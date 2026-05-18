<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'photo_id',
        'photographer_id',
        'quantity',
        'unit_price',
        'type',
        'print_size',
    ];

    // relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function photographer()
    {
        return $this->belongsTo(User::class, 'photographer_id');
    }

    // helpers
    public function subtotal(): float
    {
        return $this->quantity * $this->unit_price;
    }

    public function isPrint(): bool
    {
        return $this->type === 'print';
    }

    public function isDigital(): bool
    {
        return $this->type === 'digital';
    }
}