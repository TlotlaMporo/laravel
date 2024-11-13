@props(['title' => 'Institutes'])

<div class="bg-gray-700 fr-1 rounded-lg py-2 px-4 shadow-md">
    <h2 class="font-semibold text-xl text-indigo-500 text-center">
        {{$title}}
    </h2>
    <h2 class="font-semibold text-xl text-gray-200 text-center">
        {{$slot}}
    </h2>
</div>