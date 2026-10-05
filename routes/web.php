<?php

use Illuminate\Support\Facades\Route;

/*
    # Routeo del sitio
    Convenciones usadas (iguales a las vistas en clase):
        - URLs en español, nombres de ruta "recurso.accion".
        - Controllers asociados con el array [Clase::class, 'metodo'].
        - whereNumber() para validar los parámetros de ruta numéricos.
        - Feedback al usuario flasheando 'feedback.message' / 'feedback.type'.

    Estructura general:
        1. Rutas públicas del sitio (home, libros, blog).
        2. Autenticación propia (sin controllers/interfaz de Laravel).
        3. Reseñas (requieren sesión iniciada).
        4. Grupo de administración bajo /admin (auth + middleware "admin").
*/

// ---------------------------------------------------------------
// 1. Sitio público
// ---------------------------------------------------------------

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('index');

// Libros (producto a la venta)
Route::get('/libros', [\App\Http\Controllers\BooksController::class, 'index'])
    ->name('books.index');
Route::get('/libros/{id}', [\App\Http\Controllers\BooksController::class, 'show'])
    ->whereNumber('id')
    ->name('books.show');

// Blog / novedades / noticias
Route::get('/blog', [\App\Http\Controllers\PostsController::class, 'index'])
    ->name('posts.index');
Route::get('/blog/{id}', [\App\Http\Controllers\PostsController::class, 'show'])
    ->whereNumber('id')
    ->name('posts.show');

// ---------------------------------------------------------------
// 2. Autenticación (implementada a mano, como vimos en clase)
// ---------------------------------------------------------------

Route::get('/iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'showForm'])
    ->name('auth.login.form');
Route::post('/iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'processForm'])
    ->name('auth.login.process');
Route::post('/cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'processLogout'])
    ->name('auth.logout.process');

// ---------------------------------------------------------------
// 3. Reseñas de libros (solo usuarios con sesión iniciada)
// ---------------------------------------------------------------

Route::post('/libros/{id}/resenar', [\App\Http\Controllers\ReviewController::class, 'store'])
    ->whereNumber('id')
    ->middleware('auth')
    ->name('reviews.store');

// ---------------------------------------------------------------
// 4. Panel de administración
//    Se usa un grupo de rutas con prefijo /admin que aplica dos
//    middleware: "auth" (de Laravel) y "admin" (propio), que
//    verifica que el usuario tenga el rol administrador.
//    El nombre de ruta se prefija con "admin.".
// ---------------------------------------------------------------

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard con estadísticas del sitio
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])
        ->name('home');

    // ABM de entradas del blog (index/show/create/store/edit/update/delete/destroy)
    Route::get('/posts', [\App\Http\Controllers\Admin\PostsController::class, 'index'])
        ->name('posts.index');

    Route::get('/posts/crear', [\App\Http\Controllers\Admin\PostsController::class, 'create'])
        ->name('posts.create');
    Route::post('/posts', [\App\Http\Controllers\Admin\PostsController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{id}/editar', [\App\Http\Controllers\Admin\PostsController::class, 'edit'])
        ->whereNumber('id')
        ->name('posts.edit');
    Route::post('/posts/{id}', [\App\Http\Controllers\Admin\PostsController::class, 'update'])
        ->whereNumber('id')
        ->name('posts.update');

    // Como vimos en clase: "delete" muestra la vista de confirmación
    // y "destroy" recibe el POST que efectivamente elimina el registro.
    Route::get('/posts/{id}/eliminar', [\App\Http\Controllers\Admin\PostsController::class, 'delete'])
        ->whereNumber('id')
        ->name('posts.delete');
    Route::post('/posts/{id}/eliminar', [\App\Http\Controllers\Admin\PostsController::class, 'destroy'])
        ->whereNumber('id')
        ->name('posts.destroy');
});
