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
        $plat1 = Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Plat 1',
            'prix' => 1000,
            'image' => 'chemin/vers/plat1.jpg',
            'descriptif' => 'Description du plat 1',
        ]);

        $plat2 =  Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Plat 2',
            'prix' => 1000,
            'image' => 'chemin/vers/plat2.jpg',
            'descriptif' => 'Description du plat 2',
        ]);

        $plat3 = Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Plat 3',
            'prix' => 1000,
            'image' => 'chemin/vers/plat3.jpg',
            'descriptif' => 'Description du plat 3',
        ]);

        $plat4 = Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Plat 4',
            'prix' => 1000,
            'image' => 'chemin/vers/plat4.jpg',
            'descriptif' => 'Description du plat 4',
        ]);

        
    }
}
