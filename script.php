<?php

// Database configuration
$host = "localhost:3306";
$username = "poster";
$password = "aYvk63@41";
$database = "poster";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from the POST request
$name = $_POST['Name'];
$meatSlices = $_POST['MeatSlices'];
$vegetarianSlices = $_POST['VegetarianSlices'];
$veganSlices = $_POST['VeganSlices'];
$priority = $_POST['Priority'];
$totalSlices = "$meatSlices/$vegetarianSlices/$veganSlices";
$totalCost = $_POST['TotalCost'];

// Get the current timestamp
$date = date("Y-m-d H:i:s");

// Insert data into the MySQL database
$sql = "INSERT INTO PizzaBot (Date, Name, MeatSlices, VegetarianSlices, VeganSlices, Priority, TotalSlices, TotalCost) VALUES ('$date', '$name', '$meatSlices', '$vegetarianSlices', '$veganSlices', '$priority', '$totalSlices', '$totalCost')";

if ($conn->query($sql) === TRUE) {
    echo "Order submitted successfully";
	header("Refresh:0");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
