<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory()->create([
            'Titre' => 'La bonne Booff',
            'user_id' => 3
        ]);

        Menu::factory()->create([
            'Titre' => 'Food truck',
            'user_id' => 3
        ]);

        Menu::factory()->create([
            'Titre' => 'BestLeek',
            'user_id' => 4
        ]);

        Menu::factory()->create([
            'Titre' => 'FestiLeek',
            'user_id' => 4
        ]);

    }
}
