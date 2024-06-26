<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Filters\V1\RecipeFilter;
use App\Http\Resources\Api\V1\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(RecipeFilter $filters)
    {
        return RecipeResource::collection(Recipe::filter($filters)->paginate(30));
    }
}
