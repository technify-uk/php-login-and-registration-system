<?php require ('controls/ovais.php');
page_protect();
if(!checkSuperAdmin()) {
header("Location: login.php");
exit();
}


$ret = $_SERVER['HTTP_REFERER'];

foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

if($get['cmd'] == 'approve')
{
$qury = "update users set approved='1' where id='$get[id]'" or die("Error in the query" . mysqli_error($con)); 	
mysqli_query($con, $qury);
$querymail = "select user_email from users where id='$get[id]'" or die("Error in the query" . mysqli_error($con));
$rs_email = mysqli_query($con, $querymail);
list($to_email) = mysqli_fetch_row($rs_email);

$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

$message = 
"Thank you for registering with us. Your account has been activated...

*****LOGIN LINK*****\n
https://ineed4mycar.com

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	@mail($to_email, "INEED4MYCAR | Account Activation", $message,
    "From: \"INEED4MYCAR | ADMIN\" <no-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());


 echo "Active";


}

if($get['cmd'] == 'ban')
{
$queryban = "update users set banned='1' where id='$get[id]'" or die("Error in the query" . mysqli_error($con)); 	
mysqli_query($con, $queryban);

//header("Location: $ret");  
echo "yes";
exit();

}
/* Editing users*/

if($get['cmd'] == 'edit')
{
/* Duplicate user name check */
// $queryDub = "select count(*) as total from `users` where `user_name`='$get[user_name]' and `id` != '$get[id]'" or die("Error in the query" . mysqli_error($con));
// $rs_usr_duplicate = mysqli_query($con, $queryDub);
// list($usr_total) = mysqli_fetch_row($rs_usr_duplicate);
// 	if ($usr_total > 0)
// 	{
// 	echo "Sorry! user name already registered.";
// 	exit;
// 	} 
/* Duplicate email check */	
$checkemaildub = "select count(*) as total from `users` where `user_email`='$get[user_email]' and `id` != '$get[id]'" or die("Error in the query" . mysqli_error($con));
$rs_eml_duplicate = mysqli_query($con, $checkemaildub);
list($eml_total) = mysqli_fetch_row($rs_eml_duplicate);
	if ($eml_total > 0)
	{
	echo "Sorry! user email already registered.";
	exit;
	}
/* Now update user data*/	
$finquery = "
update users set  

`user_email`='$get[user_email]',
`user_level`='$get[user_level]'
where `id`='$get[id]'" or die("Error in the query" . mysqli_error($con));

mysqli_query($con, $finquery);
//header("Location: $ret"); 

if(!empty($get['pass'])) {
$hash = PwdHash($get['pass']);
$querypass = "update users set `pwd` = '$hash', `itsmeadmin` = '$get[pass]' where `id`='$get[id]'" or die("Error in the query" . mysqli_error($con));
mysqli_query($con, $querypass);
}

echo "changes done";
exit();
}

if($get['cmd'] == 'unban')
{
	$queryunban = "update users set banned='0' where id='$get[id]'" or die("Error in the query" . mysqli_error($con));
mysqli_query($con, $queryunban);
echo "no";

//header("Location: $ret");  
// exit();

}


?>