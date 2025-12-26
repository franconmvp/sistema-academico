<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanEstudio extends Model
{
    use HasFactory;

    protected $table = 'planes_estudio';

    protected $fillable = [
        'programa_estudio_id',
        'codigo',
        'nombre',
        'anio_inicio',
        'descripcion',
        'vigente',
    ];

    protected $casts = [
        'vigente' => 'boolean',
    ];

    /**
     * Get the programa de estudio
     */
    public function programaEstudio(): BelongsTo
    {
        return $this->belongsTo(ProgramaEstudio::class);
    }

    /**
     * Get the unidades didacticas
     */
    public function unidadesDidacticas(): HasMany
    {
        return $this->hasMany(UnidadDidactica::class);
    }

    /**
     * Get the estudiantes
     */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Scope for vigente plans
     */
    public function scopeVigente($query)
    {
        return $query->where('vigente', true);
    }
}
