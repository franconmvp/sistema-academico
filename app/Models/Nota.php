<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula_detalle_id',
        'nota_1',
        'nota_2',
        'nota_3',
        'nota_4',
        'promedio_parcial',
        'examen_final',
        'promedio_final',
        'nota_recuperacion',
        'nota_definitiva',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'nota_1' => 'decimal:2',
        'nota_2' => 'decimal:2',
        'nota_3' => 'decimal:2',
        'nota_4' => 'decimal:2',
        'promedio_parcial' => 'decimal:2',
        'examen_final' => 'decimal:2',
        'promedio_final' => 'decimal:2',
        'nota_recuperacion' => 'decimal:2',
        'nota_definitiva' => 'decimal:2',
    ];

    /**
     * Get the matricula detalle
     */
    public function matriculaDetalle(): BelongsTo
    {
        return $this->belongsTo(MatriculaDetalle::class);
    }

    /**
     * Calculate promedio parcial
     */
    public function calcularPromedioParcial(): float
    {
        $notas = array_filter([
            $this->nota_1,
            $this->nota_2,
            $this->nota_3,
            $this->nota_4,
        ], fn($n) => $n !== null);

        if (empty($notas)) {
            return 0;
        }

        return round(array_sum($notas) / count($notas), 2);
    }

    /**
     * Calculate promedio final
     */
    public function calcularPromedioFinal(): float
    {
        if ($this->promedio_parcial === null || $this->examen_final === null) {
            return 0;
        }

        // 60% promedio parcial + 40% examen final (ajustar según reglamento)
        return round(($this->promedio_parcial * 0.6) + ($this->examen_final * 0.4), 2);
    }

    /**
     * Calculate nota definitiva
     */
    public function calcularNotaDefinitiva(): float
    {
        if ($this->promedio_final >= 13) {
            return $this->promedio_final;
        }

        // Si tiene nota de recuperación y es mayor al promedio final
        if ($this->nota_recuperacion !== null && $this->nota_recuperacion > $this->promedio_final) {
            return min($this->nota_recuperacion, 13); // Máximo 13 en recuperación
        }

        return $this->promedio_final ?? 0;
    }

    /**
     * Update estado based on nota definitiva
     */
    public function actualizarEstado(): void
    {
        if ($this->nota_definitiva === null) {
            $this->estado = 'pendiente';
        } elseif ($this->nota_definitiva >= 13) {
            $this->estado = 'aprobado';
        } else {
            $this->estado = 'desaprobado';
        }
    }
}
