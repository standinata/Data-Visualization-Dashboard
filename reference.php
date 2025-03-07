<?php
// JSON data for Downtown and Arbutus Ridge
$data = [
    'downtown' => [46, 48, 46, 44], // 2001 to 2016 for Downtown
    'arbutus_ridge' => [34, 36, 43, 45, 39.5], // Values for Arbutus Ridge
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph Layout</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .chart-container {
            width: 45%;
            height: 400px;
        }
        select {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Downtown Chart Container -->
    <div class="chart-container">
        <h3>Downtown Data</h3>
        <select id="downtown-selector">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge">Arbutus Ridge</option>
        </select>
        <canvas id="downtown-chart"></canvas>
    </div>

    <!-- Arbutus Ridge Chart Container -->
    <div class="chart-container">
        <h3>Arbutus Ridge Data</h3>
        <select id="arbutus-selector">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge">Arbutus Ridge</option>
        </select>
        <canvas id="arbutus-chart"></canvas>
    </div>

    <script>
        // PHP Data passed as JSON
        const data = <?php echo json_encode($data); ?>;
        
        // Labels for the x-axis (years or time periods)
        const labels = ['2001', '2002', '2003', '2004']; // Example years for both areas

        // Setup for Downtown chart
        const downtownCtx = document.getElementById('downtown-chart').getContext('2d');
        const downtownChart = new Chart(downtownCtx, {
            type: 'line', // Line chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Downtown Data',
                    data: data.downtown, // Default data
                    borderColor: 'rgba(54, 162, 235, 1)', // Blue line color
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Setup for Arbutus Ridge chart
        const arbutusCtx = document.getElementById('arbutus-chart').getContext('2d');
        const arbutusChart = new Chart(arbutusCtx, {
            type: 'line', // Line chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Arbutus Ridge Data', // Initial label
                    data: data.arbutus_ridge, // Default data
                    borderColor: 'rgba(255, 99, 132, 1)', // Red line color
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Event listener for Downtown dropdown
        document.getElementById('downtown-selector').addEventListener('change', function() {
            const selectedArea = this.value;
            if (selectedArea === 'downtown') {
                downtownChart.data.datasets[0].data = data.downtown; // Update Downtown data
                downtownChart.data.datasets[0].borderColor = 'rgba(54, 162, 235, 1)';
                downtownChart.data.datasets[0].backgroundColor = 'rgba(54, 162, 235, 0.2)';
            } else if (selectedArea === 'arbutus_ridge') {
                downtownChart.data.datasets[0].data = data.arbutus_ridge; // Update to Arbutus Ridge data
                downtownChart.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
                downtownChart.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
            }
            downtownChart.update(); // Redraw the chart
        });

        // Event listener for Arbutus Ridge dropdown
        document.getElementById('arbutus-selector').addEventListener('change', function() {
            const selectedArea = this.value;
            if (selectedArea === 'downtown') {
                arbutusChart.data.datasets[0].data = data.downtown; // Update Downtown data
                arbutusChart.data.datasets[0].borderColor = 'rgba(54, 162, 235, 1)';
                arbutusChart.data.datasets[0].backgroundColor = 'rgba(54, 162, 235, 0.2)';
                arbutusChart.data.datasets[0].label = 'Downtown Data'; // Update legend label
            } else if (selectedArea === 'arbutus_ridge') {
                arbutusChart.data.datasets[0].data = data.arbutus_ridge; // Update Arbutus Ridge data
                arbutusChart.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
                arbutusChart.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
                arbutusChart.data.datasets[0].label = 'Arbutus Ridge Data'; // Update legend label
            }
            arbutusChart.update(); // Redraw the chart
        });
    </script>
</body>
</html>

