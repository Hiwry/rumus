<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'quote_number',
        'quote_date',
        'client_name',
        'client_contact',
        'client_email',
        'client_address',
        'referent',
        'seller_name',
        'seller_whatsapp',
        'delivery_time',
        'validity',
        'observations',
        'total_amount',
        'items',
        'company_name',
        'company_cnpj',
        'company_ie',
        'company_address',
        'company_phone',
        'signer_name',
        'signer_role',
        'status',
    ];

    protected $casts = [
        'quote_date'   => 'date',
        'items'        => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get formatted total amount in R$
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'R$ ' . number_format((float)$this->total_amount, 2, ',', '.');
    }

    /**
     * Get status label in Portuguese
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'Aprovado',
            'rejected' => 'Recusado',
            default    => 'Pendente',
        };
    }

    /**
     * Get status badge CSS class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'badge-success',
            'rejected' => 'badge-danger',
            default    => 'badge-warning',
        };
    }
}
