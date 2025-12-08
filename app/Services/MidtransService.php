<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;


class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');

        Config::$isProduction = config('midtrans.is_production');

        Config::$isSanitized = config('midtrans.is_sanitized');

        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Buat transaksi baru di Midtrans
     *
     * Flow:
     * 1. Kirim data order ke Midtrans API
     * 2. Midtrans generate snap_token
     * 3. Token ini dipakai untuk popup pembayaran
     *
     * @param \App\Models\Order $order
     * @return string Snap token untuk popup
     * @throws \Exception
     */
    public function createTransaction($order)
    {
        // parameter untuk midtrans API
        $params = [
            // detail transaksi
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_price,
            ],

            // detail customer
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ],

            // detail item yang dibeli
            'item_details' => $this->getItemDetails($order),

            // URL callback setelah user selesai pembayaran
            // Midtrans akan redirect ke URL ini dengan status payment
            'callbacks' => [
                'finish' => route('customer.orders.payment.callback', [
                    'order' => $order->id,
                    'status' => 'success'
                ])
            ]
        ];

        try {
            $snap_token = Snap::getSnapToken($params);

            return $snap_token;
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    private function getItemDetails($order)
    {
        $items = [];

        if ($order->orderDetails && $order->orderDetails->count() > 0) {
            foreach ($order->orderDetails as $detail) {
                $items[] = [
                    'id' => $detail->book->id,
                    'price' => $detail->book->price,
                    'quantity' => $detail->quantity,
                    'name' => $detail->book->title,
                ];
            }
        } else {
            // Fallback
            $items[] = [
                'id' => $order->book->id ?? 1,
                'price' => (int) ($order->total_price / $order->total_quantity),
                'quantity' => (int) $order->total_quantity,
                'name' => $order->user->name,
            ];
        }
        return $items;
    }

    /**
     * Cek status transaksi dari Midtrans
     *
     * Digunakan untuk:
     * - Webhook handler (Midtrans kirim notifikasi)
     * - Manual check status
     *
     * @param string $orderId Order number
     * @return object Status dari Midtrans
     * @throws \Exception
     */

    public function getTransactionStatus($orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (\Exception $e) {
            throw new \Exception('Gagal mendapatkan status: ' . $e->getMessage());
        }
    }
}
