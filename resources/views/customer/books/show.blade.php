<x-app-layout>
    <div class="book-detail-page">
        <div class="book-detail-header">
            <div class="book-detail-header-text">
                <h1 class="book-detail-header-title">Detail Buku</h1>
                <p class="book-detail-header-subtitle">Lihat informasi detail sebuah buku</p>
            </div>
        </div>

        <div class="book-detail-container">
            <div class="book-detail-breadcrumb">
                <p>Beranda / Koleksi Buku / {{ $book->title }}</p>
            </div>

            <div class="book-detail-section-1">
                <div class="book-detail-image">
                    @if(Storage::exists('public/' . $book->cover))
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->cover }}">
                    @else
                        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}">
                    @endif
                </div>

                <div class="book-detail-actions">
                    @php
                        if (Auth::check()){
                            $isLoved = \App\Models\Collection::where('book_id', $book->id)->where('user_id',Auth::id())->get();

                        }

                    @endphp

                    <form class="book-detail-actions" action="{{ route('customer.collections.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button class="book-detail-btn-action {{ count($isLoved) <= 0 ?  'nothing' : 'active' }}" type="submit">
                            <svg width="22" height="18" viewBox="0 0 22 18" fill="none">
                                <path d="M11 18L9.405 16.5425C3.74 11.395 0 8.0075 0 3.95C0 1.5625 1.87 0 4.4 0C5.808 0 7.15 0.6425 8 1.635C8.85 0.6425 10.192 0 11.6 0C14.13 0 16 1.5625 16 3.95C16 8.0075 12.26 11.395 6.595 16.5425L11 18Z" fill="currentColor"/>
                            </svg>
                        </button>
                        <button class="book-detail-btn-action">
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                            <path d="M15 13.5L9 17L3 13.5V3L9 6.5L15 3V13.5Z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M9 6.5V17" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>
                    </form>


                </div>

                <div class="book-detail-stock">
                    <p class="book-detail-stock-label">Stok tersedia</p>
                    <p class="book-detail-stock-value">{{ $book->stock }} unit</p>
                </div>
            </div>

            <div class="book-detail-section-2">
                <div class="book-detail-category-badge">
                    <p>{{ $book->getCategoryNameAttribute()}}</p>
                </div>

                <h2 class="book-detail-title">{{ $book->title }}</h2>

                <p class="book-detail-author">Oleh {{ $book->author }}</p>

                <div class="book-detail-rating-wrapper">
                    <div class="book-detail-rating-stars">
                        @php
                            $rating = $book->averageRating();
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5;
                        @endphp

                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#FFCC00"/>
                                </svg>
                            @elseif($i == $fullStars + 1 && $halfStar)
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <defs>
                                        <linearGradient id="half-star-detail">
                                            <stop offset="50%" stop-color="#FFCC00"/>
                                            <stop offset="50%" stop-color="#E5E7EB"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="url(#half-star-detail)"/>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" stroke="#E5E7EB" fill="#E5E7EB"/>
                                </svg>
                            @endif
                        @endfor

                        <span class="book-detail-rating-number">{{ number_format($rating, 1) }}</span>
                    </div>
                    <div class="book-detail-rating-divider"></div>
                    <p class="book-detail-reviews-count">{{ $book->totalReviews() }} ulasan</p>
                </div>

                <div class="book-detail-price-box">
                    <p class="book-detail-price-label">Harga</p>
                    <p class="book-detail-price-value">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                </div>

                <h3 class="book-detail-section-title">Detail Buku</h3>

                <div class="book-detail-info-grid">
                    <div class="book-detail-info-item">
                        <p class="book-detail-info-label">Penerbit</p>
                        <p class="book-detail-info-value">{{ $book->publisher ?? 'Pustaka Bentang' }}</p>
                    </div>
                    <div class="book-detail-info-item">
                        <p class="book-detail-info-label">Tahun</p>
                        <p class="book-detail-info-value">{{ $book->year ?? '2025' }}</p>
                    </div>
                    <div class="book-detail-info-item">
                        <p class="book-detail-info-label">Bahasa</p>
                        <p class="book-detail-info-value">{{ $book->language ?? 'Indonesia' }}</p>
                    </div>
                    <div class="book-detail-info-item">
                        <p class="book-detail-info-label">Halaman</p>
                        <p class="book-detail-info-value">{{ $book->pages ?? '500' }}</p>
                    </div>
                </div>

                <div class="book-detail-description-wrapper">
                    <h3 class="book-detail-section-title">Deskripsi</h3>

                    @php
                        $limit = 300;
                        $isLimited = strlen($book->description) > $limit;
                    @endphp

                    @if($isLimited)
                        <p class="book-detail-description" id="descriptionText">
                        {{ Str::limit($book->description, 300, '') }}
                        </p>
                        <p class="book-detail-description remainingContent" id="remainingContent">
                        {{ substr($book->description, 300) }}
                    </p>
                    <button class="book-detail-read-more" onclick="toggleDescription()">
                            Baca Selengkapnya
                        </button>
                    @else
                        <p class="book-detail-description" id="descriptionText">
                        {{ $book->description }}
                    </p>

                    @endif

                </div>

                <form action="{{ route('customer.cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="quantity" value="{{ 1 }}">
                    <button type="submit" class="book-detail-btn-cart">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7 18C7.55228 18 8 17.5523 8 17C8 16.4477 7.55228 16 7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18Z" stroke="#0088ff" stroke-width="2"/>
                        <path d="M16 18C16.5523 18 17 17.5523 17 17C17 16.4477 16.5523 16 16 16C15.4477 16 15 16.4477 15 17C15 17.5523 15.4477 18 16 18Z" stroke="#0088ff" stroke-width="2"/>
                        <path d="M1 1H4L6.68 13.39C6.77144 13.8504 7.02191 14.264 7.38755 14.5583C7.75318 14.8526 8.2107 15.009 8.68 15H15.4C15.8693 15.009 16.3268 14.8526 16.6925 14.5583C17.0581 14.264 17.3086 13.8504 17.4 13.39L19 6H5" stroke="#0088ff" stroke-width="2"/>
                        </svg>
                        <span>Tambah Ke Keranjang</span>
                    </button>
                </form>

                <form action="{{ route('customer.orders.create') }}" method="POST">
                    @csrf

                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="submit" class="book-detail-btn-buy">Beli Sekarang</button>
                </form>


                <div class="book-detail-reviews-section">
                    <div class="book-detail-review-prompt">
                        <p class="book-detail-review-prompt-text">Apa pendapatmu tentang produk ini?</p>
                        <button class="book-detail-btn-write-review" onclick="openReviewModal()">

                            Tulis Ulasan
                        </button>
                    </div>

                    <div class="book-detail-reviews-header">
                        <div class="book-detail-reviews-header-left">
                            <h3 class="book-detail-reviews-title">Ulasan Produk</h3>
                            <p class="book-detail-reviews-subtitle">
                                <span class="bold">{{ $book->totalReviews() }}</span> Ulasan
                            </p>
                        </div>
                        <div class="book-detail-reviews-header-right">
                            <form method="GET" id="sortReviewForm">
                                <select name="review_sort" class="book-detail-reviews-sort" onchange="sortReviews(this.value)">
                                    <option value="latest" {{ request('review_sort') == 'latest' || !request('review_sort') ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('review_sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="rating_high" {{ request('review_sort') == 'rating_high' ? 'selected' : '' }}>Rating Tertinggi</option>
                                    <option value="rating_low" {{ request('review_sort') == 'rating_low' ? 'selected' : '' }}>Rating Terendah</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="book-detail-reviews-list">
                        @forelse($reviews as $review)
                            <div class="book-detail-review-item">
                                <div class="book-detail-review-header">
                                    <div class="book-detail-review-user">
                                        <div class="book-detail-review-avatar">
                                            @if($review->user->avatar)
                                                <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}">
                                            @else
                                                <div class="book-detail-review-avatar-placeholder">
                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="book-detail-review-user-info">
                                            <p class="book-detail-review-user-name">{{ $review->user->name }}</p>
                                            <p class="book-detail-review-date">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="book-detail-review-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path d="M7.5 11.25L3.09 13.5675L3.93 8.5875L0.3675 5.1825L5.385 4.5675L7.5 0L9.615 4.5675L14.6325 5.1825L11.07 8.5875L11.91 13.5675L7.5 11.25Z" fill="#FFCC00"/>
                                                </svg>
                                            @else
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path d="M7.5 11.25L3.09 13.5675L3.93 8.5875L0.3675 5.1825L5.385 4.5675L7.5 0L9.615 4.5675L14.6325 5.1825L11.07 8.5875L11.91 13.5675L7.5 11.25Z" fill="#E5E7EB"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="book-detail-review-text">{{ $review->review }}</p>

                                <!-- Review Actions -->
                                <div class="book-detail-review-actions">
                                    @php
                                        $userLiked = $review->likes()->where('user_id', auth()->id())->exists();
                                        $userReported = $review->reports()->where('user_id', auth()->id())->exists();
                                    @endphp

                                    @if($userLiked)
                                        <form action="{{ route('customer.reviews.unlike', $review) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="book-detail-review-like-btn liked">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                </svg>
                                                <span>{{ $review->likes()->count() }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('customer.reviews.like', $review) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="book-detail-review-like-btn">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                </svg>
                                                <span>{{ $review->likes()->count() }}</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(!$userReported)
                                        <button type="button" class="book-detail-review-report-btn" onclick="openReportModal({{ $review->id }})">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                                                <line x1="4" y1="22" x2="4" y2="15"/>
                                            </svg>
                                            <span>Laporkan</span>
                                        </button>
                                    @else
                                        <span class="book-detail-review-reported-badge">Dilaporkan</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="book-detail-review-empty">
                                <p>Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>

                    @if($reviews->hasPages())
                        <div class="book-detail-reviews-pagination">
                            {{ $reviews->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="review-modal" id="reviewModal">
        <div class="review-modal-overlay" onclick="closeReviewModal()"></div>
        <div class="review-modal-content">
            <div class="review-modal-header">
                <h3 class="review-modal-title">Tulis Ulasan</h3>
                <button class="review-modal-close" onclick="closeReviewModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('customer.reviews.store', $book->id) }}" method="POST" class="review-modal-form">
                @csrf

                <div class="review-modal-book-info">
                    @if (Storage::exists('public/' . $book->cover))
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="review-modal-book-cover">
                    @else
                        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}" class="review-modal-book-cover">
                    @endif
                    <div class="review-modal-book-details">
                        <p class="review-modal-book-title">{{ $book->title }}</p>
                        <p class="review-modal-book-author">{{ $book->author }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Rating <span style="color: var(--error);">*</span></label>
                    <div class="review-rating-input">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required hidden>
                            <label for="star{{ $i }}" class="star-label">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16 24L6.544 29.056L8.384 18.528L0.768 11.264L11.424 9.872L16 0L20.576 9.872L31.232 11.264L23.616 18.528L25.456 29.056L16 24Z" fill="#E5E7EB"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <p class="review-rating-text">Pilih rating dari 1-5 bintang</p>
                </div>

                <div class="form-group">
                    <label for="review" class="form-label">Ulasan <span style="color: var(--error);">*</span></label>
                    <textarea
                        name="review"
                        id="review"
                        class="form-input review-textarea"
                        rows="5"
                        placeholder="Tulis ulasan Anda tentang buku ini..."
                        required
                    ></textarea>
                    <p class="form-helper">Minimal 10 karakter</p>
                </div>

                <div class="review-modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeReviewModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const isLoved = @json($isLoved);
        console.log(isLoved.length === 0);
        console.log(isLoved);
        function toggleDescription() {
            const descText = document.querySelector('.book-detail-description.remainingContent');
            const btn = event.target;

            if (descText.classList.contains('expanded')) {
                descText.classList.remove('expanded');
                btn.textContent = 'Baca Selengkapnya';
            } else {
                descText.classList.add('expanded');
                btn.textContent = 'Sembunyikan';
            }
        }

        // Review Modal Functions
        function openReviewModal() {
            document.getElementById('reviewModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.remove('active');
            document.body.style.overflow = '';
            // Reset form
            document.querySelector('.review-modal-form').reset();
            // Reset stars
            document.querySelectorAll('.star-label svg path').forEach(path => {
                path.setAttribute('fill', '#E5E7EB');
            });
        }

        // Star Rating Interaction
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-label');
            const ratingInputs = document.querySelectorAll('.review-rating-input input[type="radio"]');

            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    highlightStars(index + 1);
                });

                star.addEventListener('click', function() {
                    ratingInputs[index].checked = true;
                });
            });

            document.querySelector('.review-rating-input').addEventListener('mouseleave', function() {
                const checked = document.querySelector('.review-rating-input input[type="radio"]:checked');
                if (checked) {
                    const checkedIndex = Array.from(ratingInputs).indexOf(checked);
                    highlightStars(checkedIndex + 1);
                } else {
                    highlightStars(0);
                }
            });

            function highlightStars(count) {
                stars.forEach((star, index) => {
                    const path = star.querySelector('svg path');
                    if (index < count) {
                        path.setAttribute('fill', '#FFCC00');
                    } else {
                        path.setAttribute('fill', '#E5E7EB');
                    }
                });
            }
        });

        // Sort Reviews Function
        function sortReviews(sortValue) {
            const url = new URL(window.location.href);
            url.searchParams.set('review_sort', sortValue);
            window.location.href = url.toString();
        }

        // Report Modal Functions
        function openReportModal(reviewId) {
            document.getElementById('reportModal').classList.add('active');
            document.getElementById('reportReviewId').value = reviewId;
            document.body.style.overflow = 'hidden';
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.remove('active');
            document.body.style.overflow = '';
            document.getElementById('reportForm').reset();
        }
    </script>
    @endpush

    <!-- Report Modal -->
    <div class="review-modal" id="reportModal">
        <div class="review-modal-overlay" onclick="closeReportModal()"></div>
        <div class="review-modal-content">
            <div class="review-modal-header">
                <h2 class="review-modal-title">Laporkan Review</h2>
                <button class="review-modal-close" onclick="closeReportModal()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <form id="reportForm" action="" method="POST" class="review-modal-form" onsubmit="submitReport(event)">
                @csrf
                <input type="hidden" id="reportReviewId" name="review_id" value="">

                <div class="review-modal-field">
                    <label class="review-modal-label">Alasan Pelaporan (Opsional)</label>
                    <textarea name="reason" class="review-modal-textarea" rows="4" placeholder="Jelaskan alasan Anda melaporkan review ini..."></textarea>
                </div>

                <div class="review-modal-actions">
                    <button type="button" class="review-modal-btn review-modal-btn-cancel" onclick="closeReportModal()">
                        Batal
                    </button>
                    <button type="submit" class="review-modal-btn review-modal-btn-submit">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function submitReport(event) {
            event.preventDefault();
            const form = event.target;
            const reviewId = document.getElementById('reportReviewId').value;
            form.action = "{{ url('reviews') }}/" + reviewId + "/report";
            form.submit();
        }
    </script>
</x-app-layout>
