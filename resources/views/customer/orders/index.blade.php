<x-app-layout>
    <x-HeaderGradient title="Dashboard Pengguna" subtitle="Lihat semua informasi mengenai Anda">
    </x-HeaderGradient>

    <div class="profile-container">
        <!-- Navigation Card -->
        <div class="profile-nav-card">
            <!-- User Info Section -->
            <div class="profile-user-info">
                <div class="profile-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                        <path d="M11.4783 11.4783C14.6491 11.4783 17.2174 8.91 17.2174 5.73913C17.2174 2.56826 14.6491 0 11.4783 0C8.30739 0 5.73913 2.56826 5.73913 5.73913C5.73913 8.91 8.30739 11.4783 11.4783 11.4783ZM11.4783 14.3478C7.64739 14.3478 0 16.2704 0 20.087V22.9565H22.9565V20.087C22.9565 16.2704 15.3091 14.3478 11.4783 14.3478Z" fill="white"/>
                    </svg>
                </div>
                <h2 class="profile-user-name">{{ Auth::user()->name }}</h2>
                <p class="profile-user-email">{{ Auth::user()->email }}</p>
            </div>

            <!-- Navigation Menu -->
            <div class="profile-nav-menu">
                <a href="{{ route('customer.profile.edit') }}" class="profile-nav-item">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 8C10.21 8 12 6.21 12 4C12 1.79 10.21 0 8 0C5.79 0 4 1.79 4 4C4 6.21 5.79 8 8 8ZM8 10C5.33 10 0 11.34 0 14V16H16V14C16 11.34 10.67 10 8 10Z" fill="#4D4D4D"/>
                    </svg>
                    <span>Profil</span>
                </a>
                <a href="{{ route('customer.orders.index') }}" class="profile-nav-item profile-nav-item-active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                        <path d="M7.2 2.44459H0V4.03716H7.2V2.44459ZM7.2 8.81486H0V10.4074H7.2V8.81486ZM11.472 5.62973L8.64 2.81088L9.768 1.68812L11.464 3.37624L14.856 0L16 1.12276L11.472 5.62973ZM11.472 12L8.64 9.18115L9.768 8.05839L11.464 9.74652L14.856 6.37027L16 7.49303L11.472 12Z" fill="white"/>
                    </svg>
                    <span>Riwayat Pesanan</span>
                </a>
                <a href="{{ route('customer.collections.index') }}" class="profile-nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                        <path d="M14.5455 0.352941C13.7382 0.105882 12.8509 0 12 0C10.5818 0 9.05455 0.282353 8 1.05882C6.94545 0.282353 5.41818 0 4 0C2.58182 0 1.05455 0.282353 0 1.05882V11.4C0 11.5765 0.181818 11.7529 0.363636 11.7529C0.436364 11.7529 0.472727 11.7176 0.545455 11.7176C1.52727 11.2588 2.94545 10.9412 4 10.9412C5.41818 10.9412 6.94545 11.2235 8 12C8.98182 11.4 10.7636 10.9412 12 10.9412C13.2 10.9412 14.4364 11.1529 15.4545 11.6824C15.5273 11.7176 15.5636 11.7176 15.6364 11.7176C15.8182 11.7176 16 11.5412 16 11.3647V1.05882C15.5636 0.741176 15.0909 0.529412 14.5455 0.352941ZM14.5455 9.88235C13.7455 9.63529 12.8727 9.52941 12 9.52941C10.7636 9.52941 8.98182 9.98824 8 10.5882V2.47059C8.98182 1.87059 10.7636 1.41176 12 1.41176C12.8727 1.41176 13.7455 1.51765 14.5455 1.76471V9.88235Z" fill="#4D4D4D"/>
                        <path d="M12 4.23528C12.64 4.23528 13.2582 4.29881 13.8182 4.41881V3.34586C13.2437 3.23998 12.6255 3.17645 12 3.17645C10.7637 3.17645 9.64366 3.38116 8.72729 3.76233V4.9341C9.54911 4.48233 10.6909 4.23528 12 4.23528Z" fill="#4D4D4D"/>
                        <path d="M8.72729 5.63996V6.81172C9.54911 6.35996 10.6909 6.1129 12 6.1129C12.64 6.1129 13.2582 6.17643 13.8182 6.29643V5.22349C13.2437 5.11761 12.6255 5.05408 12 5.05408C10.7637 5.05408 9.64366 5.26584 8.72729 5.63996Z" fill="#4D4D4D"/>
                        <path d="M12 6.93878C10.7637 6.93878 9.64366 7.14349 8.72729 7.52466V8.69643C9.54911 8.24466 10.6909 7.99761 12 7.99761C12.64 7.99761 13.2582 8.06113 13.8182 8.18113V7.10819C13.2437 6.99525 12.6255 6.93878 12 6.93878Z" fill="#4D4D4D"/>
                    </svg>
                    <span>Koleksi Buku Saya</span>
                </a>
                <div class="profile-nav-divider"></div>
                <form method="POST" action="{{ route('logout') }}" class="profile-nav-item profile-nav-item-logout">
                    @csrf
                    <button type="submit" class="profile-logout-btn">
                        <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 14H9C9.55 14 10 13.55 10 13V11H8V12H2V2H8V3H10V1C10 0.45 9.55 0 9 0H1C0.45 0 0 0.45 0 1V13C0 13.55 0.45 14 1 14ZM11.09 10.59L12.5 12L16 8.5L12.5 5L11.09 6.41L12.67 8H4V10H12.67L11.09 10.59Z" fill="#FF3B30"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Orders Content Card -->
        <div class="orders-content-card">
            <h2 class="orders-content-title">Riwayat Pesanan</h2>

            <div class="orders-list">
                @forelse($orders as $order)
                    <div class="order-card">
                        <!-- Order Header -->
                        <div class="order-header">
                            <div class="order-info">
                                <h3 class="order-id">{{ $order->order_number }}</h3>
                                <p class="order-date">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            <div class="order-badges">
                                @if($order->payment_method !== 'cod')
                                    @if($order->payment_status === 'pending')
                                        <span class="order-badge order-badge-warning">Belum Dibayar</span>
                                    @elseif($order->payment_status === 'paid')
                                        <span class="order-badge order-badge-success">Sudah Dibayar</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="order-badge order-badge-danger">Gagal</span>
                                    @endif
                                @endif

                                @if($order->status === 'pending')
                                    <span class="order-badge order-badge-warning">Menunggu</span>
                                @elseif($order->status === 'processing')
                                    <span class="order-badge order-badge-info">Diproses</span>
                                @elseif($order->status === 'shipped')
                                    <span class="order-badge order-badge-purple">Dikirim</span>
                                @elseif($order->status === 'completed')
                                    <span class="order-badge order-badge-success">Selesai</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="order-badge order-badge-danger">Dibatalkan</span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items-section">
                            <p class="order-items-label">Item Pesanan:</p>
                            <div class="order-items-list">
                                @foreach($order->orderDetails->take(3) as $detail)
                                    <div class="order-item-row">
                                        <div class="order-item-name">
                                            <span>{{ $detail->book->title }}</span>
                                            <span class="order-item-qty">x{{ $detail->quantity }}</span>
                                        </div>
                                        <div class="order-item-price">Rp {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                                @if($order->orderDetails->count() > 3)
                                    <p class="order-items-more">+{{ $order->orderDetails->count() - 3 }} item lainnya</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="order-footer">
                            <div class="order-payment-info">
                                <p class="order-payment-label">Metode Pembayaran</p>
                                <p class="order-payment-method">
                                    @if($order->payment_method === 'bank_transfer')
                                        🏦 Transfer Bank
                                    @elseif($order->payment_method === 'e-wallet')
                                        💳 E-Wallet
                                    @elseif($order->payment_method === 'credit_card')
                                        💳 Kartu Kredit
                                    @else
                                        💰 {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                                    @endif
                                </p>
                            </div>
                            <div class="order-total-info">
                                <p class="order-total-label">Total</p>
                                <p class="order-total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="order-actions">
                            @if($order->payment_method === 'cod' && $order->status != 'cancelled')
                                @if($order->status === 'shipped')
                                    <form class="order-actions" method="POST" action="{{ route('customer.orders.confirm', $order->id) }}" >
                                        @csrf
                                        <button type="submit" class="order-btn order-btn-success">Paket Diterima</button>
                                    </form>
                                @elseif($order->status === 'completed')
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="order-btn order-btn-success">Lihat Detail</a>
                                @elseif($order->canBeCancelled())
                                    <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="order-btn order-btn-danger">Batalkan Pesanan</button>
                                    </form>
                                @endif
                            @elseif ($order->status != 'cancelled')
                                @if($order->payment_status === 'pending')
                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('customer.orders.payment', $order->id) }}" class="order-btn order-btn-dark">Bayar</a>
                                        @if($order->canBeCancelled())
                                            <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="order-btn order-btn-danger">Batalkan</button>
                                            </form>
                                        @endif
                                    </div>
                                @elseif($order->status === 'shipped')
                                    <form method="POST" action="{{ route('customer.orders.confirm', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="order-btn order-btn-success">Paket Diterima</button>
                                    </form>
                                @elseif($order->status === 'completed')
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="order-btn order-btn-success">Lihat Detail</a>
                                @elseif($order->status === 'cancelled')

                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="orders-empty">
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" fill="#F2F2F2"/>
                            <path d="M50 30C38.954 30 30 38.954 30 50C30 61.046 38.954 70 50 70C61.046 70 70 61.046 70 50C70 38.954 61.046 30 50 30ZM45 57.5L35 47.5L37.825 44.675L45 51.825L62.175 34.65L65 37.5L45 57.5Z" fill="#CCCCCC"/>
                        </svg>
                        <p class="orders-empty-text">Belum ada transaksi</p>
                        <a href="{{ route('customer.books.index') }}" class="orders-empty-btn">Mulai Belanja</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
