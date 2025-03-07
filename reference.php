<?php
// Sample data for Downtown, Kitsilano, and Vancouver City
$data = [
    'downtown' => [
        'area1' => [10, 20, 30, 40, 50],
        'area2' => [15, 25, 35, 45, 55],
        'area3' => [20, 30, 40, 50, 60],
    ],
    'kitsilano' => [
        'area1' => [5, 15, 25, 35, 45],
        'area2' => [10, 20, 30, 40, 50],
        'area3' => [15, 25, 35, 45, 55],
    ],
    'vancouver_city' => [
        'area1' => [12, 22, 32, 42, 52],
        'area2' => [18, 28, 38, 48, 58],
        'area3' => [22, 32, 42, 52, 62],
    ],
];

// Fetch the area from GET or set default
$selected_area = isset($_GET['area']) ? $_GET['area'] : 'area1';

// Get the data based on selection
$downtown_data = $data['downtown'][$selected_area];
$kitsilano_data = $data['kitsilano'][$selected_area];
$vancouver_city_data = $data['vancouver_city'][$selected_area];

// Encode the data as JSON to pass to JavaScript
$downtown_json = json_encode($downtown_data);
$kitsilano_json = json_encode($kitsilano_data);
$vancouver_city_json = json_encode($vancouver_city_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Graphs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Choose an Area</h1>

    <!-- Dropdown to choose area -->
    <form method="GET">
        <select name="area" onchange="this.form.submit()">
            <option value="area1" <?php echo ($selected_area == 'area1') ? 'selected' : ''; ?>>Area 1</option>
            <option value="area2" <?php echo ($selected_area == 'area2') ? 'selected' : ''; ?>>Area 2</option>
            <option value="area3" <?php echo ($selected_area == 'area3') ? 'selected' : ''; ?>>Area 3</option>
        </select>
    </form>

    <h2>Downtown</h2>
    <canvas id="downtownChart" width="400" height="200"></canvas>
    
    <h2>Kitsilano</h2>
    <canvas id="kitsilanoChart" width="400" height="200"></canvas>

    <script>
        // Get data from PHP (already encoded as JSON)
        const downtownData = <?php echo $downtown_json; ?>;
        const kitsilanoData = <?php echo $kitsilano_json; ?>;
        const vancouverCityData = <?php echo $vancouver_city_json; ?>;

        // Create Downtown Chart
        const ctxDowntown = document.getElementById('downtownChart').getContext('2d');
        new Chart(ctxDowntown, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // Example months
                datasets: [{
                    label: 'Downtown Data',
                    data: downtownData,
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false
                }, {
                    label: 'Vancouver City',
                    data: vancouverCityData,
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false
                }]
            }
        });

        // Create Kitsilano Chart
        const ctxKitsilano = document.getElementById('kitsilanoChart').getContext('2d');
        new Chart(ctxKitsilano, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // Example months
                datasets: [{
                    label: 'Kitsilano Data',
                    data: kitsilanoData,
                    borderColor: 'rgb(153, 102, 255)',
                    fill: false
                }]
            }
        });
    </script>
</body>
</html>
