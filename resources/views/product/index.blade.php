@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Daftar Produk</h2>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($products as $product)
        <div class="bg-white rounded shadow p-4">
            <img src="{{ asset('storage/' . $product->image) }}">
            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
            <p class="text-gray-600 text-sm mb-2">Rp{{ number_format($product->price, 0) }}</p>
            <a href="/add-to-cart/{{ $product->id }}"
               class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
               Tambah ke Keranjang
            </a>
        </div>
    @endforeach
</div>
@endsection
