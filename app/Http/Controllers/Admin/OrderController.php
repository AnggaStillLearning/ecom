<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Ambil semua pesanan beserta item-itemnya, urutkan dari yang terbaru
        $orders = Order::with('items')->latest()->get();

        // Kirim data ke view admin.orders.index
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mengonfirmasi pesanan berdasarkan ID.
     *
     * @param int $id ID pesanan
     */
    public function confirm($id)
    {
        // Cari pesanan berdasarkan ID, atau gagal jika tidak ditemukan
        $order = Order::findOrFail($id);

        // Ubah status menjadi "confirmed"
        $order->status = 'confirmed';
        $order->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pesanan dikonfirmasi.');
    }

    /**
     * Membatalkan pesanan berdasarkan ID.
     *
     * @param int $id ID pesanan
     */
    public function cancel($id)
    {
        // Cari pesanan berdasarkan ID, atau gagal jika tidak ditemukan
        $order = Order::findOrFail($id);

        // Ubah status menjadi "cancelled"
        $order->status = 'cancelled';
        $order->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pesanan dibatalkan.');
    }
    public function show($id)
    {
    $order = Order::with('items')->findOrFail($id);
    return view('admin.orders.show', compact('order'));
    }

}
