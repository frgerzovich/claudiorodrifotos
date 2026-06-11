<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'file_path',
        'preview_path',
        'user_id',
        'album_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function album(){
        return $this->belongsTo(Album::class);
    }
    
}
