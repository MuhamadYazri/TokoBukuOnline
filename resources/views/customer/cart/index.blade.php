<x-app-layout>
    <div class="cart-page">
        <div class="container">
            <h1 class="page-title">Keranjang Belanja</h1>

            @if($cartItems->isEmpty())
                <!-- Empty Cart State -->
                <div class="empty-cart">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                        <circle cx="100" cy="100" r="80" fill="#F3F4F6"/>
                        <path d="M70 80C70.5523 80 71 79.5523 71 79C71 78.4477 70.5523 78 70 78C69.4477 78 69 78.4477 69 79C69 79.5523 69.4477 80 70 80Z" stroke="#9CA3AF" stroke-width="4"/>
                        <path d="M130 80C130.552 80 131 79.5523 131 79C131 78.4477 130.552 78 130 78C129.448 78 129 78.4477 129 79C129 79.5523 129.448 80 130 80Z" stroke="#9CA3AF" stroke-width="4"/>
                        <path d="M60 60H80L90 120H150L160 80H100" stroke="#9CA3AF" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="95" cy="135" r="8" fill="#9CA3AF"/>
                        <circle cx="145" cy="135" r="8" fill="#9CA3AF"/>
                    </svg>
                    <h2>Keranjang Anda Kosong</h2>
                    <p>Belum ada buku yang ditambahkan ke keranjang</p>
                    <a href="{{ route('customer.books.index') }}" class="btn-browse">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M8 4L2 10L8 16M2 10H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Jelajahi Buku
                    </a>
                </div>
            @else
                <div class="cart-layout">
                    <!-- Cart Items -->
                    <div class="cart-items-section">
                        @foreach($cartItems as $item)
                            <div class="cart-item">
                                <!-- Book Cover -->
                                <div class="cart-item-image">
                                    <a href="{{ route('customer.books.show', $item->book->id) }}">
                                        @if($item->book->cover)
                                            <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                        @else
                                            <div class="cart-item-placeholder">
                                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                                    <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <!-- Book Info -->
                                <div class="cart-item-info">
                                    <h3 class="cart-item-title">
                                        <a href="{{ route('customer.books.show', $item->book->id) }}">{{ $item->book->title }}</a>
                                    </h3>
                                    <p class="cart-item-author">{{ $item->book->author }}</p>

                                    <!-- Stock Warning -->
                                    @if($item->book->stock < $item->quantity)
                                        <div class="stock-warning">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                                <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="#EF4444" stroke-width="2"/>
                                                <path d="M10 6V10M10 14H10.01" stroke="#EF4444" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            Stok hanya tersisa {{ $item->book->stock }}
                                        </div>
                                    @elseif($item->book->stock < 5)
                                        <div class="stock-warning stock-low">
                                            Stok terbatas: {{ $item->book->stock }}
                                        </div>
                                    @endif

                                    <div class="cart-item-price-mobile">
                                        Rp {{ number_format($item->book->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="cart-item-quantity">
                                    <form method="POST" action="{{ route('customer.cart.update', $item->id) }}" class="quantity-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="quantity-controls-cart">
                                            <button type="button" class="qty-btn-cart" onclick="updateCartQty({{ $item->id }}, 'decrease', {{ $item->quantity }}, {{ $item->book->stock }})">−</button>
                                            <input type="number" id="qty-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}" class="qty-input-cart" readonly>
                                            <button type="button" class="qty-btn-cart" onclick="updateCartQty({{ $item->id }}, 'increase', {{ $item->quantity }}, {{ $item->book->stock }})">+</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Price -->
                                <div class="cart-item-price">
                                    Rp {{ number_format($item->book->price, 0, ',', '.') }}
                                </div>

                                <!-- Subtotal -->
                                <div class="cart-item-subtotal">
                                    Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}
                                </div>

                                <!-- Remove Button -->
                                <div class="cart-item-remove">
                                    <form method="POST" action="{{ route('customer.cart.destroy', $item->id) }}" onsubmit="return confirm('Hapus buku ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M3 5H17M8 9V15M12 9V15M4 5L5 17C5 18.1046 5.89543 19 7 19H13C14.1046 19 15 18.1046 15 17L16 5M7 5V3C7 1.89543 7.89543 1 9 1H11C12.1046 1 13 1.89543 13 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart Button -->
                        <div class="cart-actions">
                            <form method="POST" action="{{ route('customer.cart.clear') }}" onsubmit="return confirm('Kosongkan seluruh keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-clear-cart">
                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                        <path d="M3 5H17M8 9V15M12 9V15M4 5L5 17C5 18.1046 5.89543 19 7 19H13C14.1046 19 15 18.1046 15 17L16 5M7 5V3C7 1.89543 7.89543 1 9 1H11C12.1046 1 13 1.89543 13 3V5" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                    Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <h2 class="summary-title">Ringkasan Belanja</h2>

                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Total Item</span>
                                <span class="summary-value">{{ $cartItems->sum('quantity') }} buku</span>
                            </div>

                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row summary-total">
                                <span>Total Pembayaran</span>
                                <span class="summary-total-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('customer.orders.create') }}" class="btn-checkout">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5 10H15M15 10L12 7M15 10L12 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Lanjut ke Pembayaran
                        </a>

                        <a href="{{ route('customer.books.index') }}" class="btn-continue-shopping">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .cart-page {
            padding: 40px 0;
            min-height: 70vh;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-cart h2 {
            font-size: 28px;
            font-weight: 700;
            margin: 30px 0 15px;
            color: #1f2937;
        }

        .empty-cart p {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .btn-browse {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-browse:hover {
            background: #5568d3;
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 40px;
        }

        /* Cart Items */
        .cart-items-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr 150px 120px 120px 50px;
            gap: 20px;
            align-items: center;
            padding: 20px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
        }

        .cart-item-image {
            width: 120px;
            height: 160px;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-placeholder {
            width: 100%;
            height: 100%;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cart-item-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .cart-item-title a {
            color: #1f2937;
            text-decoration: none;
        }

        .cart-item-title a:hover {
            color: #667eea;
        }

        .cart-item-author {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .stock-warning {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #ef4444;
            font-weight: 600;
        }

        .stock-warning.stock-low {
            color: #f59e0b;
        }

        .cart-item-price-mobile {
            display: none;
        }

        .quantity-controls-cart {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn-cart {
            width: 32px;
            height: 32px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn-cart:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .qty-input-cart {
            width: 50px;
            height: 32px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
        }

        .cart-item-price,
        .cart-item-subtotal {
            font-weight: 600;
            color: #1f2937;
        }

        .cart-item-subtotal {
            font-size: 18px;
            color: #667eea;
        }

        .btn-remove {
            width: 40px;
            height: 40px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }

        .btn-remove:hover {
            background: #fef2f2;
            border-color: #ef4444;
        }

        /* Cart Actions */
        .cart-actions {
            display: flex;
            justify-content: flex-end;
        }

        .btn-clear-cart {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            color: #6b7280;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-clear-cart:hover {
            border-color: #ef4444;
            color: #ef4444;
        }

        /* Cart Summary */
        .cart-summary {
            position: sticky;
            top: 20px;
            height: fit-content;
            padding: 30px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
        }

        .summary-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .summary-details {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-value {
            font-weight: 600;
            color: #1f2937;
        }

        .summary-divider {
            height: 2px;
            background: #e5e7eb;
            margin: 10px 0;
        }

        .summary-total {
            font-size: 18px;
            font-weight: 700;
        }

        .summary-total-value {
            font-size: 24px;
            color: #667eea;
        }

        .btn-checkout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 16px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            margin: 25px 0 15px;
        }

        .btn-checkout:hover {
            background: #5568d3;
        }

        .btn-continue-shopping {
            display: block;
            width: 100%;
            padding: 12px;
            background: #f3f4f6;
            color: #1f2937;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-continue-shopping:hover {
            background: #e5e7eb;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                grid-template-rows: auto auto auto;
                gap: 15px;
            }

            .cart-item-image {
                width: 80px;
                height: 110px;
                grid-row: 1 / 3;
            }

            .cart-item-info {
                grid-column: 2;
            }

            .cart-item-price,
            .cart-item-subtotal {
                display: none;
            }

            .cart-item-price-mobile {
                display: block;
                font-weight: 600;
                color: #667eea;
            }

            .cart-item-quantity {
                grid-column: 1 / 3;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cart-item-remove {
                position: absolute;
                top: 15px;
                right: 15px;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function updateCartQty(cartId, action, currentQty, maxStock) {
            const input = document.getElementById('qty-' + cartId);
            let newQty = parseInt(currentQty);

            if (action === 'decrease' && newQty > 1) {
                newQty--;
            } else if (action === 'increase' && newQty < maxStock) {
                newQty++;
            } else {
                return;
            }

            input.value = newQty;

            // Submit form via AJAX
            const form = input.closest('form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                location.reload();
            });
        }
    </script>
    @endpush
</x-app-layout>
