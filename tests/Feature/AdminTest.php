<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Materia;
use App\Models\Habilidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guests are redirected to login.
     */
    public function test_guest_cannot_access_admin_panel()
    {
        $response = $this->get(route('admin'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test that authenticated users can see the admin panel.
     */
    public function test_authenticated_user_can_access_admin_panel()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin'));

        $response->assertStatus(200);
        $response->assertSee('Panel de Administración');
        $response->assertSee('Gestión de Materias');
        $response->assertSee('Gestión de Habilidades');
    }

    /**
     * Test creating a materia.
     */
    public function test_authenticated_user_can_create_materia()
    {
        $user = User::factory()->create();

        $materiaData = [
            'nombre' => 'Cálculo Numérico',
            'codigo' => 'MAT-230',
            'creditos' => 4,
            'nota_obtenida' => 88.5,
        ];

        $response = $this->actingAs($user)
            ->post(route('admin.materias.store'), $materiaData);

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseHas('materias', [
            'codigo' => 'MAT-230',
            'nombre' => 'Cálculo Numérico',
        ]);
    }

    /**
     * Test updating a materia.
     */
    public function test_authenticated_user_can_update_materia()
    {
        $user = User::factory()->create();
        $materia = Materia::create([
            'nombre' => 'Cálculo Numérico',
            'codigo' => 'MAT-230',
            'creditos' => 4,
            'nota_obtenida' => 88.5,
        ]);

        $updateData = [
            'nombre' => 'Cálculo Numérico Avanzado',
            'codigo' => 'MAT-230',
            'creditos' => 5,
            'nota_obtenida' => 92.0,
        ];

        $response = $this->actingAs($user)
            ->put(route('admin.materias.update', $materia->id), $updateData);

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseHas('materias', [
            'id' => $materia->id,
            'nombre' => 'Cálculo Numérico Avanzado',
            'creditos' => 5,
            'nota_obtenida' => 92.0,
        ]);
    }

    /**
     * Test deleting a materia.
     */
    public function test_authenticated_user_can_delete_materia()
    {
        $user = User::factory()->create();
        $materia = Materia::create([
            'nombre' => 'Cálculo Numérico',
            'codigo' => 'MAT-230',
            'creditos' => 4,
            'nota_obtenida' => 88.5,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('admin.materias.destroy', $materia->id));

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseMissing('materias', [
            'id' => $materia->id,
        ]);
    }

    /**
     * Test creating a habilidad.
     */
    public function test_authenticated_user_can_create_habilidad()
    {
        $user = User::factory()->create();

        $habilidadData = [
            'nombre' => 'Docker',
            'porcentaje' => 65,
        ];

        $response = $this->actingAs($user)
            ->post(route('admin.habilidades.store'), $habilidadData);

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseHas('habilidades', [
            'nombre' => 'Docker',
            'porcentaje' => 65,
        ]);
    }

    /**
     * Test updating a habilidad.
     */
    public function test_authenticated_user_can_update_habilidad()
    {
        $user = User::factory()->create();
        $habilidad = Habilidad::create([
            'nombre' => 'Docker',
            'porcentaje' => 65,
        ]);

        $updateData = [
            'nombre' => 'Docker & Kubernetes',
            'porcentaje' => 80,
        ];

        $response = $this->actingAs($user)
            ->put(route('admin.habilidades.update', $habilidad->id), $updateData);

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseHas('habilidades', [
            'id' => $habilidad->id,
            'nombre' => 'Docker & Kubernetes',
            'porcentaje' => 80,
        ]);
    }

    /**
     * Test deleting a habilidad.
     */
    public function test_authenticated_user_can_delete_habilidad()
    {
        $user = User::factory()->create();
        $habilidad = Habilidad::create([
            'nombre' => 'Docker',
            'porcentaje' => 65,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('admin.habilidades.destroy', $habilidad->id));

        $response->assertRedirect(route('admin'));
        $this->assertDatabaseMissing('habilidades', [
            'id' => $habilidad->id,
        ]);
    }
}
