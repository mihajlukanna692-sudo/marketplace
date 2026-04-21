<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ogloszenia";

$con = mysqli_connect($host, $user, $pass, $db);

if(!$con){
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}
?>
