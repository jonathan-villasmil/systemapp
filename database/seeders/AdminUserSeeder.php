<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);


        $pernission = Permission::firstOrCreate(['name' => 'create']);
        $pernission = Permission::firstOrCreate(['name' => 'show']);
        $pernission = Permission::firstOrCreate(['name' => 'update']);
        $pernission = Permission::firstOrCreate(['name' => 'delete']);

        // Crear un usuario admin
        $admin = User::create([
            'name' => 'Jonathan',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456789'), // cambia esto en producción
            'email_verified_at' => now(), // para evitar problemas con verificación
        ]);

        // Asignar el rol admin
        $admin->assignRole($adminRole);
    }
}
