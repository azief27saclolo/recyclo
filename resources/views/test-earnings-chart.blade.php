<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Earnings Chart API</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .controls {
            margin-bottom: 20px;
        }
        .controls button {
            margin-right: 10px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            background: #517A5B;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .controls button:hover {
            background: #3a5c42;
        }
        .chart-container {
            position: relative;
            height: 400px;
            margin: 20px 0;
        }
        .api-response {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
        }
        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .status.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .status.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Earnings Chart API Test</h1>
        
        <div class="controls">
            <button onclick="testAPI('7d')">Test 7 Days</button>
            <button onclick="testAPI('30d')">Test 30 Days</button>
            <button onclick="testAPI('90d')">Test 90 Days</button>
            <button onclick="testAPI('1y')">Test 1 Year</button>
            <button onclick="testChartRender()">Test Chart Rendering</button>
        </div>

        <div id="status"></div>

        <div class="chart-container">
            <canvas id="testChart"></canvas>
        </div>

        <div id="apiResponse" class="api-response"></div>
    </div>

    <script>
        let testChart = null;

        // Initialize test chart
        function initTestChart() {
            const ctx = document.getElementById('testChart').getContext('2d');
            
            if (testChart) {
                testChart.destroy();
            }
            
            testChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: 'Total Earnings',
                            data: [],
                            borderColor: '#517A5B',
                            backgroundColor: 'rgba(81, 122, 91, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Net Earnings',
                            data: [],
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Commission',
                            data: [],
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Test Earnings Chart',
                            font: { size: 16, weight: 'bold' }
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Test API endpoint
        function testAPI(period) {
            showStatus('Testing API for period: ' + period, 'info');
            
            fetch(`/shop/earnings-chart?period=${period}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);
                document.getElementById('apiResponse').textContent = JSON.stringify(data, null, 2);
                
                if (data.success && data.data) {
                    showStatus('API call successful! Rendering chart...', 'success');
                    renderChart(data.data);
                } else {
                    showStatus('API call returned error: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('API call failed: ' + error.message, 'error');
                document.getElementById('apiResponse').textContent = 'Error: ' + error.message;
            });
        }

        // Render chart with data
        function renderChart(chartData) {
            if (!testChart) {
                initTestChart();
            }

            const labels = chartData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });

            const totalEarnings = chartData.map(item => item.totalEarnings);
            const netEarnings = chartData.map(item => item.netEarnings);
            const commission = chartData.map(item => item.commission);

            testChart.data.labels = labels;
            testChart.data.datasets[0].data = totalEarnings;
            testChart.data.datasets[1].data = netEarnings;
            testChart.data.datasets[2].data = commission;
            
            testChart.update();
            
            showStatus(`Chart updated with ${chartData.length} data points`, 'success');
        }

        // Test chart rendering with sample data
        function testChartRender() {
            showStatus('Testing chart rendering with sample data...', 'info');
            
            const sampleData = [];
            for (let i = 7; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                
                const totalEarnings = Math.random() * 1000 + 100;
                const commission = totalEarnings * 0.1;
                const netEarnings = totalEarnings - commission;
                
                sampleData.push({
                    date: date.toISOString().split('T')[0],
                    totalEarnings: totalEarnings,
                    netEarnings: netEarnings,
                    commission: commission
                });
            }
            
            document.getElementById('apiResponse').textContent = JSON.stringify(sampleData, null, 2);
            renderChart(sampleData);
        }

        // Show status message
        function showStatus(message, type) {
            const statusDiv = document.getElementById('status');
            statusDiv.textContent = message;
            statusDiv.className = 'status ' + type;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initTestChart();
            showStatus('Test page loaded. Click a button to test the API.', 'info');
        });
    </script>
</body>
</html>
