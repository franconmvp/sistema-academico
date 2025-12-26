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
        // Certificados, grados y títulos
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->enum('tipo', ['certificado_estudios', 'certificado_modular', 'grado', 'titulo']);
            $table->string('numero_documento')->unique();
            $table->date('fecha_emision');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['emitido', 'entregado', 'anulado'])->default('emitido');
            $table->foreignId('emitido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
