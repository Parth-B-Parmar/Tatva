<?php include "db.php"?>
<?php 
$token = $_GET['token'];

$result = "SELECT IsEmailVerified,token FROM users WHERE IsEmailVerified = 0 AND token = '$token' ";
$query = mysqli_query($connection, $result);

if(mysqli_num_rows($query) == 1) {
    //validate email
    $update = "UPDATE users SET IsEmailVerified = 1 WHERE token = '$token' ";
    $updateQuery = mysqli_query($connection, $update);
    if($updateQuery) {
        header("Location: login.php");
    } else {
        echo mysqli_error($connection);
    }
}



?>





<!DOCTYPE html>
<html lang="en">
    
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!--  Bootstrap Css -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    
    <!-- Css -->
    <link rel="stylesheet" href="css/email-verification.css">
    
    <title>Notes MarketPlace</title>
</head>

<body>
    <section id="email-verification">
        <table class="table">
            <tr>
                <td><img src="images/images/logo.png" alt="logo" class="img-responsive logo"></td>
            </tr>
            
            <tr>
                <td><h4>Email Verification</h4></td>
            </tr>
            
            <tr>
                <td><h5>Dear Smith,</h5></td>
            </tr>
            
            <tr>
                <td><p>Thanks for Signing up!</p><p>Simply click below for email verification.</p></td>
            </tr>
            
            <tr>
                <td>
                    <div id="verify-btn">
                        <a class="btn" href="#" title="verify email address" role="button">verify email address</a>
                    </div>
                </td>
            </tr>
        </table>
    </section>
</body>

<!-- Bootstrap -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

<!-- jquery -->
    <script src="js/jquery.min.js"></script>
    
</html>