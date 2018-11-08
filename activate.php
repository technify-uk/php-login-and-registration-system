<?php require('controls/ovais.php');
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}
/******** EMAIL ACTIVATION LINK**********************/
if(isset($get['user']) && !empty($get['activ_code']) && !empty($get['user']) && is_numeric($get['activ_code']) ) {
$err = array();
$msg = array();
$user = mysql_real_escape_string($get['user']);
$activ = mysql_real_escape_string($get['activ_code']);
//check if activ code and user is valid
$rs_check = mysqli_query($con,"select id from users where md5_id='$user' and activation_code='$activ'");
$num = mysqli_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$err = "Sorry no such account exists or activation code invalid.";
	header("Location: login.php?err=$err");
	exit();
	}
if(empty($err)) {
// set the approved field to 1 to activate the account
$rs_activ = mysqli_query($con,"update users set approved='1' WHERE 
						 md5_id='$user' AND activation_code = '$activ' ");
$msg = "Thank you. Your account has been activated. Login Now";
header("Location: login.php?msg=$msg");
 }
}
?>