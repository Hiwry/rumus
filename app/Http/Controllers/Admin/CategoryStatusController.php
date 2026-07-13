<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class CategoryStatusController extends Controller
{
    public function index()
    {
        $categoriesString = SiteSetting::get('product_categories', 'sublimacao,serigrafia,dtf,ecobag');
        $categories = array_filter(array_map('trim', explode(',', $categoriesString)));

        $statusesString = SiteSetting::get('order_statuses', 'pending:Aguardando,confirmed:Confirmado,in_production:Em Produção,shipped:Enviado,delivered:Entregue,cancelled:Cancelado');
        $statuses = [];
        if (!empty($statusesString)) {
            foreach (explode(',', $statusesString) as $item) {
                $parts = explode(':', $item, 2);
                if (count($parts) === 2) {
                    $statuses[trim($parts[0])] = trim($parts[1]);
                }
            }
        }

        return view('admin.categories.index', compact('categories', 'statuses'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'required|string|min:1',
            'statuses_keys' => 'required|array',
            'statuses_labels' => 'required|array',
        ]);

        // Process categories
        $categories = array_map(function($cat) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9_.-]/', '', $cat)));
        }, $request->input('categories'));
        $categories = array_unique(array_filter($categories));
        SiteSetting::set('product_categories', implode(',', $categories));

        // Process statuses
        $keys = $request->input('statuses_keys');
        $labels = $request->input('statuses_labels');
        $statuses = [];
        for ($i = 0; $i < count($keys); $i++) {
            $key = strtolower(trim(preg_replace('/[^a-zA-Z0-9_.-]/', '', $keys[$i])));
            $label = trim($labels[$i]);
            if (!empty($key) && !empty($label)) {
                $statuses[] = "{$key}:{$label}";
            }
        }
        SiteSetting::set('order_statuses', implode(',', $statuses));

        return redirect()->route('admin.categories.index')->with('success', 'Categorias e Status atualizados com sucesso!');
    }
}
