<?php
session_start();
include_once '../database/configuration.php';
// include_once 'connection/server.php';
if(!isset($_SESSION['adminSession']))
{
header("Location: ../home.php");
}
$adminsession = $_SESSION['adminSession'];
$sql = "SELECT * FROM users WHERE email = '" . $adminsession . "'";
$res=mysqli_query($conn,$sql);
$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['status_avail'] !== '') {
    // GET VALUES FROM THE FORM.
    $updateAvail = "UPDATE schedule SET availability ='".$_POST['status_avail']."' 
                    WHERE doc_id = '".$_POST['doctor_id']."' ";

    // print_r($updateAvail);
                 
    if (mysqli_query($conn,$updateAvail)) {
        echo "<script>alert('Successfully Updated')</script>";
    }else{
        echo "<script>alert('Query has got some error!!')</script>";
    }

}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Welcome <?php echo $userRow['email'];?></title>
        <!-- Bootstrap Core CSS -->
        <!-- <link href="assets/css/bootstrap.css" rel="stylesheet"> -->
        <link href="assets_/css/material.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets_/css/sb-admin.css" rel="stylesheet">
        <link href="assets_/css/time/bootstrap-clockpicker.css" rel="stylesheet">
        <link href="assets_/css/style.css" rel="stylesheet">
        <link href="assets_/font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

        <!--Font Awesome (added because you use icons in your prepend/append)-->
        <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

        <!-- Inline CSS based on choices in "Settings" tab -->
        <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}
        </style>

        <!-- Custom Fonts -->
    </head>
    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="admindashboard.php">Welcome <?php echo $userRow['email'];?></a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userRow['email']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="adminprofile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            
                            <li class="divider"></li>
                            <li>
                                <a href="logout.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li>
                            <a href="admindashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="addschedule.php"><i class="fa fa-fw fa-table"></i> Doctor Schedule</a>
                        </li>
                        <li>
                            <a href="patientlist.php"><i class="fa fa-fw fa-edit"></i> Patient List</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <!-- navigation end -->

            <div id="page-wrapper">
                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                            Doctor Schedule
                            </h2>
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-calendar"></i> Schedule
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- Page Heading end-->

                    
                    <!-- panel start -->

                     <!-- panel start -->
                    <div class="panel panel-primary filterable">

                        <!-- panel heading starat -->
                        <div class="panel-heading">
                            <h3 class="panel-title">Doctor Schedule</h3>
                            <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        </div>
                        </div>
                        <!-- panel heading end -->

                        <div class="panel-body">
                        <!-- panel content start -->
                           <!-- Table -->
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="filters">
                                    <th><input type="text" class="form-control" placeholder="Doctor" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="ScheduleDay" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="StartTime." disabled></th>
                                    <th><input type="text" class="form-control" placeholder="EndTime" disabled></th>
                                    <th><input type="text" class="form-control" placeholder="Availability" disabled></th>
                                    <th width="20%"><input type="text" class="form-control" placeholder="Delete" disabled></th>

                                </tr>
                            </thead>
                            
                            <?php 
                            $result=mysqli_query($conn,"SELECT concat(d.fname, ' ', d.lname) as Name, day, time_from, time_till, id, doc_id, availability FROM symptomschecker.schedule s 
                              INNER JOIN doctors d USING (doc_id)
                              GROUP BY doc_id
                              ORDER BY s.doc_id;");
                            

                                  
                            while ($doctorschedule=mysqli_fetch_array($result)) {   
                                
                              
                                echo "<tbody>";
                                echo "<tr>";
                                    echo "<td>" . $doctorschedule['Name'] . "</td>";
                                    echo "<td>" . $doctorschedule['day'] . "</td>";
                                    echo "<td>" . $doctorschedule['time_from'] . "</td>";
                                    echo "<td>" . $doctorschedule['time_till'] . "</td>";
                                    echo "<form method='POST'>";
                                    ?> 
                                    <td style="text-align: center;">
                                    <input 
                                    type="radio" 
                                    name="<?php echo $doctorschedule['doc_id']; ?>" 
                                    value="1"
                                    onclick="handleClick(this)"
                                    <?php if ($doctorschedule['availability'] == 1): echo 'checked' ?>
                                    <?php endif ?> 
                                    >
                                    <label> Yes</label>
                                    <input 
                                    type="radio" 
                                    name="<?php echo $doctorschedule['doc_id']; ?>" 
                                    value="0"
                                    onclick="handleClick(this)"
                                    <?php if ($doctorschedule['availability'] == 0): echo 'checked' ?>
                                    <?php endif ?> 
                                    >
                                    <label> No</label>

                                    <?php "</td>";
                                    
                                    echo "<td disabled='disabled' class='text-center'><a disabled='disabled' style=' margin-right: 7px;' href='' id='".$doctorschedule['doc_id']."' class='delete'>Remove</a>";

                                
                            } 
                            ?>
                            <input type="hidden" id="doctor_id" name="doctor_id">
                            <input type="hidden" id="status_avail" name="status_avail">

                            <?php
                                echo "</tr>";
                           echo "</tbody>";
                       echo "</table>";
                       echo "<div class='panel panel-default'>";
                       echo "<div class='col-md-offset-3 pull-right'>";
                       echo "<button class='btn btn-primary' type='submit' value='Submit' name='submit'>Update</button>";
                        echo "</div>";
                        echo "</div>";
                        ?>
                        <!-- panel content end -->
                        <!-- panel end -->
                        </div>
                    </div>
                    <!-- panel start -->
                </div>
            </div>
        <!-- /#wrapper -->


       
        <!-- jQuery -->
        <script src="./patient/assets/js/jquery.js"></script>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="./patient/assets/js/bootstrap.min.js"></script>
        <script src="assets_/js/bootstrap-clockpicker.js"></script>
        <!-- Latest compiled and minified JavaScript -->
         <!-- script for jquery datatable start-->
        <!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
    function handleClick(myRadio) {
    currentValue = myRadio.value;
    document.getElementById('status_avail').value = currentValue;
    document.getElementById('doctor_id').value = myRadio.name;
    console.log('status ' + currentValue + ': doctor ' + myRadio.name);
}


    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
</script>
 <script type="text/javascript">
$(function() {
$(".delete").click(function(){
var element = $(this);
var id = element.attr("id");
var info = 'id=' + id;
if(confirm("Are you sure you want to delete this? " + info))
{
 $.ajax({
   type: "POST",
   url: "deleteschedule.php",
   data: info,
   success: function(){
 }
});
  $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
 }
return false;
});
});

// Availability

// $(function() {
// $(".setAvail").click(function(){
// var element = $(this);
// var id = element.attr("data-docid");
// var status = element.attr("data-availstatus");
// var info = 'did=' + id;
// if(confirm("Are you sure you want to set this to " + status + "? Doctor Id " + id ))
// {
//  $.ajax({
//    type: "POST",
//    url: "deleteschedule.php",
//    data: info,
//    success: function(){
//  }
// });
//   $(this).parent().parent().fadeOut(300, function(){ $(this).remove();});
//  }
// return false;
// });
// });

</script>
<script type="text/javascript">
            /*
            Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
            */
            $(document).ready(function(){
                $('.filterable .btn-filter').click(function(){
                    var $panel = $(this).parents('.filterable'),
                    $filters = $panel.find('.filters input'),
                    $tbody = $panel.find('.table tbody');
                    if ($filters.prop('disabled') == true) {
                        $filters.prop('disabled', false);
                        $filters.first().focus();
                    } else {
                        $filters.val('').prop('disabled', true);
                        $tbody.find('.no-result').remove();
                        $tbody.find('tr').show();
                    }
                });

                $('.filterable .filters input').keyup(function(e){
                    /* Ignore tab key */
                    var code = e.keyCode || e.which;
                    if (code == '9') return;
                    /* Useful DOM data and selectors */
                    var $input = $(this),
                    inputContent = $input.val().toLowerCase(),
                    $panel = $input.parents('.filterable'),
                    column = $panel.find('.filters th').index($input.parents('th')),
                    $table = $panel.find('.table'),
                    $rows = $table.find('tbody tr');
                    /* Dirtiest filter function ever ;) */
                    var $filteredRows = $rows.filter(function(){
                        var value = $(this).find('td').eq(column).text().toLowerCase();
                        return value.indexOf(inputContent) === -1;
                    });
                    /* Clean previous no-result if exist */
                    $table.find('tbody .no-result').remove();
                    /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
                    $rows.show();
                    $filteredRows.hide();
                    /* Prepend no-result row if all rows are filtered */
                    if ($filteredRows.length === $rows.length) {
                        $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
                    }
                });
            });
        </script>

    </body>
</html>