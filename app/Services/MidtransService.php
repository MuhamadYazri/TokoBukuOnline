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

        // pakai preselect method payment pelanggan
        $enabledPayment = $this->getEnabledPayments($order->payment_method);

        if (!empty($enabledPayment)) {
            $params['enabled_payments'] = $enabledPayment;
        }

        try {
            $snap_token = Snap::getSnapToken($params);

            return $snap_token;
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    private function getEnabledPayments($paymentMethod)
    {
        // Mapping dari form value ke Midtrans payment codes
        $paymentMap = [
            // Credit Card
            'credit_card' => ['credit_card'],

            // Bank Transfer → Semua Virtual Account
            'bank_transfer' => [
                'bca_va',      // BCA Virtual Account
                'bni_va',      // BNI Virtual Account
                'bri_va',      // BRI Virtual Account
                'permata_va',  // Permata Virtual Account
                'other_va',    // Bank lain (Mandiri, CIMB, dll)
            ],

            // Specific Bank VAs (jika mau tambah pilihan spesifik di form)
            'bca_va' => ['bca_va'],
            'bni_va' => ['bni_va'],
            'bri_va' => ['bri_va'],
            'mandiri_va' => ['echannel'], // Mandiri Bill Payment

            // E-Wallet
            'e_wallet' => [
                'gopay',       // GoPay
                'shopeepay',   // ShopeePay
                'qris',        // QRIS (universal e-wallet)
            ],

            // Specific E-Wallets (jika mau tambah pilihan spesifik)
            'gopay' => ['gopay'],
            'shopeepay' => ['shopeepay'],
            'qris' => ['qris'],

            // COD tidak perlu (tidak pakai Midtrans)
            'cod' => [],
        ];

        // Return payment codes, atau empty array jika tidak ada mapping
        return $paymentMap[$paymentMethod] ?? [];
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
