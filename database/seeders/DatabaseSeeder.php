<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RequisitoIsoSeeder::class,
        ]);

        User::create([
            'name' => 'Admin SGSI',
            'email' => 'admin@iso27001.com',
            'password' => bcrypt('password123'),
            'rol' => 'Administrador del Sistema',
        ]);

        User::create([
            'name' => 'Consultor ISO',
            'email' => 'consultor@iso27001.com',
            'password' => bcrypt('password123'),
            'rol' => 'Consultor',
        ]);

        User::create([
            'name' => 'Auditor Líder',
            'email' => 'auditor@iso27001.com',
            'password' => bcrypt('password123'),
            'rol' => 'Auditor',
        ]);

        User::create([
            'name' => 'Auditado TI',
            'email' => 'auditado@iso27001.com',
            'password' => bcrypt('password123'),
            'rol' => 'Auditado',
        ]);

        User::create([
            'name' => 'Director General',
            'email' => 'direccion@iso27001.com',
            'password' => bcrypt('password123'),
            'rol' => 'Alta Dirección',
        ]);

    }
}
