@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Login</h2>
<form method="POST" action="/login" class="space-y-4">
    @csrf
    <input name="email" placeholder="Email" class="w-full border p-2" required />
    <input name="password" type="password" placeholder="Password" class="w-full border p-2" required />
    <button class="bg-blue-500 text-white px-4 py-2">Login</button>
</form>
<p class="mt-2">Belum punya akun? <a href="/register" class="text-blue-500">Register</a></p>
@endsection
