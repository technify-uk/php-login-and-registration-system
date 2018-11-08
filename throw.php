<?php 
require_once('controls/ovais.php');

session_start();

$id = $_POST['id'];
$sess_user_id = strip_tags(mysqli_real_escape_string( $con, $_SESSION['user_id']));

if(isset($sess_user_id) || isset($cook_user_id)) {
$queryupdate = 	"update `users` set `ckey`= '', `ctime`= '' where `id`='$sess_user_id' OR  `id` = '$cook_user_id'" or die("Error in the query" . mysqli_error($con));
mysqli_query( $con,$queryupdate);
}		

/************ Delete the sessions****************/
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_level']);
unset($_SESSION['HTTP_USER_AGENT']);
session_unset();
session_destroy(); 

/* Delete the cookies*******************/
setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");

header("Location: login.php");

?>