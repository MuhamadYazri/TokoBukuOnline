<x-admin-layout>
    <x-AdminHeaderGradient title="Dashboard" subtitle="Ringkasan statistik dan aktivitas terkini">
    </x-AdminHeaderGradient>
    <div class="dashboard-page">
        <div class="dashboard-container">

            <!-- Export Report Section -->
            <div class="dashboard-export-section">
                <h3 class="dashboard-export-title">Laporan Bulanan</h3>
                <form action="{{ route('admin.reports.export') }}" method="GET" class="dashboard-export-form">
                    <div class="dashboard-export-inputs">
                        <select name="month" class="dashboard-export-select" required>
                            <option value="">Pilih Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" class="dashboard-export-select" required>
                            <option value="">Pilih Tahun</option>
                            @for($year = now()->year; $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ now()->year == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="dashboard-export-btn">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M15.75 11.25V14.25C15.75 14.6478 15.592 15.0294 15.3107 15.3107C15.0294 15.592 14.6478 15.75 14.25 15.75H3.75C3.35218 15.75 2.97064 15.592 2.68934 15.3107C2.40804 15.0294 2.25 14.6478 2.25 14.25V11.25M5.25 7.5L9 11.25M9 11.25L12.75 7.5M9 11.25V2.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Export Excel</span>
                    </button>
                </form>
            </div>

            <!-- Stats Cards Grid -->
            <div class="dashboard-stats-grid">
                <!-- Total Pengguna -->
                <div class="dashboard-stat-card">
                    <p class="dashboard-stat-label">Total Pengguna</p>
                    <p class="dashboard-stat-value dashboard-stat-blue">{{ number_format($stats['total_customers'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <!-- Total Buku -->
                <div class="dashboard-stat-card">
                    <p class="dashboard-stat-label">Total Buku</p>
                    <p class="dashboard-stat-value dashboard-stat-purple">{{ number_format($stats['total_books'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <!-- Total Pesanan -->
                <div class="dashboard-stat-card">
                    <p class="dashboard-stat-label">Total Pesanan</p>
                    <p class="dashboard-stat-value dashboard-stat-green">{{ number_format($stats['total_orders'] ?? 0, 0, ',', '.') }}</p>
                </div>

            </div>

            <!-- Two Column Section -->
            <div class="dashboard-two-columns">
                <!-- Recent Orders -->
                <div class="dashboard-card">
                    <h3 class="dashboard-card-title">Pesanan Terbaru</h3>
                    <div class="dashboard-recent-orders">
                        @php
                            $recentOrders = \App\Models\Order::with('user')->latest()->take(3)->get();
                        @endphp
                        @forelse($recentOrders as $order)
                        <div class="dashboard-order-item {{ !$loop->last ? 'dashboard-order-item-border' : '' }}">
                            <div class="dashboard-order-info">
                                <p class="dashboard-order-id">{{ $order->order_number ?? 'ORD' . str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</p>
                                <p class="dashboard-order-customer">{{ $order->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="dashboard-order-details">
                                <p class="dashboard-order-total">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</p>
                                @php
                                    $statusConfig = [
                                        'pending' => ['label' => 'Menunggu', 'class' => 'dashboard-status-pending'],
                                        'processing' => ['label' => 'Diproses', 'class' => 'dashboard-status-processing'],
                                        'completed' => ['label' => 'Selesai', 'class' => 'dashboard-status-completed'],
                                        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'dashboard-status-cancelled'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['label' => 'Unknown', 'class' => ''];
                                @endphp
                                <span class="dashboard-status-badge {{ $config['class'] }}">{{ $config['label'] }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="dashboard-empty">Belum ada pesanan</p>
                        @endforelse
                    </div>
                </div>

                <!-- Popular Books -->
                <div class="dashboard-card">
                    <h3 class="dashboard-card-title">Buku Terpopuler</h3>
                    <div class="dashboard-popular-books">
                        @forelse($bestSellingBooks->take(3) as $index => $item)
                        <div class="dashboard-book-item {{ !$loop->last ? 'dashboard-book-item-border' : '' }}">
                            <div class="dashboard-book-info">
                                <div class="dashboard-book-rank">{{ $index + 1 }}</div>
                                <div class="dashboard-book-details">
                                    <p class="dashboard-book-title">{{ $item->book->title ?? 'N/A' }}</p>
                                    <p class="dashboard-book-author">{{ $item->book->author ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="dashboard-book-sales">
                                <p class="dashboard-book-sold">{{ $item->total_sold ?? 0 }}</p>
                                <p class="dashboard-book-label">terjual</p>
                            </div>
                        </div>
                        @empty
                        <p class="dashboard-empty">Belum ada data penjualan</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Chart: Penjualan Bulanan -->
            <div class="dashboard-chart-card">
                <h3 class="dashboard-chart-title">Penjualan Bulanan</h3>
                <div class="dashboard-chart-container">
                    <canvas id="transactionsChart"></canvas>
                </div>
                <h3 class="dashboard-chart-title">Tren Pendapatan</h3>
                <div class="dashboard-chart-container">
                    <canvas id="revenueChart"></canvas>
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
