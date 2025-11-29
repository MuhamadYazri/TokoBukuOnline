
<div class="navbar">
    <div class="navbar-top">
        <button class="hamburger-menu" onclick="toggleAdminSidebar()">
        <svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H24V2.4H0V0ZM0 6.8H24V9.2H0V6.8ZM0 13.6H24V16H0V13.6Z" fill="#EFEFEF"/>
                </svg>
    </button>
    <a class="brand-name" href="dashboard">
            <span >LiterASIK</span>

            {{-- <img class="brand-image" src="{{ asset('img/brand-logo.png') }}" alt=""> --}}
        </a>

    <!-- Sidebar Overlay for Mobile -->
    <!-- Mobile Toggle Button -->

    </div>

</div>

<div class="admin-sidebar-overlay" onclick="toggleAdminSidebar()"></div>

<!-- Admin Sidebar Component -->
<x-side-bar-admin></x-side-bar-admin>

@push('scripts')
<script>
    // Toggle Admin Sidebar for Mobile
    function toggleAdminSidebar() {
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('.admin-sidebar-overlay');

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Show/Hide mobile toggle based on screen size
    function handleMobileToggle() {
        const mobileToggle = document.querySelector('.admin-mobile-toggle');
        if (window.innerWidth <= 768) {
            mobileToggle.style.display = 'flex';
        } else {
            mobileToggle.style.display = 'none';
            // Remove active classes when resizing to desktop
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.admin-sidebar-overlay');
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', handleMobileToggle);

    // Run on resize
    window.addEventListener('resize', handleMobileToggle);

    // Close sidebar when clicking on a link (mobile)
    document.querySelectorAll('.admin-sidebar-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                toggleAdminSidebar();
            }
        });
    });

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
