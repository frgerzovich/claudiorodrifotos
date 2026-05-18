<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    // campos asignables
    protected $fillable = [
        'buyer_name',
        'buyer_email',
        'buyer_address',
        'buyer_phone',
        'total',
        'status',
    ];
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    // relaciones
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    
    public function scopeStatus($query, OrderStatus $status)
    {
        return $query->where('status', $status->value);
    }

    // helpers 
    public function isPending(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === OrderStatus::PAID;
    }

    public function isShipped(): bool
    {
        return $this->status === OrderStatus::SHIPPED;
    }

    public function isReceived(): bool
    {
        return $this->status === OrderStatus::RECEIVED;
    }

    // lógica de negocio
    public function calculateTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    public function updateTotal(): void
    {
        $this->total = $this->calculateTotal();
        $this->save();
    }
}