@extends('admin.layouts.app')
@section('title', 'Alterar Senha')
@section('page-title', 'Alterar Senha')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card">
        <div class="card-header" style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <span class="card-title">Definir Nova Senha</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Senha Atual</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        class="form-control @error('current_password') is-invalid @enderror" 
                        placeholder="Digite sua senha atual"
                        required
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nova Senha</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        class="form-control @error('new_password') is-invalid @enderror" 
                        placeholder="Mínimo 6 caracteres"
                        required
                    >
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Nova Senha</label>
                    <input 
                        type="password" 
                        name="new_password_confirmation" 
                        class="form-control" 
                        placeholder="Repita a nova senha"
                        required
                    >
                </div>

                <div style="margin-top: 24px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        Salvar Nova Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
