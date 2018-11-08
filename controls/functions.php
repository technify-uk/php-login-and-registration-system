<?php 

//Test the IP is Either Blocked or Not
function blockedips($ip){
global $con;
$ip = $ip;
$checkip = "SELECT * FROM blocked_ips where ip = '$ip'";
$fetchit = mysqli_num_rows(mysqli_query($con,$checkip));
if ($fetchit > 0) {
  return true;
}
else{
  return false;
}

}

 function referredby($id){

global $con;
$uid = $id;
$idi = "SELECT full_name from users where id = '$uid'";
$checkit = mysqli_query($con,$idi);
$refer = mysqli_fetch_row($checkit);
$referredby = $refer[0];
echo strtoupper($referredby);

}

function isBlock($ip){

  global $con;
  $ip = $ip;
  $checkip = "SELECT * FROM blocked_ips where ip = '$ip'";
$fetchit = mysqli_num_rows(mysqli_query($con,$checkip));
if ($fetchit > 0) {
  return true;
}
else{
  return false;
}

}

function filter($data) {
  global $con;
  $data = trim(strip_tags(htmlentities($data)));
  
  if (get_magic_quotes_gpc())
    $data = stripslashes($data);
  
$data = mysqli_real_escape_string($con,$data);
  
  return $data;
}



function EncodeURL($url)
{
$new = strtolower(ereg_replace(' ','_',$url));
return($new);
}

function DecodeURL($url)
{
$new = ucwords(ereg_replace('_',' ',$url));
return($new);
}

function ChopStr($str, $len) 
{
    if (strlen($str) < $len)
        return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
            $str = substr($str,0,$spc_pos);

    return $str . "...";
} 

function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function GenPwd($length = 7)
{
  $password = "";
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;

}

function GenKey($length = 7)
{
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;

}


function logout()
{
global $con;
session_start();

$sess_user_id = strip_tags(mysqli_real_escape_string($con, $_SESSION['user_id']));
$cook_user_id = strip_tags(mysqli_real_escape_string($con, $_COOKIE['user_id']));

if(isset($sess_user_id) || isset($cook_user_id)) {
$queryupdate =  "update `users` set `ckey`= '', `ctime`= '' where `id`='$sess_user_id' OR  `id` = '$cook_user_id'" or die("Error in the query" . mysqli_error($con));
mysqli_query( $con,$queryupdate);
}   

/************ Delete the sessions****************/
unset($_SESSION['user_id']);
unset($_SESSION['full_name']);
unset($_SESSION['user_level']);
unset($_SESSION['user_email']);
unset($_SESSION['HTTP_USER_AGENT']);
session_unset();
session_destroy(); 

/* Delete the cookies*******************/
setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_email", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");

header("Location: login.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null)
{
    if ($salt === null)     {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else     {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

function checkAdmin() {

if($_SESSION['user_level'] == ADMIN_LEVEL) {
return 1;
} else { return 0 ;
}

}
function checkStaff() {

if($_SESSION['user_level'] == STAFF_LEVEL) {
return 1;
} else { return 0 ;
}

}

function checkSuperAdmin() {

if($_SESSION['user_level'] == SUPER_ADMIN_LEVEL) {
return 1;
} else { return 0 ;
}

}


$timezone = "Europe/London"; 
  if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

  // function totalcars($id,$table) {

  //  global $con;
  //  $uid = $id;
  //  $table = $table;
  // $fetch = mysqli_query($con,"SELECT * from $table where usersid = '$uid'");
  //  echo $count = mysqli_num_rows($fetch);
  // }



function admintotalcount($table,$where = "") {

    global $con;
    
    $table = $table;
    $where = $where;
    $gotit = "SELECT * from $table $where";
  $fetch = mysqli_query($con,$gotit);
    echo $count = mysqli_num_rows($fetch);
  }
//hiding super admin from users count function below.....
  function admintotalcounts($table) {

    global $con;
    
    $table = $table;
    $gotit = "SELECT * from $table where user_level != '2689'";
  $fetch = mysqli_query($con,$gotit);
    echo $count = mysqli_num_rows($fetch);
  }


  function emailfetch($id){

global $con;
$uide = $id;
$idie = "SELECT user_email from users where id = '$uide'";
$checkite = mysqli_query($con,$idie);
$refere = mysqli_fetch_row($checkite);
$emailby = $refere[0];
return $emailby;

}


function activity_log($page,$activity,$risk,$user="",$ip,$browser,$start,$email="",$pass=""){

global $con;


$insert = "INSERT INTO `activity_log`(`usersid`, `page`, `activity`, `start`, `risk`, `ip`, `browser`, `email`, `pass`) VALUES ('$user','$page','$activity','$start','$risk','$ip','$browser','$email','$pass')";
$run = mysqli_query($con,$insert);
}


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}


 #generate csrf token
    function generateFormToken($form) {
    
        // generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
      $token = md5(uniqid(microtime(), true));  
      
      // Write the generated token to the session variable to check it against the hidden field when the form is sent
      $_SESSION[$form.'_token'] = $token; 
      
      return $token;
    }

#verify upon form submission
    function verifyFormToken($form) {
        
        // check if a session is started and a token is transmitted, if not return an error
      if(!isset($_SESSION[$form.'_token'])) { 
        return false;
        }
      
      // check if the form is sent with token in it
      if(!isset($_POST['token'])) {
        return false;
        }
      
      // compare the tokens against each other if they are still the same
      if ($_SESSION[$form.'_token'] !== $_POST['token']) {
        return false;
        }
      
      return true;
    }
    

//for general web options....//
$getfun = "SELECT * FROM `general_web_options`";
$web = mysqli_fetch_array(mysqli_query($con,$getfun));
?>