@extends('admin.layouts.app')
@section('title', 'Novo Pedido')
@section('page-title', 'Novo Pedido')

@section('topbar-actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm btn btn-outline btn-sm">← Voltar</a>
@endsection

@section('content')
<div style="max-width:680px; margin:0 auto;">
<form method="POST" action="{{ route('admin.orders.store') }}">
    @csrf
    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="card">
            <div class="card-header"><span style="font-size:16px;">👤</span><span class="card-title">Dados do Cliente</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Nome do Cliente *</label>
                    <input type="text" name="customer_name" class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" value="{{ old('customer_name') }}" required>
                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Telefone / WhatsApp</label>
                        <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="(82) 99999-9999">
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span style="font-size:16px;">📦</span><span class="card-title">Produto</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Produto do Catálogo</label>
                    <select name="product_id" class="form-control" id="product_select">
                        <option value="">Selecione um produto (opcional)</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}"
                                data-name="{{ $p->name }}"
                                data-price="{{ $p->price }}"
                                data-sizes="{{ implode(',', $p->sizes ?? []) }}"
                                data-colors="{{ implode(',', $p->colors ?? []) }}"
                                {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} — {{ $p->formatted_price }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Nome do Produto *</label>
                    <input type="text" name="product_name" id="product_name" class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" value="{{ old('product_name') }}" required>
                    @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="grid grid-3">
                    <div class="form-group">
                        <label class="form-label">Tamanho</label>
                        <input type="text" name="size" id="size_input" class="form-control" value="{{ old('size') }}" placeholder="M">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cor</label>
                        <input type="text" name="color" id="color_input" class="form-control" value="{{ old('color') }}" placeholder="black">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantidade *</label>
                        <input type="number" name="quantity" id="quantity" min="1" class="form-control" value="{{ old('quantity', 1) }}" required>
                    </div>
                </div>
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Preço Unitário (R$) *</label>
                        <input type="number" name="unit_price" id="unit_price" step="0.01" min="0" class="form-control" value="{{ old('unit_price') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Estimado</label>
                        <input type="text" id="total_display" class="form-control" value="R$ 0,00" readonly style="color:var(--success); font-weight:700;">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span style="font-size:16px;">📌</span><span class="card-title">Status & Observações</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        @foreach(['pending'=>'Aguardando','confirmed'=>'Confirmado','in_production'=>'Em Produção','shipped'=>'Enviado','delivered'=>'Entregue','cancelled'=>'Cancelado'] as $v => $l)
                            <option value="{{ $v }}" {{ old('status', 'pending') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Observações</label>
                    <textarea name="notes" rows="3" class="form-control" placeholder="Ex: Cliente pediu entrega urgente...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:15px;">💾 Criar Pedido</button>
        </div>
    </div>
</form>
</div>
@endsection

@push('scripts')
<script>
const select = document.getElementById('product_select');
const nameInput = document.getElementById('product_name');
const priceInput = document.getElementById('unit_price');
const qtyInput = document.getElementById('quantity');
const totalDisplay = document.getElementById('total_display');

select.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt.value) {
        nameInput.value = opt.dataset.name;
        priceInput.value = parseFloat(opt.dataset.price).toFixed(2);
        calcTotal();
    }
});

function calcTotal() {
    const price = parseFloat(priceInput.value) || 0;
    const qty = parseInt(qtyInput.value) || 1;
    const total = price * qty;
    totalDisplay.value = 'R$ ' + total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

priceInput.addEventListener('input', calcTotal);
qtyInput.addEventListener('input', calcTotal);
</script>
@endpush
