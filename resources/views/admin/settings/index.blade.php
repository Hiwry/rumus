@extends('admin.layouts.app')
@section('title', 'Configurações')
@section('page-title', 'Configurações do Site')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div style="display:flex; flex-direction:column; gap:24px; max-width:860px;">

        {{-- General --}}
        <div class="card">
            <div class="card-header">
                <span style="font-size:18px;">🏪</span>
                <span class="card-title">Informações Gerais</span>
            </div>
            <div class="card-body">
                <div class="grid grid-2">
                    @foreach($settings->get('general', collect()) as $s)
                        <div class="form-group">
                            <label class="form-label">{{ $s->label }}</label>
                            <input type="text" name="{{ $s->key }}" class="form-control" value="{{ old($s->key, $s->value) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Social --}}
        <div class="card">
            <div class="card-header">
                <span style="font-size:18px;">📱</span>
                <span class="card-title">Redes Sociais & Contato</span>
            </div>
            <div class="card-body">
                @foreach($settings->get('social', collect()) as $s)
                    <div class="form-group">
                        <label class="form-label">{{ $s->label }}</label>
                        <input type="{{ $s->type === 'url' ? 'url' : 'text' }}" name="{{ $s->key }}" class="form-control" value="{{ old($s->key, $s->value) }}">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Appearance --}}
        <div class="card">
            <div class="card-header">
                <span style="font-size:18px;">🎨</span>
                <span class="card-title">Aparência & Conteúdo</span>
            </div>
            <div class="card-body">
                @foreach($settings->get('appearance', collect()) as $s)
                    <div class="form-group">
                        <label class="form-label">{{ $s->label }}</label>
                        @if($s->type === 'textarea')
                            <textarea name="{{ $s->key }}" rows="3" class="form-control">{{ old($s->key, $s->value) }}</textarea>
                        @elseif($s->type === 'color')
                            <div style="display:flex; gap:12px; align-items:center;">
                                <input type="color" name="{{ $s->key }}" value="{{ old($s->key, $s->value) }}"
                                    style="width:48px; height:42px; border-radius:8px; border:1px solid var(--border); background:none; cursor:pointer; padding:2px;">
                                <input type="text" value="{{ old($s->key, $s->value) }}" class="form-control" style="max-width:140px;"
                                    oninput="document.querySelector('[name={{ $s->key }}][type=color]').value=this.value">
                            </div>
                        @elseif($s->type === 'boolean')
                            <div style="display:flex; align-items:center; gap:10px;">
                                <input type="hidden" name="{{ $s->key }}" value="0">
                                <input type="checkbox" name="{{ $s->key }}" id="{{ $s->key }}" value="1"
                                    {{ old($s->key, $s->value) == '1' ? 'checked' : '' }}
                                    style="width:18px; height:18px; accent-color:var(--brand); cursor:pointer;">
                                <label for="{{ $s->key }}" style="font-size:14px; cursor:pointer;">Habilitado</label>
                            </div>
                        @else
                            <input type="text" name="{{ $s->key }}" class="form-control" value="{{ old($s->key, $s->value) }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary" style="padding:14px 32px; font-size:16px;">💾 Salvar Configurações</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Sync color picker ↔ text input
document.querySelectorAll('input[type="color"]').forEach(colorPicker => {
    colorPicker.addEventListener('input', function() {
        this.nextElementSibling.value = this.value;
    });
});
</script>
@endpush
