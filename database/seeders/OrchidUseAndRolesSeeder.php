<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Orchid\Platform\Models\Role;

class OrchidUseAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrador',
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems' => true,
                    'platform.systems.roles' => true,
                    'platform.systems.users' => true,
                ],
            ]
        );

        // Crear usuario admin si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Asignar rol de administrador
        if (!$user->hasAccess('platform.index')) {
            $user->addRole($adminRole);
        }
    }
}
