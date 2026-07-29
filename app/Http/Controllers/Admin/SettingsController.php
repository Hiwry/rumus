<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $this->ensureQuoteSettingsExist();
        $settings = SiteSetting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Auto-create default quote settings in DB if missing.
     */
    private function ensureQuoteSettingsExist(): void
    {
        $defaults = [
            ['key' => 'quote_company_name',    'value' => 'CONFECÇÕES NÓBREGA LTDA - EPP',                               'type' => 'text',     'label' => 'Razão Social (Orçamento)',      'group' => 'quote'],
            ['key' => 'quote_company_cnpj',    'value' => '07.149.307/0002-89',                                         'type' => 'text',     'label' => 'CNPJ (Orçamento)',              'group' => 'quote'],
            ['key' => 'quote_company_ie',      'value' => '242.15525-1',                                                'type' => 'text',     'label' => 'Inscrição Estadual',            'group' => 'quote'],
            ['key' => 'quote_company_address', 'value' => 'RUA DO IMPERADOR, 312 - CENTRO',                             'type' => 'text',     'label' => 'Endereço da Empresa',           'group' => 'quote'],
            ['key' => 'quote_company_cep',     'value' => '57020-030',                                                  'type' => 'text',     'label' => 'CEP da Empresa',                'group' => 'quote'],
            ['key' => 'quote_company_phone',   'value' => '(82) 3336-7272',                                             'type' => 'text',     'label' => 'Telefone da Empresa',           'group' => 'quote'],
            ['key' => 'quote_seller',          'value' => 'MARCELO',                                                    'type' => 'text',     'label' => 'Vendedor Padrão',               'group' => 'quote'],
            ['key' => 'quote_whatsapp',        'value' => '(82) 99928-0418',                                            'type' => 'text',     'label' => 'WhatsApp Vendedor',             'group' => 'quote'],
            ['key' => 'quote_delivery_time',   'value' => 'A COMBINAR',                                                 'type' => 'text',     'label' => 'Prazo de Entrega Padrão',       'group' => 'quote'],
            ['key' => 'quote_validity',        'value' => '15 DIAS',                                                    'type' => 'text',     'label' => 'Validade Padrão',               'group' => 'quote'],
            ['key' => 'quote_signer_name',     'value' => 'Fernanda R. Nóbrega',                                        'type' => 'text',     'label' => 'Nome do Responsável (Assinatura)','group' => 'quote'],
            ['key' => 'quote_signer_role',     'value' => 'Gerente de Marketing e Vendas',                              'type' => 'text',     'label' => 'Cargo do Responsável',          'group' => 'quote'],
            ['key' => 'quote_observations',    'value' => 'Forma de pagamento: 50% de entrada e 50% na entrega, para pagamentos sem ser em cartão de crédito. Pagamento no cartão de crédito não pode ser pago 50% no inicio e 50% no final, tem que ser pago o valor total na entrada do pedido. Isso é apenas o orçamento, no fechamento do pedido pode não ter o tecido e a cor correspondente, verificar a disponibilidade antes de fechar.', 'type' => 'textarea', 'label' => 'Observações Padrão', 'group' => 'quote'],
            ['key' => 'quote_logo',            'value' => '',                                                           'type' => 'file',     'label' => 'Imagem de Logo do Orçamento',   'group' => 'quote'],
            ['key' => 'quote_stamp',           'value' => '',                                                           'type' => 'file',     'label' => 'Imagem de Carimbo CNPJ',        'group' => 'quote'],
            ['key' => 'quote_signature',       'value' => '',                                                           'type' => 'file',     'label' => 'Imagem da Assinatura',          'group' => 'quote'],
        ];

        foreach ($defaults as $item) {
            SiteSetting::firstOrCreate(['key' => $item['key']], $item);
        }
    }

    public function update(Request $request)
    {
        // Handle image/file uploads dynamically
        $fileFields = ['site_logo', 'site_favicon', 'quote_logo', 'quote_stamp', 'quote_signature'];
        
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $prefix = str_replace(['site_', 'quote_'], '', $field);
                $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/uploads'), $filename);
                SiteSetting::set($field, 'images/uploads/' . $filename);
            }
        }

        $data = $request->except(array_merge(['_token', '_method'], $fileFields));

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Handle boolean checkboxes (unchecked = not sent)
        $booleanKeys = SiteSetting::where('type', 'boolean')->pluck('key');
        foreach ($booleanKeys as $key) {
            if (!isset($data[$key])) {
                SiteSetting::set($key, '0');
            }
        }

        return back()->with('success', 'Configurações salvas com sucesso!');
    }
}
