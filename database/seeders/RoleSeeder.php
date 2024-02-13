<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Creer les roles dans la base de données


                // Créer le rôle 'AdminSystem'
                Role::factory()->create(['nom' => 'Role_AdminSystem']);

                // Créer le rôle 'Restaurant'
                Role::factory()->create(['nom' => 'Role_Restaurant']);
        
                // Créer le rôle 'Client'
                Role::factory()->create(['nom' => 'Role_Client']);
    }
}
