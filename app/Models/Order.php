<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'product_id', 'product_name',
        'customer_name', 'customer_phone', 'customer_email',
        'size', 'color', 'quantity', 'unit_price', 'total_price',
        'status', 'notes',
    ];

    protected $casts = [
        'unit_price'  => 'float',
        'total_price' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'RMS-' . strtoupper(substr(uniqid(), -6));
    }

    public function getStatusLabelAttribute(): string
    {
        try {
            $statusesString = \App\Models\SiteSetting::get('order_statuses');
            if (!empty($statusesString)) {
                foreach (explode(',', $statusesString) as $item) {
                    $parts = explode(':', $item, 2);
                    if (count($parts) === 2 && trim($parts[0]) === $this->status) {
                        return trim($parts[1]);
                    }
                }
            }
        } catch (\Throwable $e) {}

        return match($this->status) {
            'pending'       => 'Aguardando',
            'confirmed'     => 'Confirmado',
            'in_production' => 'Em Produção',
            'shipped'       => 'Enviado',
            'delivered'     => 'Entregue',
            'cancelled'     => 'Cancelado',
            default         => 'Desconhecido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'       => 'warning',
            'confirmed'     => 'info',
            'in_production' => 'primary',
            'shipped'       => 'secondary',
            'delivered'     => 'success',
            'cancelled'     => 'danger',
            default         => 'secondary',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'R$ ' . number_format($this->total_price, 2, ',', '.');
    }
}
