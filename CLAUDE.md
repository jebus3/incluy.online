# Incluy Online — CLAUDE.md

## Propósito del proyecto

**Incluy Online** es el panel de administración de Incluy, reescrito en **Laravel 11** para compatibilidad con hosting compartido cPanel. Reemplaza al proyecto anterior `incluy-admin` (Next.js), que requería Node.js no disponible en el servidor de producción.

Administra las tablas Supabase PostgreSQL que alimentan el sitio web:

- **Directorio**: organizaciones y profesionales
- **Admin usuarios**: gestión de administradores del panel
- **Eventos**: creación y gestión de eventos (pendiente)
- **Comunidad**: usuarios clientes (pendiente)

> ⚠️ Este proyecto NO gestiona contenido editorial (blog, noticias, guías, leyes).
> Ese contenido lo administra **REDI Vibes** via OctoberCMS en `c:\laragon\www\redivibes`.

---

## Stack

- **Framework:** Laravel 11
- **Vistas:** Blade + Alpine.js (sin React, sin build step en servidor)
- **Estilos:** Tailwind CSS v4 (compilado localmente, se sube el CSS ya compilado)
- **Base de datos:** PostgreSQL directo via driver `pgsql` de Laravel (Supabase como host)
- **Auth:** Laravel Auth custom sobre tabla `admin_users` (NO la tabla `users` default)
- **Servidor prod:** cPanel shared hosting con PHP 8.2+

---

## Conexión a la base de datos (Supabase PostgreSQL)

En `.env`:

```
DB_CONNECTION=pgsql
DB_HOST=aws-1-sa-east-1.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.psshyiearppcutkryxlc
DB_PASSWORD=<password real en .env, nunca en git>
PGSSLMODE=require
```

En `config/database.php`, la conexión `pgsql` ya viene lista en Laravel. Solo asegurarse de que tenga SSL:

```php
'pgsql' => [
    'driver'   => 'pgsql',
    'host'     => env('DB_HOST', '127.0.0.1'),
    'port'     => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'postgres'),
    'username' => env('DB_USERNAME', 'postgres'),
    'password' => env('DB_PASSWORD', ''),
    'sslmode'  => env('PGSSLMODE', 'require'),
    'charset'  => 'utf8',
    'prefix'   => '',
    'schema'   => 'public',
],
```

### Cómo hacer queries

```php
// Via DB facade (para queries directas a tablas existentes de Supabase)
use Illuminate\Support\Facades\DB;

$orgs = DB::table('directorio_organizaciones')->where('activa', true)->get();

// Via Eloquent (crear modelos apuntando a tablas existentes)
class Organizacion extends Model {
    protected $table = 'directorio_organizaciones';
    public $timestamps = false; // la tabla usa created_at pero no updated_at estándar
}
```

> ⚠️ No correr `php artisan migrate` sobre las tablas de negocio — ya existen en Supabase.
> Las migraciones solo aplican para tablas propias del panel (si se crean nuevas).

---

## Autenticación

- Tabla: `admin_users` (ya existe en Supabase, NO crear nueva)
- Campos: `id`, `username`, `email`, `password_hash` (bcrypt), `role`, `created_at`
- Login acepta `username` O `email` + contraseña
- Roles: `super_admin`, `admin`, `editor`
- Super admin inicial: `jesus.olivares`

**NO usar** el sistema de auth default de Laravel (tabla `users`). Implementar auth custom:

```php
// En AuthController::login()
$admin = DB::table('admin_users')
    ->where('username', $request->usuario)
    ->orWhere('email', $request->usuario)
    ->first();

if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
    return back()->withErrors(['usuario' => 'Credenciales incorrectas.']);
}

session(['admin' => (array) $admin]);
return redirect('/dashboard');
```

Proteger rutas con middleware custom `CheckAdminSession`:

```php
// app/Http/Middleware/CheckAdminSession.php
if (!session('admin')) {
    return redirect('/login');
}
```

---

## Estructura del proyecto

