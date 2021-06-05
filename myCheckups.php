<?php
include_once ('database/configuration.php');
session_start();
$checkups = "SELECT concat(fname,' ',lname) as Name,email,dob,phone,reg_date,probable_start_time,health_issue,patient_note,doctor_note, booking_id FROM
    APPOINTMENT
    INNER JOIN patients USING(pat_id)
    WHERE doc_id = (SELECT doc_id FROM doctors WHERE email = '". $_SESSION['login_user'] ."')";
?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Check-Up </title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/nav-footer.css"> 

<!-- DATATABLE -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

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



/*Style Doctor's Section*/

/*.container_doc{
  width: 80%;
  max-width: 800px;
  margin: 0 auto;
  border:1px solid red;
 }*/


.container_table{
  margin: 0px auto;
  margin-top: 12rem;
  /*width: 900px;*/
  padding: 20px;
  max-width: 95%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

table{
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
td{
  padding: 1rem;
  font-size: 1.05em;
  color: black;
}

th{
  padding: 0.5rem;
  font-size: 1em;
  background-color: lightgrey;
}

th, td {
  border-bottom: 1px solid #ddd;
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
<!-- 
<script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
</script> -->
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
              // echo "<li><a href='myCheckups.php'>My Check-Up</a></li>";
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


    <!-- Body starts here -->

    <!-- TABLE -->
    <?php
      $result = $conn->query($checkups);
    ?>

      <div class="container_doc container_table">
        <table id="myTable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>DOB</th>
              <th>Date</th>
              <!-- <th>Time</th> -->
              <!-- <th>Health Issue</th> -->
              <!-- <th>Patient's Comment</th> -->
              <th>Doctor's Comment</th>
              <th>Actions</th>

            </tr>
          </thead>
          <?php
              if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {?>
                    <tr>
                      <td><?php echo $row['Name'] ?></td>
                      <td><?php echo $row['email'] ?></td>
                       <td><?php echo $row['phone'] ?></td>
                      <td><?php echo $row['dob'] ?></td>
                      <td><?php echo $row['reg_date'] ?></td>
                      <!-- <td><?php echo $row['probable_start_time'] ?></td> -->
                      <!-- <td><?php echo $row['health_issue'] ?></td> -->
                      <!-- <td><?php echo $row['patient_note'] ?></td> -->
                      <td><?php echo $row['doctor_note'] ?></td>
                      <td>
                        <a href="CRUD/read.php?id=<?php echo $row['booking_id'];?>" title='View'  ><span class='glyphicon glyphicon-eye-open'></span></a>
                        <a href="CRUD/update.php?id=<?php echo $row['booking_id'];?>" title='Edit'  ><span class='glyphicon glyphicon-pencil'></span></a>
                        <a href="CRUD/delete.php?id=<?php echo $row['booking_id'];?>" title='Delete'  ><span class='glyphicon glyphicon-trash'></span></a>
                      </tr>
                    
                    <?php
                        }
                      } else {
                        ?>
                        <tr>
                          <td style="font-weight: bolder;  text-align: center;" colspan="11"; >No Records Found</td>
                        </tr>
                        <?php
                      } ?>       
        </table>
      </div>



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
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
      $('#myTable').DataTable();
  } );


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
