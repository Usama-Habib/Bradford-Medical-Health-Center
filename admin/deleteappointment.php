<?php
include_once '../database/configuration.php';
// Get the variables.
$appid = $_POST['id'];
// echo $appid;

$delete = mysqli_query($conn,"DELETE FROM appointment WHERE booking_id=$appid");
// if(isset($delete)) {
//    echo "YES";
// } else {
//    echo "NO";
// }

?>

