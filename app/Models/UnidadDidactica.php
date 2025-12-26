<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadDidactica extends Model
{
    use HasFactory;

    protected $table = 'unidades_didacticas';

    protected $fillable = [
        'plan_estudio_id',
        'codigo',
        'nombre',
        'ciclo',
        'creditos',
        'horas_semanales',
        'tipo',
        'descripcion',
    ];

    /**
     * Get the plan de estudio
     */
    public function planEstudio(): BelongsTo
    {
        return $this->belongsTo(PlanEstudio::class);
    }

    /**
     * Get the asignaciones docente
     */
    public function asignacionesDocente(): HasMany
    {
        return $this->hasMany(AsignacionDocente::class);
    }

    /**
     * Get the matricula detalles
     */
    public function matriculaDetalles(): HasMany
    {
        return $this->hasMany(MatriculaDetalle::class);
    }

    /**
     * Get programa through plan
     */
    public function getPrograma()
    {
        return $this->planEstudio->programaEstudio;
    }
}
