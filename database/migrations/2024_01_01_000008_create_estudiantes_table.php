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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('programa_estudio_id')->constrained('programas_estudio');
            $table->foreignId('plan_estudio_id')->constrained('planes_estudio');
            $table->foreignId('turno_id')->constrained('turnos');
            $table->string('codigo_estudiante')->unique();
            $table->string('dni')->unique();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email_personal')->nullable();
            $table->integer('ciclo_actual')->default(1);
            $table->enum('estado', ['activo', 'egresado', 'retirado', 'suspendido'])->default('activo');
            $table->date('fecha_ingreso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
