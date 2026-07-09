<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PageView;

class ProductController extends Controller
{
    // ── Track page view ─────────────────────────────────────────────────────
    private function trackView(Request $request, string $pageType, ?Product $product = null): void
    {
        try {
            PageView::create([
                'url'        => $request->fullUrl(),
                'page_type'  => $pageType,
                'product_id' => $product?->id,
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                'referer'    => substr($request->header('referer') ?? '', 0, 255),
            ]);

            if ($product) {
                $product->increment('views_count');
            }
        } catch (\Throwable) {
            // Never break the site due to tracking errors
        }
    }

    public function index(Request $request)
    {
        $products = Product::active()->get();

        $this->trackView($request, 'catalog');

        return view('catalog', [
            'products'     => $products,
            'instagramUrl' => config('services.instagram.url'),
            'whatsappUrl'  => config('services.whatsapp.url'),
        ]);
    }

    public function show(Request $request, $slug = null)
    {
        // Default slug
        if (!$slug) {
            $slug = 'camisa-sublimacao-full-print-exclusiva';
        }

        $product = Product::active()->where('slug', $slug)->first();

        if (!$product) {
            $product = Product::active()->where('slug', 'camisa-sublimacao-full-print-exclusiva')->first();
        }

        if (!$product) {
            $product = Product::active()->first();
        }

        if (!$product) {
            abort(404);
        }

        $related = Product::active()
                          ->where('id', '!=', $product->id)
                          ->take(4)
                          ->get();

        $this->trackView($request, 'product', $product);

        return view('product', [
            'product'      => $product,
            'related'      => $related,
            'instagramUrl' => config('services.instagram.url'),
            'whatsappUrl'  => config('services.whatsapp.url'),
        ]);
    }
}
