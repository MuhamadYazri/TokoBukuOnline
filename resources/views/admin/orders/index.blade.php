<x-admin-layout>
    <div class="orders-page">
        <x-header-gradient title="Kelola Pesanan" subtitle="Pantau dan kelola seluruh pesanan pelanggan" />

        <div class="orders-controls">
            <div class="orders-controls-inner">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-search">
                    <svg class="orders-search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input type="text" name="search" class="orders-search-input" placeholder="Cari nomor pesanan atau nama pelanggan..." value="{{ request('search') }}">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>

                <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-filter">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="status" class="orders-filter-select" onchange="this.form.submit()">
                        @php($activeStatus = request('status', 'all'))
                        <option value="all" {{ $activeStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $activeStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $activeStatus === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $activeStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $activeStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="orders-content">
            @if($orders->count())
                <div class="orders-table-wrap">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th class="orders-th">
                                    <input type="checkbox" class="orders-checkbox" aria-label="Pilih semua pesanan">
                                </th>
                                <th class="orders-th">Nomor Pesanan</th>
                                <th class="orders-th">Pelanggan</th>
                                <th class="orders-th">Buku</th>
                                <th class="orders-th orders-th-center">Jumlah</th>
                                <th class="orders-th orders-th-right">Total</th>
                                <th class="orders-th orders-th-center">Status</th>
                                <th class="orders-th">Tanggal</th>
                                <th class="orders-th orders-th-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="orders-tr">
                                <td class="orders-td">
                                    <input type="checkbox" class="orders-checkbox" aria-label="Pilih pesanan {{ $order->order_number }}">
                                </td>
                                <td class="orders-td">
                                    <span class="orders-number">#{{ $order->order_number }}</span>
                                </td>
                                <td class="orders-td">
                                    <div class="orders-customer">
                                        <div class="orders-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                                        <div class="orders-customer-info">
                                            <span class="orders-customer-name">{{ $order->user->name ?? 'Unknown' }}</span>
                                            <span class="orders-customer-email">{{ $order->user->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="orders-td">
                                    <span class="orders-book" title="{{ $order->book->title ?? 'Tidak tersedia' }}">{{ $order->book->title ?? 'Tidak tersedia' }}</span>
                                </td>
                                <td class="orders-td orders-td-center">
                                    <span class="orders-qty">{{ $order->total_quantity }}</span>
                                </td>
                                <td class="orders-td orders-td-right">
                                    <span class="orders-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="orders-td orders-td-center">
                                    <span class="orders-status orders-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="orders-td">
                                    <span class="orders-date">{{ $order->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="orders-td orders-td-center">
                                    <div class="orders-actions">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="orders-btn" title="Lihat detail">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M0.75 9C0.75 9 3.75 3 9 3C14.25 3 17.25 9 17.25 9C17.25 9 14.25 15 9 15C3.75 15 0.75 9 0.75 9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <button type="button" class="orders-btn" title="Perbarui status" onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M8.25 3H3C2.60218 3 2.22064 3.15804 1.93934 3.43934C1.65804 3.72064 1.5 4.10218 1.5 4.5V15C1.5 15.3978 1.65804 15.7794 1.93934 16.0607C2.22064 16.342 2.60218 16.5 3 16.5H13.5C13.8978 16.5 14.2794 16.342 14.5607 16.0607C14.842 15.7794 15 15.3978 15 15V9.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.875 1.875C14.1734 1.57663 14.5777 1.40922 15 1.40922C15.4223 1.40922 15.8266 1.57663 16.125 1.875C16.4234 2.17337 16.5908 2.57768 16.5908 3C16.5908 3.42232 16.4234 3.82663 16.125 4.125L9 11.25L6 12L6.75 9L13.875 1.875Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="orders-cards">
                    @foreach($orders as $order)
                    <div class="orders-card">
                        <div class="orders-card-header">
                            <div class="orders-card-top">
                                <span class="orders-number">#{{ $order->order_number }}</span>
                                <span class="orders-status orders-status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="orders-card-customer">
                                <div class="orders-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                                <div>
                                    <p class="orders-card-name">{{ $order->user->name ?? 'Unknown' }}</p>
                                    <p class="orders-card-email">{{ $order->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="orders-card-body">
                            <div class="orders-card-row">
                                <span class="orders-card-label">Buku</span>
                                <span class="orders-book">{{ $order->book->title ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="orders-card-row">
                                <span class="orders-card-label">Jumlah</span>
                                <span class="orders-qty">{{ $order->total_quantity }}</span>
                            </div>
                            <div class="orders-card-row">
                                <span class="orders-card-label">Total</span>
                                <span class="orders-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="orders-card-row">
                                <span class="orders-card-label">Tanggal</span>
                                <span class="orders-date">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="orders-card-footer">
                            <a href="{{ route('admin.orders.show', $order) }}" class="orders-card-btn">Lihat Detail</a>
                            <button type="button" class="orders-card-btn orders-card-btn-primary" onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')">Update Status</button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="orders-pagination">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="orders-empty">
                    <svg class="orders-empty-icon" width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <path d="M32 56C45.2548 56 56 45.2548 56 32C56 18.7452 45.2548 8 32 8C18.7452 8 8 18.7452 8 32C8 45.2548 18.7452 56 32 56Z" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M32 40V32" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M32 24H32.02" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="orders-empty-text">Belum ada pesanan yang sesuai</p>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.orders.index') }}" class="orders-empty-btn">Reset Filter</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div id="statusModal" class="orders-modal" style="display: none;">
        <div class="orders-modal-overlay" onclick="closeStatusModal()"></div>
        <div class="orders-modal-content" role="dialog" aria-modal="true" aria-labelledby="ordersModalTitle">
            <div class="orders-modal-header">
                <h3 id="ordersModalTitle" class="orders-modal-title">Update Status Pesanan</h3>
                <button type="button" class="orders-modal-close" onclick="closeStatusModal()" aria-label="Tutup modal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <form id="statusForm" method="POST" class="orders-modal-body">
                @csrf
                @method('PATCH')
                <div class="orders-modal-field">
                    <label for="ordersStatusSelect" class="orders-modal-label">Status Pesanan</label>
                    <select name="status" id="ordersStatusSelect" class="orders-modal-select">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="orders-modal-actions">
                    <button type="button" class="orders-modal-btn orders-modal-btn-secondary" onclick="closeStatusModal()">Batal</button>
                    <button type="submit" class="orders-modal-btn orders-modal-btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(orderId, currentStatus) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');
            const select = document.getElementById('ordersStatusSelect');

            form.action = `/admin/orders/${orderId}/status`;
            select.value = currentStatus;
            modal.style.display = 'flex';
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.style.display = 'none';
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeStatusModal();
            }
        });
    </script>
</x-admin-layout>
