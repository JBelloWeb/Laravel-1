<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showForm(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de login.
     */
    public function processForm(Request $request): RedirectResponse
    {
        // 1) Validación server-side con mensajes propios.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Ingresá tu correo electrónico.',
            'email.email' => 'El correo no tiene un formato válido.',
            'password.required' => 'Ingresá tu contraseña.',
        ]);

        // 2) Compara email+password hasheada contra la BD.
        //    No incluimos "role" en las credenciales: el rol se
        //    chequea después, en el middleware.
        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->with('feedback.message', 'El correo o la contraseña no son correctos.')
                ->with('feedback.type', 'danger');
        }

        // 3) Nueva sesión para evitar fijación de sesión.
        $request->session()->regenerate();

        // 4) Según el rol, adónde va después de entrar.
        $destino = Auth::user()->role === 'admin'
            ? route('admin.home')
            : route('index');

        return redirect()->to($destino)
            ->with('feedback.message', '¡Hola de nuevo, ' . Auth::user()->name . '!')
            ->with('feedback.type', 'success');
    }

    /**
     * Cierra la sesión (patrón de clase).
     */
    public function processLogout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();       // borra los datos de la sesión
        $request->session()->regenerateToken();  // regenera el token _token

        return redirect()->route('index')
            ->with('feedback.message', 'Cerraste la sesión. ¡Hasta luego!')
            ->with('feedback.type', 'success');
    }
}
