<x-app-layout>
    <div class="cart-page-new">
        <!-- Header with Gradient -->
        <x-HeaderGradient title="Keranjang" subtitle="Lihat semua buku yang ingin dicheckout">
        </x-HeaderGradient>

        <!-- Main Container -->
        <div class="cart-main-container">
            @if($cartItems->isEmpty())
                <!-- Empty Cart State -->
                <div class="cart-empty-state">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none">
                        <circle cx="60" cy="60" r="50" fill="#F3F4F6"/>
                        <path d="M45 50C45.5523 50 46 49.5523 46 49C46 48.4477 45.5523 48 45 48C44.4477 48 44 48.4477 44 49C44 49.5523 44.4477 50 45 50Z" stroke="#9CA3AF" stroke-width="3"/>
                        <path d="M75 50C75.5523 50 76 49.5523 76 49C76 48.4477 75.5523 48 75 48C74.4477 48 74 48.4477 74 49C74 49.5523 74.4477 50 75 50Z" stroke="#9CA3AF" stroke-width="3"/>
                        <path d="M35 35H50L57 75H85L92 50H60" stroke="#9CA3AF" stroke-width="3" stroke-linecap="round"/>
                        <circle cx="60" cy="85" r="5" fill="#9CA3AF"/>
                        <circle cx="80" cy="85" r="5" fill="#9CA3AF"/>
                    </svg>
                    <h2 class="cart-empty-title">Keranjang Anda Kosong</h2>
                    <p class="cart-empty-text">Belum ada buku yang ditambahkan ke keranjang</p>
                    <a href="{{ route('customer.books.index') }}" class="cart-btn-browse">
                        Jelajahi Buku
                    </a>
                </div>
            @else
                <div class="cart-wrapper">
                    <!-- Left Section: Cart Items -->
                    <div class="cart-wrapper-left">
                        <!-- Header: Select All & Delete -->
                        <div class="cart-list-header">
                            <div class="cart-select-all">
                                <input type="checkbox" id="selectAll" class="cart-checkbox">
                                <label for="selectAll">Semua</label>
                            </div>
                            <button class="cart-btn-delete-selected" onclick="deleteSelected()">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                                            <path d="M4 7H24M10 12V20M14 12V20M18 12V20M5 7L6 22C6 23.1046 6.89543 24 8 24H20C21.1046 24 22 23.1046 22 22L23 7M9 7V5C9 3.89543 9.89543 3 11 3H17C18.1046 3 19 3.89543 19 5V7" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                <span>Hapus</span>
                            </button>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-list-products">
                            @foreach($cartItems as $item)
                                <div class="cart-product-item" data-item-id="{{ $item->id }}">
                                    <div class="cart-product-wrapper">
                                        <!-- Checkbox -->
                                        <input type="checkbox" class="cart-checkbox cart-item-checkbox" data-item-id="{{ $item->id }}" data-price="{{ $item->book->price }}" data-quantity="{{ $item->quantity }}">

                                        <!-- Book Image -->
                                        <a href="{{ route('customer.books.show', $item->book->id) }}" class="cart-product-image">
                                            @if($item->book->cover)
                                                <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                            @else
                                                <div class="cart-product-placeholder">
                                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                                        <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                                        <path d="M40 5V15H50" stroke="#9CA3AF" stroke-width="2"/>
                                                        <path d="M18 25H42M18 32H42M18 39H35" stroke="#9CA3AF" stroke-width="2"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </a>

                                        <!-- Book Details -->
                                        <div class="cart-product-details">
                                            <!-- Category Badge -->
                                            <div class="cart-product-category">
                                                <p>{{ $item->book->category ?? 'Pengembangan Diri' }}</p>
                                            </div>

                                            <!-- Title -->
                                            <h3 class="cart-product-title">{{ Str::limit($item->book->title, 30) }}</h3>

                                            <!-- Author -->
                                            <p class="cart-product-author">{{ $item->book->author }}</p>

                                            <!-- Price -->
                                            <p class="cart-product-price">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>

                                            <!-- Quantity Controls -->
                                            <div class="cart-product-controls">
                                                <!-- Delete Icon -->
                                                <form method="POST" action="{{ route('customer.cart.destroy', $item->id) }}" class="cart-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cart-btn-trash" onclick="return confirm('Hapus buku ini dari keranjang?')">
                                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                                            <path d="M4 7H24M10 12V20M14 12V20M18 12V20M5 7L6 22C6 23.1046 6.89543 24 8 24H20C21.1046 24 22 23.1046 22 22L23 7M9 7V5C9 3.89543 9.89543 3 11 3H17C18.1046 3 19 3.89543 19 5V7" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Minus Button -->
                                                <form method="POST" action="{{ route('customer.cart.update', $item->id) }}" class="cart-qty-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                    <button type="submit" class="cart-btn-qty cart-btn-minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        −
                                                    </button>
                                                </form>

                                                <!-- Quantity Display -->
                                                <span class="cart-qty-display">{{ $item->quantity }}</span>

                                                <!-- Plus Button -->
                                                <form method="POST" action="{{ route('customer.cart.update', $item->id) }}" class="cart-qty-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ min($item->book->stock, $item->quantity + 1) }}">
                                                    <button type="submit" class="cart-btn-qty cart-btn-plus" {{ $item->quantity >= $item->book->stock ? 'disabled' : '' }}>
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(!$loop->last)
                                    <div class="cart-divider"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Section: Summary -->
                    <div class="cart-wrapper-right">
                        <div class="cart-summary-box">
                            <h2 class="cart-summary-title">Ringkasan Belanja</h2>

                            <!-- Summary Details -->
                            <div class="cart-summary-details">
                                <div class="cart-summary-row">
                                    <p class="cart-summary-label">Subtotal</p>
                                    <p class="cart-summary-value" id="summarySubtotal">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                </div>
                                <div class="cart-summary-row">
                                    <p class="cart-summary-label">Pajak 10%</p>
                                    <p class="cart-summary-value" id="summaryTax">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</p>
                                </div>
                                <div class="cart-summary-row">
                                    <p class="cart-summary-label">Ongkos Kirim</p>
                                    <p class="cart-summary-value">Gratis</p>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="cart-summary-divider"></div>

                            <!-- Total -->
                            <div class="cart-summary-total-row">
                                <p class="cart-summary-total-label">Total</p>
                                <p class="cart-summary-total-value" id="summaryTotal">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</p>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('customer.orders.create') }}" class="cart-btn-checkout">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Select All Checkbox
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSummary();
        });

        // Individual Checkbox Change
        document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        // Update Summary Based on Selected Items
        function updateSummary() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
            let subtotal = 0;

            checkboxes.forEach(checkbox => {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                subtotal += price * quantity;
            });

            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            // Update UI
            if (document.getElementById('summarySubtotal')) {
                document.getElementById('summarySubtotal').textContent = formatRupiah(subtotal);
                document.getElementById('summaryTax').textContent = formatRupiah(tax);
                document.getElementById('summaryTotal').textContent = formatRupiah(total);
            }
        }

        // Format to Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Delete Selected Items
        function deleteSelected() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Pilih item yang ingin dihapus');
                return;
            }

            if (confirm(`Hapus ${checkboxes.length} item dari keranjang?`)) {
                checkboxes.forEach(checkbox => {
                    const itemId = checkbox.dataset.itemId;
                    const form = document.querySelector(`[data-item-id="${itemId}"] .cart-delete-form`);
                    if (form) {
                        form.submit();
                    }
                });
            }
        }
    </script>
    @endpush
</x-app-layout>
