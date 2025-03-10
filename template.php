<?php

// Read the JSON file
$json = file_get_contents('data.json');
if ($json === false) {
    die("Error reading JSON file.");
}

// Decode the JSON file
$array = json_decode($json, true);
if ($array === null) {
    die("Error decoding JSON: " . json_last_error_msg());
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Template - Project 02, INTD 210, 2025</title>
	<link rel="stylesheet" type="text/css" href="/style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>

<body style="font-family:sans-serif">

<!-- Title div -->
<div class="title">
    <h1>Which area spends more of their income on housing rent?</h1>
</div>

<!-- Compare 2 areas -->
<div class="description">
    <h3>Compare 2 areas all around Vancouver over the course of 15 years</h3>
</div>

<!-- Canvas elements for charts -->
<div class="chart-wrap">

<div class="chart-container">
<select class="area-selector" data-chart="downtown">
            <option value="downtown" selected>Downtown</option>
            <option value="arbutus_ridge">Arbutus Ridge</option>
        </select>
    <canvas id="downtown-chart"></canvas>
</div>

<div class="chart-container">
<select class="area-selector" data-chart="arbutus">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge" selected>Arbutus Ridge</option>
        </select>
    <canvas id="arbutus-chart"></canvas>
</div>
</div>

<!-- JavaScript for Charts -->
<script>
    window.onload = function() {
        // Pass PHP data to JavaScript
        const data = <?php echo json_encode($array); ?>;

        if (!data || !data.labels || !data.downtown || !data.arbutus_ridge) {
            console.error("Data is missing or not loaded properly:", data);
            return;
        }

        const labels = data.labels;

        // Downtown chart
        const downtownCtx = document.getElementById('downtown-chart').getContext('2d');
        const downtownChart = new Chart(downtownCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Downtown Data',
                    data: data.downtown,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        // Arbutus Ridge chart
        const arbutusCtx = document.getElementById('arbutus-chart').getContext('2d');
        const arbutusChart = new Chart(arbutusCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Arbutus Ridge Data',
                    data: data.arbutus_ridge,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    };

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

<!-- Conclusion -->
<div>
    <h3>Area that needs improvement</h3>
</div>

<!-- Debugging Information -->
<div>
    <pre>
    <?php 
    // Uncomment these for debugging if needed
    // var_dump($_GET);	
    // var_dump($json);  
    // var_dump($array);
    ?>
    </pre>
</div>

</body>
</html>
