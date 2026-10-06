<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_invitado_es_redirigido_al_login(): void
    {
        $this->get(route('admin.home'))
            ->assertRedirect(route('auth.login.form'));
    }

    public function test_un_cliente_no_puede_entrar_al_panel(): void
    {
        $cliente = $this->crearUsuario('cliente');

        $this->actingAs($cliente)
            ->get(route('admin.home'))
            ->assertRedirect(route('index'))
            ->assertSessionHas('feedback.message');
    }

    public function test_un_admin_puede_ver_el_panel(): void
    {
        $admin = $this->crearUsuario('admin');

        $this->actingAs($admin)
            ->get(route('admin.home'))
            ->assertOk();
    }

    public function test_un_admin_puede_ver_el_listado_de_entradas(): void
    {
        $admin = $this->crearUsuario('admin');

        $this->actingAs($admin)
            ->get(route('admin.posts.index'))
            ->assertOk();
    }

    private function crearUsuario(string $rol): User
    {
        return User::create([
            'name' => 'Usuario ' . $rol,
            'email' => $rol . '@correo.test',
            'password' => 'password',
            'role' => $rol,
        ]);
    }
}
