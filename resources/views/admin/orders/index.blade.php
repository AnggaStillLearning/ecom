@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Daftar Pesanan</h2>

{{-- Tabel utama untuk daftar pesanan --}}
<table class="w-full border text-left mb-4">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">Customer</th>
            <th class="p-2">Status</th>
            <th class="p-2">Produk</th>
            <th class="p-2">Total Bayar</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            @php $total = 0; @endphp
            <tr class="border-b">
                {{-- Nama customer --}}
                <td class="p-2">{{ $order->customer_name }}</td>

                {{-- Status pesanan --}}
                <td class="p-2">
                    @if ($order->status === 'pending')
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @elseif ($order->status === 'confirmed')
                        <span class="text-green-600 font-semibold">Terkonfirmasi</span>
                    @else
                        <span class="text-red-600 font-semibold">Dibatalkan</span>
                    @endif
                </td>

                {{-- Daftar produk dalam pesanan --}}
                <td class="p-2">
                    <ul class="list-inside">
                        @foreach ($order->items as $item)
                            @php
                                $subTotal = $item->price * $item->quantity;
                                $total += $subTotal;
                            @endphp
                            <li class="mb-2">
                                <span class="font-semibold">{{ $item->product_name }}</span><br>
                                <span>Qty: {{ $item->quantity }}</span><br>
                                <span>Harga: Rp{{ number_format($item->price, 0) }}</span><br>
                                <span class="text-sm text-gray-500">
                                    Subtotal: Rp{{ number_format($subTotal, 0) }}
                                </span>
                                <hr class="my-1">
                            </li>
                        @endforeach
                    </ul>
                </td>

                {{-- Total pembayaran pesanan --}}
                <td class="p-2 font-bold">Rp{{ number_format($total, 0) }}</td>

                {{-- Tombol aksi untuk admin --}}
                <td class="p-2 space-y-2">
                    {{-- Tombol Lihat Invoice --}}
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                        class="bg-blue-500 text-white px-2 py-1 rounded inline-block">
                        Lihat Invoice
                    </a>

                    @if ($order->status === 'pending')
                        {{-- Tombol konfirmasi --}}
                        <form action="/admin/orders/{{ $order->id }}/confirm" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">
                                Konfirmasi
                            </button>
                        </form>

                        {{-- Tombol batalkan --}}
                        <form action="/admin/orders/{{ $order->id }}/cancel" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">
                                Batalkan
                            </button>
                        </form>
                    @else
                        <span class="text-gray-500 italic block">Tidak tersedia</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
