<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsignacionDocente extends Model
{
    use HasFactory;

    protected $table = 'asignacion_docente';

    protected $fillable = [
        'personal_id',
        'unidad_didactica_id',
        'periodo_lectivo_id',
        'turno_id',
        'aula',
    ];

    /**
     * Get the personal (docente)
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class);
    }

    /**
     * Get the unidad didactica
     */
    public function unidadDidactica(): BelongsTo
    {
        return $this->belongsTo(UnidadDidactica::class);
    }

    /**
     * Get the periodo lectivo
     */
    public function periodoLectivo(): BelongsTo
    {
        return $this->belongsTo(PeriodoLectivo::class);
    }

    /**
     * Get the turno
     */
    public function turno(): BelongsTo
    {
        return $this->belongsTo(Turno::class);
    }

    /**
     * Get the horarios
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Get the matricula detalles
     */
    public function matriculaDetalles(): HasMany
    {
        return $this->hasMany(MatriculaDetalle::class);
    }

    /**
     * Get the actas
     */
    public function actas(): HasMany
    {
        return $this->hasMany(Acta::class);
    }
}
