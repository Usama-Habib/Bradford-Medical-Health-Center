<?php 
  session_start();
?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Symptom Checker </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/nav-footer.css"> 
<link rel="stylesheet" type="text/css" href="css/symptoms.css">
</head>



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

    <div class="covid_info">
      <h2>Check your symptoms</h2>
    </div>

 <!--Form-->


    
  <div id="container">
  <form id="survey-form" action="symptoms_results.php" method="post">

   
  
<!--   <div class="label">  
    <label id="number-label">
      *Age:
    </label>
  </div> -->
    
  <div class="inputs" style="width: 50%;">
    <input
      class="inputBox"
      type="number"
      name="age"
      id="number"
      required
      placeholder="Enter Age"
      min="12"
      max="90" >
    </div>

  <br>
  <br> 

<!--   <div class="label">
    <label id="sex">
      *Sex:
    </label>
    </div> -->
  
  <div class="inputs" style="width: 50%">
    <input  type="radio" id="male" value="male" name="sex" required><label for="male">Male</label>
    <input type="radio" id="female" value="female" name="sex" required="required"><label for="female">Female</label>
    <input type="radio" id="other" value="other" name="sex" required="required"><label for="other">Other</label>
  </div>
<br>


<hr>


  <!-- TABs starts here -->

  <button class="tablink" type="button" onclick="openPage('Covid', this, 'red')" id="defaultOpen">COVID</button>
  <button class="tablink" type="button" onclick="openPage('BP', this, 'orange')" >BLOOD PRESSURE</button>
  <button class="tablink" type="button" onclick="openPage('Heart_Rate', this, 'blue')">HEART RATE</button>

 <!-- covid -->
  <div id="Covid" class="tabcontent"> 
    <div class="checkbox">
      <label id="checkbox-label">
          Tell us about your covid symptoms
        </label>
      </div>
      
    <!-- <div class="label">
      <label id="ans">
        Yes
      </label>
      </div>

      <div class="label">
      <label id="ans1">
      </label>
      </div>

      <div class="label">
      <label id="ans2">
      </label>
      </div>

      <div class="label">
      <label id="ans3">
      </label>
      </div> -->
      
     <div class="COLDERAS">
      
<br>
<br>
  <div class="labels">
    <label id="onset">
      Do you have High temperature?
    </label>
      </div>


    <div class="inputs">
      <input type="radio" value="1" name="ans" id="ans1" required><label for="ans1">Yes</label>
      <input type="radio" value="0" name="ans" id="ans0" required><label for="ans0">No</label>
    </div>



  <div class="labels">
    <label id="onset">
      Do you have Continuous cough?
    </label>
      </div>


    <div class="inputs">
      <input type="radio" value="1" name="ans1" id="ans11" required><label for="ans11">Yes</label>
      <input type="radio" value="0" name="ans1" id="ans10" required><label for="ans10">No</label>
      </div>


  <div class="labels">
    <label id="onset">
      Do you have Sense of taste?
    </label>
      </div>


    <div class="inputs">
      <input type="radio" value="1" name="ans2" id="ans21" required><label for="ans21">Yes</label>
      <input type="radio" value="0" name="ans2" id="ans20" required><label for="ans20">No</label>
      </div>

    <div class="labels">
    <label id="onset">
      Do you have shortness of breath?
    </label>
      </div>


    <div class="inputs">
      <input type="radio" value="1" name="ans3" id="ans31" required><label for="ans31">Yes</label>
      <input type="radio" value="0" name="ans3" id="ans30" required><label for="ans30">No</label>
      </div>
  </div>
  </div>
  <!-- End of covid -->

  <div id="BP" class="tabcontent">
    <div class="checkbox">
      <label id="checkbox-label">
        Tell us about your high blood pressure symptoms
      </label>
    </div>
    
    <!-- <div class="label">
    <label id="ans9">
    </label>
    </div>

    <div class="label">
    <label id="ans4">
    </label>
    </div>

    <div class="label">
    <label id="ans5">
    </label>
    </div>

    <div class="label">
    <label id="ans6">
    </label>
    </div>

    <div class="label">
    <label id="ans7">
    </label>
    </div>

    <div class="label">
    <label id="ans8">
    </label>
    </div>
 -->
    <br>
    <br>

   <div class="COLDERAS">
    

<div class="labels">
  <label id="onset">
    Do you have Severe headaches?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans9" id="ans91" required><label for="ans91">Yes</label>
    <input type="radio" value="0" name="ans9" id="ans90" checked required><label for="ans90">No</label>
    </div>



<div class="labels">
  <label id="onset">
    Do you have Nosebleed?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans4" id="ans41" required><label for="ans41">Yes</label>
    <input type="radio" value="0" name="ans4" id="ans40" checked required><label for="ans40">No</label>
    </div>


<div class="labels">
  <label id="onset">
    Do you have Vison problems?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans5" id="ans51" required><label for="ans51">Yes</label>
    <input type="radio" value="0" name="ans5" id="ans50" checked required><label for="ans50">No</label>
    </div>


<div class="labels">
  <label id="onset">
    Do you have Chest pain?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans6" id="ans61" required><label for="ans61">Yes</label>
    <input type="radio" value="0" name="ans6" id="ans60" checked required><label for="ans60">No</label>
    </div>
  



    <div class="labels">
  <label id="onset">
    Do you have Difficulty breathing?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans7" id="ans71" required><label for="ans71">Yes</label>
    <input type="radio" value="0" name="ans7" id="ans70" checked required><label for="ans70">No</label>
    </div>

   

    <div class="labels">
  <label id="onset">
    Do you have Blood in urine?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" id="ans81" name="ans8" required><label for="ans81">Yes</label>
    <input type="radio" value="0" id="ans80" name="ans8" checked required><label for="ans80">No</label>
    </div>
</div>

  </div>
  <!-- End of Blood Pressure -->

  <div id="Heart_Rate" class="tabcontent">
      <div class="checkbox">
      <label id="checkbox-label">
        Tell us about your high heart rate symtoms
      </label>
    </div>
    
<!-- <div class="label">
    <label id="ans12">
    </label>
    </div>

    <div class="label">
    <label id="ans10">
    </label>
    </div>

    <div class="label">
    <label id="ans11">
    </label>
    </div> -->

    <br>
    <br>
    
   <div class="COLDERAS">
    

 <div class="labels">
  <label id="onset">
    Do you have Heart disease?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans12" id="ans121" required><label for="ans121">Yes</label>
    <input type="radio" value="0" name="ans12" id="ans120" checked required><label for="ans120">No</label>
    </div>


     <div class="labels">
  <label id="onset">
    Do you have any Stress or anxiety?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans10" id="ans101" required><label for="ans101">Yes</label>
    <input type="radio" value="0" name="ans10" id="ans100" checked required><label for="ans100">No</label>
    </div>


     <div class="labels">
  <label id="onset">
    Are you Heavy alcohol user?
  </label>
    </div>


  <div class="inputs">
    <input type="radio" value="1" name="ans11" id="ans111" required><label for="ans111">Yes</label>
    <input type="radio" value="0" name="ans11" id="ans110" checked required><label for="ans110">No</label>
    </div>
  </div>

  </div> 
<!-- End of heart rate -->
  
  <button type="submit" style="margin-top: 0px; padding-left: 10rem; padding-right: 10rem;" id="submit">Submit</button>
  </form>
    </div>  


  <!--End of form-->

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

<script type="text/javascript">
  function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

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