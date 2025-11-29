<x-admin-layout>
    <x-HeaderGradient title="Dashboard Admin" subtitle="Kelola toko buku online Anda">
    </x-HeaderGradient>
    <div class="admin-dashboard-body">

        <div class="admin-dashboard-container">
            <!-- Header with Gradient -->



            <!-- Body Content -->
            <div class="admin-body">
                <!-- Stats Cards Grid -->
                <div class="admin-stats-grid">
                    <!-- Total Pengguna -->
                    <div class="admin-stat-card s-medium">
                        <p class="stat-label">Total Pengguna</p>
                        <p class="stat-value stat-blue">{{ $stats['total_customers'] ?? 0 }}</p>
                    </div>

                    <!-- Total Buku -->
                    <div class="admin-stat-card s-medium">
                        <p class="stat-label">Total Buku</p>
                        <p class="stat-value stat-orange">{{ $stats['total_books'] ?? 0 }}</p>
                    </div>

                    <!-- Transaksi Bulan Ini -->
                    <div class="admin-stat-card s-medium">
                        <p class="stat-label">Transaksi Bulan Ini</p>
                        <p class="stat-value stat-blue">{{ $stats['total_orders'] ?? 0 }}</p>
                    </div>

                    <!-- Pesanan Aktif -->
                    <div class="admin-stat-card s-medium">
                        <p class="stat-label">Pesanan Aktif</p>
                        <p class="stat-value stat-purple">{{ $stats['pending_orders'] ?? 0 }}</p>
                    </div>

                    <!-- Pendapatan -->
                    <div class="admin-stat-card s-medium">
                        <p class="stat-label">Pendapatan</p>
                        <p class="stat-value stat-green">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Chart: Transaksi Bulanan -->
                <div class="admin-chart-card s-medium">
                    <h3 class="chart-title">Transaksi Bulanan</h3>
                    <div class="chart-container">
                        <canvas id="transactionsChart"></canvas>
                    </div>
                </div>

                <!-- Chart: Tren Pendapatan -->
                <div class="admin-chart-card s-medium">
                    <h3 class="chart-title">Tren Pendapatan</h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Table: Buku Terlaris -->
                <div class="admin-table-card s-medium">
                    <h3 class="table-title">Buku Terlaris</h3>
                    <div class="table-wrapper">
                        <table class="bestsellers-table">
                            <thead>
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Judul Buku</th>
                                    <th>Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellingBooks as $index => $item)
                                <tr>
                                    <td>
                                        <div class="rank-badge">{{ $index + 1 }}</div>
                                    </td>
                                    <td>{{ $item->book->title ?? 'N/A' }} <br>
                                    <span>{{ $item->book->author ?? 'N/A' }}</span> </td>
                                    <td class="sold-count">{{ $item->total_sold ?? 0 }} buku</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 20px; color: #666;">
                                        Belum ada data penjualan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
        // Data dari Laravel
        const monthlyTransactions = @json($monthlyTransactions);
        const monthlyRevenue = @json($monthlyRevenue);

        // Helper: Convert month number to Indonesian month name
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Process transaction data
        const transactionLabels = [];
        const transactionData = [];

        // Get last 6 months
        const currentDate = new Date();
        for (let i = 5; i >= 0; i--) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
            const monthIndex = date.getMonth();
            const year = date.getFullYear();

            transactionLabels.push(monthNames[monthIndex]);

            // Find matching data
            const found = monthlyTransactions.find(t => t.month == (monthIndex + 1) && t.year == year);
            transactionData.push(found ? found.total_orders : 0);
        }

        // Process revenue data
        const revenueLabels = [];
        const revenueData = [];

        for (let i = 5; i >= 0; i--) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
            const monthIndex = date.getMonth();
            const year = date.getFullYear();

            revenueLabels.push(monthNames[monthIndex]);

            // Find matching data
            const found = monthlyRevenue.find(r => r.month == (monthIndex + 1) && r.year == year);
            revenueData.push(found ? found.revenue : 0);
        }

        // Chart 1: Transaksi Bulanan (Bar Chart)
        const ctxTransactions = document.getElementById('transactionsChart').getContext('2d');
        new Chart(ctxTransactions, {
            type: 'bar',
            data: {
                labels: transactionLabels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: transactionData,
                    backgroundColor: '#0088FF',
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            padding: 10,
                            font: {
                                size: 12,
                                family: 'Arial'
                            },
                            color: '#0088FF'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 20,
                            color: '#666666',
                            font: {
                                size: 12,
                                family: 'Inter'
                            }
                        },
                        grid: {
                            color: '#E6E6E6'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#666666',
                            font: {
                                size: 12,
                                family: 'Inter'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart 2: Tren Pendapatan (Line Chart)
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueData,
                    borderColor: '#08910A',
                    backgroundColor: 'rgba(8, 145, 10, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#08910A',
                    pointBorderColor: '#08910A',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            padding: 10,
                            font: {
                                size: 12,
                                family: 'Arial'
                            },
                            color: '#08910A'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            },
                            color: '#666666',
                            font: {
                                size: 12,
                                family: 'Poppins'
                            }
                        },
                        grid: {
                            color: '#E6E6E6'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#666666',
                            font: {
                                size: 12,
                                family: 'Inter'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    @endpush

</x-admin-layout>
