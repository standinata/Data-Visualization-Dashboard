<?php

$json = file_get_contents('data.json'); // get the external file
$array = json_decode($json, true); // transform JSON format into an Array in PHP

$id = $_GET["id"]; // getting the ID from the URL
if ($id == false) { $id = 0; } // default value for id parameter

?>



<!DOCTYPE html>
<html>
<head>
	<title>PHP Template - Project 02, INTD 210, 2025</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>


<body style="font-family:sans-serif">

<!-- Title div -->
<div>
<h1>Which area spends more of their income on housing rent?</h1>
</div>

<!-- Compare 2 areas -->
<div>
<h3>Compare 2 areas all around Vancouver over the course of 15 years</h3>
</div>

<!-- Insert PHP + JavaScript to Generate Graphs -->
<script>
    // Pass PHP data to JavaScript
    const data = <?php echo json_encode($array); ?>;
    
    // Extract labels dynamically from the JSON file
    const labels = data.labels;

    // Setup for Downtown chart
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
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Setup for Arbutus Ridge chart
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
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Event listener for Downtown dropdown
    document.getElementById('downtown-selector').addEventListener('change', function () {
        const selectedArea = this.value;
        if (selectedArea === 'downtown') {
            downtownChart.data.datasets[0].data = data.downtown;
            downtownChart.data.datasets[0].borderColor = 'rgba(54, 162, 235, 1)';
            downtownChart.data.datasets[0].backgroundColor = 'rgba(54, 162, 235, 0)';
        } else if (selectedArea === 'arbutus_ridge') {
            downtownChart.data.datasets[0].data = data.arbutus_ridge;
            downtownChart.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
            downtownChart.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0)';
        }
        downtownChart.update();
    });

    // Event listener for Arbutus Ridge dropdown
    document.getElementById('arbutus-selector').addEventListener('change', function () {
        const selectedArea = this.value;
        if (selectedArea === 'downtown') {
            arbutusChart.data.datasets[0].data = data.downtown;
            arbutusChart.data.datasets[0].borderColor = 'rgba(54, 162, 235, 1)';
            arbutusChart.data.datasets[0].backgroundColor = 'rgba(54, 162, 235, 0)';
            arbutusChart.data.datasets[0].label = 'Downtown Data';
        } else if (selectedArea === 'arbutus_ridge') {
            arbutusChart.data.datasets[0].data = data.arbutus_ridge;
            arbutusChart.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
            arbutusChart.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0)';
            arbutusChart.data.datasets[0].label = 'Arbutus Ridge Data';
        }
        arbutusChart.update();
    });
</script>


<!-- Conclusion -->
<div>
<h3>Area that needs improvement</h3>
</div>





<div><pre><?php // for debugging /////////////////////////
// var_dump($_GET);	// uncomment this if needed
// var_dump($id);		// uncomment this if needed
// var_dump($json);  // uncomment this if needed for debugging
// var_dump($array); // uncomment this if needed for debugging
// you can also look at the terminal on the server with the commands:
// tail -F /var/log/apache2/error.log
// tail -F /var/log/apache2/access.log
?></pre></div>
</body>
</html>