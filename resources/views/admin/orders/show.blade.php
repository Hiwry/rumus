@extends('admin.layouts.app')
@section('title', 'Pedido ' . $order->order_number)
@section('page-title', 'Pedido ' . $order->order_number)

@section('topbar-actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm btn btn-outline btn-sm">← Voltar</a>
@endsection

@section('content')
<div class="grid grid-2" style="gap:24px; align-items:start; max-width:900px;">
    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span class="card-title">Cliente</span>
            </div>
            <div class="card-body">
                <div style="font-size:20px; font-weight:700; margin-bottom:8px;">{{ $order->customer_name }}</div>
                @if($order->customer_phone)
                    <div style="font-size:14px; color:var(--text-muted); display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        {{ $order->customer_phone }}
                    </div>
                @endif
                @if($order->customer_email)
                    <div style="font-size:14px; color:var(--text-muted); display:flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        {{ $order->customer_email }}
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"></path><polyline points="3 21 21 21"></polyline><line x1="12" y1="6" x2="12" y2="18"></line></svg>
                <span class="card-title">Produto</span>
            </div>
            <div class="card-body">
                <div style="font-size:16px; font-weight:600; margin-bottom:12px;">{{ $order->product_name }}</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    @if($order->size)
                        <div><div style="font-size:11px; color:var(--text-muted);">TAMANHO</div><div style="font-weight:600;">{{ $order->size }}</div></div>
                    @endif
                    @if($order->color)
                        <div><div style="font-size:11px; color:var(--text-muted);">COR</div><div style="font-weight:600;">{{ $order->color }}</div></div>
                    @endif
                    <div><div style="font-size:11px; color:var(--text-muted);">QUANTIDADE</div><div style="font-weight:600;">{{ $order->quantity }}x</div></div>
                    <div><div style="font-size:11px; color:var(--text-muted);">PREÇO UNIT.</div><div style="font-weight:600;">R$ {{ number_format($order->unit_price, 2, ',', '.') }}</div></div>
                </div>
                <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:14px; color:var(--text-muted);">Total do Pedido</span>
                    <span style="font-size:24px; font-weight:800; color:#86efac;">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>
                <span class="card-title">Observações</span>
            </div>
            <div class="card-body">
                <p style="font-size:14px; color:var(--text-muted); line-height:1.6;">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                <span class="card-title">Status do Pedido</span>
            </div>
            <div class="card-body">
                <div style="margin-bottom:16px;">
                    <span class="status-badge status-{{ $order->status_color }}" style="font-size:14px; padding:8px 16px;">
                        {{ $order->status_label }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Atualizar Status</label>
                        <select name="status" class="form-control">
                            @foreach($statuses as $v => $l)
                                <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">Atualizar Status</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span class="card-title">Informações</span>
            </div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted);">Número do Pedido</span>
                        <span style="font-weight:700; color:var(--brand-light);">{{ $order->order_number }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted);">Criado em</span>
                        <span>{{ $order->created_at->format('d/m/Y \à\s H:i') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-muted);">Última atualização</span>
                        <span>{{ $order->updated_at->format('d/m/Y \à\s H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Excluir este pedido permanentemente?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                Excluir Pedido
            </button>
        </form>
    </div>
</div>
@endsection