```
incluy-online/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         ← login / logout
│   │   │   ├── DashboardController.php    ← home stats
│   │   │   ├── DirectorioController.php   ← CRUD organizaciones
│   │   │   ├── ProfesionalesController.php← CRUD profesionales
│   │   │   └── AdminUsuariosController.php← CRUD admin_users
│   │   └── Middleware/
│   │       └── CheckAdminSession.php      ← protección de rutas
│   └── Models/
│       ├── Organizacion.php               ← tabla directorio_organizaciones
│       ├── Profesional.php                ← tabla directorio_profesionales
│       └── AdminUser.php                  ← tabla admin_users
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php              ← layout con sidebar
│   │   ├── auth/
│   │   │   └── login.blade.php            ← formulario de login
│   │   ├── dashboard/
│   │   │   └── index.blade.php            ← home stats
│   │   ├── directorio/
│   │   │   ├── index.blade.php            ← tabla organizaciones
│   │   │   └── profesionales/
│   │   │       └── index.blade.php        ← tabla profesionales
│   │   └── admin-usuarios/
│   │       └── index.blade.php            ← tabla admin_users
│   └── css/
│       └── app.css                        ← Tailwind + variables brand
├── routes/
│   └── web.php                            ← todas las rutas del panel
├── public/
│   ├── build/                             ← CSS/JS compilado (se sube a prod)
│   └── index.php                          ← entry point (apuntar aquí en cPanel)
├── .env                                   ← credenciales (nunca en git)
├── .env.example                           ← template
└── vite.config.js                         ← config Vite para compilar assets
```

---

## Rutas (routes/web.php)

```php
// Login
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Panel protegido
Route::middleware('check.admin')->group(function () {
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('directorio',              DirectorioController::class);
    Route::resource('directorio/profesionales',ProfesionalesController::class);
    Route::resource('admin-usuarios',          AdminUsuariosController::class);
});
```

---

## Tablas Supabase — Estructura de referencia

### `admin_users`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | bigserial PK | |
| username | varchar | único |
| email | varchar | único |
| password_hash | varchar | bcrypt |
| role | varchar | super_admin / admin / editor |
| created_at | timestamptz | |

### `directorio_organizaciones`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| nombre | varchar | |
| slug | varchar | único |
| tipo | varchar | ver tipos abajo |
| rut | varchar | nullable |
| descripcion | text | nullable |
| logo_url | varchar | nullable |
| sitio_web | varchar | nullable |
| email_contacto | varchar | nullable |
| telefono | varchar | nullable |
| verificada | boolean | default false |
| activa | boolean | default true |
| created_at | timestamptz | |
| region_id | uuid | FK a regiones |
| direccion | varchar | nullable |
| atiende_online | boolean | nullable |
| atiende_domicilio | boolean | nullable |

**Tipos de organización:** `fundacion`, `asociacion`, `ong`, `clinica`, `hospital`, `municipio`, `gobierno`, `educacion`, `empresa`, `cooperativa`, `otro`

### `directorio_profesionales`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| nombre_completo | varchar | |
| slug | varchar | único |
| tipo_profesional | varchar | ver tipos abajo |
| rut | varchar | nullable |
| descripcion | text | nullable |
| foto_url | varchar | nullable |
| email_contacto | varchar | nullable |
| telefono | varchar | nullable |
| linkedin_url | varchar | nullable |
| verificado | boolean | default false |
| activo | boolean | default true |
| created_at | timestamptz | |
| region_id | uuid | nullable |
| comuna_id | uuid | nullable |
| atiende_online | boolean | nullable |
| atiende_domicilio | boolean | nullable |

**Tipos de profesional:** `psicologia`, `medicina`, `terapia_ocupacional`, `fonoaudiologia`, `kinesiologia`, `trabajo_social`, `educacion_diferencial`, `derecho`, `lsch`, `nutricion`, `fisioterapia`, `neurologia`, `psiquiatria`, `oftalmologia`, `audiologia`, `otro`

---

## Brand System

```css
/* Variables en resources/css/app.css */
:root {
  --violet: #004494;    /* primario */
  --pink:   #3C2D6D;    /* secundario */
  --orange: #B38F23;    /* acento */
  --deep:   #0A0E27;    /* texto oscuro */
  --slate:  #1E2749;    /* texto secundario */
  --gray:   #6B7C93;    /* texto terciario */
  --ice:    #F0F4F8;    /* fondo principal */
}
```

```
Gradiente sidebar:  linear-gradient(180deg, #004494, #3C2D6D)
Gradiente botones:  linear-gradient(135deg, #004494, #3C2D6D)
```

En Blade, usar estilos inline para colores brand (no clases Tailwind para colores custom):

