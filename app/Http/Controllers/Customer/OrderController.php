<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Book;
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


    public function index()
    {
        $orders = Order::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $query = Cart::with('book')->where('user_id', Auth::id());

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

            foreach ($cartItems as $item) {
                if ($item->book->stock < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok buku '{$item->book->title}' tidak mencukupi!");
                }
                $totalQuantity += $item->quantity;
                $totalPrice += $item->quantity * $item->book->price;
            }

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

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                ]);

                $item->book->decreaseStock($item->quantity);
            }

            // Generate Midtrans snap token untuk non-COD payment
            if ($request->payment_method !== 'cod') {
                $snapToken = $this->midtransService->createTransaction($order);
                $order->update(['snap_token' => $snapToken]);
            }

            if (session()->has('checkout_cart_ids')) {
                Cart::where('user_id', Auth::id())
                    ->whereIn('id', session('checkout_cart_ids'))
                    ->delete();
                session()->forget('checkout_cart_ids');
            } else {
                Cart::where('user_id', Auth::id())->delete();
            }

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

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

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

        $status = $request->query('status');

        if ($status === 'success') {
            try {
                $midtransStatus = $this->midtransService->getTransactionStatus($order->order_number);

                if ($midtransStatus->transaction_status === 'settlement') {
                    $order->markAsPaid($midtransStatus->transaction_id);

                    return redirect()->route('customer.orders.index')
                        ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
                }
            } catch (\Exception $e) {
                return redirect()->route('customer.orders.index')
                    ->with('info', 'Pembayaran sedang diproses, mohon tunggu konfirmasi.');
            }
        }

        if ($status === 'pending') {
            return redirect()->route('customer.orders.index')
                ->with('info', 'Pembayaran pending, silakan selesaikan pembayaran.');
        }

        $order->update(['payment_status' => 'failed']);
        return redirect()->route('customer.orders.index')
            ->with('error', 'Pembayaran gagal, silakan coba lagi.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderDetails.book', 'book']);

        return view('customer.orders.show', compact('order'));
    }





    public function confirm(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Pesanan tidak dapat dikonfirmasi!');
        }

        $order->update([
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah diterima dan transaksi selesai.');
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan! Hanya pesanan dengan status "Menunggu" yang dapat dibatalkan.');
        }

        $order->cancel();

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
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        switch ($request->transaction_status) {
            case 'settlement':
            case 'capture':
                $order->markAsPaid($request->transaction_id);
                break;

            case 'pending':
                $order->update(['payment_status' => 'pending']);
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled'
                ]);
                break;
        }

        return response()->json(['message' => 'Notification received']);
    }
}
