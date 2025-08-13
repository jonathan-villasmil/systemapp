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
        //create permissions Users
        $pernission = Permission::firstOrCreate(['name' => 'create user']);
        $pernission = Permission::firstOrCreate(['name' => 'show user']);
        $pernission = Permission::firstOrCreate(['name' => 'update user']);
        $pernission = Permission::firstOrCreate(['name' => 'delete user']);

        //create permissions Products
        $pernission = Permission::firstOrCreate(['name' => 'create product']);
        $pernission = Permission::firstOrCreate(['name' => 'show product']);
        $pernission = Permission::firstOrCreate(['name' => 'update product']);
        $pernission = Permission::firstOrCreate(['name' => 'delete product']);

        // Crear un usuario Admin
        $adminUser = User::create([
            'name' => 'Jonathan',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456789'), // cambia esto en producción
            'email_verified_at' => now(), // para evitar problemas con verificación
        ]);

        // Crear los roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Asignar el rol admin
        $adminUser->assignRole($adminRole);

        $pernissionsAdmin = Permission::query()->pluck('name');

        $adminRole->syncPermissions($pernissionsAdmin);



        // Crear un usuario Cliente
        $clientUser = User::create([
            'name' => 'Juan',
            'email' => 'client@client.com',
            'password' => bcrypt('123456789'), // cambia esto en producción
            'email_verified_at' => now(), // para evitar problemas con verificación
        ]);

        // Crear los roles si no existen
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        // Asignar el rol cliente
        $clientUser->assignRole($clientRole);



        // Crear un usuario Manager
        $managerUser = User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('123456789'), // cambia esto en producción
            'email_verified_at' => now(), // para evitar problemas con verificación
        ]);

        // Crear los roles si no existen
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        // Asignar el rol cliente
        $managerUser->assignRole($managerRole);

        $managerRole->syncPermissions(['create product','show product','update product','delete product']);

    }
}
