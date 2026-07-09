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
            <div class="card-header"><span style="font-size:16px;">👤</span><span class="card-title">Cliente</span></div>
            <div class="card-body">
                <div style="font-size:20px; font-weight:700; margin-bottom:8px;">{{ $order->customer_name }}</div>
                @if($order->customer_phone)
                    <div style="font-size:14px; color:var(--text-muted); margin-bottom:4px;">📱 {{ $order->customer_phone }}</div>
                @endif
                @if($order->customer_email)
                    <div style="font-size:14px; color:var(--text-muted);">✉️ {{ $order->customer_email }}</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span style="font-size:16px;">📦</span><span class="card-title">Produto</span></div>
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
            <div class="card-header"><span style="font-size:16px;">📝</span><span class="card-title">Observações</span></div>
            <div class="card-body">
                <p style="font-size:14px; color:var(--text-muted); line-height:1.6;">{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header"><span style="font-size:16px;">📌</span><span class="card-title">Status do Pedido</span></div>
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
                            @foreach(['pending'=>'Aguardando','confirmed'=>'Confirmado','in_production'=>'Em Produção','shipped'=>'Enviado','delivered'=>'Entregue','cancelled'=>'Cancelado'] as $v => $l)
                                <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">Atualizar Status</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span style="font-size:16px;">ℹ️</span><span class="card-title">Informações</span></div>
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
            <button type="submit" class="btn btn-danger" style="width:100%;">🗑 Excluir Pedido</button>
        </form>
    </div>
</div>
@endsection
