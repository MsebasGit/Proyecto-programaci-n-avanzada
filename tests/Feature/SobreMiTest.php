<?php

namespace Tests\Feature;

use App\Models\Habilidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SobreMiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_sobre_mi_page_is_accessible_and_shows_skills()
    {
        // Crear habilidades de prueba
        Habilidad::create(['nombre' => 'Laravel Test', 'porcentaje' => 88]);
        Habilidad::create(['nombre' => 'Vue Test', 'porcentaje' => 77]);

        $response = $this->get(route('sobre-mi'));

        $response->assertStatus(200);
        $response->assertSee('Sobre Mí');
        
        // Verificar que se muestren las habilidades creadas
        $response->assertSee('Laravel Test');
        $response->assertSee('88%');
        $response->assertSee('Vue Test');
        $response->assertSee('77%');
    }
}
