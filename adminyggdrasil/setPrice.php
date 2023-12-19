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
$pricePerSlice = $_POST['PricePerSlice'];

// Insert data into the MySQL database
$sql = "INSERT INTO PizzaBot (PricePerSlice) VALUES ('$pricePerSlice')";

if ($conn->query($sql) === TRUE) {
    echo "Changes submitted successfully";
	header("Refresh:0");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

?>
