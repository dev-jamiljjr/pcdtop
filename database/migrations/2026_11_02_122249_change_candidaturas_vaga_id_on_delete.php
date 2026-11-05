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
        // A migração original já criava a foreign key, mas sem o onDelete('restrict').
        // Para alterar o comportamento de uma foreign key, é preciso primeiro removê-la,
        // e depois adicioná-la novamente com as novas opções.
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropForeign(['vaga_id']); // Remove a foreign key existente
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('restrict'); // Adiciona com a nova regra
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Para reverter, removemos a foreign key com 'restrict' e a recriamos
        // com o comportamento padrão anterior (que geralmente é 'cascade' ou 'no action'
        // se não especificado, mas vamos considerar 'cascade' para esta reversão).
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropForeign(['vaga_id']);
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('cascade'); // Reverte para o comportamento anterior (ou o que era desejado)
        });
    }
};
