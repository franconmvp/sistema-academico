<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\PeriodoLectivo;
use App\Models\PlanEstudio;
use App\Models\ProgramaEstudio;
use App\Models\Turno;
use App\Models\UnidadDidactica;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrador del Sistema',
            'email' => 'admin@sistema.edu.pe',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Institution
        Institution::create([
            'codigo_modular' => '0123456',
            'nombre' => 'Instituto de Educación Superior Tecnológico',
            'tipo_ies' => 'Instituto de Educación Superior Tecnológico Público',
            'dre' => 'Dirección Regional de Educación',
            'direccion' => 'Av. Principal 123, Ciudad',
            'telefono' => '(01) 123-4567',
            'correo' => 'contacto@instituto.edu.pe',
            'pagina_web' => 'https://www.instituto.edu.pe',
        ]);

        // Create Turnos
        Turno::create(['nombre' => 'Mañana', 'hora_inicio' => '07:00', 'hora_fin' => '13:00']);
        Turno::create(['nombre' => 'Tarde', 'hora_inicio' => '13:00', 'hora_fin' => '19:00']);
        Turno::create(['nombre' => 'Noche', 'hora_inicio' => '19:00', 'hora_fin' => '23:00']);

        // Create Periodos Lectivos
        PeriodoLectivo::create([
            'nombre' => '2025-I',
            'anio' => 2025,
            'semestre' => 'I',
            'fecha_inicio' => '2025-03-01',
            'fecha_fin' => '2025-07-31',
            'activo' => false,
        ]);

        PeriodoLectivo::create([
            'nombre' => '2025-II',
            'anio' => 2025,
            'semestre' => 'II',
            'fecha_inicio' => '2025-08-01',
            'fecha_fin' => '2025-12-20',
            'activo' => false,
        ]);

        PeriodoLectivo::create([
            'nombre' => '2026-I',
            'anio' => 2026,
            'semestre' => 'I',
            'fecha_inicio' => '2026-03-01',
            'fecha_fin' => '2026-07-31',
            'activo' => true,
        ]);

        // Create Programa de Estudio
        $programa = ProgramaEstudio::create([
            'codigo' => 'COMP',
            'nombre' => 'Desarrollo de Sistemas de Información',
            'descripcion' => 'Programa de formación en desarrollo de software y sistemas de información.',
            'duracion_semestres' => 6,
            'activo' => true,
        ]);

        // Create Plan de Estudio
        $plan = PlanEstudio::create([
            'programa_estudio_id' => $programa->id,
            'codigo' => 'COMP-2024',
            'nombre' => 'Plan 2024',
            'anio_inicio' => 2024,
            'descripcion' => 'Plan de estudios vigente desde 2024.',
            'vigente' => true,
        ]);

        // Create Unidades Didácticas for Ciclo 1
        $unidades = [
            // Ciclo 1
            ['codigo' => 'COMP101', 'nombre' => 'Fundamentos de Programación', 'ciclo' => 1, 'creditos' => 4, 'horas' => 6],
            ['codigo' => 'COMP102', 'nombre' => 'Matemática Aplicada', 'ciclo' => 1, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP103', 'nombre' => 'Arquitectura de Computadores', 'ciclo' => 1, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP104', 'nombre' => 'Comunicación', 'ciclo' => 1, 'creditos' => 2, 'horas' => 3],
            // Ciclo 2
            ['codigo' => 'COMP201', 'nombre' => 'Programación Orientada a Objetos', 'ciclo' => 2, 'creditos' => 4, 'horas' => 6],
            ['codigo' => 'COMP202', 'nombre' => 'Base de Datos I', 'ciclo' => 2, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP203', 'nombre' => 'Análisis de Sistemas', 'ciclo' => 2, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP204', 'nombre' => 'Inglés Técnico I', 'ciclo' => 2, 'creditos' => 2, 'horas' => 3],
            // Ciclo 3
            ['codigo' => 'COMP301', 'nombre' => 'Desarrollo Web', 'ciclo' => 3, 'creditos' => 4, 'horas' => 6],
            ['codigo' => 'COMP302', 'nombre' => 'Base de Datos II', 'ciclo' => 3, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP303', 'nombre' => 'Redes y Comunicaciones', 'ciclo' => 3, 'creditos' => 3, 'horas' => 4],
            ['codigo' => 'COMP304', 'nombre' => 'Inglés Técnico II', 'ciclo' => 3, 'creditos' => 2, 'horas' => 3],
        ];

        foreach ($unidades as $unidad) {
            UnidadDidactica::create([
                'plan_estudio_id' => $plan->id,
                'codigo' => $unidad['codigo'],
                'nombre' => $unidad['nombre'],
                'ciclo' => $unidad['ciclo'],
                'creditos' => $unidad['creditos'],
                'horas_semanales' => $unidad['horas'],
                'tipo' => 'obligatorio',
            ]);
        }

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('   Base de datos inicializada');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Usuario Administrador:');
        $this->command->info('   Email: admin@sistema.edu.pe');
        $this->command->info('   Contraseña: admin123');
        $this->command->info('');
        $this->command->info('========================================');
    }
}
