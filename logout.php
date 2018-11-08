<?php 

require "controls/ovais.php";
page_protect();
$date = date("Y-m-d H:i:s");
activity_log(basename($_SERVER['PHP_SELF']),"User Logged Out Successfully.(".$_SESSION['full_name'].")","No Risk",$_SESSION['user_id'],$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
logout();
mysqli_close($con);
?> 