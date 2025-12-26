<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'tipo',
        'numero_documento',
        'fecha_emision',
        'descripcion',
        'estado',
        'emitido_por',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
    ];

    /**
     * Get the estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the user who emitted the certificado
     */
    public function emitidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'emitido_por');
    }

    /**
     * Get tipo label
     */
    public function getTipoLabelAttribute(): string
    {
        $tipos = [
            'certificado_estudios' => 'Certificado de Estudios',
            'certificado_modular' => 'Certificado Modular',
            'grado' => 'Grado',
            'titulo' => 'Título',
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }
}
