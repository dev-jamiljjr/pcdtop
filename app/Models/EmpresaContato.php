<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaContato extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'cargo',
        'cpf',
        'telefone',
        'email',
    ];

    /**
     * Define o relacionamento com a Empresa.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Retorna o CPF formatado no padrão 000.000.000-00 exclusivamente para visualização.
     */
    public function getCpfFormatadoAttribute(): ?string
    {
        if (empty($this->cpf)) {
            return null;
        }

        $numeros = preg_replace('/\D/', '', (string) $this->cpf);

        if (strlen($numeros) === 11) {
            return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($numeros));
        }

        return (string) $this->cpf;
    }
}
