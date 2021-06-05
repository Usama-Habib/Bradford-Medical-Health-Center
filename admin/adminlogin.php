<?php
include_once '../database/configuration.php';
session_start();

if (isset($_SESSION['adminSession']) != "") {
header("Location: admindashboard.php");
}

if (isset($_POST['login']))
{
$email = mysqli_real_escape_string($conn,$_POST['email']);
$password  = mysqli_real_escape_string($conn,$_POST['password']);

$res = mysqli_query($conn,"SELECT * FROM users WHERE email = '$email'");
$rowcount=mysqli_num_rows($res);
if ($rowcount > 0) {
// admin user exists
$row=mysqli_fetch_array($res,MYSQLI_ASSOC);
if (password_verify($password,$row['password_hash']) AND $row['role'] == 2)
{
$update_access = "UPDATE users SET last_access = NOW() WHERE email = '". $email ."'";
if ($conn->query($update_access)) {
$_SESSION['adminSession'] = $row['email'];
$_SESSION['adminFirstName'] = $row['firstname'];
$_SESSION['adminLastName'] = $row['lastname'];
}
?>
<script type="text/javascript">
alert('Login Success');
</script>
<?php
header("Location: admindashboard.php");
exit;
} else {
?>
<script type="text/javascript">
    alert("Wrong credentials");
</script>
<?php
}
}else{ ?>
<script type="text/javascript">
alert('No such user exist. Try another one.');
</script>
<?php }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BMC | Admin Login </title>
        <!-- Bootstrap -->
        <link href="./assets__/css/bootstrap.min.css" rel="stylesheet">
        <link href="./assets__/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- start -->
            <div class="login-container">
                    <div id="output"></div>
                    <div class="avatar"></div>
                    <div class="form-box">
                        <form class="form" role="form" method="POST" accept-charset="UTF-8">
                            <input name="email" type="email" placeholder="Admin Email" required>
                            <input name="password" type="password" placeholder="Password" required>
                            <button class="btn btn-info btn-block login" type="submit" name="login">Login</button>
                        </form>
                    </div>
                    <a class="btn btn-block btn-info" style="margin-top: 5px;" href="../login.php">Back</a>
                </div>
            <!-- end -->
        </div>

        <script src="assets__/js/jquery.js"></script>

        <!-- js start -->
        
        <!-- js end -->
    </body>
</html>