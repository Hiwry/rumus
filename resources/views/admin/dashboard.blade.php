@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Novo Produto</a>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-outline btn-sm">+ Novo Pedido</a>
@endsection

@push('styles')
<style>
.gauge-ring { width: 110px; height: 110px; position: relative; margin: 0 auto 0.75rem; }
.gauge-ring svg { transform: rotate(-90deg); }
.gauge-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: var(--font-title); font-weight: 800; font-size: 1.35rem; color: var(--text-main); }
.gauge-center small { font-size: 0.65rem; font-weight: 500; color: var(--text-muted); }

.bar-chart { display: flex; align-items: flex-end; gap: 4px; height: 72px; }
.bar-item { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; height: 100%; justify-content: flex-end; }
.bar-fill { width: 100%; border-radius: 2px 2px 0 0; background: #000; min-height: 3px; }
.bar-label { font-size: 9px; color: var(--text-light); font-family: var(--font-title); font-weight: 600; }

.top-product-row { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border); }
.top-product-row:last-child { border-bottom: none; padding-bottom: 0; }
.rank-num { font-family: var(--font-title); font-size: 0.72rem; font-weight: 800; width: 20px; text-align: center; flex-shrink: 0; }
.rank-1 { color: #92400e; }
.rank-2 { color: #374151; }
.rank-3 { color: #7c3aed; opacity:0.7; }
.rank-other { color: var(--text-light); }
.top-product-name { flex: 1; font-size: 0.8rem; font-weight: 600; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.top-product-cat { font-size: 0.68rem; color: var(--text-muted); }
.top-product-views { font-family: var(--font-title); font-size: 0.8rem; font-weight: 700; color: var(--text-muted); flex-shrink: 0; }

.type-row { display: flex; align-items: center; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid var(--border); }
.type-row:last-child { border-bottom: none; }
.type-label { font-family: var(--font-title); font-size: 0.72rem; font-weight: 600; min-width: 72px; color: var(--text-main); text-transform: capitalize; }
.type-track { flex: 1; height: 5px; background: var(--bg-mid); border-radius: 2px; overflow: hidden; }
.type-fill { height: 100%; background: #000; border-radius: 2px; }
.type-count { font-family: var(--font-title); font-size: 0.72rem; font-weight: 700; color: var(--text-muted); min-width: 32px; text-align: right; }

.temp-label-warm { color: #dc2626; }
.temp-label-cool { color: #2563eb; }
.temp-label-flat { color: var(--text-muted); }
</style>
@endpush

@section('content')

{{-- ── SECTION LABEL ──────────────────────────────────────────────────────────── --}}
<div class="section-divider"><span>Métricas Gerais</span></div>

{{-- ── STAT CARDS ──────────────────────────────────────────────────────────────── --}}
<div class="grid grid-4" style="margin-bottom: 1.5rem;">

    <div class="stat-card">
        <div class="stat-card-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Produtos
        </div>
        <div class="stat-card-value">{{ $totalProducts }}</div>
        <div class="stat-card-sub">{{ $activeProducts }} ativos no catálogo</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Pedidos
        </div>
        <div class="stat-card-value">{{ $totalOrders }}</div>
        <div class="stat-card-sub">
            <span class="{{ $ordersToday > 0 ? 'stat-trend-up' : '' }}">{{ $ordersToday }} hoje</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Receita Total
        </div>
        <div class="stat-card-value" style="font-size:1.4rem;">R$ {{ number_format($revenueTotal, 0, ',', '.') }}</div>
        <div class="stat-card-sub">R$ {{ number_format($revenueThisMonth, 0, ',', '.') }} este mês</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-label">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            Acessos
        </div>
        <div class="stat-card-value">{{ number_format($viewsTotal) }}</div>
        <div class="stat-card-sub">{{ $viewsToday }} hoje · {{ $viewsThisWeek }} esta semana</div>
    </div>

</div>

{{-- ── ROW 2 ───────────────────────────────────────────────────────────────────── --}}
<div class="section-divider"><span>Análise de Tráfego</span></div>

<div class="grid grid-3" style="margin-bottom: 1.5rem;">

    {{-- Temperatura --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
            <span class="card-title">Temperatura do Site</span>
        </div>
        <div class="card-body" style="text-align: center;">
            @php
                $tempPct = min(100, max(0, 50 + $tempTrend));
                $circumference = 2 * 3.14159 * 48;
                $dash = ($tempPct / 100) * $circumference;
                $tempColor = $tempPct >= 70 ? '#dc2626' : ($tempPct >= 40 ? '#d97706' : '#2563eb');
            @endphp

            <div class="gauge-ring">
                <svg viewBox="0 0 110 110" width="110" height="110">
                    <circle cx="55" cy="55" r="48" fill="none" stroke="#f1f3f5" stroke-width="8"/>
                    <circle cx="55" cy="55" r="48" fill="none"
                        stroke="{{ $tempColor }}"
                        stroke-width="8"
                        stroke-dasharray="{{ $dash }} {{ $circumference }}"
                        stroke-linecap="round"/>
                </svg>
                <div class="gauge-center" style="color: {{ $tempColor }};">
                    {{ $tempPct }}%
                    <small>intensidade</small>
                </div>
            </div>

            <div style="margin-bottom: 0.75rem;">
                @if($tempTrend > 0)
                    <span class="temp-label-warm" style="font-family:var(--font-title); font-size:0.82rem; font-weight:700;">Alta atividade +{{ $tempTrend }}%</span>
                @elseif($tempTrend < 0)
                    <span class="temp-label-cool" style="font-family:var(--font-title); font-size:0.82rem; font-weight:700;">Baixa atividade {{ $tempTrend }}%</span>
                @else
                    <span class="temp-label-flat" style="font-family:var(--font-title); font-size:0.82rem; font-weight:700;">Tráfego estável</span>
                @endif
                <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem;">{{ $viewsLast24h }} acessos nas últimas 24h</div>
            </div>

            {{-- Hourly bars --}}
            <div style="border-top: 1px solid var(--border); padding-top: 1rem;">
                <div style="font-family:var(--font-title); font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-light); margin-bottom:0.5rem; text-align:left;">Acessos por hora (hoje)</div>
                <div class="bar-chart">
                    @php $maxH = collect(range(6,23))->map(fn($h) => $hourlyViews->get($h)?->count ?? 0)->max() ?: 1; @endphp
                    @foreach(range(6, 23) as $h)
                        @php $count = $hourlyViews->get($h)?->count ?? 0; @endphp
                        <div class="bar-item">
                            <div class="bar-fill" style="height:{{ round(($count/$maxH)*60) }}px; opacity: {{ $count > 0 ? 1 : 0.15 }};"></div>
                            @if($h % 4 === 0)
                                <div class="bar-label">{{ str_pad($h,2,'0',STR_PAD_LEFT) }}h</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Top produtos --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span class="card-title">Produtos Mais Acessados</span>
        </div>
        <div class="card-body" style="padding: 1rem 1.5rem;">
            @forelse($topProducts as $i => $prod)
                <div class="top-product-row">
                    <div class="rank-num {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-other')) }}">
                        {{ $i + 1 }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div class="top-product-name">{{ $prod->name }}</div>
                        <div class="top-product-cat">{{ ucfirst($prod->category) }}</div>
                    </div>
                    <div class="top-product-views">{{ number_format($prod->page_views_count) }}</div>
                </div>
            @empty
                <div style="text-align:center; padding: 1.5rem 0; color: var(--text-muted); font-size: 0.82rem;">
                    Nenhum acesso rastreado ainda.<br>
                    <span style="font-size:0.72rem;">Os dados aparecem conforme o site é visitado.</span>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Acessos por seção --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span class="card-title">Acessos por Seção</span>
        </div>
        <div class="card-body" style="padding: 1rem 1.5rem;">
            @php
                $typeLabels = ['home'=>'Início','catalog'=>'Catálogo','product'=>'Produtos','other'=>'Outros'];
                $totalV = $viewsByType->sum('count') ?: 1;
            @endphp
            @forelse($viewsByType as $v)
                <div class="type-row">
                    <div class="type-label">{{ $typeLabels[$v->page_type] ?? $v->page_type }}</div>
                    <div class="type-track">
                        <div class="type-fill" style="width:{{ round(($v->count/$totalV)*100) }}%"></div>
                    </div>
                    <div class="type-count">{{ number_format($v->count) }}</div>
                </div>
            @empty
                <div style="text-align:center; padding:1.5rem 0; color:var(--text-muted); font-size:0.82rem;">Sem dados ainda.</div>
            @endforelse

            {{-- Last 7 days bar --}}
            <div style="margin-top:1.25rem; border-top:1px solid var(--border); padding-top:1rem;">
                <div style="font-family:var(--font-title); font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--text-light); margin-bottom:0.5rem;">Últimos 7 dias</div>
                <div class="bar-chart" style="height:60px;">
                    @php $maxD = $dailyViews->max('count') ?: 1; @endphp
                    @foreach($dailyViews as $dv)
                        <div class="bar-item">
                            <div class="bar-fill" style="height:{{ round(($dv->count/$maxD)*52) }}px;"></div>
                            <div class="bar-label">{{ date('d', strtotime($dv->date)) }}/{{ date('m', strtotime($dv->date)) }}</div>
                        </div>
                    @endforeach
                    @if($dailyViews->isEmpty())
                        <div style="width:100%; text-align:center; color:var(--text-light); font-size:0.72rem; padding-top:1rem;">Sem dados</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 3 ───────────────────────────────────────────────────────────────────── --}}
<div class="section-divider"><span>Pedidos</span></div>

<div class="grid grid-2">

    {{-- Recent orders --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span class="card-title">Pedidos Recentes</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-xs">Ver todos</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><span style="font-family:var(--font-title); font-size:0.72rem; font-weight:700;">{{ $order->order_number }}</span></td>
                            <td>{{ $order->customer_name }}</td>
                            <td><span style="font-family:var(--font-title); font-weight:700;">{{ $order->formatted_total }}</span></td>
                            <td>
                                @php
                                    $statusBadge = [
                                        'pending'       => 'badge-warning',
                                        'confirmed'     => 'badge-info',
                                        'in_production' => 'badge-dark',
                                        'shipped'       => 'badge-gray',
                                        'delivered'     => 'badge-success',
                                        'cancelled'     => 'badge-danger',
                                    ][$order->status] ?? 'badge-gray';
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ $order->status_label }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center; padding:2rem; color:var(--text-muted); font-size:0.82rem;">Nenhum pedido registrado ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Orders by status --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="card-title">Status dos Pedidos</span>
        </div>
        <div class="card-body">
            @php
                $statusDef = [
                    'pending'       => ['Aguardando',   '#d97706'],
                    'confirmed'     => ['Confirmado',    '#0284c7'],
                    'in_production' => ['Em Produção',   '#111111'],
                    'shipped'       => ['Enviado',       '#6b7280'],
                    'delivered'     => ['Entregue',      '#16a34a'],
                    'cancelled'     => ['Cancelado',     '#dc2626'],
                ];
                $totalOrd = $ordersByStatus->sum('count') ?: 1;
            @endphp

            <div style="display: flex; flex-direction: column; gap: 0.1rem;">
                @foreach($statusDef as $key => [$lbl, $color])
                    @php $row = $ordersByStatus->firstWhere('status', $key); $cnt = $row ? $row->count : 0; @endphp
                    <div style="display:flex; align-items:center; gap:0.75rem; padding:0.65rem 0; border-bottom:1px solid var(--border);">
                        <div style="width:8px; height:8px; border-radius:2px; background:{{ $color }}; flex-shrink:0;"></div>
                        <div style="flex:1; font-size:0.8rem; color:var(--text-main); font-family:var(--font-title); font-weight:500;">{{ $lbl }}</div>
                        <div style="flex:2;">
                            <div style="height:4px; background:var(--bg-mid); border-radius:2px; overflow:hidden;">
                                <div style="height:100%; width:{{ round(($cnt/$totalOrd)*100) }}%; background:{{ $color }};"></div>
                            </div>
                        </div>
                        <div style="font-family:var(--font-title); font-size:0.78rem; font-weight:700; color:{{ $color }}; min-width:20px; text-align:right;">{{ $cnt }}</div>
                    </div>
                @endforeach
            </div>

            @if($totalOrders === 0)
                <div style="text-align:center; padding:1.5rem 0;">
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">+ Criar primeiro pedido</a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
