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
            $table->text('descricao');
            $table->text('requisitos')->nullable();
            $table->decimal('salario', 8, 2)->nullable();
            $table->string('cidade');
            $table->string('estado');
            $table->string('status')->default('ativa'); // ativa, pausada, preenchida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
