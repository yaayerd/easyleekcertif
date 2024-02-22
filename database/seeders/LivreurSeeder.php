<?php

namespace Database\Seeders;

use App\Models\Livreur;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LivreurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Livreur::factory()->create([
            'user_id' => 17
        ]);
        Livreur::factory()->create([
            'user_id' => 18
        ]);
        Livreur::factory()->create([
            'user_id' => 19
        ]);
        Livreur::factory()->create([
            'user_id' => 20
        ]);


    }
}
