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
                <div class="search-input-wrap">
                    <span class="search-icon">🔍</span>
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
                    <option value="sublimacao" {{ request('category') === 'sublimacao' ? 'selected' : '' }}>Sublimação</option>
                    <option value="serigrafia" {{ request('category') === 'serigrafia' ? 'selected' : '' }}>Serigrafia</option>
                    <option value="dtf"        {{ request('category') === 'dtf'        ? 'selected' : '' }}>DTF</option>
                    <option value="ecobag"     {{ request('category') === 'ecobag'     ? 'selected' : '' }}>Ecobag</option>
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
    <div class="table-wrap">
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
                        <td style="color:var(--text-muted); font-size:12px;">{{ $product->id }}</td>
                        <td>
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
                        <td>
                        <span class="badge badge-outline">{{ ucfirst($product->category) }}</span>
                        </td>
                        <td style="font-family:var(--font-title); font-weight:700;">{{ $product->formatted_price }}</td>
                        <td>
                            <span style="color:var(--brand-light); font-weight:600;">{{ number_format($product->page_views_count) }}</span>
                            <span style="color:var(--text-muted); font-size:12px;"> views</span>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-ghost btn-xs" title="Ver no site">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-xs">Editar</a>
                                <form method="POST" action="{{ route('admin.products.toggle', $product) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-xs {{ $product->is_active ? 'btn-danger-outline' : 'btn-success-outline' }}">
                                        {{ $product->is_active ? 'Pausar' : 'Ativar' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Excluir este produto?');" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-xs">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                            <div style="font-size:36px; margin-bottom:12px;">👕</div>
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
