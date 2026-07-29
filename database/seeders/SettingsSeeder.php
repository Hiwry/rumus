<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Social
            ['key' => 'instagram_url',   'value' => 'https://www.instagram.com/rumus.br', 'type' => 'url',      'label' => 'URL do Instagram',     'group' => 'social'],
            ['key' => 'whatsapp_url',    'value' => 'https://wa.me/5582999999999',         'type' => 'url',      'label' => 'URL do WhatsApp',      'group' => 'social'],
            ['key' => 'whatsapp_number', 'value' => '5582999999999',                        'type' => 'text',     'label' => 'Número do WhatsApp',   'group' => 'social'],

            // General
            ['key' => 'site_name',       'value' => 'RUMUS',                                'type' => 'text',     'label' => 'Nome do Site',         'group' => 'general'],
            ['key' => 'site_tagline',    'value' => 'Estamparia Premium',                   'type' => 'text',     'label' => 'Slogan do Site',       'group' => 'general'],
            ['key' => 'site_logo',       'value' => '',                                     'type' => 'file',     'label' => 'Logotipo do Site (PNG)', 'group' => 'general'],
            ['key' => 'site_favicon',    'value' => 'favicon.ico',                          'type' => 'file',     'label' => 'Favicon do Site (.ico/.png)', 'group' => 'general'],
            ['key' => 'contact_email',   'value' => 'contato@rumus.com.br',                 'type' => 'text',     'label' => 'E-mail de Contato',    'group' => 'general'],
            ['key' => 'contact_phone',   'value' => '(82) 99999-9999',                      'type' => 'text',     'label' => 'Telefone de Contato',  'group' => 'general'],
            ['key' => 'address',         'value' => 'Maceió, Alagoas',                      'type' => 'text',     'label' => 'Endereço',             'group' => 'general'],

            // Appearance
            ['key' => 'hero_title',      'value' => 'Estamparia que Imprime Identidade',    'type' => 'text',     'label' => 'Título do Hero',       'group' => 'appearance'],
            ['key' => 'hero_subtitle',   'value' => 'Camisas, ecobags e muito mais personalizados com a sua arte.',  'type' => 'textarea', 'label' => 'Subtítulo do Hero', 'group' => 'appearance'],
            ['key' => 'primary_color',   'value' => '#5b2dd9',                              'type' => 'color',    'label' => 'Cor Primária',         'group' => 'appearance'],
            ['key' => 'accent_color',    'value' => '#c084fc',                              'type' => 'color',    'label' => 'Cor de Destaque',      'group' => 'appearance'],
            ['key' => 'show_banner',     'value' => '1',                                    'type' => 'boolean',  'label' => 'Mostrar Banner Topo',  'group' => 'appearance'],
            ['key' => 'banner_text',     'value' => 'Frete grátis acima de R$ 199 · Produção expressa disponível', 'type' => 'text', 'label' => 'Texto do Banner', 'group' => 'appearance'],

            // Taxonomy
            ['key' => 'product_categories', 'value' => 'sublimacao,serigrafia,dtf,ecobag', 'type' => 'text', 'label' => 'Categorias de Produtos', 'group' => 'system'],
            ['key' => 'order_statuses',     'value' => 'pending:Aguardando,confirmed:Confirmado,in_production:Em Produção,shipped:Enviado,delivered:Entregue,cancelled:Cancelado', 'type' => 'text', 'label' => 'Status de Pedidos', 'group' => 'system'],

            // Quote / Orçamento
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

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
