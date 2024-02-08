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

        // Récupérer l'utilisateur de la base de données
        $user = User::where('email', $existingUser['email'])->first();

        // Vérifier que les données correspondent
        $this->assertEquals($existingUser['name'], $user->name);
        $this->assertEquals($existingUser['phone'], $user->phone);
        $this->assertEquals($existingUser['adresse'], $user->adresse);
    }


    public function testRegisterRestaurantValidated()
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            // 'email' => 'admintest@email.com',
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'phone' => '768323276',
            'adresse' => "Thies",
            'role_id' => 1
        ]);
        // dd($admin);
        $this->actingAs($admin);

        Storage::fake('public');

        $resto = [
            'name' => 'Food_Delices',
            'email' => 'fooddelices@email.com',
            // 'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'phone' => '768345276',
            'adresse' => "Medina",
            'image' => UploadedFile::fake()->image('article.jpg'),
            'categorie_id' => 8
        ];

        $response = $this->postJson('/api/auth/restaurant/register', $resto);
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
            'email' => "degustimiam@email.com",
            'password' => "password123",
        ]);

        // dd($restaurant);

        // Envoyer une requête POST à l'endpoint restaurantLogout
        $response = $this->post('/api/auth/restaurant/logout');

        // Vérifier que le message de la réponse est correct
        $response->assertJson([
            'status_code' => 200,
            'message' => 'Deconnexion réussie'
        ]);

        // Vérifier que le restaurant est bien déconnecté
        // $this->assertGuest('user-api');
    }

    public function testRestaurantModifyProfile()
    {
        // Connecter le restaurant
        $response = $this->post('/api/restaurant/login', [
            'email' => "degustimiam@email.com",
            'password' => "password123",
        ]);

        // Récupérer le restaurant connecté
        $restaurant = auth()->guard('user-api')->user();

        // Préparer les nouvelles données pour le profil du restaurant
        $newDataRestaurant = [
            'name' => 'Degustika  Miaaam',
            'email' => 'degustimiam@email.com',
            'phone' => '783456789',
            'password' => 'password123',
            'adresse' => 'Memoz Simplon',
            'categorie_id' => 4,
            'image' => UploadedFile::fake()->image('newimage.jpg'),
        ];

        // Envoyer une requête PUT à l'endpoint restaurantModifyProfile
        $response = $this->postJson('/api/auth/restaurant/modify/profile/12', $newDataRestaurant);

        // Vérifier que la réponse a un code de statut HTTP 200
        $response->assertStatus(200);
    }


    // public function testLogout()
    // {
    //     $structure = StructureSante::factory()->create([
    //         'role_id' => 3,
    //     ]);

    //     $token = JWTAuth::fromUser($structure);

    //     // Connexion de l'utilisateur avec le guard 'structure' en utilisant le token JWT
    //     $this->withHeader('Authorization', 'Bearer ' . $token);

    //     $response = $this->json('GET', '/api/logoutStructure');
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'status' => true,
    //             'message' => $response->json('message'),
    //         ]);

    //     // vérifie si la structure s'est bien déconnectée 
    //     $this->assertGuest('structure');
    // }
}
