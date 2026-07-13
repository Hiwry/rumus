<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->withCount('pageViews')
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        $categoriesString = \App\Models\SiteSetting::get('product_categories', 'sublimacao,serigrafia,dtf,ecobag');
        $categories = array_filter(array_map('trim', explode(',', $categoriesString)));

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categoriesString = \App\Models\SiteSetting::get('product_categories', 'sublimacao,serigrafia,dtf,ecobag');
        $categories = array_filter(array_map('trim', explode(',', $categoriesString)));
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $validated = $this->processProductData($request, $validated);

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $categoriesString = \App\Models\SiteSetting::get('product_categories', 'sublimacao,serigrafia,dtf,ecobag');
        $categories = array_filter(array_map('trim', explode(',', $categoriesString)));
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);
        $validated = $this->processProductData($request, $validated, $product);

        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Produto excluído com sucesso!');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        $msg = $product->is_active ? 'ativado' : 'desativado';
        return back()->with('success', "Produto {$msg} com sucesso!");
    }

    // ── Helpers ─────────────────────────────────────────────────────────────
    
    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        $categoriesString = \App\Models\SiteSetting::get('product_categories', 'sublimacao,serigrafia,dtf,ecobag');
        $allowedCategories = array_filter(array_map('trim', explode(',', $categoriesString)));
        $allowedCategoriesCsv = implode(',', $allowedCategories);

        return $request->validate([
            'name'          => 'required|string|max:255',
            'slug'          => 'required|string|unique:products,slug,' . $ignoreId . '|max:255',
            'price'         => 'required|numeric|min:0',
            'tag'           => 'nullable|string|max:50',
            'category'      => 'required|in:' . $allowedCategoriesCsv,
            'type'          => 'required|in:unissex,infantil,feminino,masculino',
            'description'   => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'reviews_count' => 'required|integer|min:0',
            'is_active'     => 'boolean',
            'sizes'         => 'nullable|string',
            'colors'        => 'nullable|string',
            'bullets'       => 'nullable|string',
            'cares'         => 'nullable|string',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);
    }

    private function processProductData(Request $request, array $validated, ?Product $product = null): array
    {
        // Auto-generate slug from name if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Parse textarea arrays (one per line)
        $validated['sizes']   = $this->parseLines($validated['sizes'] ?? '');
        $validated['colors']  = $this->parseLines($validated['colors'] ?? '');
        $validated['bullets'] = $this->parseLines($validated['bullets'] ?? '');
        $validated['cares']   = $this->parseLines($validated['cares'] ?? '');

        // Parse specs (Key: Value per line)
        $specsRaw = $request->input('specs', '');
        $specsArr = [];
        foreach (array_filter(explode("\n", $specsRaw)) as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $specsArr[trim($parts[0])] = trim($parts[1]);
            }
        }
        $validated['specs'] = $specsArr ?: null;

        // Handle image uploads
        $existingImages = $product ? ($product->images ?? []) : [];
        if ($request->hasFile('images')) {
            $uploadedImages = [];
            foreach ($request->file('images') as $file) {
                $filename = 'products/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/products'), basename($filename));
                $uploadedImages[] = 'images/' . $filename;
            }
            $validated['images'] = array_merge($existingImages, $uploadedImages);
        } else {
            $validated['images'] = $existingImages;
        }

        // Remove images marked for deletion
        if ($request->filled('delete_images')) {
            $toDelete = $request->input('delete_images', []);
            $validated['images'] = array_values(
                array_filter($validated['images'], fn($img) => !in_array($img, $toDelete))
            );
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        return $validated;
    }

    private function parseLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", $text))));
    }
}
