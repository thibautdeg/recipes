<a href="{{route('recipes.show', $recipe->id)}}" class="group">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg sm:aspect-h-2 sm:aspect-w-2">
        <img src="https://tailwindui.com/img/ecommerce-images/category-page-01-image-card-01.jpg" alt="Person using a pen to cross a task off a productivity paper card." class="h-full w-full object-cover object-center group-hover:opacity-75">
    </div>
    <div class="mt-4 flex items-center justify-between text-base font-medium text-gray-900">
        <h3>{{$recipe->title}}</h3>
    </div>
</a>
