<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReglaPromocion extends Model
{
    use HasFactory;

    protected $table = 'reglas_promocion';

    protected $fillable = [
        'programa_estudio_id',
        'turno_id',
        'ciclo',
        'max_matriculados',
    ];

    /**
     * Get the programa de estudio
     */
    public function programaEstudio(): BelongsTo
    {
        return $this->belongsTo(ProgramaEstudio::class);
    }

    /**
     * Get the turno
     */
    public function turno(): BelongsTo
    {
        return $this->belongsTo(Turno::class);
    }
}
