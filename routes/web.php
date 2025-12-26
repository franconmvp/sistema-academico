<?php

use App\Http\Controllers\Admin\AsignacionDocenteController;
use App\Http\Controllers\Admin\CertificadoController;
use App\Http\Controllers\Admin\EstudianteController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\MatriculaController;
use App\Http\Controllers\Admin\PeriodoLectivoController;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\PlanEstudioController;
use App\Http\Controllers\Admin\ProgramaEstudioController;
use App\Http\Controllers\Admin\ReglaPromocionController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\TurnoController;
use App\Http\Controllers\Admin\UnidadDidacticaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Docente\DocenteController;
use App\Http\Controllers\Estudiante\EstudianteController as EstudianteEstudianteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Institution
    Route::get('/institution', [InstitutionController::class, 'index'])->name('institution.index');
    Route::get('/institution/edit', [InstitutionController::class, 'edit'])->name('institution.edit');
    Route::put('/institution', [InstitutionController::class, 'update'])->name('institution.update');

    // Periodos Lectivos
    Route::resource('periodos', PeriodoLectivoController::class)->parameters(['periodos' => 'periodo']);
    Route::post('/periodos/{periodo}/set-active', [PeriodoLectivoController::class, 'setActive'])->name('periodos.set-active');

    // Turnos
    Route::resource('turnos', TurnoController::class)->parameters(['turnos' => 'turno']);

    // Programas de Estudio
    Route::resource('programas', ProgramaEstudioController::class)->parameters(['programas' => 'programa']);

    // Planes de Estudio
    Route::resource('planes', PlanEstudioController::class)->parameters(['planes' => 'plan']);

    // Unidades Didácticas
    Route::resource('unidades', UnidadDidacticaController::class)->parameters(['unidades' => 'unidad']);

    // Personal
    Route::resource('personal', PersonalController::class);

    // Estudiantes
    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/estudiantes-get-planes', [EstudianteController::class, 'getPlanes'])->name('estudiantes.get-planes');

    // Reglas de Promoción
    Route::resource('reglas', ReglaPromocionController::class)->parameters(['reglas' => 'regla']);

    // Asignación Docente
    Route::resource('asignaciones', AsignacionDocenteController::class)->parameters(['asignaciones' => 'asignacion']);

    // Horarios
    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::get('/horarios/{asignacion}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{asignacion}', [HorarioController::class, 'update'])->name('horarios.update');

    // Matrícula
    Route::resource('matriculas', MatriculaController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/matriculas/{matricula}/aprobar', [MatriculaController::class, 'aprobar'])->name('matriculas.aprobar');
    Route::post('/matriculas/{matricula}/rechazar', [MatriculaController::class, 'rechazar'])->name('matriculas.rechazar');
    Route::get('/matriculas-get-unidades', [MatriculaController::class, 'getUnidades'])->name('matriculas.get-unidades');
    Route::get('/matriculas/{matricula}/ficha', [MatriculaController::class, 'fichaMatricula'])->name('matriculas.ficha');

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/matricula-semestral', [ReporteController::class, 'matriculaSemestral'])->name('reportes.matricula-semestral');
    Route::get('/reportes/notas-periodo', [ReporteController::class, 'notasPorPeriodo'])->name('reportes.notas-periodo');
    Route::get('/reportes/actas', [ReporteController::class, 'actas'])->name('reportes.actas');
    Route::post('/reportes/actas/{asignacion}/generar', [ReporteController::class, 'generarActa'])->name('reportes.generar-acta');
    Route::get('/reportes/actas/{acta}', [ReporteController::class, 'verActa'])->name('reportes.ver-acta');

    // Certificados
    Route::resource('certificados', CertificadoController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/certificados/{certificado}/entregar', [CertificadoController::class, 'marcarEntregado'])->name('certificados.entregar');
    Route::post('/certificados/{certificado}/anular', [CertificadoController::class, 'anular'])->name('certificados.anular');
});

// Docente Routes
Route::prefix('docente')->name('docente.')->middleware(['auth', 'docente'])->group(function () {
    Route::get('/asignaciones', [DocenteController::class, 'misAsignaciones'])->name('asignaciones');
    Route::get('/asignaciones/{asignacion}/estudiantes', [DocenteController::class, 'listaEstudiantes'])->name('lista-estudiantes');
    Route::get('/asignaciones/{asignacion}/notas', [DocenteController::class, 'registrarNotas'])->name('registrar-notas');
    Route::post('/asignaciones/{asignacion}/notas', [DocenteController::class, 'guardarNotas'])->name('guardar-notas');
    Route::get('/asignaciones/{asignacion}/reporte', [DocenteController::class, 'reporteNotas'])->name('reporte-notas');
    Route::get('/mi-horario', [DocenteController::class, 'miHorario'])->name('mi-horario');
});

// Estudiante Routes
Route::prefix('estudiante')->name('estudiante.')->middleware(['auth', 'estudiante'])->group(function () {
    Route::get('/mi-perfil', [EstudianteEstudianteController::class, 'miPerfil'])->name('mi-perfil');
    Route::get('/historial-academico', [EstudianteEstudianteController::class, 'historialAcademico'])->name('historial-academico');
    Route::get('/mis-matriculas', [EstudianteEstudianteController::class, 'misMatriculas'])->name('mis-matriculas');
    Route::get('/mis-matriculas/{matricula}/ficha', [EstudianteEstudianteController::class, 'fichaMatricula'])->name('ficha-matricula');
    Route::get('/mis-notas', [EstudianteEstudianteController::class, 'misNotas'])->name('mis-notas');
    Route::get('/mi-horario', [EstudianteEstudianteController::class, 'miHorario'])->name('mi-horario');
});

require __DIR__.'/auth.php';
