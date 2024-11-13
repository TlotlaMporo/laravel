<form method="POST" action='{{ "/faculty/$faculty->id/update" }}'>
    @method('PATCH')
    @csrf
    <!-- faculty field -->
    <div>
        <x-input-label for="faculty_name" :value="__('Faculty name')" />
        <x-text-input id="faculty_name" class="block mt-1 w-full" type="text" name="faculty_name" 
        :value="$faculty->faculty_name"
        required autofocus />
    </div>
    <div>
        <x-primary-button class="mt-3">
            {{ __('Update faculty') }}
        </x-primary-button>
    </div>
    <x-input-error :messages="$errors->get('faculty_name')" class="mt-2" />
</form>
