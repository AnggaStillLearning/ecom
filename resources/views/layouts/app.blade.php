<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce Tailwind</title>
    @vite('resources/css/app.css')

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-4">
        {{-- Navbar --}}
        <nav class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">
                <a href="/">E-Commerce</a>
            </h1>

            <div class="flex items-center space-x-4">
                {{-- Keranjang --}}
                <a href="/cart" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Keranjang ({{ count(session('cart', [])) }})
                </a>

                {{-- Profil Dropdown --}}
                @auth
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="dropdownMenu" class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded hidden z-50">
                        {{-- Profil Atas --}}
                        <div class="p-4 border-b">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ '@' . Str::slug(auth()->user()->name) }}</p>
                                </div>
                            </div>
                            <a href="/profil" class="text-blue-600 text-sm hover:underline mt-2 inline-block">Lihat Profil Anda</a>
                        </div>

                        {{-- Menu Opsi --}}
                        <ul class="text-sm divide-y">
                            @if (auth()->user()->role === 'admin')
                            <li>
                                <a href="/admin/products" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"></path>
                                    </svg>
                                    Dashboard Admin
                                </a>
                            </li>
                            @endif
                            <li>
                                <form action="/logout" method="POST" id="logoutForm">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 hover:bg-gray-100 text-left">
                                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @else
                {{-- Jika belum login --}}
                <a href="/login" class="text-blue-600 hover:underline">Login</a>
                <a href="/register" class="text-blue-600 hover:underline">Register</a>
                @endauth
            </div>
        </nav>

        {{-- Konten Utama --}}
        @yield('content')
    </div>

    {{-- Script untuk dropdown --}}
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');

            document.addEventListener('click', function handleOutsideClick(event) {
                if (!dropdown.contains(event.target) && !event.target.closest('button')) {
                    dropdown.classList.add('hidden');
                    document.removeEventListener('click', handleOutsideClick);
                }
            });
        }
    </script>

    {{-- SweetAlert2 Notifikasi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
</body>
</html>
