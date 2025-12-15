<x-app-layout>
    <div class="books-page-new">
        <div class="books-header-gradient">
            <div class="books-header-content">
                <h1 class="books-header-title">Koleksi Lengkap Buku</h1>
                <p class="books-header-subtitle">Temukan buku dari berbagai kategori</p>
            </div>
        </div>

        <div class="books-container">
            <div class="books-filter-wrapper">
                <div class="books-filter-card">
                    <h2 class="books-filter-heading">Filter</h2>

                    <form method="GET" class="form-books" action="{{ route('customer.books.index') }}" id="filterForm">
                        <div class="books-filter-section">
                            <h3 class="books-filter-title">Kategori</h3>
                            @php
                                $selectedCategories = request('categories', []);
                                if (!is_array($selectedCategories)) {
                                    $selectedCategories = [$selectedCategories];
                                }
                                $categoryCount = count($selectedCategories);
                                $displayText = $categoryCount > 0 ? "$categoryCount kategori dipilih" : "Pilih Kategori";
                            @endphp
                            <button type="button" class="books-category-modal-btn" onclick="openCategoryModal()">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M2.25 4.5H15.75M4.5 9H13.5M6.75 13.5H11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>{{ $displayText }}</span>
                            </button>
                        </div>

                        <div class="divider">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="1" viewBox="0 0 100 1" fill="none" preserveAspectRatio="none"><path d="M0.5 0.5H315.5" stroke="#99C8FF" stroke-linecap="round"/></svg>

                        </div>

                        <div class="books-filter-section">
                            <h3 class="books-filter-title">Rating Minimum</h3>
                            <div class="books-filter-options">
                                <label class="books-filter-option {{ !request('rating') ? 'active' : '' }}">
                                    <input type="radio" name="rating" value="" {{ !request('rating') ? 'checked' : '' }}>
                                    <span class="books-filter-label">Semua</span>
                                </label>
                                <label class="books-filter-option {{ request('rating') == '4.5' ? 'active' : '' }}">
                                    <input type="radio" name="rating" value="4.5" {{ request('rating') == '4.5' ? 'checked' : '' }}>
                                    <span class="books-filter-label">4.5+</span>
                                    <svg class="books-star-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M4.20459 15.65C3.82126 15.95 3.42959 15.9583 3.02959 15.675C2.62959 15.3917 2.49626 15.0167 2.62959 14.55L4.05459 9.925L0.429594 7.35C0.0295943 7.06667 -0.0910724 6.69167 0.0675943 6.225C0.225594 5.75833 0.546261 5.525 1.02959 5.525H5.50459L6.95459 0.725C7.03793 0.491667 7.16726 0.312334 7.34259 0.187C7.51726 0.0623336 7.70459 0 7.90459 0C8.10459 0 8.29193 0.0623336 8.46659 0.187C8.64193 0.312334 8.77126 0.491667 8.85459 0.725L10.3046 5.525H14.7796C15.2629 5.525 15.5839 5.75833 15.7426 6.225C15.9006 6.69167 15.7796 7.06667 15.3796 7.35L11.7546 9.925L13.1796 14.55C13.3129 15.0167 13.1796 15.3917 12.7796 15.675C12.3796 15.9583 11.9879 15.95 11.6046 15.65L7.90459 12.825L4.20459 15.65Z" fill="#4D4D4D"/>
                                    </svg>
                                </label>
                                <label class="books-filter-option {{ request('rating') == '4' ? 'active' : '' }}">
                                    <input type="radio" name="rating" value="4" {{ request('rating') == '4' ? 'checked' : '' }}>
                                    <span class="books-filter-label">4+</span>
                                    <svg class="books-star-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M4.20459 15.65C3.82126 15.95 3.42959 15.9583 3.02959 15.675C2.62959 15.3917 2.49626 15.0167 2.62959 14.55L4.05459 9.925L0.429594 7.35C0.0295943 7.06667 -0.0910724 6.69167 0.0675943 6.225C0.225594 5.75833 0.546261 5.525 1.02959 5.525H5.50459L6.95459 0.725C7.03793 0.491667 7.16726 0.312334 7.34259 0.187C7.51726 0.0623336 7.70459 0 7.90459 0C8.10459 0 8.29193 0.0623336 8.46659 0.187C8.64193 0.312334 8.77126 0.491667 8.85459 0.725L10.3046 5.525H14.7796C15.2629 5.525 15.5839 5.75833 15.7426 6.225C15.9006 6.69167 15.7796 7.06667 15.3796 7.35L11.7546 9.925L13.1796 14.55C13.3129 15.0167 13.1796 15.3917 12.7796 15.675C12.3796 15.9583 11.9879 15.95 11.6046 15.65L7.90459 12.825L4.20459 15.65Z" fill="#4D4D4D"/>
                                    </svg>
                                </label>
                                <label class="books-filter-option {{ request('rating') == '3.5' ? 'active' : '' }}">
                                    <input type="radio" name="rating" value="3.5" {{ request('rating') == '3.5' ? 'checked' : '' }}>
                                    <span class="books-filter-label">3.5+</span>
                                    <svg class="books-star-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M4.20459 15.65C3.82126 15.95 3.42959 15.9583 3.02959 15.675C2.62959 15.3917 2.49626 15.0167 2.62959 14.55L4.05459 9.925L0.429594 7.35C0.0295943 7.06667 -0.0910724 6.69167 0.0675943 6.225C0.225594 5.75833 0.546261 5.525 1.02959 5.525H5.50459L6.95459 0.725C7.03793 0.491667 7.16726 0.312334 7.34259 0.187C7.51726 0.0623336 7.70459 0 7.90459 0C8.10459 0 8.29193 0.0623336 8.46659 0.187C8.64193 0.312334 8.77126 0.491667 8.85459 0.725L10.3046 5.525H14.7796C15.2629 5.525 15.5839 5.75833 15.7426 6.225C15.9006 6.69167 15.7796 7.06667 15.3796 7.35L11.7546 9.925L13.1796 14.55C13.3129 15.0167 13.1796 15.3917 12.7796 15.675C12.3796 15.9583 11.9879 15.95 11.6046 15.65L7.90459 12.825L4.20459 15.65Z" fill="#4D4D4D"/>
                                    </svg>
                                </label>
                                <label class="books-filter-option {{ request('rating') == '3' ? 'active' : '' }}">
                                    <input type="radio" name="rating" value="3" {{ request('rating') == '3' ? 'checked' : '' }}>
                                    <span class="books-filter-label">3+</span>
                                    <svg class="books-star-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M4.20459 15.65C3.82126 15.95 3.42959 15.9583 3.02959 15.675C2.62959 15.3917 2.49626 15.0167 2.62959 14.55L4.05459 9.925L0.429594 7.35C0.0295943 7.06667 -0.0910724 6.69167 0.0675943 6.225C0.225594 5.75833 0.546261 5.525 1.02959 5.525H5.50459L6.95459 0.725C7.03793 0.491667 7.16726 0.312334 7.34259 0.187C7.51726 0.0623336 7.70459 0 7.90459 0C8.10459 0 8.29193 0.0623336 8.46659 0.187C8.64193 0.312334 8.77126 0.491667 8.85459 0.725L10.3046 5.525H14.7796C15.2629 5.525 15.5839 5.75833 15.7426 6.225C15.9006 6.69167 15.7796 7.06667 15.3796 7.35L11.7546 9.925L13.1796 14.55C13.3129 15.0167 13.1796 15.3917 12.7796 15.675C12.3796 15.9583 11.9879 15.95 11.6046 15.65L7.90459 12.825L4.20459 15.65Z" fill="#4D4D4D"/>
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="books-filter-submit-btn">
                            Terapkan Filter
                        </button>

                        @if(request('categories') || request('rating'))
                            <a href="{{ route('customer.books.index') }}" class="books-reset-btn">
                                Reset Filter
                            </a>
                        @endif
                    </form>

                    <button class="books-filter-toggle" onclick="toggleFilter()">
                        <svg width="18" height="11" viewBox="0 0 18 11" fill="none">
                            <path d="M1 1L9 9L17 1" stroke="#4D4D4D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Category Modal -->
            <div class="books-category-modal" id="categoryModal" onclick="closeCategoryModal(event)">
                <div class="books-category-modal-content" onclick="event.stopPropagation()">
                    <div class="books-category-modal-header">
                        <h3>Pilih Kategori</h3>
                        <button type="button" class="books-category-modal-close" onclick="closeCategoryModal()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <div class="books-category-modal-body">
                        @foreach(\App\Models\Book::getCategories() as $key => $label)
                            <label class="books-category-modal-option">
                                <input type="checkbox" name="categories[]" value="{{ $key }}" {{ in_array($key, $selectedCategories) ? 'checked' : '' }} form="filterForm">
                                <span class="books-category-modal-label">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="books-category-modal-footer">
                        <button type="button" class="books-category-modal-clear" onclick="clearCategories()">Clear</button>
                        <button type="button" class="books-category-modal-apply" onclick="applyCategoryFilter()">Terapkan</button>
                    </div>
                </div>
            </div>

            <div class="books-list-wrapper">

                <div class="books-list-header">
                    <p class="books-count-text">Menampilkan {{ $books->total() }} buku</p>
                    <form method="GET" action="{{ route('customer.books.index') }}" class="books-sort-form">
                        @if(request('categories'))
                            @foreach(request('categories') as $cat)
                                <input type="hidden" name="categories[]" value="{{ $cat }}">
                            @endforeach
                        @endif
                        @if(request('rating'))
                            <input type="hidden" name="rating" value="{{ request('rating') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="sort" class="books-sort-select" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </form>
                </div>

                @if($books->isEmpty())
                    <div class="books-empty-state">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none">
                            <path d="M60 110C87.6142 110 110 87.6142 110 60C110 32.3858 87.6142 10 60 10C32.3858 10 10 32.3858 10 60C10 87.6142 32.3858 110 60 110Z" fill="#F3F4F6"/>
                            <path d="M40 50H80M40 60H80M40 70H65" stroke="#9CA3AF" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                        <h3>Buku tidak ditemukan</h3>
                        <p>Coba kata kunci pencarian yang berbeda</p>
                    </div>
                @else
                    <div class="books-list-scroll">
                        @foreach($books as $book)
                            @php
                                $rating = $book->averageRating();
                            @endphp
                            <a href="{{ route('customer.books.show', $book->id) }}" class="books-card-item">
                                <div class="books-card-image">
                                    @if(Storage::exists('public/' . $book->cover))
                                        <img src="{{ asset( 'storage/' . $book->cover) }}" alt="{{ $book->cover }}">
                                    @else
                                        <img src="{{ asset( $book->cover) }}" alt="{{ $book->title }}">
                                    @endif
                                    <div class="books-rating-badge">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6 9L2.472 10.854L3.1452 6.867L0.2904 4.146L4.308 3.654L6 0L7.692 3.654L11.7096 4.146L8.8548 6.867L9.528 10.854L6 9Z" fill="white"/>
                                        </svg>
                                        <span>{{ number_format($rating, 1) }}</span>
                                    </div>
                                </div>

                                <div class="books-card-info">
                                    <div class="books-card-details">
                                        <p class="books-card-category">{{ $book->getCategoryNameAttribute()}}</p>
                                        <h3 class="books-card-title">{{ Str::limit($book->title, 30) }}</h3>
                                        <p class="books-card-author">Oleh {{ $book->author }}</p>
                                    </div>
                                    <div class="books-card-price-wrapper">
                                        <div class="books-card-price">
                                            Rp {{ number_format($book->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if($books->hasPages())
                        <div class="books-pagination">
                            {{ $books->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFilter() {
            const filterCard = document.querySelector('.books-filter-card');
            const toggleBtn = document.querySelector('.books-filter-toggle')

            filterCard.classList.toggle('collapsed');
            toggleBtn.classList.toggle('active');
        }

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeCategoryModal(event) {
            if (!event || event.target.id === 'categoryModal') {
                document.getElementById('categoryModal').classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        function clearCategories() {
            const checkboxes = document.querySelectorAll('.books-category-modal-option input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = false);
        }

        function applyCategoryFilter() {
            closeCategoryModal();
            // Button text will update on page reload
        }
    </script>
    @endpush
</x-app-layout>


