<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Overview metrics ────────────────────────────────────────────────
        $totalProducts   = Product::count();
        $activeProducts  = Product::where('is_active', true)->count();
        $totalOrders     = Order::count();
        $ordersToday     = Order::whereDate('created_at', today())->count();
        $revenueTotal    = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
                                 ->whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->sum('total_price');

        // ── Page views (last 30 days) ───────────────────────────────────────
        $viewsTotal    = PageView::count();
        $viewsToday    = PageView::whereDate('created_at', today())->count();
        $viewsThisWeek = PageView::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // ── Top products by views ───────────────────────────────────────────
        $topProducts = Product::withCount('pageViews')
                               ->orderBy('page_views_count', 'desc')
                               ->take(5)
                               ->get();

        // ── Daily views last 7 days ─────────────────────────────────────────
        $dailyViews = PageView::select(
                            DB::raw('DATE(created_at) as date'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->where('created_at', '>=', now()->subDays(7))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

        // ── Views by page type ──────────────────────────────────────────────
        $viewsByType = PageView::select('page_type', DB::raw('COUNT(*) as count'))
                               ->groupBy('page_type')
                               ->get();

        // ── Recent orders ───────────────────────────────────────────────────
        $recentOrders = Order::with('product')
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        // ── Orders by status ────────────────────────────────────────────────
        $ordersByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
                               ->groupBy('status')
                               ->get();

        // ── "Temperatura do site" – views last 24h vs previous 24h ─────────
        $viewsLast24h  = PageView::where('created_at', '>=', now()->subHours(24))->count();
        $viewsPrev24h  = PageView::whereBetween('created_at', [now()->subHours(48), now()->subHours(24)])->count();
        $tempTrend     = $viewsPrev24h > 0 ? round((($viewsLast24h - $viewsPrev24h) / $viewsPrev24h) * 100) : 0;

        // ── Hourly views today ──────────────────────────────────────────────
        $hourlyViews = PageView::select(
                            DB::raw('HOUR(created_at) as hour'),
                            DB::raw('COUNT(*) as count')
                        )
                        ->whereDate('created_at', today())
                        ->groupBy('hour')
                        ->orderBy('hour')
                        ->get()
                        ->keyBy('hour');

        return view('admin.dashboard', compact(
            'totalProducts', 'activeProducts',
            'totalOrders', 'ordersToday',
            'revenueTotal', 'revenueThisMonth',
            'viewsTotal', 'viewsToday', 'viewsThisWeek',
            'topProducts', 'dailyViews', 'viewsByType',
            'recentOrders', 'ordersByStatus',
            'viewsLast24h', 'viewsPrev24h', 'tempTrend', 'hourlyViews'
        ));
    }
}
