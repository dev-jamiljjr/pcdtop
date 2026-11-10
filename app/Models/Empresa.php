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
        'user_id', 'razao_social', 'nome_fantasia', 'cnpj', 'telefone',
        'email_contato', 'cidade', 'estado', 'endereco', 'ramo_atividade',
        'website', 'descricao', 'bairro', 'cep',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class);
    }

    public function contatos(): HasMany
    {
        return $this->hasMany(EmpresaContato::class);
    }

    // O método boot() foi removido.
}
