@extends('admin.layouts.app')
@section('title', 'Gerador de Orçamento')
@section('page-title', 'Novo Orçamento')

@section('content')
<style>
    .quote-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 90px;
    }

    .quote-container input,
    .quote-container select,
    .quote-container textarea {
        font-size: 16px !important;
    }

    /* Mobile Sticky Bottom Bar */
    .mobile-sticky-bar {
        display: none;
        position: fixed;
        bottom: 60px;
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

    /* Responsive Table Styles for Items */
    @media (max-width: 768px) {
        .mobile-sticky-bar {
            display: flex;
        }
        .desktop-action-bar {
            display: none !important;
        }
        .quote-container {
            gap: 16px;
        }

        /* Convert Table into Cards on Mobile */
        .responsive-items-table, 
        .responsive-items-table tbody {
            display: block;
            width: 100%;
        }
        .responsive-items-table thead {
            display: none;
        }
        .responsive-items-table tr.item-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .responsive-items-table td {
            border: none !important;
            padding: 0 !important;
            display: flex;
            flex-direction: column;
        }
        .responsive-items-table td.td-desc {
            grid-column: 1 / -1;
        }
        .responsive-items-table td.td-qty {
            grid-column: 1;
        }
        .responsive-items-table td.td-price {
            grid-column: 2;
        }
        .responsive-items-table td.td-total {
            grid-column: 1;
            justify-content: center;
            font-weight: 800;
            color: #059669;
        }
        .responsive-items-table td.td-action {
            grid-column: 2;
            align-items: flex-end;
            justify-content: center;
        }
        .mobile-cell-label {
            display: block !important;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
    }

    .mobile-cell-label {
        display: none;
    }
</style>

<form action="{{ route('admin.quotes.store') }}" method="POST" target="_blank" enctype="multipart/form-data" id="quoteForm">
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
                <button type="button" class="btn btn-secondary" id="addItemBtn" style="padding:8px 16px; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    + Adicionar Item
                </button>
            </div>
            
            <div class="card-body" style="padding:16px;">
                <table class="table responsive-items-table" id="itemsTable" style="margin:0;">
                    <thead>
                        <tr style="background:#f8f9fa;">
                            <th style="width:110px; text-align:center;">QUANT.</th>
                            <th>DESCRIÇÃO DO PRODUTO / SERVIÇO</th>
                            <th style="width:150px; text-align:right;">PÇ UNIT. (R$)</th>
                            <th style="width:160px; text-align:right;">PÇ TOTAL (R$)</th>
                            <th style="width:50px; text-align:center;"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody">
                        <tr class="item-row">
                            <td class="td-qty">
                                <span class="mobile-cell-label">Quantidade</span>
                                <input type="number" step="any" min="0" inputmode="decimal" name="items[0][quantity]" class="form-control item-qty text-center" value="1" placeholder="1" required>
                            </td>
                            <td class="td-desc">
                                <span class="mobile-cell-label">Descrição do Produto/Serviço</span>
                                <input type="text" name="items[0][description]" class="form-control item-desc" placeholder="Ex: BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO" value="BASICA PP SUB-TOTAL COM GOLA PADRE + PUNHO" required>
                            </td>
                            <td class="td-price">
                                <span class="mobile-cell-label">Valor Unitário (R$)</span>
                                <input type="text" inputmode="decimal" name="items[0][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="45,00" required>
                            </td>
                            <td class="td-total" style="text-align:right; font-weight:700; vertical-align:middle;">
                                <span class="mobile-cell-label">Subtotal</span>
                                <span class="item-total-display" style="font-size:15px; font-weight:800; color:#059669;">R$ 45,00</span>
                            </td>
                            <td class="td-action" style="text-align:center; vertical-align:middle;">
                                <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:6px; padding:6px 12px; font-weight:bold; font-size:13px; cursor:pointer;" title="Remover item">✕ Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="background:#f8f9fa; border:1px solid var(--border); border-radius:8px; padding:16px; margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-weight:800; font-size:15px; text-transform:uppercase;">TOTAL GERAL:</span>
                    <span class="grandTotalDisplay" style="font-weight:900; font-size:22px; color:#000000;">R$ 45,00</span>
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

        {{-- Opções Avançadas --}}
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
    let itemIndex = 0;
    const tbody = document.getElementById('itemsTableBody');
    const addItemBtn = document.getElementById('addItemBtn');
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

    function calculateTotals() {
        let total = 0;
        const rows = tbody.querySelectorAll('.item-row');

        rows.forEach(row => {
            const qtyInput = row.querySelector('.item-qty');
            const priceInput = row.querySelector('.item-price');
            const totalDisplay = row.querySelector('.item-total-display');

            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseMoney(priceInput.value);
            const rowTotal = qty * price;

            total += rowTotal;

            if (totalDisplay) {
                totalDisplay.textContent = rowTotal > 0 ? formatMoney(rowTotal) : 'R$ -';
            }
        });

        grandTotalDisplays.forEach(el => {
            el.textContent = formatMoney(total);
        });
    }

    // Input listeners
    tbody.addEventListener('input', function (e) {
        if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
            calculateTotals();
        }
    });

    // Remove row
    tbody.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove-row')) {
            const rows = tbody.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            } else {
                alert('O orçamento precisa ter pelo menos um item.');
            }
        }
    });

    // Add row
    addItemBtn.addEventListener('click', function () {
        itemIndex++;
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td class="td-qty">
                <span class="mobile-cell-label">Quantidade</span>
                <input type="number" step="any" min="0" inputmode="decimal" name="items[${itemIndex}][quantity]" class="form-control item-qty text-center" value="1" placeholder="1" required>
            </td>
            <td class="td-desc">
                <span class="mobile-cell-label">Descrição do Produto/Serviço</span>
                <input type="text" name="items[${itemIndex}][description]" class="form-control item-desc" placeholder="Descrição do produto ou serviço" required>
            </td>
            <td class="td-price">
                <span class="mobile-cell-label">Valor Unitário (R$)</span>
                <input type="text" inputmode="decimal" name="items[${itemIndex}][unit_price]" class="form-control item-price text-right" placeholder="0,00" value="0,00" required>
            </td>
            <td class="td-total" style="text-align:right; font-weight:700; vertical-align:middle;">
                <span class="mobile-cell-label">Subtotal</span>
                <span class="item-total-display" style="font-size:15px; font-weight:800; color:#059669;">R$ -</span>
            </td>
            <td class="td-action" style="text-align:center; vertical-align:middle;">
                <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:6px; padding:6px 12px; font-weight:bold; font-size:13px; cursor:pointer;" title="Remover item">✕ Excluir</button>
            </td>
        `;
        tbody.appendChild(tr);
        calculateTotals();
    });

    calculateTotals();
});
</script>
@endpush
