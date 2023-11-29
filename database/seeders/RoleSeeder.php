<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::updateOrCreate([
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ]
        ]);
        Role::updateOrCreate([
            [
                'name' => 'User',
                'guard_name' => 'web',
            ],
            [
                'name' => 'User',
                'guard_name' => 'web',
            ]
        ]);
        Role::updateOrCreate([
            [
                'name' => 'HRD',
                'guard_name' => 'web',
            ],
            [
                'name' => 'HRD',
                'guard_name' => 'web',
            ]
        ]);
        Role::updateOrCreate([
            [
                'name' => 'Atasan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Atasan',
                'guard_name' => 'web',
            ]
        ]);
        Role::updateOrCreate([
            [
                'name' => 'Tes',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Tes',
                'guard_name' => 'web',
            ]
        ]);
    }
}
