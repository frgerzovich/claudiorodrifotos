<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

//definicones de estados
    public const STATUS_PENDING   = 'pending';
    public const STATUS_PAID      = 'paid';
    public const STATUS_SHIPPED   = 'shipped';
    public const STATUS_RECEIVED  = 'received';
//campos asignables
    protected $fillable = [
        
        'buyer_name',
        'buyer_email',
        'buyer_address',
        'buyer_phone',
        'total',
        'status'
    ];

//relaciones
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
//scopes
    public function scopePending($query){
        return $query->where('status', self::STATUS_PENDING);
    }
    public function scopePaid($query){
        return $query->where('status', self::STATUS_PAID);
    }
    public function scopeShipped($query){
        return $query->where('status', self::STATUS_SHIPPED);
    }
    public function scopeReceived($query){
        return $query->where('status', self::STATUS_RECEIVED);
    }
//helpers
    public function isPending(){
        return $this->status === self::STATUS_PENDING;
    }
    public function isPaid(){
        return $this->status === self::STATUS_PAID;
    }
    public function isShipped(){
        return $this->status === self::STATUS_SHIPPED;
    }
    public function isReceived(){
        return $this->status === self::STATUS_RECEIVED;
    }

//metodos
    public function calculateTotal(){
        return $this->items->sum(function($item){
            return $item->quantity * $item->unit_price;
        });
    }
    public function updateTotal(){
        if(!$this->isPending()){
            return;
        }
        $this->total = $this->calculateTotal();
        $this->save();
    }
}
