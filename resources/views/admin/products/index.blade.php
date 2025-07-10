@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Kelola Produk</h2>
<a href="/admin/products/create" class="bg-blue-500 text-white px-3 py-2 rounded inline-block mb-4">Tambah Produk</a>

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full text-left border">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">Gambar</th>
            <th class="p-2">Nama</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class="border-t">
            <td class="p-2">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="h-16 w-16 object-cover">
                @endif
            </td>
            <td class="p-2">{{ $product->name }}</td>
            <td class="p-2">Rp{{ number_format($product->price, 0) }}</td>
            <td class="p-2">
                <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-500">Edit</a>
                <form action="/admin/products/{{ $product->id }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus produk?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 ml-2">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
