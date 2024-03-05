<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\PlatSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CommandeSeeder;
use Database\Seeders\CategorieSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(PlatSeeder::class);
        // $this->call(CommandeSeeder::class);
        // // $this->call(AvisSeeder::class);
        // \App\Models\Avis::factory(3)->create();
        // $this->call(LivreurSeeder::class);
        // $this->call(LivraisonSeeder::class);

        // \App\Models\Role::factory(1)->create();
        // \App\Models\Categorie::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
