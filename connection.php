<?php
$servername = "192.168.0.37";
$username = "zazu";  
$password = "zazu@123"; 
$dbname = "appointment_db"; 

$database = new mysqli($servername, $username, $password, $dbname);

if ($database->connect_error) {
    die("Échec de la connexion : " . $database->connect_error);
}
?>

