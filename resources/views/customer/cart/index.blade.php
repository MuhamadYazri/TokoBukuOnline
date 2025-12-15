<x-app-layout>
    <div class="cart-page-new">
        <x-HeaderGradient title="Keranjang" subtitle="Lihat semua buku yang ingin dicheckout">
        </x-HeaderGradient>

        <div class="cart-main-container">
            @if($cartItems->isEmpty())
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
                    <div class="cart-wrapper-left">
                        <!-- Bulk Action Bar -->
                        <div class="cart-bulk-bar" id="bulkActionBar">
                            <div class="cart-bulk-info">
                                <button type="button" class="cart-select-all-btn" id="selectAllBtn">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 11.17L1.83 7L0.410004 8.41L6 14L18 2L16.59 0.589996L6 11.17Z" fill="none"/>
                                    </svg>
                                </button>
                                <span class="cart-selected-count" id="selectedCount">0 dipilih</span>
                            </div>
                            <button type="button" class="cart-delete-btn" id="bulkDeleteBtn">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12C4 13.1 4.9 14 6 14H10C11.1 14 12 13.1 12 12V6C12 4.9 11.1 4 10 4H6C4.9 4 4 4.9 4 6V12ZM12 2H9.5L8.79 1.29C8.61 1.11 8.35 1 8.09 1H5.91C5.65 1 5.39 1.11 5.21 1.29L4.5 2H2C1.45 2 1 2.45 1 3C1 3.55 1.45 4 2 4H12C12.55 4 13 3.55 13 3C13 2.45 12.55 2 12 2Z" fill="white"/>
                                </svg>
                                Hapus
                            </button>
                        </div>

                        <div class="cart-list-products">
                            @foreach($cartItems as $item)
                                <div class="cart-product-item" data-item-id="{{ $item->id }}">
                                    <div class="cart-product-wrapper">
                                        <div class="cart-item-checkbox-wrapper">
                                            <input type="checkbox" class="cart-item-checkbox" id="cart-item-{{ $item->id }}" value="{{ $item->id }}" data-item-id="{{ $item->id }}" data-price="{{ $item->book->price }}" data-quantity="{{ $item->quantity }}">
                                            <label for="cart-item-{{ $item->id }}" class="checkbox-label-cart">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.5 8.3775L1.6225 5.5L0.5575 6.5575L4.5 10.5L11.5 3.5L10.4425 2.4425L4.5 8.3775Z" fill="white"/>
                                                </svg>
                                            </label>
                                        </div>

                                        <a href="{{ route('customer.books.show', $item->book->id) }}" class="cart-product-image">
                                            @if(Storage::exists('public/' . $item->book->cover))
                                                <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}">
                                            @else
                                                <img src="{{ asset( $item->book->cover) }}" alt="{{ $item->book->title }}">
                                            @endif
                                        </a>

                                        <div class="cart-product-details">
                                            <div class="cart-product-category">
                                                <p>{{ $item->book->category ?? 'Pengembangan Diri' }}</p>
                                            </div>

                                            <h3 class="cart-product-title">{{ Str::limit($item->book->title, 30) }}</h3>

                                            <p class="cart-product-author">{{ $item->book->author }}</p>

                                            <p class="cart-product-price">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>

                                            <div class="cart-product-controls">
                                                <form method="POST" action="{{ route('customer.cart.destroy', $item->id) }}" class="cart-delete-form" id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="cart-btn-trash" onclick="confirmDeleteCart({{ $item->id }}, '{{ Str::limit($item->book->title, 30) }}')">
                                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                                            <path d="M4 7H24M10 12V20M14 12V20M18 12V20M5 7L6 22C6 23.1046 6.89543 24 8 24H20C21.1046 24 22 23.1046 22 22L23 7M9 7V5C9 3.89543 9.89543 3 11 3H17C18.1046 3 19 3.89543 19 5V7" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('customer.cart.update', $item->id) }}" class="cart-qty-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}">
                                                    <button type="submit" class="cart-btn-qty cart-btn-minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        −
                                                    </button>
                                                </form>

                                                <span class="cart-qty-display">{{ $item->quantity }}</span>

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

                    <div class="cart-wrapper-right">
                        <div class="cart-summary-box">
                            <h2 class="cart-summary-title">Ringkasan Belanja</h2>

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

                            <div class="cart-summary-divider"></div>

                            <div class="cart-summary-total-row">
                                <p class="cart-summary-total-label">Total</p>
                                <p class="cart-summary-total-value" id="summaryTotal">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</p>
                            </div>

                            <button type="button" class="cart-btn-checkout" id="checkoutBtn">
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            const bulkActionBar = document.getElementById('bulkActionBar');
            const selectedCount = document.getElementById('selectedCount');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const checkoutBtn = document.getElementById('checkoutBtn');
            let allSelected = false;

            // Update Bulk Bar
            function updateBulkBar() {
                const checkedBoxes = document.querySelectorAll('.cart-item-checkbox:checked');
                const count = checkedBoxes.length;
                selectedCount.textContent = `${count} dipilih`;

                allSelected = count === checkboxes.length;

                if (allSelected) {
                    selectAllBtn.classList.add('active');
                } else {
                    selectAllBtn.classList.remove('active');
                }

                updateSummary();
            }

            // Individual Checkbox Change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkBar);
            });

            // Select All Button
            selectAllBtn.addEventListener('click', function() {
                allSelected = !allSelected;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = allSelected;
                });
                selectAllBtn.classList.toggle('active');
                updateBulkBar();
            });

            // Update Summary Based on Selected Items
            function updateSummary() {
                const checkedBoxes = document.querySelectorAll('.cart-item-checkbox:checked');
                let subtotal = 0;

                checkedBoxes.forEach(checkbox => {
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

            // Bulk Delete Selected Items
            bulkDeleteBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.cart-item-checkbox:checked');
                const cartIds = Array.from(checkedBoxes).map(cb => cb.value);

                if (cartIds.length === 0) {
                    alert('Pilih item yang ingin dihapus');
                    return;
                }

                if (confirm(`Apakah Anda yakin ingin menghapus ${cartIds.length} item dari keranjang?`)) {
                    fetch('/cart-bulk-delete', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            cart_ids: cartIds
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.message === 'success') {
                            location.reload();
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus item');
                    });
                }
            });

            // Checkout Selected Items
            checkoutBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.cart-item-checkbox:checked');
                const cartIds = Array.from(checkedBoxes).map(cb => cb.value);

                if (cartIds.length === 0) {
                    alert('Pilih item yang ingin di-checkout');
                    return;
                }

                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("customer.orders.create") }}';

                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfInput);

                // Add cart IDs
                cartIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'cart_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
            });
        });

        // SweetAlert2 Confirm Delete for Cart
        function confirmDeleteCart(itemId, bookTitle) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Hapus "${bookTitle}" dari keranjang?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + itemId).submit();
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
