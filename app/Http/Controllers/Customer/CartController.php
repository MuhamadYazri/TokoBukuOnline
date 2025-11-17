<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Book;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan keranjang belanja
     */
    public function index()
    {
        $cartItems = Cart::with('book')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        return view('customer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Tambah buku ke keranjang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Cek stok
        if ($book->stock < $validated['quantity']) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        // Cek apakah sudah ada di cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('book_id', $validated['book_id'])
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            if ($book->stock < $newQuantity) {
                return back()->with('error', 'Stok buku tidak mencukupi!');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $validated['book_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        // Log activity
        ActivityLog::createLog(
            Auth::id(),
            'add_to_cart',
            "Menambahkan buku '{$book->title}' ke keranjang"
        );

        return back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity di keranjang
     */
    public function update(Request $request, Cart $cart)
    {
        // Pastikan cart milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek stok
        if ($cart->book->stock < $validated['quantity']) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        $cart->update($validated);

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    /**
     * Hapus item dari keranjang
     */
    public function destroy(Cart $cart)
    {
        // Pastikan cart milik user yang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
