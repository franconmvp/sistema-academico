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
        Schema::create('periodos_lectivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // e.g., 2026-I, 2026-II
            $table->integer('anio');
            $table->enum('semestre', ['I', 'II']);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos_lectivos');
    }
};
