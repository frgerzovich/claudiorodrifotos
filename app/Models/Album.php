<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'description',
        'password',
        'is_private',
        'cover_image',
    ];

    // relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // helpers
    public function isPrivate(): bool
    {
        return $this->is_private;
    }
}