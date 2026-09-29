<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable; // Certifique-se que esta linha está correta
use Laravel\Sanctum\HasApiTokens;           // Certifique-se que esta linha está correta
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens; // Use todas as traits aqui

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',        // Adicione esta linha se estiver usando Fortify
        'two_factor_recovery_codes', // Adicione esta linha se estiver usando Fortify
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Um usuário pode ter um perfil de jovem associado.
     */
    public function jovem(): HasOne
    {
        return $this->hasOne(Jovem::class);
    }

    /**
     * Um usuário pode ter um perfil de empresa associado.
     */
    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class);
    }
}
