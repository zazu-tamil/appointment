<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

include("../connection.php"); // DB connection

if ($_GET) {
    $id = $_GET["id"];

    // Fetch doctor email using doctor id
    $result = $database->query("SELECT docemail FROM doctor WHERE docid='$id';");

    if ($result->num_rows > 0) {
        $email = ($result->fetch_assoc())["docemail"];

        // Delete from both tables
        $database->query("DELETE FROM webuser WHERE email='$email';");
        $database->query("DELETE FROM doctor WHERE docemail='$email';");
    }

    // Redirect back after deletion
    header("location: art-palette.php");
    exit;
}
?>
