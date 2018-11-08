<?php require("dbconfigit.php");
/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/
error_reporting(0);
function page_protect() {
session_start();

global $con;
global $date;
$checkifloginyet = "select `ckey`,`ctime` from `users` where `id` = '$_SESSION[user_id]' OR `id` = '$_COOKIE[user_id]'" or die("Error in the query" . mysqli_error($con)); 
   $adminpanga = mysqli_query($con,$checkifloginyet);
   list($ckeya,$ctimea) = mysqli_fetch_row($adminpanga);
   if (empty($ckeya) || empty($ctimea)) {
     logout();
     exit();
     activity_log(basename($_SERVER['PHP_SELF']),"Ckey and Ctime were reset","High Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
   }

/* Secure against Session Hijacking by checking user agent */
if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
    {
        logout();
        activity_log(basename($_SERVER['PHP_SELF']),"HTTP logout","High Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
        exit();
    }
}


// before we allow sessions, we need to check authentication key - ckey and ctime stored in database

/* If session not set, check for cookies set by Remember me */
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email']) ) 
{
  if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])){
  /* we double check cookie expiry time against stored in database */
  
  $cookie_user_id  = filter($_COOKIE['user_id']);
  $queryw = "select `ckey`,`ctime` from `users` where `id` ='$cookie_user_id'" or die("Error in the query" . mysqli_error($con)); 
  $rs_ctime = mysqli_query($con,$queryw);
  list($ckey,$ctime) = mysqli_fetch_row($rs_ctime);
  // coookie expiry
  if((time() - $ctime) > 60*60*24*COOKIE_TIME_OUT) {

    logout();
    activity_log(basename($_SERVER['PHP_SELF']),"Original Session out","High Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
    }
/* Security check with untrusted cookies - dont trust value stored in cookie.     
/* We also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/

   if(!empty($ckey) && is_numeric($_COOKIE['user_id']) && isEmail($_COOKIE['user_email']) && $_COOKIE['user_key'] == sha1($ckey)) {
      session_regenerate_id(); //against session fixation attacks.
  
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['user_email'] = $_COOKIE['user_email'];
    /* query user level from database instead of storing in cookies */  
      $query1 = "select user_level, full_name from users where id='$_SESSION[user_id]'" or die("Error in the query" . mysqli_error($con)); 
      $getquery = mysqli_query($con,$query1);
      list($user_level,$full_name) = mysqli_fetch_row($getquery);

      $_SESSION['user_level'] = $user_level;
      $_SESSION['full_name'] = $full_name;
      $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
      
     } else {
     logout();
     activity_log(basename($_SERVER['PHP_SELF']),"Last logout system","High Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
     }

  } else {
  header("Location: login.php");
  exit();
  }
}
}
require("functions.php");
?>