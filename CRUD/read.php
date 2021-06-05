<?php
session_start();
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../database/configuration.php";
    
    // Prepare a select statement
    $sql = "SELECT concat(fname,' ',lname) as Name,email,dob,phone,reg_date,probable_start_time,health_issue,patient_note,doctor_note, booking_id FROM
        APPOINTMENT
        INNER JOIN patients USING(pat_id)
        WHERE doc_id = (SELECT doc_id FROM doctors WHERE email = '". $_SESSION['login_user'] ."') AND booking_id = ?";
    
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $conn->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
       .form-row div{
            /*border:1px solid black;*/
            border-top: 1px solid black;
            /*border-radius: 3px;*/
            /*padding: 1px;*/
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["Name"]; ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <p class="form-control-static"><?php echo $row["email"]; ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date of Birth</label>
                            <p class="form-control-static"><?php echo $row["dob"]; ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Appointment On</label>
                            <p class="form-control-static"><?php echo $row["reg_date"]; ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Time</label>
                            <p class="form-control-static"><?php echo $row["probable_start_time"]; ?></p>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Health Issue</label>
                            <p class="form-control-static"><?php echo $row["health_issue"]; ?></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label>Patient's Note</label>
                        <p class="form-control-static"><?php echo $row["patient_note"]; ?></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doctor's Note</label>
                            <p class="form-control-static"><?php echo $row["doctor_note"]; ?></p>
                        </div> 
                    </div>
                    
                    <p><a href="../myCheckups.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>