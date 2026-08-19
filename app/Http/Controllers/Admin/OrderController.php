<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('customer_name', 'like', "%{$s}%")
                  ->orWhere('order_number', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuses = $this->getStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        $statuses = $this->getStatuses();
        return view('admin.orders.create', compact('products', 'statuses'));
    }

    public function store(Request $request)
    {
        $statuses = $this->getStatuses();
        $allowedStatusesCsv = implode(',', array_keys($statuses));

        $validated = $request->validate([
            'product_id'    => 'nullable|exists:products,id',
            'product_name'  => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_phone'=> 'nullable|string|max:20',
            'customer_email'=> 'nullable|email|max:255',
            'size'          => 'nullable|string|max:10',
            'color'         => 'nullable|string|max:30',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|numeric|min:0',
            'status'        => 'required|in:' . $allowedStatusesCsv,
            'notes'         => 'nullable|string',
        ]);

        $validated['order_number'] = Order::generateOrderNumber();
        $validated['total_price']  = $validated['unit_price'] * $validated['quantity'];

        Order::create($validated);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pedido criado com sucesso!');
    }

    public function show(Order $order)
    {
        $order->load('product');
        $statuses = $this->getStatuses();
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $statuses = $this->getStatuses();
        $allowedStatusesCsv = implode(',', array_keys($statuses));

        $request->validate(['status' => 'required|in:' . $allowedStatusesCsv]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status do pedido atualizado!');
    }

    private function getStatuses(): array
    {
        $statusesString = \App\Models\SiteSetting::get('order_statuses', 'pending:Aguardando,confirmed:Confirmado,in_production:Em Produção,shipped:Enviado,delivered:Entregue,cancelled:Cancelado');
        $statuses = [];
        if (!empty($statusesString)) {
            foreach (explode(',', $statusesString) as $item) {
                $parts = explode(':', $item, 2);
                if (count($parts) === 2) {
                    $statuses[trim($parts[0])] = trim($parts[1]);
                }
            }
        }
        return $statuses;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pedido excluído com sucesso!');
    }

    public function print(Order $order)
    {
        $order->load('product');
        $quote = Quote::where('converted_to_order_id', $order->id)->first();
        
        $settings = \App\Models\SiteSetting::getAllAsArray();
        $images = [
            'logo'      => $settings['quote_logo'] ?? ($settings['site_logo'] ?? ''),
            'stamp'     => $settings['quote_stamp'] ?? '',
            'signature' => $settings['quote_signature'] ?? '',
        ];

        return view('admin.orders.print', compact('order', 'quote', 'images', 'settings'));
    }
}
