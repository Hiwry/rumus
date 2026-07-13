<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos - RUMUS</title>
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

    <!-- Catalog Hero Section -->
    <section class="catalog-hero">
        <div class="container">
            <div class="catalog-hero-grid">
                <div class="catalog-hero-content">
                    <span class="catalog-hero-tag">Catálogo</span>
                    <h1 class="catalog-hero-title">Nossos produtos</h1>
                    <p class="catalog-hero-desc">Camisas personalizadas e ecobags com impressão de alta qualidade para transformar sua ideia em realidade.</p>
                </div>
                <div class="catalog-hero-img-container">
                    <img src="{{ asset('images/rumus_hero_model.png') }}" class="catalog-hero-img" alt="Camiseta RUMUS Mockup">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Layout Grid -->
    <main class="container">
        <div class="catalog-layout">
            
            <!-- Left Side Filters Sidebar -->
            <aside class="catalog-sidebar">
                
                <!-- Category Filter -->
                <div class="filter-section">
                    <h4 class="filter-title" onclick="toggleFilterCollapse(this)">
                        Categorias
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </h4>
                    <div class="filter-content">
                        <ul class="filter-category-list">
                            <li class="filter-category-item active" data-category-filter="all">
                                <a href="#">Todas <span class="category-count">12</span></a>
                            </li>
                            <li class="filter-category-item" data-category-filter="sublimacao">
                                <a href="#">Camisa Sublimação <span class="category-count">3</span></a>
                            </li>
                            <li class="filter-category-item" data-category-filter="serigrafia">
                                <a href="#">Camisa Serigrafia <span class="category-count">3</span></a>
                            </li>
                            <li class="filter-category-item" data-category-filter="dtf">
                                <a href="#">Camisa DTF <span class="category-count">3</span></a>
                            </li>
                            <li class="filter-category-item" data-category-filter="ecobag">
                                <a href="#">Ecobag <span class="category-count">3</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Product Type Filter -->
                <div class="filter-section">
                    <h4 class="filter-title" onclick="toggleFilterCollapse(this)">
                        Tipo de produto
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </h4>
                    <div class="filter-content">
                        <div class="filter-checkbox-list">
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="product_type" value="all" checked onchange="filterTypeChanged(this)">
                                Todas
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="product_type" value="unissex" onchange="filterTypeChanged(this)">
                                Unissex
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="product_type" value="masculino" onchange="filterTypeChanged(this)">
                                Masculino
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="product_type" value="feminino" onchange="filterTypeChanged(this)">
                                Feminino
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" name="product_type" value="infantil" onchange="filterTypeChanged(this)">
                                Infantil
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Size Filter -->
                <div class="filter-section">
                    <h4 class="filter-title" onclick="toggleFilterCollapse(this)">
                        Tamanho
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </h4>
                    <div class="filter-content">
                        <div class="filter-checkbox-list">
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="P" onchange="applyFilters()">
                                P
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="M" onchange="applyFilters()">
                                M
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="G" onchange="applyFilters()">
                                G
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="GG" onchange="applyFilters()">
                                GG
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="XG" onchange="applyFilters()">
                                XG
                            </label>
                            <label class="filter-checkbox-label">
                                <input type="checkbox" class="size-filter-checkbox" value="XGG" onchange="applyFilters()">
                                XGG
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Color Filter -->
                <div class="filter-section">
                    <h4 class="filter-title" onclick="toggleFilterCollapse(this)">
                        Cor
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </h4>
                    <div class="filter-content">
                        <div class="color-options-grid">
                            <button class="color-option-btn" style="background-color: #000000;" data-color="black" title="Preto" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #ffffff;" data-color="white" title="Branco" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #cccccc;" data-color="grey" title="Cinza" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #ff0000;" data-color="red" title="Vermelho" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #0000ff;" data-color="blue" title="Azul" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #008000;" data-color="green" title="Verde" onclick="toggleColorSelection(this)"></button>
                            <button class="color-option-btn" style="background-color: #800080;" data-color="purple" title="Roxo" onclick="toggleColorSelection(this)"></button>
                        </div>
                    </div>
                </div>

                <!-- Price Slider Filter -->
                <div class="filter-section">
                    <h4 class="filter-title" onclick="toggleFilterCollapse(this)">
                        Faixa de preço
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </h4>
                    <div class="filter-content">
                        <div class="price-range-container">
                            <div class="price-slider-values">
                                <span>R$ 19,90</span>
                                <span id="price-slider-max-display">R$ 89,90</span>
                            </div>
                            <input type="range" class="range-slider-input" min="19.90" max="89.90" step="1.00" value="89.90" id="price-slider-input" oninput="updatePriceSlider(this)">
                        </div>
                    </div>
                </div>

                <button class="btn-filter-apply" onclick="applyFilters()">Filtrar</button>

                <!-- Sidebar Custom CTA -->
                <div class="sidebar-cta-box">
                    <h5 class="sidebar-cta-title">Não encontrou o que procura?</h5>
                    <p class="sidebar-cta-desc">Fale com a gente e faça seu orçamento personalizado!</p>
                    <a href="{{ $whatsappUrl }}?text=Ol%C3%A1!%20Gostaria%20de%20um%20or%C3%A7amento%20personalizado." target="_blank" class="btn-sidebar-whatsapp">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        Chamar no WhatsApp
                    </a>
                </div>
            </aside>

            <!-- Right Side Products Output -->
            <section class="catalog-main">
                
                <!-- Main Header Control Bar -->
                <div class="catalog-main-topbar">
                    <div class="products-counter">
                        Mostrando <span id="products-count-start">1</span>–<span id="products-count-end">12</span> de <span id="products-total-count">12</span> produtos
                    </div>
                    <div class="catalog-controls">
                        <div class="sort-wrapper">
                            <select class="sort-select" id="sort-dropdown" onchange="sortDropdownChanged(this)">
                                <option value="mais-vendidos">Ordenar por: Mais vendidos</option>
                                <option value="menor-preco">Ordenar por: Menor preço</option>
                                <option value="maior-preco">Ordenar por: Maior preço</option>
                            </select>
                        </div>
                        <div class="layout-toggles">
                            <button class="layout-btn active" id="layout-grid-btn" onclick="toggleLayout('grid')" aria-label="Visualização em Grade">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            </button>
                            <button class="layout-btn" id="layout-list-btn" onclick="toggleLayout('list')" aria-label="Visualização em Lista">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Control Bar -->
                <div class="mobile-controls-bar">
                    <button class="mobile-control-btn" id="mobile-categories-btn" onclick="openMobileDrawer('categories')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Categorias
                    </button>
                    <button class="mobile-control-btn" id="mobile-filters-btn" onclick="openMobileDrawer('filters')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Filtros
                    </button>
                    <div class="mobile-sort-wrapper">
                        <select class="mobile-sort-select" id="mobile-sort-dropdown" onchange="sortDropdownChanged(this)">
                            <option value="mais-vendidos">Mais vendidos</option>
                            <option value="menor-preco">Menor preço</option>
                            <option value="maior-preco">Maior preço</option>
                        </select>
                    </div>
                </div>

                <!-- Products Catalog Grid Container -->
                <div class="catalog-grid" id="catalog-products-container">
                    @foreach($products as $prod)
                        <article class="catalog-product-card" 
                            data-slug="{{ $prod->slug }}"
                            data-category="{{ $prod->category }}"
                            data-price="{{ $prod->price }}"
                            data-type="{{ $prod->type }}"
                            data-sizes="{{ implode(',', $prod->sizes ?? []) }}"
                            data-colors="{{ implode(',', $prod->colors ?? []) }}"
                            data-name="{{ strtolower($prod->name) }}"
                            data-tag="{{ $prod->tag }}">
                            
                            @if(!empty($prod->tag))
                                <span class="card-badge">{{ $prod->tag }}</span>
                            @endif

                            <div class="card-img-wrapper">
                                <a href="{{ route('product.show', $prod->slug) }}" class="product-img-link" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                    <img src="{{ asset(($prod->images ?? [])[0] ?? 'images/sublimacao_mockup.png') }}" alt="{{ $prod->name }}" class="card-img">
                                </a>
                            </div>

                            <div class="card-info">
                                <div class="card-details-group">
                                    <span class="card-category-tag">{{ ucfirst($prod->category) }}</span>
                                    <h3 class="card-title">
                                        <a href="{{ route('product.show', $prod->slug) }}">{{ $prod->name }}</a>
                                    </h3>
                                    <div class="card-price-row">
                                        <span class="price-label">A partir de</span>
                                        <span class="price-amount">R$ {{ number_format($prod->price, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="card-actions-group">
                                    <div class="card-actions">
                                        <a href="{{ $whatsappUrl }}?text=Ol%C3%A1!%20Gostaria%20de%20um%20or%C3%A7amento%20para%20o%20produto%3A%20{{ rawurlencode($prod->name) }}" target="_blank" class="btn-card-quote">
                                            SOLICITE UM ORÇAMENTO
                                        </a>
                                        <a href="{{ $whatsappUrl }}?text=Ol%C3%A1!%20Gostaria%20de%20tirar%20d%C3%BAvidas%20sobre%20o%20produto%3A%20{{ rawurlencode($prod->name) }}" target="_blank" class="btn-card-whatsapp" aria-label="Falar sobre este produto no WhatsApp">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    <!-- Empty State Box -->
                    <div class="catalog-empty-state" id="catalog-empty-state">
                        <h4 class="empty-state-title">Nenhum produto encontrado</h4>
                        <p class="empty-state-desc">Experimente ajustar os filtros ou pesquisar por outro termo.</p>
                        <button class="btn-clear-filters" onclick="clearAllFilters()">Limpar todos os filtros</button>
                    </div>
                </div>

                <!-- Mobile Load More Button -->
                <button class="mobile-load-more-btn" onclick="alert('Todos os 12 produtos já estão carregados!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    Carregar mais produtos
                </button>

                <!-- Pagination (Realistic Visual) -->
                <div class="catalog-pagination">
                    <button class="page-btn active">1</button>
                    <button class="page-btn" onclick="alert('Esta é uma simulação de catálogo. Todas as 12 opções de produtos estão sendo mostradas na página 1.')">2</button>
                    <button class="page-btn" onclick="alert('Esta é uma simulação de catálogo. Todas as 12 opções de produtos estão sendo mostradas na página 1.')">3</button>
                    <button class="page-btn" onclick="alert('Esta é uma simulação de catálogo. Todas as 12 opções de produtos estão sendo mostradas na página 1.')">4</button>
                    <button class="page-btn" onclick="alert('Esta é uma simulação de catálogo. Todas as 12 opções de produtos estão sendo mostradas na página 1.')" aria-label="Próxima página">&gt;</button>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer Features / Benefit icons -->
    <section class="why-us" style="padding-top:4rem; border-top:1px solid #e9ecef;">
        <div class="container">
            <div class="why-us-divider">
                <span>Por que escolher a Rumus?</span>
            </div>
            <div class="benefits-row">
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <span class="benefit-title">Produção própria</span>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <span class="benefit-title">Alta qualidade</span>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                    </div>
                    <span class="benefit-title">Impressão profissional</span>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><path d="M3 18v-6a9 9 0 0 1 18 0v6M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3"/></svg>
                    </div>
                    <span class="benefit-title">Atendimento rápido</span>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon-wrapper">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <span class="benefit-title">Entrega para todo Brasil</span>
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
                        <li><a href="{{ route('product.catalog', ['categoria' => 'sublimacao']) }}">Camisa Sublimação</a></li>
                        <li><a href="{{ route('product.catalog', ['categoria' => 'serigrafia']) }}">Camisa Serigrafia</a></li>
                        <li><a href="{{ route('product.catalog', ['categoria' => 'dtf']) }}">Camisa DTF</a></li>
                        <li><a href="{{ route('product.catalog', ['categoria' => 'ecobag']) }}">Ecobag</a></li>
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
                            <span>(82) 99999-9999</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>contato@rumus.com.br</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            <span>@rumus.ink</span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contact-icon"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Maceió - AL</span>
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

    <!-- Cart Drawer & Search Logic Reused and Enhanced -->
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
            <a href="#" class="btn-card-quote" style="display:block; text-align:center;">Adicionar Itens</a>
        </div>
    </div>

    <!-- Categories Drawer Overlay for Mobile -->
    <div class="mobile-drawer-overlay" id="categories-drawer-overlay" onclick="closeMobileDrawers()"></div>
    <div class="mobile-drawer" id="categories-drawer">
        <div class="mobile-drawer-header">
            <h3>Categorias</h3>
            <button class="mobile-drawer-close" onclick="closeMobileDrawers()">&times;</button>
        </div>
        <div class="mobile-drawer-body">
            <ul class="mobile-drawer-list">
                <li class="mobile-drawer-item active" data-category-mobile="all" onclick="selectMobileCategory('all')">
                    <a href="#">Todas <span class="category-count">12</span></a>
                </li>
                <li class="mobile-drawer-item" data-category-mobile="sublimacao" onclick="selectMobileCategory('sublimacao')">
                    <a href="#">Camisa Sublimação <span class="category-count">3</span></a>
                </li>
                <li class="mobile-drawer-item" data-category-mobile="serigrafia" onclick="selectMobileCategory('serigrafia')">
                    <a href="#">Camisa Serigrafia <span class="category-count">3</span></a>
                </li>
                <li class="mobile-drawer-item" data-category-mobile="dtf" onclick="selectMobileCategory('dtf')">
                    <a href="#">Camisa DTF <span class="category-count">3</span></a>
                </li>
                <li class="mobile-drawer-item" data-category-mobile="ecobag" onclick="selectMobileCategory('ecobag')">
                    <a href="#">Ecobag <span class="category-count">3</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Filters Drawer Overlay for Mobile -->
    <div class="mobile-drawer-overlay" id="filters-drawer-overlay" onclick="closeMobileDrawers()"></div>
    <div class="mobile-drawer" id="filters-drawer">
        <div class="mobile-drawer-header">
            <h3>Filtros</h3>
            <button class="mobile-drawer-close" onclick="closeMobileDrawers()">&times;</button>
        </div>
        <div class="mobile-drawer-body">
            <!-- Product Type Filter -->
            <div class="filter-section">
                <h4 class="filter-title">Tipo de produto</h4>
                <div class="filter-checkbox-list">
                    <label class="filter-checkbox-label">
                        <input type="checkbox" name="product_type_mobile" value="all" checked onchange="filterTypeMobileChanged(this)">
                        Todas
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" name="product_type_mobile" value="unissex" onchange="filterTypeMobileChanged(this)">
                        Unissex
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" name="product_type_mobile" value="masculino" onchange="filterTypeMobileChanged(this)">
                        Masculino
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" name="product_type_mobile" value="feminino" onchange="filterTypeMobileChanged(this)">
                        Feminino
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" name="product_type_mobile" value="infantil" onchange="filterTypeMobileChanged(this)">
                        Infantil
                    </label>
                </div>
            </div>

            <!-- Size Filter -->
            <div class="filter-section">
                <h4 class="filter-title">Tamanho</h4>
                <div class="filter-checkbox-list">
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="P" onchange="sizeCheckboxChanged(this, true)">
                        P
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="M" onchange="sizeCheckboxChanged(this, true)">
                        M
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="G" onchange="sizeCheckboxChanged(this, true)">
                        G
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="GG" onchange="sizeCheckboxChanged(this, true)">
                        GG
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="XG" onchange="sizeCheckboxChanged(this, true)">
                        XG
                    </label>
                    <label class="filter-checkbox-label">
                        <input type="checkbox" class="size-filter-checkbox-mobile" value="XGG" onchange="sizeCheckboxChanged(this, true)">
                        XGG
                    </label>
                </div>
            </div>

            <!-- Color Filter -->
            <div class="filter-section">
                <h4 class="filter-title">Cor</h4>
                <div class="color-options-grid">
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #000000;" data-color="black" title="Preto" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #ffffff;" data-color="white" title="Branco" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #cccccc;" data-color="grey" title="Cinza" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #ff0000;" data-color="red" title="Vermelho" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #0000ff;" data-color="blue" title="Azul" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #008000;" data-color="green" title="Verde" onclick="toggleColorMobileSelection(this)"></button>
                    <button class="color-option-btn color-option-btn-mobile" style="background-color: #800080;" data-color="purple" title="Roxo" onclick="toggleColorMobileSelection(this)"></button>
                </div>
            </div>

            <!-- Price Slider Filter -->
            <div class="filter-section">
                <h4 class="filter-title">Faixa de preço</h4>
                <div class="price-range-container">
                    <div class="price-slider-values">
                        <span>R$ 19,90</span>
                        <span id="price-slider-max-display-mobile">R$ 89,90</span>
                    </div>
                    <input type="range" class="range-slider-input" min="19.90" max="89.90" step="1.00" value="89.90" id="price-slider-input-mobile" oninput="updatePriceSliderMobile(this)">
                </div>
            </div>

            <button class="btn-filter-apply" onclick="applyFilters(); closeMobileDrawers();">Aplicar Filtros</button>
        </div>
    </div>

    <script>
        // Store selected options
        let selectedCategory = 'all';
        let selectedTypes = [];
        let selectedSizes = [];
        let selectedColors = [];
        let maxPrice = 89.90;
        let searchQuery = '';
        let currentLayout = 'grid';

        document.addEventListener('DOMContentLoaded', () => {
            // Check query parameters
            const urlParams = new URLSearchParams(window.location.search);
            const categoryParam = urlParams.get('categoria');
            const searchParam = urlParams.get('busca');

            if (categoryParam) {
                setCategoryFilter(categoryParam);
            }
            if (searchParam) {
                searchQuery = searchParam.toLowerCase();
                const searchInputs = document.querySelectorAll('.search-input');
                searchInputs.forEach(input => input.value = searchParam);
            }

            // Bind filters and layouts
            initBaseUI();
            applyFilters();
        });

        function initBaseUI() {
            // Category sidebar selection click event
            const categoryItems = document.querySelectorAll('.filter-category-item');
            categoryItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    categoryItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                    selectedCategory = item.getAttribute('data-category-filter');
                    
                    // Sync to mobile list active state
                    const mobileItems = document.querySelectorAll('.mobile-drawer-item');
                    mobileItems.forEach(mi => {
                        mi.classList.remove('active');
                        if (mi.getAttribute('data-category-mobile') === selectedCategory) {
                            mi.classList.add('active');
                        }
                    });

                    applyFilters();
                });
            });

            // Mobile Menu Toggle
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            if (menuToggle && navLinks) {
                menuToggle.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }

            // Search Overlay Toggle
            const searchIcon = document.querySelector('.nav-icon-search');
            const searchOverlay = document.querySelector('.search-overlay');
            const searchClose = document.querySelector('.search-close-btn');
            const searchInput = document.querySelector('.search-overlay .search-input');

            if (searchIcon && searchOverlay && searchClose) {
                searchIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    searchOverlay.classList.add('active');
                    if (searchInput) searchInput.focus();
                });

                searchClose.addEventListener('click', () => {
                    searchOverlay.classList.remove('active');
                });

                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        searchQuery = e.target.value.trim().toLowerCase();
                        applyFilters();
                    });
                }
            }

            // Cart Drawer
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
        }

        // Set Category filter on startup & updates
        function setCategoryFilter(category) {
            const categoryItems = document.querySelectorAll('.filter-category-item');
            categoryItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-category-filter') === category) {
                    item.classList.add('active');
                    selectedCategory = category;
                }
            });
            // Sync mobile list
            const mobileItems = document.querySelectorAll('.mobile-drawer-item');
            mobileItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-category-mobile') === category) {
                    item.classList.add('active');
                }
            });
        }

        // Collapse filter groups
        function toggleFilterCollapse(element) {
            element.classList.toggle('collapsed');
            const content = element.nextElementSibling;
            if (content.style.maxHeight === '0px') {
                content.style.maxHeight = '500px';
            } else {
                content.style.maxHeight = '0px';
            }
        }

        // Checkbox type filters (Desktop)
        function filterTypeChanged(checkbox) {
            const checkboxes = document.getElementsByName('product_type');
            const mobileCheckboxes = document.getElementsByName('product_type_mobile');
            
            // Sync desktop status to mobile checkbox
            const matchedMobileCB = document.querySelector(`input[name="product_type_mobile"][value="${checkbox.value}"]`);
            if (matchedMobileCB) {
                matchedMobileCB.checked = checkbox.checked;
            }

            if (checkbox.value === 'all') {
                if (checkbox.checked) {
                    checkboxes.forEach(cb => {
                        if (cb.value !== 'all') cb.checked = false;
                    });
                    mobileCheckboxes.forEach(cb => {
                        if (cb.value !== 'all') cb.checked = false;
                    });
                    selectedTypes = [];
                }
            } else {
                document.querySelector('input[name="product_type"][value="all"]').checked = false;
                document.querySelector('input[name="product_type_mobile"][value="all"]').checked = false;
                
                selectedTypes = Array.from(checkboxes)
                    .filter(cb => cb.checked && cb.value !== 'all')
                    .map(cb => cb.value);
                
                if (selectedTypes.length === 0) {
                    document.querySelector('input[name="product_type"][value="all"]').checked = true;
                    document.querySelector('input[name="product_type_mobile"][value="all"]').checked = true;
                }
            }
            applyFilters();
        }

        // Checkbox type filters (Mobile)
        function filterTypeMobileChanged(checkbox) {
            const checkboxes = document.getElementsByName('product_type_mobile');
            const desktopCheckboxes = document.getElementsByName('product_type');
            
            // Sync mobile status to desktop checkbox
            const matchedDesktopCB = document.querySelector(`input[name="product_type"][value="${checkbox.value}"]`);
            if (matchedDesktopCB) {
                matchedDesktopCB.checked = checkbox.checked;
            }

            if (checkbox.value === 'all') {
                if (checkbox.checked) {
                    checkboxes.forEach(cb => {
                        if (cb.value !== 'all') cb.checked = false;
                    });
                    desktopCheckboxes.forEach(cb => {
                        if (cb.value !== 'all') cb.checked = false;
                    });
                    selectedTypes = [];
                }
            } else {
                document.querySelector('input[name="product_type_mobile"][value="all"]').checked = false;
                document.querySelector('input[name="product_type"][value="all"]').checked = false;
                
                selectedTypes = Array.from(checkboxes)
                    .filter(cb => cb.checked && cb.value !== 'all')
                    .map(cb => cb.value);
                
                if (selectedTypes.length === 0) {
                    document.querySelector('input[name="product_type_mobile"][value="all"]').checked = true;
                    document.querySelector('input[name="product_type"][value="all"]').checked = true;
                }
            }
            applyFilters();
        }

        // Toggle selected colors (Desktop)
        function toggleColorSelection(btn) {
            btn.classList.toggle('selected');
            const color = btn.getAttribute('data-color');
            
            // Sync to mobile color button
            const mobileBtn = document.querySelector(`.color-option-btn-mobile[data-color="${color}"]`);
            if (mobileBtn) {
                mobileBtn.classList.toggle('selected', btn.classList.contains('selected'));
            }

            if (btn.classList.contains('selected')) {
                if (!selectedColors.includes(color)) selectedColors.push(color);
            } else {
                selectedColors = selectedColors.filter(c => c !== color);
            }
            applyFilters();
        }

        // Toggle selected colors (Mobile)
        function toggleColorMobileSelection(btn) {
            btn.classList.toggle('selected');
            const color = btn.getAttribute('data-color');
            
            // Sync to desktop color button
            const desktopBtn = document.querySelector(`.color-option-btn[data-color="${color}"]`);
            if (desktopBtn) {
                desktopBtn.classList.toggle('selected', btn.classList.contains('selected'));
            }

            if (btn.classList.contains('selected')) {
                if (!selectedColors.includes(color)) selectedColors.push(color);
            } else {
                selectedColors = selectedColors.filter(c => c !== color);
            }
            applyFilters();
        }

        // Price range slider (Desktop)
        function updatePriceSlider(slider) {
            maxPrice = parseFloat(slider.value);
            document.getElementById('price-slider-max-display').innerText = `R$ ${maxPrice.toFixed(2).replace('.', ',')}`;
            // Sync mobile price slider
            const mobileSlider = document.getElementById('price-slider-input-mobile');
            if (mobileSlider) {
                mobileSlider.value = slider.value;
                document.getElementById('price-slider-max-display-mobile').innerText = `R$ ${maxPrice.toFixed(2).replace('.', ',')}`;
            }
            applyFilters();
        }

        // Price range slider (Mobile)
        function updatePriceSliderMobile(slider) {
            maxPrice = parseFloat(slider.value);
            document.getElementById('price-slider-max-display-mobile').innerText = `R$ ${maxPrice.toFixed(2).replace('.', ',')}`;
            // Sync desktop price slider
            const desktopSlider = document.getElementById('price-slider-input');
            if (desktopSlider) {
                desktopSlider.value = slider.value;
                document.getElementById('price-slider-max-display').innerText = `R$ ${maxPrice.toFixed(2).replace('.', ',')}`;
            }
            applyFilters();
        }

        // Bidirectional Size Checkboxes Sync
        function sizeCheckboxChanged(checkbox, isMobile) {
            const value = checkbox.value;
            const targetSelector = isMobile ? `.size-filter-checkbox[value="${value}"]` : `.size-filter-checkbox-mobile[value="${value}"]`;
            const targetCB = document.querySelector(targetSelector);
            if (targetCB) {
                targetCB.checked = checkbox.checked;
            }
            applyFilters();
        }

        // Clear all filters btn
        function clearAllFilters() {
            // Reset categories
            setCategoryFilter('all');

            // Reset checkboxes
            const checkboxes = document.getElementsByName('product_type');
            const mobileCheckboxes = document.getElementsByName('product_type_mobile');
            checkboxes.forEach(cb => cb.checked = cb.value === 'all');
            mobileCheckboxes.forEach(cb => cb.checked = cb.value === 'all');
            selectedTypes = [];

            const sizeCheckboxes = document.querySelectorAll('.size-filter-checkbox, .size-filter-checkbox-mobile');
            sizeCheckboxes.forEach(cb => cb.checked = false);
            selectedSizes = [];

            // Reset colors
            const colorBtns = document.querySelectorAll('.color-option-btn, .color-option-btn-mobile');
            colorBtns.forEach(btn => btn.classList.remove('selected'));
            selectedColors = [];

            // Reset price slider
            const slider = document.getElementById('price-slider-input');
            slider.value = 89.90;
            updatePriceSlider(slider);

            // Reset search
            searchQuery = '';
            const searchInputs = document.querySelectorAll('.search-input');
            searchInputs.forEach(input => input.value = '');

            applyFilters();
        }

        // Toggle Layout: Grid vs List
        function toggleLayout(type) {
            const container = document.getElementById('catalog-products-container');
            const gridBtn = document.getElementById('layout-grid-btn');
            const listBtn = document.getElementById('layout-list-btn');

            currentLayout = type;

            if (type === 'grid') {
                container.classList.remove('list-view');
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
            } else {
                container.classList.add('list-view');
                gridBtn.classList.remove('active');
                listBtn.classList.add('active');
            }
        }

        // Sort items dynamically
        function sortDropdownChanged(select) {
            const container = document.getElementById('catalog-products-container');
            const cards = Array.from(container.querySelectorAll('.catalog-product-card'));
            const sortVal = select.value;

            // Sync sort values across dropdowns (desktop & mobile)
            const desktopSort = document.getElementById('sort-dropdown');
            const mobileSort = document.getElementById('mobile-sort-dropdown');
            if (desktopSort && desktopSort.value !== sortVal) desktopSort.value = sortVal;
            if (mobileSort && mobileSort.value !== sortVal) mobileSort.value = sortVal;

            cards.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price'));
                const priceB = parseFloat(b.getAttribute('data-price'));
                const isBestSellerA = a.getAttribute('data-tag') === 'MAIS VENDIDO' ? 1 : 0;
                const isBestSellerB = b.getAttribute('data-tag') === 'MAIS VENDIDO' ? 1 : 0;

                if (sortVal === 'menor-preco') {
                    return priceA - priceB;
                } else if (sortVal === 'maior-preco') {
                    return priceB - priceA;
                } else { // default or 'mais-vendidos'
                    return isBestSellerB - isBestSellerA || priceB - priceA;
                }
            });

            // Re-append cards to DOM in sorted order
            cards.forEach(card => {
                container.appendChild(card);
            });
        }

        // Mobile Drawers Toggle
        function openMobileDrawer(drawerId) {
            document.getElementById(`${drawerId}-drawer-overlay`).classList.add('active');
            document.getElementById(`${drawerId}-drawer`).classList.add('active');
        }

        // Mobile Category Selection Handler
        function selectMobileCategory(category) {
            setCategoryFilter(category);
            applyFilters();
            closeMobileDrawers();
        }

        function closeMobileDrawers() {
            document.querySelectorAll('.mobile-drawer-overlay, .mobile-drawer').forEach(el => {
                el.classList.remove('active');
            });
        }

        // Main filter execution logic
        function applyFilters() {
            const container = document.getElementById('catalog-products-container');
            const cards = container.querySelectorAll('.catalog-product-card');
            const emptyState = document.getElementById('catalog-empty-state');
            
            // Collect sizes checkbox inputs
            const sizeCheckboxes = document.querySelectorAll('.size-filter-checkbox');
            selectedSizes = Array.from(sizeCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

            let visibleCount = 0;

            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                const cardPrice = parseFloat(card.getAttribute('data-price'));
                const cardType = card.getAttribute('data-type');
                const cardSizes = card.getAttribute('data-sizes').split(',');
                const cardColors = card.getAttribute('data-colors').split(',');
                const cardName = card.getAttribute('data-name');

                let matchesCategory = (selectedCategory === 'all' || cardCat === selectedCategory);
                let matchesType = (selectedTypes.length === 0 || selectedTypes.includes(cardType));
                
                let matchesSize = true;
                if (selectedSizes.length > 0) {
                    matchesSize = cardSizes.some(s => selectedSizes.includes(s));
                }

                let matchesColor = true;
                if (selectedColors.length > 0) {
                    matchesColor = cardColors.some(c => selectedColors.includes(c));
                }

                let matchesPrice = (cardPrice <= maxPrice);
                
                let matchesSearch = true;
                if (searchQuery.length > 0) {
                    matchesSearch = cardName.includes(searchQuery);
                }

                if (matchesCategory && matchesType && matchesSize && matchesColor && matchesPrice && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update COUNTERS
            const totalProducts = {{ count($products) }};
            document.getElementById('products-count-start').innerText = visibleCount > 0 ? 1 : 0;
            document.getElementById('products-count-end').innerText = visibleCount;
            document.getElementById('products-total-count').innerText = totalProducts;

            // Empty state display
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
    </script>
</body>
</html>
