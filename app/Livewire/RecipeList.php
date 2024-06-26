<?php

namespace App\Livewire;

use App\Http\Controllers\Filters\V1\RecipeFilter;
use App\Models\Category;
use App\Models\Recipe;

use Illuminate\Http\Request;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RecipeList extends Component
{
    use WithPagination;
    #[Url(history: true)]
    public $search = '';
    #[Url(history: true)]
    public $selectedCategories = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => [], 'as' => 'categories'],
    ];

    protected $rules = [
        'search' => 'string|max:255',
        'selectedCategories' => 'array|exists:categories,id',
    ];

    public function mount()
    {
        // check for parameters in the URL
        $this->search = request()->query('search', $this->search);
        $this->selectedCategories = request()->query('categories', $this->selectedCategories);
    }

    public function updateSelectedCategories($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }

        $this->resetPage();
    }

    public function render()
    {
        $this->validate();

        $request = new Request($this->getFilterParameters());

        $filter = new RecipeFilter($request);

        $recipes = Recipe::filter($filter)
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $categories = Category::select(['id', 'name'])->has('recipes')->limit(10)->get();

        return view('livewire.recipe-list', [
            'recipes' => $recipes,
            'categories' => $categories,
        ]);
    }

    private function getFilterParameters(): array
    {
        $parameters = [];

        if (!empty($this->search)) {
            $parameters['filter']['search'] = $this->search;
        }

        if (!empty($this->selectedCategories)) {
            $parameters['filter']['categories'] = implode(',', $this->selectedCategories);
        }

        return $parameters;
    }
}
