<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Roles
        $admin = Role::create(['name' => 'SUPER ADMIN']);
        $vendedor = Role::create(['name' => 'vendedor']);

        // 2. Crear un usuario administrador por defecto
        $user = User::create([
            'name' => 'Erick Fernando Morales Gil',
            'email' => 'erick@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole($admin);
    }
}
