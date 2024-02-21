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
        
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "fooddelices@email.com",
            'password' => "password123",
        ]);

        $menu = [
            'titre' => 'leeeek'
        ];

        $response = $this->post('/api/auth/menu/store', $menu);

        $response->assertStatus(201);
            
    }

    public function testShowMenu()
    {
        // Connecter le user restaurant
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "fooddelices@email.com",
            'password' => "password123",
        ]);

        $response = $this->get('/api/auth/menu/show/21');

        $response->assertStatus(200);

        // $response->assertStatus(201)
        //     ->assertJson([
        //         "status" => true,
        //         "message" => "Menu ajouté avec succès ",
        //         "user" => $menu
        //     ]);
            
    }

    public function testListMenu()
    {
        // Connecter le user restaurant
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "fooddelices@email.com",
            'password' => "password123",
        ]);

        $response = $this->get('/api/auth/menu/list');

        $response->assertStatus(200);

        // $response->assertStatus(201)
        //     ->assertJson([
        //         "status" => true,
        //         "message" => "Menu ajouté avec succès ",
        //         "user" => $menu
        //     ]);
            
    }

    public function testModifyMenu() 
    {
         // Connecter le user restaurant
         $restaurant = $this->post('/api/restaurant/login', [
            'email' => "fooddelices@email.com",
            'password' => "password123",
        ]);
        
        $menu = [
            'titre' => 'doouuuux'
        ];

        // dd($menu);
        $response = $this->put('/api/auth/menu/update/10', $menu);

        $response->assertStatus(200);
    }
    
    // public function testDeleteMenu() 
    // {
    //      // Connecter le user restaurant
    //      $restaurant = $this->post('/api/restaurant/login', [
    //         'email' => "fooddelices@email.com",
    //         'password' => "password123",
    //     ]);

    //     $response = $this->delete('/api/auth/menu/delete/22');

    //     $response->assertStatus(200);
    // }

}

