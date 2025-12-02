<x-app-layout>
    <div class="checkout-page-new">
        <!-- Gradient Header -->
        <x-HeaderGradient title="Checkout" subtitle="Lengkapi informasi tambahan pelanggan">
        </x-HeaderGradient>

        <!-- Main Content -->
        <div class="checkout-main-container">
            <form method="POST" action="{{ route('customer.orders.store') }}" id="checkoutForm" class="checkout-grid">
                @csrf

                <!-- Left Column -->
                <div class="checkout-left-column">
                    <!-- Address Section -->
                    <section class="checkout-section">
                        <div class="checkout-section-header">
                            <h2 class="checkout-section-title">Alamat Pengiriman</h2>
                            <span class="checkout-section-helper">Pilih alamat tujuan pesanan</span>
                        </div>

                        <div class="checkout-address-list">
                            <!-- Rumah -->
                            <label class="checkout-address-card checkout-address-selected">
                                <div class="checkout-address-header">
                                    <input type="radio" name="shipping_address" value="home" class="checkout-radio" checked>
                                    <div class="checkout-address-title-group">
                                        <span class="checkout-address-name">Rumah</span>
                                        <span class="checkout-address-badge">Utama</span>
                                    </div>
                                </div>
                                <div class="checkout-address-body">
                                    <p class="checkout-address-recipient">{{ auth()->user()->name }}</p>
                                    <p class="checkout-address-phone">+62 812-3456-7890</p>
                                    <p class="checkout-address-detail">
                                        Jl. Mawar No. 123, Kelurahan Sukamaju<br>
                                        Kecamatan Bandung Barat, Kota Bandung<br>
                                        Jawa Barat 40123
                                    </p>
                                </div>
                            </label>

                            <!-- Kantor -->
                            <label class="checkout-address-card">
                                <div class="checkout-address-header">
                                    <input type="radio" name="shipping_address" value="office" class="checkout-radio">
                                    <div class="checkout-address-title-group">
                                        <span class="checkout-address-name">Kantor</span>
                                    </div>
                                </div>
                                <div class="checkout-address-body">
                                    <p class="checkout-address-recipient">{{ auth()->user()->name }}</p>
                                    <p class="checkout-address-phone">+62 812-3456-7890</p>
                                    <p class="checkout-address-detail">
                                        Gedung Plaza Indonesia, Lantai 5<br>
                                        Jl. MH Thamrin No. 28-30<br>
                                        Jakarta Pusat, DKI Jakarta 10350
                                    </p>
                                </div>
                            </label>

                            <button type="button" class="checkout-add-address-btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M10 4V16M4 10H16" stroke="#0088FF" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Tambah Alamat Baru
                            </button>
                        </div>
                    </section>

                    <!-- Products Section -->
                    <section class="checkout-section">
                        <div class="checkout-section-header">
                            <h2 class="checkout-section-title">Produk</h2>
                            <span class="checkout-section-helper">Periksa kembali buku yang akan dibeli</span>
                        </div>

                        <div class="checkout-products-list">
                            @foreach($cartItems as $item)
                                <div class="checkout-product-item">
                                    <div class="checkout-product-image">
                                        @if($item->book->cover)
                                            <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                        @else
                                            <div class="checkout-product-placeholder">
                                                <svg width="36" height="36" viewBox="0 0 60 60" fill="none" aria-hidden="true">
                                                    <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="checkout-product-details">
                                        <span class="checkout-product-category">{{ $item->book->category ?? 'Buku' }}</span>
                                        <h3 class="checkout-product-title">{{ $item->book->title }}</h3>
                                        <p class="checkout-product-author">{{ $item->book->author }}</p>
                                        <div class="checkout-product-bottom">
                                            <span class="checkout-product-price">Rp {{ number_format($item->book->price, 0, ',', '.') }}</span>
                                            <span class="checkout-product-qty">Qty {{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Payment Section -->
                    <section class="checkout-section">
                        <div class="checkout-section-header">
                            <h2 class="checkout-section-title">Metode Pembayaran</h2>
                            <span class="checkout-section-helper">Pilih metode yang ingin digunakan</span>
                        </div>

                        <div class="checkout-payment-list">
                            <label class="checkout-payment-option">
                                <input type="radio" name="payment_method" value="credit_card" class="checkout-radio">
                                <div class="checkout-payment-content">
                                    <div class="checkout-payment-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <rect x="2" y="5" width="20" height="14" rx="2" stroke="#0088FF" stroke-width="2"/>
                                            <path d="M2 9H22" stroke="#0088FF" stroke-width="2"/>
                                            <rect x="5" y="13" width="6" height="2" fill="#0088FF"/>
                                        </svg>
                                    </div>
                                    <div class="checkout-payment-info">
                                        <span class="checkout-payment-name">Kartu Kredit/Debit</span>
                                        <span class="checkout-payment-desc">Visa, Mastercard, JCB</span>
                                    </div>
                                </div>
                            </label>

                            <label class="checkout-payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer" class="checkout-radio">
                                <div class="checkout-payment-content">
                                    <div class="checkout-payment-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M3 9L12 3L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z" stroke="#0088FF" stroke-width="2"/>
                                            <path d="M9 21V13H15V21" stroke="#0088FF" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <div class="checkout-payment-info">
                                        <span class="checkout-payment-name">Transfer Bank</span>
                                        <span class="checkout-payment-desc">BCA, Mandiri, BNI, BRI</span>
                                    </div>
                                </div>
                            </label>

                            <label class="checkout-payment-option">
                                <input type="radio" name="payment_method" value="e_wallet" class="checkout-radio">
                                <div class="checkout-payment-content">
                                    <div class="checkout-payment-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M21 8V16C21 18.2091 19.2091 20 17 20H7C4.79086 20 3 18.2091 3 16V8C3 5.79086 4.79086 4 7 4H17C19.2091 4 21 5.79086 21 8Z" stroke="#0088FF" stroke-width="2"/>
                                            <circle cx="12" cy="12" r="3" stroke="#0088FF" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <div class="checkout-payment-info">
                                        <span class="checkout-payment-name">E-Wallet</span>
                                        <span class="checkout-payment-desc">GoPay, OVO, DANA, ShopeePay</span>
                                    </div>
                                </div>
                            </label>

                            <label class="checkout-payment-option checkout-payment-selected">
                                <input type="radio" name="payment_method" value="cash" class="checkout-radio" checked>
                                <div class="checkout-payment-content">
                                    <div class="checkout-payment-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9" stroke="#0088FF" stroke-width="2"/>
                                            <path d="M12 6V12L16 14" stroke="#0088FF" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div class="checkout-payment-info">
                                        <span class="checkout-payment-name">Tunai</span>
                                        <span class="checkout-payment-desc">Bayar di tempat (COD)</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </section>
                </div>

                <!-- Right Column -->
                <aside class="checkout-right-column">
                    <div class="checkout-summary-box">
                        <h3 class="checkout-summary-title">Detail Pembayaran</h3>

                        <div class="checkout-summary-content">
                            <div class="checkout-summary-row">
                                <span class="checkout-summary-label">Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                                <span class="checkout-summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="checkout-summary-row">
                                <span class="checkout-summary-label">Pajak 10%</span>
                                <span class="checkout-summary-value">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="checkout-summary-row">
                                <span class="checkout-summary-label">Ongkos Kirim</span>
                                <span class="checkout-summary-value checkout-summary-free">Gratis</span>
                            </div>
                            <div class="checkout-summary-divider"></div>
                            <div class="checkout-summary-row checkout-summary-total">
                                <span class="checkout-summary-label">Total Pembayaran</span>
                                <span class="checkout-summary-value">Rp {{ number_format($total + ($total * 0.1), 0, ',', '.') }}</span>
                            </div>
                        </div>


                        <button type="submit" class="checkout-btn-submit">Bayar Sekarang</button>

                        <a href="{{ route('customer.cart.index') }}" class="checkout-btn-secondary">Kembali ke Keranjang</a>
                        <p class="checkout-security-note">Transaksi aman dan terenkripsi</p>
                    </div>
                </aside>
            </form>
        </div>
    </div>
</x-app-layout>
