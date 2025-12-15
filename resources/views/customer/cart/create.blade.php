<x-app-layout>
    <div class="checkout-page">
        <div class="container">
            <h1 class="page-title">Checkout</h1>

            <form method="POST" action="{{ route('customer.orders.store') }}" class="checkout-layout">
                @csrf

                <div class="order-summary-section">
                    <h2 class="section-title">Pesanan Anda</h2>

                    <div class="order-items">
                        @foreach($cartItems as $item)
                            <div class="checkout-item">
                                <div class="checkout-item-image">
                                    @if(Storage::exists('public/' . $item->book->cover))
                                        <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                    @else
                                        <img src="{{ asset( 'public/' .$item->book->cover) }}" alt="{{ $item->book->title }}">

                                    @endif
                                    <span class="item-quantity-badge">{{ $item->quantity }}x</span>
                                </div>

                                <div class="checkout-item-info">
                                    <h3>{{ $item->book->title }}</h3>
                                    <p class="checkout-item-author">{{ $item->book->author }}</p>
                                    <div class="checkout-item-price">
                                        <span class="item-unit-price">Rp {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                        <span class="item-subtotal">Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total-box">
                        <div class="total-row">
                            <span>Total Item</span>
                            <span>{{ $cartItems->sum('quantity') }} buku</span>
                        </div>
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="total-divider"></div>
                        <div class="total-row total-final">
                            <span>Total Pembayaran</span>
                            <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="payment-section">
                    <h2 class="section-title">Konfirmasi Pembayaran</h2>

                    <div class="info-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#3B82F6" stroke-width="2"/>
                            <path d="M12 8V12M12 16H12.01" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <div>
                            <h4>Informasi Pembayaran</h4>
                            <p>Pesanan Anda akan diproses setelah mengklik tombol "Buat Pesanan". Silakan lakukan pembayaran sesuai instruksi yang akan dikirimkan.</p>
                        </div>
                    </div>

                    <div class="customer-info-box">
                        <h3>Informasi Pembeli</h3>
                        <div class="info-detail">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" fill="#9CA3AF"/>
                                <path d="M10 12C5.58172 12 2 15.5817 2 20H18C18 15.5817 14.4183 12 10 12Z" fill="#9CA3AF"/>
                            </svg>
                            <div>
                                <label>Nama</label>
                                <p>{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <div class="info-detail">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M2 3C2 2.44772 2.44772 2 3 2H17C17.5523 2 18 2.44772 18 3V17C18 17.5523 17.5523 18 17 18H3C2.44772 18 2 17.5523 2 17V3Z" stroke="#9CA3AF" stroke-width="2"/>
                                <path d="M2 6L10 11L18 6" stroke="#9CA3AF" stroke-width="2"/>
                            </svg>
                            <div>
                                <label>Email</label>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="terms-box">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agree_terms" required>
                            <span>Saya menyetujui syarat dan ketentuan yang berlaku</span>
                        </label>
                    </div>

                    <div class="checkout-actions">
                        <a href="{{ route('customer.cart.index') }}" class="btn-back">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M12 4L6 10L12 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn-place-order">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M9 5L15 10L9 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        .checkout-page {
            padding: 40px 0;
            min-height: 70vh;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 450px;
            gap: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        /* Order Summary */
        .order-summary-section {
            background: white;
            padding: 30px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            height: fit-content;
        }

        .order-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .checkout-item {
            display: flex;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item-image {
            position: relative;
            width: 80px;
            height: 110px;
            flex-shrink: 0;
        }

        .checkout-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .checkout-item-placeholder {
            width: 100%;
            height: 100%;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-quantity-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 28px;
            height: 28px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .checkout-item-info {
            flex: 1;
        }

        .checkout-item-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .checkout-item-author {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .checkout-item-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-unit-price {
            font-size: 13px;
            color: #6b7280;
        }

        .item-subtotal {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
        }

        /* Order Total */
        .order-total-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .total-row:last-child {
            margin-bottom: 0;
        }

        .total-divider {
            height: 2px;
            background: #e5e7eb;
            margin: 15px 0;
        }

        .total-final {
            font-size: 18px;
            font-weight: 700;
        }

        .total-amount {
            font-size: 28px;
            color: #667eea;
        }

        /* Payment Section */
        .payment-section {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .info-box {
            display: flex;
            gap: 15px;
            padding: 20px;
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            border-radius: 10px;
        }

        .info-box svg {
            flex-shrink: 0;
        }

        .info-box h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e40af;
        }

        .info-box p {
            font-size: 14px;
            line-height: 1.6;
            color: #1e40af;
        }

        .customer-info-box {
            background: white;
            padding: 25px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
        }

        .customer-info-box h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .info-detail {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-detail:last-child {
            margin-bottom: 0;
        }

        .info-detail svg {
            flex-shrink: 0;
        }

        .info-detail label {
            display: block;
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .info-detail p {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }

        .terms-box {
            background: white;
            padding: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
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

        .checkbox-label span {
            font-size: 14px;
            color: #1f2937;
        }

        .checkout-actions {
            display: flex;
            gap: 15px;
        }

        .btn-back {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            color: #6b7280;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .btn-place-order {
            flex: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-place-order:hover {
            background: #5568d3;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @endpush
</x-app-layout>
