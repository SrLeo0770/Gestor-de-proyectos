<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Administrador del sistema'
            ],
            [
                'name' => 'Cliente',
                'slug' => 'client',
                'description' => 'Cliente del sistema'
            ],
            [
                'name' => 'Líder de Proyecto',
                'slug' => 'project_leader',
                'description' => 'Líder de proyectos'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
} 