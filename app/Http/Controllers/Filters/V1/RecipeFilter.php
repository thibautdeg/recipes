<?php

namespace App\Http\Controllers\Filters\V1;

use App\Http\Controllers\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class RecipeFilter extends QueryFilter
{
    public function include($value): Builder
    {
        return $this->builder->with($value);
    }

    public function search($value)
    {
        $this->builder
            ->where('title', 'like', "%$value%")
            ->orWhereHas('ingredients', function ($query) use ($value) {
                $query->where('name', 'like', "%$value%");
            });
    }

    public function title($value): Builder
    {
        $like_str = str_replace('*', '%', $value);

        return $this->builder->where('title', 'like', $like_str);
    }

    public function categories($value): Builder
    {
        return $this->builder->whereIn('category_id', explode(',', $value));
    }
}
