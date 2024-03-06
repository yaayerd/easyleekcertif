<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Plat;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlatTest extends TestCase
{
   use WithFaker;
        public function testCreatePlat()
        {
            
            $restaurant = $this->post('/api/restaurant/login', [
                'email' => "fodologie@email.com",
                'password' => "password123",
            ]);
    
            $platIdeal = [
                'libelle' => 'Attiéké Aloco Poulet',
                'prix' => 1000 ,
                'descriptif' => 'Trop bon, trop doux, trop neix',
                'menu_id' => 70 ,
                'image' => 'attieke.jpg',

            ];
    
            $response = $this->post('/api/auth/plat/store', $platIdeal);
    
            $response->assertStatus(201);
                
        }
    
        public function testShowPlat()
        {
            
            $restaurant = $this->post('/api/restaurant/login', [
                'email' => "fodologie@email.com",
                'password' => "password123",
            ]);
    
            $response = $this->get('/api/auth/plat/show/68');
    
            $response->assertStatus(200);
    
            // $response->assertStatus(201)
            //     ->assertJson([
            //         "status" => true,
            //         "message" => "plat ajouté avec succès ",
            //         "user" => $plat
            //     ]);
                
        }
    
        public function testListPlat()
        {
            // $restaurant= User::factory()->create([
            //     'name' => 'Hello Food',
            //     // 'email' => 'hellofood@email.com',
            //     'email' => $this->faker->unique()->safeEmail,
            //     'password' => 'password123',
            //     'phone' => '768345276',
            //     'adresse' => "Fass",
            //     'image' => UploadedFile::fake()->image('plat.jpg'),
            //     'categorie_id' => 5,
            //     'role_id' => 2
            // ]);
            
            $restaurant = $this->post('/api/restaurant/login', [
                'email' => "fooddelices@email.com",
                'password' => "password123",
            ]);

            // $menu = Menu::factory()->create([ 
            //     "titre" => "food vibes",
            //     'user_id'=>$restaurant->id,
            // ]);

            // $plat = Plat::factory()->create([
            //     'libelle' => 'Thiooooou',
            //     'prix' => 500 ,
            //     'descriptif' => 'Trop bon doux, trop neix',
            //     'menu_id' => $menu->id, 
            //     'image' => UploadedFile::fake()->image('thiou.jpg'),
            // ]);
            
            // $token = JWTAuth::fromUser($restaurant);
            // dd($token);
            // $response = $this->withHeader('Authorization', 'Bearer' . $token)
            //          ->get('/api/auth/plat/list/restaurant',[
            //             'menu_id' => $menu->id,
            //         ]);
            // dd($response);
    
            $response = $this->post('/api/auth/plat/list/restaurant');

            $response->assertStatus(405);
                
        }
    
        public function testModifyPlat() 
        {
             // Connecter le user restaurant
             $restaurant = $this->post('/api/restaurant/login', [
                'email' => "fodologie@email.com",
                'password' => "password123",
            ]);
            
            $platModif = [
                'libelle' => 'Mafeeee ',
                'prix' => 1000 ,
                'descriptif' => 'Trop bon, trop doux, trop neix',
                'menu_id' => 70 ,
                'image' => 'MAFE.jpg',
            ];
    
            $response = $this->put('/api/auth/plat/update/71', $platModif);
            // dd($response);
    
            $response->assertStatus(200);
        }
        
        // public function testDeletePlat() 
        // {
        //      // Connecter le user restaurant
        //      $restaurant = $this->post('/api/restaurant/login', [
        //         'email' => "fooddelices@email.com",
        //         'password' => "password123",
        //     ]);
    
        //     $response = $this->delete('/api/auth/plat/delete/11');
    
        //     $response->assertStatus(200);
        // }
    
    
}
