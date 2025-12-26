<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Notas - {{ $asignacion->unidadDidactica->nombre }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; line-height: 1.3; }
        .container { max-width: 100%; margin: 0 auto; padding: 15px; }
        .header { text-align: center; border-bottom: 2px solid #1a365d; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { color: #1a365d; margin: 0; font-size: 16px; }
        .header h2 { color: #666; margin: 5px 0; font-size: 13px; }
        .info-box { background: #f9f9f9; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .info-item { display: flex; }
        .info-label { font-weight: bold; margin-right: 5px; }
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
        @media print {
            .no-print { display: none; }
            body { font-size: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>REPORTE DE NOTAS</h1>
            <h2>{{ $asignacion->unidadDidactica->nombre }}</h2>
        </div>

        <div class="info-box">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Código:</span>
                    <span>{{ $asignacion->unidadDidactica->codigo }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Período:</span>
                    <span>{{ $asignacion->periodoLectivo->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ciclo:</span>
                    <span>{{ $asignacion->unidadDidactica->ciclo }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Programa:</span>
                    <span>{{ $asignacion->unidadDidactica->planEstudio->programaEstudio->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Turno:</span>
                    <span>{{ $asignacion->turno->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Docente:</span>
                    <span>{{ $asignacion->personal->nombre_completo }}</span>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th class="text-left">Apellidos y Nombres</th>
                    <th>N1</th>
                    <th>N2</th>
                    <th>N3</th>
                    <th>N4</th>
                    <th>PP</th>
                    <th>EF</th>
                    <th>PF</th>
                    <th>RC</th>
                    <th>ND</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php $aprobados = 0; $desaprobados = 0; @endphp
                @foreach($estudiantes as $index => $detalle)
                    @php
                        $nota = $detalle->nota;
                        if(($nota?->nota_definitiva ?? 0) >= 13) $aprobados++; 
                        else if($nota?->nota_definitiva) $desaprobados++;
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
                        <td class="{{ ($nota?->nota_definitiva ?? 0) >= 13 ? 'approved' : 'failed' }}">
                            {{ $nota?->nota_definitiva ?? '-' }}
                        </td>
                        <td>{{ $nota?->estado ? ucfirst($nota->estado) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="info-box" style="margin-top: 15px;">
            <strong>Resumen:</strong> 
            Total: {{ $estudiantes->count() }} | 
            Aprobados: {{ $aprobados }} | 
            Desaprobados: {{ $desaprobados }} |
            Pendientes: {{ $estudiantes->count() - $aprobados - $desaprobados }}
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div class="signature-line">Docente</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Coordinador de Programa</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Secretaría Académica</div>
            </div>
        </div>

        <div class="footer">
            <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>N1-N4: Notas parciales | PP: Promedio Parcial | EF: Examen Final | PF: Promedio Final | RC: Recuperación | ND: Nota Definitiva</p>
        </div>

        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #1a365d; color: white; border: none; cursor: pointer; border-radius: 5px;">
                Imprimir Reporte
            </button>
            <a href="{{ route('docente.asignaciones') }}" style="margin-left: 10px; padding: 10px 20px; background: #666; color: white; text-decoration: none; border-radius: 5px;">
                Volver
            </a>
        </div>
    </div>
</body>
</html>
