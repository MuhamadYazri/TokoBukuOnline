<x-admin-layout>
    <x-HeaderGradient title="Kelola Pesanan" subtitle="Pantau dan kelola semua pesanan">
    </x-HeaderGradient>

    <div class="orders-page">
        <!-- Stats Cards -->
        <div class="orders-stats-grid">
            <div class="orders-stat-card orders-stat-card-orange">
                <p class="orders-stat-label">Menunggu</p>
                <p class="orders-stat-value">{{ $pendingCount }}</p>
            </div>
            <div class="orders-stat-card orders-stat-card-blue">
                <p class="orders-stat-label">Diproses</p>
                <p class="orders-stat-value">{{ $processingCount }}</p>
            </div>
            <div class="orders-stat-card orders-stat-card-purple">
                <p class="orders-stat-label">Dikirim</p>
                <p class="orders-stat-value">{{ $shippedCount }}</p>
            </div>
            <div class="orders-stat-card orders-stat-card-green">
                <p class="orders-stat-label">Selesai</p>
                <p class="orders-stat-value">{{ number_format($completedCount) }}</p>
            </div>
            <div class="orders-stat-card orders-stat-card-red">
                <p class="orders-stat-label">Dibatalkan</p>
                <p class="orders-stat-value">{{ $cancelledCount }}</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="orders-search-filter">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-search-form">
                <svg class="orders-search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M16.5 16.5L12.875 12.875M14.8333 8.16667C14.8333 11.8486 11.8486 14.8333 8.16667 14.8333C4.48477 14.8333 1.5 11.8486 1.5 8.16667C1.5 4.48477 4.48477 1.5 8.16667 1.5C11.8486 1.5 14.8333 4.48477 14.8333 8.16667Z" stroke="rgba(10,10,10,0.5)" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" name="search" class="orders-search-input" placeholder="Cari order ID atau nama pelanggan..." value="{{ request('search') }}">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('start_date'))
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                @endif
                @if(request('end_date'))
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                @endif
            </form>

            <div class="orders-filter-wrapper">
                <form action="{{ route('admin.orders.index') }}" method="GET" id="statusFilterForm">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('start_date'))
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    @endif
                    @if(request('end_date'))
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    @endif
                    <div class="orders-filter-select-wrapper">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" class="orders-filter-icon">
                            <path d="M2.25 4.5H15.75M4.5 9H13.5M6.75 13.5H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <select name="status" class="orders-filter-select" onchange="document.getElementById('statusFilterForm').submit()">
                            @php
                                $activeStatus = request('status', 'all');
                            @endphp
                            <option value="all" {{ $activeStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ $activeStatus === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="processing" {{ $activeStatus === 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ $activeStatus === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ $activeStatus === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $activeStatus === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="orders-filter-chevron">
                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </form>
            </div>

            <form action="{{ route('admin.orders.index') }}" method="GET" class="orders-date-filter">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="orders-date-inputs">
                    <div class="orders-date-input-wrapper">
                        <label for="start_date" class="orders-date-label">Dari</label>
                        <input type="date" name="start_date" id="start_date" class="orders-date-input" value="{{ request('start_date') }}">
                    </div>
                    <div class="orders-date-input-wrapper">
                        <label for="end_date" class="orders-date-label">Sampai</label>
                        <input type="date" name="end_date" id="end_date" class="orders-date-input" value="{{ request('end_date') }}">
                    </div>
                </div>
                <button type="submit" class="orders-date-submit-btn">Filter</button>
                @if(request('start_date') || request('end_date'))
                    <a href="{{ route('admin.orders.index', ['search' => request('search'), 'status' => request('status')]) }}" class="orders-date-clear-btn">Reset</a>
                @endif
            </form>
        </div>

        <!-- Orders Cards Grid -->
        <div class="orders-cards-grid">
            @forelse($orders as $order)
                <div class="orders-card-new">
                    <!-- Header with Order ID and Status -->
                    <div class="orders-card-header-new">
                        <div class="orders-card-id-section">
                            <p class="orders-card-id">{{ $order->order_number }}</p>
                            <p class="orders-card-customer-name">{{ $order->user->name ?? 'Unknown' }}</p>
                        </div>
                        @php
                            $statusConfig = [
                                'pending' => ['class' => 'pending', 'label' => 'Menunggu', 'bg' => '#FFF4E6', 'color' => '#FF8800'],
                                'processing' => ['class' => 'processing', 'label' => 'Diproses', 'bg' => '#E6F4FF', 'color' => '#0088FF'],
                                'shipped' => ['class' => 'shipped', 'label' => 'Dikirim', 'bg' => '#F3E6FF', 'color' => '#6600FF'],
                                'completed' => ['class' => 'completed', 'label' => 'Selesai', 'bg' => '#E6F7E6', 'color' => '#08910A'],
                                'cancelled' => ['class' => 'cancelled', 'label' => 'Dibatalkan', 'bg' => '#FEE2E2', 'color' => '#DC2626'],
                            ];
                            $status = $statusConfig[$order->status] ?? ['class' => 'pending', 'label' => 'Menunggu', 'bg' => '#FFF4E6', 'color' => '#FF8800'];
                        @endphp
                        <div class="orders-status-badge orders-status-{{ $status['class'] }}" style="background-color: {{ $status['bg'] }}">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <circle cx="7" cy="7" r="5" fill="{{ $status['color'] }}"/>
                            </svg>
                            <p style="color: {{ $status['color'] }}">{{ $status['label'] }}</p>
                        </div>
                    </div>

                    <!-- Order Items Section -->
                    <div class="orders-info-section">
                        <p class="orders-items-label">Item Pesanan:</p>
                        @if($order->orderDetails && $order->orderDetails->count() > 0)
                            @foreach($order->orderDetails->take(2) as $detail)
                                <div class="orders-item-row">
                                    <div class="orders-item-name">
                                        <span>{{ $detail->book->title ?? 'Book' }}</span>
                                        <span class="orders-item-qty">x{{ $detail->quantity }}</span>
                                    </div>
                                    <p class="orders-item-price">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="orders-item-row">
                                <div class="orders-item-name">
                                    <span>{{ $order->book->title ?? 'Book' }}</span>
                                    <span class="orders-item-qty">x{{ $order->total_quantity }}</span>
                                </div>
                                <p class="orders-item-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Address Section -->
                    <div class="orders-address-section">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M14 6.66667C14 11.3333 8 15.3333 8 15.3333C8 15.3333 2 11.3333 2 6.66667C2 5.07536 2.63214 3.54925 3.75736 2.42403C4.88258 1.29881 6.40869 0.666672 8 0.666672C9.59131 0.666672 11.1174 1.29881 12.2426 2.42403C13.3679 3.54925 14 5.07536 14 6.66667Z" stroke="#4d4d4d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 8.66667C9.10457 8.66667 10 7.77124 10 6.66667C10 5.5621 9.10457 4.66667 8 4.66667C6.89543 4.66667 6 5.5621 6 6.66667C6 7.77124 6.89543 8.66667 8 8.66667Z" stroke="#4d4d4d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="orders-address-text">{{ $order->user->address ?? 'Jl. Sudirman No. 123, Jakarta' }}</p>
                    </div>

                    <!-- Total & Action Section -->
                    <div class="orders-total-section">
                        <div class="orders-total-info">
                            <p class="orders-total-label">Total Pembayaran</p>
                            <p class="orders-total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="orders-action-dropdown">
                            <button type="button" class="orders-action-btn" onclick="toggleOrderAction({{ $order->id }})">
                                <span>{{ $status['label'] }}</span>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div class="orders-action-dropdown-menu" id="action-menu-{{ $order->id }}">
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="pending" class="orders-action-option">Menunggu</button>
                                    <button type="submit" name="status" value="processing" class="orders-action-option">Diproses</button>
                                    <button type="submit" name="status" value="shipped" class="orders-action-option">Dikirim</button>
                                    <button type="submit" name="status" value="completed" class="orders-action-option">Selesai</button>
                                    <button type="submit" name="status" value="cancelled" class="orders-action-option">Dibatalkan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <p class="orders-card-date">Tanggal: {{ $order->created_at->format('Y-m-d') }}</p>
                </div>
            @empty
                <div class="orders-empty-state">
                    <p>Belum ada pesanan ditemukan</p>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.orders.index') }}" class="orders-reset-btn">Reset Filter</a>
                    @endif
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="orders-pagination">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

    @push('scripts')
        <script>
    function toggleOrderAction(orderId) {
        const menu = document.getElementById('action-menu-' + orderId);
        const allMenus = document.querySelectorAll('.orders-action-dropdown-menu');

        allMenus.forEach(m => {
            if (m.id !== 'action-menu-' + orderId) {
                m.classList.remove('show');
            }
        });

        menu.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    window.onclick = function(event) {
        if (!event.target.closest('.orders-action-dropdown')) {
            const allMenus = document.querySelectorAll('.orders-action-dropdown-menu');
            allMenus.forEach(m => m.classList.remove('show'));
        }
    }
    </script>
    @endpush

</x-admin-layout>
