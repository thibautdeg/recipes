
<div class="bg-white">
    <div class="pb-16 pt-6 sm:pb-24">}

        <div class="mx-auto mt-8 max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="">
                <div class="lg:col-span-5 lg:col-start-8">
                    <div class="flex justify-between">
                        <h1 class="text-xl font-medium text-gray-900">{{$recipe->title}}</h1>
                        <div>
                            <x-primary-button wire:click="hideRecipe" :disabled="!auth()->check()">
                                <span class="text-nowrap mr-2">
                                    hide recipe
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </x-primary-button>
                            @guest
                                <span class="block text-sm text-gray-700">
                                    log in om recept te verbergen
                                </span>
                            @endguest
                        </div>

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
