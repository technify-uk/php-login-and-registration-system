<?php

include 'controls/ovais.php';

foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

$user = mysqli_real_escape_string($con, $get['user']);

if(isset($get['cmd']) && $get['cmd'] == 'check') {

if(!isUserID($user)) {
echo "Invalid User ID";
exit();
}

if(empty($user) && strlen($user) <=3) {
echo "Enter 5 chars or more";
exit();
}


$qyery = "select count(*) as total from users where user_name='$user'" or die("Error in the query" . mysqli_error($con)); 
$rs_duplicate = mysqli_query($con, $qyery);
list($total) = mysqli_fetch_row($con, $rs_duplicate);

	if ($total > 0)
	{
	echo "Not Available";
	} else {
	echo "Available";
	}
}

?>