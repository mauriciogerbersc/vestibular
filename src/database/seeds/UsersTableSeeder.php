<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        DB::table('admin_role')->truncate();

        $adminRole = Role::where('name', 'admin')->first();

        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'mauricio@aerotd.com.br',
            'password' =>  Hash::make('adminadmin')
        ]);


        $admin->roles()->attach($adminRole);
    }
}
