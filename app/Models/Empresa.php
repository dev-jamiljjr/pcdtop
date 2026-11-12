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
        'bairro',
        'cep',
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

    /**
     * Retorna o CNPJ formatado no padrão 00.000.000/0000-00 exclusivamente para visualização.
     */
    public function getCnpjFormatadoAttribute(): ?string
    {
        if (empty($this->cnpj)) {
            return null;
        }

        $numeros = preg_replace('/\D/', '', (string) $this->cnpj);

        if (strlen($numeros) === 14) {
            return vsprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', str_split($numeros));
        }

        return (string) $this->cnpj;
    }

    /**
     * Retorna o CEP formatado no padrão 00000-000 exclusivamente para visualização.
     */
    public function getCepFormatadoAttribute(): ?string
    {
        if (empty($this->cep)) {
            return null;
        }

        $numeros = preg_replace('/\D/', '', (string) $this->cep);

        if (strlen($numeros) === 8) {
            return vsprintf('%s%s%s%s%s-%s%s%s', str_split($numeros));
        }

        return (string) $this->cep;
    }
}
