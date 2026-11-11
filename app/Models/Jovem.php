<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Jovem extends Model
{
    use HasFactory;

    protected $table = 'jovens';

    protected $fillable = [
        'user_id', 'cpf', 'nome_completo', 'data_nascimento', 'genero',
        'deficiencia', 'endereco', 'bairro', 'cidade', 'estado', 'cep',
        'telefone', 'curriculo_path', 'formacao_academica', 'experiencia_profissional',
        'habilidades', 'link_portfolio', 'link_linkedin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class);
    }

    /**
     * Retorna o CPF formatado no padrão 000.000.000-00 exclusivamente para a camada de apresentação.
     */
    public function getCpfFormatadoAttribute(): ?string
    {
        if (empty($this->cpf)) {
            return null;
        }

        $cpfNumeros = preg_replace('/\D/', '', (string) $this->cpf);

        if (strlen($cpfNumeros) === 11) {
            return vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($cpfNumeros));
        }

        return (string) $this->cpf;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($jovem) {
            if ($jovem->curriculo_path && Storage::disk('public')->exists($jovem->curriculo_path)) {
                Storage::disk('public')->delete($jovem->curriculo_path);
            }
        });
    }
}
