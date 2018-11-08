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
$qury = "update feedback set status='1' where id='$get[id]'" or die("Error in the query" . mysqli_error($con)); 	
mysqli_query($con, $qury);

 echo "Active";


}

if($get['cmd'] == 'ban')
{
$queryban = "update feedback set status='0' where id='$get[id]'" or die("Error in the query" . mysqli_error($con)); 	
mysqli_query($con, $queryban);

//header("Location: $ret");  
echo "Pending";
exit();

}
?>