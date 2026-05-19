<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Models\Photo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'role'
    ];

    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function albums(){
        return $this->hasMany(Album::class);
    }
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }
    public function isPhotographer(): bool
    {
        return $this->role === UserRole::PHOTOGRAPHER;
    }
    public function ownsPhoto(Photo $photo){
        return $this->id === $photo->user_id;
    }
    public function canManagePhoto(Photo $photo){
        return $this->ownsPhoto($photo)|| $this->isAdmin();
    }

    public function ensureCanManagePhoto(Photo $photo): void{
        abort_unless($this->canManagePhoto($photo), 403);
    }
    public function ensureAdmin(): void{
        abort_unless($this->isAdmin(), 403);
    }
        /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'role' => UserRole::class,
    ];
}
