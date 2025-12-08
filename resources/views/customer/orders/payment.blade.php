<x-app-layout>
    <x-HeaderGradient title="Pembayaran" subtitle="Selesaikan pembayaran pesanan Anda">
    </x-HeaderGradient>

    <div class="payment-page">
        <div class="payment-container">
            <div class="payment-card">
                <div style="text-align: center; padding: 40px 20px;">
                    <!-- Loading Icon -->
                    <div style="margin-bottom: 24px;">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" style="margin: 0 auto; animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;">
                            <circle cx="32" cy="32" r="30" stroke="#0088FF" stroke-width="3" fill="none" opacity="0.2"/>
                            <path d="M32 2 A30 30 0 0 1 62 32" stroke="#0088FF" stroke-width="3" fill="none" stroke-linecap="round">
                                <animateTransform attributeName="transform" type="rotate" from="0 32 32" to="360 32 32" dur="1s" repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </div>

                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; color: #003777; margin-bottom: 12px;">
                        Memproses Pembayaran...
                    </h2>

                    <p style="font-family: 'Poppins', sans-serif; font-size: 14px; color: #666666; margin-bottom: 8px;">
                        Order #{{ $order->order_number }}
                    </p>

                    <p style="font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 600; color: #0088FF; margin-bottom: 24px;">
                        Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>

                    <p style="font-family: 'Poppins', sans-serif; font-size: 14px; color: #999999; margin-bottom: 32px;">
                        Popup pembayaran akan muncul dalam beberapa detik
                    </p>

                    <button type="button" id="pay-button" class="btn-pay-now">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 9h20"/>
                        </svg>
                        Bayar Sekarang
                    </button>

                    <p class="payment-note" style="margin-top: 16px;">
                        Jika popup tidak muncul otomatis, klik tombol di atas
                    </p>

                    <a href="{{ route('customer.orders.index') }}" style="display: inline-block; margin-top: 16px; font-family: 'Poppins', sans-serif; font-size: 14px; color: #999999; text-decoration: underline;">
                        ← Kembali ke Riwayat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    </style>

    @push('scripts')
    <!-- Load Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const snapToken = '{{ $order->snap_token }}';
            const payButton = document.getElementById('pay-button');

            // Auto trigger popup setelah 1.5 detik
            // Delay untuk memberi user waktu melihat loading screen
            setTimeout(function() {
                openMidtransPopup();
            }, 1500);

            // Manual trigger jika user klik button
            payButton.addEventListener('click', function() {
                openMidtransPopup();
            });

            function openMidtransPopup() {
                window.snap.pay(snapToken, {
                    // Success: Pembayaran berhasil
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        window.location.href = '{{ route("customer.orders.payment.callback", ["order" => $order->id]) }}?status=success&transaction_id=' + result.transaction_id;
                    },

                    // Pending: Menunggu pembayaran (misal transfer bank)
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        window.location.href = '{{ route("customer.orders.payment.callback", ["order" => $order->id]) }}?status=pending';
                    },

                    // Error: Pembayaran gagal
                    onError: function(result) {
                        console.log('Payment error:', result);
                        window.location.href = '{{ route("customer.orders.payment.callback", ["order" => $order->id]) }}?status=failed';
                    },

                    // Close: User tutup popup tanpa menyelesaikan
                    onClose: function() {
                        if (confirm('Anda belum menyelesaikan pembayaran. Kembali ke riwayat pesanan?')) {
                            window.location.href = '{{ route("customer.orders.index") }}';
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
