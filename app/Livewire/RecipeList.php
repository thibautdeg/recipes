<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Recipe;

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

        $recipes = Recipe::query()
            ->when(!empty($this->search), function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when(!empty($this->selectedCategories), function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $categories = Category::select(['id', 'name'])->has('recipes')->limit(10)->get();

        return view('livewire.recipe-list', [
            'recipes' => $recipes,
            'categories' => $categories,
        ]);
    }
}
