@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Produk</h2>
<form action="/admin/products/store" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <input name="name" placeholder="Nama Produk" class="w-full border p-2" required />
    <input name="price" placeholder="Harga" type="number" class="w-full border p-2" required />
    <textarea name="description" placeholder="Deskripsi" class="w-full border p-2"></textarea>
    <input type="file" name="image" class="w-full border p-2" />
    <button class="bg-green-500 text-white px-4 py-2">Simpan</button>
</form>
@endsection
