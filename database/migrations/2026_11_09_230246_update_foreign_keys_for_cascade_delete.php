<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela 'jovens'
        Schema::table('jovens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabela 'empresas'
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabela 'empresa_contatos'
        Schema::table('empresa_contatos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });

        // Tabela 'vagas'
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });

        // Tabela 'candidaturas'
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropForeign(['jovem_id']);
            $table->dropForeign(['vaga_id']);
            $table->foreign('jovem_id')->references('id')->on('jovens')->onDelete('cascade');
            $table->foreign('vaga_id')->references('id')->on('vagas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Reverte as alterações para o comportamento padrão (restrict/no action)
        Schema::table('jovens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('empresa_contatos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });

        Schema::table('vagas', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });

        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropForeign(['jovem_id']);
            $table->dropForeign(['vaga_id']);
            $table->foreign('jovem_id')->references('id')->on('jovens');
            $table->foreign('vaga_id')->references('id')->on('vagas');
        });
    }
};
