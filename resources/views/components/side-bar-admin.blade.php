<aside class="admin-sidebar">
    <div class="admin-sidebar-content">
        <!-- Brand / Logo Section -->
        <div class="admin-sidebar-header">
            <div class="admin-sidebar-brand">

                <span class="admin-sidebar-brand-text">LiterASIK Admin</span>
            </div>

            <!-- Mobile Close Button -->
            <button class="admin-sidebar-close" onclick="toggleAdminSidebar()">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="admin-sidebar-nav">
            <ul class="admin-sidebar-menu">
                <!-- Dashboard -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.25 15.75V9.75C11.25 9.55109 11.171 9.36032 11.0303 9.21967C10.8897 9.07902 10.6989 9 10.5 9H7.5C7.30109 9 7.11032 9.07902 6.96967 9.21967C6.82902 9.36032 6.75 9.55109 6.75 9.75V15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2.25 7.50012C2.24995 7.28192 2.2975 7.06633 2.38934 6.8684C2.48118 6.67047 2.6151 6.49496 2.78175 6.35412L8.03175 1.85412C8.30249 1.6253 8.64552 1.49976 9 1.49976C9.35448 1.49976 9.69751 1.6253 9.96825 1.85412L15.2183 6.35412C15.3849 6.49496 15.5188 6.67047 15.6107 6.8684C15.7025 7.06633 15.7501 7.28192 15.75 7.50012V14.2501C15.75 14.6479 15.592 15.0295 15.3107 15.3108C15.0294 15.5921 14.6478 15.7501 14.25 15.7501H3.75C3.35218 15.7501 2.97064 15.5921 2.68934 15.3108C2.40804 15.0295 2.25 14.6479 2.25 14.2501V7.50012Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Dashboard</span>
                    </a>
                </li>

                <!-- Books Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.books.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 14.625V3.375C3 2.87772 3.19754 2.40081 3.54917 2.04917C3.90081 1.69754 4.37772 1.5 4.875 1.5H14.25C14.4489 1.5 14.6397 1.57902 14.7803 1.71967C14.921 1.86032 15 2.05109 15 2.25V15.75C15 15.9489 14.921 16.1397 14.7803 16.2803C14.6397 16.421 14.4489 16.5 14.25 16.5H4.875C4.37772 16.5 3.90081 16.3025 3.54917 15.9508C3.19754 15.5992 3 15.1223 3 14.625ZM3 14.625C3 14.1277 3.19754 13.6508 3.54917 13.2992C3.90081 12.9475 4.37772 12.75 4.875 12.75H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Buku</span>
                    </a>
                </li>
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.customers.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15.75V14.25C12 13.4544 11.6839 12.6913 11.1213 12.1287C10.5587 11.5661 9.79565 11.25 9 11.25H4.5C3.70435 11.25 2.94129 11.5661 2.37868 12.1287C1.81607 12.6913 1.5 13.4544 1.5 14.25V15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 2.34595C12.6433 2.51272 13.213 2.8884 13.6198 3.41399C14.0265 3.93959 14.2471 4.58536 14.2471 5.24995C14.2471 5.91453 14.0265 6.5603 13.6198 7.0859C13.213 7.6115 12.6433 7.98717 12 8.15395" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16.5 15.7499V14.2499C16.4995 13.5852 16.2783 12.9395 15.871 12.4141C15.4638 11.8888 14.8936 11.5136 14.25 11.3474" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Pengguna</span>
                    </a>
                </li>

                <!-- Orders Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_2427_337)">
                            <mask id="mask0_2427_337" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                            <path d="M18 0H0V18H18V0Z" fill="currentColor"/>
                            </mask>
                            <g mask="url(#mask0_2427_337)">
                            <path d="M6 16.5C6.41421 16.5 6.75 16.1642 6.75 15.75C6.75 15.3358 6.41421 15 6 15C5.58579 15 5.25 15.3358 5.25 15.75C5.25 16.1642 5.58579 16.5 6 16.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.25 16.5C14.6642 16.5 15 16.1642 15 15.75C15 15.3358 14.6642 15 14.25 15C13.8358 15 13.5 15.3358 13.5 15.75C13.5 16.1642 13.8358 16.5 14.25 16.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.5376 1.5376H3.0376L5.0326 10.8526C5.10578 11.1937 5.2956 11.4987 5.56938 11.715C5.84316 11.9313 6.18378 12.0454 6.5326 12.0376H13.8676C14.209 12.037 14.54 11.9201 14.8059 11.706C15.0718 11.4919 15.2567 11.1935 15.3301 10.8601L16.5676 5.2876H3.8401" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </g>
                        <defs>
                            <clipPath id="clip0_2427_337">
                            <rect width="20" height="20" fill="white"/>
                            </clipPath>
                        </defs>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Pesanan</span>
                    </a>
                </li>

                <div class="admin-sidebar-divider"></div>

                <!-- Settings -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('customer.profile.edit') }}" class="admin-sidebar-link {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2C10.5523 2 11 2.44772 11 3V4.06189C11.6619 4.18237 12.2924 4.41253 12.8677 4.73603L13.6161 3.98765C14.0066 3.59713 14.6398 3.59713 15.0303 3.98765C15.4208 4.37818 15.4208 5.01134 15.0303 5.40187L14.282 6.15025C14.6055 6.72554 14.8356 7.35608 14.9561 8.01799H16C16.5523 8.01799 17 8.46571 17 9.01799C17 9.57028 16.5523 10.018 16 10.018H14.9561C14.8356 10.6799 14.6055 11.3104 14.282 11.8857L15.0303 12.6341C15.4208 13.0246 15.4208 13.6578 15.0303 14.0483C14.6398 14.4388 14.0066 14.4388 13.6161 14.0483L12.8677 13.2999C12.2924 13.6234 11.6619 13.8536 11 13.9741V15C11 15.5523 10.5523 16 10 16C9.44772 16 9 15.5523 9 15V13.9741C8.33808 13.8536 7.70754 13.6234 7.13225 13.2999L6.38388 14.0483C5.99335 14.4388 5.36019 14.4388 4.96967 14.0483C4.57914 13.6578 4.57914 13.0246 4.96967 12.6341L5.71804 11.8857C5.39454 11.3104 5.16438 10.6799 5.0439 10.018H4C3.44772 10.018 3 9.57028 3 9.01799C3 8.46571 3.44772 8.01799 4 8.01799H5.0439C5.16438 7.35608 5.39454 6.72554 5.71804 6.15025L4.96967 5.40187C4.57914 5.01134 4.57914 4.37818 4.96967 3.98765C5.36019 3.59713 5.99335 3.59713 6.38388 3.98765L7.13225 4.73603C7.70754 4.41253 8.33808 4.18237 9 4.06189V3C9 2.44772 9.44772 2 10 2Z" fill="currentColor" opacity="0.3"/>
                            <circle cx="10" cy="9" r="2" fill="currentColor"/>
                        </svg>
                        <span class="admin-sidebar-text">Pengaturan</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="admin-sidebar-menu-item">
                    <form method="POST" action="{{ route('logout') }}" class="admin-sidebar-form">
                        @csrf
                        <button type="submit" class="admin-sidebar-link admin-sidebar-logout">
                            <svg class="admin-sidebar-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 4L17 8M17 8L13 12M17 8H7M7 3H6C4.89543 3 4 3.89543 4 5V15C4 16.1046 4.89543 17 6 17H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="admin-sidebar-text">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- User Profile Section -->
        <div class="admin-sidebar-footer">
            <div class="admin-sidebar-user">
                <div class="admin-sidebar-avatar">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="16" fill="#E0F2FE"/>
                        <path d="M16 16C18.2091 16 20 14.2091 20 12C20 9.79086 18.2091 8 16 8C13.7909 8 12 9.79086 12 12C12 14.2091 13.7909 16 16 16Z" fill="#0088FF"/>
                        <path d="M23 24C23 20.134 19.866 17 16 17C12.134 17 9 20.134 9 24H23Z" fill="#0088FF"/>
                    </svg>
                </div>
                <div class="admin-sidebar-user-info">
                    <p class="admin-sidebar-user-name">{{ Auth::user()->name }}</p>
                    <p class="admin-sidebar-user-role">Administrator</p>
                </div>
            </div>
        </div>
    </div>
</aside>
