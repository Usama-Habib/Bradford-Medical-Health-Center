<?php
include_once ('database/configuration.php');
session_start();
if (empty($_SESSION['login_user'])){
    header("Location:home.php");
    exit();
}else{
?>
<!DOCTYPE html>
<html>

<head>

    <title>BMC | Appointments </title>

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
            max-width: 800px;
            height: auto;
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
            padding: 30px;
            display: flex;
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
            margin-left: -10%;
        }

        @media(max-width: 575.98px) {
            .container {
                flex-direction: column;
                box-shadow: none;
            }

            .col-left,
            .col-right {
                text-align: center;
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

        /*Table Styling*/
        table{
            width: 100%;
            margin: 0px auto;
            border-collapse: collapse;
        }

        
        /*th{
            background-color: orange;
            padding: 0.5rem;
            border:1px solid black;
            text-align: center;
        }
        td{
            font-weight: bolder;
            text-align: left;
            background-color: skyblue;
            border: 1px solid black;
            padding: 0.5rem;
        }*/


            th, td {
              text-align: left;
              padding: 8px;
            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
              background-color: orange;
              color: white;
            }


        .dropbtn {
          background-color: #3498DB;
          color: white;
          padding: 16px;
          font-size: 16px;
          border: none;
          cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
          background-color: #2980B9;
        }

        .dropdown {
          position: relative;
          display: inline-block;
        }

        .dropdown-content {

          display: none;
          position: absolute;
          background-color: #f1f1f1;
          min-width: 160px;
          overflow: auto;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }

        .dropdown{
          /*background-color: pink;*/
        }

        .dropdown button{
          border-radius: 50%;
        }

        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
        }

        .dropdown a:hover {background-color: #ddd;}

        .show {display: block;}

        .login_icon{
          color: black;
          border: 1.5px solid black;
          padding: 10px;
          border-radius: 50%;
        }


    </style>
</head>


<body>
<?php 
  // Calculate display name
  $displayName = substr($_SESSION['user_firstname'], 0,1);
  $displayName .= substr($_SESSION['user_lastname'], 0,1);
  $displayName = strtoupper($displayName);

?>

<!-- Nav bar -->

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed">

                <li><a href="home.php">Home</a></li>
                <li><a href="#contact">Appointment</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><?php if (empty($_SESSION['login_user'])) { echo "<a href='login.php'>Login</a>"; } else { echo "<a href='logout.php'>Logout</a>"; } ?></li>
            </button>

            <a class="navbar-brand" href="home.php">
                <img src="img/logo1.png" alt="Logo">
            </a>
        </div>

        <div id="navbar" class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="treatment.php">Treatment</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><?php if ($_SESSION['login_user']) { 
                    echo "<div class='dropdown'>
                            <button onclick='myFunction()' class='dropbtn'>". $displayName ."</button>
                            <div id='myDropdown' class='dropdown-content'>
                              <a href='logout.php'>Logout</a>
                            </div>
                          </div>"; 
                } ?>
                    
                </li>
                
            </ul>

        </div>
    </div>
</nav>


<!-- End of Nav bar -->

<!--Login form-->

<div class="wrapper">
    <div class="container1">
         <table>
             <thead>
                 <th>Patient</th>
                 <th>Doctor</th>
                 <th>Doctor's Email</th>
                 <th>Date Scheduled</th>
                 <th>Appointment Expected</th>
             </thead>
             <tbody>
                 
                     <?php
                        $my_appoint = "select concat(d.fname,' ',d.lname) as Name, concat(p.fname,' ', p.lname) as pName ,  d.email, reg_date, probable_start_time from appointment INNER JOIN patients p USING(pat_id) INNER JOIN doctors d USING(doc_id) where p.email = '". $_SESSION['login_user'] ."' and reg_date >= CURDATE()";
                        $result = $conn->query($my_appoint);
                        if($result->num_rows > 0){
                            while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['pName']?></td>
                                <td><?php echo $row['Name']?></td>
                                <td><a href="mailto:<?php echo $row['email']?>"><?php echo $row['email']?></a></td>
                                <td><?php echo $row['reg_date']?></td>
                                <td><?php echo $row['probable_start_time'] . ' PM'?></td>
                            </tr>
                       <?php }
                        }else{ ?>
                            <tr><td style="text-align: center;" colspan="5">No appointment found</td></tr>
                        <?php }
                     ?>
             </tbody>
         </table>
    </div>
</div>



<!--End of login form-->



<!-- Footer -->
<footer class="footer-distributed">

    <div class="footer-left">
        <img src="img/logo1.png">
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

<script type="text/javascript">
    /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

</script>

</body>
</html>
<?php

}?>
