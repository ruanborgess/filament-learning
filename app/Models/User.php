<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use App\Enum\Role;

class User extends Authenticatable implements HasName
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
        'firstName',
        'lastName',
        'image',
        'email',
        'password',
        'role',
    ];

    public function getFilamentName(): string
    {
        $name = trim(($this->firstName ?? '') . ' ' . ($this->lastName ?? ''));

        return $name !== '' ? $name : $this->email;
    }

    /**
     * Keep Filament's make:filament-user command compatible with this schema,
     * where the user's first name is stored in the firstName column.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['firstName'] = $value;
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' =>  Role::class,
        ];
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'user_post')
            ->withPivot('order')
            ->orderBy('user_post.order');
    }

    public function isSubscriber(): bool
    {
        return $this->role === Role::Subscriber;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Admin;
    }

    public function isEditor(): bool
    {
        return $this->role === Role::Editor;
    }


}
