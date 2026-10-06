# Librería Sempere — Parcial 1 (Portales y Comercio Electrónico)

Web dinámica de una librería con:

- **Sitio público**: home que presenta el catálogo, listado y detalle de libros (producto a la venta) con reseñas de usuarios, blog de novedades/noticias y login de usuarios.
- **Panel de administración** (`/admin`): autenticación propia (sin la interfaz/controllers de Laravel) protegida por middleware, con ABM completo de las entradas del blog.

**Alumno:** Juan Ignacio Peralta Bello · **Docente:** Santiago Gallino · **Comisión:** DMW3AP · 2026.

## Requisitos

- PHP >= 8.3 (con `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `zip`)
- Composer
- MariaDB/MySQL
- Conexión a internet (Tailwind CSS v4 se carga por CDN)

## Instalación

```bash
composer install
cp .env.example .env        # y ajustar DB_DATABASE=peraltabello_juan, DB_PORT=3307
php artisan key:generate
php artisan migrate --seed  # crea las tablas y carga los datos de ejemplo
php artisan storage:link
php artisan serve           # http://localhost:8000
```

La base de datos debe llamarse `peraltabello_juan` (utf8mb4).

## Datos de acceso

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | `admin@libreriasempere.test` | `password` |
| Lectores (reseñas) | `lucia@correo.test` / `martin@correo.test` | `password` |

## Estructura

```
app/Http/Controllers/        Home, Auth, Books, Posts, Review + Admin/ (ABM)
app/Http/Middleware/         EnsureUserIsAdmin (alias "admin")
app/Models/                  User, Book, Post, Category, Publisher, Review
database/migrations/         users + publishers, books, categories, posts,
                             category_post, reviews, role en users
database/seeders/            datos de ejemplo (users, libros, posts, reseñas…)
resources/views/             layouts (x-layouts.main / .admin), sitio y admin
routes/web.php               rutas públicas, auth y grupo /admin
public/css/style.css         estilos propios (complementan Tailwind CDN)
```

## Base de datos

7 tablas: `users`, `publishers`, `books`, `posts`, `categories`, `category_post` (N:N) y `reviews` (N:N users↔books), creadas con migrations y pobladas con seeders.
