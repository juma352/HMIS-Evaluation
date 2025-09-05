<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HMIS Evaluation</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-indigo-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-5xl font-bold text-gray-800">HMIS Evaluation System</h1>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="{{ route('login') }}" class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                            <div>
                                <h2 class="mt-4 text-xl font-semibold text-gray-900">Login</h2>
                                <p class="mt-2 text-gray-500 text-sm leading-relaxed">
                                    Access your existing account to manage evaluations.
                                </p>
                            </div>
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                                <div>
                                    <h2 class="mt-4 text-xl font-semibold text-gray-900">Register</h2>
                                    <p class="mt-2 text-gray-500 text-sm leading-relaxed">
                                        Create a new account to start using the HMIS Evaluation System.
                                    </p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="https://laravel.com" class="group inline-flex items-center hover:text-gray-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="h-6 w-6 -mt-px mr-1 w-5 h-5 stroke-gray-400 group-hover:stroke-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3.037.524M12 6.042a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3.037.524M12 6.042V3.75m-6 0H3.75m0 0h-.008v.008H3.75V3.75zm6 0h.008v.008H9.75V3.75zM12 15.75h.008v.008H12V15.75zm-6 0H3.75m0 0h-.008v.008H3.75V15.75zm3 0h.008v.008H6.75V15.75zm3 0h.008v.008H9.75V15.75zm3 0h.008v.008H12V15.75zm3 0h.008v.008H15.75V15.75zm3 0h.008v.008H18.75V15.75zm3 0h.008v.008H21.75V15.75zM7.5 18.75a.75.75 0 000 1.5h9a.75.75 0 000-1.5h-9z" />
                                </svg>
                                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
