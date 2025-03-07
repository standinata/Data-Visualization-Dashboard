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