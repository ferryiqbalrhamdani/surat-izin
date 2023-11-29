<?php

namespace Database\Seeders;

use App\Models\Role as ModelsRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role_admin = Role::updateOrCreate(['name' => 'Admin']);
        $role_user = Role::updateOrCreate(['name' => 'User']);
        $role_hrd = Role::updateOrCreate(['name' => 'HRD']);
        $role_atsan = Role::updateOrCreate(['name' => 'Atasan']);
        //     [
        //         'name' => 'HRD',
        //         'guard_name' => 'web',
        //     ],
        //     [
        //         'name' => 'HRD',
        //         'guard_name' => 'web',
        //     ]
        // ]);
        // $role_atasan = Role::updateOrCreate([
        //     [
        //         'name' => 'Atasan',
        //         'guard_name' => 'web',
        //     ],
        //     [
        //         'name' => 'Atasan',
        //         'guard_name' => 'web',
        //     ]
        // ]);

        $permission = Permission::updateOrCreate(['name' => 'view_dashboard']);
        $permission2 = Permission::updateOrCreate(['name' => 'view_surat_izin']);
        $permission3 = Permission::updateOrCreate(['name' => 'view_izin_cuti']);
        $permission4 = Permission::updateOrCreate(['name' => 'view_izin_lembur']);
        $permission5 = Permission::updateOrCreate(['name' => 'view_data_izin']);
        $permission6 = Permission::updateOrCreate(['name' => 'view_data_cuti']);
        $permission7 = Permission::updateOrCreate(['name' => 'view_data_lembur']);
        $permission8 = Permission::updateOrCreate(['name' => 'view_data_user']);
        $permission9 = Permission::updateOrCreate(['name' => 'view_data_role']);
        $permission10 = Permission::updateOrCreate(['name' => 'view_data_pt']);
        $permission11 = Permission::updateOrCreate(['name' => 'view_data_divisi']);

        $role_admin->givePermissionTo($permission);
        $role_admin->givePermissionTo($permission2);
        $role_admin->givePermissionTo($permission3);
        $role_admin->givePermissionTo($permission4);
        $role_admin->givePermissionTo($permission5);
        $role_admin->givePermissionTo($permission6);
        $role_admin->givePermissionTo($permission7);
        $role_admin->givePermissionTo($permission8);
        $role_admin->givePermissionTo($permission9);
        $role_admin->givePermissionTo($permission10);
        $role_admin->givePermissionTo($permission11);

        $role_user->givePermissionTo($permission);
        $role_user->givePermissionTo($permission2);
        $role_user->givePermissionTo($permission3);
        $role_user->givePermissionTo($permission4);

        $role_hrd->givePermissionTo($permission);
        $role_hrd->givePermissionTo($permission5);
        $role_hrd->givePermissionTo($permission6);
        $role_hrd->givePermissionTo($permission7);

        $role_atsan->givePermissionTo($permission);
        $role_atsan->givePermissionTo($permission2);
        $role_atsan->givePermissionTo($permission3);
        $role_atsan->givePermissionTo($permission4);
        $role_atsan->givePermissionTo($permission5);
        $role_atsan->givePermissionTo($permission6);
        $role_atsan->givePermissionTo($permission7);

        $user = User::find(1);
        $user1 = User::find(2);
        $user2 = User::find(3);
        $user3 = User::find(4);

        $user->assignRole(['Admin']);
        $user1->assignRole(['User']);
        $user2->assignRole(['HRD']);
        $user3->assignRole(['Atasan']);
    }
}
