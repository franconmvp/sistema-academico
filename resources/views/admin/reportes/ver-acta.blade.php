<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta {{ $acta->numero_acta }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; line-height: 1.3; }
        .container { max-width: 100%; margin: 0 auto; padding: 15px; }
        .header { text-align: center; border-bottom: 2px solid #1a365d; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #1a365d; margin: 0; font-size: 16px; }
        .info-box { background: #f9f9f9; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: center; }
        th { background: #1a365d; color: white; }
        .text-left { text-align: left; }
        .approved { color: #059669; font-weight: bold; }
        .failed { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        .signature-area { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature-box { text-align: center; width: 180px; }
        .signature-line { border-top: 1px solid #333; margin-top: 40px; padding-top: 5px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ACTA DE EVALUACIÓN</h1>
            <p style="font-size: 14px; color: #d4a017; font-weight: bold;">N° {{ $acta->numero_acta }}</p>
        </div>
        <div class="info-box">
            <div class="info-grid">
                <div><strong>Período:</strong> {{ $acta->asignacionDocente->periodoLectivo->nombre }}</div>
                <div><strong>Programa:</strong> {{ $acta->asignacionDocente->unidadDidactica->planEstudio->programaEstudio->nombre }}</div>
                <div><strong>Ciclo:</strong> {{ $acta->asignacionDocente->unidadDidactica->ciclo }}</div>
                <div><strong>Unidad Didáctica:</strong> {{ $acta->asignacionDocente->unidadDidactica->nombre }}</div>
                <div><strong>Turno:</strong> {{ $acta->asignacionDocente->turno->nombre }}</div>
                <div><strong>Docente:</strong> {{ $acta->asignacionDocente->personal->nombre_completo }}</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th class="text-left">Apellidos y Nombres</th>
                    <th>N1</th><th>N2</th><th>N3</th><th>N4</th>
                    <th>PP</th><th>EF</th><th>PF</th><th>RC</th><th>ND</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php $aprobados = 0; $desaprobados = 0; @endphp
                @foreach($acta->asignacionDocente->matriculaDetalles->sortBy('matricula.estudiante.apellido_paterno') as $index => $detalle)
                    @php
                        $nota = $detalle->nota;
                        if(($nota?->nota_definitiva ?? 0) >= 13) $aprobados++; 
                        elseif($nota?->nota_definitiva) $desaprobados++;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detalle->matricula->estudiante->codigo_estudiante }}</td>
                        <td class="text-left">{{ $detalle->matricula->estudiante->nombre_completo }}</td>
                        <td>{{ $nota?->nota_1 ?? '-' }}</td>
                        <td>{{ $nota?->nota_2 ?? '-' }}</td>
                        <td>{{ $nota?->nota_3 ?? '-' }}</td>
                        <td>{{ $nota?->nota_4 ?? '-' }}</td>
                        <td>{{ $nota?->promedio_parcial ?? '-' }}</td>
                        <td>{{ $nota?->examen_final ?? '-' }}</td>
                        <td>{{ $nota?->promedio_final ?? '-' }}</td>
                        <td>{{ $nota?->nota_recuperacion ?? '-' }}</td>
                        <td class="{{ ($nota?->nota_definitiva ?? 0) >= 13 ? 'approved' : 'failed' }}">{{ $nota?->nota_definitiva ?? '-' }}</td>
                        <td>{{ $nota?->estado ? ucfirst($nota->estado) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="info-box" style="margin-top: 15px;">
            <strong>Resumen:</strong> Total: {{ $acta->asignacionDocente->matriculaDetalles->count() }} | Aprobados: {{ $aprobados }} | Desaprobados: {{ $desaprobados }}
        </div>
        <div class="signature-area">
            <div class="signature-box"><div class="signature-line">Docente</div></div>
            <div class="signature-box"><div class="signature-line">Coordinador</div></div>
            <div class="signature-box"><div class="signature-line">Secretaría Académica</div></div>
        </div>
        <div class="footer">
            <p>Generado el {{ $acta->fecha_generacion->format('d/m/Y') }} por {{ $acta->generadoPor?->name ?? 'Sistema' }}</p>
        </div>
        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #1a365d; color: white; border: none; cursor: pointer; border-radius: 5px;">Imprimir</button>
            <a href="{{ route('admin.reportes.actas') }}" style="margin-left: 10px; padding: 10px 20px; background: #666; color: white; text-decoration: none; border-radius: 5px;">Volver</a>
        </div>
    </div>
</body>
</html>
