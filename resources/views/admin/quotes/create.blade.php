@extends('admin.layouts.app')
@section('title', 'Gerador de Orçamento')
@section('page-title', 'Novo Orçamento')

@section('content')
<style>
    /* Mobile-First Custom Styles for Budget Generator */
    .quote-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 90px; /* Space for mobile sticky bottom bar */
    }

    /* Prevent iOS auto-zoom on input focus */
    .quote-container input,
    .quote-container select,
    .quote-container textarea {
        font-size: 16px !important;
    }

    /* Desktop / Mobile view toggles */
    .desktop-table-wrap {
        display: block;
    }
    .mobile-items-wrap {
        display: none;
    }

    /* Mobile Sticky Bottom Action Bar */
    .mobile-sticky-bar {
        display: none;
        position: fixed;
        bottom: 60px; /* Above bottom nav */
        left: 0;
        right: 0;
        background: #111111;
        color: #ffffff;
        padding: 12px 16px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
        z-index: 160;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .mobile-sticky-total {
        display: flex;
        flex-direction: column;
    }

    .mobile-sticky-total .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9ca3af;
        font-weight: 700;
    }

    .mobile-sticky-total .val {
        font-size: 18px;
        font-weight: 800;
        color: #4ade80;
    }

    .mobile-btn-print {
        background: #000000;
        color: #fff;
        border: none;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    /* Mobile Item Card */
    .mobile-item-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px;
        margin-bottom: 12px;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .mobile-item-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
    }

    .mobile-item-num {
        font-weight: 800;
        font-size: 13px;
        color: var(--text-main);
        text-transform: uppercase;
    }

    .mobile-item-subtotal {
        font-size: 13px;
        font-weight: 700;
        color: #059669;
        background: #ecfdf5;
        padding: 2px 8px;
        border-radius: 4px;
    }

    /* Responsive Breakpoints */
    @media (max-width: 768px) {
        .desktop-table-wrap {
            display: none;
        }
        .mobile-items-wrap {
            display: block;
        }
        .mobile-sticky-bar {
            display: flex;
        }
        .quote-container {
            gap: 16px;
        }
        .desktop-action-bar {
            display: none !important;
        }
    }
</style>

