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
$table = DB_NAME;

$dataOccupiedWhole = $_POST['dataOccupied'];
$dataOccupiedBroken = explode(",",$dataOccupiedWhole);

$dataXWhole = $_POST['dataX'];
$dataXBroken = explode(",",$dataXWhole);

$dataYWhole = $_POST['dataY'];
$dataYBroken = explode(",",$dataYWhole);
 
$numofTables = $_POST['data'];
$numofTablesBroken = explode(",",$numofTables);

$numofSeats = $_POST['dataSeat'];
$numofSeatsBroken = explode(",",$numofSeats);

$server = $_POST['dataServer'];
$serverBroken = explode(",",$server);

for($i = 0; $i < sizeOf($numofTablesBroken); $i++) {

$dataOccupiedBroken[$i] = str_replace(' ', '~', $dataOccupiedBroken[$i]);
$sql = "INSERT INTO `$table`.`data` (`id`, `table`, `x`, `y`, `occupied`, `seats`, `server`) VALUES ('$numofTablesBroken[$i]', '$numofTablesBroken[$i]', '$dataXBroken[$i]', '$dataYBroken[$i]', '$dataOccupiedBroken[$i]', '$numofSeatsBroken[$i]', '$serverBroken[$i]')";
$sql2 = "UPDATE `$table`.`data` SET `x` = '$dataXBroken[$i]', `y` = '$dataYBroken[$i]', `occupied` = '$dataOccupiedBroken[$i]', `seats` = '$numofSeatsBroken[$i]', `server` = '$serverBroken[$i]' WHERE `data`.`id` = '$numofTablesBroken[$i]'";

if ($dbc->query($sql) === TRUE) {
//    echo "Record updated successfully";
} else {
//   echo "Error creating record: " . $dbc->error;
}

if ($dbc->query($sql2) === TRUE) {
//    echo "Record updated successfully";
} else {
//   echo "Error updating record: " . $dbc->error;
}


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
	<td align="left"><b>Seats</b></td>
	<td align="left"><b>Server</b></td>';

	while($row = mysqli_fetch_array($response)){
	
echo '<tr><td align="left">' .
	$row['table'] . '</td><td align="left">' .
	$row['x'] . '</td><td align="left">' .
	$row['y'] . '</td><td align="left">' .
	$row['occupied'] . '</td><td align="left">' .
	$row['seats'] . '</td><td align="left">' .
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

<p><a href="http://localhost/Create.php">Return to previous page</a></p>
</body>
</html>