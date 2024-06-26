<?php

namespace App\Livewire;

use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RecipeDetail extends Component
{
    public $recipe;
    public $servings = 2;

    public function mount()
    {
        $this->recipe = Recipe::with(['ingredients', 'category'])->findOrFail((int)request()->route()->parameter('id'));
    }

    public function updatedServings($value)
    {
        foreach ($this->recipe->ingredients as $ingredient) {
            $ingredient->pivot->quantity = $ingredient->pivot->quantity * $value / 2;
        }
    }

    public function hideRecipe()
    {
        $this->recipe->hiddenByUsers()->attach(auth()->id());
        $this->redirectRoute('recipes.index');
    }

    public function render()
    {

        $similarRecipes = Cache::remember('similar-recipes-' . $this->recipe->id, Carbon::now()->addDay(), function () {
            return Recipe::where('category_id', $this->recipe->category_id)
                ->where('id', '!=', $this->recipe->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        return view('livewire.recipe-detail', [
            'recipe' => $this->recipe,
            'similarRecipes' => $similarRecipes,
        ]);
    }
}
