<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<?php
session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

include("connection.php");

$error = '<label for="promter" class="form-label"></label>';

if ($_POST) {

    // collect session-stored personal details
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
     $dob = $_SESSION['personal']['dob'];

    // collect form data
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    if ($newpassword == $cpassword) {

        // check if email already exists in webuser
        $sqlmain = "SELECT * FROM webuser WHERE email = ?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            // insert into patient
            $insert_patient = "INSERT INTO patient (pemail, pname, ppassword, paddress, pdob, ptel)
                               VALUES ('$email', '$name', '$newpassword', '$address', '$dob', '$tele')";
            $insert_webuser = "INSERT INTO webuser (email, usertype) VALUES ('$email', 'p')";

            $patient_result = $database->query($insert_patient);
            $webuser_result = $database->query($insert_webuser);

            if ($patient_result && $webuser_result) {
                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "p";
                $_SESSION["username"] = $fname;

                header('Location: patient/index.php');
                exit;
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Database Insert Error! Please try again.</label>';
            }
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Re-enter password.</label>';
    }
}
?>

<center>
<div class="container">
    <table border="0" style="width: 69%;">
        <tr>
            <td colspan="2">
                <p class="header-text">Let's Get Started</p>
                <p class="sub-text">It's Okey, Now Create User Account.</p>
            </td>
        </tr>
        <tr>
            <form action="" method="POST">
            <td class="label-td" colspan="2">
                <label for="newemail" class="form-label">Email: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="tele" class="form-label">Mobile Number: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="tel" name="tele" class="input-text" placeholder="ex: 0712345678"  required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="newpassword" class="form-label">Create New Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="cpassword" class="form-label">Confirm Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $error; ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
            </td>
            <td>
                <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <label class="sub-text" style="font-weight: 280;">Already have an account&#63;</label>
                <a href="login.php" class="hover-link1 non-style-link">Login</a>
                <br><br><br>
            </td>
        </tr>
        </form>
    </table>
</div>
</center>
</body>
</html>
