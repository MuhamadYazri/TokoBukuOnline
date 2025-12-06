<nav class="navbar" id="navbar">
    <div class="navbar-top">
        <a class="brand-name" href="dashboard">
            <span >LiterASIK</span>

            {{-- <img class="brand-image" src="{{ asset('img/brand-logo.png') }}" alt=""> --}}
        </a>

        <div class="navbar-actions">

            <div class="shopping-cart-wrapper">
                <a href="{{ route('customer.cart.index' ) }}" class="cart-link">
                    <svg class="cart-icon" width="20" height="20" viewBox="0 0 20 20" fill="#EFEFEF" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 18.3333C8.42047 18.3333 9.16667 17.5871 9.16667 16.6667C9.16667 15.7462 8.42047 15 7.5 15C6.57953 15 5.83333 15.7462 5.83333 16.6667C5.83333 17.5871 6.57953 18.3333 7.5 18.3333Z" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.6667 18.3333C17.5871 18.3333 18.3333 17.5871 18.3333 16.6667C18.3333 15.7462 17.5871 15 16.6667 15C15.7462 15 15 15.7462 15 16.6667C15 17.5871 15.7462 18.3333 16.6667 18.3333Z" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0.833328 0.833336H4.16666L6.39999 11.9917C6.47615 12.3753 6.68484 12.7199 6.98954 12.9652C7.29424 13.2105 7.6755 13.3408 8.06666 13.3333H16.1667C16.5578 13.3408 16.9391 13.2105 17.2438 12.9652C17.5485 12.7199 17.7572 12.3753 17.8333 11.9917L19.1667 5.00001H5" stroke="#EFEFEF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="cart-badge">{{ auth()->check() ? auth()->user()->carts()->count() : 0 }}</span>
                </a>
            </div>
            <button class="hamburger-menu" onclick="toggleMobileNav()">
                <svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H24V2.4H0V0ZM0 6.8H24V9.2H0V6.8ZM0 13.6H24V16H0V13.6Z" fill="#EFEFEF"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="search-bar">
        <form action="{{ route('customer.books.index') }}" method="GET" class="search-form">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z" stroke="#717182" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 19L14.65 14.65" stroke="#717182" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Cari judul buku, penulis, atau kategori..."
                value="{{ request('search') }}">
        </form>
    </div>

    <div class="nav-mobile" id="navMobile">
        <div class="nav-mobile-item">
            <a href="{{ route('home') }}" class="nav-mobile-link">Beranda</a>
        </div>
        <div class="nav-mobile-item">
            <a href="{{ route('customer.collections.index') }}" class="nav-mobile-link">Koleksi Buku</a>
        </div>
        <div class="nav-mobile-item">
            <a href="{{ route('home') }}" class="nav-mobile-link">Trending</a>
        </div>
        <div class="nav-mobile-item">
            @auth
                <a href="{{ route('customer.profile.edit') }}" class="nav-mobile-link">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 7C8.933 7 10.5 5.433 10.5 3.5C10.5 1.567 8.933 0 7 0C5.067 0 3.5 1.567 3.5 3.5C3.5 5.433 5.067 7 7 7ZM7 8.75C4.66375 8.75 0 9.92125 0 12.25V14H14V12.25C14 9.92125 9.33625 8.75 7 8.75Z" fill="#334155"/>
                    </svg>
                    Akun Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-mobile-link">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 7C8.933 7 10.5 5.433 10.5 3.5C10.5 1.567 8.933 0 7 0C5.067 0 3.5 1.567 3.5 3.5C3.5 5.433 5.067 7 7 7ZM7 8.75C4.66375 8.75 0 9.92125 0 12.25V14H14V12.25C14 9.92125 9.33625 8.75 7 8.75Z" fill="#334155"/>
                    </svg>
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        function toggleMobileNav() {
            const navMobile = document.getElementById('navMobile');
            navMobile.classList.toggle('active');
        }
        const navbar = document.querySelector('.navbar');

        let lastScrollPosition = 0;

        document.addEventListener('scroll', ()=>{
            const scrollPosition = window.scrollY;

            if(window.scrollY > 80){
                navbar.classList.add('scrolled');
                console.log('top');
            }else{
                navbar.classList.remove('scrolled');
                console.log('not-top');
            }

            if(lastScrollPosition < scrollPosition){
                navbar.classList.add('scrollAtas');
                console.log('scroll down');
            }else{
                navbar.classList.remove('scrollAtas');
                console.log('scroll up');
            }


            lastScrollPosition = scrollPosition;
        })

        document.addEventListener('click', function(event) {
            const navMobile = document.getElementById('navMobile');
            const hamburger = document.querySelector('.hamburger-menu');

            if (!navMobile.contains(event.target) && !hamburger.contains(event.target)) {
                navMobile.classList.remove('active');
            }
        });
    </script>

@endpush
