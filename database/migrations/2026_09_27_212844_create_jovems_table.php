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
        Schema::create('jovens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('data_nascimento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable(); // Adicionada
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('genero')->nullable(); // Adicionada
            $table->text('deficiencia')->nullable(); // Para MVP, um campo de texto simples
            $table->longText('formacao_academica')->nullable(); // Adicionada
            $table->longText('experiencia_profissional')->nullable();
            $table->text('habilidades')->nullable(); // Adicionada
            $table->string('link_portfolio')->nullable(); // Adicionada
            $table->string('link_linkedin')->nullable(); // Adicionada
            $table->string('curriculo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jovens');
    }
};
