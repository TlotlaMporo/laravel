<x-admin-layout>
    <div class="py-12" x-data="{name:''}">
        <div class="flex justify-between items-center mb-3 sm:px-8">
            <h2 id="title" data-title="Faculty" data-list="Faculties" class="font-bold text-2xl">Update Faculty  
            </h2>
        
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                @include('includes.edit-faculty')
            </div>
        </div>
        
    </div>
    
</x-admin-layout>