<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'type' => 'recipe',
        'id' => $this->id,
        'attributes' => [
            'title' => $this->title,
            'instructions' => $this->when(
                $request->routeIs('api.v1.recipes.show'),
                $this->instructions
            ),
            'duration' => $this->duration,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ],
        'relationships' => [
            'category' => [
//                'data' => [
//                    'type' => 'category',
//                    'id' => (int) $this->category_id,
//                ],
//                'links' => [
//                    'self' => route('category.show', ['user' => $this->user_id])
//                ],
            ],
            'ingredients' => [
//                'data' => [
//                    'type' => 'ingredient',
//                    'id' => (int) $this->ingredient_id,
//                ],
//                'links' => [
//                    'self' => route('ingredients.show', ['ingredient' => $this->ingredient_id])
//                ],
            ],
        ],
//        'includes' => new UserResource($this->whenLoaded('user')),
        'links' => [
            [
                'self' => route('api.v1.recipes.show', ['recipe' => $this->id])
            ],
        ],
    ];
    }
}
