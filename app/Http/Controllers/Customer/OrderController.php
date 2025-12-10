<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Book;
// use App\Models\ActivityLog;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }


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
    public function create(Request $request)
    {
        $query = Cart::with('book')->where('user_id', Auth::id());

        // Jika ada cart_ids yang dipilih (dari checkbox), ambil hanya yang dipilih
        if ($request->has('cart_ids') && is_array($request->cart_ids)) {
            $query->whereIn('id', $request->cart_ids);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Tidak ada item yang dipilih!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->price;
        });

        // Simpan cart_ids di session untuk digunakan saat store
        if ($request->has('cart_ids')) {
            session(['checkout_cart_ids' => $request->cart_ids]);
        } else {
            session()->forget('checkout_cart_ids');
        }

        return view('customer.orders.create', compact('cartItems', 'total'));
    }

    /**
     * Store new order + generate payment
     *
     * Flow:
     * 1. Validate input (payment method wajib)
     * 2. Create order dari cart items
     * 3. Generate snap token dari Midtrans (jika bukan COD)
     * 4. Clear cart
     * 5. Redirect ke payment page
     */
    public function store(Request $request)
    {

        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,bca_va,bni_va,bri_va,mandiri_va,e_wallet,gopay,shopeepay,qris,cod',
        ]);

        $query = Cart::with('book')->where('user_id', Auth::id());

        // Ambil hanya cart items yang dipilih (dari session checkout)
        if (session()->has('checkout_cart_ids')) {
            $query->whereIn('id', session('checkout_cart_ids'));
        }

        $cartItems = $query->get();

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

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'total_quantity' => $totalQuantity,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);
            // Buat order untuk setiap buku
            foreach ($cartItems as $item) {
                // Buat order detail
                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                ]);

                // Kurangi stok buku
                $item->book->decreaseStock($item->quantity);
            }

            // Generate Midtrans snap token untuk non-COD payment
            if ($request->payment_method !== 'cod') {
                $snapToken = $this->midtransService->createTransaction($order);
                $order->update(['snap_token' => $snapToken]);
            }

            // Hapus cart items yang sudah di-checkout
            // Jika ada selected items, hapus hanya yang dipilih
            if (session()->has('checkout_cart_ids')) {
                Cart::where('user_id', Auth::id())
                    ->whereIn('id', session('checkout_cart_ids'))
                    ->delete();
                session()->forget('checkout_cart_ids');
            } else {
                // Hapus semua cart jika checkout semua items
                Cart::where('user_id', Auth::id())->delete();
            }

            // Log activity
            // ActivityLog::createLog(
            //     Auth::id(),
            //     'create_order',
            //     "Membuat pesanan #{$orderNumber} dengan total Rp " . number_format($totalPrice)
            // );

            DB::commit();

            if ($request->payment_method !== 'cod') {
                return redirect()->route('customer.orders.payment', $order->id);
            }

            return redirect()->route('customer.orders.index')
                ->with('success', "Pesanan berhasil dibuat! Bayar saat barang tiba.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman payment
     *
     * Halaman ini akan load Midtrans Snap JS
     * User klik "Bayar Sekarang" → popup Midtrans muncul
     */

    public function payment($id)
    {
        $order = Order::with('orderDetails.book')->findOrFail($id);

        // check order milik user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // jika sudah payment, redirect ke orders
        if ($order->isPaid()) {
            return redirect()->route('customer.orders.index')->with('info', 'Pesanan sudah dibayar');
        }

        if ($order->payment_method === 'cod') {
            return redirect()->route('customer.orders.index');
        }

        return view('customer.orders.payment', compact('order'));
    }

    /**
     * Handle callback dari Midtrans setelah pembayaran
     *
     * Flow:
     * 1. User selesai bayar di popup Midtrans
     * 2. Midtrans redirect ke URL ini
     * 3. Update status order
     * 4. Redirect ke orders dengan message
     */
    public function paymentCallback(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Ambil status dari query string
        $status = $request->query('status');

        // Handle berdasarkan status
        if ($status === 'success') {
            // Cek status dari Midtrans API (untuk validasi)
            try {
                $midtransStatus = $this->midtransService->getTransactionStatus($order->order_number);

                // Jika settlement (berhasil dibayar)
                if ($midtransStatus->transaction_status === 'settlement') {
                    $order->markAsPaid($midtransStatus->transaction_id);

                    return redirect()->route('customer.orders.index')
                        ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
                }
            } catch (\Exception $e) {
                // Jika error saat cek status, assume success (akan diupdate via webhook)
                return redirect()->route('customer.orders.index')
                    ->with('info', 'Pembayaran sedang diproses, mohon tunggu konfirmasi.');
            }
        }

        if ($status === 'pending') {
            return redirect()->route('customer.orders.index')
                ->with('info', 'Pembayaran pending, silakan selesaikan pembayaran.');
        }

        // Failed
        $order->update(['payment_status' => 'failed']);

        return redirect()->route('customer.orders.index')
            ->with('error', 'Pembayaran gagal, silakan coba lagi.');
    }

    /**
     * Tampilkan detail order
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderDetails.book', 'book']);

        return view('customer.orders.show', compact('order'));
    }





    /**
     * Confirm order received (update status to completed)
     */
    public function confirm(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa confirm jika status shipped
        if ($order->status !== 'shipped') {
            return back()->with('error', 'Pesanan tidak dapat dikonfirmasi!');
        }

        // Update status ke completed
        $order->update([
            'status' => 'completed',
            'payment_status' => 'paid', // Mark as paid untuk COD
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah diterima dan transaksi selesai.');
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order)
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


    /**
     * Webhook handler untuk notifikasi dari Midtrans
     *
     * Kenapa perlu webhook?
     * - Callback hanya dipanggil jika user klik "finish" di popup
     * - Jika user tutup popup, callback tidak jalan
     * - Webhook SELALU dipanggil oleh Midtrans saat status berubah
     *
     * Flow:
     * 1. User bayar di Midtrans
     * 2. Midtrans kirim POST request ke URL ini
     * 3. Kita update status order
     */
    public function midtransNotification(Request $request)
    {
        // Validasi signature untuk keamanan
        // Pastikan request benar-benar dari Midtrans
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        // Jika signature tidak cocok, reject
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari order berdasarkan order_number
        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status berdasarkan transaction_status dari Midtrans
        switch ($request->transaction_status) {
            case 'settlement':  // Pembayaran berhasil
            case 'capture':     // Kartu kredit berhasil
                $order->markAsPaid($request->transaction_id);
                break;

            case 'pending':     // Menunggu pembayaran
                $order->update(['payment_status' => 'pending']);
                break;

            case 'deny':        // Ditolak
            case 'expire':      // Expired
            case 'cancel':      // Dibatalkan
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
                break;
        }

        // Return response ke Midtrans
        return response()->json(['message' => 'Notification received']);
    }
}
