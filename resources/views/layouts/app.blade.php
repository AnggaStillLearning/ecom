<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce Tailwind</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        <nav class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">
                <a href="/">E-Commerce</a>
            </h1>

            <div class="flex items-center space-x-4">
                <a href="/cart" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Keranjang ({{ count(session('cart', [])) }})
                </a>

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="/admin/products" class="text-blue-600 hover:underline">
                            Dashboard Admin
                        </a>
                    @endif

                    <span class="text-gray-700">Hi, {{ auth()->user()->name }}</span>

                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="/login" class="text-blue-600 hover:underline">Login</a>
                    <a href="/register" class="text-blue-600 hover:underline">Register</a>
                @endauth
            </div>
        </nav>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
