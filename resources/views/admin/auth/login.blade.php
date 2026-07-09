<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUMUS Admin — Entrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #000000;
            --primary-hover: #1f1f1f;
            --text-main: #111111;
            --text-muted: #6b7280;
            --bg-white: #ffffff;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
            --border-focus: #111111;
            --danger: #dc2626;
            --success: #16a34a;
            --font-title: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.1);
        }

        html, body {
            height: 100%;
            font-family: var(--font-body);
            color: var(--text-main);
            background-color: var(--bg-light);
        }

        /* ── Top bar (same as site) ─────────────────────────────────────── */
        .top-bar {
            background-color: #000000;
            padding: 0.55rem 0;
            font-size: 0.72rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.6px;
            text-align: center;
            font-family: var(--font-title);
            text-transform: uppercase;
        }

        /* ── Navbar (same as site) ──────────────────────────────────────── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 1.1rem 0;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: var(--font-title);
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #000;
            text-decoration: none;
            text-transform: uppercase;
        }

        .navbar-badge {
            font-family: var(--font-title);
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 0.3rem 0.75rem;
            border-radius: 4px;
            background: var(--bg-light);
        }

        /* ── Page layout ────────────────────────────────────────────────── */
        .page-wrapper {
            min-height: calc(100vh - 88px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            background-color: var(--bg-light);
        }

        /* ── Login container ────────────────────────────────────────────── */
        .login-container {
            width: 100%;
            max-width: 420px;
        }

        /* Header block above card */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: #000;
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        .login-icon svg {
            stroke: #fff;
        }

        .login-header h1 {
            font-family: var(--font-title);
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #000;
            margin-bottom: 0.4rem;
        }

        .login-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ── Card ───────────────────────────────────────────────────────── */
        .login-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow-md);
        }

        /* ── Alerts ─────────────────────────────────────────────────────── */
        .alert {
            padding: 0.85rem 1rem;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: var(--font-body);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: var(--danger);
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: var(--success);
        }

        /* ── Form ───────────────────────────────────────────────────────── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-family: var(--font-title);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.8rem 1rem;
            font-family: var(--font-body);
            font-size: 0.9rem;
            color: var(--text-main);
            background: #fff;
            transition: var(--transition);
            outline: none;
            -webkit-appearance: none;
        }

        .form-input::placeholder {
            color: #c4c9d4;
        }

        .form-input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.06);
        }

        .form-input.is-error {
            border-color: var(--danger);
        }

        .form-input.is-error:focus {
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
        }

        .field-error {
            font-size: 0.78rem;
            color: var(--danger);
            margin-top: 0.4rem;
            font-weight: 500;
        }

        /* ── Submit button (exact same style as site's .btn-primary) ─────── */
        .btn-submit {
            width: 100%;
            background-color: #000;
            color: #fff;
            padding: 0.9rem 1.8rem;
            border-radius: 4px;
            font-family: var(--font-title);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border: 1px solid #000;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        /* ── Divider ────────────────────────────────────────────────────── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .form-divider span {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            white-space: nowrap;
        }

        /* ── Back link ──────────────────────────────────────────────────── */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--text-main);
        }

        /* ── Footer ─────────────────────────────────────────────────────── */
        .page-footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.72rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            background: #fff;
        }

        /* ── Micro animation ─────────────────────────────────────────────── */
        .login-container {
            animation: fadeUp 0.35s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Top bar — identical to site -->
    <div class="top-bar">
        Painel Administrativo · RUMUS Estamparia Premium
    </div>

    <!-- Navbar — identical to site -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo">RUMUS</a>
            <span class="navbar-badge">Admin</span>
        </div>
    </nav>

    <!-- Page -->
    <div class="page-wrapper">
        <div class="login-container">

            <div class="login-header">
                <div class="login-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <h1>Acesso ao Painel</h1>
                <p>Entre com suas credenciais de administrador.</p>
            </div>

            <div class="login-card">

                @if(session('error'))
                    <div class="alert alert-error">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">E-mail</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="admin@rumus.com.br"
                            autocomplete="email"
                            autofocus
                        >
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Senha</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Entrar no Painel
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </form>

                <div class="form-divider">
                    <span>ou</span>
                </div>

                <a href="/" class="back-link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Voltar para o site
                </a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="page-footer">
        © {{ date('Y') }} RUMUS Estamparia. Acesso restrito a administradores.
    </div>

</body>
</html>
