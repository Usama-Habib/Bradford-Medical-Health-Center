<?php
include_once ('database/configuration.php');
session_start();
if (empty($_SESSION['login_user'])){
    header("Location: home.php"); /* Redirect browser */
    exit();
  }else{
  
  define("FIELD_REQUIRED_ERROR", "This field is required");
  // define variables and set to empty values
  $phoneErr = "";
  $phone = "";
  $fname = $_SESSION['user_firstname'];
  $lname = $_SESSION['user_lastname'];
  $dateofbirth = "";
  $any_error = "";

  $existing_bookings = "SELECT validator FROM (SELECT * FROM APPOINTMENT WHERE doc_id = '". $_GET['doc'] ."' AND reg_date >= curdate() ORDER BY reg_date DESC LIMIT 10) sub ORDER BY booking_id DESC";

  $cur_patient = "SELECT * FROM patients WHERE email like ('". $_SESSION['login_user'] ."')";
  $result_pat = $conn->query($cur_patient);
  $pat_count = $result_pat->num_rows;

  if ($result_pat->num_rows > 0) {
    while($row = $result_pat->fetch_assoc()) {
        $dateofbirth = $row['dob'];
        $phone = $row['phone'];
      }
  }


  // if ($pat_count > 0) {
  //   // WHICH MEANS THIS PATIENT IS ALREADY THERE IN OUR DATABASE AND WE DO HAVE 
  //   // INFORMATION ABOUT HIS DOB AND PHONE NUMBER
  // }esle{
  //   // THIS IS A NEW PATIENT, WE NEED HIM TO STORE HIS DOB AND PHONE NUMBER.
  // }

  $booked_slots = $conn->query($existing_bookings);
  $alreadyBookedSlots = $booked_slots->fetch_all(MYSQLI_ASSOC);
    
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    // IF FORM IS SUBMITTED THEN ...

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    

    // Phone Number
    // if ($pat_count === 0){
    //   if (empty($_POST["pphone"])) {
    //     echo "<script>alert('pphone is empty')</script>";
    //     $phoneErr = FIELD_REQUIRED_ERROR;
    //   }elseif(strlen(test_input($_POST['pphone'])) <= 8 || strlen(test_input($_POST['pphone'])) >= 15){
    //     $phoneErr = "It should be a valid mobile number";
    //   }else{
    //     $phone = test_input($_POST['pphone']);
    //   }
    // }



        // DON'T ADD PATIENT IF HE EXISTS ALREADY.
        if ($pat_count > 0) {

            $date = explode(' ', $_POST['time_slot'])[1];
            $slot = explode(' ', $_POST['time_slot'])[2];
            $probStartTime = explode(' ', $_POST['time_slot'])[3];
            $actualEndTime = explode(':', $probStartTime)[0] + 1 . ":00";
            $pat_id = "";
            $cur_patient = "SELECT * FROM patients WHERE email like ('". $_SESSION['login_user'] ."')";
            $result_pat = $conn->query($cur_patient);
            if ($result_pat->num_rows > 0) {
              while($row = $result_pat->fetch_assoc()) {
                  $pat_id = $row['pat_id'];
                }
            }


            $add_appointment = "INSERT INTO appointment VALUES (DEFAULT,'".$pat_id."', '".$_GET['doc']."', '".$slot."','".$_POST['reason']."', '".$date."', '".$probStartTime."', '".$actualEndTime."','". str_replace("'", '', test_input($_POST['note'])) ."', DEFAULT ,'".$_POST['time_slot']."')";
            if ($conn->query($add_appointment) === TRUE) {
               // APPOINTMENT ADDED SUCCESSFULLY
              // Send email to user with the token in a link they can click on
                $to = $email;
                $subject = "Your Appointment has booked with bmchealthconsultant.com";
                $msg = "Thanks for appointment," . '<br>' ." Your registration is made with the email you provided " . $email . "<br>". "Below are patients details: <br>" . "Patient Name: ".$fname . "<br>" . "Date of Appointment " . $date . "( " . $slot . " )";
                $msg = wordwrap($msg,70);
                $headers = "From: info@bmchealthconsultant.com";
                mail($to, $subject, $msg, $headers);
                header('Location: appointment_success.php');

               }else{
                  $any_error = "Error: " . $add_appointment . "<br>" . $conn->error;
               }
            }else{
              if (empty($_POST["pphone"])) {
                $phoneErr = FIELD_REQUIRED_ERROR;
              }elseif(strlen(test_input($_POST['pphone'])) <= 10 || strlen(test_input($_POST['pphone'])) > 15){
                $phoneErr = "It should be a valid mobile number";
              }else{
                $phone = test_input($_POST['pphone']);
              }
              $dateofbirth =  test_input($_POST['pdob']);
              $email = $_SESSION['login_user'];

              // IF THERE EXIST NO ERRORS THEN ...
              if (empty($phoneErr)) {

                $date = explode(' ', $_POST['time_slot'])[1];
                $slot = explode(' ', $_POST['time_slot'])[2];
                $probStartTime = explode(' ', $_POST['time_slot'])[3];
                $actualEndTime = explode(':', $probStartTime)[0] + 1 . ":00";
                
                // ADD NEW PATIENT
                $addNewPatient = "INSERT INTO patients VALUES (default,'".$fname."','".$lname."','".$dateofbirth."','".$email."','".$phone."')";
                if ($conn->query($addNewPatient) === TRUE) {
                      // REDIRECT TO CONFIRMATION PAGE
                      // MAKE AN APPOINTMENT
                      $pat_id = $conn->insert_id;
                      $add_appointment = "INSERT INTO appointment VALUES (DEFAULT,'".$pat_id."', '".$_GET['doc']."', '".$slot."','".$_POST['reason']."', '".$date."', '".$probStartTime."', '".$actualEndTime."','". str_replace("'", '', test_input($_POST['note'])) ."', DEFAULT ,'".$_POST['time_slot']."')";
                       // $add_appointment = "INSERT INTO appointment VALUES (DEFAULT,'".$pat_id."', '".$_GET['doc']."', '".$slot."','".$_POST['reason']."', '".$date."', '".date("g:i", strtotime($time))."', '".date("g:i", strtotime($time) + 1*60*60)."','".$_POST['time_slot']."')";
                      
                      if ($conn->query($add_appointment) === TRUE) {
                         // APPOINTMENT ADDED SUCCESSFULLY
                        // Send email to user with the token in a link they can click on
                        $to = $email;
                        $subject = "Your Appointment has booked with bmchealthconsultant.com";
                        $msg = "Thanks for appointment," . '<br>' ." Your registration is made with the email you provided " . $email . "<br>". "Below are patients details: <br>" . "Patient Name: ".$fname . "<br>" . "Date of Appointment " . $date . "( " . $slot . " )";
                        $msg = wordwrap($msg,70);
                        $headers = "From: info@bmchealthconsultant.com";
                        mail($to, $subject, $msg, $headers);
                        header('Location: appointment_success.php');

                       }else{
                          $any_error = "Error: " . $add_appointment . "<br>" . $conn->error;
                       }

                  } else {
                    $any_error = "Error: " . $addNewPatient . "<br>" . $conn->error;
                  }

              }

        }
  }
 ?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Book Appointment </title>

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

