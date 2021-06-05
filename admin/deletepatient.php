<?php
include_once '../database/configuration.php';
// Get the variables.
$icPatient = $_POST['ic'];
// echo $appid;

$delete = mysqli_query($conn,"DELETE FROM patients WHERE pat_id=$icPatient");
// if(isset($delete)) {
//    echo "YES";
// } else {
//    echo "NO";
// }



?>

