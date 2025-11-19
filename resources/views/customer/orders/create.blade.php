<x-app-layout>
    <div class="checkout-page">
        <div class="container">
            <h1 class="page-title">Checkout</h1>

            <div class="checkout-grid">
                <!-- Left: Order Items -->
                <div class="checkout-items-section">
                    <h2 class="section-title">Item yang Dibeli</h2>

                    <div class="checkout-items-list">
                        @foreach($cartItems as $item)
                            <div class="checkout-item">
                                <div class="item-image-small">
                                    @if($item->book->cover)
                                        <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                    @else
                                        <div class="item-placeholder-small">
                                            <svg width="30" height="30" viewBox="0 0 60 60" fill="none">
                                                <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="item-details-small">
                                    <h4>{{ $item->book->title }}</h4>
                                    <p>{{ $item->book->author }}</p>
                                    <span class="item-qty">{{ $item->quantity }}x</span>
                                </div>
                                <div class="item-price-small">
                                    Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Back to Cart -->
                    <a href="{{ route('customer.cart.index') }}" class="btn-back-cart">
                        ← Kembali ke Keranjang
                    </a>
                </div>

                <!-- Right: Checkout Form -->
                <div class="checkout-form-section">
                    <div class="checkout-card">
                        <h3>Konfirmasi Pesanan</h3>

                        <form method="POST" action="{{ route('customer.orders.store') }}" id="checkoutForm">
                            @csrf

                            <!-- Delivery Info -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M3 9L12 2L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z" stroke="#667eea" stroke-width="2"/>
                                        <path d="M9 21V12H15V21" stroke="#667eea" stroke-width="2"/>
                                    </svg>
                                    Informasi Pengiriman
                                </h4>

                                <div class="info-box">
                                    <div class="info-row">
                                        <span class="info-label">Nama:</span>
                                        <span class="info-value">{{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>

                                <p class="info-note">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="#6b7280" stroke-width="2"/>
                                        <path d="M10 6V10L13 13" stroke="#6b7280" stroke-width="2"/>
                                    </svg>
                                    Pesanan akan diproses dalam 1-2 hari kerja
                                </p>
                            </div>

                            <!-- Order Summary -->
                            <div class="form-section">
                                <h4 class="form-section-title">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M9 5H7C6.44772 5 6 5.44772 6 6V18C6 18.5523 6.44772 19 7 19H17C17.5523 19 18 18.5523 18 18V6C18 5.44772 17.5523 5 17 5H15M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01" stroke="#667eea" stroke-width="2"/>
                                    </svg>
                                    Ringkasan Pesanan
                                </h4>

                                <div class="summary-box">
                                    <div class="summary-row-checkout">
                                        <span>Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                                        <span class="summary-value-checkout">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="summary-row-checkout">
                                        <span>Biaya Pengiriman</span>
                                        <span class="summary-value-checkout">Rp 0</span>
                                    </div>
                                    <div class="summary-row-checkout">
                                        <span>Biaya Admin</span>
                                        <span class="summary-value-checkout">Rp 0</span>
                                    </div>
                                    <div class="summary-divider-checkout"></div>
                                    <div class="summary-row-checkout summary-total-checkout">
                                        <span>Total Pembayaran</span>
                                        <span class="summary-total-value-checkout">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="terms-section">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="agreeTerms" required>
                                    <span>Saya setuju dengan <a href="#" class="terms-link">Syarat & Ketentuan</a></span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-place-order" id="btnPlaceOrder">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M5 10L8 13L15 6" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                Buat Pesanan
                            </button>

                            <p class="security-note">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 2L3 6V10C3 14.55 6.84 18.74 10 19C13.16 18.74 17 14.55 17 10V6L10 2Z" stroke="#10B981" stroke-width="2"/>
                                    <path d="M7 10L9 12L13 8" stroke="#10B981" stroke-width="2"/>
                                </svg>
                                Transaksi Anda aman dan terenkripsi
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .checkout-page {
            padding: 40px 0;
            background: #f9fafb;
            min-height: calc(100vh - 200px);
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #1f2937;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 500px;
            gap: 40px;
        }

        /* Checkout Items Section */
        .checkout-items-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            height: fit-content;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f3f4f6;
        }

        .checkout-items-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .checkout-item {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }

        .item-image-small {
            width: 60px;
            height: 80px;
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .item-image-small img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-placeholder-small {
            width: 100%;
            height: 100%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-details-small {
            flex: 1;
        }

        .item-details-small h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .item-details-small p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .item-qty {
            display: inline-block;
            padding: 2px 8px;
            background: #e5e7eb;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .item-price-small {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
        }

        .btn-back-cart {
            display: inline-block;
            padding: 12px 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid #667eea;
            border-radius: 10px;
        }

        .btn-back-cart:hover {
            background: #f0f4ff;
        }

        /* Checkout Form Section */
        .checkout-form-section {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .checkout-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .checkout-card h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .info-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #1f2937;
        }

        .info-note {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            background: #fffbeb;
            padding: 12px;
            border-radius: 8px;
        }

        .summary-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
        }

        .summary-row-checkout {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: #6b7280;
        }

        .summary-value-checkout {
            font-weight: 600;
            color: #1f2937;
        }

        .summary-divider-checkout {
            height: 2px;
            background: #e5e7eb;
            margin: 15px 0;
        }

        .summary-total-checkout {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .summary-total-value-checkout {
            font-size: 24px;
            color: #667eea;
        }

        .terms-section {
            margin-bottom: 25px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .terms-link {
            color: #667eea;
            text-decoration: none;
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        .btn-place-order {
            width: 100%;
            padding: 16px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn-place-order:hover {
            background: #5568d3;
        }

        .btn-place-order:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            color: #10b981;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .checkout-form-section {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 28px;
            }

            .checkout-card {
                padding: 20px;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Disable submit button after click
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnPlaceOrder');
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/><path d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor"/></svg> Memproses...';
        });
    </script>
    @endpush
</x-app-layout>
