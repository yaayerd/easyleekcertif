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
            'Titre' => 'Local Niam',
            'user_id' => 3
        ]);

        Menu::factory()->create([
            'Titre' => 'Master Thiep',
            'user_id' => 3
        ]);

        Menu::factory()->create([
            'Titre' => 'Mini delicia',
            'user_id' => 4
        ]);

        Menu::factory()->create([
            'Titre' => 'Savoures bien',
            'user_id' => 4
        ]);

        Menu::factory()->create([
            'Titre' => 'Si plate ',
            'user_id' => 5
        ]);

        Menu::factory()->create([
            'Titre' => 'Si Mbourou',
            'user_id' => 5
        ]);

        Menu::factory()->create([
            'Titre' => 'Dibi bou noy',
            'user_id' => 6
        ]);

        Menu::factory()->create([
            'Titre' => 'Dibi safsap',
            'user_id' => 6
        ]);

        Menu::factory()->create([
            'Titre' => 'La bonne cuisine',
            'user_id' => 8
        ]);

        Menu::factory()->create([
            'Titre' => 'Ndeki truck',
            'user_id' => 8
        ]);

        Menu::factory()->create([
            'Titre' => 'Best burger in town',
            'user_id' => 7
        ]);

        Menu::factory()->create([
            'Titre' => 'Food ForAll',
            'user_id' => 7
        ]);

    }
}
