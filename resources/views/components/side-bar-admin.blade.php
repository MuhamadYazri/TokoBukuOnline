<aside class="admin-sidebar">
    <div class="admin-sidebar-content">
        <!-- Brand / Logo Section -->
        <div class="admin-sidebar-header">
            <div class="admin-sidebar-brand">
                <span class="admin-sidebar-brand-text">LiterASIK</span>
            </div>
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

                <!-- Users Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.customers.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 15.75V14.25C12 13.4544 11.6839 12.6913 11.1213 12.1287C10.5587 11.5661 9.79565 11.25 9 11.25H4.5C3.70435 11.25 2.94129 11.5661 2.37868 12.1287C1.81607 12.6913 1.5 13.4544 1.5 14.25V15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Pengguna</span>
                    </a>
                </li>

                <!-- Books Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.books.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 14.625V3.375C3 2.87772 3.19754 2.40081 3.54917 2.04917C3.90081 1.69754 4.37772 1.5 4.875 1.5H14.25C14.4489 1.5 14.6397 1.57902 14.7803 1.71967C14.921 1.86032 15 2.05109 15 2.25V15.75C15 15.9489 14.921 16.1397 14.7803 16.2803C14.6397 16.421 14.4489 16.5 14.25 16.5H4.875C4.37772 16.5 3.90081 16.3025 3.54917 15.9508C3.19754 15.5992 3 15.1223 3 14.625ZM3 14.625C3 14.1277 3.19754 13.6508 3.54917 13.2992C3.90081 12.9475 4.37772 12.75 4.875 12.75H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Buku</span>
                    </a>
                </li>

                <!-- Transactions Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="#" class="admin-sidebar-link">
                        <svg class="admin-sidebar-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.75 11.25H2.25M15.75 11.25C16.1642 11.25 16.5 10.9142 16.5 10.5V3C16.5 2.58579 16.1642 2.25 15.75 2.25H2.25C1.83579 2.25 1.5 2.58579 1.5 3V10.5C1.5 10.9142 1.83579 11.25 2.25 11.25M15.75 11.25V14.25C15.75 14.6642 15.4142 15 15 15H3C2.58579 15 2.25 14.6642 2.25 14.25V11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 8.25C9.82843 8.25 10.5 7.57843 10.5 6.75C10.5 5.92157 9.82843 5.25 9 5.25C8.17157 5.25 7.5 5.92157 7.5 6.75C7.5 7.57843 8.17157 8.25 9 8.25Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Transaksi</span>
                    </a>
                </li>

                <!-- Orders Management -->
                <li class="admin-sidebar-menu-item">
                    <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <svg class="admin-sidebar-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 16.5C6.41421 16.5 6.75 16.1642 6.75 15.75C6.75 15.3358 6.41421 15 6 15C5.58579 15 5.25 15.3358 5.25 15.75C5.25 16.1642 5.58579 16.5 6 16.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14.25 16.5C14.6642 16.5 15 16.1642 15 15.75C15 15.3358 14.6642 15 14.25 15C13.8358 15 13.5 15.3358 13.5 15.75C13.5 16.1642 13.8358 16.5 14.25 16.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1.5376 1.5376H3.0376L5.0326 10.8526C5.10578 11.1937 5.2956 11.4987 5.56938 11.715C5.84316 11.9313 6.18378 12.0454 6.5326 12.0376H13.8676C14.209 12.037 14.54 11.9201 14.8059 11.706C15.0718 11.4919 15.2567 11.1935 15.3301 10.8601L16.5676 5.2876H3.8401" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="admin-sidebar-text">Kelola Pesanan</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Logout Button -->
        <div class="admin-sidebar-logout-wrapper">
            <form method="POST" action="{{ route('logout') }}" class="admin-sidebar-form">
                @csrf
                <button type="submit" class="admin-sidebar-logout-btn">
                    <svg class="admin-sidebar-logout-icon" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 13H3C2.46957 13 1.96086 12.7893 1.58579 12.4142C1.21071 12.0391 1 11.5304 1 11V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H6M11 10L15 7M15 7L11 4M15 7H6" stroke="#FF3B30" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="admin-sidebar-logout-text">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>
