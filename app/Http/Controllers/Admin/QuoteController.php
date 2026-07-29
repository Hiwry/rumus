<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
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
     * Render the print-ready budget document.
     */
    public function print(Request $request)
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
            'company_cep'     => 'nullable|string',
            'company_phone'   => 'nullable|string',
            'signer_name'     => 'nullable|string',
            'signer_role'     => 'nullable|string',
            'items'           => 'nullable|array',
            'items.*.quantity'    => 'nullable',
            'items.*.description' => 'nullable|string',
            'items.*.unit_price'  => 'nullable',
        ]);

        // Upload temp/override images if provided in request
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

        // Process items calculations
        $items = [];
        $grandTotal = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $qty = (float) str_replace(',', '.', $item['quantity'] ?? 0);
                
                // Parse price strings like "45,00" or "45.00" or "R$ 45,00"
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

                if (!empty($item['description']) || $qty > 0 || $unitPrice > 0) {
                    $items[] = [
                        'quantity'    => $qty > 0 ? (floor($qty) == $qty ? (int)$qty : number_format($qty, 2, ',', '.')) : '',
                        'description' => $item['description'] ?? '',
                        'unit_price'  => $unitPrice > 0 ? 'R$ ' . number_format($unitPrice, 2, ',', '.') : '',
                        'total_price' => $totalPrice > 0 ? 'R$ ' . number_format($totalPrice, 2, ',', '.') : 'R$ -',
                    ];
                }
            }
        }

        // Ensure minimum 14 empty visual rows if needed to fill the document nicely like physical order pad
        $minRows = 12;
        $totalItemsCount = count($items);
        for ($i = $totalItemsCount; $i < $minRows; $i++) {
            $items[] = [
                'quantity'    => '',
                'description' => '',
                'unit_price'  => '',
                'total_price' => '',
            ];
        }

        $formattedGrandTotal = 'R$ ' . number_format($grandTotal, 2, ',', '.');

        // Formatted date in Portuguese, e.g. "quarta-feira, 29 de julho de 2026"
        $dateFormatted = !empty($data['quote_date']) ? \Carbon\Carbon::parse($data['quote_date'])->locale('pt_BR')->translatedFormat('l, d \d\e F \d\e Y') : \Carbon\Carbon::now()->locale('pt_BR')->translatedFormat('l, d \d\e F \d\e Y');

        return view('admin.quotes.print', compact('data', 'items', 'images', 'grandTotal', 'formattedGrandTotal', 'dateFormatted'));
    }
}
