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
        'telefone',      // Já existia na create_empresas_table
        'email_contato', // Já existia na create_empresas_table
        'cidade',        // Já existia na create_empresas_table
        'estado',        // Já existia na create_empresas_table
        'endereco',      // Já existia na create_empresas_table
        'ramo_atividade',// Já existia na create_empresas_table
        'website',       // Já existia na create_empresas_table (usado como "site")
        'descricao',     // Já existia na create_empresas_table
        'bairro',        // NOVO
        'cep',           // NOVO
    ];

    /**
     * Define o relacionamento com o User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define o relacionamento com as Vagas.
     */
    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class);
    }

    /**
     * Define o relacionamento com os Contatos da Empresa.
     */
    public function contatos(): HasMany
    {
        return $this->hasMany(EmpresaContato::class);
    }
}
