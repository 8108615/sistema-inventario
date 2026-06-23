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
        // 1. Crear Permisos (Para que el módulo de Permisos tenga datos)
        $permisos = [
            'dashboard.ver',
            'roles.ver', 'roles.crear', 'roles.editar', 'roles.eliminar',
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
            'categorias.ver', 'categorias.crear', 'categorias.editar', 'categorias.eliminar',
            'sucursales.ver', 'sucursales.crear', 'sucursales.editar', 'sucursales.eliminar',
        ];

        foreach ($permisos as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // 2. Crear Roles
        $admin = Role::firstOrCreate(['name' => 'SUPER ADMIN']);
        $vendedor = Role::firstOrCreate(['name' => 'VENDEDOR']);

        // 3. Asignar todos los permisos al ADMIN
        $admin->syncPermissions(Permission::all());

        // 4. Crear usuario administrador si no existe
        $user = User::firstOrCreate(
            ['email' => 'erick@gmail.com'],
            [
                'name' => 'Erick Fernando Morales Gil',
                'password' => Hash::make('12345678'),
            ]
        );

        $user->assignRole($admin);
    }
}