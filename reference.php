<?php
// JSON data for Downtown, Arbutus Ridge, and Vancouver
$data = [
    'downtown' => [46, 48, 46, 44], 
    'arbutus_ridge' => [34, 36, 43, 45, 39.5], 
    'vancouver' => [36, 37, 38, 37] // Vancouver is always shown
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
        <select class="area-selector" data-chart="downtown">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge">Arbutus Ridge</option>
        </select>
        <canvas id="downtown-chart"></canvas>
    </div>

    <!-- Arbutus Ridge Chart Container -->
    <div class="chart-container">
        <h3>Arbutus Ridge Data</h3>
        <select class="area-selector" data-chart="arbutus">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge">Arbutus Ridge</option>
        </select>
        <canvas id="arbutus-chart"></canvas>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const jsonData = <?php echo json_encode($data); ?>;
        const labels = ['2001', '2002', '2003', '2004']; 

        // Function to create a chart
        function createChart(ctx, defaultArea) {
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: defaultArea.replace('_', ' ') + " Data",
                            data: jsonData[defaultArea],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: "Vancouver",
                            data: jsonData.Vancouver,
                            borderColor: 'rgba(0, 200, 0, 1)',
                            backgroundColor: 'rgba(0, 200, 0, 0.2)',
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
        }

        // Initialize charts
        const downtownCtx = document.getElementById('downtown-chart').getContext('2d');
        const downtownChart = createChart(downtownCtx, "downtown");

        const arbutusCtx = document.getElementById('arbutus-chart').getContext('2d');
        const arbutusChart = createChart(arbutusCtx, "arbutus_ridge");

        // Function to update charts
        function updateChart(chart, selectedArea) {
            chart.data.datasets[0].data = jsonData[selectedArea];
            chart.data.datasets[0].label = selectedArea.replace('_', ' ') + " Data";
            chart.update();
        }

        // Attach event listeners to both dropdowns
        document.querySelectorAll('.area-selector').forEach(select => {
            select.addEventListener('change', function() {
                const selectedArea = this.value;
                const chartType = this.getAttribute('data-chart');

                if (chartType === "downtown") {
                    updateChart(downtownChart, selectedArea);
                } else if (chartType === "arbutus") {
                    updateChart(arbutusChart, selectedArea);
                }
            });
        });
    </script>
</body>
</html>

