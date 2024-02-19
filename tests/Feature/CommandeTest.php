<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Plat;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandeTest extends TestCase
{
    use WithFaker;
        public function testCreateCommande()
        {
            
            $client= User::factory()->create([
                'name' => 'Marcel',
                // 'email' => 'marcel@email.com',
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password123',
                'phone' => '768345276',
                'adresse' => "PA",
                'role_id' => 3
            ]);
    
            $this->actingAs($client);

            $commande = [
                "plat_id" => 1,
                "nombrePlats"=>  1,
                "lieuLivraison"=>  "Fadia case ba " 

            ];
    
            $response = $this->post('/api/auth/commande/store', $commande);
    
            $response->assertStatus(201);
                
        }
    
        public function testShowCommande()
        {
            
            $client = $this->post('/api/user/login', [
                'email' => "marcel@email.com",
                'password' => "password123",
            ]);
    
            $response = $this->get('/api/auth/commande/show/10');
    
            $response->assertStatus(200);
                
        }
    
        public function testListCommande()
        {
            $client = $this->post('/api/user/login', [
                'email' => "marcel@email.com",
                'password' => "password123",
            ]);
    
            $plat =  [
                'plat_id' => 1
            ];
    
            $response = $this->post('/api/auth/commande/list', $plat);

            $response->assertStatus(405);
                
        }
    
        public function testModifyCommande() 
        {
             $client = $this->post('/api/user/login', [
                'email' => "marcel@email.com",
                'password' => "password123",
            ]);
            
            $commandeModif = [
                "plat_id" => 1,
                "nombrePlats"=>  1,
                "lieuLivraison"=>  "Sopprim "
            ];
    
            $response = $this->put('/api/auth/commande/update/1', $commandeModif);
            // dd($response);
    
            $response->assertStatus(200);
        }
        
        // public function testAnnulerCommande() 
        // {
        //      $client = $this->post('/api/user/login', [
        //         'email' => "fooddelices@email.com",
        //         'password' => "password123",
        //     ]);
    
        //     $response = $this->delete('api/auth/commande/annuler/34');
    
        //     $response->assertOk();
        // }
        
        // public function testRefuserCommande() 
        // {
        //      $restaurant = $this->post('/api/user/login', [
        //         'email' => "fooddelices@email.com",
        //         'password' => "password123",
        //     ]);
    
        //     $response = $this->put('api/auth/commande/refuser/');
    
        //     $response->assertStatus(200);
        // }


}
