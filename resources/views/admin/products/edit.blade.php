@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Produk</h2>
<form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $product->name }}" class="w-full border p-2" required />
    <input name="price" value="{{ $product->price }}" type="number" class="w-full border p-2" required />
    <textarea name="description" class="w-full border p-2">{{ $product->description }}</textarea>

    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" class="h-32 mb-2">
    @endif

    <input type="file" name="image" class="w-full border p-2" />
    <button class="bg-green-500 text-white px-4 py-2">Simpan</button>
</form>
@endsection
