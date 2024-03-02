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
        // Créer les rôles dans la base de données
    
        // Créer le rôle 'AdminSystem'
        Role::factory()->create([
            'nom' => 'Role_AdminSystem',
            'description' => 'Rôle attribué aux administrateurs système avec des privilèges étendus sur l\'ensemble du système. Ces utilisateurs peuvent gérer les paramètres globaux et avoir un accès administratif complet.',
        ]);
    
        // Créer le rôle 'Restaurant'
        Role::factory()->create([
            'nom' => 'Role_Restaurant',
            'description' => 'Rôle destiné aux utilisateurs responsables de la gestion d\'un restaurant. Les utilisateurs avec ce rôle peuvent créer et modifier des menus ainsi que les plats, gérer les commandes et effectuer des tâches spécifiques liées au restaurant.',
        ]);
    
        // Créer le rôle 'Client'
        Role::factory()->create([
            'nom' => 'Role_Client',
            'description' => 'Rôle attribué aux clients de l\'application. Ces utilisateurs peuvent consulter les menus, passer des commandes et interagir avec l\'application en tant que clients.',
        ]);
    
        // Créer le rôle 'Livreur'
        // Role::factory()->create([
        //     'nom' => 'Role_Livreur',
        //     'description' => 'Rôle destiné aux livreurs responsables de la livraison des commandes. Les utilisateurs avec ce rôle peuvent gérer les détails de livraison, confirmer les livraisons et interagir avec les clients pour les informations de livraison.',
        // ]);
    }
}
