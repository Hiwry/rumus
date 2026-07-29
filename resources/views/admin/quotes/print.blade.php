<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento Nº {{ $data['quote_number'] ?? '001' }} — {{ $data['client_name'] ?? 'Cliente' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Calibri:wght@400;700&family=Arial:wght@400;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, 'Helvetica Neue', sans-serif;
            color: #000;
            background: #eef1f5;
            padding: 20px 0;
            font-size: 14px;
            line-height: 1.3;
        }

        .page-container {
            width: 210mm;
            height: 285mm;
            max-height: 285mm;
            background: #ffffff;
            margin: 0 auto;
            padding: 8mm 12mm;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        /* ── Action Bar for Print ────────────────────────────────────────── */
        .print-actions {
            width: 210mm;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-download {
            background: #16a34a;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-download:hover {
            background: #15803d;
        }

        .btn-print {
            background: #000000;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print:hover {
            background: #222222;
        }

        .btn-back {
            background: #f1f3f5;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px 18px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        /* ── Header ──────────────────────────────────────────────────────── */
        .header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .logo-box {
            width: 55%;
        }

        .logo-img {
            max-height: 110px;
            max-width: 340px;
            object-fit: contain;
            display: block;
            margin-bottom: 4px;
        }

        .banner-orcamento {
            background: #000000;
            color: #ffffff;
            font-size: 26px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 5px 12px;
            margin-top: 4px;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .company-box {
            width: 43%;
            text-align: right;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.35;
        }

        .company-name {
            font-size: 16px;
            font-weight: 800;
        }

        .header-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 800;
        }

        /* ── Client Details Box ─────────────────────────────────────────── */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 6px;
        }

        .details-table td {
            padding: 3px 6px;
            font-size: 13.5px;
            border-bottom: 1px dotted #000;
            vertical-align: bottom;
        }

        .details-label {
            font-weight: 800;
            width: 1%;
            white-space: nowrap;
            padding-right: 6px !important;
        }

        /* ── Main Items Table ────────────────────────────────────────────── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            flex-grow: 1;
        }

        .items-table th {
            border: 1px dotted #000;
            padding: 6px 8px;
            font-size: 13.5px;
            font-weight: 800;
            text-transform: uppercase;
            background: #ffffff;
        }

        .items-table td {
            border-left: 1px dotted #000;
            border-right: 1px dotted #000;
            border-bottom: 1px dotted #000;
            padding: 4px 8px;
            font-size: 13px;
            height: 24px;
            vertical-align: middle;
        }

        .col-qty { width: 10%; text-align: center; }
        .col-desc { width: 62%; text-align: left; }
        .col-unit { width: 14%; text-align: right; }
        .col-total { width: 14%; text-align: right; }

        /* ── Summary & Footer Info ──────────────────────────────────────── */
        .summary-row td {
            border-top: 1px dotted #000;
            border-bottom: 1px dotted #000;
            padding: 6px 8px;
            font-size: 13.5px;
            font-weight: 700;
        }

        .delivery-notice {
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            color: #006633;
            margin: 6px 0 8px 0;
            text-transform: uppercase;
        }

        .observations-box {
            color: #e00000;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* ── Footer Stamp & Signature ───────────────────────────────────── */
        .footer-grid {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 6px;
            padding-top: 6px;
            page-break-inside: avoid;
        }

        .stamp-col {
            width: 48%;
        }

        .stamp-title {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .stamp-img {
            max-height: 130px;
            max-width: 320px;
            object-fit: contain;
        }

        .signature-col {
            width: 48%;
            text-align: center;
        }

        .date-line {
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: right;
        }

        .signature-img {
            max-height: 75px;
            max-width: 260px;
            object-fit: contain;
            display: block;
            margin: 0 auto 4px auto;
        }

        .signer-name {
            font-size: 15px;
            font-weight: 800;
        }

        .signer-role {
            font-size: 12.5px;
            color: #333;
        }

        /* ── Print Media Query ───────────────────────────────────────────── */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .print-actions {
                display: none !important;
            }

            .page-container {
                width: 100%;
                min-height: 100vh;
                box-shadow: none;
                padding: 5mm 8mm;
                margin: 0;
            }

            @page {
                size: A4 portrait;
                margin: 5mm;
            }
        }
    </style>
</head>
<body>

    {{-- Printable Action Bar --}}
    <div class="print-actions">
        <a href="javascript:history.back()" class="btn-back">← Voltar</a>
        <div style="font-weight:bold; color:#000000; font-size:15px;">Orçamento Gerado com Sucesso!</div>
        <div style="display:flex; gap:10px;">
            <button type="button" id="downloadPdfBtn" class="btn-download">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Baixar PDF
            </button>
            <button type="button" onclick="window.print()" class="btn-print">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Imprimir
            </button>
        </div>
    </div>

    <div class="page-container">

        <div>
            {{-- Header Block --}}
            <div class="header-wrap">
                <div class="logo-box">
                    @if(!empty($images['logo']))
                        <img src="{{ asset($images['logo']) }}" alt="Logo" class="logo-img">
                    @else
                        <div style="font-size:32px; font-weight:900; color:#000000; letter-spacing:1px; margin-bottom:4px;">{{ $data['company_name'] ?? 'RUMUS' }}</div>
                        <div style="font-size:13px; font-style:italic; color:#444;">Estamparia & Confecções</div>
                    @endif
                    <div class="banner-orcamento">ORÇAMENTO</div>
                </div>

                <div class="company-box">
                    <div class="company-name">{{ $data['company_name'] ?? 'CONFECÇÕES NÓBREGA LTDA - EPP' }}</div>
                    <div>CNPJ: {{ $data['company_cnpj'] ?? '07.149.307/0002-89' }}</div>
                    <div>INSC. ESTADUAL: {{ $data['company_ie'] ?? '242.15525-1' }}</div>
                    <div>RUA: {{ $data['company_address'] ?? 'RUA DO IMPERADOR, 312' }}</div>
                    <div>CEP: {{ $data['company_cep'] ?? '57020-030' }} &nbsp;&nbsp;&nbsp;&nbsp; FONE: {{ $data['company_phone'] ?? '3336-7272' }}</div>

                    <div class="header-meta">
                        <div>N°: {{ $data['quote_number'] ?? date('dmy') }}</div>
                        <div>VALIDADE: {{ strtoupper($data['validity'] ?? '15 DIAS') }}</div>
                    </div>
                </div>
            </div>

            {{-- Client Details Box --}}
            <table class="details-table">
                <tr>
                    <td class="details-label">CLIENTE:</td>
                    <td>{{ strtoupper($data['client_name'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="details-label">ENDEREÇO:</td>
                    <td>{{ strtoupper($data['client_address'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="details-label">CONTATO:</td>
                    <td>
                        {{ strtoupper($data['client_contact'] ?? '') }}
                    </td>
                </tr>
                <tr>
                    <td class="details-label">E-MAIL:</td>
                    <td>{{ $data['client_email'] ?? '' }}</td>
                </tr>
                <tr>
                    <td class="details-label">REFERENTE:</td>
                    <td>{{ strtoupper($data['referent'] ?? 'ORÇAMENTO') }}</td>
                </tr>
            </table>

            {{-- Items Table --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="col-qty">QUANT.</th>
                        <th class="col-desc">DESCRIÇÃO</th>
                        <th class="col-unit">PÇ UNIT.</th>
                        <th class="col-total">PÇ TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="col-qty">{{ $item['quantity'] }}</td>
                            <td class="col-desc">{{ mb_strtoupper($item['description'], 'UTF-8') }}</td>
                            <td class="col-unit">{{ $item['unit_price'] }}</td>
                            <td class="col-total">{{ $item['total_price'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Summary Line --}}
            <table style="width:100%; border-collapse:collapse; margin-top:-1px;">
                <tr class="summary-row">
                    <td style="width:28%; border-right:1px dotted #000; border-left:1px dotted #000;">
                        Vendedor: &nbsp;&nbsp; <strong>{{ strtoupper($data['seller_name'] ?? 'MARCELO') }}</strong>
                    </td>
                    <td style="width:44%; border-right:1px dotted #000; text-align:center;">
                        WHATSAPP &nbsp;&nbsp; <strong>{{ $data['seller_whatsapp'] ?? '82 9 9928-0418' }}</strong>
                    </td>
                    <td style="width:28%; border-right:1px dotted #000; text-align:right;">
                        TOTAL &nbsp;&nbsp; <span style="font-size:14px; font-weight:800;">{{ $formattedGrandTotal }}</span>
                    </td>
                </tr>
            </table>

            {{-- Delivery Notice --}}
            <div class="delivery-notice">
                PRAZO DE ENTREGA: {{ strtoupper($data['delivery_time'] ?? 'A COMBINAR') }}
            </div>

            {{-- Observations --}}
            @if(!empty($data['observations']))
                <div class="observations-box">
                    <strong>OBSERVAÇÕES:</strong> {{ $data['observations'] }}
                </div>
            @endif
        </div>

        {{-- Footer Block: Stamp & Signature --}}
        <div class="footer-grid">
            {{-- Stamp Column --}}
            <div class="stamp-col">
                <div class="stamp-title">CARIMBO CNPJ:</div>
                @if(!empty($images['stamp']))
                    <img src="{{ asset($images['stamp']) }}" alt="Carimbo CNPJ" class="stamp-img">
                @else
                    <div style="border:1px dashed #999; padding:15px; text-align:center; color:#888; font-size:11px; max-width:220px; border-radius:4px;">
                        Carimbo CNPJ<br>
                        (Configure a imagem nas Configurações do Admin)
                    </div>
                @endif
            </div>

            {{-- Signature Column --}}
            <div class="signature-col">
                <div class="date-line">
                    {{ $dateFormatted }}
                </div>

                @if(!empty($images['signature']))
                    <img src="{{ asset($images['signature']) }}" alt="Assinatura" class="signature-img">
                @else
                    <div style="height:45px;"></div>
                @endif

                <div class="signer-name">{{ $data['signer_name'] ?? 'Fernanda R. Nóbrega' }}</div>
                <div class="signer-role">{{ $data['signer_role'] ?? 'Gerente de Marketing e Vendas' }}</div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const downloadBtn = document.getElementById('downloadPdfBtn');
            
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function () {
                    const element = document.querySelector('.page-container');
                    const quoteNum = "{{ $data['quote_number'] ?? '001' }}";
                    const clientName = "{{ Str::slug($data['client_name'] ?? 'cliente') }}";
                    const filename = `Orcamento_N${quoteNum}_${clientName}.pdf`;

                    const opt = {
                        margin:       [0, 0, 0, 0],
                        filename:     filename,
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2, useCORS: true, logging: false, scrollY: 0 },
                        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                        pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
                    };

                    downloadBtn.disabled = true;
                    downloadBtn.style.opacity = '0.7';
                    downloadBtn.innerHTML = `Baixando...`;

                    html2pdf().set(opt).from(element).save().then(() => {
                        downloadBtn.disabled = false;
                        downloadBtn.style.opacity = '1';
                        downloadBtn.innerHTML = `
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Baixar PDF
                        `;
                    });
                });
            }
        });
    </script>
</body>
</html>
