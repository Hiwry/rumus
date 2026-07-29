@extends('admin.layouts.app')
@section('title', 'Editar Orçamento #' . $quote->quote_number)
@section('page-title', 'Editar Orçamento')

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

    .desktop-table-wrap { display: block; }
    .mobile-items-wrap { display: none; }

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

    .mobile-item-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px;
        margin-bottom: 12px;
        position: relative;
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

    @media (max-width: 768px) {
        .desktop-table-wrap { display: none; }
        .mobile-items-wrap { display: block; }
        .mobile-sticky-bar { display: flex; }
        .desktop-action-bar { display: none !important; }
    }
</style>

<form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST" enctype="multipart/form-data" id="quoteForm">
    @csrf
    @method('PUT')

    <div class="quote-container">
        
        {{-- Desktop Header Bar --}}
        <div class="desktop-action-bar" style="display:flex; justify-content:space-between; align-items:center; background:#fff; padding:16px 24px; border-radius:8px; border:1px solid var(--border); box-shadow:var(--shadow-sm);">
            <div>
                <h2 style="font-size:18px; font-weight:700; color:var(--text-main);">Editar Orçamento #{{ $quote->quote_number }}</h2>
                <p style="font-size:13px; color:var(--text-muted); margin-top:2px;">Altere as informações do orçamento e salve as atualizações.</p>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.quotes.print', $quote->id) }}" target="_blank" class="btn btn-secondary" style="padding:10px 18px; font-size:14px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                    📄 Ver PDF / Imprimir
                </a>
                <button type="submit" class="btn btn-primary" style="padding:10px 24px; font-size:14px; font-weight:700; display:inline-flex; align-items:center; gap:8px;">
                    Salvar Alterações
                </button>
            </div>
        </div>

        {{-- Status Card --}}
        <div class="card">
            <div class="card-header" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                <span class="card-title">Status do Orçamento</span>
            </div>
            <div class="card-body">
                <div class="form-group" style="margin:0; max-width:300px;">
                    <label class="form-label">Status Atual</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Aprovado pelo Cliente</option>
                        <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Recusado pelo Cliente</option>
                    </select>
                </div>
            </div>
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
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $quote->client_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contato / Telefone</label>
                        <input type="tel" name="client_contact" class="form-control" value="{{ old('client_contact', $quote->client_contact) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="client_address" class="form-control" value="{{ old('client_address', $quote->client_address) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="client_email" class="form-control" value="{{ old('client_email', $quote->client_email) }}">
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Referente</label>
                        <input type="text" name="referent" class="form-control" value="{{ old('referent', $quote->referent) }}">
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
                            @php $itemsList = $quote->items ?? []; @endphp
                            @forelse($itemsList as $idx => $item)
                                <tr class="item-row-desktop">
                                    <td>
                                        <input type="number" step="any" min="0" inputmode="decimal" name="items[{{ $idx }}][quantity]" class="form-control item-qty text-center" value="{{ $item['quantity'] ?? '1' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $idx }}][description]" class="form-control item-desc" value="{{ $item['description'] ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" inputmode="decimal" name="items[{{ $idx }}][unit_price]" class="form-control item-price text-right" value="{{ $item['unit_price'] ?? '0,00' }}">
                                    </td>
                                    <td style="text-align:right; font-weight:700; vertical-align:middle;">
                                        <span class="item-total-display">{{ $item['total_price'] ?? 'R$ -' }}</span>
                                    </td>
                                    <td style="text-align:center; vertical-align:middle;">
                                        <button type="button" class="btn-remove-row" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:18px; padding:4px;" title="Remover item">✕</button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="item-row-desktop">
                                    <td><input type="number" step="any" min="0" inputmode="decimal" name="items[0][quantity]" class="form-control item-qty text-center" value="1"></td>
                                    <td><input type="text" name="items[0][description]" class="form-control item-desc" placeholder="Descrição do item"></td>
                                    <td><input type="text" inputmode="decimal" name="items[0][unit_price]" class="form-control item-price text-right" value="0,00"></td>
                                    <td style="text-align:right; font-weight:700; vertical-align:middle;"><span class="item-total-display">R$ -</span></td>
                                    <td style="text-align:center; vertical-align:middle;"><button type="button" class="btn-remove-row" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:18px; padding:4px;">✕</button></td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr style="background:#fafafa; border-top:2px solid var(--border);">
                                <td colspan="3" style="text-align:right; font-weight:800; font-size:15px; text-transform:uppercase; padding:16px;">TOTAL GERAL:</td>
                                <td style="text-align:right; font-weight:900; font-size:18px; color:var(--primary); padding:16px;">
                                    <span class="grandTotalDisplay">{{ $quote->formatted_total }}</span>
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
                    @forelse($itemsList as $idx => $item)
                        <div class="mobile-item-card item-row-mobile">
                            <div class="mobile-item-card-header">
                                <span class="mobile-item-num">Item #{{ $idx + 1 }}</span>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="mobile-item-subtotal item-total-display">{{ $item['total_price'] ?? 'R$ -' }}</span>
                                    <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:4px; padding:4px 8px; font-weight:bold; font-size:12px;">✕ Excluir</button>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:10px;">
                                <label class="form-label">Descrição do Produto/Serviço</label>
                                <input type="text" name="items[{{ $idx }}][description]" class="form-control item-desc" value="{{ $item['description'] ?? '' }}">
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Quantidade</label>
                                    <input type="number" step="any" min="0" inputmode="decimal" name="items[{{ $idx }}][quantity]" class="form-control item-qty text-center" value="{{ $item['quantity'] ?? '1' }}">
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <label class="form-label">Valor Unit. (R$)</label>
                                    <input type="text" inputmode="decimal" name="items[{{ $idx }}][unit_price]" class="form-control item-price text-right" value="{{ $item['unit_price'] ?? '0,00' }}">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="mobile-item-card item-row-mobile">
                            <div class="mobile-item-card-header">
                                <span class="mobile-item-num">Item #1</span>
                                <button type="button" class="btn-remove-row" style="background:#fee2e2; color:#dc2626; border:none; border-radius:4px; padding:4px 8px; font-weight:bold; font-size:12px;">✕ Excluir</button>
                            </div>
                            <div class="form-group"><input type="text" name="items[0][description]" class="form-control item-desc"></div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                <div class="form-group"><input type="number" step="any" min="0" inputmode="decimal" name="items[0][quantity]" class="form-control item-qty text-center" value="1"></div>
                                <div class="form-group"><input type="text" inputmode="decimal" name="items[0][unit_price]" class="form-control item-price text-right" value="0,00"></div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" class="btn btn-secondary addItemBtn" style="width:100%; padding:12px; font-size:14px; font-weight:700; margin-top:8px; display:flex; justify-content:center; align-items:center; gap:6px;">
                    + Adicionar Outro Item
                </button>

                <div style="background:#f8f9fa; border:1px solid var(--border); border-radius:8px; padding:14px; margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-weight:800; font-size:14px; text-transform:uppercase;">TOTAL GERAL:</span>
                    <span class="grandTotalDisplay" style="font-weight:900; font-size:20px; color:#000000;">{{ $quote->formatted_total }}</span>
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
                        <input type="text" name="seller_name" class="form-control" value="{{ old('seller_name', $quote->seller_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">WhatsApp Vendedor</label>
                        <input type="tel" name="seller_whatsapp" class="form-control" value="{{ old('seller_whatsapp', $quote->seller_whatsapp) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prazo de Entrega</label>
                        <input type="text" name="delivery_time" class="form-control" value="{{ old('delivery_time', $quote->delivery_time) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label">Observações de Pagamento (Texto Vermelho)</label>
                    <textarea name="observations" rows="3" class="form-control">{{ old('observations', $quote->observations) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Opções Avançadas --}}
        <details class="card" style="cursor:pointer;">
            <summary class="card-header" style="display:flex; align-items:center; justify-content:space-between; user-select:none;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path></svg>
                    <span class="card-title">4. Credenciais da Empresa e Responsável</span>
                </div>
                <span style="font-size:12px; color:var(--text-muted); font-weight:700;">Toque para expandir ▼</span>
            </summary>
            <div class="card-body" style="border-top:1px solid var(--border);">
                <div class="grid grid-3">
                    <div class="form-group">
                        <label class="form-label">Nº Orçamento</label>
                        <input type="text" name="quote_number" class="form-control" value="{{ old('quote_number', $quote->quote_number) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data</label>
                        <input type="date" name="quote_date" class="form-control" value="{{ old('quote_date', $quote->quote_date ? $quote->quote_date->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Validade</label>
                        <input type="text" name="validity" class="form-control" value="{{ old('validity', $quote->validity) }}">
                    </div>
                </div>

                <div class="grid grid-2" style="margin-top:10px;">
                    <div class="form-group">
                        <label class="form-label">Nome Responsável (Assinatura)</label>
                        <input type="text" name="signer_name" class="form-control" value="{{ old('signer_name', $quote->signer_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cargo do Responsável</label>
                        <input type="text" name="signer_role" class="form-control" value="{{ old('signer_role', $quote->signer_role) }}">
                    </div>
                </div>

                <div class="grid grid-3" style="margin-top:10px;">
                    <div class="form-group">
                        <label class="form-label">Razão Social</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $quote->company_name) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">CNPJ</label>
                        <input type="text" name="company_cnpj" class="form-control" value="{{ old('company_cnpj', $quote->company_cnpj) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Inscrição Estadual</label>
                        <input type="text" name="company_ie" class="form-control" value="{{ old('company_ie', $quote->company_ie) }}">
                    </div>
                </div>
            </div>
        </details>

        {{-- Main Submit Button Desktop --}}
        <div class="desktop-action-bar" style="display:flex; justify-content:flex-end; gap:12px; margin-top:10px;">
            <button type="submit" class="btn btn-primary" style="padding:14px 36px; font-size:16px; font-weight:700; display:inline-flex; align-items:center; gap:10px;">
                Salvar Alterações
            </button>
        </div>

    </div>

    {{-- Mobile Sticky Bottom Bar --}}
    <div class="mobile-sticky-bar">
        <div class="mobile-sticky-total">
            <span class="label">Total Geral</span>
            <span class="val grandTotalDisplay">{{ $quote->formatted_total }}</span>
        </div>
        <button type="submit" class="mobile-btn-print">
            Salvar Alterações
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = {{ count($quote->items ?? [1]) }};

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
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            const mobileCards = mobileContainer.querySelectorAll('.item-row-mobile');
            mobileCards.forEach((card) => {
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
            desktopRows.forEach((row) => {
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

    document.getElementById('quoteForm').addEventListener('input', function (e) {
        if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
            syncAndCalculate();
        }
    });

    document.querySelectorAll('.addItemBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            itemIndex++;

            const tr = document.createElement('tr');
            tr.className = 'item-row-desktop';
            tr.innerHTML = `
                <td><input type="number" step="any" min="0" inputmode="decimal" name="items[${itemIndex}][quantity]" class="form-control item-qty text-center" value="1"></td>
                <td><input type="text" name="items[${itemIndex}][description]" class="form-control item-desc" placeholder="Descrição do item"></td>
                <td><input type="text" inputmode="decimal" name="items[${itemIndex}][unit_price]" class="form-control item-price text-right" value="0,00"></td>
                <td style="text-align:right; font-weight:700; vertical-align:middle;"><span class="item-total-display">R$ -</span></td>
                <td style="text-align:center; vertical-align:middle;"><button type="button" class="btn-remove-row" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:18px; padding:4px;">✕</button></td>
            `;
            desktopTbody.appendChild(tr);

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
                <div class="form-group"><input type="text" name="items[${itemIndex}][description]" class="form-control item-desc" placeholder="Descrição do item"></div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="form-group"><input type="number" step="any" min="0" inputmode="decimal" name="items[${itemIndex}][quantity]" class="form-control item-qty text-center" value="1"></div>
                    <div class="form-group"><input type="text" inputmode="decimal" name="items[${itemIndex}][unit_price]" class="form-control item-price text-right" value="0,00"></div>
                </div>
            `;
            mobileContainer.appendChild(card);

            syncAndCalculate();
        });
    });

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
