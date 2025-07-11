<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow h-screen sticky top-0">
            <div class="p-4 text-xl font-bold border-b">Admin Panel</div>
            <nav class="p-4 space-y-2">
                <a href="/admin/products" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/products*') ? 'bg-gray-200 font-semibold' : '' }}">
                    Produk
                </a>
                <a href="/admin/orders" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->is('admin/orders*') ? 'bg-gray-200 font-semibold' : '' }}">
                    Pesanan
                </a>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded hover:bg-gray-200">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
