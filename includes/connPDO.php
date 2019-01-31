<?php
//Connect to DB using PDO.
$username = "";
$password = "";

try {
    $dbh = new PDO("mysql:host=localhost;dbname=recipe_stor", $username, $password);
    $conn = $dbh;
}
catch( PDOException $exception  ) {
    echo "Connection error :" . $exception ->getMessage();
}
?>
