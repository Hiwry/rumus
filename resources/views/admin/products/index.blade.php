@extends('admin.layouts.app')
@section('title', 'Catálogo')
@section('page-title', 'Catálogo de Produtos')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Novo Produto</a>
@endsection

@section('content')
{{-- Filters --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-body" style="padding: 16px 20px;">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <div class="search-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Buscar produto..."
                        value="{{ request('search') }}"
                    >
                </div>
                <select name="category" class="form-control" style="width:160px;">
                    <option value="">Categoria</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-control" style="width:140px;">
                    <option value="">Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Ativos</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativos</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                @if(request()->hasAny(['search','category','status']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">Limpar</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Products table --}}
<div class="card">
    <div class="table-wrap responsive-table">
        <table>
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Acessos</th>
                    <th>Status</th>
                    <th style="width:180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td data-label="#" style="color:var(--text-muted); font-size:12px;">{{ $product->id }}</td>
                        <td class="full-width">
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($product->images && count($product->images) > 0)
                                    <img
                                        src="{{ asset($product->images[0]) }}"
                                        alt="{{ $product->name }}"
                                        style="width:40px; height:40px; object-fit:cover; border-radius:8px; border:1px solid var(--border);"
                                        onerror="this.style.display='none'"
                                    >
                                @endif
                                <div>
                                    <div style="font-weight:600; font-size:14px;">{{ $product->name }}</div>
                                    <div style="font-size:11px; color:var(--text-muted);">/produto/{{ $product->slug }}</div>
                                    @if(!empty($prod->tag))
                                        <span class="badge badge-warning" style="font-size:0.6rem;">{{ $prod->tag }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td data-label="Categoria">
                            <span class="badge badge-outline">{{ ucfirst($product->category) }}</span>
                        </td>
                        <td data-label="Preço" style="font-family:var(--font-title); font-weight:700;">{{ $product->formatted_price }}</td>
                        <td data-label="Acessos">
                            <span style="color:var(--brand-light); font-weight:600;">{{ number_format($product->page_views_count) }}</span>
                            <span style="color:var(--text-muted); font-size:12px;"> views</span>
                        </td>
                        <td data-label="Status">
                            @if($product->is_active)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                        <td data-label="Ações">
                            <div style="display:flex; gap:6px; align-items:center; flex-wrap:nowrap;">
                                <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-ghost btn-xs" title="Ver no site" style="padding:6px; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-xs" title="Editar" style="padding:6px; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.products.toggle', $product) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-xs {{ $product->is_active ? 'btn-danger-outline' : 'btn-success-outline' }}" title="{{ $product->is_active ? 'Pausar' : 'Ativar' }}" style="padding:6px; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px;">
                                        @if($product->is_active)
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>
                                        @else
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Excluir este produto?');" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-xs" title="Excluir" style="padding:6px; display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                            <div style="color:var(--text-light); margin-bottom:12px;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin:0 auto; display:block;"><path d="M20.38 3.46L16 6a2 2 0 0 1-2-2V2H10v2a2 2 0 0 1-2 2L3.62 3.46a1 1 0 0 0-1.34.45L.15 7.86a1 1 0 0 0 .3 1.25L4 12v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7l3.55-2.89a1 1 0 0 0 .3-1.25l-2.13-3.95a1 1 0 0 0-1.34-.45z"/></svg>
                            </div>
                            <div style="font-size:15px; margin-bottom:8px;">Nenhum produto encontrado</div>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="margin-top:8px;">+ Criar primeiro produto</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $products->withQueryString()->links('admin.pagination') }}
        </div>
    @endif
</div>
@endsection
