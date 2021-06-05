<?php 
	session_start();
	require 'database/configuration.php';
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

<!-- Charts.css -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">

</head>
<style type="text/css">
		.container2{
			padding-top: 80px;
			font-family: sans-serif;
			margin: 0px auto;
			max-width: 900px;
			border-radius: 5px;
		}
		h2{
			text-align: center;
			color: white;
			border: none;
			border-radius: 15px;
			padding: 10px;
			border-radius: 10px;

		}
		h2 span{
			font-size: 16px;
			background-color: black;
			color: white;
			border-radius: 50%;
			padding: 5px;
		}
		.prescription_container{
			display: inline-flex;
			justify-content: space-around;
			align-items: center;
			padding: 10px;
		}
		.prescription_icon{
			float: left;
			max-width: 20%;
			
		}
		.prescription_text{
			text-align: justify;
			max-width: 75%;
			font-size: 1.3em;
		}
		.ul_outer > li {
			list-style-type: square;
		}

		img{
			width: 150px;
		}

		#my-chart{
			padding-bottom: 50px;
		}

		.net_risk {
			transform-origin: left;
        	animation: revealing-bars 4s linear 1;
		}

		#my-chart .bar {
		  /*height: 250px;*/
		  max-width: 500px;
		  margin: 0 auto;
		  --labels-size: 250px;
		  font-weight: bolder;
		  font-size: 16px;

		}

		@media (min-width: 900px) {
		  #my-chart .bar {
		    /*height: 250px;*/
		    max-width: 900px;
		  }
		  #my-chart td{
		  	margin: 3px;
		  	padding: 10px;
		  	border-radius: 5px;
		  	min-width: 45px;
		  }
		}

		@keyframes revealing-bars {
        0% {width: 100px;}
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


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// AGE
	$my_age = $_POST['age'];

// COVID-19
	// ans ==> HIGH TEMP (weightage, 30)
	// ans1 ==> Continous Cough (weightage,25)
	// ans2 ==> Taste Sense (weightage,10)
	// ans3 ==> Breath Shortness (weightage,10)
	// age ==> (weightage,age>50,25)
	// age ==> (weightage,age < 50 and age >30,15)
	// age ==> (weightage,age < 30,0)

// HIGH BLOOD PRESSURE
	// age ==> (weightage,age>50,25)
	// age ==> (weightage,age < 50 and age >30,15)
	// ans4 ==> Nose Bleed (weightage, 5)
	// ans5 ==> Vision Problem (weightage, 5)
	// ans6 ==> Chest Pain (weightage, 15)
	// ans7 ==> Breath difficutly (weightage, 10)
	// ans8 ==> Blood in urine (weightage, 10)
	// ans9 ==> Severe Headache (weightage, 30)
// HIGH HEART RATE
	// ans10 ==> Stress and anxiety (weightage, 25)
	// ans11 ==> Heavy Alcohal (weightage, 30)
	// ans12 ==> Heart Disease (weightage, 35)
	// age ==> (weigtage,10)

	$covid_risk_level = 0;
	$bp_risk_level = 0;
	$heartRate_risk_level = 0;
	$covid_ageRisk = 0;
	$bp_ageRisk = 0;
	$hr_ageRisk = 0;


	// USING ABOVE GUSSED WEIGHTAGE. Make sure it is not a practical weightage. Just for demonstration purpose
	if ($my_age > 50) {
		$covid_risk_level +=25;
		$bp_risk_level +=25;
		$heartRate_risk_level += 10;
		$covid_ageRisk = 25;
		$bp_ageRisk = 25;
		$hr_ageRisk = 10;
	}elseif ($my_age < 50 && $my_age > 30) {
		$bp_risk_level +=15;
		$covid_risk_level +=15;
		$heartRate_risk_level += 5;
		$covid_ageRisk = 15;
		$bp_ageRisk = 15;
		$hr_ageRisk = 5;
	}

	if ($_POST['ans'] === '1') {
		$covid_risk_level += 30;
	}if ($_POST['ans1'] === '1') {
		$covid_risk_level += 25;
	}if ($_POST['ans2'] === '1') {
		$covid_risk_level += 10;
	}if ($_POST['ans3'] === '1') {
		$covid_risk_level += 10;
	}



	if ($_POST['ans4'] === '1') {
		$bp_risk_level += 5;
	}if ($_POST['ans5'] === '1') {
		$bp_risk_level += 5;
	}if ($_POST['ans6'] === '1') {
		$bp_risk_level += 15;
	}if ($_POST['ans7'] === '1') {
		$bp_risk_level += 10;
	}if ($_POST['ans8'] === '1') {
		$bp_risk_level += 10;
	}if ($_POST['ans9'] === '1') {
		$bp_risk_level += 30;
	}


	if ($_POST['ans10'] === '1') {
		$heartRate_risk_level += 25;
	}if ($_POST['ans11'] === '1') {
		$heartRate_risk_level += 30;
	}if ($_POST['ans12'] === '1') {
		$heartRate_risk_level += 35;
	}

?>
	
	<div class="container2">
		<?php 
		if ($covid_risk_level-$covid_ageRisk > 0) {
			?>
			<h2 style="background-color: <?php 
				if ($covid_risk_level >= 35 && $covid_risk_level <= 70) {
					echo "orange";
				}elseif ($covid_risk_level < 35) {
					echo "green";
				}else
					echo "red";

			?>"
			>
			COVID-19 RISK <span><?php echo $covid_risk_level ?>%</span>
			</h2>
			
		<?php
			if ($my_age > 50) {
				$ageFactor = 25; 
				$htFactor = 30;
				$cough = 25;
				$sense = 10;
				$breath = 10;
			}
			elseif($my_age > 30 && $my_age < 50) {
				$ageFactor = 15;
				$htFactor = 30;
				$cough = 25;
				$sense = 10;
				$breath = 10;
			}
			else{
				$ageFactor = 0; 
				$htFactor = 30;
				$cough = 25;
				$sense = 10;
				$breath = 10;
			}

			if ($_POST['ans'] === '1' && $_POST['ans1'] === '1' && $_POST['ans2'] === '1' && $_POST['ans3'] === '1') {
				# Full prescription
				?>
				<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/virus.png" width="100%">
				</div>
				<div class="prescription_text">
					<p>There are things you can do to treat mild symptoms of coronavirus (COVID-19) while you’re staying at home (self-isolating).</p>
					<ul class="ul_outer">
						<!-- <li>
							If you have a high temperature
							<ul>
								<li>get lots of rest</li>
								<li>drink plenty of fluids (water is best) to avoid dehydration – drink enough so your pee is light yellow and clear</li>
								<li>take paracetamol or ibuprofen if you feel uncomfortable</li>
							</ul>
						</li>
						<li>
							If you have a cough
							<ul>
								<li>avoid lying on your back – lie on your side or sit upright instead</li>
								<li>try having a teaspoon of honey – but do not give honey to babies under 12 months</li>
							</ul>
						</li>
						<li>
							If you feel breathless
							<ul>
								<li>keep your room cool by turning the heating down or opening a window – do not use a fan as it may spread the virus</li>
								<li>sit upright in a chair and relax your shoulders</li>
								<li>try breathing slowly in through your nose and out through your mouth, with your lips together like you're gently blowing out a candle</li>
							</ul>
						</li> -->
						<?php 
						$sql = "SELECT prescription FROM symptomschecker.disease_symp
								inner join symptoms_prescription using(symptom)
								where symptom like ('Covid')";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						  // output data of each row
						  while($row = $result->fetch_assoc()) {
						    echo "<li>" . $row["prescription"] . "</li>";
						  }
						} else {
						  echo "0 results";
						}
						?>
					</ul>
				</div>
			</div>

			<!-- Here is a dummy risk calculation, make sure it is just for the demonstration purpose -->
			<!-- If user's age is above 50
					Age is a major factor in COVID risk calculation
					
					Age Weightage ==> ?
					High Temperature ==> 30
					Cough ==> 25
					Sense ==> 10
					Breath Shortness => 10
			 -->


			<!-- Try Charts.css -->

			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			    <tr>
			      <th scope="row">High Temperature</th>
			      <td style="--size: calc( <?php echo $htFactor/100 ?> )"> <span class="data"> <?php echo $htFactor ?> </span> </td>
			    </tr>
			     <tr>
			      <th scope="row">Continous Cough</th>
			      <td style="--size: calc( <?php echo $cough/100 ?> )"> <span class="data"> <?php echo $cough ?></span> </td>
			    </tr>
			     <tr>
			      <th scope="row">Taste Sense</th>
			      <td style="--size: calc( <?php echo $sense/100 ?> )"> <span class="data"> <?php echo $sense ?></span> </td>
			    </tr>
			    <tr>
			      <th scope="row">Breath Shortness</th>
			      <td style="--size: calc( <?php echo $breath/100 ?> )"> <span class="data"> <?php echo $breath ?></span> </td>
			    </tr>
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
			<?php	
			}else{
				if ($_POST['ans'] === '1') {
				// only HIGH TEMP
				$htFactor = 30;
				$cough = 0;
				$sense = 0;
				$breath = 0;
			?>
			<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/temperature.png" width="100%">
					<p style="text-align: center; font-weight: bolder;">High Temp</p>

				</div>
			<div class="prescription_text">
					<ul>
				<?php 
				$sql = "SELECT prescription FROM symptomschecker.disease_symp
						inner join symptoms_prescription using(symptom)
						where symptom like ('high temperature')";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
				    echo "<li>" . $row["prescription"] . "</li>";
				  }
				} else {
				  echo "0 results";
				}
				?>

					</ul>
				</div>
			</div>
			<!-- Try Charts.css -->

			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			  	
			    <tr>
			      <th scope="row">High Temperature</th>
			      <td style="--size: calc( <?php echo $htFactor/100 ?> )"> <span class="data"> <?php echo $htFactor ?> </span> </td>
			    </tr>
			
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
			<?php	
			}
			if ($_POST['ans1'] === '1') {
				// only Continuous Cough
				$htFactor = 0;
				$cough = 25;
				$sense = 0;
				$breath = 0;
			?>
			<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/cough.png" width="100%">
					<p style="text-align: center; font-weight: bolder;">Cough</p>
				</div>
				<div class="prescription_text">
					<ul>
						<?php 
						$sql = "SELECT prescription FROM symptomschecker.disease_symp
								inner join symptoms_prescription using(symptom)
								where symptom like ('%Continuous Cough%')";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						  // output data of each row
						  while($row = $result->fetch_assoc()) {
						    echo "<li>" . $row["prescription"] . "</li>";
						  }
						} else {
						  echo "0 results";
						}
						?>
					</ul>
				</div>
			</div>
			<!-- Try Charts.css -->

			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			 
			     <tr>
			      <th scope="row">Continous Cough</th>
			      <td style="--size: calc( <?php echo $cough/100 ?> )"> <span class="data"> <?php echo $cough ?></span> </td>
			    </tr>
		
			 
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
			<?php
			}
			if ($_POST['ans2'] === '1') {
				// only Taste Sense
				$htFactor = 0;
				$cough = 0;
				$sense = 10;
				$breath = 0;
			?>
			<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/taste.png" width="100%">
					<p style="text-align: center; font-weight: bolder;">Taste Sense</p>
				</div>
			<div class="prescription_text">
					<ul>
						<?php 
						$sql = "SELECT prescription FROM symptomschecker.disease_symp
								inner join symptoms_prescription using(symptom)
								where symptom like ('%Lost sense of taste%')";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						  // output data of each row
						  while($row = $result->fetch_assoc()) {
						    echo "<li>" . $row["prescription"] . "</li>";
						  }
						} else {
						  echo "0 results";
						}
						?>
					</ul>
				</div>
			</div>
			<!-- Try Charts.css -->

			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			    
			     <tr>
			      <th scope="row">Taste Sense</th>
			      <td style="--size: calc( <?php echo $sense/100 ?> )"> <span class="data"> <?php echo $sense ?></span> </td>
			    </tr>
			    
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
			<?php
			}
			if ($_POST['ans3'] === '1') {
				// only Breath Shortness
				$htFactor = 0;
				$cough = 0;
				$sense = 0;
				$breath = 10;
				?>
			<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/breathing.png" width="100%">
					<p style="text-align: center; font-weight: bolder;">Breath Shortness</p>
				</div>
				<div class="prescription_text">
					<?php 
						$sql = "SELECT prescription FROM symptomschecker.disease_symp
								inner join symptoms_prescription using(symptom)
								where symptom like ('%Shortness of breath%')";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						  // output data of each row
						  while($row = $result->fetch_assoc()) {
						    echo "<li>" . $row["prescription"] . "</li>";
						  }
						} else {
						  echo "0 results";
						}
						?>
				</div>
			</div>
			<!-- Try Charts.css -->

			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			    
			    <tr>
			      <th scope="row">Breath Shortness</th>
			      <td style="--size: calc( <?php echo $breath/100 ?> )"> <span class="data"> <?php echo $breath ?></span> </td>
			    </tr>
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breath+$sense+$cough+$htFactor) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
				<?php
			}
		 }
		}
				
		}
		?>
		
		<?php 
		if ($bp_risk_level-$bp_ageRisk > 0) {?>
		<h2 
		style="background-color: <?php 
		if ($bp_risk_level >= 35 && $bp_risk_level <= 70) {
			echo "orange";
		}elseif ($bp_risk_level < 35) {
			echo "green";
		}else {
			echo "red";
		}
		?>">HIGH BLOOD PRESSURE RISK <span><?php echo $bp_risk_level ?>%</span></h2>

			<?php
			if ($my_age > 50) {
					$ageFactor = 25; 
					$noseBleed = 5;
					$vProblem = 5;
					$chestPain = 15;
					$breathDiff = 10;
					$binU = 10;
					$severeHeadache = 30;
				}
				elseif($my_age > 30 && $my_age < 50) {
					$ageFactor = 15;
					$noseBleed = 5;
					$vProblem = 5;
					$chestPain = 15;
					$breathDiff = 10;
					$binU = 10;
					$severeHeadache = 30;
				}
				else{
					$ageFactor = 0; 
					$noseBleed = 5;
					$vProblem = 5;
					$chestPain = 15;
					$breathDiff = 10;
					$binU = 10;
					$severeHeadache = 30;
				}
				if ($_POST['ans4'] === '1' && $_POST['ans5'] === '1' && $_POST['ans6'] === '1' && $_POST['ans7'] === '1' && $_POST['ans8'] === '1' && $_POST['ans9'] === '1') {
				# Full prescription
			?>
				<div class="prescription_container">
				<div class="prescription_icon">
					<img src="img/bloodpressure.png" width="100%">
				</div>
				<div class="prescription_text">
					<p>These come as tablets and usually need to be taken once a day.</p>
					<ul class="ul_outer">
						<li>
							Common blood pressure medicines include
							<ul>
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%High blood pressure%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			
			<!-- Try Charts.css -->
			<div id="my-chart">
			  <table class="charts-css bar show-data-on-hover show-labels ">

			  <tbody>
			    <tr>
			      <th scope="row">Severe Headache</th>
			      <td style="--size: calc( <?php echo $severeHeadache/100 ?> )"> <span class="data"> <?php echo $severeHeadache ?> </span> </td>
			    </tr>
			     <tr>
			      <th scope="row">Nose Bleed</th>
			      <td style="--size: calc( <?php echo $noseBleed/100 ?> )"> <span class="data"> <?php echo $noseBleed ?></span> </td>
			    </tr>
			     <tr>
			      <th scope="row">Vision Problem</th>
			      <td style="--size: calc( <?php echo $vProblem/100 ?> )"> <span class="data"> <?php echo $vProblem ?></span> </td>
			    </tr>
			    <tr>
			      <th scope="row">Chest Pain</th>
			      <td style="--size: calc( <?php echo $chestPain/100 ?> )"> <span class="data"> <?php echo $chestPain ?></span> </td>
			    </tr>
			    <tr>
			      <th scope="row">Breath Difficuly</th>
			      <td style="--size: calc( <?php echo $breathDiff/100 ?> )"> <span class="data"> <?php echo $breathDiff ?></span> </td>
			    </tr>
			    <tr>
			      <th scope="row">Blood in urine</th>
			      <td style="--size: calc( <?php echo $binU/100 ?> )"> <span class="data"> <?php echo $binU ?></span> </td>
			    </tr>
			    <?php
			    if ($my_age > 30) {
			    ?>
			    <tr>
			      <th scope="row">Age Factor</th>
			      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
			    </tr>
			    <?php }
			    ?>
			    
			    <tr>
			      <th scope="row">Overall Risk</th>
			      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
			    </tr>

			  </tbody>

			</table>
			</div>
			<!-- End Charts.css -->
		<?php	
		}else{
				if ($_POST['ans9'] === '1') {
				$noseBleed = 0;
				$vProblem = 0;
				$chestPain = 0;
				$breathDiff = 0;
				$binU = 0;
				$severeHeadache = 30;
				// only Severe Headache
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/headache.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Severe Headache</p>
						</div>
						<div class="prescription_text">
							<ul class="ul_outer">
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Severe headaches%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
							</ul>
						</div>
					</div>

					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Severe Headache</th>
					      <td style="--size: calc( <?php echo $severeHeadache/100 ?> )"> <span class="data"> <?php echo $severeHeadache ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->


					<?php
				}
				if ($_POST['ans4'] === '1') {
				$noseBleed = 5;
				$vProblem = 0;
				$chestPain = 0;
				$breathDiff = 0;
				$binU = 0;
				$severeHeadache = 0;
				// only Nose Bleed
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/bleeding.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Nose Bleed</p>
						</div>
						<div class="prescription_text">
							<ul class="ul_outer">
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Nosebleed%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
							</ul>
						</div>
					</div>
					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Nose Bleed</th>
					      <td style="--size: calc( <?php echo $noseBleed/100 ?> )"> <span class="data"> <?php echo $noseBleed ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
					<?php
				}
				if ($_POST['ans5'] === '1') {
				$noseBleed = 0;
				$vProblem = 5;
				$chestPain = 0;
				$breathDiff = 0;
				$binU = 0;
				$severeHeadache = 0;
				// only  Vision problem
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/vision.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Vision Problem</p>
						</div>
						<div class="prescription_text">
							<ul class="ul_outer">
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Vision problem%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>

							</ul>
						</div>
					</div>
					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Vision Problem</th>
					      <td style="--size: calc( <?php echo $vProblem/100 ?> )"> <span class="data"> <?php echo $vProblem ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
					<?php
				}
				if ($_POST['ans6'] === '1') {
				$noseBleed = 0;
				$vProblem = 0;
				$chestPain = 15;
				$breathDiff = 0;
				$binU = 0;
				$severeHeadache = 0;
				// only Chest Pain
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/chestpain.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Chest Pain</p>
						</div>
						<div class="prescription_text">
							<ul class="ul_outer">
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Chest pain%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
							</ul>
						</div>
					</div>
					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Chest Pain</th>
					      <td style="--size: calc( <?php echo $chestPain/100 ?> )"> <span class="data"> <?php echo $chestPain ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
					<?php
				}
				if ($_POST['ans7'] === '1') {
				$noseBleed = 0;
				$vProblem = 0;
				$chestPain = 0;
				$breathDiff = 10;
				$binU = 0;
				$severeHeadache = 0;
				// only Breath difficutly
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/breathing.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Breath difficutly</p>
						</div>
						<div class="prescription_text">
							<ul class="ul_outer">
								<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Difficulty breathing%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
							</ul>
						</div>
					</div>
					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Breath difficutly</th>
					      <td style="--size: calc( <?php echo $breathDiff/100 ?> )"> <span class="data"> <?php echo $breathDiff ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
					<?php
				}
				if ($_POST['ans8'] === '1') {
				$noseBleed = 0;
				$vProblem = 0;
				$chestPain = 0;
				$breathDiff = 0;
				$binU = 10;
				$severeHeadache = 0;	
				// only Blood in urine
					?>
					<div class="prescription_container">
						<div class="prescription_icon">
							<img src="img/urine.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Blood in urine</p>
						</div>
						<div class="prescription_text">
							<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%Blood in urine%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<li>" . $row["prescription"] . "</li>";
									  }
									} else {
									  echo "0 results";
									}
									?>
						</div>
					</div>
					<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Blood in urine</th>
					      <td style="--size: calc( <?php echo $binU/100 ?> )"> <span class="data"> <?php echo $binU ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$breathDiff+$binU+$chestPain+$noseBleed+$vProblem+$severeHeadache) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
					<?php
				}
			}
		}
		?>
		<?php 
		if ($heartRate_risk_level-$hr_ageRisk > 0) {?>
		<h2 style="background-color: <?php 
		if ($heartRate_risk_level <= 70 && $heartRate_risk_level >=35) {
			echo "orange";
		}elseif ($heartRate_risk_level < 35) {
			echo "green";
		}else echo "red"; ?>">
		HIGH HEART RATE RISK <span><?php echo $heartRate_risk_level ?>%</span></h2>
		<?php
			if ($my_age > 50) {
					$ageFactor = 10; 
					$heartDisease = 35;
					$stress = 25;
					$heavyAlcohol = 30;
			}elseif($my_age > 30 && $my_age < 50) {
					$ageFactor = 5;
					$heartDisease = 35;
					$stress = 25;
					$heavyAlcohol = 30;
			}else{
					$ageFactor = 0; 
					$heartDisease = 35;
					$stress = 25;
					$heavyAlcohol = 30;
				}
			if ($_POST['ans10'] === '1' && $_POST['ans11'] === '1' && $_POST['ans12'] === '1') {
				# Full prescription
				?>
				<div class="prescription_container">
					<div class="prescription_icon">
						<img src="img/heartrate.png" width="100%">
					</div>
					<div class="prescription_text">
						<?php 
									$sql = "SELECT prescription FROM symptomschecker.disease_symp
											inner join symptoms_prescription using(symptom)
											where symptom like ('%High heart rate%')";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
									  // output data of each row
									  while($row = $result->fetch_assoc()) {
									    echo "<p>" . $row["prescription"] . "</p>";
									  }
									} else {
									  echo "0 results";
									}
									?>
					</div>
				</div>
			<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Heart Disease</th>
					      <td style="--size: calc( <?php echo $heartDisease/100 ?> )"> <span class="data"> <?php echo $heartDisease ?> </span> </td>
					    </tr>

					    <tr>
					      <th scope="row">Stress & Anxiety</th>
					      <td style="--size: calc( <?php echo $stress/100 ?> )"> <span class="data"> <?php echo $stress ?> </span> </td>
					    </tr>

					    <tr>
					      <th scope="row">Heavy Alcohol</th>
					      <td style="--size: calc( <?php echo $heavyAlcohol/100 ?> )"> <span class="data"> <?php echo $heavyAlcohol ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>

					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
		<?php	
		}else{
			if ($_POST['ans10'] === '1' ) {
				$heartDisease = 0;
				$stress = 25;
				$heavyAlcohol = 0;
				// Stress and anxiety
				?>
				<div class="prescription_container">
					<div class="prescription_icon">
						<img src="img/stress.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Stress and anxiety</p>

					</div>
					<div class="prescription_text">
						<?php 
							$sql = "SELECT prescription FROM symptomschecker.disease_symp
									inner join symptoms_prescription using(symptom)
									where symptom like ('%Stress or anxiety%')";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
							 // output data of each row
							  while($row = $result->fetch_assoc()) {
							    echo "<li>" . $row["prescription"] . "</li>";
							  }
							} else {
							  echo "0 results";
							}
						?>
					</div>
				</div>
				<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Stress & Anxiety</th>
					      <td style="--size: calc( <?php echo $stress/100 ?> )"> <span class="data"> <?php echo $stress ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
				<?php
			}
			if ($_POST['ans11'] === '1' ) {
				$heartDisease = 0;
				$stress = 0;
				$heavyAlcohol = 30;
				// Heavy Alcohal
				?>
				<div class="prescription_container">
					<div class="prescription_icon">

						<img src="img/wine.png" width="100%">
							<p style="text-align: center; font-weight: bolder;">Alcohal</p>

					</div>
					<div class="prescription_text">
						<?php 
							$sql = "SELECT prescription FROM symptomschecker.disease_symp
									inner join symptoms_prescription using(symptom)
									where symptom like ('%Heavy alcohol%')";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
							 // output data of each row
							  while($row = $result->fetch_assoc()) {
							    echo "<li>" . $row["prescription"] . "</li>";
							  }
							} else {
							  echo "0 results";
							}
						?>
						<br>
						<li>Visit the Frank website to <a href="https://www.talktofrank.com/get-help/find-support-near-you"> find local drug treatment services</a>.</li>
					</div>
				</div>
				<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Heavy Alcohol</th>
					      <td style="--size: calc( <?php echo $heavyAlcohol/100 ?> )"> <span class="data"> <?php echo $heavyAlcohol ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
				<?php
			}
			if ($_POST['ans12'] === '1' ) {
				$heartDisease = 35;
				$stress = 0;
				$heavyAlcohol = 0;
				// Heart Disease
				?>
				<div class="prescription_container">
					<div class="prescription_icon">
						<img src="img/heartdisease.png" width="100%">
						<p style="text-align: center; font-weight: bolder;">Heart Disease</p>

					</div>
					<div class="prescription_text">

						<?php 
							$sql = "SELECT prescription FROM symptomschecker.disease_symp
									inner join symptoms_prescription using(symptom)
									where symptom like ('%Heart disease%')";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
							 // output data of each row
							  while($row = $result->fetch_assoc()) {
							    echo "<li>" . $row["prescription"] . "</li>";
							  }
							} else {
							  echo "0 results";
							}
						?>
					</div>
				</div>
				<!-- Try Charts.css -->
					<div id="my-chart">
					  <table class="charts-css bar show-data-on-hover show-labels ">

					  <tbody>
					    <tr>
					      <th scope="row">Heart Disease</th>
					      <td style="--size: calc( <?php echo $heartDisease/100 ?> )"> <span class="data"> <?php echo $heartDisease ?> </span> </td>
					    </tr>
					    
					    <?php
					    if ($my_age > 30) {
					    ?>
					    <tr>
					      <th scope="row">Age Factor</th>
					      <td style="--size: calc( <?php echo $ageFactor/100 ?> )"> <span class="data"> <?php echo $ageFactor ?></span> </td>
					    </tr>
					    <?php }
					    ?>
					    
					    <tr>
					      <th scope="row">Overall Risk</th>
					      <td class="net_risk" style="--size: calc( <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) /100 ?>)"> <span class="data"> <?php echo ($ageFactor+$heartDisease+$stress+$heavyAlcohol) . "%" ?></span> </td>
					    </tr>

					  </tbody>

					</table>
					</div>
			<!-- End Charts.css -->
				<?php
			}
		}
		?>  
	<!-- </div> -->
<?php	
 }
 if ($heartRate_risk_level-$hr_ageRisk === 0 && $covid_risk_level-$covid_ageRisk === 0 && $bp_risk_level-$bp_ageRisk === 0) {
 	echo "<h1>Nothing to display. Try again please</h1>";
	unset($ageRisk);

 }
?>
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

