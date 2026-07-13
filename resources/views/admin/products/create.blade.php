@extends('admin.layouts.app')
@section('title', 'Novo Produto')
@section('page-title', 'Novo Produto')

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm btn btn-outline btn-sm">← Voltar ao Catálogo</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-2" style="gap:24px; align-items:start;">
        {{-- Left column --}}
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📝</span><span class="card-title">Informações Básicas</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nome do Produto *</label>
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Ex: Camisa Sublimação Full Print" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Slug (URL) *</label>
                        <input type="text" name="slug" id="slug" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" value="{{ old('slug') }}" placeholder="camisa-sublimacao-full-print" required>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Preço (R$) *</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ old('price') }}" placeholder="49.90" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tag / Destaque</label>
                            <input type="text" name="tag" class="form-control" value="{{ old('tag') }}" placeholder="MAIS VENDIDO">
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Categoria *</label>
                            <select name="category" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" required>
                                <option value="">Selecione...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipo *</label>
                            <select name="type" class="form-control" required>
                                <option value="unissex" {{ old('type','unissex') === 'unissex' ? 'selected' : '' }}>Unissex</option>
                                <option value="masculino" {{ old('type') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino" {{ old('type') === 'feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="infantil" {{ old('type') === 'infantil' ? 'selected' : '' }}>Infantil</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">Avaliação (1-5)</label>
                            <input type="number" name="rating" min="1" max="5" class="form-control" value="{{ old('rating', 5) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nº de Avaliações</label>
                            <input type="number" name="reviews_count" min="0" class="form-control" value="{{ old('reviews_count', 0) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Descrição *</label>
                        <textarea name="description" rows="4" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Descreva o produto..." required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; gap:10px;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer;">
                        <label for="is_active" style="font-size:14px; cursor:pointer;">Produto ativo (visível no site)</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📐</span><span class="card-title">Tamanhos & Cores</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Tamanhos disponíveis (um por linha)</label>
                        <textarea name="sizes" rows="5" class="form-control" placeholder="P&#10;M&#10;G&#10;GG&#10;XG">{{ old('sizes') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cores disponíveis (uma por linha)</label>
                        <textarea name="colors" rows="4" class="form-control" placeholder="black&#10;white&#10;grey&#10;red">{{ old('colors') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="card">
                <div class="card-header"><span style="font-size:16px;">🖼️</span><span class="card-title">Imagens</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Upload de Imagens</label>
                        <div style="border:2px dashed var(--border); border-radius:12px; padding:24px; text-align:center; cursor:pointer;" onclick="document.getElementById('images').click()">
                            <div style="font-size:32px; margin-bottom:8px;">📷</div>
                            <div style="font-size:14px; color:var(--text-muted);">Clique para selecionar imagens</div>
                            <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">JPG, PNG, WEBP · Máx 4MB cada</div>
                        </div>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" style="display:none;" onchange="previewImages(this)">
                        <div id="image-preview" style="display:flex; flex-wrap:wrap; gap:8px; margin-top:12px;"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">✅</span><span class="card-title">Destaques do Produto</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Bullets / Vantagens (um por linha)</label>
                        <textarea name="bullets" rows="5" class="form-control" placeholder="Estampa full print de alta definição&#10;Tecido leve e confortável&#10;Secagem rápida">{{ old('bullets') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">📋</span><span class="card-title">Especificações</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Especificações (Chave: Valor, uma por linha)</label>
                        <textarea name="specs" rows="6" class="form-control" placeholder="Material: 100% Poliéster&#10;Gramatura: 150g/m²&#10;Tipo de Estampa: Sublimação Full Print">{{ old('specs') ? (is_array(old('specs')) ? implode("\n", array_map(fn($k,$v)=>"$k: $v", array_keys(old('specs')), old('specs'))) : old('specs')) : '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span style="font-size:16px;">🫧</span><span class="card-title">Cuidados com o Produto</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Instruções de Lavagem (uma por linha)</label>
                        <textarea name="cares" rows="4" class="form-control" placeholder="Lavar à mão em ciclo delicado&#10;Não usar alvejante&#10;Secar à sombra">{{ old('cares') }}</textarea>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size:15px;">💾 Criar Produto</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name
document.querySelector('[name="name"]').addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.dataset.edited) {
        slug.value = this.value.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
    }
});
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.edited = 'true';
});

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
</script>
@endpush
