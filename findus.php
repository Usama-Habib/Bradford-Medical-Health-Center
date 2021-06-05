<?php 
  session_start();
?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Find us </title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<link rel="stylesheet" type="text/css" href="css/nav-footer.css"> 

 <style>



  /* google map */
   
.google_maps{

  padding-top: 110px;


}
   /* end of google map */

</style>

</head>


<body>


    <!-- Nav bar -->

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed">
       
        <li><a href="home.php">Home</a></li>
        <li><a href="">Treatment</a></li>  
        <li><a href="">Contact</a></li>  
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
        <li>
          <?php if (empty($_SESSION['login_user'])) { echo "<a href='login.php'>Login</a>"; } else { echo "<a href='logout.php'>Logout</a>"; } ?>
        </li>
      </ul>

    </div>
  </div>
</nav>


    <!-- End of Nav bar -->




    <!-- Google maps -->

    
<div class="google_maps">
  
<iframe width="100%" max-width="950" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2357.2467821521154!2d-1.7749916842657112!3d53.78509514945753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487be6c8ec7ba231%3A0xb8225d64c719bee4!2sHorton%20Park%20Health%20Centre!5e0!3m2!1sen!2suk!4v1604663051083!5m2!1sen!2suk" allowfullscreen></iframe>

</div>

<!-- End of Google maps -->



    <!-- End of google maps -->


    <!-- Footer -->
    <footer class="footer-distributed">

      <div class="footer-left">
          <img src="img/logo1.png">
        <h3>About<span>Eduonix</span></h3>

        <p class="footer-links">
          <a href="home.php">Home</a>
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
  function initialize() {
    var mapOptions = {
        zoom: 9,
        center: new google.maps.LatLng(28.9285745, 77.09149350000007),
        mapTypeId: google.maps.MapTypeId.TERRAIN
     };

     var map = new google.maps.Map(
         document.getElementById('location-canvas'), 
         mapOptions
     );
}
</script>


    <!--End of  Footer -->

</body>
</html>

