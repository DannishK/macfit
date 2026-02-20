<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' =>'Admin',
            'description'=>''
        ]);
         Role::create([
            'name' =>'Manager',
            'description'=>''
        ]);
         Role::create([
            'name' =>'user',
            'description'=>''
        ]);
         Role::create([
            'name' =>'staff',
            'description'=>''
        ]);
    }
}
