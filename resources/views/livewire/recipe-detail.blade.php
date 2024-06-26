
<div class="bg-white">
    <div class="pb-16 pt-6 sm:pb-24">}

        <div class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="">
                <div class="lg:col-span-5 lg:col-start-8">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium text-gray-900">{{$recipe->title}}</h1>
                        <x-primary-button>
                            hide recipe
                        </x-primary-button>
                    </div>
                    <!-- Reviews -->
                    <div class="mt-4">
                        <h2 class="sr-only">Duration</h2>
                        <div class="flex items-center">
                            <p class="text-sm text-gray-700">
                                {{$recipe->duration}} minutes
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 lg:col-span-5">
                    <details class="bg-gray-100 rounded-md p-6" open>
                        <summary class="font-medium flex justify-between items-center">
                            <span>
                                Ingredients
                            </span>
                            <span>
                                <label for="servings" class="">servings: </label>
                                <x-text-input id="servings" type="number" wire:model.live.debounce.300ms="servings" max="30" wire:model.live.debounce.300ms="servings" max="30" />
                            </span>
                        </summary>

                        <ul class="divide-y mt-2">
                            @foreach($recipe->ingredients as $ingredient)
                                <li class="flex justify-between py-1">
                                    <span>
                                        {{$ingredient->name}}
                                    </span>
                                    <span>
                                        {{$ingredient->pivot->quantity}}
                                        {{$ingredient->pivot->unit}}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </details>


                    <!-- Product details -->
                    <div class="mt-10">
                        <h2 class="text-sm font-medium text-gray-900">Description</h2>

                        <div class="prose prose-sm mt-4 text-gray-500">
                            {!! $recipe->instructions !!}
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <div class="container mx-auto  mt-10">

            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach($similarRecipes as $similarRecipe)
                    @include('recipe.recipe', ['recipe' => $similarRecipe])
                @endforeach
            </div>

        </div>
    </div>
</div>
