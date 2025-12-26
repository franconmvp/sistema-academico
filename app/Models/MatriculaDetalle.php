<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MatriculaDetalle extends Model
{
    use HasFactory;

    protected $table = 'matricula_detalle';

    protected $fillable = [
        'matricula_id',
        'unidad_didactica_id',
        'asignacion_docente_id',
        'numero_matricula',
        'estado',
    ];

    /**
     * Get the matricula
     */
    public function matricula(): BelongsTo
    {
        return $this->belongsTo(Matricula::class);
    }

    /**
     * Get the unidad didactica
     */
    public function unidadDidactica(): BelongsTo
    {
        return $this->belongsTo(UnidadDidactica::class);
    }

    /**
     * Get the asignacion docente
     */
    public function asignacionDocente(): BelongsTo
    {
        return $this->belongsTo(AsignacionDocente::class);
    }

    /**
     * Get the nota
     */
    public function nota(): HasOne
    {
        return $this->hasOne(Nota::class);
    }
}
