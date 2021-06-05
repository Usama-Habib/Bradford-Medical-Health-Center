<?php
include_once ('database/configuration.php');
session_start();
if($_SESSION['role'] === -1){

  $select_spec = "SELECT spec_id,specialization_name FROM SPECIALIZATION";
  $spec_result = $conn->query($select_spec);
  define("FIELD_REQUIRED_ERROR", "This field is required");
  // define variables and set to empty values
  $fnameErr = $lnameErr = "";
  $fname = $_SESSION['user_firstname'];
  $lname = $_SESSION['user_lastname'];
  $dateofbirth = $contact = "";
  // $password = "";
  // $email = "";
  // $cfrmpassword = "";
  $errors = [];
  $any_error = "";

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    // IF FORM IS SUBMITTED THEN ...

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    // $password = test_input($_POST['dpass']);
    // $cfrmpassword = test_input($_POST['dcpass']);
    // $email = test_input($_POST['demail']);

    
    // FIRST NAME VALIDATION

    // if (empty($_POST["dfname"])) {
    //   $fnameErr = FIELD_REQUIRED_ERROR;
    // }elseif (strlen(test_input($_POST['dfname'])) <= 2 ) {
    //   $fnameErr = "It should be a valid name";
    // } else {
    //   $fname = test_input($_POST["dfname"]);
    //   // check if name only contains letters and whitespace
    //   if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
    //     $fnameErr = "Only letters and white space allowed";
    //   }
    // }

    // LAST NAME VALIDATION

    // if (empty($_POST["dlname"])) {
    //   $lnameErr = FIELD_REQUIRED_ERROR;
    // }elseif (strlen(test_input($_POST['dlname'])) <= 2 ) {
    //   $lnameErr = "It should be a valid name";
    // } else {
    //   $lname = test_input($_POST["dlname"]);
    //   // check if name only contains letters and whitespace
    //   if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
    //     $lnameErr = "Only letters and white space allowed";
    //   }
    // }

    // MOBILE VALIDATION

    if (empty($_POST["dphone"])) {
      $errors['dphoneErr'] = FIELD_REQUIRED_ERROR;
    }elseif (strlen(test_input($_POST['dphone'])) < 11 ||  strlen(test_input($_POST['dphone'])) > 15 ) {
      $errors['dphoneErr'] = "It should be a valid number";
    } else {
      $contact = test_input($_POST["dphone"]);
    }

    // if(!$password){
    //     $errors['user_password'] = FIELD_REQUIRED_ERROR;
    // }elseif (strlen($password) < 5 OR strlen($password) > 15) {
    //     $errors['user_password'] = "Password field must be in between 5 and 15 characters";
    // }
    // if(!$cfrmpassword){
    //     $errors['user_confirm_password'] = FIELD_REQUIRED_ERROR;
    // }elseif (strlen($cfrmpassword) < 5 OR strlen($cfrmpassword) > 15) {
    //     $errors['user_confirm_password'] = "Password field must be in between 5 and 15 characters";
    // }
    // if($password && $cfrmpassword && strcmp($password,$cfrmpassword) !==0 ){
    //     $errors['user_confirm_password'] = "This must match the password field";
    // }
    $dateofbirth =  test_input($_POST['ddob']);
    

    // IF THERE EXIST NO ERRORS THEN ...
    if (empty($lnameErr) && empty($fnameErr) && empty($errors)) {
        // echo "<br><br><br><br><br>";
        // var_dump($_POST);

        $email_exists = "SELECT * FROM DOCTORS WHERE email LIKE '".$_SESSION['login_user']."'";
        $result = $conn->query($email_exists);
        $totalrows = $result->num_rows;
        if ($totalrows > 0) {
            // Already exists 
              $any_error = "Sorry, try another email";
          }else{
            // Add to database (in DOCTORS AND USERS TABLE)
            $add_doctor = "INSERT INTO DOCTORS VALUES (default,'".$fname."','".$lname."','".$contact."','".$_SESSION['login_user']."','".$dateofbirth."')";
            // $add_new_user = "INSERT INTO USERS (email,password_hash,role) VALUES ('".$email."','".password_hash($password,PASSWORD_DEFAULT)."',1)";



            if ($conn->query($add_doctor) === TRUE) {


                // ADD DOCTOR'S SCHEDULE
                $last_id = $conn->insert_id;
                // ADD DOCTOR'S SPECIALIZATION

                $doc_spec = "INSERT INTO doct_spec VALUES (default, '".$last_id."', '".$_POST['dspec']."')";
                $conn->query($doc_spec); 
                
              // Now doctor has registered himself change his status from -1 (pending) to 1 (approved)
              $change_status = "UPDATE users SET role = 1 WHERE email = '". $_SESSION['login_user'] ."'";
              $conn->query($change_status);
              $_SESSION['role'] = 1;
              
                // CHECK IF HE/SHE HAS MORE THAN ONE SCHEDULE 
                if (isset($_POST['same_schedule'])) {

                // INCASE IF IT IS SAME THROUGH-OUT THE WEEK ...
                  
                  $add_doctor_schedule = "INSERT INTO SCHEDULE VALUES 
                   (default,'".$last_id."','Monday','". date("G:i", strtotime($_POST['startsAt']))."','". date("G:i", strtotime($_POST['endsAt']))."',default) ,
                   (default,'".$last_id."','Tuesday','". date("G:i", strtotime($_POST['startsAt']))."','". date("G:i", strtotime($_POST['endsAt']))."',default), 
                   (default,'".$last_id."','Wednesday','". date("G:i", strtotime($_POST['startsAt']))."','". date("G:i", strtotime($_POST['endsAt']))."',default), 
                   (default,'".$last_id."','Thursday','". date("G:i", strtotime($_POST['startsAt']))."','". date("G:i", strtotime($_POST['endsAt']))."',default), 
                   (default,'".$last_id."','Friday','". date("G:i", strtotime($_POST['startsAt']))."','". date("G:i", strtotime($_POST['endsAt']))."',default)";
                  
                  if ($conn->query($add_doctor_schedule) === TRUE) {
                          // ************************* Here We Go ************************** 
                        exit(header("Location: home.php"));
                         // echo "New record created successfully";
                    } else {
                          $any_error = "Error: " . $add_doctor_schedule . "<br>" . $conn->error;
                    }
                  }else{
                    $add_doctor_schedule = "INSERT INTO SCHEDULE VALUES 
                    (default,'".$last_id."','Monday','". date("G:i", strtotime($_POST['onmondaystartsat']))."','". date("G:i", strtotime($_POST['onmondayendsat']))."', default) , 
                    (default,'".$last_id."','Tuesday','". date("G:i", strtotime($_POST['ontuesdaystartsat']))."','". date("G:i", strtotime($_POST['ontuesdayendsat']))."', default), 
                    (default,'".$last_id."','Wednesday','". date("G:i", strtotime($_POST['onwedstartsat']))."','". date("G:i", strtotime($_POST['onwedendsat']))."', default), 
                    (default,'".$last_id."','Thursday','". date("G:i", strtotime($_POST['onthurstartsat']))."','". date("G:i", strtotime($_POST['onthurendsat']))."', default), 
                    (default,'".$last_id."','Friday','". date("G:i", strtotime($_POST['onfristartsat']))."','". date("G:i", strtotime($_POST['onfriendsat']))."', default)";
                  
                  if ($conn->query($add_doctor_schedule) === TRUE) {
                          // ************************* Here We Go ************************** 
                        exit(header("Location: home.php"));
                         // echo "New record created successfully";
                    } else {
                          $any_error = "Error: " . $add_doctor_schedule . "<br>" . $conn->error;
                    }
                  }
                } 
              else {
              $any_error = "Error: " . $add_doctor . "<br>" . $conn->error;
            }

          }
        
    }
  }
 ?>
