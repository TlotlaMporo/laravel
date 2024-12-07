<x-app-layout x-data="{open:false}"> 
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 p-4 rounded-lg shadow-lg border-2 border-white outline outline-2 outline-white">
            <h2 class="font-extrabold text-2xl text-white tracking-wider">
                {{ __('Institutes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 relative min-h-screen"> <!-- Set a minimum height to ensure the background covers the full screen -->
        
        <!-- Background Image with Blur and Dark Overlay -->
        <div class="absolute inset-0 -z-10">
            <img src="education.jpg" alt="Background Image" 
                class="w-full h-full object-cover opacity-70 blur-md">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10 border-2 border-white outline outline-2 outline-white rounded-lg">
            <h2 class="font-bold pb-5 text-2xl text-gray-100 tracking-wide">
                Institutes List
            </h2>
            
            <!-- Institutes Grid -->
            <div class="bg-gray-800/90 shadow-xl sm:rounded-lg p-8 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-6 text-white border-2 border-white outline outline-2 outline-white">
                @foreach($institutes as $institute)
                    <!-- Individual Institute Card with Enhanced Border -->
                    <div class="bg-gradient-to-br from-yellow-400 via-red-500 to-pink-500 rounded-lg p-6 shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border-8 border-white outline outline-2 outline-white">
                        <h3 class="font-extrabold text-lg text-white mb-2">
                            Institute: {{ $institute->institute_name }}
                        </h3>
                        <p class="text-gray-200">Location: {{ $institute->location }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Confirmation Modal -->
        @if (session('status') === 'application-created')
            <x-confirm-modal :name="'create'" :content="'The application submitted successfully'">
            </x-confirm-modal>
        @endif
    </div>
</x-app-layout>
