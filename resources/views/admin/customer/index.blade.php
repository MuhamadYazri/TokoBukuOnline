<x-admin-layout>
    <div class="customer-page">
        <!-- Header -->
        <x-header-gradient title="Kelola Pengguna" subtitle="Kelola data pengguna toko buku" />

        <!-- Controls -->
        <div class="customer-controls">
            <div class="customer-controls-inner">
                <!-- Search -->
                <form action="{{ route('admin.customers.index') }}" method="GET" class="customer-search">
                    <svg class="customer-search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input type="text" name="search" class="customer-search-input" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>

                <!-- Sort -->
                <form action="{{ route('admin.customers.index') }}" method="GET" class="customer-sort">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="sort" class="customer-sort-select" onchange="this.form.submit()">
                        <option value="">Urutkan</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="customer-content">
            @if($customers->count() > 0)
                <!-- Table (Desktop) -->
                <div class="customer-table-wrap">
                    <table class="customer-table">
                        <thead>
                            <tr>
                                <th class="customer-th">
                                    <input type="checkbox" class="customer-checkbox">
                                </th>
                                <th class="customer-th">Pengguna</th>
                                <th class="customer-th">Email</th>
                                <th class="customer-th customer-th-center">Pesanan</th>
                                <th class="customer-th customer-th-center">Ulasan</th>
                                <th class="customer-th customer-th-center">Koleksi</th>
                                <th class="customer-th">Terdaftar</th>
                                <th class="customer-th customer-th-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr class="customer-tr">
                                <td class="customer-td">
                                    <input type="checkbox" class="customer-checkbox">
                                </td>
                                <td class="customer-td">
                                    <div class="customer-user">
                                        <div class="customer-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                        <span class="customer-name">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td class="customer-td">
                                    <span class="customer-email">{{ $customer->email }}</span>
                                </td>
                                <td class="customer-td customer-td-center">
                                    <span class="customer-badge customer-badge-blue">{{ $customer->orders_count }}</span>
                                </td>
                                <td class="customer-td customer-td-center">
                                    <span class="customer-badge customer-badge-yellow">{{ $customer->reviews_count }}</span>
                                </td>
                                <td class="customer-td customer-td-center">
                                    <span class="customer-badge customer-badge-green">{{ $customer->collections_count }}</span>
                                </td>
                                <td class="customer-td">
                                    <span class="customer-date">{{ $customer->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="customer-td customer-td-center">
                                    <div class="customer-actions">
                                        <button class="customer-btn" title="Lihat">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M0.75 9C0.75 9 3.75 3 9 3C14.25 3 17.25 9 17.25 9C17.25 9 14.25 15 9 15C3.75 15 0.75 9 0.75 9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <button class="customer-btn" title="Edit">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M8.25 3H3C2.60218 3 2.22064 3.15804 1.93934 3.43934C1.65804 3.72064 1.5 4.10218 1.5 4.5V15C1.5 15.3978 1.65804 15.7794 1.93934 16.0607C2.22064 16.342 2.60218 16.5 3 16.5H13.5C13.8978 16.5 14.2794 16.342 14.5607 16.0607C14.842 15.7794 15 15.3978 15 15V9.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M13.875 1.875C14.1734 1.57663 14.5777 1.40922 15 1.40922C15.4223 1.40922 15.8266 1.57663 16.125 1.875C16.4234 2.17337 16.5908 2.57768 16.5908 3C16.5908 3.42232 16.4234 3.82663 16.125 4.125L9 11.25L6 12L6.75 9L13.875 1.875Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <button class="customer-btn customer-btn-delete" title="Hapus">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <path d="M2.25 4.5H3.75H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6 4.5V3C6 2.60218 6.15804 2.22064 6.43934 1.93934C6.72064 1.65804 7.10218 1.5 7.5 1.5H10.5C10.8978 1.5 11.2794 1.65804 11.5607 1.93934C11.842 2.22064 12 2.60218 12 3V4.5M14.25 4.5V15C14.25 15.3978 14.092 15.7794 13.8107 16.0607C13.5294 16.342 13.1478 16.5 12.75 16.5H5.25C4.85218 16.5 4.47064 16.342 4.18934 16.0607C3.90804 15.7794 3.75 15.3978 3.75 15V4.5H14.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cards (Mobile) -->
                <div class="customer-cards">
                    @foreach($customers as $customer)
                    <div class="customer-card">
                        <div class="customer-card-header">
                            <div class="customer-user">
                                <div class="customer-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-email">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="customer-card-body">
                            <div class="customer-card-stats">
                                <div class="customer-stat">
                                    <span class="customer-stat-label">Pesanan</span>
                                    <span class="customer-badge customer-badge-blue">{{ $customer->orders_count }}</span>
                                </div>
                                <div class="customer-stat">
                                    <span class="customer-stat-label">Ulasan</span>
                                    <span class="customer-badge customer-badge-yellow">{{ $customer->reviews_count }}</span>
                                </div>
                                <div class="customer-stat">
                                    <span class="customer-stat-label">Koleksi</span>
                                    <span class="customer-badge customer-badge-green">{{ $customer->collections_count }}</span>
                                </div>
                            </div>
                            <div class="customer-card-footer">
                                <span class="customer-date">Terdaftar: {{ $customer->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="customer-pagination">
                    {{ $customers->links() }}
                </div>
            @else
                <div class="customer-empty">
                    <svg class="customer-empty-icon" width="64" height="64" viewBox="0 0 64 64" fill="none">
                        <path d="M32 56C45.2548 56 56 45.2548 56 32C56 18.7452 45.2548 8 32 8C18.7452 8 8 18.7452 8 32C8 45.2548 18.7452 56 32 56Z" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M32 40V32" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M32 24H32.02" stroke="#E5E7EB" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="customer-empty-text">Tidak ada pengguna ditemukan</p>
                    @if(request('search') || request('sort'))
                        <a href="{{ route('admin.customers.index') }}" class="customer-empty-btn">Reset Filter</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
