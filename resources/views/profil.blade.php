@extends('layouts.app')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Profil Pengguna</h2>

    <p class="mb-2"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
    <p class="mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>
    <p class="mb-4"><strong>Role:</strong> {{ auth()->user()->role }}</p>

    @if (auth()->user()->role === 'admin')
        <a href="/admin/products" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">
            Dashboard Admin
        </a>
    @endif

    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Logout
        </button>
    </form>
</div>
@endsection
