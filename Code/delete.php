<!DOCTYPE html>
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
require_once('mysql.php');

$index = $_POST['delete'];
$sql = "DELETE FROM data WHERE id='$index'";

if (mysqli_query($dbc, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($dbc);
}

$query = "SELECT * FROM `data` ORDER BY `id` ASC ";


$response = @mysqli_query($dbc, $query);

if ($response) {

	echo '<table align="left"
	cellspacing="5" cellpadding="8">
	 
	<tr><td align="left"><b>Table</b></td>
	<td align="left"><b>X Location</b></td>
	<td align="left"><b>Y Location</b></td>
	<td align="left"><b>Occupied</b></td>
	<td align="left"><b>Seats</b></td>';

	while($row = mysqli_fetch_array($response)){
	
echo '<tr><td align="left">' .
	$row['table'] . '</td><td align="left">' .
	$row['x'] . '</td><td align="left">' .
	$row['y'] . '</td><td align="left">' .
	$row['occupied'] . '</td><td align="left">' .
	$row['seats'] . '</td><td align="left">';

	 
	echo '</tr>';
	}
	 
	echo '</table>';
	 
	} else {
	 
	echo "Couldn't issue database query<br />";
	 
	echo mysqli_error($dbc);
	 
	}

mysqli_close($dbc);
?>

<p><a href="http://localhost/Create.php">Return to previous page</a></p>

</body>

</html>