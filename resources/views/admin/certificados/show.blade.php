<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $certificado->tipo_label }} - {{ $certificado->numero_documento }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 14px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; border: 3px double #1a365d; }
        .header { text-align: center; border-bottom: 2px solid #d4a017; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #1a365d; margin: 0; font-size: 28px; letter-spacing: 2px; }
        .header h2 { color: #d4a017; margin: 10px 0 0; font-size: 18px; }
        .doc-number { text-align: center; font-size: 12px; color: #666; margin-bottom: 30px; }
        .content { text-align: justify; margin-bottom: 30px; }
        .student-info { background: #f9f9f9; padding: 20px; margin: 20px 0; border-left: 4px solid #d4a017; }
        .student-info p { margin: 5px 0; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #666; }
        .signature-area { margin-top: 60px; display: flex; justify-content: space-around; }
        .signature-box { text-align: center; width: 200px; }
        .signature-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 5px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ strtoupper($certificado->tipo_label) }}</h1>
            <h2>{{ $certificado->estudiante->programaEstudio->institution->nombre ?? 'Instituto de Educación Superior' }}</h2>
        </div>
        <div class="doc-number">N° {{ $certificado->numero_documento }}</div>
        <div class="content">
            <p>El Director General del Instituto de Educación Superior, que suscribe:</p>
            <p><strong>CERTIFICA:</strong></p>
            <p>Que, <strong>{{ $certificado->estudiante->nombre_completo }}</strong>, identificado(a) con {{ $certificado->estudiante->tipo_documento }} N° <strong>{{ $certificado->estudiante->numero_documento }}</strong>, ha cursado y aprobado satisfactoriamente los estudios correspondientes al programa de estudios de <strong>{{ $certificado->estudiante->programaEstudio->nombre }}</strong>.</p>
        </div>
        <div class="student-info">
            <p><strong>Código de Estudiante:</strong> {{ $certificado->estudiante->codigo_estudiante }}</p>
            <p><strong>Programa de Estudios:</strong> {{ $certificado->estudiante->programaEstudio->nombre }}</p>
            <p><strong>Plan de Estudios:</strong> {{ $certificado->estudiante->planEstudio->nombre ?? 'N/A' }}</p>
            <p><strong>Fecha de Emisión:</strong> {{ $certificado->fecha_emision->format('d \d\e F \d\e Y') }}</p>
            @if($certificado->descripcion)
                <p><strong>Observaciones:</strong> {{ $certificado->descripcion }}</p>
            @endif
        </div>
        <p>Se expide el presente documento a solicitud del interesado(a), para los fines que estime conveniente.</p>
        <div class="signature-area">
            <div class="signature-box"><div class="signature-line">Secretario Académico</div></div>
            <div class="signature-box"><div class="signature-line">Director General</div></div>
        </div>
        <div class="footer">
            <p>Emitido el {{ $certificado->fecha_emision->format('d/m/Y') }} | Estado: {{ ucfirst($certificado->estado) }}</p>
            @if($certificado->fecha_entrega)
                <p>Entregado el {{ $certificado->fecha_entrega->format('d/m/Y') }}</p>
            @endif
        </div>
        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: #1a365d; color: white; border: none; cursor: pointer; border-radius: 5px;">Imprimir</button>
            <a href="{{ route('admin.certificados.index') }}" style="margin-left: 10px; padding: 10px 20px; background: #666; color: white; text-decoration: none; border-radius: 5px;">Volver</a>
        </div>
    </div>
</body>
</html>
