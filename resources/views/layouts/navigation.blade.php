
<nav x-data="{ open: false, rOpen:false,lOpen:false }" :class="open && 'pb-3'" class=" bg-gray-800 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class=" flex justify-between h-16">
            <div class="flex">
                

                <!-- Navigation Links -->
                 @auth
                 <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endauth

                @guest
                 <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                @endguest
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex" >
                    <x-nav-link href="/institutes" :active="request()->is('institutes') || request()->is('institutes/*')">
                        {{ __('Institutes') }}
                    </x-nav-link>
                </div>
                
                @auth
                @if(Auth::user()?->institute)
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/faculty" :active="request()->routeIs('faculty') || request()->is('faculty/*')">
                        {{ __('Faculty') }}
                    </x-nav-link>
                </div>
                @endif
                @endauth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/courses" :active="request()->is('courses') || request()->is('course/*')">
                        {{ __('Courses') }}
                    </x-nav-link>
                </div>
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/applications" :active="request()->is('applications') || request()->is('applications/*')">
                        {{ __('Applications') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                   <x-nav-link href="/admissions" :active="request()->is('admissions') || request()->is('admissions/*')">
                       {{ __('Admissions') }}
                   </x-nav-link>
               </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
             <div class="flex">
            @guest
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-link-button>
                    Login
                </x-link-button>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ 'Register'}}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="/student/register">
                            {{ __('Student') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="/institute/register">
                            {{ __('Institute') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
            @endguest

            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex flex-col">
                    <x-responsive-nav-link href="/" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/about" :active="request()->is('about')">
                        {{ __('About') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/courses" :active="request()->is('courses')">
                        {{ __('Courses') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="institutes" :active="request()->is('institutes')">
                        {{ __('Institutes') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <div class="mt-3 space-y-3 px-3">
                <div class="space-y-3">
                 <x-secondary-button @click="rOpen = ! rOpen">
                    Register
                </x-secondary-button>  
                <div :class="(!rOpen && open) ? 'hidden':'flex flex-col gap-1 ml-3'">
                    <x-responsive-nav-link href="/student/register" :active="request()->is('student/register')">
                        {{ __('Student') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/institute/register" :active="request()->is('/institute/register')">
                        {{ __('Institute') }}
                    </x-responsive-nav-link>
                </div> 
                </div>
                <div class="mt-1">
                 <x-link-button>
                    Login
                </x-link-button>
                </div>
                
            </div>
        </div>
    </div>
    </nav>
