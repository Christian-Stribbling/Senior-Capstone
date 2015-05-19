<html>
<style>
body {
	background-image: url(background.jpg);
	
-moz-background-size: cover;
-webkit-background-size: cover;
background-size: cover;
background-position: top center !important;
background-repeat: no-repeat !important;
background-attachment: fixed;
}
</style>
<body>
<h2>Make A Reservation</h2>


<?php
	require_once('mysql.php');
	
	// Grab Employees
	$query = "SELECT * FROM `employee` ORDER BY `id` ASC ";
	$response = @mysqli_query($dbc, $query);
	
	if ($response) {
	$names = array();
	while($row = mysqli_fetch_array($response)){
	
	array_push($names, $row['Name']);
	}
	}	 
	// Close connection to the database
	mysqli_close($dbc);
?>


<form action = "reservation.php" method = "post">
<p><b>Name: <input type="text" name="name" required></b></p><br>
<p><b>E-mail: <input type="email" name="email" required></b></p><br>
<p><b>Phone Number: <input type="tel" name="phone" required></b></p><br>
<p><b>Date: <input type="datetime-local" name="localDate" required></b></p><br>
<p><b>Party Size: <input type="number" name="party" min="1" required></b></p><br>
<p><b>Preferred Server: <select id="employees" name = "server">
<option value="No Preference">No Preference</option>
<?php for ($i = 0; $i < sizeOf($names); $i++)
{
    echo "<option>" . $names[$i] . "</option>";
}

?>
</select></b></p><br>
<input type="submit">
</form>
</body>
</html>