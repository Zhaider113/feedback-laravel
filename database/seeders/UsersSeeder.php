<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',	
            'last_name' => 'Admin',		
            'email' => 'admin@admin.com',		
            'password' => bcrypt('admin'),
            'user_type' => USER_TYPES['admin']
        ]);
        
        $user = User::create([
            'first_name' => 'Zeesan',
            'last_name' => 'Haider',	
            'username' => 'zhaider113',		 
            'email' => 'zhaider113@gmail.com',
            'phone' => '03145129270',
            'profile_image' => 'profile_images/default.png',		
            'password' => bcrypt('12345678'),
            'user_type' => USER_TYPES['user']
        ]);
    }
}
