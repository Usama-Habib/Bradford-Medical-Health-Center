<?php
include_once ('database/configuration.php');
session_start();
$select_category = "SELECT spec_id, specialization_name FROM specialization";
$result = $conn->query($select_category);
?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Make Appointment </title>

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


/*Style Doctor's Section*/

.container_doc{
  width: 80%;
  max-width: 800px;
  margin: 0 auto;
  /*padding: 1px;*/
  margin-top: 8rem;
 }


form{
  margin-top: 0px;
  /*padding: 15px;*/
  display: flex;
  justify-content: space-between;
  background-color: white;
}

.container_table{
  margin-top: 0rem;
  width: 100%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

table{
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td{
  /*border:1px solid white;*/
  padding: 1rem;
  font-size: 1.05em;
  background-color: skyblue;
  border: 20px;
  color: black;
  /*font-weight: bold;*/
}

th{
  /*border-bottom: 20px;*/
  padding: 1rem;
  font-size: 1em;
  font-weight: bolder;
}

.Standard{
  padding: 20px;
  text-align: center;
  border: 2px solid black;
  margin: 20px;
}

.appointment_link{
  background-color: orange;
}
.appointment_link a{
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

    <br><br><br><br><br>
<div class="Standard">
  <h1>MAKE AN APPOINTMENT</h1>

 <h4>Appointments can be booked over the telephone, in person or through online access. Appointments can be made at any surgery site since all the systems, telephone and appointment booking systems are linked.</h4>


  <h4>All surgeries are by appointment only. You can request an appointment with a doctor of your choice. If the doctor of your choice is not available you will be offered the earliest possible alternative. .</h4>
</div>

    <!-- Body starts here -->


    <div class="container_doc">
       <form>
        <h3>FIND DOCTORS BY CATEGORY</h3>
        <div style="display: flex; justify-content: center; align-items: center;">
            <div>        
              <select name="spec_name" style="padding: 8px; border-color: orange; background-color: ">
                <?php

                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {?>
                    <option value=<?php echo $row['specialization_name']?>><?php echo $row['specialization_name'] ?></option>;
                    <?php
                        }
                      } else {
                        ?>
                        <option >No category exists</option>
                        <?php
                      }
                ?>
              </select>
            </div>
            <div>
              <button <?php if (empty($_SESSION['login_user'])) { echo 'disabled=disabled'; } ?> style=" outline-color: orange; margin-left: 15px; padding: 8px; color: white; background-color: orange; border-color: #e0ac1c" name="submit" type="submit" value='search'>SEARCH</button>
            </div>
        </div>
      </form>
      <!-- SHOW TO NON-LOGIN USER -->
        <?php
          if 
           (empty($_SESSION['login_user'])) {
            echo "<span style='color:orange; font-weight:bold;'><i>Login first before placing an appointment</i> </span>"; 
          }
        ?>
    </div>


    <!-- TABLE -->
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['submit'])) {
      $spec = $_GET['spec_name'];
      $select_doc = "SELECT fname,lname,email,phone,specialization_name,availability,doc_id,spec_id FROM DOCT_SPEC
                      INNER JOIN DOCTORS USING(DOC_ID) 
                      INNER JOIN schedule USING(DOC_ID) 
                      INNER JOIN specialization USING(SPEC_ID)
                      WHERE specialization_name LIKE '%$spec%' 
                      GROUP BY email";
      $result = $conn->query($select_doc);
      ?>

      <div style=" border-radius: 20px;" class="container_doc container_table">
        <table>
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Contact Number</th>
              <th>Expertise</th>
              <th>Available</th>
              <th>Book</th>
            </tr>
          </thead>
          <?php
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {?>
                    <tr>
                      <td><?php echo $row['fname'] ?></td>
                      <td><?php echo $row['lname'] ?></td>
                      <td><?php echo $row['email'] ?></td>
                      <td><?php echo $row['phone'] ?></td>
                      <td><?php echo $row['specialization_name'] ?></td>
                      <td>
                        <?php if ($row['availability'] == 1) {
                            echo "Yes";
                          }else{
                            echo "No";
                          } ?>
                      </td>
                      <?php $url = "book_appointment.php?doc=" . urlencode($row['doc_id']) . "&spec=" .urlencode($row['spec_id']);?>
                      <td style="background-color: orange;">
                        <!-- ALLOW BOOKING FOR BASED ON AVAILABILITY -->
                        <?php
                        if ($row['availability'] == 1) {
                            echo "<a href=$url>BOOK</a>";
                          }else{
                            echo "Not Available";
                          }
                        ?>
                      </td>
                    </tr>
                    
                    <?php
                        }
                      } else {
                        ?>
                        <tr>
                          <td style="font-weight: bolder;  text-align: center;" colspan="7"; >No Records Found</td>
                        </tr>
                        <?php
                      } ?>       
        </table>
      </div>

    <?php
    }

    ?>



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
