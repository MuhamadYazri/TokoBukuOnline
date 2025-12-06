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
                    @if($book->cover)
                        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}">
                    @else
                        <div class="book-detail-image-placeholder">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                                <path d="M15 10H55L65 20V65C65 66.1046 64.1046 67 63 67H15C13.8954 67 13 66.1046 13 65V12C13 10.8954 13.8954 10 15 10Z" fill="#E5E7EB"/>
                                <path d="M55 10V20H65" stroke="#9CA3AF" stroke-width="2"/>
                                <path d="M25 35H55M25 42H55M25 49H47" stroke="#9CA3AF" stroke-width="2"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="book-detail-actions">
                    <form action="{{ route('customer.collections.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button class="book-detail-btn-action" type="submit">
                            <svg width="22" height="18" viewBox="0 0 22 18" fill="none">
                                <path d="M11 18L9.405 16.5425C3.74 11.395 0 8.0075 0 3.95C0 1.5625 1.87 0 4.4 0C5.808 0 7.15 0.6425 8 1.635C8.85 0.6425 10.192 0 11.6 0C14.13 0 16 1.5625 16 3.95C16 8.0075 12.26 11.395 6.595 16.5425L11 18Z" fill="#B3B3B3"/>
                            </svg>
                        </button>
                    </form>

                    <button class="book-detail-btn-action">
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                            <path d="M15 13.5L9 17L3 13.5V3L9 6.5L15 3V13.5Z" stroke="#B3B3B3" stroke-width="2" fill="none"/>
                            <path d="M9 6.5V17" stroke="#B3B3B3" stroke-width="2"/>
                        </svg>
                    </button>
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

                    <p class="book-detail-description" id="descriptionText">
                        {{ Str::limit($book->description, 300, '') }}
                    </p>

                    @if($isLimited)
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
                        <path d="M7 18C7.55228 18 8 17.5523 8 17C8 16.4477 7.55228 16 7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18Z" stroke="#6600FF" stroke-width="2"/>
                        <path d="M16 18C16.5523 18 17 17.5523 17 17C17 16.4477 16.5523 16 16 16C15.4477 16 15 16.4477 15 17C15 17.5523 15.4477 18 16 18Z" stroke="#6600FF" stroke-width="2"/>
                        <path d="M1 1H4L6.68 13.39C6.77144 13.8504 7.02191 14.264 7.38755 14.5583C7.75318 14.8526 8.2107 15.009 8.68 15H15.4C15.8693 15.009 16.3268 14.8526 16.6925 14.5583C17.0581 14.264 17.3086 13.8504 17.4 13.39L19 6H5" stroke="#6600FF" stroke-width="2"/>
                        </svg>
                        <span>Tambah Ke Keranjang</span>
                    </button>
                </form>

                <a href="#" class="book-detail-btn-buy">
                    Beli Sekarang
                </a>

                <div class="book-detail-reviews-section">
                    <div class="book-detail-review-prompt">
                        <p class="book-detail-review-prompt-text">Apa pendapatmu tentang produk ini?</p>
                        <button class="book-detail-btn-write-review">
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
                            <select class="book-detail-reviews-sort">
                                <option value="terbaru">Terbaru</option>
                                <option value="terlama">Terlama</option>
                                <option value="rating-tertinggi">Rating Tertinggi</option>
                                <option value="rating-terendah">Rating Terendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="book-detail-reviews-list">
                        @foreach($book->reviews()->latest()->take(5)->get() as $review)
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
                            </div>
                        @endforeach
                    </div>

                    @if($book->totalReviews() > 5)
                        <div class="book-detail-reviews-load-more">
                            <button class="book-detail-btn-load-more">
                                Muat lebih banyak ulasan...
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleDescription() {
            const descText = document.querySelector('.book-detail-description.remainingContent');
            const btn = event.target;

            if (descText.classList.contains('expanded')) {
                descText.classList.remove('expanded');
                // descText.style.maxHeight = 0;
                btn.textContent = 'Baca Selengkapnya';
            } else {
                descText.classList.add('expanded');
                // descText.style.maxHeight = "none";
                btn.textContent = 'Sembunyikan';
            }
        }
    </script>
    @endpush
</x-app-layout>
