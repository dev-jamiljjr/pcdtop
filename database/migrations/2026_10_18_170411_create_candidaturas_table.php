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
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jovem_id')->constrained('jovens')->onDelete('cascade'); // Referência ao jovem que se candidatou
            $table->foreignId('vaga_id')->constrained('vagas')->onDelete('cascade'); // Referência à vaga
            $table->string('status')->default('pendente'); // e.g., 'pendente', 'visualizado', 'aprovado', 'rejeitado'
            $table->text('observacoes')->nullable(); // Campo para observações da empresa ou do jovem
            $table->timestamps();

            // Garante que um jovem possa se candidatar a uma vaga apenas uma vez
            $table->unique(['jovem_id', 'vaga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidaturas');
    }
};
