<?php

namespace Database\Seeders;

use App\Models\Plat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Thiebou dieune bou wekh',
            'prix' => 600,
            'image' => 'chemin/vers/plat1.jpg',
            'descriptif' => 'Description du plat 1',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Thiebou dieune bou xonk',
            'prix' => 600,
            'image' => 'chemin/vers/plat1bis.jpg',
            'descriptif' => 'Description du plat 1 bis',
        ]);

         Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Thiou yapp',
            'prix' => 800,
            'image' => 'chemin/vers/plat2.jpg',
            'descriptif' => 'Description du plat 2',
        ]);

         Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Yassa dieune',
            'prix' => 800,
            'image' => 'chemin/vers/plat2bis.jpg',
            'descriptif' => 'Description du plat 2 bis',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 3, 
            'libelle' => 'Vermisselles',
            'prix' => 900,
            'image' => 'chemin/vers/plat3.jpg',
            'descriptif' => 'Description du plat 3',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 3, 
            'libelle' => 'Cous Cous',
            'prix' => 900,
            'image' => 'chemin/vers/plat3bis.jpg',
            'descriptif' => 'Description du plat 3 bis',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 4, 
            'libelle' => 'Mafé',
            'prix' => 1000,
            'image' => 'chemin/vers/plat4.jpg',
            'descriptif' => 'Description du plat',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 4, 
            'libelle' => 'Soupe Kandia',
            'prix' => 1000,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 5, 
            'libelle' => 'Spaguetti',
            'prix' => 400,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 5, 
            'libelle' => 'Brochette',
            'prix' => 400,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat ',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 6, 
            'libelle' => 'Brochette Plateau',
            'prix' => 400,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat ',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 6, 
            'libelle' => 'Sauce Plateau',
            'prix' => 400,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat ',
        ]);

        
    }
}
