<?php

require_once("../includes/initialize.php");
include_layout_template('header.php');

?>

<?php

if(!isset($_GET['i'])){
    header("Location: index.php");
}

if($_GET['i'] == 1){
    echo "<font color='red'>".output_message("Some error occurred. Click <a href='http://hostels.dtu.ac.in'>here</a> to return.")."</font>";
}


if($_GET['i'] == 2){
    echo "<font color='red'>".output_message("Registration is not open right now. Click <a href='http://hostels.dtu.ac.in'>here</a> to return.")."</font>";
}

if($_GET['i'] == 3){
    echo "<font color='red'>".output_message("Allotment status is not open right now. Click <a href='http://hostels.dtu.ac.in'>here</a> to return.")."</font>";
}

if($_GET['i'] == 4){
    echo "<font color='red'>".output_message("Some error with your database entry. Please get your database entry checked at hostel office. Click <a href='http://hostels.dtu.ac.in'>here</a> to return.")."</font>";
}

if($_GET['i'] == 4){
    echo "<font color='red'>".output_message("Some error with your room allotment. Please get your database entry checked at hostel office. Click <a href='http://hostels.dtu.ac.in'>here</a> to return.")."</font>";
}

if($_GET['i'] == 5){
    echo "<font color='red'>".output_message("Please Login with admin account.")."</font>";
}

?>

<?php  include_layout_template('footer.php');  ?>