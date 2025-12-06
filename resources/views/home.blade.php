<x-app-layout>
    <div class="home-page">
        <!-- Hero Section -->
        <section class="home-hero">
            <div class="home-hero-content-text">
                <h1 class="home-hero-title">Buat Membaca-mu Jadi ASIIIIK!</h1>
                <p class="home-hero-subtitle">Temukan ribuan buku pilihan dari penulis terbaik Indonesia dan dunia!</p>
            </div>
            <button class="home-hero-btn">
                <a href="{{ route('customer.books.index') }}">Lihat Semua Buku ASIIIKK!</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="19" viewBox="0 0 17 19" fill="none">
            <path d="M1.25 9.25003H15.25M15.25 9.25003L8.25 1.25003M15.25 9.25003L8.25 17.25" stroke="#E5F1FF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </button>

            <img src="{{ asset('img/abs-img-hero.svg') }}" class="abs-img-hero" alt="img-books">
        </section>

        <section class="home-categories">
            <div class="home-categories-header-wrapper">
                <div class="header-categories-text-wrapper">
                    <h2 class="home-section-title">Semua Kategori</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="1" viewBox="0 0 100 1" fill="none" preserveAspectRatio="none">
                    <path d="M0.5 0.5H179.5" stroke="black" stroke-opacity="0.7" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="text-detail-categories">Lihat semua kategori yang tersedia</span>
            </div>

            <div class="swiper home-categories-swiper">
                <div class="swiper-wrapper home-categories-scroll">
                    @foreach ($categories as $key => $name)
                    <div class="swiper-slide">
                        <a href="{{ route('customer.books.index', ['category' => $key]) }}" class="home-category-card">
                            <div class="home-category-image">
                            </div>
                            <p class="home-category-name">{{ $name }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none" class="icon-arrow-categories">
                            <path d="M1 0V2H9.59L0 11.59L1.41 13L11 3.41V12H13V0H1Z" fill="#2C2C2C"/>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="wrapper-btn-scroll-categories">
                <button class="home-scroll-btn home-scroll-left categories-prev">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>

                <button class="home-scroll-btn home-scroll-right categories-next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>


        </section>

        <section class="home-trending">
            <div class="home-trending-header-wrapper">
                <div class="header-trending-text-wrapper">
                    <h2 class="home-section-title">Buku Trending</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="1" viewBox="0 0 100 1" fill="none" preserveAspectRatio="none">
                    <path d="M0.5 0.5H179.5" stroke="black" stroke-opacity="0.7" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="text-detail-trending">Buku-buku yang sedang trending</span>
            </div>
            <div class="swiper home-trending-swiper">
                <div class="swiper-wrapper home-trending-scroll">
                    @php
                        $topBooks = $trendingBooks->sortByDesc('total_order')->take(10);
                        $rank = 1;
                    @endphp
                    @foreach ($topBooks as $book)
                    <div class="swiper-slide">
                        <a href="{{ route('customer.books.show', $book) }}" class="home-trending-card">
                            @if($rank <= 3)
                            <div class="home-trending-badge">Top {{ $rank }}</div>
                            @endif
                            <div class="home-trending-image">
                            </div>
                            <div class="home-trending-info">
                                <p class="home-trending-category">{{ $book->getCategoryNameAttribute() }}</p>
                                <h3 class="home-trending-title">{{ $book->title }}</h3>
                                <div class="home-trending-rating">
                                    <span class="home-trending-stars">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                        <g clip-path="url(#clip0_2308_1941)">
                                            <path d="M5.60646 1.11635C5.62778 1.07328 5.66071 1.03703 5.70154 1.01168C5.74237 0.986332 5.78947 0.9729 5.83753 0.9729C5.88558 0.9729 5.93268 0.986332 5.97351 1.01168C6.01434 1.03703 6.04727 1.07328 6.06859 1.11635L7.19229 3.39244C7.26631 3.54225 7.37559 3.67186 7.51073 3.77015C7.64587 3.86843 7.80284 3.93246 7.96817 3.95672L10.4812 4.32448C10.5288 4.33138 10.5735 4.35146 10.6103 4.38246C10.6471 4.41346 10.6745 4.45414 10.6894 4.49989C10.7043 4.54565 10.706 4.59465 10.6945 4.64137C10.683 4.68808 10.6586 4.73064 10.6242 4.76423L8.80681 6.53393C8.68695 6.65072 8.59728 6.7949 8.54551 6.95404C8.49373 7.11318 8.4814 7.28252 8.50959 7.44748L8.93864 9.94782C8.94704 9.99541 8.9419 10.0444 8.9238 10.0892C8.9057 10.134 8.87536 10.1729 8.83626 10.2013C8.79716 10.2297 8.75086 10.2465 8.70264 10.2499C8.65443 10.2532 8.60624 10.2429 8.56358 10.2202L6.31717 9.03913C6.16915 8.96141 6.00447 8.92081 5.83728 8.92081C5.6701 8.92081 5.50542 8.96141 5.3574 9.03913L3.11147 10.2202C3.06882 10.2428 3.0207 10.253 2.97257 10.2495C2.92443 10.2461 2.87823 10.2293 2.8392 10.2009C2.80018 10.1725 2.7699 10.1137 2.75182 10.089C2.73373 10.0443 2.72857 9.99535 2.73691 9.94782L3.16547 7.44796C3.19378 7.28293 3.18151 7.11348 3.12973 6.95424C3.07795 6.795 2.98821 6.65075 2.86825 6.53393L1.05088 4.76471C1.01614 4.73116 0.991525 4.68853 0.979835 4.64168C0.968146 4.59482 0.969851 4.54563 0.984757 4.49969C0.999662 4.45376 1.02717 4.41293 1.06414 4.38187C1.10112 4.35081 1.14607 4.33075 1.19389 4.32399L3.7064 3.95672C3.87191 3.93264 4.0291 3.8687 4.16443 3.77041C4.29976 3.67211 4.40917 3.5424 4.48325 3.39244L5.60646 1.11635Z" fill="#FFD900" stroke="#FFD900" stroke-width="0.972897" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2308_1941">
                                            <rect width="11.6748" height="11.6748" fill="white"/>
                                            </clipPath>
                                        </defs>
                                        </svg>
                                    </span>
                                    <span class="home-trending-rating-value">{{ number_format($book->averageRating(), 1) }}</span>
                                </div>
                                <div class="wrapper-price-sold">
                                    <p class="home-trending-price">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                                <p class="home-trending-sold">{{ $book->total_order ?? 0 }} terjual</p>
                                </div>

                            </div>
                        </a>
                    </div>
                    @php $rank++; @endphp
                    @endforeach
                </div>
            </div>
            <div class="wrapper-btn-scroll-trending">
                <button class="home-scroll-btn home-scroll-left trending-prev">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>

                <button class="home-scroll-btn home-scroll-right trending-next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>

        </section>
        <div class="wrapper-svg-why">
            <svg id="wave" class="svg-home-why" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(249, 249, 249, 1)" offset="0%"></stop><stop stop-color="rgba(249, 249, 249, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,20L30,25C60,30,120,40,180,38.3C240,37,300,23,360,30C420,37,480,63,540,68.3C600,73,660,57,720,43.3C780,30,840,20,900,21.7C960,23,1020,37,1080,46.7C1140,57,1200,63,1260,60C1320,57,1380,43,1440,46.7C1500,50,1560,70,1620,68.3C1680,67,1740,43,1800,35C1860,27,1920,33,1980,35C2040,37,2100,33,2160,36.7C2220,40,2280,50,2340,60C2400,70,2460,80,2520,73.3C2580,67,2640,43,2700,38.3C2760,33,2820,47,2880,58.3C2940,70,3000,80,3060,75C3120,70,3180,50,3240,50C3300,50,3360,70,3420,75C3480,80,3540,70,3600,61.7C3660,53,3720,47,3780,46.7C3840,47,3900,53,3960,55C4020,57,4080,53,4140,58.3C4200,63,4260,77,4290,83.3L4320,90L4320,100L4290,100C4260,100,4200,100,4140,100C4080,100,4020,100,3960,100C3900,100,3840,100,3780,100C3720,100,3660,100,3600,100C3540,100,3480,100,3420,100C3360,100,3300,100,3240,100C3180,100,3120,100,3060,100C3000,100,2940,100,2880,100C2820,100,2760,100,2700,100C2640,100,2580,100,2520,100C2460,100,2400,100,2340,100C2280,100,2220,100,2160,100C2100,100,2040,100,1980,100C1920,100,1860,100,1800,100C1740,100,1680,100,1620,100C1560,100,1500,100,1440,100C1380,100,1320,100,1260,100C1200,100,1140,100,1080,100C1020,100,960,100,900,100C840,100,780,100,720,100C660,100,600,100,540,100C480,100,420,100,360,100C300,100,240,100,180,100C120,100,60,100,30,100L0,100Z"></path></svg>
        </div>

        <section class="home-why">

            <h2 class="home-why-section-title">Kenapa milih <span> LiterASIK</span>?</h2>
            <div class="home-bento-grid">
                <div class="wrapper-bento-card">
                    <div class="home-bento-card home-bento-1">
                        <div class="home-bento-overlay">
                            <h3 class="home-bento-title">Curation LiterASIK</h3>
                            <p class="home-bento-text">Hanya buku yang worth it!</p>
                        </div>
                    </div>
                    <div class="home-bento-card home-bento-2">
                        <div class="home-bento-overlay">
                            <h3 class="home-bento-title">Belanja Anti-ribet</h3>
                            <p class="home-bento-text">Checkout cepat, gak pake lama!</p>
                        </div>
                    </div>
                </div>
                <div class="wrapper-bento-card">
                        <div class="home-bento-card home-bento-3">
                        <div class="home-bento-overlay">
                            <h3 class="home-bento-title">Harga Affordable</h3>
                            <p class="home-bento-text">Ramah dikantong mahasiswa!</p>
                        </div>
                    </div>
                    <div class="home-bento-card home-bento-4">
                        <div class="home-bento-overlay">
                            <h3 class="home-bento-title">Pengiriman Sat-Set</h3>
                            <p class="home-bento-text">Cepat sampai, langsung baca!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="wrapper-svg-why">
            <svg id="wave" class="svg-home-why-2" style="transform:rotate(180deg); transition: 0.3s" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(179, 214, 255, 1)" offset="0%"></stop><stop stop-color="rgba(179, 214, 255, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,20L30,25C60,30,120,40,180,38.3C240,37,300,23,360,30C420,37,480,63,540,68.3C600,73,660,57,720,43.3C780,30,840,20,900,21.7C960,23,1020,37,1080,46.7C1140,57,1200,63,1260,60C1320,57,1380,43,1440,46.7C1500,50,1560,70,1620,68.3C1680,67,1740,43,1800,35C1860,27,1920,33,1980,35C2040,37,2100,33,2160,36.7C2220,40,2280,50,2340,60C2400,70,2460,80,2520,73.3C2580,67,2640,43,2700,38.3C2760,33,2820,47,2880,58.3C2940,70,3000,80,3060,75C3120,70,3180,50,3240,50C3300,50,3360,70,3420,75C3480,80,3540,70,3600,61.7C3660,53,3720,47,3780,46.7C3840,47,3900,53,3960,55C4020,57,4080,53,4140,58.3C4200,63,4260,77,4290,83.3L4320,90L4320,100L4290,100C4260,100,4200,100,4140,100C4080,100,4020,100,3960,100C3900,100,3840,100,3780,100C3720,100,3660,100,3600,100C3540,100,3480,100,3420,100C3360,100,3300,100,3240,100C3180,100,3120,100,3060,100C3000,100,2940,100,2880,100C2820,100,2760,100,2700,100C2640,100,2580,100,2520,100C2460,100,2400,100,2340,100C2280,100,2220,100,2160,100C2100,100,2040,100,1980,100C1920,100,1860,100,1800,100C1740,100,1680,100,1620,100C1560,100,1500,100,1440,100C1380,100,1320,100,1260,100C1200,100,1140,100,1080,100C1020,100,960,100,900,100C840,100,780,100,720,100C660,100,600,100,540,100C480,100,420,100,360,100C300,100,240,100,180,100C120,100,60,100,30,100L0,100Z"></path></svg>
        </div>
        <section class="home-about">
            <div class="home-about-content">
                <div class="wrapper-about-img">
                    <div class="wrapper-home-about-stats">
                        <div class="home-about-stats">
                            <span>LiterASIK</span>
                            <div class="wrapper-about-stat">
                                <div class="home-about-stat">
                                    <svg class="home-about-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none">
                                    <path d="M16.3636 0.409091C15.4555 0.122727 14.4573 0 13.5 0C11.9045 0 10.1864 0.327273 9 1.22727C7.81364 0.327273 6.09545 0 4.5 0C2.90455 0 1.18636 0.327273 0 1.22727V13.2136C0 13.4182 0.204545 13.6227 0.409091 13.6227C0.490909 13.6227 0.531818 13.5818 0.613636 13.5818C1.71818 13.05 3.31364 12.6818 4.5 12.6818C6.09545 12.6818 7.81364 13.0091 9 13.9091C10.1045 13.2136 12.1091 12.6818 13.5 12.6818C14.85 12.6818 16.2409 12.9273 17.3864 13.5409C17.4682 13.5818 17.5091 13.5818 17.5909 13.5818C17.7955 13.5818 18 13.3773 18 13.1727V1.22727C17.5091 0.859091 16.9773 0.613636 16.3636 0.409091ZM16.3636 11.4545C15.4636 11.1682 14.4818 11.0455 13.5 11.0455C12.1091 11.0455 10.1045 11.5773 9 12.2727V2.86364C10.1045 2.16818 12.1091 1.63636 13.5 1.63636C14.4818 1.63636 15.4636 1.75909 16.3636 2.04545V11.4545Z" fill="black" fill-opacity="0.7"/>
                                    </svg>
                                    <div class="home-about-stat-info">
                                        <p class="home-about-stat-label">Total Buku</p>
                                        <p class="home-about-stat-value">{{ $totalBooks }}</p>
                                    </div>
                                </div>
                                <div class="home-about-stat">
                                    <svg class="home-about-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                        <path d="M9 16.49C8.65957 16.83 8.25532 17 7.78723 17C7.31915 17 6.91489 16.83 6.57447 16.49L0.489362 10.4125C0.163121 10.0867 0 9.68646 0 9.21187C0 8.73729 0.163121 8.33708 0.489362 8.01125L7.97872 0.51C8.13475 0.354167 8.31915 0.230208 8.53191 0.138125C8.74468 0.0460417 8.97163 0 9.21277 0H15.2979C15.766 0 16.1667 0.166458 16.5 0.499375C16.8333 0.832292 17 1.2325 17 1.7V7.7775C17 8.01833 16.9539 8.245 16.8617 8.4575C16.7695 8.67 16.6454 8.85417 16.4894 9.01L9 16.49ZM13.1702 5.1C13.5248 5.1 13.8262 4.97604 14.0745 4.72813C14.3227 4.48021 14.4468 4.17917 14.4468 3.825C14.4468 3.47083 14.3227 3.16979 14.0745 2.92188C13.8262 2.67396 13.5248 2.55 13.1702 2.55C12.8156 2.55 12.5142 2.67396 12.266 2.92188C12.0177 3.16979 11.8936 3.47083 11.8936 3.825C11.8936 4.17917 12.0177 4.48021 12.266 4.72813C12.5142 4.97604 12.8156 5.1 13.1702 5.1Z" fill="black" fill-opacity="0.7"/>
                                    </svg>
                                    <div class="home-about-stat-info">
                                        <p class="home-about-stat-label">Buku Terjual</p>
                                        <p class="home-about-stat-value">{{ $totalBooksSold }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <img class="svg-about" src="{{ asset('img/svg-about.svg') }}" alt="svg about">
                </div>
                <div class="wrapper-about-text">
                    <h2 class="home-about-title">Tentang <span>LiterASIK</span></h2>
                    <p class="home-about-text"><span>LiterASIK</span> adalah platform jual beli buku online yang <span>memudahkan kamu</span> untuk menemukan dan membeli buku favorit dengan <span>harga terjangkau</span>. Kami hadir untuk membuat membaca jadi lebih <span>ASIIK!</span>.</p>

                </div>

            </div>

        </section>

        <div class="wrapper-svg-about">
            <svg id="wave" class="svg-home-about-2" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(179, 214, 255, 1)" offset="0%"></stop><stop stop-color="rgba(179, 214, 255, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,20L30,25C60,30,120,40,180,38.3C240,37,300,23,360,30C420,37,480,63,540,68.3C600,73,660,57,720,43.3C780,30,840,20,900,21.7C960,23,1020,37,1080,46.7C1140,57,1200,63,1260,60C1320,57,1380,43,1440,46.7C1500,50,1560,70,1620,68.3C1680,67,1740,43,1800,35C1860,27,1920,33,1980,35C2040,37,2100,33,2160,36.7C2220,40,2280,50,2340,60C2400,70,2460,80,2520,73.3C2580,67,2640,43,2700,38.3C2760,33,2820,47,2880,58.3C2940,70,3000,80,3060,75C3120,70,3180,50,3240,50C3300,50,3360,70,3420,75C3480,80,3540,70,3600,61.7C3660,53,3720,47,3780,46.7C3840,47,3900,53,3960,55C4020,57,4080,53,4140,58.3C4200,63,4260,77,4290,83.3L4320,90L4320,100L4290,100C4260,100,4200,100,4140,100C4080,100,4020,100,3960,100C3900,100,3840,100,3780,100C3720,100,3660,100,3600,100C3540,100,3480,100,3420,100C3360,100,3300,100,3240,100C3180,100,3120,100,3060,100C3000,100,2940,100,2880,100C2820,100,2760,100,2700,100C2640,100,2580,100,2520,100C2460,100,2400,100,2340,100C2280,100,2220,100,2160,100C2100,100,2040,100,1980,100C1920,100,1860,100,1800,100C1740,100,1680,100,1620,100C1560,100,1500,100,1440,100C1380,100,1320,100,1260,100C1200,100,1140,100,1080,100C1020,100,960,100,900,100C840,100,780,100,720,100C660,100,600,100,540,100C480,100,420,100,360,100C300,100,240,100,180,100C120,100,60,100,30,100L0,100Z"></path></svg>
        </div>
        <footer class="home-footer">
            <div class="home-footer-header">
                <h3 class="home-footer-logo">LiterASIK</h3>
                <div class="home-footer-social-icons">
                    <a href="#" class="home-footer-social-link" aria-label="Twitter">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#090B0E">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                        </svg>
                    </a>
                    <a href="#" class="home-footer-social-link" aria-label="Instagram">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#090B0E">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" fill="#F9F9F9"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke="#F9F9F9" stroke-width="2"/>
                        </svg>
                    </a>
                    <a href="#" class="home-footer-social-link" aria-label="YouTube">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#090B0E">
                            <path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33z"/>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#F9F9F9"/>
                        </svg>
                    </a>
                    <a href="#" class="home-footer-social-link" aria-label="LinkedIn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#090B0E">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="home-footer-links">
                <div class="home-footer-section">
                    <h4 class="home-footer-section-title">Information</h4>
                    <ul class="home-footer-link-list">
                        <li><a href="{{ route('home') }}" class="home-footer-link">Home</a></li>
                        <li><a href="#" class="home-footer-link">About</a></li>
                        <li><a href="{{ route('customer.books.index') }}" class="home-footer-link">Products</a></li>
                        <li><a href="#" class="home-footer-link">Authors</a></li>
                    </ul>
                </div>

                <div class="home-footer-section">
                    <h4 class="home-footer-section-title">Social</h4>
                    <ul class="home-footer-link-list">
                        <li><a href="#" class="home-footer-link">Youtube</a></li>
                        <li><a href="#" class="home-footer-link">Instagram</a></li>
                        <li><a href="#" class="home-footer-link">Twitter</a></li>
                        <li><a href="#" class="home-footer-link">Whatsapp</a></li>
                        <li><a href="#" class="home-footer-link">Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="home-footer-copyright">
                <p>Built with Love by LiterASIK</p>
            </div>
        </footer>
    </div>

    @push('scripts')
    <script>
        // Initialize Categories Swiper
        const categoriesSwiper = new Swiper('.home-categories-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            speed: 800,
            freeMode: true,
            navigation: {
                nextEl: '.categories-next',
                prevEl: '.categories-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                480: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 10
                },
                1280: {
                    slidesPerView: 6,
                    spaceBetween: 10
                }
            }
        });

        // Initialize Trending Swiper
        const trendingSwiper = new Swiper('.home-trending-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            speed: 800,
            freeMode: true,
            navigation: {
                nextEl: '.trending-next',
                prevEl: '.trending-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.5,
                    spaceBetween: 10
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 10
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
