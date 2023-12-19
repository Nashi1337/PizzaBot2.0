<?php
$servername = "localhost:3306";
$username = "poster";
$password = "aYvk63@41";
$database = "poster";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to drop the table
$sql = "TRUNCATE TABLE PizzaBot";

if ($conn->query($sql) === TRUE) {
    echo "Table PizzaBot truncateted successfully.";
} else {
    echo "Error trunacteateing table: " . $conn->error;
}

$conn->close();
?>
