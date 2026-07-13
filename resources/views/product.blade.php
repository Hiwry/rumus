<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - RUMUS</title>
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

    <!-- Main Product Page Wrapper -->
    <main class="product-page-wrapper">
        <div class="container">
            <div class="product-main-grid">
                
                <!-- Left Column: Gallery -->
                <div class="product-gallery">
                    <div class="thumbnail-list">
                        @foreach($product->images as $index => $img)
                            <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" data-src="{{ asset($img) }}">
                                <img src="{{ asset($img) }}" alt="Miniatura {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="main-image-display">
                        <img id="main-product-image" src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Right Column: Product Details Panel -->
                <div class="product-details-panel">
                    @if(isset($product->tag))
                        <span class="product-badge">{{ $product->tag }}</span>
                    @endif
                    <h1 class="product-page-title">{{ $product->name }}</h1>
                    
                    <div class="product-rating-row">
                        <div class="stars-rating">
                            @for($i = 0; $i < $product->rating; $i++)
                                <span>★</span>
                            @endfor
                        </div>
                        <span class="reviews-text">({{ $product->reviews_count }} avaliações)</span>
                    </div>

                    <p class="product-page-description">{{ $product->description }}</p>

                    <div class="product-price-section">
                        <div class="price-value">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                        <div class="price-installments">ou 3x de R$ {{ number_format($product->price / 3, 2, ',', '.') }} sem juros</div>
                    </div>

                    <!-- Selection Options -->
                    <div class="options-container">
                        
                        <!-- Neck selection -->
                        <div class="option-group">
                            <span class="option-label">Tipo de gola</span>
                            <div class="neck-selector">
                                <button type="button" class="neck-btn active" data-value="Careca">Gola Careca</button>
                                <button type="button" class="neck-btn" data-value="V">Gola V</button>
                            </div>
                        </div>

                        <!-- Size selection -->
                        <div class="option-group">
                            <span class="option-label">Tamanho</span>
                            <div class="size-selector">
                                <button type="button" class="size-btn active" data-value="P">P</button>
                                <button type="button" class="size-btn" data-value="M">M</button>
                                <button type="button" class="size-btn" data-value="G">G</button>
                                <button type="button" class="size-btn" data-value="GG">GG</button>
                                <button type="button" class="size-btn" data-value="XG">XG</button>
                                <button type="button" class="size-btn" data-value="XGG">XGG</button>
                            </div>
                        </div>

                        <!-- Size Summary box -->
                        <div class="size-summary-box">
                            <strong>Resumo dos tamanhos</strong>
                            <p>P: veste 36-38 | M: 40 | G: 42 | GG: 44 | XG: 46 | XGG: 48-50</p>
                        </div>

                        <!-- Quantity Selector and Action Buttons -->
                        <div class="purchase-actions">
                            <div class="quantity-wrapper">
                                <span class="option-label">Quantidade</span>
                                <div class="quantity-stepper">
                                    <button type="button" class="qty-btn" id="qty-dec">-</button>
                                    <input type="number" id="qty-input" value="1" min="1">
                                    <button type="button" class="qty-btn" id="qty-inc">+</button>
                                </div>
                            </div>

                            <div class="action-buttons-group">
                                <button type="button" id="btn-add-to-cart" class="btn-action-cart">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px; vertical-align: middle;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                    ADICIONAR AO CARRINHO
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Tab Info Section (Description, Specs, Cares) -->
            <div class="product-info-tabs">
                
                <!-- Tab: Description -->
                <div class="info-tab-col">
                    <h3 class="tab-title">DESCRIÇÃO</h3>
                    <ul class="check-list">
                        @foreach($product->bullets as $bullet)
                            <li>
                                <svg class="check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>{{ $bullet }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tab: Specifications -->
                <div class="info-tab-col">
                    <h3 class="tab-title">ESPECIFICAÇÕES</h3>
                    <table class="specs-table">
                        <tbody>
                            @foreach($product->specs as $label => $val)
                                <tr>
                                    <td class="spec-label">{{ $label }}</td>
                                    <td class="spec-val">{{ $val }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tab: Cares -->
                <div class="info-tab-col">
                    <h3 class="tab-title">CUIDADOS</h3>
                    <ul class="care-list">
                        @foreach($product->cares as $index => $care)
                            <li>
                                <div class="care-icon-wrapper">
                                    @if($index === 0)
                                        <!-- Washing machine/hand icon -->
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22a7 7 0 0 0 7-7H5a7 7 0 0 0 7 7zM2 10h20v2H2zM5 10l1-5h12l1 5"/></svg>
                                    @elseif($index === 1)
                                        <!-- No bleach (triangle with cross) -->
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 22 20 2 20"/><line x1="8" y1="9" x2="16" y2="17"/><line x1="16" y1="9" x2="8" y2="17"/></svg>
                                    @elseif($index === 2)
                                        <!-- Do not soak (tub icon) -->
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22a7 7 0 0 0 7-7H5a7 7 0 0 0 7 7zM2 10h20v2H2z"/></svg>
                                    @else
                                        <!-- Dry in shade (shade/sun icon) -->
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    @endif
                                </div>
                                <span>{{ $care }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <!-- Related Products Section -->
            <section class="related-products-section">
                <h2 class="related-section-title">PRODUTOS RELACIONADOS</h2>
                <div class="related-grid">
                    @foreach($related as $rel)
                        <div class="related-product-card">
                            <a href="{{ route('product.show', $rel['slug']) }}" class="related-product-link">
                                <div class="related-img-wrapper">
                                    <img src="{{ asset($rel['images'][0]) }}" class="related-img" alt="{{ $rel['name'] }}">
                                </div>
                                <div class="related-info">
                                    <h3 class="related-title">{{ $rel['name'] }}</h3>
                                    <div class="related-price">R$ {{ number_format($rel['price'], 2, ',', '.') }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </main>

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
                        <li><a href="{{ url('/') }}">Sobre nós</a></li>
                        <li><a href="{{ url('/') }}">Como funciona</a></li>
                        <li><a href="{{ url('/') }}">Depoimentos</a></li>
                        <li><a href="{{ url('/') }}">Contato</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Produtos</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/#serigrafia') }}">Camisetas</a></li>
                        <li><a href="{{ url('/#sublimacao') }}">Camisetas Sublimadas</a></li>
                        <li><a href="{{ url('/#dtf') }}">Camisetas Longline</a></li>
                        <li><a href="{{ url('/#ecobags') }}">Ecobags</a></li>
                        <li><a href="{{ url('/') }}">Outros</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Atendimento</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $whatsappUrl }}" target="_blank">WhatsApp</a></li>
                        <li><a href="{{ url('/') }}">Perguntas frequentes</a></li>
                        <li><a href="{{ url('/') }}">Trocas e devoluções</a></li>
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

    <!-- JS Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

            // Cart Drawer Toggle and Shopping Cart Logic
            const cartIcon = document.querySelector('.nav-icon-cart');
            const cartDrawer = document.querySelector('.cart-drawer');
            const cartOverlay = document.querySelector('.cart-drawer-overlay');
            const cartClose = document.querySelector('.cart-drawer-close');
            const cartBadge = document.querySelector('.cart-badge');
            const cartDrawerBody = document.querySelector('.cart-drawer-body');
            const cartDrawerFooter = document.querySelector('.cart-drawer-footer');

            const getCart = () => {
                try {
                    return JSON.parse(localStorage.getItem('rumus_cart')) || [];
                } catch (e) {
                    return [];
                }
            };

            const saveCart = (cart) => {
                localStorage.setItem('rumus_cart', JSON.stringify(cart));
            };

            const updateCartBadge = () => {
                const cart = getCart();
                const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
                if (cartBadge) {
                    cartBadge.textContent = totalQty;
                }
            };

            const removeCartItem = (index) => {
                const cart = getCart();
                cart.splice(index, 1);
                saveCart(cart);
                updateCartBadge();
                renderCartDrawer();
            };

            const closeCart = () => {
                cartDrawer?.classList.remove('active');
                cartOverlay?.classList.remove('active');
            };

            const openCart = () => {
                cartDrawer?.classList.add('active');
                cartOverlay?.classList.add('active');
            };

            const renderCartDrawer = () => {
                const cart = getCart();
                if (!cartDrawerBody) return;

                if (cart.length === 0) {
                    cartDrawerBody.innerHTML = '<p class="empty-cart-msg">Seu carrinho está vazio.</p>';
                    if (cartDrawerFooter) {
                        cartDrawerFooter.innerHTML = '<button type="button" class="btn-product-quote cart-drawer-close-link" style="width: 100%; border: 1.5px solid #000; padding: 0.8rem; text-align: center; font-weight: bold; background: #fff; cursor: pointer;">Adicionar Itens</button>';
                        cartDrawerFooter.querySelector('.cart-drawer-close-link')?.addEventListener('click', (e) => {
                            e.preventDefault();
                            closeCart();
                        });
                    }
                    return;
                }

                let html = '<div class="cart-items-list">';
                let total = 0;

                cart.forEach((item, index) => {
                    const price = parseFloat(item.price) || 0;
                    const itemTotal = price * item.qty;
                    total += itemTotal;

                    html += `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                            <div class="cart-item-info">
                                <h4 class="cart-item-title">${item.name}</h4>
                                <p class="cart-item-options">Gola: ${item.gola} | Tam: ${item.size}</p>
                                <div class="cart-item-price-qty">
                                    <span class="cart-item-qty">${item.qty}x</span>
                                    <span class="cart-item-price">R$ ${price.toFixed(2).replace('.', ',')}</span>
                                </div>
                            </div>
                            <button type="button" class="btn-remove-cart-item" data-index="${index}">&times;</button>
                        </div>
                    `;
                });

                html += '</div>';
                cartDrawerBody.innerHTML = html;

                // Add event listeners for removal
                document.querySelectorAll('.btn-remove-cart-item').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const index = parseInt(btn.getAttribute('data-index'));
                        removeCartItem(index);
                    });
                });

                // Update footer with total price and a checkout/WhatsApp button
                if (cartDrawerFooter) {
                    const whatsappMsg = getCartWhatsappMessage(cart, total);
                    cartDrawerFooter.innerHTML = `
                        <div class="cart-total-row">
                            <span>Total:</span>
                            <strong>R$ ${total.toFixed(2).replace('.', ',')}</strong>
                        </div>
                        <a href="{{ $siteSettings['whatsapp_url'] ?? 'https://wa.me/5582999999999' }}?text=${encodeURIComponent(whatsappMsg)}" target="_blank" class="btn-action-primary" style="margin-top: 1rem; width: 100%; text-align: center; display: block; text-decoration: none;">
                            FINALIZAR PEDIDO NO WHATSAPP
                        </a>
                    `;
                }
            };

            const getCartWhatsappMessage = (cart, total) => {
                let msg = "Olá! Gostaria de fazer o pedido dos seguintes itens do meu carrinho:\n\n";
                cart.forEach((item, index) => {
                    msg += `*${index + 1}. ${item.name}*\n`;
                    msg += `• Gola: ${item.gola}\n`;
                    msg += `• Tamanho: ${item.size}\n`;
                    msg += `• Quantidade: ${item.qty}x\n`;
                    msg += `• Valor unitário: R$ ${parseFloat(item.price).toFixed(2).replace('.', ',')}\n\n`;
                });
                msg += `*Total do Pedido: R$ ${total.toFixed(2).replace('.', ',')}*\n\n`;
                msg += "Como procedemos para o fechamento do pedido?";
                return msg;
            };

            if (cartIcon && cartDrawer && cartOverlay && cartClose) {
                cartIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    openCart();
                });

                cartClose.addEventListener('click', closeCart);
                cartOverlay.addEventListener('click', closeCart);
            }

            // Product Gallery Interactive switching
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            const mainImage = document.getElementById('main-product-image');
            
            thumbnails.forEach(thumb => {
                const switchImage = () => {
                    const newSrc = thumb.getAttribute('data-src');
                    if (mainImage && newSrc) {
                        mainImage.src = newSrc;
                        // Update active state
                        thumbnails.forEach(t => t.classList.remove('active'));
                        thumb.classList.add('active');
                    }
                };

                thumb.addEventListener('click', switchImage);
                thumb.addEventListener('mouseenter', switchImage);
            });

            // Option Selectors (Neck and Size)
            const neckButtons = document.querySelectorAll('.neck-btn');
            neckButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    neckButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                });
            });

            const sizeButtons = document.querySelectorAll('.size-btn');
            sizeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                });
            });

            // Quantity Stepper
            const qtyInput = document.getElementById('qty-input');
            const qtyDec = document.getElementById('qty-dec');
            const qtyInc = document.getElementById('qty-inc');

            if (qtyInput && qtyDec && qtyInc) {
                qtyDec.addEventListener('click', () => {
                    let currentVal = parseInt(qtyInput.value) || 1;
                    if (currentVal > 1) {
                        qtyInput.value = currentVal - 1;
                    }
                });

                qtyInc.addEventListener('click', () => {
                    let currentVal = parseInt(qtyInput.value) || 1;
                    qtyInput.value = currentVal + 1;
                });

                qtyInput.addEventListener('change', () => {
                    let currentVal = parseInt(qtyInput.value);
                    if (isNaN(currentVal) || currentVal < 1) {
                        qtyInput.value = 1;
                    }
                });
            }

            // Quote and Art WhatsApp helper
            const whatsappBaseUrl = "{{ config('services.whatsapp.url') }}";
            const productName = "{{ $product->name }}";

            const getSelectedDetails = () => {
                const activeNeck = document.querySelector('.neck-btn.active')?.getAttribute('data-value') || 'Careca';
                const activeSize = document.querySelector('.size-btn.active')?.getAttribute('data-value') || 'P';
                const quantity = qtyInput?.value || '1';
                return { activeNeck, activeSize, quantity };
            };


            // Add to Cart Button Click
            const addToCartBtn = document.getElementById('btn-add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', () => {
                    const { activeNeck, activeSize, quantity } = getSelectedDetails();
                    const qty = parseInt(quantity) || 1;
                    const item = {
                        name: productName,
                        price: {{ $product->price }},
                        image: "{{ asset($product->images[0]) }}",
                        gola: activeNeck,
                        size: activeSize,
                        qty: qty
                    };

                    const cart = getCart();
                    // Check if identical item already in cart
                    const existingIndex = cart.findIndex(i => i.name === item.name && i.gola === item.gola && i.size === item.size);
                    if (existingIndex > -1) {
                        cart[existingIndex].qty += qty;
                    } else {
                        cart.push(item);
                    }

                    saveCart(cart);
                    updateCartBadge();
                    renderCartDrawer();
                    openCart();
                });
            }

            // Initialize Cart UI
            updateCartBadge();
            renderCartDrawer();
        });
    </script>
</body>
</html>
