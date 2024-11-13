@props(['name'=>'confirm','content'])
<x-modal name="{{$name}}" show="show" focusable>
    <div class="px-6 py-4 space-y-4">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __($content) }}
        </h2>
        <x-secondary-button x-on:click="$dispatch('close')">
            {{ __('ok') }}
        </x-secondary-button>
    </div>
</x-modal>