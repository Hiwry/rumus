@extends('admin.layouts.app')
@section('title', 'Configurações')
@section('page-title', 'Configurações do Site')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:flex; flex-direction:column; gap:24px; max-width:860px;">

        {{-- General --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span class="card-title">Informações Gerais</span>
            </div>
            <div class="card-body">
                <div class="grid grid-2">
                    @foreach($settings->get('general', collect()) as $s)
                        <div class="form-group">
                            <label class="form-label">{{ $s->label }}</label>
                            @if($s->type === 'file')
                                <div style="display:flex; flex-direction:column; gap:8px;">
                                    <input type="file" name="{{ $s->key }}" class="form-control" accept="image/*,.ico">
                                    @if(!empty($s->value))
                                        <div style="display:flex; align-items:center; gap:8px; margin-top:4px;">
                                            <span style="font-size:12px; color:var(--text-muted);">Atual:</span>
                                            @if(Str::endsWith($s->value, '.ico'))
                                                <img src="{{ asset($s->value) }}" alt="Favicon" style="width:16px; height:16px;">
                                            @else
                                                <img src="{{ asset($s->value) }}" alt="{{ $s->label }}" style="max-height:40px; border:1px solid var(--border); border-radius:4px; padding:2px;">
                                            @endif
                                            <span style="font-size:12px; color:var(--text-muted); font-family:monospace;">{{ $s->value }}</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <input type="text" name="{{ $s->key }}" class="form-control" value="{{ old($s->key, $s->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Social --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
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
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"></path><circle cx="7.5" cy="10.5" r="1.5"></circle><circle cx="11.5" cy="7.5" r="1.5"></circle><circle cx="16.5" cy="9.5" r="1.5"></circle></svg>
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
            <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:15px; display:inline-flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Salvar Configurações
            </button>
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
