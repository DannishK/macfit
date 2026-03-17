<?php

namespace Database\Seeders;

use App\Models\gym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         gym::create([
            'name' => 'MacFit Central',
            'description' => 'Main branch located in the city center with full equipment.',
            'longitude' => 36.8219,
            'latitude' => -1.2921,
        ]);

        Gym::create([
            'name' => 'MacFit Westlands',
            'description' => 'Modern gym facility with swimming pool and sauna.',
            'longitude' => 36.8070,
            'latitude' => -1.2676,
        ]);

        Gym::create([
            'name' => 'MacFit East Branch',
            'description' => 'Affordable branch with personal training services.',
            'longitude' => 36.8969,
            'latitude' => -1.2195,
        ]);
    }
    }

