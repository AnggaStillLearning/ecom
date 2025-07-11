@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Detail Pesanan</h2>

<p><strong>Customer:</strong> {{ $order->customer_name }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

<table class="w-full border mt-4">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2">Produk</th>
            <th class="p-2">Qty</th>
            <th class="p-2">Harga</th>
            <th class="p-2">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach ($order->items as $item)
            @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
            <tr class="border-b">
                <td class="p-2">{{ $item->product_name }}</td>
                <td class="p-2">{{ $item->quantity }}</td>
                <td class="p-2">Rp{{ number_format($item->price, 0) }}</td>
                <td class="p-2">Rp{{ number_format($subtotal, 0) }}</td>
            </tr>
        @endforeach
        <tr class="font-bold bg-gray-50">
            <td colspan="3" class="p-2 text-right">Total</td>
            <td class="p-2">Rp{{ number_format($total, 0) }}</td>
        </tr>
    </tbody>
</table>
@endsection
