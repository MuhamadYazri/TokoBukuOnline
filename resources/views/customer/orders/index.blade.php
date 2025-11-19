<x-app-layout>
    <div class="orders-page">
        <div class="container">
            <h1 class="page-title">Riwayat Pesanan</h1>

            @if($orders->isEmpty())
                <!-- Empty Orders State -->
                <div class="empty-orders">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                        <circle cx="100" cy="100" r="80" fill="#F3F4F6"/>
                        <path d="M70 70H130M70 90H130M70 110H110" stroke="#9CA3AF" stroke-width="4" stroke-linecap="round"/>
                        <rect x="60" y="60" width="80" height="80" rx="5" stroke="#9CA3AF" stroke-width="4"/>
                    </svg>
                    <h2>Belum Ada Pesanan</h2>
                    <p>Anda belum pernah melakukan pemesanan</p>
                    <a href="{{ route('customer.books.index') }}" class="btn-browse">
                        Jelajahi Buku
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="order-card">
                            <!-- Order Header -->
                            <div class="order-header">
                                <div class="order-info">
                                    <div class="order-number">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M4 4H16V16H4V4Z" stroke="#667eea" stroke-width="2"/>
                                            <path d="M8 2V6M12 2V6M2 8H18" stroke="#667eea" stroke-width="2"/>
                                        </svg>
                                        <span>{{ $order->order_number }}</span>
                                    </div>
                                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="order-status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </div>
                            </div>

                            <!-- Order Body -->
                            <div class="order-body">
                                <div class="order-book-info">
                                    @if($order->book->cover)
                                        <img src="{{ asset('storage/' . $order->book->cover) }}" alt="{{ $order->book->title }}">
                                    @else
                                        <div class="order-book-placeholder">
                                            <svg width="40" height="40" viewBox="0 0 60 60" fill="none">
                                                <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3>{{ $order->book->title }}</h3>
                                        <p class="book-author">{{ $order->book->author }}</p>
                                        <p class="book-qty">Jumlah: {{ $order->total_quantity }} buku</p>
                                    </div>
                                </div>

                                <div class="order-total">
                                    <span class="total-label">Total:</span>
                                    <span class="total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Order Footer -->
                            <div class="order-footer">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="btn-detail-order">
                                    Lihat Detail
                                </a>
                                @if($order->status === 'pending')
                                    <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-cancel-order">
                                            Batalkan Pesanan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .orders-page {
            padding: 40px 0;
            min-height: 70vh;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        /* Empty Orders */
        .empty-orders {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-orders h2 {
            font-size: 28px;
            font-weight: 700;
            margin: 30px 0 15px;
            color: #1f2937;
        }

        .empty-orders p {
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

        /* Orders List */
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
        }

        .order-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .order-number {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .order-date {
            font-size: 13px;
            color: #6b7280;
        }

        .order-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .order-book-info {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .order-book-info img {
            width: 60px;
            height: 85px;
            object-fit: cover;
            border-radius: 6px;
        }

        .order-book-placeholder {
            width: 60px;
            height: 85px;
            background: #f3f4f6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order-book-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .book-author {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .book-qty {
            font-size: 13px;
            color: #6b7280;
        }

        .order-total {
            text-align: right;
        }

        .total-label {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
        }

        .order-footer {
            display: flex;
            gap: 10px;
            padding: 15px 20px;
            background: #f9fafb;
            border-top: 2px solid #e5e7eb;
        }

        .btn-detail-order {
            flex: 1;
            padding: 10px;
            text-align: center;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-detail-order:hover {
            background: #5568d3;
        }

        .btn-cancel-order {
            flex: 1;
            padding: 10px;
            background: white;
            color: #ef4444;
            border: 2px solid #ef4444;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cancel-order:hover {
            background: #fef2f2;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .order-body {
                flex-direction: column;
                gap: 20px;
            }

            .order-total {
                width: 100%;
                text-align: left;
                padding-top: 15px;
                border-top: 1px solid #e5e7eb;
            }
        }
    </style>
    @endpush
</x-app-layout>