<!DOCTYPE html>
<html>

<head>

<title>BMC | Doctor Register </title>

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

.container_dr_bottom{
  display: flex;
  justify-content: center;
  padding: 15px;
  background-color: white;
}
.container_dr_bottom button{
  padding: 10px;
  width: 20rem;
  margin-left: 1rem;
  max-width: 30rem;
}

.container_dr_bottom a{
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

.error{
  color: orange;
  font-size: 0.9em;
}

.schedule_container{
  /*border:1px solid red;*/
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}


.schedule_container input{
  margin-left: 2px;
  padding: .4rem;
}

.weekly_schedule input{
  padding: .4rem;
  margin-left: 10px;
  margin-right: 10px;
  margin-bottom: 7px; 
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
            }elseif(!empty($_SESSION['login_user']) AND ($_SESSION['role'] === -1)){
              $displayName = substr($_SESSION['user_firstname'], 0,1);
              $displayName .= substr($_SESSION['user_lastname'], 0,1);
              $displayName = strtoupper($displayName);
               echo "<li>
                          <div class='dropdown'>
                            <button onclick='myFunction()' class='dropbtn'>".$displayName ."</button>
                            <div id='myDropdown' class='dropdown-content'>
                              <a href='logout.php'>Logout</a>
                            </div>
                          </div>
                    </li>";
            }
            else{
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
     <h2>Doctor's Registration<span style="float: right; color: orange;font-style: italic; font-size: 0.5em;" ><?php echo $any_error;?></span></h2>
      <form method="post">
        <div style="padding: 20px; display: flex; justify-content: space-between; max-height: 65vh; ">
          <div class="detail_box">
            <!-- left box -->
            <label for="dfname">First Name</label><br>
            <input value="<?php echo $_SESSION['user_firstname']?>" required="required" type="text" disabled name="dfname" id="dfname" placeholder="Doctor's First Name">
            <span class="error"><?php if (strlen($fnameErr) > 0) { echo "<br>" . $fnameErr . "<br>"; } ?></span>
            <label for="dlname">Last Name</label><br>
            <input value="<?php echo $_SESSION['user_lastname']?>" required="required" type="text" disabled name="dlname" id="dlname" placeholder="Doctor's Last Name">
            <span class="error"><?php if (strlen($lnameErr) > 0) { echo "<br>" . $lnameErr . "<br>"; } ?></span>
            <label  for="ddob">Date of Birth</label><br>

            <input value="<?php echo $dateofbirth?>" required="required" max="<?php 
            $date = strtotime(date('Y-m-d') . '-25 year');
            $max_dob = date('Y-m-d',$date);
            echo $max_dob;
            ?>" type="date" name="ddob" id="ddob" placeholder="Doctor's DOB">
            <br>
            
            <!-- <label for="demail">Email</label>
            <input value="<?php echo $email?>" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" type="email" name="demail" id="demail">

            <label for="dpass">Password</label>
            <input type="password" placeholder="Type your password" name="dpass" id="dpass" value="<?php echo $password?>">
            <span class="error"><?php if (isset($errors['user_password'])) { echo "<br>" . $errors['user_password'] . "<br>"; }else { echo "";} ?></span>

            <label for="dcpass">Confirm Password</label>
            <input type="password" placeholder="Type your password" name="dcpass"  value="<?php echo $cfrmpassword?>">
            <span class="error"><?php if (isset($errors['user_confirm_password'])) { echo "<br>" . $errors['user_confirm_password'] . "<br>"; } ?></span>
            
 -->
            <label for="dphone">Mobile</label><br>
            <input required="required" value="<?php echo $contact; ?>" type="text" name="dphone" id="dphone" placeholder="Doctor's Mobile Number" >
            <span class="error">
              <?php 
                if (isset($errors['dphoneErr'])) { 
                  echo "<br>" . $errors['dphoneErr'] ; 
                } ?>
              
            </span>  
            <br>

            
            <label for="dspec">Specialist In</label><br>
            <select name="dspec">
              <?php

                if ($spec_result->num_rows > 0) {
                  // output data of each row
                  while($row = $spec_result->fetch_assoc()) {?>
                    <option value=<?php echo $row['spec_id']?>><?php echo $row['specialization_name'] ?></option>;
                    <?php
                        }
                      } else {
                        ?>
                        <option >No category exists</option>
                        <?php
                      }

                ?>  
            </select> 
            <br>

          </div>

          <div class="schedule">
            <!-- right box or calender -->
            <div class="schedule_container">
                <label for="startsAt">Available From</label>
                <input type="time" name="startsAt" id="startsAt" value="13:00" >
                <label style="font-weight: bolder; font-size: 1.5em;">:</label>
                <label for="endsAt">Available Upto</label>
                <input type="time" name="endsAt" id="endsAt" value="16:00">  
            </div>
            <!-- <br> -->
            <input id="same_schedule" onchange="disableWeeklySchedule(this)" type="checkbox" name="same_schedule" >
            <label style="margin-top: 1rem; font-weight: light; color: orange;" for="same_schedule"><i>My timings remain same throughout the week</i></label>
              <div class="weekly_schedule">
                  <br>
                  <input type="time" name="onmondaystartsat" value="13:00">
                  <label style="font-weight: bolder; font-size: 1.2em;">:</label>
                  <input type="time" name="onmondayendsat" value="16:00">
                  <label style="font-weight: bolder; font-size: 1.1em;">On Monday</label>

                  <input type="time" name="ontuesdaystartsat" value="13:00">
                  <label style="font-weight: bolder; font-size: 1.2em;">:</label>
                  <input type="time" name="ontuesdayendsat" value="16:00">
                  <label style="font-weight: bolder; font-size: 1.1em;">On Tuesday</label>

                  <input type="time" name="onwedstartsat" value="13:00">
                  <label style="font-weight: bolder; font-size: 1.2em;">:</label>
                  <input type="time" name="onwedendsat" value="16:00">
                  <label style="font-weight: bolder; font-size: 1.1em;">On Wednesday</label>

                  <input type="time" name="onthurstartsat" value="13:00">
                  <label style="font-weight: bolder; font-size: 1.2em;">:</label>
                  <input type="time" name="onthurendsat" value="16:00">
                  <label style="font-weight: bolder; font-size: 1.1em;">On Thursday</label>


                  <input type="time" name="onfristartsat" value="13:00">
                  <label style="font-weight: bolder; font-size: 1.2em;">:</label>
                  <input type="time" name="onfriendsat" value="16:00">
                  <label style="font-weight: bolder; font-size: 1.1em;">On Friday</label>

              </div>
            </div>

            
        </div>
          <div class="container_dr_bottom">
             <a style="text-decoration: none; border:1px solid black; text-align: center;" href="login.php">CANCEL</a>
             <button type="submit" name="submit" style="background-color: orange; border-color: orange; color: white;">REGISTER ME</button>
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
      function disableWeeklySchedule(event){
        if (event.checked) {document.getElementsByClassName('weekly_schedule')[0].hidden=true;}else{document.getElementsByClassName('weekly_schedule')[0].hidden=false;}
        
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
}else{
  die(header("Location: home.php"));
}
  
?>
