@extends('admin.layouts.app')
@section('title', 'Categorias & Status')
@section('page-title', 'Categorias & Status')

@section('content')
<form method="POST" action="{{ route('admin.categories.update') }}">
    @csrf

    <div style="display:flex; flex-direction:column; gap:24px; max-width:860px;">

        {{-- Categories Card --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span class="card-title">Categorias de Produtos</span>
            </div>
            <div class="card-body">
                <p style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">
                    Defina as categorias de produtos disponíveis no catálogo. Use letras minúsculas, sem acentos ou caracteres especiais (ex: <code>sublimacao</code>, <code>serigrafia</code>).
                </p>

                <div id="categories-container" style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                    @foreach($categories as $category)
                        <div class="category-row" style="display:flex; gap:10px; align-items:center;">
                            <input type="text" name="categories[]" class="form-control" value="{{ $category }}" placeholder="Nome da categoria (ex: dtf)">
                            <button type="button" class="btn btn-danger-outline btn-sm remove-row-btn" style="padding:10px; display:inline-flex; align-items:center; justify-content:center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-category-btn" class="btn btn-outline btn-sm">
                    + Adicionar Categoria
                </button>
            </div>
        </div>

        {{-- Statuses Card --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span class="card-title">Status de Pedidos</span>
            </div>
            <div class="card-body">
                <p style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">
                    Defina os status para o fluxo de pedidos. O sistema mapeia uma chave identificadora simples (ex: <code>pending</code>) para o rótulo exibido (ex: <code>Aguardando</code>).
                </p>

                <div id="statuses-container" style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                    @foreach($statuses as $key => $label)
                        <div class="status-row" style="display:flex; gap:10px; align-items:center;">
                            <input type="text" name="statuses_keys[]" class="form-control" value="{{ $key }}" placeholder="Chave (ex: pending)" style="flex:1;">
                            <input type="text" name="statuses_labels[]" class="form-control" value="{{ $label }}" placeholder="Rótulo (ex: Aguardando)" style="flex:2;">
                            <button type="button" class="btn btn-danger-outline btn-sm remove-row-btn" style="padding:10px; display:inline-flex; align-items:center; justify-content:center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-status-btn" class="btn btn-outline btn-sm">
                    + Adicionar Status
                </button>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Salvar Alterações
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Add Category Row
    const categoriesContainer = document.getElementById('categories-container');
    const addCategoryBtn = document.getElementById('add-category-btn');

    addCategoryBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'category-row';
        row.style.display = 'flex';
        row.style.gap = '10px';
        row.style.alignItems = 'center';
        row.innerHTML = `
            <input type="text" name="categories[]" class="form-control" placeholder="Nome da categoria (ex: dtf)">
            <button type="button" class="btn btn-danger-outline btn-sm remove-row-btn" style="padding:10px; display:inline-flex; align-items:center; justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        `;
        categoriesContainer.appendChild(row);
        bindRemoveBtn(row.querySelector('.remove-row-btn'));
    });

    // Add Status Row
    const statusesContainer = document.getElementById('statuses-container');
    const addStatusBtn = document.getElementById('add-status-btn');

    addStatusBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'status-row';
        row.style.display = 'flex';
        row.style.gap = '10px';
        row.style.alignItems = 'center';
        row.innerHTML = `
            <input type="text" name="statuses_keys[]" class="form-control" placeholder="Chave (ex: pending)" style="flex:1;">
            <input type="text" name="statuses_labels[]" class="form-control" placeholder="Rótulo (ex: Aguardando)" style="flex:2;">
            <button type="button" class="btn btn-danger-outline btn-sm remove-row-btn" style="padding:10px; display:inline-flex; align-items:center; justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        `;
        statusesContainer.appendChild(row);
        bindRemoveBtn(row.querySelector('.remove-row-btn'));
    });

    // Bind remove action
    const bindRemoveBtn = (btn) => {
        btn.addEventListener('click', () => {
            btn.parentElement.remove();
        });
    };

    document.querySelectorAll('.remove-row-btn').forEach(bindRemoveBtn);
});
</script>
@endpush
