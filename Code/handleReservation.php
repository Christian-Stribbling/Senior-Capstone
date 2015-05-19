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
<?php
date_default_timezone_set("America/New_York");
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
?>	

<?php
if (!empty($_POST["delete"])) {
$entry = $_POST["delete"];
$sql = "DELETE FROM reservation WHERE name='$entry'";

if (mysqli_query($dbc, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($dbc);
}
}


if (!empty($_POST["name"])) {
$name = $_POST["name"];
$email = "none";
$phone = "none";
$localDate = new DateTime();
$result = $localDate->format('Y-m-d H:i:s');
$party = $_POST["party"];
$server = $_POST["server"];

$sql = "INSERT INTO `tables`.`reservation` (`name`, `email`, `phone`, `date`, `party`, `server`) VALUES ('$name', '$email', '$phone', '$result', '$party', '$server')";

if (mysqli_query($dbc, $sql)) {
    
} else {
//    echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
}
}

?>

<form method = "post">
<p><b>Name: <input type="text" name="name" required></b></p><br>
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

	<form method = "post">

	<p><b>Select Guest to Delete: <select name = "delete">

<?php 
$query = "SELECT * FROM `reservation` ORDER BY `date` ASC ";

$response = @mysqli_query($dbc, $query);

if ($response) {

	while($row = mysqli_fetch_array($response)){
	
		echo "<option>" . $row['name'] . "</option>";
	}
	 	 
	} else {
	 
//	echo "Couldn't issue database query<br />";
	 
//	echo mysqli_error($dbc);	 
	}

   

?>
</select></b></p>
<input type="submit" value = "Delete">
</form>

<?php

$query = "SELECT * FROM `reservation` ORDER BY `date` ASC ";


$response = @mysqli_query($dbc, $query);

if ($response) {

	echo '<table align="left"
	cellspacing="5" cellpadding="8">
	 
	<tr><td align="left"><b>Name</b></td>
	<td align="left"><b>Date</b></td>
	<td align="left"><b>Party</b></td>
	<td align="left"><b>Server</b></td>';

	while($row = mysqli_fetch_array($response)){
	
echo '<tr><td align="left">' .
	$row['name'] . '</td><td align="left">' .
	$row['date'] . '</td><td align="left">' .
	$row['party'] . '</td><td align="left">' .
	$row['server'] . '</td><td align="left">';
	
	 
	echo '</tr>';
	}
	 
	echo '</table>';
	 
	} else {
	 
//	echo "Couldn't issue database query<br />";
	 
//	echo mysqli_error($dbc);
	 
	}
	 
	// Close connection to the database
	mysqli_close($dbc);
	 
	?>
	



</body>
</html>