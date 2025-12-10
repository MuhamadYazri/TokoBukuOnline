<nav class="navbar-desktop" id="navbarDesktop">
    <div class="navbar-desktop-container">
        <!-- Logo/Brand -->
        <a href="{{ route('home') }}" class="navbar-desktop-brand">
            <span>LiterASIK</span>
        </a>

        <!-- Search & Category Wrapper -->
        <div class="navbar-desktop-search-wrapper">
            <!-- Category Dropdown Button -->
            <div class="navbar-desktop-category-dropdown">
                <button class="navbar-desktop-category-btn" id="categoryBtn">
                    <span>Kategori</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6L8 10L12 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div class="navbar-desktop-category-menu" id="categoryMenu">
                    <a href="{{ route('customer.books.index', ['category' => 'pengembangan-diri']) }}" class="navbar-desktop-category-item">Pengembangan Diri</a>
                    <a href="{{ route('customer.books.index', ['category' => 'fiksi']) }}" class="navbar-desktop-category-item">Fiksi</a>
                    <a href="{{ route('customer.books.index', ['category' => 'filosofi']) }}" class="navbar-desktop-category-item">Filosofi</a>
                    <a href="{{ route('customer.books.index', ['category' => 'psikologi']) }}" class="navbar-desktop-category-item">Psikologi</a>
                </div>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('customer.books.index') }}" method="GET" class="navbar-desktop-search-form">
                <div class="navbar-desktop-search-input-wrapper">
                    <svg class="navbar-desktop-search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="#6A7282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 19L14.65 14.65" stroke="#6A7282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        class="navbar-desktop-search-input"
                        placeholder="Cari judul buku, penulis, atau kategori..."
                        value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <!-- Right Actions -->
        <div class="navbar-desktop-actions">
            <!-- Favorites/Collections -->
            <a href="{{ route('customer.collections.index') }}" class="navbar-desktop-icon-btn" title="Koleksi">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.84 4.61C20.3292 4.099 19.7228 3.69365 19.0554 3.41708C18.3879 3.14052 17.6725 2.99817 16.95 2.99817C16.2275 2.99817 15.5121 3.14052 14.8446 3.41708C14.1772 3.69365 13.5708 4.099 13.06 4.61L12 5.67L10.94 4.61C9.9083 3.57831 8.50903 2.99871 7.05 2.99871C5.59096 2.99871 4.19169 3.57831 3.16 4.61C2.1283 5.64169 1.54871 7.04097 1.54871 8.5C1.54871 9.95903 2.1283 11.3583 3.16 12.39L4.22 13.45L12 21.23L19.78 13.45L20.84 12.39C21.351 11.8792 21.7563 11.2728 22.0329 10.6053C22.3095 9.93789 22.4518 9.22248 22.4518 8.5C22.4518 7.77752 22.3095 7.06211 22.0329 6.39467C21.7563 5.72723 21.351 5.12087 20.84 4.61Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>

            <!-- Cart -->
            <a href="{{ route('customer.cart.index') }}" class="navbar-desktop-cart-btn" title="Keranjang">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 18.3333C8.42047 18.3333 9.16667 17.5871 9.16667 16.6667C9.16667 15.7462 8.42047 15 7.5 15C6.57953 15 5.83333 15.7462 5.83333 16.6667C5.83333 17.5871 6.57953 18.3333 7.5 18.3333Z" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16.6667 18.3333C17.5871 18.3333 18.3333 17.5871 18.3333 16.6667C18.3333 15.7462 17.5871 15 16.6667 15C15.7462 15 15 15.7462 15 16.6667C15 17.5871 15.7462 18.3333 16.6667 18.3333Z" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M0.833328 0.833336H4.16666L6.39999 11.9917C6.47615 12.3753 6.68484 12.7199 6.98954 12.9652C7.29424 13.2105 7.6755 13.3408 8.06666 13.3333H16.1667C16.5578 13.3408 16.9391 13.2105 17.2438 12.9652C17.5485 12.7199 17.7572 12.3753 17.8333 11.9917L19.1667 5.00001H5" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                @auth
                    @if(auth()->user()->carts()->count() > 0)
                        <span class="navbar-desktop-cart-badge">{{ auth()->user()->carts()->count() }}</span>
                    @endif
                @endauth
            </a>

            <!-- Profile -->
            @auth
                <div class="navbar-desktop-profile-dropdown">
                    <button class="navbar-desktop-profile-btn" id="profileBtn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="navbar-desktop-profile-menu" id="profileMenu">
                        <div class="navbar-desktop-profile-header">
                            <p class="navbar-desktop-profile-name">{{ auth()->user()->name }}</p>
                            <p class="navbar-desktop-profile-email">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="navbar-desktop-profile-divider"></div>
                        <a href="{{ route('customer.profile.edit') }}" class="navbar-desktop-profile-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10Z" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('customer.orders.index') }}" class="navbar-desktop-profile-item">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3333 2H2.66667C1.93029 2 1.33333 2.59695 1.33333 3.33333V13.3333C1.33333 14.0697 1.93029 14.6667 2.66667 14.6667H13.3333C14.0697 14.6667 14.6667 14.0697 14.6667 13.3333V3.33333C14.6667 2.59695 14.0697 2 13.3333 2Z" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10.6667 1.33334V3.33334" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.33333 1.33334V3.33334" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1.33333 5.33334H14.6667" stroke="#334155" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Pesanan Saya</span>
                        </a>
                        <div class="navbar-desktop-profile-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="navbar-desktop-profile-item navbar-desktop-profile-logout">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H6" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.6667 11.3333L14 8L10.6667 4.66666" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14 8H6" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="navbar-desktop-icon-btn" title="Login">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @endauth
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbarDesktop');
        const categoryBtn = document.getElementById('categoryBtn');
        const categoryMenu = document.getElementById('categoryMenu');
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');

        let lastScrollPosition = 0;

        // Scroll behavior
        document.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY;

            if (window.scrollY > 80) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            if (lastScrollPosition < scrollPosition && scrollPosition > 100) {
                navbar.classList.add('hidden');
            } else {
                navbar.classList.remove('hidden');
            }

            lastScrollPosition = scrollPosition;
        });

        // Category dropdown toggle
        if (categoryBtn && categoryMenu) {
            categoryBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                categoryMenu.classList.toggle('active');
                if (profileMenu) profileMenu.classList.remove('active');
            });
        }

        // Profile dropdown toggle
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('active');
                if (categoryMenu) categoryMenu.classList.remove('active');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (categoryMenu && !categoryBtn.contains(event.target)) {
                categoryMenu.classList.remove('active');
            }
            if (profileMenu && !profileBtn.contains(event.target)) {
                profileMenu.classList.remove('active');
            }
        });
    });
</script>
@endpush
