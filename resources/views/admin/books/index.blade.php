<x-admin-layout>
    <x-HeaderGradient title="Kelola Buku" subtitle="Kelola semua koleksi buku di toko online Anda">
    </x-HeaderGradient>

    <div class="admin-books-body">
        <div class="admin-books-container">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="admin-alert admin-alert-success">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM8 15L3 10L4.41 8.59L8 12.17L15.59 4.58L17 6L8 15Z" fill="currentColor"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-alert admin-alert-error">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V13H11V15ZM11 11H9V5H11V11Z" fill="currentColor"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Content -->
            <div class="admin-books-content">

                <!-- Top Actions Bar -->
                <div class="admin-books-actions-bar">
                    <div class="admin-books-actions-left">
                        <h2 class="admin-books-page-title">Daftar Buku</h2>
                        <p class="admin-books-count">Total: <span>{{ $books->total() }}</span> buku</p>
                    </div>
                    <div class="admin-books-actions-right">
                        <a href="{{ route('admin.books.create') }}" class="admin-btn admin-btn-primary">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 3.75V14.25M3.75 9H14.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Tambah Buku</span>
                        </a>
                    </div>
                </div>

                <!-- Filter & Search Section -->
                <div class="admin-books-filter-section">
                    <form method="GET" action="{{ route('admin.books.index') }}" class="admin-books-filter-form">

                        <!-- Search Input -->
                        <div class="admin-books-search-wrapper">
                            <svg class="admin-books-search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25 14.25C11.5637 14.25 14.25 11.5637 14.25 8.25C14.25 4.93629 11.5637 2.25 8.25 2.25C4.93629 2.25 2.25 4.93629 2.25 8.25C2.25 11.5637 4.93629 14.25 8.25 14.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.75 15.75L12.4875 12.4875" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                class="admin-books-search-input"
                                placeholder="Cari judul buku atau penulis..."
                                value="{{ request('search') }}"
                            >
                        </div>

                        <!-- Filter Dropdowns -->
                        <div class="admin-books-filters-group">
                            <!-- Category Filter -->
                            <select name="category" class="admin-books-filter-select">
                                <option value="">Semua Kategori</option>
                                @foreach(\App\Models\Book::getCategories() as $key => $category)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Stock Filter -->
                            <select name="stock_status" class="admin-books-filter-select">
                                <option value="">Semua Status</option>
                                <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="unavailable" {{ request('stock_status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>

                            <!-- Sort Filter -->
                            <select name="sort" class="admin-books-filter-select">
                                <option value="">Urutkan</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="most_sold" {{ request('sort') == 'most_sold' ? 'selected' : '' }}>Paling Laku</option>
                                <option value="least_sold" {{ request('sort') == 'least_sold' ? 'selected' : '' }}>Paling Tidak Laku</option>
                            </select>

                            <!-- Apply Button -->
                            <button type="submit" class="admin-books-filter-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.25 4.5H15.75M4.5 9H13.5M7.5 13.5H10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Filter
                            </button>

                            <!-- Reset Button -->
                            <a href="{{ route('admin.books.index') }}" class="admin-books-reset-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.25 9.75C2.58273 7.82503 3.60591 6.08748 5.12731 4.87077C6.64871 3.65407 8.56303 3.03928 10.5 3.14999M15.75 8.25C15.4173 10.175 14.3941 11.9125 12.8727 13.1292C11.3513 14.3459 9.43697 14.9607 7.5 14.85M2.25 12.75V9.75H5.25M15.75 5.25V8.25H12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Books Table -->
                <div class="admin-books-table-wrapper">
                    @if($books->count() > 0)
                        <div class="admin-books-table-container">
                            <table class="admin-books-table">
                                <thead>
                                    <tr>
                                        <th class="admin-table-th">Cover</th>
                                        <th class="admin-table-th">Judul & Penulis</th>
                                        <th class="admin-table-th">Kategori</th>
                                        <th class="admin-table-th">Harga</th>
                                        <th class="admin-table-th">Stok</th>
                                        <th class="admin-table-th">Status</th>
                                        <th class="admin-table-th">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                    <tr class="admin-table-row">
                                        <!-- Cover -->
                                        <td class="admin-table-td">
                                            <div class="admin-book-cover">
                                                @if($book->cover)
                                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                                                @else
                                                    <div class="admin-book-cover-placeholder">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4 19.5V4.5C4 3.67157 4.67157 3 5.5 3H18.5C19.3284 3 20 3.67157 20 4.5V19.5L12 16L4 19.5Z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Title & Author -->
                                        <td class="admin-table-td">
                                            <div class="admin-book-info">
                                                <p class="admin-book-title">{{ $book->title }}</p>
                                                <p class="admin-book-author">{{ $book->author }}</p>
                                                <p class="admin-book-year">{{ $book->year }}</p>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td class="admin-table-td">
                                            <span class="admin-category-badge">{{ $book->category_name }}</span>
                                        </td>

                                        <!-- Price -->
                                        <td class="admin-table-td">
                                            <span class="admin-book-price">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                                        </td>

                                        <!-- Stock -->
                                        <td class="admin-table-td">
                                            <span class="admin-book-stock {{ $book->stock > 10 ? 'stock-high' : ($book->stock > 0 ? 'stock-medium' : 'stock-empty') }}">
                                                {{ $book->stock }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="admin-table-td">
                                            @if($book->stock > 0)
                                                <span class="admin-status-badge status-available">
                                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="4" cy="4" r="3" fill="currentColor"/>
                                                    </svg>
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="admin-status-badge status-unavailable">
                                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="4" cy="4" r="3" fill="currentColor"/>
                                                    </svg>
                                                    Habis
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="admin-table-td">
                                            <div class="admin-table-actions">
                                                <a href="{{ route('admin.books.show', $book) }}" class="admin-action-btn admin-action-view" title="Lihat Detail">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1.5 9C1.5 9 3.75 4.5 9 4.5C14.25 4.5 16.5 9 16.5 9C16.5 9 14.25 13.5 9 13.5C3.75 13.5 1.5 9 1.5 9Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M9 11.25C10.2426 11.25 11.25 10.2426 11.25 9C11.25 7.75736 10.2426 6.75 9 6.75C7.75736 6.75 6.75 7.75736 6.75 9C6.75 10.2426 7.75736 11.25 9 11.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book) }}" class="admin-action-btn admin-action-edit" title="Edit">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.25 3H3C2.60218 3 2.22064 3.15804 1.93934 3.43934C1.65804 3.72064 1.5 4.10218 1.5 4.5V15C1.5 15.3978 1.65804 15.7794 1.93934 16.0607C2.22064 16.342 2.60218 16.5 3 16.5H13.5C13.8978 16.5 14.2794 16.342 14.5607 16.0607C14.842 15.7794 15 15.3978 15 15V9.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M13.875 1.875C14.1734 1.57663 14.5777 1.40906 15 1.40906C15.4223 1.40906 15.8266 1.57663 16.125 1.875C16.4234 2.17337 16.5909 2.57774 16.5909 3C16.5909 3.42226 16.4234 3.82663 16.125 4.125L9 11.25L6 12L6.75 9L13.875 1.875Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="admin-delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-action-btn admin-action-delete" title="Hapus">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M2.25 4.5H3.75H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M6 4.5V3C6 2.60218 6.15804 2.22064 6.43934 1.93934C6.72064 1.65804 7.10218 1.5 7.5 1.5H10.5C10.8978 1.5 11.2794 1.65804 11.5607 1.93934C11.842 2.22064 12 2.60218 12 3V4.5M14.25 4.5V15C14.25 15.3978 14.092 15.7794 13.8107 16.0607C13.5294 16.342 13.1478 16.5 12.75 16.5H5.25C4.85218 16.5 4.47064 16.342 4.18934 16.0607C3.90804 15.7794 3.75 15.3978 3.75 15V4.5H14.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($books->hasPages())
                        <div class="admin-books-pagination">
                            {{ $books->links('pagination::bootstrap-5') }}
                        </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="admin-books-empty-state">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40" cy="40" r="40" fill="#F1F5F9"/>
                                <path d="M28 52V28C28 26.3431 29.3431 25 31 25H49C50.6569 25 52 26.3431 52 28V52L40 47L28 52Z" fill="#CBD5E1"/>
                            </svg>
                            <h3 class="admin-empty-title">Belum Ada Buku</h3>
                            <p class="admin-empty-text">Mulai tambahkan buku pertama Anda untuk memulai penjualan.</p>
                            <a href="{{ route('admin.books.create') }}" class="admin-btn admin-btn-primary">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 3.75V14.25M3.75 9H14.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Tambah Buku Pertama</span>
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
