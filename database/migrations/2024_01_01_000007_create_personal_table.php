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
        // Personal Docente y No Docente
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('dni')->unique();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->enum('tipo', ['docente', 'administrativo', 'jerarquico']); // Personal Docente y No Docente
            $table->string('cargo')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('grado_academico')->nullable();
            $table->string('titulo_profesional')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->enum('condicion', ['nombrado', 'contratado'])->default('contratado');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
