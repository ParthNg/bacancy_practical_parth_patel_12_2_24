<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        for ($i=0; $i <= 0; $i++) {
                $role = 'admin';
                $phone = '4569078123';
                $user = User::firstOrCreate([
                            'first_name' => 'admin',
                            'email' => 'admin@mail.com',
                            'mobile_number' => $phone,
                            'password' => Hash::make('12345678'),
                            'user_type' => 'admin',
                            'verified' => 1,
                            'registered_on' => 'web',
                            'status' => 'active',
                            'email_verified_at' => date('Y-m-d'),
                        ]);
                // $user->assignRole([$role->id]);

                //if($role->name != 'developer'){
                $this->command->getOutput()->writeln("<question>Admin Panel Credentials</question>");
                $this->command->getOutput()->writeln("<comment>Username:</comment><info>".'admin@mail.com'."</info>");
                $this->command->getOutput()->writeln("<comment>Password:</comment><info>12345678</info>");
                //}
        }
        //factory('App\Models\User', 10)->create();
    }
}
