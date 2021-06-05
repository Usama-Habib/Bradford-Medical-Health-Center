<?php
session_start();
include_once ('database/configuration.php');
if (isset($_SESSION['role']) && $_SESSION['role'] === -1) {
  // CHECK DOCTOR HAS REGISTERED HIMSELF OR NOT

  $isRegistered = "SELECT * FROM doctors WHERE email = '". $_SESSION['login_user'] ."'";
  if ($result = $conn->query($isRegistered)) {
    /* determine number of rows result set */
    $row_cnt = $result->num_rows;
    if ($row_cnt < 1) {
      // YOU NEED TO DO FIRST REGISTRATION
      die(header("Location: doctor_register.php"));
    }
    /* close result set */
    $result->close();
  }else{
    echo "Error : " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Home </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/nav-footer.css"> 
<style>


/* Jumbotron */
.jumbotron{

  margin-top: 100px;
  background-image: url("medical-02.jpg");
  background-size: cover;


}

/* End of Jumbotron */


.ourpatients{

  text-align: center;
  color: #008ae6;
  padding-top: 10px;
}



/* Button */
.button2 {background-color: #008CBA;} /* Blue */
.button {
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

/* End of button */


.covid_info{

  color: #008ae6;
  text-align: center;
}


div.example {
  
  padding: 20px;
  text-align: center;
  

}

@media screen and (min-width: 601px) {
  div.example {
    font-size: 80px;
  }
}

@media screen and (max-width: 600px) {
  div.example {
    font-size: 30px;
  }
}

@media screen and (min-width: 601px) {
  div.covid_info {
    font-size: 80px;
  }
}

@media screen and (max-width: 600px) {
  div.covid_info {
    font-size: 30px;
  }
}





.box{
  padding-top:10px;
  }

.Image-star, .Image-quote{
  text-align: center;
}





/* Our patients slides*/

* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}

/* Slideshow container */
.slideshow-container {
  position: relative;
  background: #f1f1f1f1;
  

}

/* Slides */
.mySlides {
  display: none;
  padding: 80px;
  text-align: center;
  
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -30px;
  padding: 16px;
  color: #888;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  position: absolute;
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
  color: white;
}

/* The dot/bullet/indicator container */
.dot-container {
    text-align: center;
    padding: 20px;
    background: #ddd;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

/* Add a background color to the active dot/circle */
.active, .dot:hover {
  background-color: #717171;
}

/* Add an italic font style to all quotes */
q {font-style: italic;}

/* Add a blue color to the author */
.author {color: cornflowerblue;}





/* three logos at the bottom*/
/* Three image containers (use 25% for four, and 50% for two, etc) */
.column {
  float: left;
  width: 33.33%;
  padding: 5px;
  padding-left: 150px;
  padding-top: 30px;
}

.row{
  display: flex;
  justify-content: space-around;
}

/* Clear floats after image containers */
.row::after {
  content: "";
  clear: both;
  display: table;
}



/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media screen and (max-width: 500px) {
  .column {
    width: 100%;
  }
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
  width: 50px;
  height: 50px;
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


?>

    <!-- Nav bar -->

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed">
       
        <li><a href="home.php">Home</a></li>
        <li><a href="treatment.php">Treatment</a></li>  
        <li><a href="contact.php">Contact</a></li>  
        <li><a href="login.php">Login</a></li>
        
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
          <?php
            if(!empty($_SESSION['login_user']) AND ($_SESSION['role'] === 0)){
                // Calculate display name
                $displayName = substr($_SESSION['user_firstname'], 0,1);
                $displayName .= substr($_SESSION['user_lastname'], 0,1);
                $displayName = strtoupper($displayName);
              echo "<li><a href='myAppointments.php'>My Appointments</a></li>";
              echo "<li>
                          <div class='dropdown'>
                            <button onclick='myFunction()' class='dropbtn'>". $displayName ."</button>
                            <div id='myDropdown' class='dropdown-content'>
                              <a href='logout.php'>Logout</a>
                            </div>
                          </div>
                    </li>";
            }elseif (!empty($_SESSION['login_user']) AND ($_SESSION['role'] === 1)) {
              $displayName = substr($_SESSION['user_firstname'], 0,1);
              $displayName .= substr($_SESSION['user_lastname'], 0,1);
              $displayName = strtoupper($displayName);
              echo "<li><a href='myCheckups.php'>My Check-Up</a></li>";
              echo "<li>
                          <div class='dropdown'>
                            <button onclick='myFunction()' class='dropbtn'>".$displayName ."</button>
                            <div id='myDropdown' class='dropdown-content'>
                              <a href='logout.php'>Logout</a>
                            </div>
                          </div>
                    </li>";
            }else{
                echo "<li><a href='login.php'>Login</a></li>";
            }
          ?>
      </ul>
    </div>
  </div>
</nav>


    <!-- End of Nav bar -->



    <!-- Jumbotron -->
    
<div class="container">
  <!-- Main component for a primary marketing message or call to action -->
  <div class="jumbotron">

    <h1>Bradford Medical Centre</h1> 
    <p>Keeping our patients safe is our absolute priority, and this has never been as important as it is now. We are proud of our strong record in infection prevention and control, and have strict protocols in place to minimise the risk of infection and keep our patients and workforce safe.</p>

    <a href='readmore.php'><button class="button button2">Read More</button></a>
  
  </div>
</div>

    <!-- End of Jumbotron -->

    <div class="covid_info">
      <h2>(Coronavirus) Patient and Visitor Information</h2>
    </div>
    
    <div class="example"><h4>Bradford Medical Centre UK has offered its full support to the National Health Service to assist with its response to the COVID-19 outbreak.</h4>
      <h4>Click <a href="https://www.nhs.uk/conditions/coronavirus-covid-19/">here</a> to visit the NHS.</h4>
      <h4>During COVID 19 we ask that you only attend the hospital if you have been invited to do so. This is to protect all our patients, particularly </h4>
      <h4>the most vulnerable as well as our staff.</h4>
      <h4>Patients having a procedure will be swabbed for COVID-19, 72 hours prior to admission. We do not offer COVID tests for people </h4>
      <h4>that are symptomatic.</h4>
    </div>





<div class="slideshow-container">
  <div class="ourpatients">
  
<h2>Our Patients</h2>
</div>

<div class="mySlides">


  <q>Every member of staff was great, very comfortable rooms. Easy to relax, staff great at putting you at ease. Would genuinely recommend Bradford Medical Centre, genuinely changed my view on hospital treatment</q>
  <p class="author">- Patient 1</p>
</div>

<div class="mySlides">
  <q>Just felt I needed to say a big thankyou to all the staff at The Yorkshire Clinic today after a very positive experience in their care. I cannot imagine how it could have been a better experience. Thankyou all</q>
  <p class="author">- Patient 2</p>
</div>

<div class="mySlides">
  <q>Excellent care and attention from initial consultation to surgery, theatre staff, ward nurses and physios. Outstanding service by all involved, would recommend this hospital to any future patients</q>
  <p class="author">-Patient 3</p>
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>

<div class="dot-container">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>




<!-- images -->

   <div class="row">

    <div class="column">
      <a href="symptoms.php" target="blank">
      <img src="img/check-your-symptom.png" width="200" height="200">
      <h4>Check your symtoms</h4>
    </div>

    <?php

    if (isset($_SESSION['role']) AND $_SESSION['role'] === 1) {
      ?>
    <?php }else{
      ?>
      <div class="column">
          <a href="appointment.php">
           <img src="img/appointment.png" width="200" height="200">
          <h4>Make an appointment</h4>
        </div>
      <?php
    } ?>

    <div class="column">
      <a href="findus.php">
      <img src="img/findus.png" width="200" height="200">
      <h4>Find our medical centre</h4>
    </div>

</div>


<!-- End of images -->





    <!-- Footer -->
    <footer class="footer-distributed">

      <div class="footer-left">
          <img src="img/logo1.png">
        <h3>About<span>Eduonix</span></h3>

        <p class="footer-links">
          <a href="#">Home</a>
          |
          <a href="treatment.php">Treatment</a>
          |
          <a href="contact.php">Contact</a>
          |
          <a href="login.php">Login</a>
        </p>

        <p class="footer-company-name">© 2020 Bradford Medical Centre Pvt. Ltd.</p>
      </div>

      <div class="footer-center">
        <div>
          <i class="fa fa-map-marker"></i>
            <p><span>Horton Park Centre, 
                     99 Horton Park Ave, 
                     Bradford, BD7 3EG</p>
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






    <script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

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


    <!--End of  Footer -->

</body>
</html>

