<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersDetail;
use App\Models\Cart;
use App\Models\Book;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Tampilkan riwayat pesanan
     */
    public function index()
    {
        $orders = Order::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Tampilkan form checkout
     */
    public function create()
    {
        $cartItems = Cart::with('book')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.books.index')
                ->with('error', 'Keranjang Anda kosong!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        return view('customer.orders.create', compact('cartItems', 'total'));
    }

    /**
     * Proses checkout (buat order)
     */
    public function store(Request $request)
    {
        $cartItems = Cart::with('book')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.books.index')
                ->with('error', 'Keranjang Anda kosong!');
        }

        DB::beginTransaction();
        try {
            $totalQuantity = 0;
            $totalPrice = 0;

            // Validasi stok & hitung total
            foreach ($cartItems as $item) {
                if ($item->book->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok buku '{$item->book->title}' tidak mencukupi!");
                }
                $totalQuantity += $item->quantity;
                $totalPrice += $item->quantity * $item->book->price;
            }

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            // Buat order untuk setiap buku
            foreach ($cartItems as $item) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'order_number' => $orderNumber,
                    'book_id' => $item->book_id,
                    'total_quantity' => $item->quantity,
                    'total_price' => $item->quantity * $item->book->price,
                    'status' => 'pending',
                ]);

                // Buat order detail
                OrdersDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                ]);

                // Kurangi stok buku
                $item->book->decreaseStock($item->quantity);
            }

            // Hapus cart setelah checkout
            Cart::where('user_id', Auth::id())->delete();

            // Log activity
            ActivityLog::createLog(
                Auth::id(),
                'create_order',
                "Membuat pesanan #{$orderNumber} dengan total Rp " . number_format($totalPrice)
            );

            DB::commit();

            return redirect()->route('customer.orders.index')
                ->with('success', "Pesanan berhasil dibuat! Nomor order: {$orderNumber}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail order
     */
    public function show(order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderDetails.book', 'book']);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Cancel order
     */
    public function cancel(order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa cancel jika status pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan!');
        }

        $order->cancel();

        // Kembalikan stok buku
        foreach ($order->orderDetails as $detail) {
            $detail->book->increaseStock($detail->quantity);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
