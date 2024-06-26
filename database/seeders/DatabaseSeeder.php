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

        $categories = Category::factory(10)->create();
        $ingredients = Ingredient::factory(500)->create();

        Recipe::factory(500)
            ->recycle($categories)
            ->create()
            ->each(function ($recipe) use ($ingredients) {
                $units = ['kg', 'liter', 'g', 'ml', 'tbsp', 'tsp'];
                $selectedIngredients = $ingredients->random(rand(3, 10));

                foreach ($selectedIngredients as $ingredient) {
                    $recipe->ingredients()->attach($ingredient, [
                        'quantity' => rand(1, 100) / 10,
                        'unit' => $units[array_rand($units)],
                    ]);
                }
            });
    }
}
