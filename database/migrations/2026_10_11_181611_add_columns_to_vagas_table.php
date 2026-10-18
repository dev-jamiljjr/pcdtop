<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            // Adicionar a coluna 'status' para gerenciar o estado da vaga (e.g., 'ativa', 'inativa', 'preenchida')
            // Como esta coluna já está sendo criada na migração original, podemos deixar este método 'up' vazio
            // ou, para garantir, adicionar a coluna apenas se ela não existir.
            // A abordagem mais limpa é consolidar na migração de criação e deixar este vazio.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // O método down correspondente também pode ser deixado vazio
        // ou podemos remover a coluna 'status' se ela existir.
        if (Schema::hasColumn('vagas', 'status')) {
            Schema::table('vagas', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
