<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->longText('descricao'); // Alterado para longText para mais conteúdo
            $table->longText('requisitos')->nullable(); // Alterado para longText
            $table->string('localizacao'); // Adicionada
            $table->string('tipo_contrato'); // Adicionada: Ex: CLT, PJ, Estágio
            $table->decimal('salario', 10, 2)->nullable(); // Precisão ajustada
            $table->text('beneficios')->nullable(); // Adicionada
            $table->string('status')->default('ativa'); // ativa, pausada, preenchida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
