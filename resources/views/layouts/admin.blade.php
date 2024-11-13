<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Higher Learning') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased pb-3">
    <div class=" bg-gray-100">
        <!-- Page Content -->
        <main class="max-[640px]:px-4">
            <div class="">
                <aside class=" bg-gray-800 text-indigo-500 fixed top-0 py-6 pr-2 left-0 bottom-0">
                        <x-responsive-admin-nav-link href="/dashboard" :active="request()->is('dashboard')">
                            <x-carbon-dashboard class="{{request()->is('dashboard') ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                            <span class="title">Dashboard</span>
                        </x-responsive-admin-nav-link>   
                    <x-responsive-admin-nav-link href="/ad/institute" :active="request()->is('ad/institute') || request()->is('ad/institute/*')">
                        <x-carbon-book class="{{(request()->is('ad/institute')||request()->is('ad/institute/*')) ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Institutes</span>
                    </x-responsive-admin-nav-link>
                    <x-responsive-admin-nav-link href="/ad/faculty" :active="request()->is('ad/faculty') || request()->is('ad/faculty/*')">
                        <x-carbon-box class="{{(request()->is('ad/faculty') || request()->is('ad/faculty/*')) ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Faculties</span>
                    </x-responsive-admin-nav-link>
                    <x-responsive-admin-nav-link href="/ad/course" :active="request()->is('ad/course') || request()->is('ad/course/*')">
                        <x-carbon-course class="{{(request()->is('ad/course') ||request()->is('ad/course/*')) ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Courses</span>
                    </x-responsive-admin-nav-link>
                    <x-responsive-admin-nav-link href="/ad/applications" :active="request()->is('ad/applications') || request()->is('ad/applications/*')">
                        <x-carbon-application class="{{(request()->is('ad/applications') || request()->is('ad/applications/*')) ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Applications</span>
                    </x-responsive-admin-nav-link>
                    <x-responsive-admin-nav-link href="/ad/admissions" :active="request()->is('ad/admissions')">
                        <x-carbon-checkmark-outline class="{{request()->is('ad/admissions') ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Admissions</span>
                    </x-responsive-admin-nav-link>
                    
                    <hr>
                    <x-responsive-admin-nav-link href="/ad/create" :active="request()->is('ad/create')">
                        <x-carbon-user-avatar class="{{request()->is('ad/create') ? 'text-indigo-500' : 'text-gray-100'}} h-5 w-5 " />
                        <span class="title">Create Admin</span>
                    </x-responsive-admin-nav-link>
                </aside>
                <div id="wrap" class="">
                    <!-- Page Heading -->
                    <header id="header" class="bg-gray-200 shadow fixed top-0 right-0">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            @include('layouts.admin-header')
                        </div>
                    </header>
                    <section class="px-4 bg-gray-100 pt-[90px]">
                       {{ $slot }} 
                    </section>
                
                </div>
            </div>
            
            
        </main>
    </div>
</body>

</html>