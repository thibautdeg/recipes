<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="py-24 text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jouw Recepten</h1>
    </div>

    <section aria-labelledby="search-heading" class="border-t border-gray-200 pt-6">
        <h2 id="sorting-heading" class="sr-only">Zoeken</h2>

        <form>
            <x-text-input wire:model.live.debounce.300ms="search" id="search" name="search" placeholder="Zoeken naar recepten" class="w-full" />
        </form>
    </section>


    <!-- Filters -->
    <section aria-labelledby="filter-heading" class="border-t border-gray-200 pt-6">
        <h2 id="filter-heading" class="sr-only">recipe filters</h2>

        <div class="flex items-center justify-end">

            <div class="flex items-baseline space-x-8">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <span>Categorieën</span>
                            @if(count($selectedCategories) > 0)
                                <span class="ml-1.5 rounded bg-gray-200 px-1.5 py-0.5 text-xs font-semibold tabular-nums text-gray-700">{{count($selectedCategories)}}</span>
                                <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            @endif

                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form class="space-y-4 p-4">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input id="filter-category-{{ $category->id }}" name="category[]" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }} wire:click="updateSelectedCategories({{ $category->id }})">
                                    <label for="filter-category-{{ $category->id }}" class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-gray-900">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </section>

    <!-- recipe grid -->
    <section aria-labelledby="recipes-heading" class="my-8">
        <h2 id="recipes-heading" class="sr-only">recipes</h2>

        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
            @foreach($recipes as $recipe)
                <a href="{{route('recipes.show', $recipe->id)}}" class="group">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg sm:aspect-h-2 sm:aspect-w-2">
                        <img src="https://tailwindui.com/img/ecommerce-images/category-page-01-image-card-01.jpg" alt="Person using a pen to cross a task off a productivity paper card." class="h-full w-full object-cover object-center group-hover:opacity-75">
                    </div>
                    <div class="mt-4 flex items-center justify-between text-base font-medium text-gray-900">
                        <h3>{{$recipe->title}}</h3>
{{--                        <p>$13</p>--}}
                    </div>
{{--                    <p class="mt-1 text-sm italic text-gray-500">3 sizes available</p>--}}
                </a>
            @endforeach

            <!-- More recipes... -->
        </div>

        {{ $recipes->links() }}

    </section>
</div>
