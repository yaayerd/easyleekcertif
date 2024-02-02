<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Http\Middleware\AdminSystem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
   
    public function testCreateMenu()
    {
        // Connecter le user restaurant
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "degustika@email.com",
            'password' => "password123",
        ]);

        // Récupérer le restaurant connecté
        $restaurant = auth()->guard('user-api')->user();
        // dd($restaurant);
        $this->actingAs($restaurant, 'restaurant');
        $menu = [
            'titre' => 'niam niam'
        ];

        $response = $this->post('/api/auth/menu/store', $menu);

        $response->assertStatus(201)
            ->assertJson([
                "status" => true,
                "message" => "Menu ajouté avec succès ",
                "user" => $response->json('menu')
            ]);
            
    }

}
