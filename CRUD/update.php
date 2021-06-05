<?php
session_start();
// Include config file
$doctor_note = "";
require_once "../database/configuration.php";
// Processing form data when form is submitted
if(isset($_POST["submit"])){
    // Get hidden input value
    $id = $_POST["id"];  
    // Check input errors before inserting in database
    if(!empty($_POST['doctorNote'])){
        // Prepare an insert statement
       $sql = "UPDATE `appointment` SET `doctor_note` = ? WHERE booking_id = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $doctor_note, $param_id);
            
            // Set parameters
            $doctor_note = $_POST['doctorNote'];
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: ../myCheckups.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT concat(fname,' ',lname) as Name,email,dob,reg_date,probable_start_time,health_issue,patient_note,doctor_note, booking_id FROM
        APPOINTMENT
        INNER JOIN patients USING(pat_id)
        WHERE doc_id = (SELECT doc_id FROM doctors WHERE email = '". $_SESSION['login_user'] ."') AND booking_id = ? ";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["Name"];
                    $email = $row["email"];
                    $dob = $row["dob"];
                    $reg_date = $row["reg_date"];
                    $probable_start_time = $row['probable_start_time'];
                    $health_issue = $row['health_issue'];
                    $patient_note = $row['patient_note'];
                    $doctor_note = $row['doctor_note'];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        // header("location: error.php");
        // exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please fill this form and submit to update record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-row">
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Name</label>
                                <input disabled="disabled" type="text" class="form-control" value="<?php echo $name; ?>">
                            </div>
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Email</label>
                                <input disabled="disabled" type="text" class="form-control" value = "<?php echo $email; ?>"></input>
                            </div>
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Date of Birth</label>
                                <input disabled="disabled" type="text" class="form-control" value = "<?php echo $dob; ?>"></input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Appointment On</label>
                                <input disabled="disabled" type="text" class="form-control" value="<?php echo $reg_date; ?>">
                            </div>
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Time</label>
                                <input disabled="disabled" type="text" class="form-control" value = "<?php echo $probable_start_time; ?>"></input>
                            </div>
                            <div style="padding-left: 0px" class="form-group col-md-4">
                                <label>Health Issue</label>
                                <input disabled="disabled" type="text" class="form-control" value = "<?php echo $health_issue; ?>"></input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div style="padding-left: 0px"  class="form-group col-md-6">
                                <label>Patient's Note</label>
                                <textarea disabled="disabled" style="width: 100%; height: 100px;"><?php echo $patient_note; ?></textarea>
                            </div>
                            <div style="padding-left: 0px" class="form-group col-md-6">
                                <label>Doctor's Note</label>
                                <textarea name="doctorNote" style="width: 100%; height: 100px;"><?php echo $doctor_note; ?></textarea>
                            </div>
                        </div>                      
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="../myCheckups.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>