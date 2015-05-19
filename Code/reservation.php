<html>
<body onload="confirmInfo()">
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

<p><b>Your Name <?php echo $_POST["name"]; ?></b></p><br>
<p><b>Your Email: <?php echo $_POST["email"]; ?></b></p><br>
<p><b>Your Phone: <?php echo $_POST["phone"]; ?></b></p><br>
<p><b>The Date: <?php echo $_POST["localDate"]; ?></b></p><br>
<p><b>Your Party Size: <?php echo $_POST["party"]; ?></b></p><br>
<p><b>Your Preferred Server: <?php echo $_POST["server"]; ?></b></p><br>

<p><a href="http://localhost/MakeReservations.php">Return to previous page</a></p>


<?php
require_once('mysql.php');
$table = DB_NAME;

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$localDate = $_POST["localDate"];
$party = $_POST["party"];
$server = $_POST["server"];

$sql = "INSERT INTO `$table`.`reservation` (`name`, `email`, `phone`, `date`, `party`, `server`) VALUES ('$name', '$email', '$phone', '$localDate', '$party', '$server')";

if (mysqli_query($dbc, $sql)) {
    
} else {
//    echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
}

$to = $email;
$subject = "Reservation";
$message = "Test Message";
$headers = "From: $from_add \r\n";
$headers .= "Reply-To: $from_add \r\n";
$headers .= "Return-Path: $from_add\r\n";
$headers .= "X-Mailer: PHP \r\n";

if(mail($to,$subject,$message,$headers)) 
	{
		echo $msg = "Mail sent OK";
	} 
	else 
	{
 	   echo $msg = "Error sending email!";
	}


mysqli_close($dbc);
?>

</body>
</html>