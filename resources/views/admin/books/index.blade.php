<x-admin-layout>
    <x-HeaderGradient title="Kelola Buku" subtitle="Kelola inventaris dan informasi buku">
    </x-HeaderGradient>

    <div class="books-page">
        <!-- Stats Cards -->
        <div class="books-stats-grid">
            <div class="books-stat-card books-stat-card-blue">
                <p class="books-stat-label">Total Buku</p>
                <p class="books-stat-value">{{ $totalBooks }}</p>
            </div>
            <div class="books-stat-card books-stat-card-red">
                <p class="books-stat-label">Stok Habis</p>
                <p class="books-stat-value">{{ $outOfStock }}</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="books-search-filter">
            <form action="{{ route('admin.books.index') }}" method="GET" class="books-search-form">
                <svg class="books-search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M16.5 16.5L12.875 12.875M14.8333 8.16667C14.8333 11.8486 11.8486 14.8333 8.16667 14.8333C4.48477 14.8333 1.5 11.8486 1.5 8.16667C1.5 4.48477 4.48477 1.5 8.16667 1.5C11.8486 1.5 14.8333 4.48477 14.8333 8.16667Z" stroke="rgba(10,10,10,0.5)" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" name="search" class="books-search-input" placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>

            <form action="{{ route('admin.books.index') }}" method="GET" class="books-filter-form" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div class="books-filter-select-wrapper">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" class="books-filter-icon">
                        <path d="M2.25 4.5H15.75M4.5 9H13.5M6.75 13.5H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <select name="filter" class="books-filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="" {{ !request('filter') ? 'selected' : '' }}>Semua</option>
                        <option value="tersedia" {{ request('filter') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ request('filter') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        <option value="stok_terbanyak" {{ request('filter') == 'stok_terbanyak' ? 'selected' : '' }}>Stok Terbanyak</option>
                        <option value="stok_tersedikit" {{ request('filter') == 'stok_tersedikit' ? 'selected' : '' }}>Stok Tersedikit</option>
                    </select>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="books-filter-chevron">
                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </form>

            <a href="{{ route('admin.books.create') }}" class="books-add-btn">
                + Tambah Buku
            </a>
        </div>

        <!-- Books Cards Grid -->
        <div class="books-cards-grid">
            @forelse($books as $book)
            <div class="books-card-new">
                <!-- Header with ID and Status -->
                <div class="books-card-header-new">
                    <div class="books-card-id-section">
                        <p class="books-card-id">BK{{ str_pad($book->id, 3, '0', STR_PAD_LEFT) }}</p>
                        <p class="books-card-category">{{ $book->category_name }}</p>
                    </div>
                    @if($book->stock > 0)
                    <div class="books-status-badge books-status-available">
                        <p>Tersedia</p>
                    </div>
                    @else
                    <div class="books-status-badge books-status-unavailable">
                        <p>SHabis</p>
                    </div>
                    @endif
                </div>

                <!-- Book Info Section -->
                <div class="books-info-section">
                    <div class="books-title-author">
                        <p class="books-title-new">{{ $book->title }}</p>
                        <p class="books-author-new">{{ $book->author }}</p>
                    </div>
                    <div class="books-price-stock">
                        <div class="books-price-item">
                            <p class="books-price-label">Harga</p>
                            <p class="books-price-value">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="books-stock-item">
                            <p class="books-stock-label">Stok</p>
                            <p class="books-stock-value {{ $book->stock > 0 ? 'stock-available' : 'stock-empty' }}">{{ $book->stock }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions Footer -->
                <div class="books-card-footer-new">
                    <a href="{{ route('admin.books.edit', $book) }}" class="books-edit-btn">Edit</a>
                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="books-delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="books-delete-btn">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="books-empty-state">
                <p>Belum ada buku ditemukan</p>
                <a href="{{ route('admin.books.create') }}" class="books-add-first-btn">+ Tambah Buku Pertama</a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="books-pagination">
            {{ $books->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
