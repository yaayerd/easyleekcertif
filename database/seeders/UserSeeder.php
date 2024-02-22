<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Créer utilisateur Admin 1 (Sénégalais)
        User::create([
            'is_activated' => 1,
            'role_id' => 1,
            'name' => 'El Modou Mboup',
            'email' => 'elmodou@admin.com',
            'phone' => '771234567',
            'adresse' => '56 Rue des Almadies, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Admin 2 (Sénégalais)
        User::create([
            'is_activated' => 1,
            'role_id' => 1,
            'name' => 'Yaye',
            'email' => 'yaye@admin.com',
            'phone' => '781234567',
            'adresse' => '25 Avenue Ndiaga Mbaye, Dakar',
            'password' => Hash::make('password123')
        ]);


        // Créer utilisateur Restaurant 1
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 2,
            'name' => 'Le Délice Sénégalais',
            'email' => 'delice.senegalais@resto.com',
            'phone' => '765432109',
            'adresse' => 'Avenue Cheikh Anta Diop, Dakar',
            'description' => 'Un restaurant qui propose une délicieuse cuisine sénégalaise authentique.',
            'image' => 'chemin/vers/restaurant1.jpg',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant 2
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 1,
            'name' => 'Saveurs de la Banlieue',
            'email' => 'saveurs.banlieue@resto.com',
            'phone' => '778765432',
            'adresse' => 'Thiaroye, Dakar',
            'description' => 'Un restaurant offrant une variété de saveurs délicieuses de la région de Thiès.',
            'image' => 'chemin/vers/restaurant2.jpg',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant 3 (Tangana)
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 5,
            'name' => 'Chez Baary Tangana',
            'email' => 'baary.tangana@resto.com',
            'phone' => '789012345',
            'adresse' => 'Guédiawaye, Dakar',
            'description' => 'Un lieu chaleureux offrant des plats traditionnels sénégalais, notamment des tanganas succulents.',
            'image' => 'chemin/vers/restaurant3.jpg',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant 4 (Dibiterie)
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 6,
            'name' => 'La Dibiterie du Gourmet',
            'email' => 'dibiterie.gourmet@resto.com',
            'phone' => '701234567',
            'adresse' => 'Médina, Dakar',
            'description' => 'Une dibiterie réputée proposant une sélection de viandes grillées avec des accompagnements délicieux.',
            'image' => 'chemin/vers/restaurant4.jpg',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant 5 (Fast Food)
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 3,
            'name' => 'Speedy Bites Fast Food',
            'email' => 'speedy.bites@resto.com',
            'phone' => '789876543',
            'adresse' => 'Liberté 6, Dakar',
            'description' => 'Un fast food offrant une variété de plats rapides et délicieux, parfaits pour les personnes pressées.',
            'image' => 'chemin/vers/restaurant5.jpg',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Restaurant 6 (Femme qui vend de la bonne nourriture)
        User::create([
            'is_activated' => 1,
            'role_id' => 2,
            'categorie_id' => 4,
            'name' => 'Fanta Cuisinière',
            'email' => 'fanta.cuisiniere@resto.com',
            'phone' => '765432100',
            'adresse' => 'Quartier des Mamelles, Dakar',
            'description' => 'Une cuisinière talentueuse proposant des plats faits maison délicieux et sains.',
            'image' => 'chemin/vers/restaurant6.jpg',
            'password' => Hash::make('password123')
        ]);


        // Créer utilisateur Client 1 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Mamadou Ndiaye',
            'email' => 'mamadou.ndiaye@client.com',
            'phone' => '781234567',
            'adresse' => 'Quartier des Parcelles Assainies, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 2 (Femme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Aïssatou Fall',
            'email' => 'aissatou.fall@client.com',
            'phone' => '781234568',
            'adresse' => 'Patte d oie, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 3 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Ousmane Diop',
            'email' => 'ousmane.diop@client.com',
            'phone' => '781234569',
            'adresse' => 'Rue Léopold Sédar Senghor, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 4 (Femme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Fatoumata Sow',
            'email' => 'fatoumata.sow@client.com',
            'phone' => '781234570',
            'adresse' => 'Tivaouane Peulh, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 5 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Abdoulaye Diop',
            'email' => 'abdoulaye.diop@client.com',
            'phone' => '781234571',
            'adresse' => 'Quartier des Mamelles, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 6 (Femme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Ndeye Sarr',
            'email' => 'ndeye.sarr@client.com',
            'phone' => '781234572',
            'adresse' => 'Keur Massar, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 7 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Modou Ba',
            'email' => 'modou.ba@client.com',
            'phone' => '781234573',
            'adresse' => 'Rufisque, Dakar',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Client 8 (Femme)
        User::create([
            'is_activated' => 1,
            'role_id' => 3,
            'name' => 'Rokhaya Ndiaye',
            'email' => 'rokhaya.ndiaye@client.com',
            'phone' => '781234574',
            'adresse' => 'Rue Saint-Michel, Dakar',
            'password' => Hash::make('password123')
        ]);


        // Créer utilisateur Livreur 1 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Moussa Sarr',
            'email' => 'moussa.sarr@livreur.com',
            'phone' => 787654321,
            'adresse' => 'Pikine Icotaf',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Livreur 2 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Samba Fall',
            'email' => 'samba.fall@livreur.com',
            'phone' => 787654322,
            'adresse' => 'HLM 2',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Livreur 3 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Ibrahima Gueye',
            'email' => 'ibrahima.gueye@livreur.com',
            'phone' => 787654323,
            'adresse' => 'Fass Colobane',
            'password' => Hash::make('password123')
        ]);

        // Créer utilisateur Livreur 4 (Homme)
        User::create([
            'is_activated' => 1,
            'role_id' => 4,
            'name' => 'Cheikh Ndiaye',
            'email' => 'cheikh.ndiaye@livreur.com',
            'phone' => 787654324,
            'adresse' => 'Fass Mbao',
            'password' => Hash::make('password123')
        ]);
    }
}
