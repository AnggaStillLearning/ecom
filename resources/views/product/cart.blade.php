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
                <th class="p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach (session('cart') as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <tr class="border-b">
                    <td class="p-2 flex items-center gap-2">
                        @if(isset($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded">
                        @endif
                        <span>{{ $item['name'] }}</span>
                    </td>
                    <td class="p-2">{{ $item['quantity'] }}</td>
                    <td class="p-2">Rp{{ number_format($item['price'], 0) }}</td>
                    <td class="p-2">Rp{{ number_format($subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-lg font-semibold">Total: Rp{{ number_format($total, 0) }}</p>

    <form action="{{ url('/checkout') }}" method="POST" class="mt-4">
        @csrf
        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Checkout
        </button>
    </form>
@else
    <p>Keranjang kosong.</p>
@endif
@endsection
