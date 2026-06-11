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
    public function getRouteKeyName()
    {
        return 'url';
    }
    public function isPrivate(): bool
    {
        return $this->is_private;
    }
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        $firstPhoto = $this->photos->first();

        if ($firstPhoto) {
            return asset('storage/' . $firstPhoto->preview_path);
        }

        return null;
    }
    
}