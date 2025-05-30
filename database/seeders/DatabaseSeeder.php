<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->count(5)->create();

        foreach ($user as $user) {
            Product::factory()
                ->count(5)
                ->create([
                    'user_id' => 1,
                ]);
        }

    }
}
