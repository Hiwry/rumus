@extends('admin.layouts.app')
@section('title', 'Imagens do Site')
@section('page-title', 'Imagens da Página Inicial')

@section('content')
<div style="display:flex; flex-direction:column; gap:32px; max-width:1000px;">

    {{-- Banner Section --}}
    <div class="card">
        <div class="card-header" style="display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <span class="card-title">Banners do Hero (Carrossel)</span>
            </div>
            <button type="button" onclick="document.getElementById('add-banner-modal').style.display='flex'" class="btn btn-primary btn-sm">
                + Adicionar Banner
            </button>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:24px;">
                @if(isset($images['banner']))
                    @foreach($images['banner'] as $img)
                        <div style="border:1px solid var(--border); border-radius:6px; padding:16px; display:flex; flex-direction:column; gap:12px; background:var(--bg-white);">
                            <div style="height:160px; border-radius:4px; overflow:hidden; background:var(--bg-light); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; position:relative;">
                                <img src="{{ $img->url }}" alt="{{ $img->title }}" style="max-width:100%; max-height:100%; object-fit:contain;">
                                @if(count($images['banner']) > 1)
                                    <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Deseja excluir este banner?')" style="position:absolute; top:8px; right:8px;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" style="padding: 4px 6px; border-radius:4px;">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div>
                                <h5 style="font-size:14px; font-weight:700; margin-bottom:4px;">{{ $img->title }}</h5>
                                <form method="POST" action="{{ route('admin.images.update', $img) }}" enctype="multipart/form-data" style="margin-top:10px;">
                                    @csrf @method('PUT')
                                    <input type="file" name="image" class="form-control" required style="padding:5px; font-size:11px; margin-bottom:8px;" onchange="this.form.submit()">
                                    <span style="font-size:10px; color:var(--text-muted);">Clique para substituir imagem</span>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Categories Mockups Section --}}
    <div class="card">
        <div class="card-header" style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <span class="card-title">Mockups de Categorias</span>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
                @if(isset($images['categories']))
                    @foreach($images['categories'] as $img)
                        <div style="border:1px solid var(--border); border-radius:6px; padding:16px; display:flex; flex-direction:column; gap:12px; background:var(--bg-white);">
                            <div style="height:140px; border-radius:4px; overflow:hidden; background:var(--bg-light); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;">
                                <img src="{{ $img->url }}" alt="{{ $img->title }}" style="max-width:100%; max-height:100%; object-fit:contain;">
                            </div>
                            <div>
                                <h5 style="font-size:13px; font-weight:700; margin-bottom:4px;">{{ $img->title }}</h5>
                                <form method="POST" action="{{ route('admin.images.update', $img) }}" enctype="multipart/form-data" style="margin-top:10px;">
                                    @csrf @method('PUT')
                                    <input type="file" name="image" class="form-control" required style="padding:5px; font-size:11px; margin-bottom:8px;" onchange="this.form.submit()">
                                    <span style="font-size:10px; color:var(--text-muted);">Clique para substituir</span>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Highlights/Services Section --}}
    <div class="card">
        <div class="card-header" style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span class="card-title">Destaques e Tipos de Produto</span>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:20px;">
                @if(isset($images['highlights']))
                    @foreach($images['highlights'] as $img)
                        <div style="border:1px solid var(--border); border-radius:6px; padding:16px; display:flex; flex-direction:column; gap:12px; background:var(--bg-white);">
                            <div style="height:140px; border-radius:4px; overflow:hidden; background:var(--bg-light); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;">
                                <img src="{{ $img->url }}" alt="{{ $img->title }}" style="max-width:100%; max-height:100%; object-fit:contain;">
                            </div>
                            <div>
                                <h5 style="font-size:13px; font-weight:700; margin-bottom:4px;">{{ $img->title }}</h5>
                                <form method="POST" action="{{ route('admin.images.update', $img) }}" enctype="multipart/form-data" style="margin-top:10px;">
                                    @csrf @method('PUT')
                                    <input type="file" name="image" class="form-control" required style="padding:5px; font-size:11px; margin-bottom:8px;" onchange="this.form.submit()">
                                    <span style="font-size:10px; color:var(--text-muted);">Clique para substituir</span>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Portfolio Gallery Section --}}
    <div class="card">
        <div class="card-header" style="display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                <span class="card-title">Galeria de Trabalhos / Instagram</span>
            </div>
            <button type="button" onclick="document.getElementById('add-gallery-modal').style.display='flex'" class="btn btn-primary btn-sm">
                + Adicionar Foto
            </button>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap:20px;">
                @if(isset($images['portfolio']))
                    @foreach($images['portfolio'] as $img)
                        <div style="border:1px solid var(--border); border-radius:6px; overflow:hidden; position:relative; group:hover;" class="gallery-card">
                            <img src="{{ $img->url }}" alt="{{ $img->title }}" style="width:100%; height:180px; object-fit:cover;">
                            <div style="padding:10px; display:flex; justify-content:space-between; align-items:center; background:var(--bg-white); border-top:1px solid var(--border);">
                                <span style="font-size:11px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:110px;" title="{{ $img->title }}">{{ $img->title }}</span>
                                <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Deseja excluir esta imagem da galeria?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-xs" style="padding: 4px 6px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Add Modal --}}
<div id="add-gallery-modal" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:9999;">
    <div class="card" style="width:450px; background:#fff; border-radius:6px; box-shadow:var(--shadow-lg);">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <h4 class="card-title">Adicionar Foto à Galeria</h4>
            <button type="button" onclick="document.getElementById('add-gallery-modal').style.display='none'" style="font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="portfolio">
                <div class="form-group">
                    <label class="form-label">Título / Legenda *</label>
                    <input type="text" name="title" class="form-control" placeholder="Legenda da foto" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Arquivo de Imagem *</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
                    <button type="button" onclick="document.getElementById('add-gallery-modal').style.display='none'" class="btn btn-outline btn-sm">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Enviar Imagem</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Banner Modal --}}
<div id="add-banner-modal" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:9999;">
    <div class="card" style="width:450px; background:#fff; border-radius:6px; box-shadow:var(--shadow-lg);">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <h4 class="card-title">Adicionar Banner ao Carrossel</h4>
            <button type="button" onclick="document.getElementById('add-banner-modal').style.display='none'" style="font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="banner">
                <div class="form-group">
                    <label class="form-label">Título do Banner *</label>
                    <input type="text" name="title" class="form-control" placeholder="Ex: Modelo Camisa Branca" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Arquivo de Imagem *</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:16px;">
                    <button type="button" onclick="document.getElementById('add-banner-modal').style.display='none'" class="btn btn-outline btn-sm">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Enviar Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
