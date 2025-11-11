<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Doctor</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
   <?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

// import database
include("../connection.php");

if ($_POST) {
    // ----- 1. Grab form values ------------------------------------------------
    $name      = $_POST['name'];
    $spec      = $_POST['spec'];
    $email     = $_POST['email'];
    $tele      = $_POST['Tele'];
    $password  = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // ----- 2. Basic validation ------------------------------------------------
    if ($password !== $cpassword) {
        $error = '2'; // passwords do not match
    } else {
        // ----- 3. Email already used? -----------------------------------------
        $check = $database->query("SELECT email FROM webuser WHERE email='$email'");
        if ($check && $check->num_rows > 0) {
            $error = '1'; // email already taken
        } else {
            // ----- 4. Plain-text password (no hashing) -------------------------
            $plain_pwd = $password; // keep as plain text (your format)

            // ----- 5. INSERT into doctor --------------------------------------
            $sql1 = "INSERT INTO doctor (docemail, docname, docpassword, doctel, specialties)
                     VALUES ('$email', '$name', '$plain_pwd', '$tele', '$spec')";

            // ----- 6. INSERT into webuser -------------------------------------
            $sql2 = "INSERT INTO webuser (email, usertype)
                     VALUES ('$email', 'd')";

            // ----- 7. Execute both queries ------------------------------------
            if ($database->query($sql1) === TRUE && $database->query($sql2) === TRUE) {
                $error = '4'; // SUCCESS
            } else {
                $error = '3'; // insertion failed
            }
        }
    }
} else {
    $error = '3'; // invalid POST
}

header("location: art-palette.php?action=add&error=" . $error);
?>

   

</body>
</html>