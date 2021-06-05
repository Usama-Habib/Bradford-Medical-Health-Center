<?php
include_once ('database/configuration.php');
$result = "";
$password = "";
$cfrmpassword = "";
$errors = [];
define('REQUIRED_FIELD_ERROR' , "This field is required");
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $password = purify_post_data('u_pass');
    $cfrmpassword = purify_post_data('u_confrm_pass');

    if(!$password){
        $errors['user_password'] = REQUIRED_FIELD_ERROR;
    }elseif (strlen($password) < 5 OR strlen($password) > 15) {
        $errors['user_password'] = "Password field must be in between 5 and 15 characters";
    }
    if(!$cfrmpassword){
        $errors['user_confirm_password'] = REQUIRED_FIELD_ERROR;
    }elseif (strlen($cfrmpassword) < 5 OR strlen($cfrmpassword) > 15) {
        $errors['user_confirm_password'] = "Password field must be in between 5 and 15 characters";
    }
    if($password && $cfrmpassword && strcmp($password,$cfrmpassword) !==0 ){
        $errors['user_confirm_password'] = "This must match the password field";
    }
    if (empty($errors)){
        // Grab to token that came from the email link
        $token = $_GET['token'];
            // select email address of user from the password_reset table
            $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
            $results = $conn->query($sql);
            $email = $results->fetch_assoc();
            $email = $email['email'];
            $result = $email;
            if ($email) {
                $new_pass = password_hash($password,PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password_hash ='$new_pass' WHERE email = '$email'";
                if($results = $conn->query($sql)){
                    header('location: login.php');
                }
            }
        }
}
function purify_post_data($field){
    $_POST[$field] ?? '';
    return htmlspecialchars(stripslashes($_POST[$field]));
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>BMC | New Password </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


    <link rel="stylesheet" type="text/css" href="css/nav-footer.css">

    <style>


        /* * * * * General CSS * * * * */


        .wrapper {
            margin: 0 auto;
            width: 100%;
            max-width: 1140px;
            padding-top: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .container1 {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: auto;
            display: flex;
            align-content: center;
            justify-content: center;
            background: #ffffff;
            box-shadow: 0 0 5px #999999;
        }

        .credit {
            position: relative;
            margin: 25px auto 0 auto;
            width: 100%;
            text-align: center;
            color: #666666;
            font-size: 16px;
            font-weight: 400;
        }

        .credit a {
            color: #222222;
            font-size: 16px;
            font-weight: 600;
        }

        .col-left,
        .col-right {
            /*padding: 30px;*/
            /*text-align: center;*/
        }

        .col-left {
            width: 60%;
            -webkit-clip-path: polygon(0 0, 0% 100%, 100% 0);
            clip-path: polygon(0 0, 0% 100%, 100% 0);
            background: #008CBA;
        }

        .col-right {
            padding: 60px 30px;
            width: 50%;
            /*margin-left: -10%;*/
        }

        @media(max-width: 575.98px) {
            .container {
                flex-direction: column;
                box-shadow: none;
            }

            .col-left,
            .col-right {
                width: 100%;
                margin: 0;
                -webkit-clip-path: none;
                clip-path: none;
            }

            .col-right {
                padding: 30px;
            }
        }

        .login-text {
            position: relative;
            width: 100%;
            color: #ffffff;
        }

        .login-text h2 {
            margin: 0 0 15px 0;
            font-size: 30px;
            font-weight: 700;
        }

        .login-text p {
            margin: 0 0 20px 0;
            font-size: 16px;
            font-weight: 500;
            line-height: 22px;
        }

        .login-text .btn {
            display: inline-block;
            padding: 7px 20px;
            font-size: 16px;
            letter-spacing: 1px;
            text-decoration: none;
            border-radius: 30px;
            color: #ffffff;
            outline: none;
            border: 1px solid #ffffff;
            box-shadow: inset 0 0 0 0 #ffffff;
            transition: .3s;
            -webkit-transition: .3s;
        }

        .login-text .btn:hover {
            color: #44c7f5;
            box-shadow: inset 150px 0 0 0 #ffffff;
        }

        .login-form {
            position: relative;
            width: 100%;
        }

        .login-form h2 {
            margin: 0 0 15px 0;
            font-size: 22px;
            font-weight: 700;
        }

        .login-form p {
            margin: 0 0 10px 0;
            text-align: left;
            color: #666666;
            font-size: 15px;
        }

        .login-form p:last-child {
            margin: 0;
            padding-top: 3px;
        }

        .login-form p a {
            color: #44c7f5;
            font-size: 14px;
            text-decoration: none;
        }

        .login-form label {
            display: block;
            width: 100%;
            margin-bottom: 2px;
            letter-spacing: .5px;
        }

        .login-form p:last-child label {
            width: 60%;
            float: left;
        }

        .login-form label span {
            color: #ff574e;
            padding-left: 2px;
        }

        .login-form input {
            display: block;
            width: 100%;
            height: 35px;
            padding: 0 10px;
            outline: none;
            border: 1px solid #cccccc;
            border-radius: 30px;
        }

        .login-form input:focus {
            border-color: #ff574e;
        }

        .login-form button,
        .login-form input[type=submit] {
            display: inline-block;
            width: 100%;
            margin-top: 5px;
            color: #44c7f5;
            font-size: 16px;
            letter-spacing: 1px;
            cursor: pointer;
            background: transparent;
            border: 1px solid #44c7f5;
            border-radius: 30px;
            box-shadow: inset 0 0 0 0 #44c7f5;
            transition: .3s;
            -webkit-transition: .3s;
        }

        .login-form button:hover,
        .login-form input[type=submit]:hover {
            color: #ffffff;
            box-shadow: inset 250px 0 0 0 #44c7f5;
        }



    </style>
</head>


<body>


<!-- Nav bar -->

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed">

                <li><a href="home.php">Home</a></li>
                <li><a href="#contact">Appointment</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php">Login</a></li>

            </button>

            <a class="navbar-brand" href="home.php">
                <img src="css/logo1.png" alt="Logo">
            </a>
        </div>

        <div id="navbar" class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="#contact">Treatment</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>

        </div>
    </div>
</nav>


<!-- End of Nav bar -->



<!--Login form-->

<div class="wrapper">
    <?php
    if ($errors['login_err'] ?? false){
        echo "<p style='max-width: 1140px; text-align: center; font-style: italic font-size: 18px; color: red; '> ". $errors['login_err'] ." </p>";
    }
    ?>
    <div class="container1">
          <div class="col-right">
            <div class="login-form">
                <h2>Set new password</h2>
                <form method="post">
                    <p>
                        <label>Password<span>*</span></label>
                        <input type="password" placeholder="Type your password" name="u_pass" value = <?php echo $password ?>>
                    <div style="color: red" class="invalid-feedback">
                        <?php echo $errors['user_password'] ?? ""?>
                    </div>
                    </p>

                    <p>
                        <label>Confirm Password<span>*</span></label>
                        <input class="form-control <?php echo isset($errors['user_confirm_password']) ? 'is-invalid': '' ?>" type="password" placeholder="Type your password" name="u_confrm_pass"  value="<?php echo $cfrmpassword?>">
                    <div style="color: red" class="invalid-feedback">
                        <?php echo $errors['user_confirm_password'] ?? ""?>
                    </div>
                    </p>

                    <p>
                        <input type="submit" value="Update Password" />
                    </p>

                </form>
            </div>
        </div>
    </div>
</div>



<!--End of login form-->
<!-- Footer -->
<footer class="footer-distributed">

    <div class="footer-left">
        <img src="css/logo1.png">
        <h3>About<span>Eduonix</span></h3>

        <p class="footer-links">
            <a href="#">Home</a>
            |
            <a href="#">Treatment</a>
            |
            <a href="#">Contact</a>
            |
            <a href="#">Login</a>
        </p>

        <p class="footer-company-name">© 2020 Bradford Medical Centre Pvt. Ltd.</p>
    </div>

    <div class="footer-center">
        <div>
            <i class="fa fa-map-marker"></i>
            <p><span>Bradford Road,
                     Bingley,
                     West Yorkshire,
                     BD16 1TW
            </span>
            </p>
        </div>

        <div>
            <i class="fa fa-phone"></i>
            <p>+91 22-27782183</p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="mailto:support@eduonix.com">support@eduonix.com</a></p>
        </div>
    </div>
    <div class="footer-right">
        <p class="footer-company-about">
            <span>About us</span>
            Bradford medical centre is one of West Yorkshire's leading private hospitals set in three acres of woodland in the grounds of Cottingley Hall near Bingley. The hospital opened in 1982 and has 57 bedrooms including one twin-bedded room all with en suite facilities...</p>
        <div class="footer-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>

        </div>
    </div>
</footer>

<!--End of  Footer -->

</body>
</html>

