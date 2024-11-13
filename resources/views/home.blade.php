<x-app-layout x-data="{open:false}">
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-800 p-4 shadow-md rounded-lg">
            <h2 class="font-semibold text-2xl text-white">
                {{ __('Home') }}
            </h2>
        </div>
    </x-slot>

    <!-- Main Section -->
    <div class="py-12 relative">
        
        <!-- Blurred Background Image -->
        <img src="graduate.jpg" alt="Students celebrating graduation" class="fixed w-full h-full top-0 right-0 left-0 bottom-0 object-cover opacity-70 blur-xl -z-10">
        
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/70 -z-10"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-gray-900/80 shadow-2xl sm:rounded-lg p-10 text-white backdrop-blur-md">
                <div class="flex flex-col items-center gap-6 justify-center">
                    
                    <!-- Header with Gradient Text -->
                    <h1 class="font-bold text-4xl md:text-5xl text-center text-transparent bg-clip-text bg-gradient-to-r from-[#00b4d8] to-[#90e0ef]">
                        Forge Your Path to a Bright Future
                    </h1> 
                    
                    <!-- Subheading -->
                    <p class="text-center text-lg md:text-xl text-gray-300">
                        Discover top learning opportunities and find courses that align perfectly with your skills and goals.
                    </p> 

                    <!-- Action Buttons -->
                    <div class="flex flex-col items-center gap-6 mt-6">
                        
                        <!-- Institution Registration Button -->
                        <a href="/institute/register" class="group">
                            <x-primary-button class="transform transition-transform duration-200 group-hover:scale-105 flex items-center justify-center bg-gradient-to-r from-[#00b4d8] to-[#0096c7] p-[2px] rounded-full shadow-lg">
                                <div class="hover:bg-gray-700 transition-colors duration-300 bg-gray-900 h-full w-full px-6 py-3 rounded-full text-white flex items-center justify-center font-semibold">
                                    Join Us as an Institution and Inspire Change
                                </div>
                            </x-primary-button>  
                        </a>
                        
                        <!-- Divider Line with "OR" -->
                        <div class="flex w-36 items-center gap-1">
                            <hr class="flex-1 border-[#90e0ef]">  
                            <span class="font-bold text-gray-300">OR</span>  
                            <hr class="flex-1 border-[#90e0ef]">  
                        </div>
                        
                        <!-- Student Registration Button -->
                        <a href="/student/register" class="group">
                            <x-primary-button class="transform transition-transform duration-200 group-hover:scale-105 flex items-center justify-center bg-gradient-to-r from-[#0096c7] to-[#023e8a] p-[2px] rounded-full shadow-lg">
                                <div class="hover:bg-gradient-to-r from-[#0096c7] to-[#03045e] hover:text-gray-200 transition-colors duration-300 bg-gray-900 h-full w-full px-6 py-3 rounded-full text-white flex items-center justify-center font-semibold">
                                    Establish Your Presence as a Student
                                </div>
                            </x-primary-button> 
                        </a>  
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