<form action="{{ route('admin.quotes.print') }}" method="POST" target="_blank" enctype="multipart/form-data" id="quoteForm">
    @csrf

    <div class="quote-container">
        
        {{-- Desktop Header Bar --}}
        <div class="desktop-action-bar" style="display:flex; justify-content:space-between; align-items:center; background:#fff; padding:16px 24px; border-radius:8px; border:1px solid var(--border); box-shadow:var(--shadow-sm);">
            <div>
                <h2 style="font-size:18px; font-weight:700; color:var(--text-main);">Gerador de Orçamento</h2>
                <p style="font-size:13px; color:var(--text-muted); margin-top:2px;">Cálculo automático de itens e layout pronto para impressão A4 / PDF.</p>
            </div>
            <button type="submit" class="btn btn-primary" style="padding:12px 28px; font-size:15px; font-weight:700; display:inline-flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Gerar / Imprimir Orçamento
            </button>
        </div>

        {{-- Dados do Cliente --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span class="card-title">1. Dados do Cliente</span>
            </div>
            <div class="card-body">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Cliente</label>
                        <input type="text" name="client_name" class="form-control" placeholder="Nome do Cliente ou Empresa" value="{{ old('client_name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contato / Telefone</label>
                        <input type="tel" name="client_contact" class="form-control" placeholder="(82) 99999-9999" value="{{ old('client_contact') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="client_address" class="form-control" placeholder="Rua, Número, Bairro" value="{{ old('client_address') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="client_email" class="form-control" placeholder="cliente@email.com" value="{{ old('client_email') }}">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Referente</label>
                        <input type="text" name="referent" class="form-control" value="{{ old('referent', 'ORÇAMENTO') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Itens do Orçamento --}}
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <span class="card-title">2. Itens do Orçamento</span>
                </div>
                <button type="button" class="btn btn-secondary addItemBtn" style="padding:8px 14px; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    + Item
                </button>
            </div>
            
            {{-- DESKTOP TABLE VIEW --}}
            <div class="card-body desktop-table-wrap" style="padding:0;">
                <div class="table-responsive">
                    <table class="table" id="itemsTable" style="margin:0;">
                        <thead>
                            <tr style="background:#f8f9fa;">
                                <th style="width:110px; text-align:center;">QUANT.</th>
                                <th>DESCRIÇÃO DO PRODUTO / SERVIÇO</th>
                                <th style="width:150px; text-align:right;">PÇ UNIT. (R$)</th>
                                <th style="width:160px; text-align:right;">PÇ TOTAL (R$)</th>
                                <th style="width:50px; text-align:center;"></th>
                            </tr>
                        </thead>
                        <tbody id="desktopTableBody">
                            <tr class="item-row-desktop">
                                <td>
                                    <input type="number" step="any" min="0" inputmode="decimal" name="items[0][quantity]" class="form-control item-qty text-center" value="1" placeholder="1">
                                </td>
                                <td>
                                    <input type="text" name="items[0][description]" class="form-control item-desc" placeholder="Ex: BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO" value="BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO">
                                </td>
                                <td>
                                    <input type="text" inputmode="decimal" name="items[0][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="45,00">
                                </td>
                                <td style="text-align:right; font-weight:700; vertical-align:middle;">
                                    <span class="item-total-display">R$ 45,00</span>
                                </td>
                                <td style="text-align:center; vertical-align:middle;">
                                    <button type="button" class="btn-remove-row" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:18px; padding:4px;" title="Remover item">✕</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="background:#fafafa; border-top:2px solid var(--border);">
                                <td colspan="3" style="text-align:right; font-weight:800; font-size:15px; text-transform:uppercase; padding:16px;">TOTAL GERAL:</td>
                                <td style="text-align:right; font-weight:900; font-size:18px; color:var(--primary); padding:16px;">
                                    <span class="grandTotalDisplay">R$ 45,00</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- MOBILE CARDS VIEW --}}
            <div class="card-body mobile-items-wrap" style="padding:12px;">
                <div id="mobileItemsContainer">
                    <div class="mobile-item-card item-row-mobile">
                        <div class="mobile-item-card-header">
                            <span class="mobile-item-num">Item #1</span>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="mobile-item-subtotal item-total-display">R$ 45,00</span>
                                <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:4px; padding:4px 8px; font-weight:bold; font-size:12px;">✕ Excluir</button>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:10px;">
                            <label class="form-label">Descrição do Produto/Serviço</label>
                            <input type="text" name="items[0][description]" class="form-control item-desc" placeholder="Ex: BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO" value="BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO">
                        </div>

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Quantidade</label>
                                <input type="number" step="any" min="0" inputmode="decimal" name="items[0][quantity]" class="form-control item-qty text-center" value="1" placeholder="1">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Valor Unit. (R$)</label>
                                <input type="text" inputmode="decimal" name="items[0][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="45,00">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary addItemBtn" style="width:100%; padding:12px; font-size:14px; font-weight:700; margin-top:8px; display:flex; justify-content:center; align-items:center; gap:6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Adicionar Outro Item
                </button>

                <div style="background:#f8f9fa; border:1px solid var(--border); border-radius:8px; padding:14px; margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-weight:800; font-size:14px; text-transform:uppercase;">TOTAL GERAL:</span>
                    <span class="grandTotalDisplay" style="font-weight:900; font-size:20px; color:#000000;">R$ 45,00</span>
                </div>
            </div>

        </div>

        {{-- Condições Comerciais --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span class="card-title">3. Vendedor, Entrega & Observações</span>
            </div>
            <div class="card-body">
                <div class="grid grid-3">
                    <div class="form-group">
                        <label class="form-label">Vendedor</label>
                        <input type="text" name="seller_name" class="form-control" value="{{ old('seller_name', $defaults['seller_name']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp Vendedor</label>
                        <input type="tel" name="seller_whatsapp" class="form-control" value="{{ old('seller_whatsapp', $defaults['seller_whatsapp']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prazo de Entrega</label>
                        <input type="text" name="delivery_time" class="form-control" value="{{ old('delivery_time', $defaults['delivery_time']) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label">Observações de Pagamento (Texto Vermelho)</label>
                    <textarea name="observations" rows="3" class="form-control">{{ old('observations', $defaults['observations']) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Opções Avançadas / Empresa (Accordion sanfona fácil no celular) --}}
        <details class="card" style="cursor:pointer;">
            <summary class="card-header" style="display:flex; align-items:center; justify-content:space-between; user-select:none;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path></svg>
                    <span class="card-title">4. Alterar Nº Orçamento, Validade, Assinatura e Imagens (Opcional)</span>
                </div>
                <span style="font-size:12px; color:var(--text-muted); font-weight:700;">Toque para expandir ▼</span>
            </summary>
            <div class="card-body" style="border-top:1px solid var(--border);">
                <div class="grid grid-3">
                    <div class="form-group">
                        <label class="form-label">Nº Orçamento</label>
                        <input type="text" name="quote_number" class="form-control" value="{{ old('quote_number', $defaults['quote_number']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data</label>
                        <input type="date" name="quote_date" class="form-control" value="{{ old('quote_date', $defaults['quote_date']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Validade</label>
                        <input type="text" name="validity" class="form-control" value="{{ old('validity', $defaults['validity']) }}">
                    </div>
                </div>

                <div class="grid grid-2" style="margin-top:10px;">
                    <div class="form-group">
                        <label class="form-label">Nome Responsável (Assinatura)</label>
                        <input type="text" name="signer_name" class="form-control" value="{{ old('signer_name', $defaults['signer_name']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cargo do Responsável</label>
                        <input type="text" name="signer_role" class="form-control" value="{{ old('signer_role', $defaults['signer_role']) }}">
                    </div>
                </div>

                <div class="grid grid-3" style="margin-top:10px;">
                    <div class="form-group">
                        <label class="form-label">Razão Social</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $defaults['company_name']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">CNPJ</label>
                        <input type="text" name="company_cnpj" class="form-control" value="{{ old('company_cnpj', $defaults['company_cnpj']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Inscrição Estadual</label>
                        <input type="text" name="company_ie" class="form-control" value="{{ old('company_ie', $defaults['company_ie']) }}">
                    </div>
                </div>

                <div class="grid grid-3" style="margin-top:10px; padding-top:10px; border-top:1px solid var(--border);">
                    <div class="form-group">
                        <label class="form-label">Trocar Logo (Neste Orçamento)</label>
                        <input type="file" name="custom_logo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Trocar Carimbo (Neste Orçamento)</label>
                        <input type="file" name="custom_stamp" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Trocar Assinatura (Neste Orçamento)</label>
                        <input type="file" name="custom_signature" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </details>

        {{-- Main Submit Button Desktop --}}
        <div class="desktop-action-bar" style="display:flex; justify-content:flex-end; margin-top:10px;">
            <button type="submit" class="btn btn-primary" style="padding:14px 36px; font-size:16px; font-weight:700; display:inline-flex; align-items:center; gap:10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Gerar / Imprimir Orçamento
            </button>
        </div>

    </div>

    {{-- Mobile Sticky Bottom Bar --}}
    <div class="mobile-sticky-bar">
        <div class="mobile-sticky-total">
            <span class="label">Total Geral</span>
            <span class="val grandTotalDisplay">R$ 45,00</span>
        </div>
        <button type="submit" class="mobile-btn-print">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Gerar Orçamento
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = 1;

    const desktopTbody = document.getElementById('desktopTableBody');
    const mobileContainer = document.getElementById('mobileItemsContainer');
    const grandTotalDisplays = document.querySelectorAll('.grandTotalDisplay');

    function parseMoney(val) {
        if (!val) return 0;
        let clean = val.toString().replace(/[^\d.,]/g, '');
        if (clean.indexOf(',') !== -1 && clean.indexOf('.') !== -1) {
            clean = clean.replace(/\./g, '').replace(',', '.');
        } else if (clean.indexOf(',') !== -1) {
            clean = clean.replace(',', '.');
        }
        return parseFloat(clean) || 0;
    }

    function formatMoney(num) {
        return 'R$ ' + num.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function syncAndCalculate() {
        let total = 0;

        // Check if screen is mobile
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            const mobileCards = mobileContainer.querySelectorAll('.item-row-mobile');
            mobileCards.forEach((card, idx) => {
                const qtyInput = card.querySelector('.item-qty');
                const priceInput = card.querySelector('.item-price');
                const totalDisplay = card.querySelector('.item-total-display');

                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseMoney(priceInput.value);
                const rowTotal = qty * price;
                total += rowTotal;

                totalDisplay.textContent = rowTotal > 0 ? formatMoney(rowTotal) : 'R$ -';
            });
        } else {
            const desktopRows = desktopTbody.querySelectorAll('.item-row-desktop');
            desktopRows.forEach((row, idx) => {
                const qtyInput = row.querySelector('.item-qty');
                const priceInput = row.querySelector('.item-price');
                const totalDisplay = row.querySelector('.item-total-display');

                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseMoney(priceInput.value);
                const rowTotal = qty * price;
                total += rowTotal;

                totalDisplay.textContent = rowTotal > 0 ? formatMoney(rowTotal) : 'R$ -';
            });
        }

        grandTotalDisplays.forEach(el => {
            el.textContent = formatMoney(total);
        });
    }

    // Input listener for calculations
    document.getElementById('quoteForm').addEventListener('input', function (e) {
        if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
            syncAndCalculate();
        }
    });

    // Add item handler
    document.querySelectorAll('.addItemBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            itemIndex++;

            // Add Desktop Row
            const tr = document.createElement('tr');
            tr.className = 'item-row-desktop';
            tr.innerHTML = `
                <td>
                    <input type="number" step="any" min="0" inputmode="decimal" name="items[${itemIndex}][quantity]" class="form-control item-qty text-center" value="1" placeholder="1">
                </td>
                <td>
                    <input type="text" name="items[${itemIndex}][description]" class="form-control item-desc" placeholder="Descrição do produto ou serviço">
                </td>
                <td>
                    <input type="text" inputmode="decimal" name="items[${itemIndex}][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="0,00">
                </td>
                <td style="text-align:right; font-weight:700; vertical-align:middle;">
                    <span class="item-total-display">R$ -</span>
                </td>
                <td style="text-align:center; vertical-align:middle;">
                    <button type="button" class="btn-remove-row" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:18px; padding:4px;" title="Remover item">✕</button>
                </td>
            `;
            desktopTbody.appendChild(tr);

            // Add Mobile Card
            const card = document.createElement('div');
            card.className = 'mobile-item-card item-row-mobile';
            const count = mobileContainer.querySelectorAll('.item-row-mobile').length + 1;
            card.innerHTML = `
                <div class="mobile-item-card-header">
                    <span class="mobile-item-num">Item #${count}</span>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="mobile-item-subtotal item-total-display">R$ -</span>
                        <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:4px; padding:4px 8px; font-weight:bold; font-size:12px;">✕ Excluir</button>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:10px;">
                    <label class="form-label">Descrição do Produto/Serviço</label>
                    <input type="text" name="items[${itemIndex}][description]" class="form-control item-desc" placeholder="Descrição do produto ou serviço">
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Quantidade</label>
                        <input type="number" step="any" min="0" inputmode="decimal" name="items[${itemIndex}][quantity]" class="form-control item-qty text-center" value="1" placeholder="1">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Valor Unit. (R$)</label>
                        <input type="text" inputmode="decimal" name="items[${itemIndex}][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="0,00">
                    </div>
                </div>
            `;
            mobileContainer.appendChild(card);

            syncAndCalculate();
        });
    });

    // Remove item handler
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-row')) {
            const desktopRows = desktopTbody.querySelectorAll('.item-row-desktop');
            const mobileCards = mobileContainer.querySelectorAll('.item-row-mobile');

            if (desktopRows.length > 1 || mobileCards.length > 1) {
                const targetRow = e.target.closest('.item-row-desktop, .item-row-mobile');
                if (targetRow) {
                    targetRow.remove();
                    syncAndCalculate();
                }
            } else {
                alert('O orçamento precisa ter pelo menos 1 item.');
            }
        }
    });

    syncAndCalculate();
});
</script>
@endpush
