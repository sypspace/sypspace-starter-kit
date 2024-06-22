<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasAvatar, HasName
{
    use HasFactory, Notifiable, HasUuids, HasRoles, HasPanelShield;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile && $this->profile->avatar_url ? Storage::url($this->profile->avatar_url) : null;
    }

    public function getFilamentName(): string
    {
        return "{$this->name}";
    }

    public function getIsVerifiedAttribute()
    {
        return $this->email_verified_at ? true : false;
    }

    public function getIsSuperAdminAttribute(): bool
    {
        // return in_array('super_admin', $this->roles->pluck('name')->toArray());
        // return $this->roles()->where('name', 'super_admin')->count();
        return $this->hasRole(config('filament-shield.super_admin.name'));
    }

    // public function getAvatarUrlAttribute(): ?string
    // {
    //     // return $this->profile->avatar_url;
    //     return $this->getMedia('avatars')?->first()?->getUrl() ?? $this->getMedia('avatars')?->first()?->getUrl('thumb') ?? null;
    // }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //         ->fit(Fit::Contain, 300, 300)
    //         ->nonQueued();
    // }

}
