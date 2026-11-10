<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public const STATUS_ATIVO = 'ativo';
    public const STATUS_BLOQUEADO = 'bloqueado';

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_perfil',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function jovem(): HasOne
    {
        return $this->hasOne(Jovem::class);
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ATIVO;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOQUEADO;
    }

    // O método boot() foi removido.
}
