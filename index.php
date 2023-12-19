<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pizza Bot</title>
</head>
<body>
    <div class="container" style="display: block;">
        <h1>Pizza Order</h1>
        <form id="pizzaForm">
            <label for="name">Name:</label>
            <input name="Name" type="text" id="name" maxlength="40" onClick="this.select();" required>

            <label for="slices">Number of Meat Slices:</label>
            <input name="MeatSlices" type="number" id="meatSlices" min="0" value="0" onClick="this.select();" required>
			
			<label for="slices">Number of Vegetarian Slices:</label>
            <input name="VegetarianSlices" type="number" id="vegetarianSlices" min="0"  value="0" onClick="this.select();" required>

			<label for="slices">Number of Vegan Slices:</label>
            <input name="VeganSlices" type="number" id="veganSlices" min="0" value="0" onClick="this.select();" required>

			<label for="priority">Priority: <span id="priorityText">Set your priority to category or slice number</span></label>
			<input name="Priority" type="range" id="priority" min="0" max="10" step="1" value="5" oninput="updatePriorityValue(this.value)">
			<div style="display: flex; justify-content: space-between; width: 100%; margin-top: -20px;">
				<label for="priority" style="text-align: left;">Category</label>
				<label for="priority" style="text-align: right;">Number</label>
			</div>

            <button type="button" onclick="submitOrder()" id="submitButton">Submit Order</button>
        </form>
		
		<div id="priceContainer">
		</div>
		
		<br>
		You can pay via PayPal <a href="https://paypal.me/cocksnballs">here</a>
		<label style="font-size:8px;">Please make sure to include your name as it is in the Pizza Order or else we can't know if you paid or not.</label>
    </div>

	<div class="container">
		<table>
			<tr>
				<th>Edit?</th>
				<th>Date</th>
				<th>Name</th>
				<th>Meat Slices</th>
				<th>Vegetarian Slices</th>
				<th>Vegan Slices</th>
				<th>Priority</th>
				<th>Total Slices</th>
				<th>Total Cost</th>
				<th>Paid</th>
			</tr>
			<?php
			$servername = "localhost:3306";
			$username = "poster";
			$password = "aYvk63@41";
			$dbname = "poster";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT ID, DATE_FORMAT(Date, '%Y-%m-%d %H:%i:%s') AS FormattedDate, Name, MeatSlices, VegetarianSlices, VeganSlices, Priority, TotalSlices, TotalCost, Paid FROM PizzaBot";

			$result = $conn->query($sql);

			$totalMeatSlices = 0;
			$totalVegetarianSlices = 0;
			$totalVeganSlices = 0;
			$orders = array();
			
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr>"; // Start a new row for each record
					echo "<td><button class='edit-btn' data-id='" . $row["ID"] . "'>Delete</button></td>";
					echo "<td>" . $row["FormattedDate"] . "</td>";
					echo "<td>" . $row["Name"] . "</td>";
					echo "<td>" . $row["MeatSlices"] . "</td>";
					echo "<td>" . $row["VegetarianSlices"] . "</td>";
					echo "<td>" . $row["VeganSlices"] . "</td>";
					echo "<td>" . $row["Priority"] . "</td>";
					echo "<td>" . $row["TotalSlices"] . "</td>";
					echo "<td>" . $row["TotalCost"] . "</td>";
					echo "<td>" . $row["Paid"] . "</td>";
					echo "</tr>"; // End the row
					
					$totalMeatSlices += $row["MeatSlices"];
        			$totalVegetarianSlices += $row["VegetarianSlices"];
        			$totalVeganSlices += $row["VeganSlices"];
					
					$meatPizzas = ceil($totalMeatSlices / 15);
					$vegetarianPizzas = ceil($totalVegetarianSlices / 15);
					$veganPizzas = ceil($totalVeganSlices / 15);
					
					$remainingMeatSlices = $meatPizzas * 15 - $totalMeatSlices;
					$remainingVegetarianSlices = $vegetarianPizzas * 15 - $totalVegetarianSlices;
					$remainingVeganSlices = $veganPizzas * 15 - $totalVeganSlices;

					$priority = $row["Priority"] / 10;
					$additionalMeatSlices = round($priority * $remainingMeatSlices);
					$additionalVegetarianSlices = round($priority * $remainingVegetarianSlices);
					$additionalVeganSlices = round($priority * $remainingVeganSlices);
					
					echo "<tr>";
					echo "<td colspan='3'>Additional Slices:</td>";
					echo "<td>" . $additionalMeatSlices . "</td>";
					echo "<td>" . $additionalVegetarianSlices . "</td>";
					echo "<td>" . $additionalVeganSlices . "</td>";
					echo "<td colspan='3'></td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='6'>No data found.</td></tr>"; // Display a single row for no data
			}
			$conn->close();
			

			
			echo "<tr>";
			echo "<td colspan='3'>Total Slices:</td>";
			echo "<td>" . $totalMeatSlices . 		"</td>";
			echo "<td>" . $totalVegetarianSlices . 	"</td>";
			echo "<td>" . $totalVeganSlices . 		"</td>";
			echo "<td colspan='3'></td>"; 
			echo "</tr>";
			
			echo "<tr>";
			echo "<td colspan='3'>Pizzas Needed:</td>";
			echo "<td id='meatPizzas'>" . $meatPizzas . "</td>";
			echo "<td id='vegetarianPizzas'>" . $vegetarianPizzas . "</td>";
			echo "<td id='veganPizzas'>" . $veganPizzas . "</td>";
			echo "<td colspan='3'></td>"; 
			echo "</tr>";
			
			echo "<tr>";
			echo "<td colspan='3'>Remaining Slices:</td>";
			echo "<td>" . ($meatPizzas*15-$totalMeatSlices) . "</td>";
			echo "<td>" . ($vegetarianPizzas*15-$totalVegetarianSlices) . "</td>";
			echo "<td>" . ($veganPizzas*15-$totalVeganSlices) . "</td>";
			echo "<td colspan='3'></td>";
			echo "</tr>";
			

			?>
		</table>
	</div>
	
	<script src="script.js"></script>
</body>
</html>
