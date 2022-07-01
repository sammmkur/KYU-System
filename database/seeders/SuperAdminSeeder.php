<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Backpack\PermissionManager\app\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SuperAdmin User
        $superadmin = \App\Models\User::where('email','superadmin@rectmedia.com')->first();
        if(empty($superadmin)){
            $superadmin_user = \App\Models\User::create([
                'name' => 'Superadmin',
                'email' => 'superadmin@kyu.com',
                'password' => bcrypt('KYU2022'),
                'complete_name' => 'Super Admin',
                'phone_number' => '1234'
            ]);

            $role = Role::where('name',config('constant.roles.superadmin'))->where('guard_name',backpack_guard_name())->first();
            if(empty($role)){
                $superadmin_role = Role::create(['name' => config('constant.roles.superadmin'), 'guard_name' => 'backpack']);
            }

            $superadmin_user->roles()->sync($superadmin_user->id);
        }
    }
}
