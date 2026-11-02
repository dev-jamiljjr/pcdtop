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
        Schema::table('candidaturas', function (Blueprint $table) {
            // Remove a chave estrangeira com a regra 'restrict'
            $table->dropForeign(['vaga_id']);

            // Readiciona a chave estrangeira na coluna existente,
            // mas agora com a regra 'cascade'.
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('cascade'); // <<< A REGRA CORRETA
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            // Para reverter, remove a chave com 'cascade'
            $table->dropForeign(['vaga_id']);

            // E readiciona com 'restrict' (o estado anterior)
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('restrict');
        });
    }
};
