<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protege el panel de administración (/admin).
 *
 * Se registra con el alias "admin" en bootstrap/app.php y se
 * aplica junto con "auth" en el grupo de rutas:
 *   ->middleware(['auth', 'admin'])
 *
 * Orden: "auth" ya garantizó que haya sesión iniciada; acá solo
 * verificamos que el rol sea 'admin'.
 */
class EnsureUserIsAdmin
{
    /**
     * Maneja una petición entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Defensa simple: si no hay usuario o no es admin, no pasa.
        if ($user === null || $user->role !== 'admin') {
            return redirect()
                ->route('index')
                ->with('feedback.message', 'No tenés permiso para entrar al panel de administración.')
                ->with('feedback.type', 'danger');
        }

        return $next($request);
    }
}
