<?php

use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class); // Seed the database

    $this->user = User::first();

    $this->categories = Category::all();
    $this->recipes = Recipe::all();
    $this->ingredients = Ingredient::all();
});

test('a user can fetch recipes', function () {
    $response = $this->actingAs($this->user)->getJson('/api/v1/recipes');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data', 'links', 'meta'
    ]);
});

test('a user can filter recipes by category', function () {
    $categoryId = $this->categories->first()->id;
    $response = $this->actingAs($this->user)->getJson('/api/v1/recipes?filter[categories]=' . $categoryId);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data', 'links', 'meta'
    ]);
});

test('a user can search for recipes by title and ingredients', function () {
    $recipe = $this->recipes->first();
    $response = $this->actingAs($this->user)->getJson('/api/v1/recipes?filter[search]=' . $recipe->title);

    $response->assertStatus(200);
    $response->assertJsonFragment(['title' => $recipe->title]);
    $response->assertJsonStructure([
        'data', 'links', 'meta'
    ]);

    $ingredient = $this->ingredients->first();
    $response = $this->actingAs($this->user)->getJson('/api/v1/recipes?filter[search]=' . $ingredient->name);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data', 'links', 'meta'
    ]);
});
