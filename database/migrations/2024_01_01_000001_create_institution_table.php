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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_modular')->unique();
            $table->string('nombre');
            $table->string('tipo_ies')->nullable(); // Tipo de Institución de Educación Superior
            $table->string('dre')->nullable(); // Dirección Regional de Educación
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('pagina_web')->nullable();
            $table->text('otros')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
