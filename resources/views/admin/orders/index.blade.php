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
                <div class="search-input-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, pedido, telefone..." value="{{ request('search') }}">
                </div>
                <select name="status" class="form-control" style="width:180px;">
                    <option value="">Todos os status</option>
                    @foreach(['pending'=>'Aguardando','confirmed'=>'Confirmado','in_production'=>'Em Produção','shipped'=>'Enviado','delivered'=>'Entregue','cancelled'=>'Cancelado'] as $v => $l)
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
    <div class="table-wrap">
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
                        <td>
                            <span style="font-size:12px; font-weight:700; color:var(--brand-light);">{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <div style="font-weight:500;">{{ $order->customer_name }}</div>
                            @if($order->customer_phone)
                                <div style="font-size:11px; color:var(--text-muted);">📱 {{ $order->customer_phone }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:13px;">{{ $order->product_name }}</div>
                            @if($order->size || $order->color)
                                <div style="font-size:11px; color:var(--text-muted);">
                                    {{ $order->size ? 'Tam: '.$order->size : '' }}{{ $order->size && $order->color ? ' · ' : '' }}{{ $order->color ? 'Cor: '.$order->color : '' }}
                                </div>
                            @endif
                        </td>
                        <td style="font-weight:600;">{{ $order->quantity }}</td>
                        <td style="font-weight:700; color:#86efac;">{{ $order->formatted_total }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                                @csrf @method('PATCH')
                                <select name="status" class="form-control" style="width:150px; padding:5px 8px; font-size:12px;" onchange="this.form.submit()">
                                    @foreach(['pending'=>'Aguardando','confirmed'=>'Confirmado','in_production'=>'Em Produção','shipped'=>'Enviado','delivered'=>'Entregue','cancelled'=>'Cancelado'] as $v => $l)
                                        <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
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
                            <div style="font-size:36px; margin-bottom:12px;">📋</div>
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
