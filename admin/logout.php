<?php
session_start();

if(!isset($_SESSION['adminSession']))
{
 header("Location: admindashboard.php");
}
else if(isset($_SESSION['adminSession'])!="")
{
 header("Location: ../login.php");
}

if(isset($_GET['logout']))
{
 session_destroy();
 unset($_SESSION['adminSession']);
 header("Location: ../login.php");
}
?>