.container_apmnt{
  width: 80%;
  max-width: 800px;
  margin: 0 auto;
  /*padding: 1px;*/
  margin-top: 8rem;
  background-color: #ebebeb;
  /*border:1px solid black;*/
   box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.container_apmnt h2{
    /*border:1px solid red;*/
    margin-top: 0px;
    background-color: white;
    padding: 15px;
}


.detail_box{
  max-width: 30%;
  /*border:1px solid red;*/
  overflow: auto;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

/* Hide scrollbar for Chrome, Safari and Opera */
.detail_box::-webkit-scrollbar {
    display: none;
}

.detail_box input,select,textarea{
  width: 100%;
  max-width: 100%;
  margin-bottom: 0.6rem;
  padding: .4rem;
}

.detail_box textarea{
  padding-bottom: 0px;
}

.container_apmnt_bottom{
  display: flex;
  justify-content: center;
  padding: 15px;
  background-color: white;
}
.container_apmnt_bottom button{
  padding: 10px;
  width: 20rem;
  margin-left: 1rem;
  max-width: 30rem;
}

.container_apmnt_bottom a{
  padding: 10px;
  max-width: 30rem;
  width: 20rem;
  margin-left: 1rem;
}

.container_table{
  width: 80%;
  max-width: 600px;
  margin: 0 auto;
  padding: 8px;
  margin-top: 1rem;
  border-radius: 1rem;
  border:2px solid #e0ac1c;
}

.schedule{
  padding: 20px;
  /*border:1px solid red;*/
  width: 67%;
  background-color: white;
  border:1px solid lightgrey;
}


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  /*overflow: hidden;*/
}
td{
  border:1px solid white;
  padding: 8px;
  font-size: 1.15em;
  background-color: skyblue;
}

th{
  padding: 4px;
}

table td:hover{
  cursor: pointer;
  background-color: orange;
}

.table_container{
  max-height: 340px;
  overflow-x: auto;
  overflow-y: auto;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

/* Hide scrollbar for Chrome, Safari and Opera */
.table_container::-webkit-scrollbar {
    display: none;
}


.error{
  color: orange;
  font-size: 0.9em;
}

.docschdule{
  max-width: 100%;
  min-width: 90px;
  /*min-height: 90px;*/
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


    <!-- Body starts here -->


    <div class="container_apmnt">

     <h2>Book Appointment<span style="float: right; color: orange;font-style: italic; font-size: 0.5em;" ><?php echo $any_error;?></span></h2>

      <form method="post">
        <div style="padding: 20px; display: flex; justify-content: space-between; max-height: 65vh; ">
          <div class="detail_box">
            <!-- left box -->
            <label for="pfname">First Name</label><br>
            <input disabled value="<?php echo $fname?>" required="required" type="text" name="pfname" id="pfname" placeholder="Patient's First Name">
        <!--     <span class="error"><?php if (strlen($fnameErr) > 0) { echo "<br>" . $fnameErr . "<br>"; } ?></span> -->
            <label for="plname">Last Name</label><br>
            <input disabled value="<?php echo $lname?>" required="required" type="text" name="plname" id="plname" placeholder="Patient's Last Name">
           <!--  <span class="error"><?php if (strlen($lnameErr) > 0) { echo "<br>" . $lnameErr . "<br>"; } ?></span> -->
            <label  for="pdob">Date of Birth</label><br>

            <input 
              value="<?php 
                  echo $dateofbirth;
                  ?>"
              <?php 
                if($pat_count > 0){
                    if ($result_pat->num_rows > 0) {
                        echo "disabled";
                    }
                  }
              ?>
              required="required" 
              max="<?php 
                $date = strtotime(date('Y-m-d') . '-18 year');
                $max_dob = date('Y-m-d',$date);
                echo $max_dob;
                ?>" 
              type="date" 
              name="pdob" 
              id="pdob" 
              placeholder="Patient's DOB">
            <br>
            
            <label for="pphone">Mobile</label><br>
            <input 
              type="text" 
              name="pphone" 
              id="pphone"
              required
              placeholder="Patient's Mobile Number" 
              value="<?php 
                // if($pat_count > 0){
                //     if ($result_pat->num_rows > 0) {
                //         var_dump($result_pat->fetch_assoc());
                //         // echo '<pre>';
                //         // var_dump($result_pat->fetch_assoc());
                //         // echo '</pre>';
                //       while($row = $result_pat->fetch_assoc()) {
                //         echo $row["phone"];
                //       }
                //     }
                //   }else{
                //     echo $phone;
                //   } 
              echo $phone;
              ?>"
              <?php 
                if($pat_count > 0){
                    if ($result_pat->num_rows > 0) {
                        echo "disabled";
                    }
                  }
              ?>
            > 
              <span class="error">
                <?php if (strlen($phoneErr) > 0) { echo "<br>" . $phoneErr ; } ?>
              </span> 
            <br>

            <label for="reason">Reason for visit</label><br>
            <select name="reason" id="reason">
              <option value="Routine or follow-up visit">Routine or follow-up visit</option>
              <option value="I have a new medical issue">I have a new medical issue</option>
              <option value="I have a concern or question about my medication">Question about my medication</option>
              <option value="My reason is not listed here">My reason is not listed here</option>   
            </select>

            <br>
            <label for="note">Say something to your doctor</label><br>
            <textarea maxlength="100" id="note" name="note" minlength="0"></textarea>  

            <!-- <hr style="height:1px;border-width:0;color:black;background-color:black">

            <label for="dname">Doctor</label>
            <input type="text" name="dname" id="dname" disabled="disabled" value="Usama">
            <br>
            <label for="dfee">Fee</label><br>
            <input type="text" name="dfee" id="dfee" disabled="disabled" value="300$">
            <br>
            <label for="daddress">Address</label><br>
            <input type="text" name="daddress" id="daddress" disabled="disabled" value="Here is my clinic address">            
            <br>

            <label for="dspec">Specialist In</label><br>
            <input type="text" name="dspec" id="dspec" value="Doctor's specialization" disabled="disabled">  
            <br> -->

          </div>

          <div class="schedule">
            <div class="table_container">
                <!-- right box or calender -->
                <table>

        <?php
        for ($i=0; $i < 12 ; $i++) {
        $day_on = ($i + 1) . 'day';
        $date = strtotime(date('Y-m-d') . $day_on); 
        if (date('l',$date) == 'Saturday' || date('l',$date) == 'Sunday') {
          continue;
        }
        $daytoday = date('l',$date);

        // Let me add a new row 

        ?>

        <tr>
          <!-- 1) Row Head i.e. Monday, Tuesday, Wednesday      -->
          <td style=" margin-right: 0px; padding-right: 0px; text-transform: uppercase; background-color: orange; color: white; font-weight: bolder;"><?php echo $daytoday ."<br>" . "<span style='font-size: 0.7em;'>" . date('Y-m-d', $date) . "</span>" ; ?></td>
          <!-- 2) Now let's add schedule -->
          <?php
                $select_doc_schedule = "SELECT * FROM schedule WHERE doc_id = '".$_GET['doc']."' AND day like '%$daytoday%'";
                $result = $conn->query($select_doc_schedule);
                $row = $result->fetch_assoc();
                $noofslots = (strtotime($row['time_till'])-strtotime($row['time_from']))/(3600);


                // Split doctors daily schedule into one hour slot example doctor's start time (1pm) end time(5pm) so end result would be 1:00-2:00, 2:00-3:00, 3:00-4:00,... 
                for ($j=0; $j < $noofslots; $j++) { 
                  $slot_val = $daytoday .' '. date('Y-m-d', $date) .' '. ($j+1) . ' ' . date("g:i A", strtotime($row['time_from']) + ($j*60*60) );
                  // $date_plus_slot = date('Y-m-d', $date) .' '. ($j+1);
                 ?>
                 <!-- EACH ROW including already booked slots and not booked yet -->
                <td class="docschdule" title="<?php 
                  for ($k=0; $k < sizeof($alreadyBookedSlots); $k++) { 
                    if ($alreadyBookedSlots[$k]['validator'] == $slot_val) {
                      echo  'Already Booked';
                    } 
                  } ?>" 
                  
                  data-slot="<?php echo $slot_val; ?>"
                  id="<?php echo $slot_val;?>"
                  onclick="changeBackground(this)" 
                  style="<?php  
                  for ($k=0; $k < sizeof($alreadyBookedSlots); $k++) {
                    if ($alreadyBookedSlots[$k]['validator'] == $slot_val) {
                      echo  'background-color: red; text-transform: uppercase; color: white;';
                    } 
                  } ?>">
                  <?php echo date("g:i A", strtotime($row['time_from']) + ($j*60*60) );  ?>
                </td>
                 <?php
               }?>
        </tr>
      <?php } 
      ?>
      </table>
            </div>
            
              <!-- <label>Appointment date</label> -->
              <input id="time_slot" name="time_slot" type="hidden">
              <!-- <input disabled="disabled" id="appointment_date" required="required" max="<?php echo date('Y-m-d',strtotime(date('Y-m-d') . '5 day'))?>" min="<?php echo date('Y-m-d')?>" style="padding: 0.4rem; margin: 0.4rem 0; " type="date" name="appointment_date" value="<?php echo date('Y-m-d')?>"> -->
          </div>

        </div>
          <div class="container_apmnt_bottom">
             <a style="text-decoration: none; border:1px solid black; text-align: center;" href="appointment.php">CANCEL</a>
             <button title="Kindly select appointment date" type="submit" id="booknow" disabled="disabled" name="submit" style="background-color: orange; border-color: orange; color: white;">BOOK NOW</button>
          </div>
      </form>
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

    <script type="text/javascript">
      let selected_slots = [];

      function changeBackground(event){
        // SUBMIT BUTTON
        let btn_book = document.getElementById('booknow');

        // IF ALREAY BOOK THEN AVOID IT'S BOOKING AGAIN
        if (event.style.backgroundColor == 'red') {
        }
        // INCASE NOTHING IS SELECTED
        else if (selected_slots.length == 0) {
          event.style.backgroundColor = 'orange';
          let slot = event.getAttribute('data-slot');
          selected_slots.push(slot);
          // document.getElementById('appointment_date').value = event.getAttribute('data-date');
          btn_book.disabled = false;
          btn_book.title = "Book Appointment";
          // console.log(selected_slots);
          document.getElementById('time_slot').value = selected_slots;
        }

        // IF A SLOT IS SELECTED THEN REPLACE IT WITH A NEWLY SELECTED 
        else if(selected_slots.length == 1){
          
          // IF THE SELECTED ONE IS CLICKED THEN DISABLED IT
          if (selected_slots == event.getAttribute('data-slot')) {
              event.style.backgroundColor = 'skyblue';
              selected_slots.pop();
              btn_book.disabled = true;
              btn_book.title = "Kindly select appointment time";
          }else{
              event.style.backgroundColor = 'orange';
              // remove color now
              document.getElementById(selected_slots[0]).style.backgroundColor = 'skyblue';
              selected_slots.pop();

              let slot = event.getAttribute('data-slot');
              selected_slots.push(slot);
              btn_book.disabled = false;
              btn_book.title = "Book Appointment";
              // document.getElementById(selected_slots).value = selected_slots;
              document.getElementById('time_slot').value = selected_slots;

          }
        } 
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
</body>
</html>


<?php
  }
?>