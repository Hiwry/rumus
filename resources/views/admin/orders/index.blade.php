@extends('admin.layouts.app')
@section('title', 'Pedidos')
@section('page-title', 'Pedidos')

@section('topbar-actions')
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">+ Novo Pedido</a>
@endsection

@section('content')
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 20px;">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="search-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, pedido, telefone..." value="{{ request('search') }}">
                </div>
                <select name="status" class="form-control" style="width:180px;">
                    <option value="">Todos os status</option>
                    @foreach($statuses as $v => $l)
                        <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">Limpar</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap responsive-table">
        <table>
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th style="width:140px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td data-label="Pedido">
                            <span style="font-size:12px; font-weight:700; color:var(--brand-light);">{{ $order->order_number }}</span>
                        </td>
                        <td data-label="Cliente">
                            <div style="font-weight:500;">{{ $order->customer_name }}</div>
                            @if($order->customer_phone)
                                <div style="font-size:11px; color:var(--text-muted); display:flex; align-items:center; gap:4px; margin-top:2px;">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    {{ $order->customer_phone }}
                                </div>
                            @endif
                        </td>
                        <td data-label="Produto">
                            <div style="font-size:13px;">{{ $order->product_name }}</div>
                            @if($order->size || $order->color)
                                <div style="font-size:11px; color:var(--text-muted);">
                                    {{ $order->size ? 'Tam: '.$order->size : '' }}{{ $order->size && $order->color ? ' · ' : '' }}{{ $order->color ? 'Cor: '.$order->color : '' }}
                                </div>
                            @endif
                        </td>
                        <td data-label="Qtd" style="font-weight:600;">{{ $order->quantity }}</td>
                        <td data-label="Total" style="font-weight:700; color:#86efac;">{{ $order->formatted_total }}</td>
                        <td data-label="Status">
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                                @csrf @method('PATCH')
                                <select name="status" class="form-control" style="width:150px; padding:5px 8px; font-size:12px;" onchange="this.form.submit()">
                                    @foreach($statuses as $v => $l)
                                        <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td data-label="Data" style="font-size:12px; color:var(--text-muted);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td data-label="Ações">
                            <div style="display:flex; gap:6px;">
                                <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="btn btn-secondary btn-xs" style="display:inline-flex; align-items:center; gap:3px;" title="Ver / PDF do Pedido">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    PDF
                                </a>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-xs">Ver</a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Excluir este pedido?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger-outline btn-xs">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:var(--text-muted);">
                            <div style="color:var(--text-light); margin-bottom:12px;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin:0 auto; display:block;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div style="font-size:15px; margin-bottom:8px;">Nenhum pedido encontrado</div>
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary" style="margin-top:8px;">+ Criar primeiro pedido</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            {{ $orders->withQueryString()->links('admin.pagination') }}
        </div>
    @endif
</div>
@endsection
