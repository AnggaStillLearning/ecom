@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Keranjang Belanja</h2>

@if (session('cart'))
    <table class="w-full text-left border-collapse mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Produk</th>
                <th class="p-2">Qty</th>
                <th class="p-2">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach (session('cart') as $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <tr class="border-b">
                    <td class="p-2">{{ $item['name'] }}</td>
                    <td class="p-2">{{ $item['quantity'] }}</td>
                    <td class="p-2">Rp{{ number_format($item['price'], 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="text-lg font-semibold">Total: Rp{{ number_format($total, 0) }}</p>
    <a href="/checkout" class="mt-3 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
        Checkout
    </a>
@else
    <p>Keranjang kosong.</p>
@endif
@endsection
