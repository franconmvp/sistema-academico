# Sistema Académico - Instituto de Educación Superior

Sistema de gestión académica integral desarrollado en Laravel para instituciones de educación superior. Permite la administración completa de estudiantes, docentes, matrículas, notas y certificados.

## Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- Node.js y npm
- SQLite, MySQL o PostgreSQL

## Instalación

1. **Clonar el repositorio**
```bash
git clone <url-del-repositorio>
cd sistema-academico
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias JavaScript**
```bash
npm install && npm run build
```

4. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de datos**

Para SQLite (desarrollo):
```bash
touch database/database.sqlite
# En .env: DB_CONNECTION=sqlite
```

Para MySQL/PostgreSQL, configure las credenciales en el archivo `.env`.

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
```

7. **Iniciar el servidor de desarrollo**
```bash
php artisan serve
```

## Credenciales de Acceso

Después de ejecutar los seeders, puede acceder al sistema con:

- **Email:** admin@sistema.edu.pe
- **Contraseña:** admin123

## Roles del Sistema

### Administrador
- Gestión completa de información institucional
- Administración de períodos lectivos
- Gestión de personal docente y administrativo
- Administración de programas y planes de estudio
- Gestión de estudiantes y matrículas
- Generación de reportes y certificados
- Creación y gestión de cuentas de usuario

### Docente
- Visualización de asignaciones académicas
- Registro y gestión de notas
- Generación de reportes por período
- Consulta de horarios

### Estudiante
- Visualización de información personal (solo lectura)
- Consulta de historial académico
- Visualización de notas actuales
- Acceso a fichas de matrícula
- Consulta de horarios

## Módulos Principales

### Información Institucional
- Datos generales del instituto
- Logo y configuración

### Períodos Lectivos
- Gestión de semestres académicos
- Activación de período actual

### Programas de Estudio
- Registro de carreras profesionales
- Duración y descripción

### Planes de Estudio
- Asociación con programas
- Vigencia y descripción

### Unidades Didácticas
- Cursos por plan de estudio
- Créditos y horas semanales
- Ciclo correspondiente

### Personal
- Docentes y personal administrativo
- Tipos de contrato
- Especialidades

### Estudiantes
- Datos personales
- Programa y plan de estudio
- Turno asignado

### Turnos
- Mañana, Tarde, Noche
- Horarios de inicio y fin

### Reglas de Promoción
- Límites de matrícula por ciclo y turno

### Matrículas
- Pre-matrícula y matrícula oficial
- Selección de unidades didácticas
- Generación de fichas de matrícula

### Asignación Docente
- Asignación de cursos a docentes
- Período, turno y aula

### Horarios
- Configuración de días y horas por asignación

### Notas
- Registro de notas parciales y final
- Cálculo automático de promedios
- Recuperación y nota definitiva

### Reportes
- Matrícula semestral
- Notas por período
- Actas de evaluación

### Certificados
- Certificados de estudios
- Certificados modulares
- Grados y títulos

## Estructura de Archivos

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # Controladores de administración
│   │   ├── Docente/         # Controladores de docente
│   │   ├── Estudiante/      # Controladores de estudiante
│   │   └── DashboardController.php
│   └── Middleware/          # Middleware de roles
├── Models/                   # Modelos Eloquent
└── View/
    └── Components/           # Componentes de vistas

database/
├── migrations/               # Migraciones de base de datos
└── seeders/                  # Seeders para datos iniciales

resources/views/
├── admin/                    # Vistas de administración
├── docente/                  # Vistas de docente
├── estudiante/               # Vistas de estudiante
├── components/               # Componentes Blade
└── layouts/                  # Layouts principales
```

## Colores del Tema

El sistema utiliza una paleta de colores institucional:

- **Primary (Navy Blue):** #1a365d
- **Secondary (Gold):** #d4a017

Estos colores están configurados en `tailwind.config.js` y se aplican consistentemente en toda la interfaz.

## Testing

Ejecutar las pruebas del sistema:

```bash
php artisan test
```

## Tecnologías Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Blade Templates + Tailwind CSS
- **Autenticación:** Laravel Breeze
- **Base de Datos:** SQLite/MySQL/PostgreSQL
- **Testing:** Pest PHP

## Licencia

Este proyecto es software propietario desarrollado para uso institucional.

## Soporte

Para soporte técnico, contactar al administrador del sistema.
