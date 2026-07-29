<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class QuoteController extends Controller
{
    /**
     * Auto-migrate quotes table if missing on production server.
     */
    private function ensureTableExists(): void
    {
        if (!Schema::hasTable('quotes')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Ignore if already created or permission denied
            }
        }
    }

    /**
     * Display budget dashboard manager with metrics & filterable list.
     */
    public function index(Request $request)
    {
        $this->ensureTableExists();
        $query = Quote::query();

        // Search filter
        if ($request->filled('q')) {
            $searchTerm = '%' . $request->input('q') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('client_name', 'like', $searchTerm)
                  ->orWhere('quote_number', 'like', $searchTerm)
                  ->orWhere('seller_name', 'like', $searchTerm);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Period Filter
        $period = $request->input('period', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case '7days':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
            case 'custom':
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
                break;
        }

        // Calculate Metrics for current filtered scope
        $metricsQuery = clone $query;
        $totalCount = $metricsQuery->count();
        $totalSum = (float) $metricsQuery->sum('total_amount');
        $averageValue = $totalCount > 0 ? $totalSum / $totalCount : 0;

        // Paginated list
        $quotes = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.quotes.index', compact(
            'quotes',
            'totalCount',
            'totalSum',
            'averageValue',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show the quote generator form.
     */
    public function create()
    {
        $settings = SiteSetting::getAllAsArray();
        
        $defaults = [
            'quote_number'       => date('dmy') . rand(10, 99),
            'quote_date'         => date('Y-m-d'),
            'company_name'       => $settings['quote_company_name'] ?? 'CONFECÇÕES NÓBREGA LTDA - EPP',
            'company_cnpj'       => $settings['quote_company_cnpj'] ?? '07.149.307/0002-89',
            'company_ie'         => $settings['quote_company_ie'] ?? '242.15525-1',
            'company_address'    => $settings['quote_company_address'] ?? 'RUA DO IMPERADOR, 312 - CENTRO',
            'company_cep'        => $settings['quote_company_cep'] ?? '57020-030',
            'company_phone'      => $settings['quote_company_phone'] ?? '(82) 3336-7272',
            'seller_name'        => $settings['quote_seller'] ?? 'MARCELO',
            'seller_whatsapp'    => $settings['quote_whatsapp'] ?? '(82) 9 9928-0418',
            'delivery_time'      => $settings['quote_delivery_time'] ?? 'A COMBINAR',
            'validity'           => $settings['quote_validity'] ?? '15 DIAS',
            'signer_name'        => $settings['quote_signer_name'] ?? 'Fernanda R. Nóbrega',
            'signer_role'        => $settings['quote_signer_role'] ?? 'Gerente de Marketing e Vendas',
            'observations'       => $settings['quote_observations'] ?? 'Forma de pagamento: 50% de entrada e 50% na entrega, para pagamentos sem ser em cartão de crédito. Pagamento no cartão de crédito não pode ser pago 50% no inicio e 50% no final, tem que ser pago o valor total na entrada do pedido. Isso é apenas o orçamento, no fechamento do pedido pode não ter o tecido e a cor correspondente, verificar a disponibilidade antes de fechar.',
            'quote_logo'         => $settings['quote_logo'] ?? ($settings['site_logo'] ?? ''),
            'quote_stamp'        => $settings['quote_stamp'] ?? '',
            'quote_signature'    => $settings['quote_signature'] ?? '',
        ];

        return view('admin.quotes.create', compact('defaults'));
    }

    /**
     * Store new quote in database & display print view.
     */
    public function store(Request $request)
    {
        $this->ensureTableExists();
        $data = $request->validate([
            'quote_number'    => 'required|string',
            'quote_date'      => 'nullable|string',
            'validity'        => 'nullable|string',
            'client_name'     => 'nullable|string',
            'client_address'  => 'nullable|string',
            'client_contact'  => 'nullable|string',
            'client_email'    => 'nullable|string',
            'referent'        => 'nullable|string',
            'seller_name'     => 'nullable|string',
            'seller_whatsapp' => 'nullable|string',
            'delivery_time'   => 'nullable|string',
            'observations'    => 'nullable|string',
            'company_name'    => 'nullable|string',
            'company_cnpj'    => 'nullable|string',
            'company_ie'      => 'nullable|string',
            'company_address' => 'nullable|string',
            'company_phone'   => 'nullable|string',
            'signer_name'     => 'nullable|string',
            'signer_role'     => 'nullable|string',
            'items'           => 'nullable|array',
            'items.*.quantity'    => 'nullable',
            'items.*.description' => 'nullable|string',
            'items.*.unit_price'  => 'nullable',
        ]);

        // Process items calculations
        $processedItems = [];
        $grandTotal = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $rawQty = trim($item['quantity'] ?? '1');
                $qty = (float) str_replace(',', '.', $rawQty);
                
                $unitPriceStr = preg_replace('/[^\d.,]/', '', $item['unit_price'] ?? '0');
                if (strpos($unitPriceStr, ',') !== false && strpos($unitPriceStr, '.') !== false) {
                    $unitPriceStr = str_replace('.', '', $unitPriceStr);
                    $unitPriceStr = str_replace(',', '.', $unitPriceStr);
                } else {
                    $unitPriceStr = str_replace(',', '.', $unitPriceStr);
                }
                $unitPrice = (float) $unitPriceStr;
                $totalPrice = $qty * $unitPrice;
                $grandTotal += $totalPrice;

                $desc = trim($item['description'] ?? '');

                if ($desc !== '' || $qty > 0 || $unitPrice > 0) {
                    $formattedQty = $rawQty !== '' ? $rawQty : ($qty > 0 ? (floor($qty) == $qty ? (int)$qty : number_format($qty, 2, ',', '.')) : '1');
                    $processedItems[] = [
                        'quantity'    => $formattedQty,
                        'description' => $desc,
                        'unit_price'  => $unitPrice > 0 ? 'R$ ' . number_format($unitPrice, 2, ',', '.') : ($item['unit_price'] ?? 'R$ 0,00'),
                        'total_price' => $totalPrice > 0 ? 'R$ ' . number_format($totalPrice, 2, ',', '.') : 'R$ 0,00',
                    ];
                }
            }
        }

        // Save Quote to Database
        $quote = Quote::create([
            'quote_number'    => $data['quote_number'],
            'quote_date'      => !empty($data['quote_date']) ? $data['quote_date'] : date('Y-m-d'),
            'client_name'     => $data['client_name'] ?? 'Cliente',
            'client_contact'  => $data['client_contact'] ?? '',
            'client_email'    => $data['client_email'] ?? '',
            'client_address'  => $data['client_address'] ?? '',
            'referent'        => $data['referent'] ?? 'ORÇAMENTO',
            'seller_name'     => $data['seller_name'] ?? '',
            'seller_whatsapp' => $data['seller_whatsapp'] ?? '',
            'delivery_time'   => $data['delivery_time'] ?? '',
            'validity'        => $data['validity'] ?? '',
            'observations'    => $data['observations'] ?? '',
            'total_amount'    => $grandTotal,
            'items'           => $processedItems,
            'company_name'    => $data['company_name'] ?? '',
            'company_cnpj'    => $data['company_cnpj'] ?? '',
            'company_ie'      => $data['company_ie'] ?? '',
            'company_address' => $data['company_address'] ?? '',
            'company_phone'   => $data['company_phone'] ?? '',
            'signer_name'     => $data['signer_name'] ?? '',
            'signer_role'     => $data['signer_role'] ?? '',
            'status'          => 'pending',
        ]);

        return $this->renderPrintView($quote, $request);
    }

    /**
     * Show edit form for existing quote.
     */
    public function edit(Quote $quote)
    {
        $settings = SiteSetting::getAllAsArray();
        
        $defaults = [
            'quote_number'       => $quote->quote_number,
            'quote_date'         => $quote->quote_date ? $quote->quote_date->format('Y-m-d') : date('Y-m-d'),
            'company_name'       => $quote->company_name ?: ($settings['quote_company_name'] ?? ''),
            'company_cnpj'       => $quote->company_cnpj ?: ($settings['quote_company_cnpj'] ?? ''),
            'company_ie'         => $quote->company_ie ?: ($settings['quote_company_ie'] ?? ''),
            'company_address'    => $quote->company_address ?: ($settings['quote_company_address'] ?? ''),
            'company_cep'        => $settings['quote_company_cep'] ?? '',
            'company_phone'      => $quote->company_phone ?: ($settings['quote_company_phone'] ?? ''),
            'seller_name'        => $quote->seller_name ?: ($settings['quote_seller'] ?? ''),
            'seller_whatsapp'    => $quote->seller_whatsapp ?: ($settings['quote_whatsapp'] ?? ''),
            'delivery_time'      => $quote->delivery_time ?: ($settings['quote_delivery_time'] ?? ''),
            'validity'           => $quote->validity ?: ($settings['quote_validity'] ?? ''),
            'signer_name'        => $quote->signer_name ?: ($settings['quote_signer_name'] ?? ''),
            'signer_role'        => $quote->signer_role ?: ($settings['quote_signer_role'] ?? ''),
            'observations'       => $quote->observations ?: ($settings['quote_observations'] ?? ''),
            'quote_logo'         => $settings['quote_logo'] ?? ($settings['site_logo'] ?? ''),
            'quote_stamp'        => $settings['quote_stamp'] ?? '',
            'quote_signature'    => $settings['quote_signature'] ?? '',
        ];

        return view('admin.quotes.edit', compact('quote', 'defaults'));
    }

    /**
     * Update existing quote in database.
     */
    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'quote_number'    => 'required|string',
            'quote_date'      => 'nullable|string',
            'validity'        => 'nullable|string',
            'client_name'     => 'nullable|string',
            'client_address'  => 'nullable|string',
            'client_contact'  => 'nullable|string',
            'client_email'    => 'nullable|string',
            'referent'        => 'nullable|string',
            'seller_name'     => 'nullable|string',
            'seller_whatsapp' => 'nullable|string',
            'delivery_time'   => 'nullable|string',
            'observations'    => 'nullable|string',
            'company_name'    => 'nullable|string',
            'company_cnpj'    => 'nullable|string',
            'company_ie'      => 'nullable|string',
            'company_address' => 'nullable|string',
            'company_phone'   => 'nullable|string',
            'signer_name'     => 'nullable|string',
            'signer_role'     => 'nullable|string',
            'status'          => 'nullable|string',
            'items'           => 'nullable|array',
            'items.*.quantity'    => 'nullable',
            'items.*.description' => 'nullable|string',
            'items.*.unit_price'  => 'nullable',
        ]);

        $processedItems = [];
        $grandTotal = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $rawQty = trim($item['quantity'] ?? '1');
                $qty = (float) str_replace(',', '.', $rawQty);
                
                $unitPriceStr = preg_replace('/[^\d.,]/', '', $item['unit_price'] ?? '0');
                if (strpos($unitPriceStr, ',') !== false && strpos($unitPriceStr, '.') !== false) {
                    $unitPriceStr = str_replace('.', '', $unitPriceStr);
                    $unitPriceStr = str_replace(',', '.', $unitPriceStr);
                } else {
                    $unitPriceStr = str_replace(',', '.', $unitPriceStr);
                }
                $unitPrice = (float) $unitPriceStr;
                $totalPrice = $qty * $unitPrice;
                $grandTotal += $totalPrice;

                $desc = trim($item['description'] ?? '');

                if ($desc !== '' || $qty > 0 || $unitPrice > 0) {
                    $formattedQty = $rawQty !== '' ? $rawQty : ($qty > 0 ? (floor($qty) == $qty ? (int)$qty : number_format($qty, 2, ',', '.')) : '1');
                    $processedItems[] = [
                        'quantity'    => $formattedQty,
                        'description' => $desc,
                        'unit_price'  => $unitPrice > 0 ? 'R$ ' . number_format($unitPrice, 2, ',', '.') : ($item['unit_price'] ?? 'R$ 0,00'),
                        'total_price' => $totalPrice > 0 ? 'R$ ' . number_format($totalPrice, 2, ',', '.') : 'R$ 0,00',
                    ];
                }
            }
        }

        $quote->update([
            'quote_number'    => $data['quote_number'],
            'quote_date'      => !empty($data['quote_date']) ? $data['quote_date'] : $quote->quote_date,
            'client_name'     => $data['client_name'] ?? $quote->client_name,
            'client_contact'  => $data['client_contact'] ?? $quote->client_contact,
            'client_email'    => $data['client_email'] ?? $quote->client_email,
            'client_address'  => $data['client_address'] ?? $quote->client_address,
            'referent'        => $data['referent'] ?? $quote->referent,
            'seller_name'     => $data['seller_name'] ?? $quote->seller_name,
            'seller_whatsapp' => $data['seller_whatsapp'] ?? $quote->seller_whatsapp,
            'delivery_time'   => $data['delivery_time'] ?? $quote->delivery_time,
            'validity'        => $data['validity'] ?? $quote->validity,
            'observations'    => $data['observations'] ?? $quote->observations,
            'total_amount'    => $grandTotal,
            'items'           => $processedItems,
            'company_name'    => $data['company_name'] ?? $quote->company_name,
            'company_cnpj'    => $data['company_cnpj'] ?? $quote->company_cnpj,
            'company_ie'      => $data['company_ie'] ?? $quote->company_ie,
            'company_address' => $data['company_address'] ?? $quote->company_address,
            'company_phone'   => $data['company_phone'] ?? $quote->company_phone,
            'signer_name'     => $data['signer_name'] ?? $quote->signer_name,
            'signer_role'     => $data['signer_role'] ?? $quote->signer_role,
            'status'          => $data['status'] ?? $quote->status,
        ]);

        return redirect()->route('admin.quotes.index')->with('success', 'Orçamento atualizado com sucesso!');
    }

    /**
     * Update status via AJAX / quick action.
     */
    public function updateStatus(Request $request, Quote $quote)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $quote->update(['status' => $request->input('status')]);
        return back()->with('success', 'Status do orçamento atualizado!');
    }

    /**
     * Delete a quote.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();
        return back()->with('success', 'Orçamento excluído com sucesso!');
    }

    /**
     * Render the print-ready budget document for a saved quote.
     */
    public function print(Quote $quote, Request $request)
    {
        return $this->renderPrintView($quote, $request);
    }

    /**
     * Helper to render print/PDF template for a quote.
     */
    private function renderPrintView(Quote $quote, Request $request)
    {
        $settings = SiteSetting::getAllAsArray();
        $images = [
            'logo'      => $settings['quote_logo'] ?? ($settings['site_logo'] ?? ''),
            'stamp'     => $settings['quote_stamp'] ?? '',
            'signature' => $settings['quote_signature'] ?? '',
        ];

        foreach (['logo' => 'custom_logo', 'stamp' => 'custom_stamp', 'signature' => 'custom_signature'] as $key => $input) {
            if ($request->hasFile($input)) {
                $file = $request->file($input);
                $filename = 'temp_' . $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/uploads'), $filename);
                $images[$key] = 'images/uploads/' . $filename;
            }
        }

        $items = $quote->items ?? [];
        $minRows = 7;
        $totalItemsCount = count($items);
        for ($i = $totalItemsCount; $i < $minRows; $i++) {
            $items[] = [
                'quantity'    => '',
                'description' => '',
                'unit_price'  => '',
                'total_price' => '',
            ];
        }

        $formattedGrandTotal = $quote->formatted_total;
        $dateFormatted = $quote->quote_date ? Carbon::parse($quote->quote_date)->locale('pt_BR')->translatedFormat('l, d \d\e F \d\e Y') : Carbon::now()->locale('pt_BR')->translatedFormat('l, d \d\e F \d\e Y');

        $data = [
            'quote_number'    => $quote->quote_number,
            'quote_date'      => $quote->quote_date ? $quote->quote_date->format('Y-m-d') : '',
            'client_name'     => $quote->client_name,
            'client_address'  => $quote->client_address,
            'client_contact'  => $quote->client_contact,
            'client_email'    => $quote->client_email,
            'referent'        => $quote->referent,
            'seller_name'     => $quote->seller_name,
            'seller_whatsapp' => $quote->seller_whatsapp,
            'delivery_time'   => $quote->delivery_time,
            'validity'        => $quote->validity,
            'observations'    => $quote->observations,
            'company_name'    => $quote->company_name,
            'company_cnpj'    => $quote->company_cnpj,
            'company_ie'      => $quote->company_ie,
            'company_address' => $quote->company_address,
            'company_phone'   => $quote->company_phone,
            'signer_name'     => $quote->signer_name,
            'signer_role'     => $quote->signer_role,
        ];

        return view('admin.quotes.print', compact('data', 'items', 'images', 'formattedGrandTotal', 'dateFormatted', 'quote'));
    }
}
