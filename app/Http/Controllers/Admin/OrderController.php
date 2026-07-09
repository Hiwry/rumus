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

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        return view('admin.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
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
            'status'        => 'required|in:pending,confirmed,in_production,shipped,delivered,cancelled',
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
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,in_production,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status do pedido atualizado!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pedido excluído com sucesso!');
    }
}
