<x-admin-layout>
    <x-header-gradient title="Kelola Review" subtitle="Kelola dan moderasi review pengguna" />
    <div class="reviews-page">
        <!-- Stats Cards -->
        <div class="reviews-stats-grid">
            <div class="reviews-stat-card">
                <p class="reviews-stat-label">Total Review</p>
                <p class="reviews-stat-value reviews-stat-blue">{{ number_format($totalReviews) }}</p>
            </div>
            <div class="reviews-stat-card">
                <p class="reviews-stat-label">Total Like</p>
                <p class="reviews-stat-value reviews-stat-green">{{ number_format($totalLikes) }}</p>
            </div>
            <div class="reviews-stat-card">
                <p class="reviews-stat-label">Total Laporan</p>
                <p class="reviews-stat-value reviews-stat-yellow">{{ number_format($totalReports) }}</p>
            </div>
            <div class="reviews-stat-card">
                <p class="reviews-stat-label">Review Dilaporkan</p>
                <p class="reviews-stat-value reviews-stat-red">{{ number_format($reportedReviews) }}</p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="reviews-search-filter">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="reviews-search-form">
                <svg class="reviews-search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M16.5 16.5L12.875 12.875M14.8333 8.16667C14.8333 11.8486 11.8486 14.8333 8.16667 14.8333C4.48477 14.8333 1.5 11.8486 1.5 8.16667C1.5 4.48477 4.48477 1.5 8.16667 1.5C11.8486 1.5 14.8333 4.48477 14.8333 8.16667Z" stroke="rgba(10,10,10,0.5)" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" name="search" class="reviews-search-input" placeholder="Cari review, pengguna, atau buku..." value="{{ request('search') }}">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
            </form>

            <form action="{{ route('admin.reviews.index') }}" method="GET" class="reviews-filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div class="reviews-filter-select-wrapper">
                    <svg class="reviews-filter-icon" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M2.25 4.5H15.75M4.5 9H13.5M6.75 13.5H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <select name="sort" class="reviews-filter-select" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="most_likes" {{ request('sort') == 'most_likes' ? 'selected' : '' }}>Like Terbanyak</option>
                        <option value="least_likes" {{ request('sort') == 'least_likes' ? 'selected' : '' }}>Like Tersedikit</option>
                        <option value="most_reports" {{ request('sort') == 'most_reports' ? 'selected' : '' }}>Laporan Terbanyak</option>
                        <option value="least_reports" {{ request('sort') == 'least_reports' ? 'selected' : '' }}>Laporan Tersedikit</option>
                    </select>
                    <svg class="reviews-filter-chevron" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </form>
        </div>

        <!-- Reviews List -->
        <div class="reviews-list">
            @forelse($reviews as $review)
            <div class="review-card {{ $review->reports_count > 0 ? 'review-reported' : '' }}">
                <!-- Review Header -->
                <div class="review-header">
                    <div class="review-user-info">
                        <div class="review-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="review-user-name">{{ $review->user->name }}</p>
                            <p class="review-date">{{ $review->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="review-actions">
                        @if($review->reports_count > 0)
                            <span class="review-report-badge">🚩 {{ $review->reports_count }} Laporan</span>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="review-delete-btn">Hapus</button>
                        </form>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="review-book-info">
                    <img src="{{ asset($review->book->cover) }}" alt="{{ $review->book->title }}" class="review-book-cover">
                    <div>
                        <p class="review-book-title">{{ $review->book->title }}</p>
                        <p class="review-book-author">{{ $review->book->author }}</p>
                    </div>
                </div>

                <!-- Rating -->
                <div class="review-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="review-star {{ $i <= $review->rating ? 'active' : '' }}">★</span>
                    @endfor
                </div>

                <!-- Review Content -->
                @if($review->review)
                <div class="review-content">
                    <p>{{ $review->review }}</p>
                </div>
                @endif

                <!-- Review Stats -->
                <div class="review-stats">
                    <div class="review-stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor"/>
                        </svg>
                        <span>{{ $review->likes_count }} Like</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="reviews-empty-state">
                <p>Tidak ada review ditemukan</p>
                @if(request('search') || request('sort'))
                    <a href="{{ route('admin.reviews.index') }}" class="reviews-reset-btn">Reset Filter</a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="reviews-pagination">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
