<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Educational RIASEC-style interest exploration tool. For entertainment and learning purposes only - not for professional career guidance.">
    <meta name="keywords" content="RIASEC, interest exploration, educational tool, Holland model learning, career education">
    <meta name="author" content="Interest Explorer V1.0">
    <title>@yield('title', 'RIASEC Interest Explorer - Educational Tool')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-gray-900 hover:text-gray-700">
                        Interest Explorer V1.0
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                        <a href="{{ route('dashboard') }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">Dashboard</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('filament.admin.pages.dashboard') }}" 
                               class="text-red-600 hover:text-red-800 font-medium">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-600 hover:text-gray-800 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">Login</a>
                        <a href="{{ route('register') }}" 
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main content area -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

    <!-- Optional: Footer -->
    <footer class="bg-white text-center p-4 border-t text-sm text-gray-600">
        &copy; {{ date('Y') }} Interest Explorer V1.0 - Educational Tool Only
    </footer>
</div>

</body>
</html>
