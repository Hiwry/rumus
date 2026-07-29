<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — RUMUS Admin</title>
    <link rel="icon" type="{{ Str::endsWith($siteSettings['site_favicon'] ?? '', '.ico') ? 'image/x-icon' : 'image/png' }}" href="{{ asset($siteSettings['site_favicon'] ?? 'favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #000000;
            --primary-hover: #1f1f1f;
            --text-main: #111111;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --bg-white: #ffffff;
            --bg-light: #f8f9fa;
            --bg-mid: #f1f3f5;
            --border: #e9ecef;
            --border-dark: #d1d5db;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
            --info: #0284c7;
            --font-title: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.07);
            --sidebar-w: 248px;
        }

        html, body { height: 100%; }

        body {
            font-family: var(--font-body);
            color: var(--text-main);
            background: var(--bg-light);
            display: flex;
            overflow: hidden;
        }

        /* ═══════════════════════════════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--bg-white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 200;
            overflow: hidden;
        }

        /* Sidebar top-bar strip (same black as site) */
        .sidebar-topstrip {
            background: #000;
            padding: 0.45rem 1.25rem;
            font-family: var(--font-title);
            font-size: 0.62rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Logo row */
        .sidebar-logo {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo-name {
            font-family: var(--font-title);
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: #000;
            text-transform: uppercase;
            text-decoration: none;
        }

        .sidebar-logo-tag {
            font-family: var(--font-title);
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            border: 1px solid var(--border);
            padding: 0.2rem 0.55rem;
            border-radius: 3px;
            background: var(--bg-light);
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.75rem;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-label {
            font-family: var(--font-title);
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-light);
            padding: 0 0.5rem 0.6rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.6rem 0.75rem;
            border-radius: 4px;
            font-family: var(--font-title);
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
            margin-bottom: 1px;
        }

        .nav-link .nav-icon {
            font-size: 14px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: var(--bg-light);
            color: var(--text-main);
        }

        .nav-link.active {
            background: #000;
            color: #fff;
        }

        .nav-link.active .nav-icon {
            filter: brightness(10);
        }

        /* Sidebar footer */
        .sidebar-footer {
            border-top: 1px solid var(--border);
            padding: 0.9rem 0.75rem;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0.5rem;
            margin-bottom: 0.6rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #000;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-title);
            font-size: 0.78rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info-name {
            font-family: var(--font-title);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-info-email {
            font-size: 0.68rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.6rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-family: var(--font-title);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        /* ═══════════════════════════════════════════════════════════════════
           MAIN
        ═══════════════════════════════════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Top bar — same as site's black strip */
        .main-topbar {
            background: #000;
            padding: 0.5rem 2rem;
            font-family: var(--font-title);
            font-size: 0.68rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .main-topbar-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            opacity: 0.7;
        }

        .main-topbar-item.highlight {
            opacity: 1;
        }

        /* Page header — same as site's navbar */
        .page-header {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-header-title {
            font-family: var(--font-title);
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            flex: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-sep {
            color: var(--border-dark);
            font-weight: 400;
        }

        .breadcrumb-current {
            color: var(--text-main);
        }

        .breadcrumb-parent {
            color: var(--text-muted);
            font-weight: 500;
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* ── Buttons (match site exactly) ──────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.65rem 1.25rem;
            border-radius: 4px;
            font-family: var(--font-title);
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-sm { padding: 0.45rem 0.85rem; font-size: 0.68rem; }
        .btn-xs { padding: 0.3rem 0.6rem; font-size: 0.65rem; }

        .btn-primary { background: #000; color: #fff; border-color: #000; }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-outline { background: transparent; color: #000; border-color: var(--border-dark); }
        .btn-outline:hover { border-color: #000; background: var(--bg-light); }

        .btn-ghost { background: transparent; color: var(--text-muted); border-color: var(--border); }
        .btn-ghost:hover { background: var(--bg-light); color: var(--text-main); }

        .btn-danger-outline { background: transparent; color: var(--danger); border-color: #fca5a5; }
        .btn-danger-outline:hover { background: #fef2f2; }

        .btn-success-outline { background: transparent; color: var(--success); border-color: #86efac; }
        .btn-success-outline:hover { background: #f0fdf4; }

        /* ── Page content ──────────────────────────────────────────────── */
        .page-content {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* ── Flash messages ────────────────────────────────────────────── */
        .flash {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 1rem;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--success); }
        .flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }
        .flash-info    { background: #eff6ff; border: 1px solid #bfdbfe; color: var(--info); }

        /* ── Cards ─────────────────────────────────────────────────────── */
        .card {
            background: var(--bg-white);
            border: 1px solid var(--border);
            border-radius: 6px;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title {
            font-family: var(--font-title);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            flex: 1;
        }

        .card-body { padding: 1.5rem; }

        /* ── Stat cards ─────────────────────────────────────────────────── */
        .stat-card {
            background: var(--bg-white);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 1.5rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--border-dark);
        }

        .stat-card-label {
            font-family: var(--font-title);
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .stat-card-value {
            font-family: var(--font-title);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-card-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .stat-trend-up   { color: var(--success); font-weight: 600; }
        .stat-trend-down { color: var(--danger); font-weight: 600; }

        /* ── Tables ─────────────────────────────────────────────────────── */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 0.7rem 1rem;
            text-align: left;
            font-family: var(--font-title);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            background: var(--bg-light);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--bg-light); }

        tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.84rem;
            vertical-align: middle;
            color: var(--text-main);
        }

        /* ── Status badges ──────────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.6rem;
            border-radius: 3px;
            font-family: var(--font-title);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-dark    { background: #111; color: #fff; }
        .badge-outline { background: transparent; border: 1px solid var(--border-dark); color: var(--text-muted); }
        .badge-success { background: #f0fdf4; color: var(--success); border: 1px solid #bbf7d0; }
        .badge-warning { background: #fffbeb; color: var(--warning); border: 1px solid #fde68a; }
        .badge-danger  { background: #fef2f2; color: var(--danger);  border: 1px solid #fecaca; }
        .badge-info    { background: #eff6ff; color: var(--info);    border: 1px solid #bfdbfe; }
        .badge-gray    { background: var(--bg-mid); color: var(--text-muted); border: 1px solid var(--border); }

        /* ── Forms ──────────────────────────────────────────────────────── */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-family: var(--font-title);
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-main);
            margin-bottom: 0.45rem;
        }

        .form-control {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 0.7rem 0.9rem;
            font-family: var(--font-body);
            font-size: 0.875rem;
            color: var(--text-main);
            background: var(--bg-white);
            transition: var(--transition);
            outline: none;
            resize: vertical;
            -webkit-appearance: none;
        }

        .form-control:focus {
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { font-size: 0.75rem; color: var(--danger); margin-top: 0.35rem; font-weight: 500; }

        select.form-control { cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; padding-right: 2.25rem; }

        /* ── Grid helpers ───────────────────────────────────────────────── */
        .grid { display: grid; gap: 1.25rem; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        /* ── Search bar ─────────────────────────────────────────────────── */
        .search-bar { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
        .search-wrap { position: relative; flex: 1; min-width: 200px; }
        .search-wrap svg { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; }
        .search-wrap .form-control { padding-left: 2.3rem; }

        /* ── Pagination ─────────────────────────────────────────────────── */
        .pagination { display: flex; align-items: center; gap: 0.25rem; }
        .page-link { padding: 0.45rem 0.85rem; border-radius: 4px; font-family: var(--font-title); font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-decoration: none; border: 1px solid var(--border); transition: var(--transition); }
        .page-link:hover { border-color: #000; color: #000; }
        .page-link.active { background: #000; color: #fff; border-color: #000; }

        /* ── Scrollbar ──────────────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-dark); border-radius: 3px; }

        /* ── Divider ────────────────────────────────────────────────────── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0 1.5rem;
        }

        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-divider span {
            font-family: var(--font-title);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-light);
        }

        /* ── Responsive ─────────────────────────────────────────────────── */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            z-index: 150;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        .mobile-sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }

        /* Bottom Navigation Bar */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: var(--bg-white);
            border-top: 1px solid var(--border);
            z-index: 180;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            align-items: center;
            justify-content: space-around;
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            background: transparent;
            border: none;
            padding: 0.25rem 0;
            font-family: var(--font-title);
            font-size: 0.65rem;
            font-weight: 600;
            gap: 0.2rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .bottom-nav-item:hover,
        .bottom-nav-item.active {
            color: #000;
        }

        .bottom-nav-item svg {
            transition: var(--transition);
        }
        
        .bottom-nav-item.active svg {
            stroke: #000;
            fill: rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; padding-bottom: 60px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .page-content { padding: 1rem 0.75rem; }
            .mobile-sidebar-toggle { display: flex; }
            .page-header { display: flex; padding: 0 1rem; gap: 0.5rem; justify-content: space-between; }
            .page-header-title { font-size: 0.8rem; }
            .page-header-actions { gap: 0.5rem; }
            .page-header-actions .btn { padding: 0.4rem 0.65rem; font-size: 0.62rem; }
            .main-topbar { padding: 0.5rem 1rem; font-size: 0.6rem; gap: 0.8rem; justify-content: center; }
            .main-topbar-item { display: none; }
            .main-topbar-item.highlight { display: flex; }
            .mobile-bottom-nav { display: flex; }

            /* ── Search Bar Mobile ────────────────────────────────────────── */
            .search-bar {
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 0.5rem !important;
                width: 100% !important;
            }
            .search-bar select.form-control,
            .search-bar .btn,
            .search-bar .search-wrap {
                width: 100% !important;
                min-width: 0 !important;
            }
            .search-bar .btn {
                justify-content: center;
                padding: 0.65rem 1rem;
            }

            /* ── Responsive Table to Cards ────────────────────────────────── */
            .responsive-table table, 
            .responsive-table thead, 
            .responsive-table tbody, 
            .responsive-table th, 
            .responsive-table td, 
            .responsive-table tr { 
                display: block; 
            }
            .responsive-table thead {
                display: none;
            }
            .responsive-table tr {
                background: var(--bg-white);
                border: 1px solid var(--border);
                border-radius: 8px;
                margin-bottom: 12px;
                padding: 12px;
                box-shadow: var(--shadow-sm);
            }
            .responsive-table td {
                border: none;
                padding: 8px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 13px;
                border-bottom: 1px dashed var(--border);
                min-height: 38px;
            }
            .responsive-table td:last-child {
                border-bottom: none;
                padding-top: 10px;
                justify-content: flex-end;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-family: var(--font-title);
                font-weight: 700;
                font-size: 11px;
                text-transform: uppercase;
                color: var(--text-muted);
                letter-spacing: 0.5px;
            }
            .responsive-table td.full-width {
                display: block;
                border-bottom: 1px solid var(--border);
                padding-bottom: 8px;
                margin-bottom: 8px;
            }
            .responsive-table td.full-width::before {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ══ Sidebar ══════════════════════════════════════════════════════════ -->
    <aside class="sidebar">

        <!-- Black strip — same as site's top-bar -->
        <div class="sidebar-topstrip">Painel de Controle</div>

        <!-- Logo row — same style as site's navbar -->
        <div class="sidebar-logo">
            <a href="/" class="sidebar-logo-name">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'RUMUS' }}" style="max-height: 28px; object-fit: contain;">
                @else
                    {{ $siteSettings['site_name'] ?? 'RUMUS' }}
                @endif
            </a>
            <span class="sidebar-logo-tag">Admin</span>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">

            <div class="nav-section">
                <div class="nav-section-label">Visão Geral</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </span>
                    Dashboard
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Loja</div>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    </span>
                    Catálogo de Produtos
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </span>
                    Pedidos
                </a>
                <a href="{{ route('admin.quotes.index') }}" class="nav-link {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 10h.01"/><path d="M12 14h.01"/><path d="M8 14h.01"/><path d="M12 18h.01"/><path d="M8 18h.01"/></svg>
                    </span>
                    Gerador de Orçamento
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Sistema</div>
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12h2M20 12h2M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41"/></svg>
                    </span>
                    Configurações do Site
                </a>
                <a href="{{ route('admin.password.change') }}" class="nav-link {{ request()->routeIs('admin.password.change') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </span>
                    Alterar Senha
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    </span>
                    Categorias & Status
                </a>
                <a href="{{ route('admin.images.index') }}" class="nav-link {{ request()->routeIs('admin.images.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </span>
                    Imagens do Site
                </a>
                <a href="{{ url('/') }}" target="_blank" class="nav-link">
                    <span class="nav-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </span>
                    Abrir Site
                </a>
            </div>

        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="user-row">
                <div class="user-avatar">{{ strtoupper(substr(session('admin_user_name', 'A'), 0, 1)) }}</div>
                <div style="flex:1; min-width:0;">
                    <div class="user-info-name">{{ session('admin_user_name', 'Admin') }}</div>
                    <div class="user-info-email">{{ session('admin_user_email', '') }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Sair do Painel
                </button>
            </form>
        </div>

    </aside>

    <!-- ══ Main ═════════════════════════════════════════════════════════════ -->
    <div class="main">

        <!-- Black top-bar strip — same as site -->
        <div class="main-topbar">
            <span class="main-topbar-item highlight">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Sistema ativo
            </span>
            <span class="main-topbar-item">Produção própria com qualidade premium</span>
            <span class="main-topbar-item">Atendimento via WhatsApp</span>
        </div>

        <!-- Page header — same as site's navbar -->
        <header class="page-header">
            <button type="button" class="mobile-sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <div class="page-header-title">
                <span class="breadcrumb-parent">Admin</span>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="page-header-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <!-- Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="flash flash-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash flash-error">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>

    </div>

    <!-- ══ Mobile Bottom Navigation ═════════════════════════════════════════ -->
    <nav class="mobile-bottom-nav">
        <a href="{{ route('admin.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>Painel</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <span>Produtos</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span>Pedidos</span>
        </a>
        <a href="{{ route('admin.quotes.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 10h.01"/><path d="M12 14h.01"/><path d="M8 14h.01"/><path d="M12 18h.01"/><path d="M8 18h.01"/></svg>
            <span>Orçamento</span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M2 12h2M20 12h2M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41"/></svg>
            <span>Ajustes</span>
        </a>
        <button type="button" class="bottom-nav-item" id="bottomNavMenu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            <span>Mais</span>
        </button>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const bottomNavMenu = document.getElementById('bottomNavMenu');
            const overlay = document.getElementById('sidebarOverlay');
            
            const openSidebar = function() {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            };

            const closeSidebar = function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            };

            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
                });
            }

            if (bottomNavMenu) {
                bottomNavMenu.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
