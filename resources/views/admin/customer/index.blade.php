<x-admin-layout>
    <x-header-gradient title="Kelola Pengguna" subtitle="Kelola data dan informasi pengguna" />
    <div class="customer-page">
        <!-- Header -->


        <!-- Stats Cards -->
        <div class="customer-stats-grid">
            <div class="customer-stat-card customer-stat-card-blue">
                <p class="customer-stat-label">Total Pengguna</p>
                <p class="customer-stat-value">{{ number_format($totalCustomers) }}</p>
            </div>
            <div class="customer-stat-card customer-stat-card-purple">
                <p class="customer-stat-label">Pengguna Baru Bulan Ini</p>
                <p class="customer-stat-value">{{ $newCustomersThisMonth }}</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="customer-search-filter">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="customer-search-form">
                <svg class="customer-search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M16.5 16.5L12.875 12.875M14.8333 8.16667C14.8333 11.8486 11.8486 14.8333 8.16667 14.8333C4.48477 14.8333 1.5 11.8486 1.5 8.16667C1.5 4.48477 4.48477 1.5 8.16667 1.5C11.8486 1.5 14.8333 4.48477 14.8333 8.16667Z" stroke="rgba(10,10,10,0.5)" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" name="search" class="customer-search-input" placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
            </form>

            <form action="{{ route('admin.customers.index') }}" method="GET" class="customer-filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <button type="button" class="customer-filter-btn">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M2.25 4.5H15.75M4.5 9H13.5M6.75 13.5H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Semua Status</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Customer Cards Grid -->
        <div class="customer-cards-grid">
            @forelse($customers as $customer)
            <div class="customer-card-new">
                <!-- Header with Avatar and Name -->
                <div class="customer-card-header-new">
                    <div class="customer-profile-section">
                        <div class="customer-avatar-new">
                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                        </div>
                        <div class="customer-info">
                            <p class="customer-id">USR{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</p>
                            <p class="customer-name-new">{{ $customer->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="customer-contact-section">
                    <div class="customer-contact-item">
                        <span>📧</span>
                        <p>{{ $customer->email }}</p>
                    </div>
                    <div class="customer-contact-item">
                        <span>📱</span>
                        <p>{{ $customer->phone ?? '081234567890' }}</p>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="customer-stats-section">
                    <div class="customer-stat-item">
                        <p class="customer-stat-item-label">Total Pesanan</p>
                        <p class="customer-stat-item-value customer-stat-blue">{{ $customer->orders_count }}</p>
                    </div>
                    <div class="customer-stat-item customer-stat-item-right">
                        <p class="customer-stat-item-label">Total Belanja</p>
                        <p class="customer-stat-item-value customer-stat-green">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="customer-card-footer-new">
                    <p class="customer-join-date">Bergabung: {{ $customer->created_at->format('Y-m-d') }}</p>
                    <button class="customer-detail-btn">Detail</button>
                </div>
            </div>
            @empty
            <div class="customer-empty-state">
                <p>Tidak ada pengguna ditemukan</p>
                @if(request('search') || request('sort'))
                    <a href="{{ route('admin.customers.index') }}" class="customer-reset-btn">Reset Filter</a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
        <div class="customer-pagination">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
