<?php

namespace Database\Seeders;




use App\Models\Bundle;
use App\Models\Category;
use App\Models\Gym;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Categories table is empty. Seed categories first.');
            return;
        }

        $staticTimes = [
            '06:00',
            '08:30',
            '12:00',
            '17:30',
            '19:00',
            '20:30'
        ];

        $bundles = [
            [
                'category' => 'Strength Training',
                'name' => 'Basic Powerlifting',
                'duration' => 2,
                'value' => 50,
                'description' => '2-hour heavy lifting access.'
            ],
            [
                'category' => 'Cardio & Endurance',
                'name' => 'Endurance Runner Pass',
                'duration' => 3,
                'value' => 40,
                'description' => 'Full cardio & treadmill access.'
            ],
            [
                'category' => 'Yoga & Mobility',
                'name' => 'Morning Yoga Flow',
                'duration' => 1,
                'value' => 30,
                'description' => '1-hour guided yoga session.'
            ],
            [
                'category' => 'HIIT & Circuit',
                'name' => '30-Day Shred',
                'duration' => 1,
                'value' => 45,
                'description' => 'High intensity fat-burning workout.'
            ],
            [
                'category' => 'Combat Sports',
                'name' => 'Boxing Fundamentals',
                'duration' => 2,
                'value' => 60,
                'description' => 'Boxing technique and sparring class.'
            ],
        ];

        foreach ($bundles as $bundleData) {

            $category = $categories
                ->where('name', $bundleData['category'])
                ->first();

            if (!$category) {
                $this->command->warn("Category {$bundleData['category']} not found.");
                continue;
            }

            $randomTime = $staticTimes[array_rand($staticTimes)];

            Bundle::updateOrCreate(
                [
                    'name' => $bundleData['name'],
                ],
                [
                    'description' => $bundleData['description'],
                    'duration'    => $bundleData['duration'],
                    'value'       => $bundleData['value'],
                    'start_time'  => Carbon::createFromFormat('H:i', $randomTime),
                    'category_id' => $category->id,
                ]
            );
        }

        $this->command->info('Bundles seeded successfully.');
    }
}