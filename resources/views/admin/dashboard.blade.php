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
    <style>
        :root {
            --hoockers-green: #517A5B;
            --hoockers-green_80: #517A5Bcc;
            --card-shadow: 0 8px 16px rgba(0,0,0,0.1);
            --hover-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        
        body {
            font-family: 'Urbanist', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            color: #2c3e50;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            margin-left: 290px;
            min-height: 100vh;
            width: calc(100% - 290px);
            box-sizing: border-box;
        }

        .main-content h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-card h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
        }

        .stat-card .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--hoockers-green);
            margin: 0;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 14px;
            font-weight: 500;
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .card-header {
            padding: 25px 30px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: transparent;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .card-body {
            padding: 30px;
        }

        .activity-feed {
            padding: 10px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .activity-icon i {
            color: white;
            font-size: 20px;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .activity-header h6 {
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
            margin: 0;
        }

        .activity-content p {
            color: #666;
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .btn-link {
            color: var(--hoockers-green);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            margin-top: 8px;
            display: inline-block;
        }

        .btn-link:hover {
            color: var(--hoockers-green_80);
            text-decoration: underline;
        }

        .text-muted {
            color: #95a5a6 !important;
            font-size: 13px;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .card-header, .card-body {
                padding: 20px;
            }
        }
    </style>
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
</body>
</html>
