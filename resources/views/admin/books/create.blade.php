<x-admin-layout>
    <x-HeaderGradient title="Tambah Buku Baru" subtitle="Lengkapi informasi buku yang akan ditambahkan">
    </x-HeaderGradient>

    <div class="admin-form-body">
        <div class="admin-form-container">

            <!-- Form Card -->
            <div class="admin-form-card">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="admin-book-form">
                    @csrf

                    <!-- Form Grid -->
                    <div class="admin-form-grid">

                        <!-- Left Column: Cover Upload -->
                        <div class="admin-form-column admin-form-upload-column">
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Cover Buku</h3>
                                <p class="admin-form-section-subtitle">Upload gambar cover buku (opsional)</p>

                                <div class="admin-upload-wrapper">
                                    <div class="admin-upload-area" id="uploadArea">
                                        <input
                                            type="file"
                                            name="cover"
                                            id="coverInput"
                                            class="admin-upload-input"
                                            accept="image/jpeg,image/jpg,image/png"
                                        >

                                        <div class="admin-upload-placeholder" id="uploadPlaceholder">
                                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="48" height="48" rx="24" fill="#E0F2FE"/>
                                                <path d="M24 18V30M18 24H30" stroke="#0088FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="admin-upload-text">Klik atau drag file kesini</p>
                                            <p class="admin-upload-hint">JPG, JPEG, PNG (Max. 2MB)</p>
                                        </div>

                                        <div class="admin-upload-preview" id="uploadPreview" style="display: none;">
                                            <img src="" alt="Preview" id="previewImage">
                                            <button type="button" class="admin-upload-remove" id="removeImage">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    @error('cover')
                                        <p class="admin-form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Form Fields -->
                        <div class="admin-form-column admin-form-fields-column">

                            <!-- Basic Information Section -->
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Informasi Dasar</h3>

                                <!-- Title -->
                                <div class="admin-form-group">
                                    <label for="title" class="admin-form-label">
                                        Judul Buku <span class="admin-form-required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="admin-form-input @error('title') admin-form-input-error @enderror"
                                        value="{{ old('title') }}"
                                        placeholder="Masukkan judul buku"
                                        required
                                    >
                                    @error('title')
                                        <p class="admin-form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Author -->
                                <div class="admin-form-group">
                                    <label for="author" class="admin-form-label">
                                        Penulis <span class="admin-form-required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="author"
                                        id="author"
                                        class="admin-form-input @error('author') admin-form-input-error @enderror"
                                        value="{{ old('author') }}"
                                        placeholder="Masukkan nama penulis"
                                        required
                                    >
                                    @error('author')
                                        <p class="admin-form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category & Year Row -->
                                <div class="admin-form-row">
                                    <!-- Category -->
                                    <div class="admin-form-group">
                                        <label for="category" class="admin-form-label">
                                            Kategori <span class="admin-form-required">*</span>
                                        </label>
                                        <div style="display: flex; gap: 8px;">
                                            <select
                                                name="category"
                                                id="category"
                                                class="admin-form-select @error('category') admin-form-input-error @enderror"
                                                required
                                                style="flex: 1;"
                                            >
                                                <option value="">Pilih Kategori</option>
                                                @foreach(\App\Models\Book::getCategories() as $key => $category)
                                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                                <option value="custom">Tambah Kategori Baru</option>
                                            </select>
                                            <input
                                                type="text"
                                                name="new_category"
                                                id="new_category"
                                                class="admin-form-input"
                                                placeholder="Kategori baru"
                                                style="display: none; flex: 1;"
                                            >
                                        </div>
                                        @error('category')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Year -->
                                    <div class="admin-form-group">
                                        <label for="year" class="admin-form-label">
                                            Tahun Terbit
                                        </label>
                                        <input
                                            type="number"
                                            name="year"
                                            id="year"
                                            class="admin-form-input @error('year') admin-form-input-error @enderror"
                                            value="{{ old('year', date('Y')) }}"
                                            placeholder="2024"
                                            min="1900"
                                            max="{{ date('Y') }}"
                                        >
                                        @error('year')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Publisher & Pages Row -->
                                <div class="admin-form-row">
                                    <!-- Publisher -->
                                    <div class="admin-form-group">
                                        <label for="penerbit" class="admin-form-label">
                                            Penerbit
                                        </label>
                                        <input
                                            type="text"
                                            name="penerbit"
                                            id="penerbit"
                                            class="admin-form-input @error('penerbit') admin-form-input-error @enderror"
                                            value="{{ old('penerbit') }}"
                                            placeholder="Masukkan nama penerbit"
                                        >
                                        @error('penerbit')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Pages -->
                                    <div class="admin-form-group">
                                        <label for="halaman" class="admin-form-label">
                                            Jumlah Halaman
                                        </label>
                                        <input
                                            type="number"
                                            name="halaman"
                                            id="halaman"
                                            class="admin-form-input @error('halaman') admin-form-input-error @enderror"
                                            value="{{ old('halaman') }}"
                                            placeholder="0"
                                            min="1"
                                        >
                                        @error('halaman')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Language -->
                                <div class="admin-form-group">
                                    <label for="bahasa" class="admin-form-label">
                                        Bahasa
                                    </label>
                                    <div style="display: flex; gap: 8px;">
                                        <select
                                            name="bahasa"
                                            id="bahasa"
                                            class="admin-form-select @error('bahasa') admin-form-input-error @enderror"
                                            style="flex: 1;"
                                        >
                                            <option value="">Pilih Bahasa</option>
                                            <option value="Indonesia" {{ old('bahasa') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="Inggris" {{ old('bahasa') == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                                            <option value="Arab" {{ old('bahasa') == 'Arab' ? 'selected' : '' }}>Arab</option>
                                            <option value="Jepang" {{ old('bahasa') == 'Jepang' ? 'selected' : '' }}>Jepang</option>
                                            <option value="Mandarin" {{ old('bahasa') == 'Mandarin' ? 'selected' : '' }}>Mandarin</option>
                                            <option value="custom">Tambah Bahasa Baru</option>
                                        </select>
                                        <input
                                            type="text"
                                            name="new_language"
                                            id="new_language"
                                            class="admin-form-input"
                                            placeholder="Bahasa baru"
                                            style="display: none; flex: 1;"
                                        >
                                    </div>
                                    @error('bahasa')
                                        <p class="admin-form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="admin-form-group">
                                    <label for="description" class="admin-form-label">
                                        Deskripsi
                                    </label>
                                    <textarea
                                        name="description"
                                        id="description"
                                        rows="4"
                                        class="admin-form-textarea @error('description') admin-form-input-error @enderror"
                                        placeholder="Masukkan deskripsi buku (opsional)"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="admin-form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pricing & Stock Section -->
                            <div class="admin-form-section">
                                <h3 class="admin-form-section-title">Harga & Stok</h3>

                                <!-- Price & Stock Row -->
                                <div class="admin-form-row">
                                    <!-- Price -->
                                    <div class="admin-form-group">
                                        <label for="price" class="admin-form-label">
                                            Harga <span class="admin-form-required">*</span>
                                        </label>
                                        <div class="admin-form-input-group">
                                            <span class="admin-form-input-prefix">Rp</span>
                                            <input
                                                type="number"
                                                name="price"
                                                id="price"
                                                class="admin-form-input admin-form-input-with-prefix @error('price') admin-form-input-error @enderror"
                                                value="{{ old('price') }}"
                                                placeholder="0"
                                                min="0"
                                                step="1000"
                                                required
                                            >
                                        </div>
                                        @error('price')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Stock -->
                                    <div class="admin-form-group">
                                        <label for="stock" class="admin-form-label">
                                            Stok <span class="admin-form-required">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            name="stock"
                                            id="stock"
                                            class="admin-form-input @error('stock') admin-form-input-error @enderror"
                                            value="{{ old('stock') }}"
                                            placeholder="0"
                                            min="0"
                                            required
                                        >
                                        @error('stock')
                                            <p class="admin-form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="admin-form-actions">
                        <a href="{{ route('admin.books.index') }}" class="admin-form-btn admin-form-btn-cancel">
                            Batal
                        </a>
                        <a href="{{ route('admin.books.store') }}"><button type="submit" class="admin-form-btn admin-form-btn-submit">

                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Simpan Buku</span>
                        </button></a>

                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        // Image Upload Preview
        const uploadArea = document.getElementById('uploadArea');
        const coverInput = document.getElementById('coverInput');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const uploadPreview = document.getElementById('uploadPreview');
        const previewImage = document.getElementById('previewImage');
        const removeImage = document.getElementById('removeImage');

        // Click to upload
        uploadArea.addEventListener('click', () => {
            coverInput.click();
        });

        // File input change
        coverInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                displayPreview(file);
            }
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');

            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                coverInput.files = e.dataTransfer.files;
                displayPreview(file);
            }
        });

        // Display preview
        function displayPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                uploadPlaceholder.style.display = 'none';
                uploadPreview.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }

        // Remove image
        removeImage.addEventListener('click', (e) => {
            e.stopPropagation();
            coverInput.value = '';
            previewImage.src = '';
            uploadPlaceholder.style.display = 'flex';
            uploadPreview.style.display = 'none';
        });

        // Category - show/hide custom input
        const categorySelect = document.getElementById('category');
        const newCategoryInput = document.getElementById('new_category');

        categorySelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                newCategoryInput.style.display = 'block';
                newCategoryInput.required = true;
                newCategoryInput.focus();
            } else {
                newCategoryInput.style.display = 'none';
                newCategoryInput.required = false;
                newCategoryInput.value = '';
            }
        });

        // Language - show/hide custom input
        const languageSelect = document.getElementById('bahasa');
        const newLanguageInput = document.getElementById('new_language');

        languageSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                newLanguageInput.style.display = 'block';
                newLanguageInput.focus();
            } else {
                newLanguageInput.style.display = 'none';
                newLanguageInput.value = '';
            }
        });
    </script>
    @endpush
</x-admin-layout>
