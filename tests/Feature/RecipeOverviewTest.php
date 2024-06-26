<?php

use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $this->user = User::first();

    $this->categories = Category::all();
    $this->recipes = Recipe::all();
    $this->ingredients = Ingredient::all();
});

test('the recipe overview page can be accessed', function () {
    $response = $this->actingAs($this->user)->get('/');

    $response->assertStatus(200);
    $response->assertSee('Jouw Recepten');
});

test('the recipe overview page can filter by category', function () {
    $category = $this->categories->first();
    $response = $this->actingAs($this->user)->get('/?categories[0]=' . $category->id);

    $response->assertStatus(200);
    $filteredRecipes = Recipe::where('category_id', $category->id)->get();
    $response->assertSee($filteredRecipes->first()->title);
});

test('the recipe overview page can search by title and ingredients', function () {
    $recipe = $this->recipes->first();
    $response = $this->actingAs($this->user)->get('/?search=' . $recipe->title);

    $response->assertStatus(200);
    $response->assertSee($recipe->title);

    $ingredient = $this->ingredients->first();
    $response = $this->actingAs($this->user)->get('/?search=' . $ingredient->name);

    $response->assertStatus(200);
    $recipesWithIngredient = Recipe::whereHas('ingredients', function ($query) use ($ingredient) {
        $query->where('name', $ingredient->name);
    })->get();

    $response->assertSee($recipesWithIngredient->first()->title);
});
