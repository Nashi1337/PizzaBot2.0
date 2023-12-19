<?php

$servername = "localhost:3306";
$username = "poster";
$password = "aYvk63@41";
$dbname = "poster";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the ID parameter from the POST request
$id = $_POST['id'];

// Construct and execute the SQL query
$sql = "DELETE FROM PizzaBot WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

// Close the database connection
$conn->close();
?>