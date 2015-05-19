

<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'tables');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($dbc) {
$message = "Database Found";
echo "<script type='text/javascript'>alert('$message');</script>";
}
else {
$message = "Database NOT Found";
echo "<script type='text/javascript'>alert('$message');</script>";
}

// capstone5
// C$5PPSt0nV
// http://img.pcs.cnu.edu/
// capstone5


?>