```html
<aside style="background: linear-gradient(180deg, #004494, #3C2D6D)">
<button style="background: linear-gradient(135deg, #004494, #3C2D6D)">
```

---

## Módulos a implementar

| Módulo | Ruta | Tabla | Estado |
|--------|------|-------|--------|
| Login/Logout | `/login` | `admin_users` | ⬜ Pendiente |
| Dashboard | `/` | — (stats) | ⬜ Pendiente |
| Organizaciones | `/directorio` | `directorio_organizaciones` | ⬜ Pendiente |
| Profesionales | `/directorio/profesionales` | `directorio_profesionales` | ⬜ Pendiente |
| Admin Usuarios | `/admin-usuarios` | `admin_users` | ⬜ Pendiente |
| Eventos | `/eventos` | `eventos` | ⬜ Futuro |
| Comunidad | `/comunidad` | `comunidad_usuarios` | ⬜ Futuro |

---

## Comandos frecuentes

```bash
# Crear proyecto (solo primera vez)
composer create-project laravel/laravel incluy-online
cd incluy-online

# Instalar Tailwind + Alpine
npm install -D tailwindcss @tailwindcss/vite alpinejs
npm run build   # compilar assets (se sube public/build/ a producción)

# Desarrollo local (Laragon sirve PHP automáticamente)
# Acceder en: http://incluy-online.test

# Compilar assets para subir a prod
npm run build
```

---

## Deploy en cPanel (producción)

### Estructura en el servidor

```
public_html/          ← raíz del dominio incluy.online
└── panel/            ← subcarpeta con todo el proyecto Laravel
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── ...
    └── public/       ← aquí debe apuntar el document root del dominio
```

### Opción A: Cambiar document root en cPanel
En cPanel → Dominios → Editar → cambiar Document Root a `public_html/panel/public`

### Opción B: .htaccess en public_html (si no puedes cambiar document root)
```apache
# public_html/.htaccess
RewriteEngine On
RewriteRule ^(.*)$ public/index.php [L]
```
Y mover el contenido de `public/` a `public_html/` con este `index.php` modificado:

```php
// public_html/index.php
require __DIR__.'/panel/vendor/autoload.php';
$app = require_once __DIR__.'/panel/bootstrap/app.php';
// ...
```

### Pasos para subir por FTP

1. Correr localmente: `composer install --no-dev --optimize-autoloader` y `npm run build`
2. Subir por FTP todo **excepto**: `.git/`, `node_modules/`, `.env`, `tests/`
3. Crear `.env` manualmente en el servidor (copiar de `.env.example` y completar)
4. Vía cPanel Terminal (o SSH): `php artisan key:generate`
5. Verificar permisos: `storage/` y `bootstrap/cache/` deben ser `775`
6. Listo — no se necesita `php artisan migrate` (tablas ya existen en Supabase)

### Variables .env para producción

```
APP_NAME="Incluy Admin"
APP_ENV=production
APP_KEY=                    ← generada con php artisan key:generate
APP_DEBUG=false
APP_URL=https://incluy.online

DB_CONNECTION=pgsql
DB_HOST=aws-1-sa-east-1.pooler.supabase.com
DB_PORT=6543
DB_DATABASE=postgres
DB_USERNAME=postgres.psshyiearppcutkryxlc
DB_PASSWORD=<password real>
PGSSLMODE=require

SESSION_DRIVER=file
SESSION_LIFETIME=480
CACHE_STORE=file
```

---

## Convenciones de desarrollo

- Blade para todas las vistas — sin Inertia, sin React
- Alpine.js para interactividad (modales, dropdowns, toggles) — cargado via npm
- No usar Livewire — innecesario para este panel
- DB facade para queries a tablas Supabase existentes (evitar migraciones sobre ellas)
- Modelos Eloquent con `$table` explícito y `public $timestamps = false` si aplica
- Controladores resourceful (index, create, store, edit, update, destroy)
- Middleware `check.admin` protege todas las rutas del panel
- Sesión PHP nativa (no tokens JWT) — más simple en cPanel

---

## Notas de seguridad

- Nunca subir `.env` a git ni a FTP de forma pública
- Usar `Hash::check()` de Laravel (bcrypt) para verificar contraseñas de `admin_users`
- Proteger acceso directo a `storage/` y `bootstrap/cache/` via `.htaccess`
- En producción: `APP_DEBUG=false` siempre
