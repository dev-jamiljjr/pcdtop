<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'telefone',
        'email_contato',
        'cidade',
        'estado',
        'endereco',
        'ramo_atividade',
        'website',
        'descricao',
    ];

    /**
     * Uma empresa pertence a um usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Uma empresa pode ter muitas vagas.
     */
    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class);
    }
}
