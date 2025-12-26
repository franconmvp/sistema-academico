<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Matrícula - {{ $estudiante->codigo_estudiante }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #1a365d; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #1a365d; margin: 0; font-size: 18px; }
        .header h2 { color: #d4a017; margin: 5px 0; font-size: 14px; }
        .section { margin-bottom: 20px; }
        .section-title { background: #1a365d; color: white; padding: 5px 10px; font-weight: bold; margin-bottom: 10px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .info-item { display: flex; }
        .info-label { font-weight: bold; width: 120px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; color: #666; font-size: 10px; }
        .signature-area { margin-top: 60px; display: flex; justify-content: space-between; }
        .signature-box { text-align: center; width: 200px; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; }
        @media print { .no-print { display: none; } body { font-size: 11px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FICHA DE MATRÍCULA</h1>
            <h2>{{ $matricula->periodoLectivo->nombre }}</h2>
        </div>

        <div class="section">
            <div class="section-title">DATOS DEL ESTUDIANTE</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Código:</span>
                    <span>{{ $estudiante->codigo_estudiante }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">DNI:</span>
                    <span>{{ $estudiante->dni }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Apellidos:</span>
                    <span>{{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nombres:</span>
                    <span>{{ $estudiante->nombres }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Programa:</span>
                    <span>{{ $estudiante->programaEstudio->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Plan:</span>
                    <span>{{ $estudiante->planEstudio->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Turno:</span>
                    <span>{{ $estudiante->turno->nombre }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ciclo:</span>
                    <span>{{ $matricula->ciclo }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">UNIDADES DIDÁCTICAS MATRICULADAS</div>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Unidad Didáctica</th>
                        <th style="text-align: center;">Créditos</th>
                        <th style="text-align: center;">Horas</th>
                        <th>Docente</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalCreditos = 0; $totalHoras = 0; @endphp
                    @foreach($matricula->detalles as $detalle)
                        @php 
                            $totalCreditos += $detalle->unidadDidactica->creditos;
                            $totalHoras += $detalle->unidadDidactica->horas_semanales;
                        @endphp
                        <tr>
                            <td>{{ $detalle->unidadDidactica->codigo }}</td>
                            <td>{{ $detalle->unidadDidactica->nombre }}</td>
                            <td style="text-align: center;">{{ $detalle->unidadDidactica->creditos }}</td>
                            <td style="text-align: center;">{{ $detalle->unidadDidactica->horas_semanales }}</td>
                            <td>{{ $detalle->asignacionDocente?->personal?->nombre_completo ?? 'Por asignar' }}</td>
                        </tr>
                    @endforeach
                    <tr style="font-weight: bold; background: #f9f9f9;">
                        <td colspan="2" style="text-align: right;">TOTAL:</td>
                        <td style="text-align: center;">{{ $totalCreditos }}</td>
                        <td style="text-align: center;">{{ $totalHoras }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature-area">
            <div class="signature-box">
                <div class="signature-line">Estudiante</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Secretaría Académica</div>
            </div>
        </div>

        <div class="footer">
            <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #1a365d; color: white; border: none; cursor: pointer; border-radius: 5px;">
                Imprimir Ficha
            </button>
            <a href="{{ route('estudiante.mis-matriculas') }}" style="margin-left: 10px; padding: 10px 20px; background: #666; color: white; text-decoration: none; border-radius: 5px;">
                Volver
            </a>
        </div>
    </div>
</body>
</html>
