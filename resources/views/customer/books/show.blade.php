<x-app-layout>
    <div class="book-detail-page">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="{{ route('customer.books.index') }}">Katalog</a>
                <span>/</span>
                <span>{{ $book->title }}</span>
            </nav>

            <!-- Book Detail Section -->
            <div class="book-detail-grid">
                <!-- Left: Book Cover -->
                <div class="book-cover-section">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="book-cover-large">
                    @else
                        <div class="book-cover-placeholder-large">
                            <svg width="120" height="120" viewBox="0 0 60 60" fill="none">
                                <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                <path d="M40 5V15H50" stroke="#9CA3AF" stroke-width="2"/>
                                <path d="M18 25H42M18 32H42M18 39H35" stroke="#9CA3AF" stroke-width="2"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <form method="POST" action="{{ route('customer.collections.store') }}" class="w-full">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn-action btn-collection">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 3.5L11.5 8.5H16.5L12.5 11.5L14 16.5L10 13.5L6 16.5L7.5 11.5L3.5 8.5H8.5L10 3.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                                Tambah ke Koleksi
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Book Info -->
                <div class="book-info-section">
                    <h1 class="book-title-detail">{{ $book->title }}</h1>
                    <p class="book-author-detail">oleh <strong>{{ $book->author }}</strong></p>

                    <!-- Rating Summary -->
                    <div class="rating-summary">
                        <div class="rating-stars-large">
                            @php
                                $rating = $book->averageRating();
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars) >= 0.5;
                            @endphp

                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <svg class="star-large star-filled" width="24" height="24" viewBox="0 0 20 20">
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#FCD34D"/>
                                    </svg>
                                @elseif($i == $fullStars + 1 && $halfStar)
                                    <svg class="star-large star-half" width="24" height="24" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="half-detail">
                                                <stop offset="50%" stop-color="#FCD34D"/>
                                                <stop offset="50%" stop-color="#E5E7EB"/>
                                            </linearGradient>
                                        </defs>
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="url(#half-detail)"/>
                                    </svg>
                                @else
                                    <svg class="star-large star-empty" width="24" height="24" viewBox="0 0 20 20">
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#E5E7EB"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-number">{{ number_format($rating, 1) }}</span>
                        <span class="rating-count">({{ $book->totalReviews() }} ulasan)</span>
                    </div>

                    <!-- Book Meta Info -->
                    <div class="book-meta">
                        @if($book->year)
                            <div class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M6 2V6M14 2V6M3 10H17M5 4H15C16.1046 4 17 4.89543 17 6V16C17 17.1046 16.1046 18 15 18H5C3.89543 18 3 17.1046 3 16V6C3 4.89543 3.89543 4 5 4Z" stroke="#6B7280" stroke-width="2"/>
                                </svg>
                                <span>Tahun: {{ $book->year }}</span>
                            </div>
                        @endif

                        <div class="meta-item">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <path d="M20 10C20 15.523 15.523 20 10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0C15.523 0 20 4.477 20 10Z" fill="#{{ $book->stock > 10 ? '10B981' : ($book->stock > 0 ? 'F59E0B' : 'EF4444') }}"/>
                            </svg>
                            <span>Stok: {{ $book->stock }} buku</span>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="price-section">
                        <div class="price-large">
                            <span class="price-currency">Rp</span>
                            <span class="price-amount">{{ number_format($book->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Add to Cart Form -->
                    @if($book->stock > 0)
                        <form method="POST" action="{{ route('customer.cart.store') }}" class="add-to-cart-section">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            <div class="quantity-selector">
                                <label for="quantity">Jumlah:</label>
                                <div class="quantity-controls">
                                    <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $book->stock }}" class="qty-input">
                                    <button type="button" class="qty-btn" onclick="increaseQty({{ $book->stock }})">+</button>
                                </div>
                            </div>

                            <button type="submit" class="btn-add-to-cart">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M7 18C7.55228 18 8 17.5523 8 17C8 16.4477 7.55228 16 7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M16 18C16.5523 18 17 17.5523 17 17C17 16.4477 16.5523 16 16 16C15.4477 16 15 16.4477 15 17C15 17.5523 15.4477 18 16 18Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M1 1H4L6.68 13.39C6.77144 13.8504 7.02191 14.264 7.38755 14.5583C7.75318 14.8526 8.2107 15.009 8.68 15H15.4C15.8693 15.009 16.3268 14.8526 16.6925 14.5583C17.0581 14.264 17.3086 13.8504 17.4 13.39L19 6H5" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <div class="out-of-stock">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="#EF4444" stroke-width="2"/>
                                <path d="M7 7L13 13M13 7L7 13" stroke="#EF4444" stroke-width="2"/>
                            </svg>
                            Stok Habis
                        </div>
                    @endif

                    <!-- Description -->
                    @if($book->description)
                        <div class="book-description">
                            <h3>Deskripsi</h3>
                            <p>{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="reviews-section">
                <h2 class="section-title">Ulasan Pembaca</h2>

                <!-- Rating Breakdown -->
                @php
                    $breakdown = $book->ratingBreakdown();
                    $totalReviews = $book->totalReviews();
                @endphp

                <div class="rating-breakdown">
                    <div class="rating-overview">
                        <div class="rating-score">{{ number_format($book->averageRating(), 1) }}</div>
                        <div class="rating-stars-medium">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($book->averageRating()))
                                    <svg class="star-medium star-filled" width="20" height="20" viewBox="0 0 20 20">
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#FCD34D"/>
                                    </svg>
                                @else
                                    <svg class="star-medium star-empty" width="20" height="20" viewBox="0 0 20 20">
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#E5E7EB"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <div class="rating-total">{{ $totalReviews }} ulasan</div>
                    </div>

                    <div class="rating-bars">
                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $count = $breakdown["{$i}_star"];
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="rating-bar-item">
                                <span class="star-label">{{ $i }} ★</span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="bar-count">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Write Review Form -->
                <div class="write-review-section">
                    <h3>Tulis Ulasan</h3>
                    <form method="POST" action="{{ route('customer.reviews.store', $book->id) }}" class="review-form">
                        @csrf

                        <div class="form-group">
                            <label>Rating</label>
                            <div class="star-rating-input" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="star-input" data-rating="{{ $i }}" width="32" height="32" viewBox="0 0 20 20">
                                        <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#E5E7EB"/>
                                    </svg>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" required>
                        </div>

                        <div class="form-group">
                            <label for="review">Ulasan (opsional)</label>
                            <textarea name="review" id="review" rows="4" class="form-textarea" placeholder="Bagikan pengalaman Anda tentang buku ini..."></textarea>
                        </div>

                        <button type="submit" class="btn-submit-review">Kirim Ulasan</button>
                    </form>
                </div>

                <!-- Reviews List -->
                <div class="reviews-list">
                    @forelse($book->reviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-user">
                                    <div class="user-avatar">{{ substr($review->user->name, 0, 1) }}</div>
                                    <div>
                                        <div class="user-name">{{ $review->user->name }}</div>
                                        <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="star-small star-filled" width="16" height="16" viewBox="0 0 20 20">
                                                <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#FCD34D"/>
                                            </svg>
                                        @else
                                            <svg class="star-small star-empty" width="16" height="16" viewBox="0 0 20 20">
                                                <path d="M10 15L4.12 18.09L5.24 11.45L0.49 6.91L7.18 6.09L10 0L12.82 6.09L19.51 6.91L14.76 11.45L15.88 18.09L10 15Z" fill="#E5E7EB"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if($review->review)
                                <p class="review-text">{{ $review->review }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="no-reviews">
                            <p>Belum ada ulasan untuk buku ini. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->isNotEmpty())
                <div class="related-books-section">
                    <h2 class="section-title">Buku Lain dari {{ $book->author }}</h2>
                    <div class="related-books-grid">
                        @foreach($relatedBooks as $related)
                            <div class="related-book-card">
                                <a href="{{ route('customer.books.show', $related->id) }}">
                                    @if($related->cover)
                                        <img src="{{ asset('storage/' . $related->cover) }}" alt="{{ $related->title }}">
                                    @else
                                        <div class="related-book-placeholder">
                                            <svg width="40" height="40" viewBox="0 0 60 60" fill="none">
                                                <path d="M10 5H40L50 15V50C50 51.1046 49.1046 52 48 52H10C8.89543 52 8 51.1046 8 50V7C8 5.89543 8.89543 5 10 5Z" fill="#E5E7EB"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <h4>{{ $related->title }}</h4>
                                    <p class="related-price">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .book-detail-page {
            padding: 40px 0;
        }

        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            font-size: 14px;
            color: #6b7280;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .book-detail-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .book-cover-section {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .book-cover-large {
            width: 100%;
            height: 550px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .book-cover-placeholder-large {
            width: 100%;
            height: 550px;
            background: #f3f4f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            flex: 1;
            padding: 12px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #1f2937;
        }

        .btn-action:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .book-title-detail {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .book-author-detail {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f3f4f6;
        }

        .rating-stars-large {
            display: flex;
            gap: 4px;
        }

        .rating-number {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .rating-count {
            color: #6b7280;
        }

        .book-meta {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 30px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6b7280;
        }

        .price-section {
            margin-bottom: 30px;
        }

        .price-large {
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .price-currency {
            font-size: 20px;
            color: #6b7280;
        }

        .price-amount {
            font-size: 42px;
            font-weight: 700;
            color: #667eea;
        }

        .add-to-cart-section {
            background: #f9fafb;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quantity-selector label {
            font-weight: 600;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .qty-input {
            width: 60px;
            height: 36px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-add-to-cart {
            width: 100%;
            padding: 16px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display:
