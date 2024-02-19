<?php

namespace Database\Seeders;

use App\Models\Livreur;
use App\Models\Commande;
use App\Models\Livraison;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LivraisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Livraison::create([
            'etatLivraison' => 'enregistree',
            'prixLivraison' => 1000,
            'commande_id' => Commande::inRandomOrder()->first()->id,
            'livreur_id' => Livreur::inRandomOrder()->first()->id,
        ]);
        Livraison::create([
            'etatLivraison' => 'enregistree',
            'prixLivraison' => 2000,
            'commande_id' => Commande::inRandomOrder()->first()->id,
            'livreur_id' => Livreur::inRandomOrder()->first()->id,
        ]);
        Livraison::create([
            'etatLivraison' => 'enregistree',
            'prixLivraison' => 1500,
            'commande_id' => Commande::inRandomOrder()->first()->id,
            'livreur_id' => Livreur::inRandomOrder()->first()->id,
        ]);
    }
}
