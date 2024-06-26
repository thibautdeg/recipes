<?php

use App\Models\Recipe;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $this->user = User::first();

    $this->recipes = Recipe::with('ingredients')->get();
});

test('the recipe detail page can be accessed', function () {
    $recipe = $this->recipes->first();
    $response = $this->actingAs($this->user)->get('/recipes/' . $recipe->id);

    $response->assertStatus(200);
    $response->assertSee($recipe->title);
    $response->assertSee($recipe->instructions);
});

test('the recipe detail page shows ingredients and quantities', function () {
    $recipe = $this->recipes->first();
    $response = $this->actingAs($this->user)->get('/recipes/' . $recipe->id);

    $response->assertStatus(200);
    foreach ($recipe->ingredients as $ingredient) {
        $response->assertSee($ingredient->name);
        $response->assertSee($ingredient->pivot->quantity);
        $response->assertSee($ingredient->pivot->unit);
    }
});

test('the recipe detail page shows related recipes', function () {
    $recipe = $this->recipes->first();
    $relatedRecipes = Recipe::where('category_id', $recipe->category_id)
        ->where('id', '!=', $recipe->id)
        ->get();

    $response = $this->actingAs($this->user)->get('/recipes/' . $recipe->id);

    $response->assertStatus(200);
    $this->assertTrue(
        $relatedRecipes->pluck('title')->some(fn($title) => $response->getContent() && strpos($response->getContent(), $title) !== false)
    );
});
