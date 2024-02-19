<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         // Créer utilisateur Admin
         User::create([
            'is_activated' => 1,
            'role_id' => 1,
            'name' => 'Admin 1',
            'email' => 'admin1@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Admin 1',
            'password' => Hash::make('password123')
        ]);
       
        User::create([
            'is_activated' => 1,
            'role_id' => 1,
            'name' => 'Admin 2',
            'email' => 'admin2@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Admin 2',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => rand(1, 6),
            'name' => 'Restaurant 1',
            'email' => 'restaurant1@example.com',
            'phone' => 773456789,
            'adresse' => 'Adresse Restaurant 1',
            'image' => 'chemin/vers/restaurant1.jpg', 
            'password' => Hash::make('password123')
        ]);
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => rand(1, 6),
            'name' => 'Restaurant 2',
            'email' => 'restaurant2@example.com',
            'phone' => 773456789,
            'adresse' => 'Adresse Restaurant 2',
            'image' => 'chemin/vers/restaurant2.jpg', 
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Client 1',
            'email' => 'client1@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Client 1',
            'password' => Hash::make('password123')
        ]);
       
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Client 2',
            'email' => 'client2@example.com',
            'phone' => 787654322,
            'adresse' => 'Adresse Client 2',
            'password' => Hash::make('password123')
        ]);
       
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Client 3',
            'email' => 'client3@example.com',
            'phone' => 787654343,
            'adresse' => 'Adresse Client 3',
            'password' => Hash::make('password123')
        ]);

         // Créer utilisateur Livreur
         User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'name' => 'Livreur 1',
            'email' => 'livreur1@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Livreur 1',
            'password' => Hash::make('password123')
        ]);
        
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Livreur 2',
            'email' => 'livreur2@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Livreur 2',
            'password' => Hash::make('password123')
        ]);
        
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Livreur 3',
            'email' => 'livreur3@example.com',
            'phone' => 787654321,
            'adresse' => 'Adresse Livreur 3',
            'password' => Hash::make('password123')
        ]);
    }
}
