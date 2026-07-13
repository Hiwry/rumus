<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumus - Camisas Personalizadas e Ecobags</title>
    <link rel="icon" type="{{ Str::endsWith($siteSettings['site_favicon'] ?? '', '.ico') ? 'image/x-icon' : 'image/png' }}" href="{{ asset($siteSettings['site_favicon'] ?? 'favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if(isset($siteSettings))
    <style>
        :root {
            @if(!empty($siteSettings['primary_color']))
                --primary: {{ $siteSettings['primary_color'] }};
                --primary-hover: {{ $siteSettings['primary_color'] }}cc;
            @endif
            @if(!empty($siteSettings['accent_color']))
                --accent: {{ $siteSettings['accent_color'] }};
            @endif
        }
        .hero-image-container {
            position: relative;
            min-height: 520px;
            overflow: hidden;
            width: 100%;
        }
        .hero-image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            z-index: 1;
        }
        .hero-image-container img.active {
            opacity: 1;
            z-index: 2;
        }
    </style>
    @endif
</head>
<body>
    @if(isset($siteSettings) && ($siteSettings['show_banner'] ?? '0') == '1')
    <div class="promo-banner" style="background: var(--primary, #000); color: #fff; text-align: center; padding: 8px 12px; font-size: 11px; font-family: var(--font-title); font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">
        {{ str_replace('🚀', '', $siteSettings['banner_text'] ?? '') }}
    </div>
    @endif

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>Atendimento via WhatsApp</span>
            </div>
            <div class="top-bar-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/></svg>
                <span>Produção própria com qualidade premium</span>
            </div>
            <div class="top-bar-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="2" ry="2"/><line x1="16" y1="8" x2="20" y2="8"/><line x1="16" y1="12" x2="23" y2="12"/><line x1="1" y1="18" x2="23" y2="18"/></svg>
                <span>Enviamos para todo Brasil</span>
            </div>
        </div>
    </div>

    <!-- Header & Navigation -->
    <header class="navbar">
        <div class="container navbar-container">
            <!-- Hamburger menu button -->
            <button class="mobile-menu-toggle" aria-label="Abrir Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <a href="{{ url('/') }}" class="logo">
                @if(!empty($siteSettings['site_logo']))
                    <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'RUMUS' }}" style="max-height: 32px; object-fit: contain;">
                @else
                    {{ $siteSettings['site_name'] ?? 'RUMUS' }}
                @endif
            </a>
            
            <nav class="nav-links">
                <a href="{{ route('product.catalog', ['categoria' => 'sublimacao']) }}" class="nav-link">Camisa Sublimação</a>
                <a href="{{ route('product.catalog', ['categoria' => 'serigrafia']) }}" class="nav-link">Camisa Serigrafia</a>
                <a href="{{ route('product.catalog', ['categoria' => 'dtf']) }}" class="nav-link">Camisa DTF</a>
                <a href="{{ route('product.catalog', ['categoria' => 'ecobag']) }}" class="nav-link">Ecobag</a>
            </nav>

            <div class="nav-actions">
                <a href="#" class="nav-icon nav-icon-search" aria-label="Pesquisar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </a>
                <a href="#" class="nav-icon nav-icon-user" aria-label="Conta">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <a href="#" class="nav-icon nav-icon-cart" aria-label="Carrinho">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <span class="cart-badge">0</span>
                </a>
                <a href="{{ $instagramUrl }}" target="_blank" class="btn-quote">Solicite um Orçamento</a>
            </div>

            <!-- Search Overlay -->
            <div class="search-overlay">
                <input type="text" placeholder="Buscar produtos..." class="search-input">
                <button class="search-close-btn" aria-label="Fechar busca">&times;</button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-subtitle">{{ $siteSettings['site_tagline'] ?? 'Camisas Personalizadas e Ecobags' }}</span>
                <h1 class="hero-title">{{ $siteSettings['hero_title'] ?? 'Transformamos sua ideia em realidade.' }}</h1>
                <p class="hero-description">{{ $siteSettings['hero_subtitle'] ?? 'Camisas personalizadas, ecobags e produção para empresas, eventos, atléticas e marcas.' }}</p>
                <div class="hero-buttons">
                    <a href="{{ $instagramUrl }}" target="_blank" class="btn-primary">
                        Fazer Orçamento
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="{{ route('product.catalog') }}" class="btn-secondary">Ver Catálogo</a>
                </div>
            </div>
            <div class="hero-image-container">
                @if(isset($landingImages) && $landingImages->where('section', 'banner')->isNotEmpty())
                    @foreach($landingImages->where('section', 'banner')->values() as $index => $img)
                        <img src="{{ $img->url }}" alt="{{ $img->title }}" class="{{ $index === 0 ? 'active' : '' }}">
                    @endforeach
                @else
                    <img src="{{ asset('images/rumus_hero_model.png') }}" alt="Modelo vestindo camisa preta premium RUMUS" class="active">
                @endif
            </div>
        </div>
    </section>

    <!-- Four Main Category Cards -->
    <section class="categories-section">
        <div class="container">
            <div class="categories-divider">
                <span>Nossas Categorias</span>
            </div>
            <div class="categories-grid">
                <!-- Sublimacao -->
                <a href="{{ route('product.show', 'camisa-sublimacao-full-print-exclusiva') }}" class="category-card" id="sublimacao">
                    <img src="{{ isset($landingImages['category_sublimacao']) ? $landingImages['category_sublimacao']->url : asset('images/sublimacao_mockup.png') }}" class="category-img" alt="Camisa Sublimação">
                    <div class="category-overlay">
                        <h3 class="category-title">Camisa<br>Sublimação</h3>
                        <div class="category-btn" aria-label="Acessar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </div>
                    </div>
                </a>
                <!-- Serigrafia -->
                <a href="{{ route('product.show', 'camisa-serigrafia-tradicional') }}" class="category-card" id="serigrafia">
                    <img src="{{ isset($landingImages['category_serigrafia']) ? $landingImages['category_serigrafia']->url : asset('images/serigrafia_mockup.png') }}" class="category-img" alt="Camisa Serigrafia">
                    <div class="category-overlay">
                        <h3 class="category-title">Camisa<br>Serigrafia</h3>
                        <div class="category-btn" aria-label="Acessar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </div>
                    </div>
                </a>
                <!-- DTF -->
                <a href="{{ route('product.show', 'camisa-dtf-estampa-frontal') }}" class="category-card" id="dtf">
                    <img src="{{ isset($landingImages['category_dtf']) ? $landingImages['category_dtf']->url : asset('images/dtf_mockup.png') }}" class="category-img" alt="Camisa DTF">
                    <div class="category-overlay">
                        <h3 class="category-title">Camisa<br>DTF</h3>
                        <div class="category-btn" aria-label="Acessar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </div>
                    </div>
                </a>
                <!-- Ecobag -->
                <a href="{{ route('product.show', 'camisa-sublimacao-full-print-exclusiva') }}" class="category-card" id="ecobags">
                    <img src="{{ isset($landingImages['category_ecobag']) ? $landingImages['category_ecobag']->url : asset('images/ecobag_mockup.png') }}" class="category-img" alt="Ecobag">
                    <div class="category-overlay">
                        <h3 class="category-title">Ecobag</h3>
                        <div class="category-btn" aria-label="Acessar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title-steps">COMO FUNCIONA</h2>
            </div>
            <div class="steps-container">
                <div class="steps-line"></div>
                <!-- Step 1 -->
                <div class="step-card">
                    <div class="step-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v4h3v10h12V10h3V6l-3-4H6z"/><path d="M9 2a3 3 0 0 0 6 0"/></svg>
                    </div>
                    <h3 class="step-title">1. Escolha o produto</h3>
                    <p class="step-desc">Selecione o produto estampa que deseja.</p>
                </div>
                <!-- Step 2 -->
                <div class="step-card">
                    <div class="step-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29" /><polyline points="16 16 12 12 8 16" /><line x1="12" y1="12" x2="12" y2="21" /></svg>
                    </div>
                    <h3 class="step-title">2. Envie sua arte</h3>
                    <p class="step-desc">Faça o upload da sua arte nas nossas redes ou loja.</p>
                </div>
                <!-- Step 3 -->
                <div class="step-card">
                    <div class="step-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><polyline points="8 12 11 15 16 9" /></svg>
                    </div>
                    <h3 class="step-title">3. Receba a aprovação</h3>
                    <p class="step-desc">Enviamos a arte para sua aprovação.</p>
                </div>
                <!-- Step 4 -->
                <div class="step-card">
                    <div class="step-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9" /><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" /><rect x="6" y="14" width="12" height="8" /></svg>
                    </div>
                    <h3 class="step-title">4. Produzimos</h3>
                    <p class="step-desc">Produção com qualidade e padrão premium.</p>
                </div>
                <!-- Step 5 -->
                <div class="step-card">
                    <div class="step-icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21" /><polygon points="12 22.08 12 12 3 6.92 3 17 12 22.08" /><polygon points="12 22.08 21 17 21 6.92 12 12 12 22.08" /><polygon points="12 12 21 6.92 12 1.84 3 6.92 12 12" /></svg>
                    </div>
                    <h3 class="step-title">5. Entregamos</h3>
                    <p class="step-desc">Enviamos para todo Brasil com segurança.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mais Pedidos (Featured Products) - Smaller sizing layout -->
    <section class="featured-section" id="mais-pedidos">
        <div class="container">
            <div class="featured-header-row">
                <div>
                    <span class="section-subtitle">Produtos em Destaque</span>
                    <h2 class="section-title">Mais pedidos</h2>
                </div>
                <div class="featured-nav">
                    <button class="nav-arrow" id="slide-prev" aria-label="Anterior">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="nav-arrow" id="slide-next" aria-label="Próximo">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
            
            <div class="products-slider-wrapper">
                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['highlight_empresariais']) ? $landingImages['highlight_empresariais']->url : asset('images/camisas_empresariais.png') }}" class="product-img" alt="Camisas Empresariais">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Camisas Empresariais</h3>
                            <a href="{{ route('product.show', 'camisa-serigrafia-tradicional') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['highlight_uniformes']) ? $landingImages['highlight_uniformes']->url : asset('images/uniformes.png') }}" class="product-img" alt="Uniformes">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Uniformes</h3>
                            <a href="{{ route('product.show', 'camisa-sublimacao-esportiva') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                    <!-- Product 3 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['highlight_interclasse']) ? $landingImages['highlight_interclasse']->url : asset('images/interclasse.png') }}" class="product-img" alt="Interclasse">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Interclasse</h3>
                            <a href="{{ route('product.show', 'camisa-sublimacao-full-print-02') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                    <!-- Product 4 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['highlight_abadas']) ? $landingImages['highlight_abadas']->url : asset('images/abadas.png') }}" class="product-img" alt="Abadás">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Abadás</h3>
                            <a href="{{ route('product.show', 'camisa-sublimacao-full-print-exclusiva') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                    <!-- Product 5 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['category_ecobag']) ? $landingImages['category_ecobag']->url : asset('images/ecobag_mockup.png') }}" class="product-img" alt="Ecobags">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Ecobags</h3>
                            <a href="{{ route('product.show', 'camisa-sublimacao-full-print-exclusiva') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                    <!-- Product 6 -->
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ isset($landingImages['highlight_exclusivas']) ? $landingImages['highlight_exclusivas']->url : asset('images/camisas_exclusivas.png') }}" class="product-img" alt="Camisas Exclusivas">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">Camisas Exclusivas</h3>
                            <a href="{{ route('product.show', 'camisa-sublimacao-full-print-exclusiva') }}" class="btn-product-quote">Solicitar Orçamento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us section -->
    <section class="why-us">
        <div class="container">
            <div class="why-us-divider">
                <span>Por que escolher a Rumus?</span>
            </div>
            <div class="benefits-row">
                <!-- Benefit 1 -->
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <span class="benefit-title">Produção própria</span>
                </div>
                <!-- Benefit 2 -->
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <span class="benefit-title">Alta qualidade</span>
                </div>
                <!-- Benefit 3 -->
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                    </div>
                    <span class="benefit-title">Impressão profissional</span>
                </div>
                <!-- Benefit 4 -->
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M3 18v-6a9 9 0 0 1 18 0v6M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3"/></svg>
                    </div>
                    <span class="benefit-title">Atendimento rápido</span>
                </div>
                <!-- Benefit 5 -->
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <span class="benefit-title">Entrega para todo Brasil</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Work Gallery -->
    <section class="works-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title-gallery">TRABALHOS QUE VIRAM ORGULHO</h2>
            </div>
            
            <div class="works-grid">
                @if(isset($landingImages))
                    @foreach($landingImages->where('section', 'portfolio') as $img)
                        <div class="work-item">
                            <img src="{{ $img->url }}" class="work-img" alt="{{ $img->title }}">
                        </div>
                    @endforeach
                @else
                    <div class="work-item">
                        <img src="{{ asset('images/dtf_mockup.png') }}" class="work-img" alt="Camisa DTF Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/serigrafia_mockup.png') }}" class="work-img" alt="Camisa Serigrafia Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/sublimacao_mockup.png') }}" class="work-img" alt="Camisa Sublimação Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/camisas_exclusivas.png') }}" class="work-img" alt="Camisas Exclusivas Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/uniformes.png') }}" class="work-img" alt="Uniformes Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/ecobag_mockup.png') }}" class="work-img" alt="Ecobag Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/interclasse.png') }}" class="work-img" alt="Interclasse Rumus">
                    </div>
                    <div class="work-item">
                        <img src="{{ asset('images/abadas.png') }}" class="work-img" alt="Abadás Rumus">
                    </div>
                @endif
            </div>

            <div class="works-action">
                <a href="{{ $instagramUrl }}" target="_blank" class="btn-instagram-more">
                    <span>VER MAIS NO INSTAGRAM</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-instagram-icon"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials (Depoimentos) -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header-testimonials">
                <span class="testimonials-subtitle">QUEM JÁ FEZ, APROVA</span>
                <h2 class="testimonials-title">Depoimentos</h2>
            </div>

            <div class="testimonials-grid-wrapper">
                <div class="testimonials-grid">
                    <!-- Card 1 -->
                    <div class="testimonial-card">
                        <div>
                            <div class="stars">★★★★★</div>
                            <p class="testimonial-text">“Qualidade impecável! As camisetas ficaram incríveis e os clientes elogiaram bastante. Atendimento top do início ao fim.”</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">Lucas Andrade</span>
                            <span class="author-desc">Atibaia – UFGD</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="testimonial-card">
                        <div>
                            <div class="stars">★★★★★</div>
                            <p class="testimonial-text">“Trabalho incrível, superaram nossas expectativas. Estampas com cores vivas e ótimo caimento!”</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">Mariana Santos</span>
                            <span class="author-desc">Empresária – Uberlândia, MG</span>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="testimonial-card">
                        <div>
                            <div class="stars">★★★★★</div>
                            <p class="testimonial-text">“Já é a terceira vez que fazemos com a Rumus. Sempre pontuais e com muita qualidade!”</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">João Pedro</span>
                            <span class="author-desc">Bocas – Bombarral/PR</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonials-dots">
                <span class="testimonial-dot active" data-index="0"></span>
                <span class="testimonial-dot" data-index="1"></span>
                <span class="testimonial-dot" data-index="2"></span>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="faq-layout">
                <div class="faq-accordion-container">
                    <h2 class="faq-title-main">PERGUNTAS FREQUENTES</h2>
                    
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Qual o prazo de produção?</span>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>Nosso prazo médio de produção é de 7 a 15 dias úteis, variando de acordo com a quantidade e complexidade do pedido. O prazo exato será informado no momento do orçamento.</p>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Qual o pedido mínimo?</span>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>Nosso pedido mínimo varia por técnica: 10 peças para camisas personalizadas em DTF e sublimação, e 30 peças para serigrafia tradicional.</p>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Como envio minha arte?</span>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>Você pode enviar sua arte em formatos vetoriais (.AI, .CDR, .PDF) ou em alta resolução (.PNG, .JPG). Se precisar, nossa equipe de designers pode ajudar a finalizar seu layout.</p>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Quais formas de pagamento?</span>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content">
                            <p>Aceitamos pagamentos via Pix, transferência bancária e cartões de crédito. Facilitamos o pagamento em duas parcelas (50% no fechamento do pedido e 50% antes do envio).</p>
                        </div>
                    </div>
                </div>

                <!-- CTA card on the right -->
                <div class="faq-cta-card">
                    <h3 class="faq-cta-title">AINDA TEM DÚVIDAS?</h3>
                    <p class="faq-cta-desc">Fale com a gente pelo WhatsApp!</p>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn-whatsapp-cta">
                        <span>CHAMAR NO WHATSAPP</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="whatsapp-icon"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-about">
                    <div class="footer-logo">RUMUS</div>
                    <p>Transformamos ideias em marcas que vestem propósitos e viram orgulho.</p>
                    <div class="footer-socials">
                        <a href="{{ $instagramUrl }}" target="_blank" class="footer-social-icon" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="footer-social-icon" aria-label="WhatsApp">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h5>Institucional</h5>
                    <ul class="footer-links">
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#">Como funciona</a></li>
                        <li><a href="#">Depoimentos</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Produtos</h5>
                    <ul class="footer-links">
                        <li><a href="#serigrafia">Camisetas</a></li>
                        <li><a href="#sublimacao">Camisetas Sublimadas</a></li>
                        <li><a href="#dtf">Camisetas Longline</a></li>
                        <li><a href="#ecobags">Ecobags</a></li>
                        <li><a href="#">Outros</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Atendimento</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $whatsappUrl }}" target="_blank">WhatsApp</a></li>
                        <li><a href="#">Perguntas frequentes</a></li>
                        <li><a href="#">Trocas e devoluções</a></li>
                    </ul>
                </div>

                <div class="footer-col footer-col-last">
                    <h5>Fale com a gente</h5>
                    <ul class="footer-contact">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>(19) 99999-9999</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>atendimento@rumus.com.br</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            <span>@rumus.ink</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Enviamos para todo o Brasil</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 RUMUS. Todos os direitos reservados.</p>
                <p>Enviamos para todo Brasil</p>
            </div>
        </div>
    </footer>

    <!-- JS Logic for Accordions and Slides -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Toggle
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
                // Close menu when clicking a link
                navLinks.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navLinks.classList.remove('active');
                    });
                });
            }

            // Accordion Toggle
            const accordionHeaders = document.querySelectorAll('.accordion-header');
            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const item = header.parentElement;
                    
                    // Toggle active class
                    item.classList.toggle('active');
                    
                    // Close other items
                    document.querySelectorAll('.accordion-item').forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                });
            });

            // Simple Slider/Carousel Scroll for "Mais pedidos"
            const sliderWrapper = document.querySelector('.products-slider-wrapper');
            const btnPrev = document.getElementById('slide-prev');
            const btnNext = document.getElementById('slide-next');

            if (sliderWrapper && btnPrev && btnNext) {
                btnPrev.addEventListener('click', () => {
                    sliderWrapper.scrollBy({ left: -300, behavior: 'smooth' });
                });

                btnNext.addEventListener('click', () => {
                    sliderWrapper.scrollBy({ left: 300, behavior: 'smooth' });
                });
            }

            // Testimonials mobile slider dot highlight
            const testimonialsWrapper = document.querySelector('.testimonials-grid-wrapper');
            const testimonialDots = document.querySelectorAll('.testimonial-dot');
            if (testimonialsWrapper && testimonialDots.length > 0) {
                testimonialsWrapper.addEventListener('scroll', () => {
                    const width = testimonialsWrapper.clientWidth;
                    const scrollLeft = testimonialsWrapper.scrollLeft;
                    const index = Math.round(scrollLeft / width);
                    testimonialDots.forEach((dot, idx) => {
                        if (idx === index) {
                            dot.classList.add('active');
                        } else {
                            dot.classList.remove('active');
                        }
                    });
                });
                testimonialDots.forEach(dot => {
                    dot.addEventListener('click', () => {
                        const index = parseInt(dot.getAttribute('data-index'));
                        const width = testimonialsWrapper.clientWidth;
                        testimonialsWrapper.scrollTo({ left: index * width, behavior: 'smooth' });
                    });
                });
            }

            // Search Overlay Toggle
            const searchIcon = document.querySelector('.nav-icon-search');
            const searchOverlay = document.querySelector('.search-overlay');
            const searchClose = document.querySelector('.search-close-btn');

            if (searchIcon && searchOverlay && searchClose) {
                searchIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchOverlay.classList.add('active');
                    searchOverlay.querySelector('.search-input').focus();
                });

                searchClose.addEventListener('click', () => {
                    searchOverlay.classList.remove('active');
                });
            }

            // Cart Drawer Toggle
            const cartIcon = document.querySelector('.nav-icon-cart');
            const cartDrawer = document.querySelector('.cart-drawer');
            const cartOverlay = document.querySelector('.cart-drawer-overlay');
            const cartClose = document.querySelector('.cart-drawer-close');

            if (cartIcon && cartDrawer && cartOverlay && cartClose) {
                cartIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    cartDrawer.classList.add('active');
                    cartOverlay.classList.add('active');
                });

                const closeCart = () => {
                    cartDrawer.classList.remove('active');
                    cartOverlay.classList.remove('active');
                };

                cartClose.addEventListener('click', closeCart);
                cartOverlay.addEventListener('click', closeCart);
            }

            // Hero Banner Carousel
            const bannerImages = document.querySelectorAll('.hero-image-container img');
            if (bannerImages.length > 1) {
                let currentIndex = 0;
                setInterval(() => {
                    bannerImages[currentIndex].classList.remove('active');
                    currentIndex = (currentIndex + 1) % bannerImages.length;
                    bannerImages[currentIndex].classList.add('active');
                }, 4000);
            }
        });
    </script>

    <!-- Cart Drawer -->
    <div class="cart-drawer-overlay"></div>
    <div class="cart-drawer">
        <div class="cart-drawer-header">
            <h3>Seu Carrinho</h3>
            <button class="cart-drawer-close" aria-label="Fechar carrinho">&times;</button>
        </div>
        <div class="cart-drawer-body">
            <p class="empty-cart-msg">Seu carrinho está vazio.</p>
        </div>
        <div class="cart-drawer-footer">
            <a href="{{ $instagramUrl }}" target="_blank" class="btn-product-quote">Adicionar Itens</a>
        </div>
    </div>
</body>
</html>
