<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ===========================
    //         BAGIAN USER
    // ===========================

    /**
     * Menampilkan semua produk ke user.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Menampilkan detail produk tertentu ke user.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image, // simpan path gambar
            ];
        }

        session()->put('cart', $cart);
        return redirect('/')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Menampilkan isi keranjang belanja.
     */
    public function cart()
    {
        return view('product.cart');
    }

    /**
     * Memproses checkout dan menyimpan pesanan.
     */
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Keranjang kosong!');
        }

        // Buat order baru
        $order = Order::create([
            'customer_name' => auth()->check() ? auth()->user()->name : 'Guest',
            'status' => 'pending',
        ]);

        // Tambahkan item ke order
        foreach ($cart as $item) {
            $order->items()->create([
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan berhasil dibuat dan menunggu konfirmasi admin.');
    }

    // ===========================
    //         BAGIAN ADMIN
    // ===========================

    /**
     * Menampilkan daftar produk ke halaman admin.
     */
    public function adminIndex()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Tampilkan form tambah produk untuk admin.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Simpan produk baru dari admin.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/products
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Proses update produk oleh admin.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Ganti gambar jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Upload gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect('/admin/products')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus produk dari sistem.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus');
    }
}
