<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Entree;
use App\Models\Facture;
use App\Models\Fournisseur;
use App\Models\Medicament;
use App\Models\Medicament_facture;
use App\Models\Role;
use App\Models\Sortie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'utilisateur']);

        User::create([
            'name' => 'ziraoui',
            'email' => 'ziraoui@gmail.com',
            'password' => Hash::make('12344321'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12344321'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'alami',
            'email' => 'alami@gmail.com',
            'password' => Hash::make('12344321'),
            'role_id' => 2
        ]);

        User::factory()->count(15)->create();
        
        Client::factory()->count(50)->create();
        Fournisseur::factory()->count(90)->create();
        Medicament::factory()->count(90)->create();
        Sortie::factory()->count(100)->create();
        Entree::factory()->count(400)->create();
        Facture::factory()->count(2000)->create();
        Medicament_facture::factory()->count(2000)->create();
    }
}
