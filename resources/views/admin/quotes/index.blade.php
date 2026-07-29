@extends('admin.layouts.app')
@section('title', 'Gerenciador de Orçamentos')
@section('page-title', 'Orçamentos')

@section('content')
<style>
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .metric-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .metric-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .metric-value {
        font-size: 22px;
        font-weight: 800;
        color: #000000;
    }

    .period-btn {
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text-main);
        text-decoration: none;
        transition: all 0.2s;
    }

    .period-btn:hover,
    .period-btn.active {
        background: #000000;
        color: #ffffff;
        border-color: #000000;
    }

    @media (max-width: 768px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }
        .filter-flex {
            flex-direction: column;
            align-items: stretch !important;
        }
    }
</style>

<div style="display:flex; flex-direction:column; gap:20px; max-width:1200px; margin:0 auto;">

    {{-- Top Title & Actions Bar --}}
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div>
            <h2 style="font-size:20px; font-weight:800; color:#000;">Gerenciador de Orçamentos</h2>
            <p style="font-size:13px; color:var(--text-muted); margin-top:2px;">Histórico, valores totais e métricas de orçamento por período.</p>
        </div>
        <a href="{{ route('admin.quotes.create') }}" class="btn btn-primary" style="padding:10px 22px; font-size:14px; font-weight:700; display:inline-flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Novo Orçamento
        </a>
    </div>

    {{-- Cards de Métricas e Estatísticas --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="16" y1="14" x2="16" y2="18"/><path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 10h.01"/><path d="M12 14h.01"/><path d="M8 14h.01"/><path d="M12 18h.01"/><path d="M8 18h.01"/></svg>
            </div>
            <div>
                <div class="metric-title">Total de Orçamentos</div>
                <div class="metric-value">{{ $totalCount }}</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon" style="background:#ecfdf5; color:#059669;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <div class="metric-title">Valor Total Acumulado</div>
                <div class="metric-value">R$ {{ number_format($totalSum, 2, ',', '.') }}</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon" style="background:#eff6ff; color:#0284c7;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div class="metric-title">Ticket Médio por Orçamento</div>
                <div class="metric-value">R$ {{ number_format($averageValue, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Filtro de Período & Busca --}}
    <div class="card">
        <div class="card-body" style="padding:16px 20px;">
            <form method="GET" action="{{ route('admin.quotes.index') }}" class="filter-flex" style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
                
                {{-- Quick Period Buttons --}}
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <span style="font-size:12px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-right:4px;">Período:</span>
                    <a href="{{ route('admin.quotes.index', array_merge(request()->except(['period', 'start_date', 'end_date', 'page']), ['period' => 'all'])) }}" class="period-btn {{ $period === 'all' ? 'active' : '' }}">Todos</a>
                    <a href="{{ route('admin.quotes.index', array_merge(request()->except(['period', 'start_date', 'end_date', 'page']), ['period' => 'today'])) }}" class="period-btn {{ $period === 'today' ? 'active' : '' }}">Hoje</a>
                    <a href="{{ route('admin.quotes.index', array_merge(request()->except(['period', 'start_date', 'end_date', 'page']), ['period' => '7days'])) }}" class="period-btn {{ $period === '7days' ? 'active' : '' }}">7 Dias</a>
                    <a href="{{ route('admin.quotes.index', array_merge(request()->except(['period', 'start_date', 'end_date', 'page']), ['period' => 'this_month'])) }}" class="period-btn {{ $period === 'this_month' ? 'active' : '' }}">Este Mês</a>
                    <a href="{{ route('admin.quotes.index', array_merge(request()->except(['period', 'start_date', 'end_date', 'page']), ['period' => 'this_year'])) }}" class="period-btn {{ $period === 'this_year' ? 'active' : '' }}">Este Ano</a>
                </div>

                {{-- Search & Custom Date Form Inputs --}}
                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <div style="position:relative; min-width:200px;">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar cliente ou Nº..." style="padding-left:32px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>

                    <button type="submit" class="btn btn-secondary" style="padding:8px 16px; font-weight:700;">Filtrar</button>
                    @if(request()->hasAny(['q', 'period', 'status', 'start_date']))
                        <a href="{{ route('admin.quotes.index') }}" class="btn btn-outline" style="padding:8px 14px; font-size:13px;" title="Limpar Filtros">Limpar</a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- Tabela de Orçamentos --}}
    <div class="card">
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead>
                        <tr style="background:#f8f9fa;">
                            <th style="width:110px;">Nº ORÇ.</th>
                            <th style="width:110px;">DATA</th>
                            <th>CLIENTE</th>
                            <th>VENDEDOR</th>
                            <th style="text-align:right;">VALOR TOTAL</th>
                            <th style="text-align:center; width:120px;">STATUS</th>
                            <th style="text-align:center; width:160px;">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr>
                                <td style="font-weight:700; font-family:monospace; color:#000;">
                                    #{{ $quote->quote_number }}
                                </td>
                                <td style="font-size:13px; color:var(--text-muted);">
                                    {{ $quote->formatted_date }}
                                </td>
                                <td>
                                    <div style="font-weight:700; color:#111;">{{ $quote->client_name ?: 'Cliente não identificado' }}</div>
                                    @if($quote->client_contact)
                                        <div style="font-size:12px; color:var(--text-muted);">{{ $quote->client_contact }}</div>
                                    @endif
                                </td>
                                <td style="font-size:13px; font-weight:600;">
                                    {{ $quote->seller_name ?: '—' }}
                                </td>
                                <td style="text-align:right; font-weight:800; font-size:15px; color:#000;">
                                    {{ $quote->formatted_total }}
                                </td>
                                <td style="text-align:center;">
                                    <form method="POST" action="{{ route('admin.quotes.status', $quote->id) }}" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="badge {{ $quote->status_badge }}" style="border-radius:12px; padding:4px 10px; font-size:12px; font-weight:700; cursor:pointer; outline:none;">
                                            <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pendente</option>
                                            <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Aprovado</option>
                                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Recusado</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex; justify-content:center; gap:6px;">
                                        {{-- Ver / Reimprimir / PDF --}}
                                        <a href="{{ route('admin.quotes.print', $quote->id) }}" target="_blank" class="btn btn-secondary" style="padding:6px 10px; font-size:12px;" title="Ver / PDF">
                                            📄 PDF
                                        </a>
                                        {{-- Editar --}}
                                        <a href="{{ route('admin.quotes.edit', $quote->id) }}" class="btn btn-secondary" style="padding:6px 10px; font-size:12px;" title="Editar">
                                            ✏️
                                        </a>
                                        {{-- Excluir --}}
                                        <form method="POST" action="{{ route('admin.quotes.destroy', $quote->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este orçamento?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary" style="padding:6px 10px; font-size:12px; color:var(--danger);" title="Excluir">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:40px 20px;">
                                    <div style="font-size:15px; font-weight:700; color:var(--text-muted);">Nenhum orçamento encontrado.</div>
                                    <p style="font-size:13px; color:var(--text-muted); margin-top:4px;">Crie seu primeiro orçamento para começar a acompanhar suas vendas.</p>
                                    <a href="{{ route('admin.quotes.create') }}" class="btn btn-primary" style="margin-top:14px; padding:10px 20px; font-size:14px; display:inline-flex; align-items:center; gap:6px;">
                                        + Criar Orçamento
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if($quotes->hasPages())
                <div style="padding:16px 20px; border-top:1px solid var(--border);">
                    {{ $quotes->links('admin.pagination') }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
