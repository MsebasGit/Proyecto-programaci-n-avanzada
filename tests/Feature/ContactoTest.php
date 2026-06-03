<?php

namespace Tests\Feature;

use App\Models\Contacto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_contacto_page_is_accessible()
    {
        $response = $this->get(route('contacto'));
        $response->assertStatus(200);
        $response->assertSee('Contacto');
    }

    /** @test */
    public function test_contacto_form_saves_data_and_redirects()
    {
        $data = [
            'nombre' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
            'mensaje' => 'Este es un mensaje de prueba de más de diez caracteres.',
        ];

        $response = $this->post(route('contacto.procesar'), $data);

        $response->assertRedirect(route('contacto'));
        $response->assertSessionHas('exito', 'Tu mensaje fue enviado correctamente.');

        // Verifica que se haya guardado en la base de datos
        $this->assertDatabaseHas('contactos', [
            'nombre' => 'Juan Perez',
            'email' => 'juan.perez@example.com',
            'mensaje' => 'Este es un mensaje de prueba de más de diez caracteres.',
        ]);
    }

    /** @test */
    public function test_contacto_validation_requires_fields()
    {
        $response = $this->post(route('contacto.procesar'), [
            'nombre' => '',
            'email' => 'invalid-email',
            'mensaje' => 'corto',
        ]);

        $response->assertSessionHasErrors(['nombre', 'email', 'mensaje']);
        $this->assertDatabaseCount('contactos', 0);
    }
}
