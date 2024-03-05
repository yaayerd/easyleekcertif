<?php

namespace Database\Seeders;

use App\Models\Plat;
use App\Models\User;
use App\Models\Commande;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commande1 = Commande::create([
            'plat_id' => 1,
            'user_id' => 5,
            // 'numeroCommande' => 'CMD123',
            'nombrePlats' => 2,
            // 'nomPlat' => 'Plat 1',
            // 'prixCommande' => 1200,
            'lieuLivraison' => 'Adresse de livraison 1',
            'etatCommande' => 'acceptee',
        ]);
        $commande2 = Commande::create([
            'plat_id' => 2,
            'user_id' => 5,
            // 'numeroCommande' => 'CMD223',
            'nombrePlats' => 2,
            // 'nomPlat' => 'Plat 2 bis',
            // 'prixCommande' => 1200,
            'lieuLivraison' => 'Adresse de livraison 2',
        ]);
        $commande3 = Commande::create([
            'plat_id' => 3,
            'user_id' => 6,
            // 'numeroCommande' => 'CMD323',
            'nombrePlats' => 3,
            // 'nomPlat' => 'Plat 3',
            // 'prixCommande' => 1600,
            'lieuLivraison' => 'Adresse de livraison 3',
        ]);
        $commande4 = Commande::create([
            'plat_id' => 4,
            'user_id' => 6,
            // 'numeroCommande' => 'CMD423',
            'nombrePlats' => 3,
            // 'nomPlat' => 'Plat 3 bis',
            // 'prixCommande' => 1600,
            'lieuLivraison' => 'Adresse de livraison 4',
        ]);
        $commande5 = Commande::create([
            'plat_id' => 5,
            'user_id' => 7,
            // 'numeroCommande' => 'CM423',
            'nombrePlats' => 3,
            // 'nomPlat' => 'Plat 4',
            // 'prixCommande' => 1600,
            'lieuLivraison' => 'Adresse de livraison 5',
        ]);
        $commande6 = Commande::create([
            'plat_id' => 6,
            'user_id' => 7,
            // 'numeroCommande' => 'CMD623',
            'nombrePlats' => 3,
            // 'nomPlat' => 'Plat 4 bis',
            // 'prixCommande' => 1600,
            'lieuLivraison' => 'Adresse de livraison 6',
        ]);

    }
}
