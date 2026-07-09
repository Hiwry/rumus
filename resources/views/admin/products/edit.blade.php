@extends('admin.layouts.app')
@section('title', 'Editar Produto')
@section('page-title', 'Editar: ' . $product->name)

@section('topbar-actions')
    <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-outline btn-sm btn btn-outline btn-sm">👁 Ver no Site</a>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm btn btn-outline btn-sm">← Voltar</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid grid-2" style="gap:24px; align-items:start;">
        {{-- Left column --}}
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📝</span><span class="card-title">Informações Básicas</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nome do Produto *</label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Slug (URL) *</label>
                        <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" value="{{ old('slug', $product->slug) }}" required>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Preço (R$) *</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag</label>
                            <input type="text" name="tag" class="form-control" value="{{ old('tag', $product->tag) }}" placeholder="MAIS VENDIDO">
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Categoria *</label>
                            <select name="category" class="form-control" required>
                                @foreach(['sublimacao'=>'Sublimação','serigrafia'=>'Serigrafia','dtf'=>'DTF','ecobag'=>'Ecobag'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('category', $product->category) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipo *</label>
                            <select name="type" class="form-control" required>
                                @foreach(['unissex'=>'Unissex','masculino'=>'Masculino','feminino'=>'Feminino','infantil'=>'Infantil'] as $val => $lbl)
                                    <option value="{{ $val }}" {{ old('type', $product->type) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Avaliação</label>
                            <input type="number" name="rating" min="1" max="5" class="form-control" value="{{ old('rating', $product->rating) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nº de Avaliações</label>
                            <input type="number" name="reviews_count" min="0" class="form-control" value="{{ old('reviews_count', $product->reviews_count) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descrição *</label>
                        <textarea name="description" rows="4" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; gap:10px;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer;">
                        <label for="is_active" style="font-size:14px; cursor:pointer;">Produto ativo</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📐</span><span class="card-title">Tamanhos & Cores</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Tamanhos (um por linha)</label>
                        <textarea name="sizes" rows="5" class="form-control">{{ old('sizes', implode("\n", $product->sizes ?? [])) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cores (uma por linha)</label>
                        <textarea name="colors" rows="4" class="form-control">{{ old('colors', implode("\n", $product->colors ?? [])) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div style="display:flex; flex-direction:column; gap:20px;">
            {{-- Current images --}}
            <div class="card">
                <div class="card-header"><span style="font-size:16px;">🖼️</span><span class="card-title">Imagens</span></div>
                <div class="card-body">
                    @if($product->images && count($product->images) > 0)
                        <div style="margin-bottom:16px;">
                            <label class="form-label">Imagens Atuais</label>
                            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                                @foreach($product->images as $img)
                                    <div style="position:relative; display:inline-block;">
                                        <img src="{{ asset($img) }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);" onerror="this.style.opacity=0.3">
                                        <label style="position:absolute; top:-6px; right:-6px; cursor:pointer; background:rgba(239,68,68,0.9); border-radius:50%; width:20px; height:20px; display:flex; align-items:center; justify-content:center; font-size:11px;" title="Remover imagem">
                                            <input type="checkbox" name="delete_images[]" value="{{ $img }}" style="display:none;">
                                            ✕
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:6px;">Clique no ✕ vermelho para marcar imagem para remoção</div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Adicionar Novas Imagens</label>
                        <div style="border:2px dashed var(--border); border-radius:12px; padding:20px; text-align:center; cursor:pointer;" onclick="document.getElementById('images').click()">
                            <div style="font-size:28px; margin-bottom:6px;">📷</div>
                            <div style="font-size:13px; color:var(--text-muted);">Clique para adicionar imagens</div>
                        </div>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" style="display:none;" onchange="previewImages(this)">
                        <div id="image-preview" style="display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">✅</span><span class="card-title">Destaques</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Bullets (um por linha)</label>
                        <textarea name="bullets" rows="5" class="form-control">{{ old('bullets', implode("\n", $product->bullets ?? [])) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📋</span><span class="card-title">Especificações</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Especificações (Chave: Valor, uma por linha)</label>
                        <textarea name="specs" rows="6" class="form-control">{{ old('specs', is_array($product->specs) ? implode("\n", array_map(fn($k,$v)=>"$k: $v", array_keys($product->specs), $product->specs)) : '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">🫧</span><span class="card-title">Cuidados</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Instruções de Lavagem (uma por linha)</label>
                        <textarea name="cares" rows="4" class="form-control">{{ old('cares', implode("\n", $product->cares ?? [])) }}</textarea>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:15px;">💾 Salvar Alterações</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,0.1)';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

// Toggle delete checkbox visual
document.querySelectorAll('[name="delete_images[]"]').forEach(checkbox => {
    checkbox.closest('label').addEventListener('change', function() {
        const imgEl = this.closest('div').querySelector('img');
        if (checkbox.checked) {
            imgEl.style.opacity = '0.3';
            imgEl.style.filter = 'grayscale(1)';
            this.style.background = 'rgba(34,197,94,0.9)';
            this.textContent = '↩';
        } else {
            imgEl.style.opacity = '1';
            imgEl.style.filter = '';
            this.style.background = 'rgba(239,68,68,0.9)';
            this.textContent = '✕';
        }
    });
});
</script>
@endpush
