<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();

        Category::factory(10)->create();

        Ingredient::factory(500)->create();

        Recipe::factory(500)->create()->each(function ($recipe) {
            $units       = [
                'kg',
                'liter',
                'g',
                'ml',
                'tbsp',
                'tsp',
            ];
            $ingredients = Ingredient::inRandomOrder()->take(rand(3, 10))->pluck('id');

            foreach ($ingredients as $ingredient) {
                $recipe->ingredients()->attach($ingredient, [
                    'quantity' => rand(1, 100) / 10,
                    'unit' => $units[array_rand($units)],
                ]);
            }
        });
    }
}
