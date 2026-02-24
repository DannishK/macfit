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
            'description'=>'all previlages'
        ]);
         Role::create([
            'name' =>'Trainer',
            'description'=>'can add users'
        ]);
         Role::create([
            'name' =>'user',
            'description'=>'no previlages to database'
        ]);
         Role::create([
            'name' =>'staff',
            'description'=>'can read and create users'
        ]);
    }
}
