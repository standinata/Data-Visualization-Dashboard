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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Template - Project 02, INTD 210, 2025</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

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
            <option value="riley_park">Riley Park</option>
        </select>
        <canvas id="downtown-chart"></canvas>
        <span id="downtown-trend" class="trend-pill"></span>
    </div>

    <div class="chart-container">
        <select class="area-selector" data-chart="arbutus">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge" selected>Arbutus Ridge</option>
            <option value="riley_park">Riley Park</option>
        </select>
        <canvas id="arbutus-chart"></canvas>
        <span id="arbutus-trend" class="trend-pill"></span>
    </div>
</div>

<!-- Conclusion -->
<div>
    <h3>Area that needs improvement</h3>
</div>
<div class="conclusion-wrap">
    <div class="conclusion">
        <p id="conclusion-text">Loading...</p>
    </div>
</div>

<!-- JavaScript for Charts -->
<script>
window.onload = function() {
    const data = <?php echo json_encode($array); ?>;
    const labels = data.labels;

    // Manually set the trend changes for the areas based on the given percentages
    const trendChanges = {
        downtown: -2,   // Downtown: decrease of 2%
        riley_park: -3, // Riley Park: decrease of 3%
        arbutus_ridge: 11 // Arbutus: increase of 11%
    };

    // Function to calculate the trend change dynamically
    function calculateTrend(area) {
        return trendChanges[area] || 0;  // Default to 0% if not defined
    }

    // Function to update the trend pill with the correct percentage change
    function updateTrendPill(area, pillId) {
        const trendValue = calculateTrend(area);
        const trendPill = document.getElementById(pillId);
        trendPill.textContent = trendValue > 0 ? `+${trendValue}% increase` : `${trendValue}% decrease`;
        trendPill.className = "trend-pill " + (trendValue > 0 ? "green" : "red");
    }

    // Function to update the conclusion based on the trend of two areas
    function updateConclusion(area1, area2) {
        const trend1 = calculateTrend(area1);
        const trend2 = calculateTrend(area2);
        let conclusionText = "";
        if (trend1 > trend2) {
            conclusionText = `${area1.replace('_', ' ')} needs more improvement.`;
        } else if (trend2 > trend1) {
            conclusionText = `${area2.replace('_', ' ')} needs more improvement.`;
        } else {
            conclusionText = "Both areas show similar trends.";
        }
        document.getElementById("conclusion-text").textContent = conclusionText;
    }

    // Function to create the chart for an area
    function createChart(ctx, area, trendPillId) {
        updateTrendPill(area, trendPillId);
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: "Vancouver", data: data.vancouver, borderColor: 'rgba(0, 200, 0, 1)', backgroundColor: 'rgba(0, 200, 0, 0)', fill: true, tension: 0.4 },
                    { label: area.replace('_', ' '), data: data[area], borderColor: 'rgba(54, 162, 235, 1)', backgroundColor: 'rgba(255, 255, 255, 0)', fill: true, tension: 0.4 }
                ]
            },
            options: { scales: { y: { beginAtZero: true, min: 0, max: 50, stepSize: 5 } } }
        });
    }

    const downtownCtx = document.getElementById('downtown-chart').getContext('2d');
    let downtownChart = createChart(downtownCtx, "downtown", "downtown-trend");

    const arbutusCtx = document.getElementById('arbutus-chart').getContext('2d');
    let arbutusChart = createChart(arbutusCtx, "arbutus_ridge", "arbutus-trend");

    updateConclusion("downtown", "arbutus_ridge");

    // Function to update a chart when an area is selected
    function updateChart(chart, area, trendPillId) {
        chart.data.datasets[1].data = data[area];
        chart.data.datasets[1].label = area.replace('_', ' ');
        chart.update();
        updateTrendPill(area, trendPillId);
    }

    // Event listener for the area selectors
    document.querySelectorAll('.area-selector').forEach(select => {
        select.addEventListener('change', function() {
            const selectedArea = this.value;
            const chartType = this.getAttribute('data-chart');
            if (chartType === "downtown") {
                updateChart(downtownChart, selectedArea, "downtown-trend");
            } else if (chartType === "arbutus") {
                updateChart(arbutusChart, selectedArea, "arbutus-trend");
            }
            const otherChart = chartType === "downtown" ? document.querySelector("[data-chart='arbutus']").value : document.querySelector("[data-chart='downtown']").value;
            updateConclusion(selectedArea, otherChart);
        });
    });
};
</script>


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
