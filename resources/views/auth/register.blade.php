@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Register</h2>
<form method="POST" action="/register" class="space-y-4">
    @csrf
    <input name="name" placeholder="Nama" class="w-full border p-2" required />
    <input name="email" placeholder="Email" class="w-full border p-2" required />
    <input name="password" type="password" placeholder="Password" class="w-full border p-2" required />
    <input name="password_confirmation" type="password" placeholder="Konfirmasi Password" class="w-full border p-2" required />
    <button class="bg-green-500 text-white px-4 py-2">Register</button>
</form>
<p class="mt-2">Sudah punya akun? <a href="/login" class="text-blue-500">Login</a></p>
@endsection
