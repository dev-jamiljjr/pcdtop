<?php

namespace App\Models;

// ... outras importações ...
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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

    // ... restante do código do seu arquivo ...

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
