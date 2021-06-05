<?php
include_once '../database/configuration.php';
// Get the variables.
$id = $_POST['id'];
// echo $appid;
$delete = mysqli_query($conn,"DELETE FROM doctors WHERE doc_id=$id");

// $delete = mysqli_query($conn,"DELETE FROM schedule WHERE doc_id=$id");
// if(isset($delete)) {
//    echo "YES";
// } else {
//    echo "NO";
// }



?>

