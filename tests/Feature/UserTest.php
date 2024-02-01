<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testRegisterClientValidated()
    {
        // Ajouter des données valides pour l'inscription d'un patient
        $data = [
            'name' => 'Ahmadou Name',
            'email' =>  'ahmadou@email.com',
            // 'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'phone' => '778524565',
            'adresse' => "Sahm",
        ];

        $response = $this->postJson('/api/user/register', $data);
        // dd($response);
        // Vérifier que la réponse est correcte avec le code HTTP 201
        $response->assertStatus(200);

        // // Vérifier que l'utilisateur a été correctement enregistré dans la base de données
        // $this->assertDatabaseHas('users', [
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'role_id' => 3,
        // ]);

        // Récupérer l'utilisateur de la base de données
        $user = User::where('email', $data['email'])->first();

        // Vérifier que les données correspondent
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['phone'], $user->phone);
        $this->assertEquals($data['adresse'], $user->adresse);
    }


    public function testLoginValidated()
    {

        $existingUser = User::where('email', 'mariama@email.com')->first();
        // Envoi de la requête de connexion
        $response = $this->postJson('/api/user/login', [
            'email' => 'mariama@email.com',
            'password' => "password123",
        ]);

        // On vérifie le status de la réponse (code HTTP) et des données
        // dd($response->status(), $response->json('data'));


        // Vérifications
        $response->assertStatus(200);
        // $this->assertArrayHasKey('token', $response->json());
    }


    public function testRegisterRestaurantValidated()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Food_Delices',
            'email' => 'fooddelices@email.com',
            // 'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'phone' => '768345276',
            'adresse' => "Medina",
            'image' => UploadedFile::fake()->image('article.jpg'),
            'categorie_id' => 6
        ];

        $response = $this->postJson('/api/auth/restaurant/register', $data);

        // $this->withoutMiddleware();
        // dd($response);
        $response->assertStatus(200);
    }

    public function testRestaurantDetails()
    {
        // Connecter le restaurant
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "chezfaya@email.com",
            'password' => "password123",
        ]);

        // Envoyer une requête GET à l'endpoint restaurantMe
        $response = $this->post('/api/auth/restaurant/me');

        // Vérifier que la réponse a un code de statut HTTP 200
        $response->assertStatus(200);
    }

    public function testRestaurantLogout()
    {
        // Connecter le restaurant
        $restaurant = $this->post('/api/restaurant/login', [
            'email' => "degustika@email.com",
            'password' => "password123",
        ]);

        // Envoyer une requête POST à l'endpoint restaurantLogout
        $response = $this->post('/api/auth/restaurant/logout');

        // Vérifier que la réponse a un code de statut HTTP 200
        $response->assertStatus(200);

        // Vérifier que le message de la réponse est correct
        $response->assertJson([
            'status_code' => 200,
            'message' => 'Deconnexion réussie'
        ]);

        // Vérifier que le restaurant est bien déconnecté
        $this->assertGuest('user-api');
    }

    public function testRestaurantModifyProfile()
    {
        // Connecter le restaurant
        $response = $this->post('/api/restaurant/login', [
            'email' => "degustika@email.com",
            'password' => "password123",
        ]);

        // Récupérer le restaurant connecté
        $restaurant = auth()->guard('user-api')->user();

        // Préparer les nouvelles données pour le profil du restaurant
        $newData = [
            'name' => 'Degustika  Miaaam',
            'email' => 'degustimiam@email.com',
            'phone' => '783456789',
            'password' => 'password123',
            'adresse' => 'Memoz',
            'categorie_id' => 1,
            'image' => UploadedFile::fake()->image('newimage.jpg'),
        ];

        // Envoyer une requête PUT à l'endpoint restaurantModifyProfile
        $response = $this->postJson('/api/auth/restaurant/modify/profile/12', $newData);

        // Vérifier que la réponse a un code de statut HTTP 200
        $response->assertStatus(200);
    }

    
}
