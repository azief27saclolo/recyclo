<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recyclo Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- External CSS file -->
    <link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <x-admin-sidebar activePage="dashboard" />

        <div class="main-content">
            <h1>Dashboard</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p class="stat-value">{{ $users_count }}</p>
                    <p class="stat-label">Registered users</p>
                </div>
                
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <p class="stat-value">{{ $orders_count }}</p>
                    <p class="stat-label">Completed orders</p>
                </div>
                
                <div class="stat-card">
                    <h3>Total Products</h3>
                    <p class="stat-value">{{ $products_count }}</p>
                    <p class="stat-label">Active products</p>
                </div>
                
                <div class="stat-card">
                    <h3>Total Shops</h3>
                    <p class="stat-value">{{ $shops_count }}</p>
                    <p class="stat-label">Registered shops</p>
                </div>
            </div>

            <!-- Chart Section Container -->
            <div class="chart-container-grid">
                <!-- User Registration Chart Section -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">User Registrations</h5>
                        <div class="chart-filters">
                            <form id="period-form" method="get" action="{{ route('admin.dashboard') }}">
                                <select name="period" id="period-select" class="form-select" onchange="document.getElementById('period-form').submit()">
                                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="userRegistrationChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Orders Chart Section -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Orders Received</h5>
                        <div class="chart-filters">
                            <form id="orders-period-form" method="get" action="{{ route('admin.dashboard') }}">
                                <input type="hidden" name="period" value="{{ $period }}">
                                <select name="orders_period" id="orders-period-select" class="form-select" onchange="document.getElementById('orders-period-form').submit()">
                                    <option value="daily" {{ $orders_period === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ $orders_period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ $orders_period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ $orders_period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="ordersChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Products Listed Chart Section -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Products Listed</h5>
                        <div class="chart-filters">
                            <form id="products-period-form" method="get" action="{{ route('admin.dashboard') }}">
                                <input type="hidden" name="period" value="{{ $period }}">
                                <input type="hidden" name="orders_period" value="{{ $orders_period }}">
                                <select name="products_period" id="products-period-select" class="form-select" onchange="document.getElementById('products-period-form').submit()">
                                    <option value="daily" {{ isset($products_period) && $products_period === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ isset($products_period) && $products_period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ isset($products_period) && $products_period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ isset($products_period) && $products_period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="productsChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Shops Registered Chart Section -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Shops Registered</h5>
                        <div class="chart-filters">
                            <form id="shops-period-form" method="get" action="{{ route('admin.dashboard') }}">
                                <input type="hidden" name="period" value="{{ $period }}">
                                <input type="hidden" name="orders_period" value="{{ $orders_period }}">
                                <input type="hidden" name="products_period" value="{{ isset($products_period) ? $products_period : 'monthly' }}">
                                <select name="shops_period" id="shops-period-select" class="form-select" onchange="document.getElementById('shops-period-form').submit()">
                                    <option value="daily" {{ isset($shops_period) && $shops_period === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ isset($shops_period) && $shops_period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ isset($shops_period) && $shops_period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ isset($shops_period) && $shops_period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="shopsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                        @forelse($recent_activities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon bg-{{ $activity['type'] === 'order' ? 'success' : ($activity['type'] === 'shop' ? 'primary' : ($activity['type'] === 'product' ? 'info' : 'warning')) }}">
                                    <i class="bi {{ $activity['icon'] }}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-header">
                                        <h6>{{ $activity['title'] }}</h6>
                                        <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                    </div>
                                    <p>{{ $activity['description'] }}</p>
                                    <a href="{{ $activity['link'] }}" class="btn-link">View Details</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-activity text-muted" style="font-size: 48px;"></i>
                                <p class="mt-3 text-muted">No recent activities</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Registration Chart
            const userCtx = document.getElementById('userRegistrationChart').getContext('2d');
            const userChartLabels = @json($userData['labels']);
            const userChartData = @json($userData['data']);
            
            new Chart(userCtx, {
                type: 'bar',
                data: {
                    labels: userChartLabels,
                    datasets: [{
                        label: 'New User Registrations',
                        data: userChartData,
                        backgroundColor: 'rgba(81, 122, 91, 0.7)',
                        borderColor: '#517A5B',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Orders Chart
            const orderCtx = document.getElementById('ordersChart').getContext('2d');
            const orderChartLabels = @json($orderData['labels']);
            const orderChartData = @json($orderData['data']);
            
            new Chart(orderCtx, {
                type: 'line',
                data: {
                    labels: orderChartLabels,
                    datasets: [{
                        label: 'Orders Received',
                        data: orderChartData,
                        backgroundColor: 'rgba(25, 135, 84, 0.2)',
                        borderColor: '#198754',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: true,
                        pointBackgroundColor: '#198754',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
            
            // Products Chart
            const productCtx = document.getElementById('productsChart').getContext('2d');
            const productChartLabels = @json($productData['labels']);
            const productChartData = @json($productData['data']);
            
            new Chart(productCtx, {
                type: 'bar',
                data: {
                    labels: productChartLabels,
                    datasets: [{
                        label: 'Products Listed',
                        data: productChartData,
                        backgroundColor: 'rgba(255, 193, 7, 0.6)',
                        borderColor: '#FFC107',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Shops Chart
            const shopCtx = document.getElementById('shopsChart').getContext('2d');
            const shopChartLabels = @json($shopData['labels']);
            const shopChartData = @json($shopData['data']);
            
            new Chart(shopCtx, {
                type: 'line',
                data: {
                    labels: shopChartLabels,
                    datasets: [{
                        label: 'Shops Registered',
                        data: shopChartData,
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
                        borderColor: '#0d6efd',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: true,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Add this style section to make charts display side by side on large screens -->
    <style>
        .chart-container-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        @media (min-width: 992px) {
            .chart-container-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (min-width: 1200px) {
            .chart-container-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .chart-container-grid > div:nth-child(3),
            .chart-container-grid > div:nth-child(4) {
                grid-column: span 1;
            }
        }
    </style>
</body>
</html>
