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
            <option value="riley_park">Riley Park</option>
        </select>
        <canvas id="downtown-chart"></canvas>
    </div>

    <div class="chart-container">
        <select class="area-selector" data-chart="arbutus">
            <option value="downtown">Downtown</option>
            <option value="arbutus_ridge" selected>Arbutus Ridge</option>
            <option value="riley_park">Riley Park</option>
        </select>
        <canvas id="arbutus-chart"></canvas>
    </div>
</div>

<!-- JavaScript for Charts -->
<script>
window.onload = function() {
    // Pass PHP data to JavaScript
    const data = <?php echo json_encode($array); ?>;

    // Check if data loaded correctly
    console.log(data); // Debug: View the data in the console

    if (!data || !data.labels || !data.downtown || !data.arbutus_ridge || !data.riley_park || !data.vancouver) {
        console.error("Data is missing or not loaded properly:", data);
        return;
    }

    const labels = data.labels;

    // Common chart options with fixed Y-axis range and step size
    const commonOptions = {
        scales: {
            y: {
                beginAtZero: true,
                min: 0,  // Set the minimum value to 0
                max: 50, // Set the maximum value to 50
                stepSize: 5, // Set the step size for intervals
            }
        }
    };

    // Downtown chart
    const downtownCtx = document.getElementById('downtown-chart').getContext('2d');
        const downtownChart = new Chart(downtownCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Vancouver",  // Dataset for Vancouver
                        data: data.vancouver,  // Data sourced from JSON
                        borderColor: 'rgba(0, 200, 0, 1)',  // Line color for Vancouver
                        backgroundColor: 'rgba(0, 200, 0, 0)',
                        fill: true,  // This makes the area under the line filled
                        tension: 0.4  // Smoothing of the line
                    },
                    {
                        label: 'Downtown',
                        data: data.downtown,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
        options: commonOptions
    });


// Arbutus Ridge chart
const arbutusCtx = document.getElementById('arbutus-chart').getContext('2d');
const arbutusChart = new Chart(arbutusCtx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: "Vancouver",  // Adding Vancouver dataset
                data: data.vancouver,  // Data sourced from JSON for Vancouver
                borderColor: 'rgba(0, 200, 0, 1)',  // Line color for Vancouver
                backgroundColor: 'rgba(0, 200, 0, 0)',
                fill: true,  // This makes the area under the line filled
                tension: 0.4  // Smoothing of the line
            },
            {
                label: 'Arbutus Ridge',
                data: data.arbutus_ridge,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: commonOptions
});


    // Function to capitalize the first letter of a string
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).replace('_', ' ');
    }

    // Function to update chart data
    function updateChart(chart, selectedArea) {
        // Update the chart data and label based on the selected area
        chart.data.datasets[1].data = data[selectedArea];
        chart.data.datasets[1].label = capitalizeFirstLetter(selectedArea); // Capitalize the first letter and update label
        chart.update(); // Re-render the chart with new data
    }

    // Attach event listeners to both dropdowns
    document.querySelectorAll('.area-selector').forEach(select => {
        select.addEventListener('change', function() {
            const selectedArea = this.value; // Get selected area from dropdown
            const chartType = this.getAttribute('data-chart'); // Get the chart type (downtown or arbutus)

            if (chartType === "downtown") {
                updateChart(downtownChart, selectedArea); // Update the Downtown chart
            } else if (chartType === "arbutus") {
                updateChart(arbutusChart, selectedArea); // Update the Arbutus Ridge chart
            }
        });
    });
};


</script>

<!-- Conclusion -->
<div>
    <h3>Area that needs improvement</h3>
</div>

<div class="conclusion-wrap">
    <div class="conclusion">
    <p>AAAAAAAA</p>
    </div>
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
