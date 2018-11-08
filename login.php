<?php 
/*
Welcome to Technify I.T Solutions User Management System, built with PHP and MySqli, designed in Bootstrap.
This code is a complete user management system and offers:
1.  New User Registration with Profile Picture
2.  User Verification System (Manual or Automatic)
3.  Dashboard Page
4.  Profile Page with Additional Information
5.  Profile Picture Update, Password Update, Information Update Settings
6.  Login Page
7.  Forget Password Page
8.  Add New User (if Admin)
9.  Update User Information (if Admin)
10. Website Basic Information
11. User Roles and Access
***********************************************************************************************************
1. User Registration (Bootstrap form with basic information like Email, Password, Profile Image, Name)
***********************************************************************************************************
2. New User Email Verification (You can verify the registered users automatically or mannually. If Automatic : User will fill registration form with his Email, After successful registration he will receive an Email with verification link and activation code. User can click the link or Enter the code to get access to dashboard. Or if Manual Activation is set: User will be informed that his account is created now wait for the Admin to Activate the account.)
--------------------Set these settings in controls/dbconfigit.php---------------------
////////////////////Registration Type (Automatic or Manual)////////////////////////////
 1 -> Automatic Registration (users will receive activation code and they will be automatically approved after clicking activation link)
 0 -> Manual Approval (users will not receive activation code and you will need to approve every user manually)

$user_registration = 1;  (set 0 or 1)
*************************************************************************************************************
3. 



*/
require ('controls/ovais.php');
$err = array();
$msg = array();
$date = date("Y-m-d H:i:s");
echo $_SERVER['REMOTE_ADDR'];
if(isset($_POST['doLogin']))
{

$theip = $_SERVER['REMOTE_ADDR'];
if (blockedips($theip)=='1') {
  $err[] = "IP Has been Blocked.";
  activity_log(basename($_SERVER['PHP_SELF']),"Invalid Login Attempt with Blocked IP.","High Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date,$_POST['usr_email'],$_POST['pwd']);
}

foreach($_POST as $key => $value) {
  $data[$key] = filter($value); // post variables are filtered
}

if(empty($data['usr_email']))
                {
                $err[] = "Email is Required.";
                }
                else {

                // Validate Email
                if(!isEmail($data['usr_email'])) {
                $err[] = "Invalid email address.";
                //header("Location: register.php?msg=$err");
                //exit();
                } 

                 $user_email = $data['usr_email'];
               }

               if(empty($data['pwd']))
                {
                $err[] = "Password is Mandatory.";
                }
                else {
                $pass = $data['pwd'];
              }


//in future we will add username 

if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

$queryuser = "SELECT `id`,`pwd`,`full_name`,`approved`,`user_level`,`user_email` FROM users WHERE $user_cond AND `banned` = '0'" or die("Error Found.");  
$result = mysqli_query($con, $queryuser);
$num = mysqli_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
  
  list($id,$pwd,$full_name,$approved,$user_level,$uuser_email) = mysqli_fetch_row($result);
  
  if(!$approved) {
  //$msg = urlencode("Account not activated. Please check your email for activation code");
  $err[] = "Account not activated. Please check your email for activation code.";
  activity_log(basename($_SERVER['PHP_SELF']),"Attempt to Login with Not Approved Account.(".$full_name.")","Low Risk",$_SESSION['user_id'],$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
  
  //header("Location: login.php?msg=$msg");
   //exit();
   }
   
    //check against salt
  if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
  if(empty($err)){      

     // this sets session and logs user in  
       session_start();
     session_regenerate_id (true); //prevent against session fixation attacks.

     // this sets variables in the session 
    $_SESSION['user_id']= $id;  
    $_SESSION['full_name'] = $full_name;
     $_SESSION['user_email'] = $uuser_email;
    $_SESSION['user_level'] = $user_level;
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
    
    //update the timestamp and key for cookie
    $stamp = time();
    $ckey = GenKey();
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $queryfor = "update users set `ctime`='$stamp', `ckey` = '$ckey', `users_ip` = '$user_ip' where id='$id'"  or die("Error in the query" . mysqli_error($con));
    mysqli_query($con, $queryfor);
    // sendFCM("Welcome Back.","$user_email");
    //set a cookie 
    
     if(isset($_POST['remember'])){
          setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
          setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
          setcookie("user_email",$_SESSION['user_email'], time()+60*60*24*COOKIE_TIME_OUT, "/");
           }
             activity_log(basename($_SERVER['PHP_SELF']),"User Logged in Successfully.(".$full_name.")","No Risk",$_SESSION['user_id'],$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);
           $logwithname = "Dear (".$full_name."). Welcome to LookUp.uk";
          // sendUrlFCM($logwithname,"","$uuser_email");
      header("Location: index.php");
     }
    }
    else
    {
    //$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
    $err[] = "Invalid Login. Please try again with correct user email and password.";
    activity_log(basename($_SERVER['PHP_SELF']),"Invalid Login Attempt. User or Pass Incorrect.","Low Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date,$user_email,$pass);
    //header("Location: login.php?msg=$msg");
    }
  } else {
    $err[] = "Error - Invalid login. No such user exists";
     activity_log(basename($_SERVER['PHP_SELF']),"Invalid Login Attempt. No User Registered with this Email.","Low Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date,$user_email,$pass);
    }   
}
 // echo "<script>alert('hi');</script>";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | <?php echo $web['company_title'];?></title>

    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="Awais Ahmad">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">

     <div class="login-logo">
       <!--  <img src="uploads/inlogo.jpg" width="360px" height="120px"> -->
      </div><!-- /.login-logo -->

  <script type="text/javascript">window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);</script>


<style type="text/css">



.login-box-body{background:#fff !important;}

  body{

    background:url("uploads/loginback.jpg") !important;
background-repeat: repeat !important;
    background-attachment: fixed;
    background-position: center; 
    background-size: 100% 100%;

  }


</style>

   <?php
    /******************** ERROR MESSAGES*************************************************
    This code is to show error messages 
    **************************************************************************/
  if(!empty($err))  {?>
  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Error!</h4><?php
   
    foreach ($err as $e) {
      echo "$e <br>";
      }
    echo "</div>";  
     }
     if(!empty($msg))  { ?>
<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Successful!</h4>
                    <?php
      echo $msg[0]." </div>";

     }
    /******************************* END ********************************/    
    ?>
    <div class="login-box">
    
     
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  id="loginform">
          <div class="form-group has-feedback">
            <input type="email" name="usr_email" id="username" class="form-control" placeholder="Email" required="">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="pwd" id="password" type="password" class="form-control" placeholder="Password" required="">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
               <div class="checkbox icheck">
                

                  <input type="checkbox" value="1" id="remember" name="remember" checked="" style="margin-left: 0px !important; position: relative !important;"> <label for="remember">Remember Me </label>
                            </div>
            </div><!-- /.col -->
          </div>
           <div class="row">
            <div class="col-xs-12">
             <!--  <button type="button"  class="btn btn-primary btn-block btn-flat" onClick="topicSubscribe();"><strong style="letter-spacing: 2px;" >SIGN IN</strong></button> -->
               <button type="submit" name="doLogin" class="btn btn-primary btn-block btn-flat"><strong style="letter-spacing: 2px;" >SIGN IN</strong></button>
            </div><!-- /.col -->
          </div>
          </div>
        </form>

       

        <a href="forgot.php" class="btn btn-warning btn-block btn-flat"><strong style="letter-spacing: 2px;">FORGOT PASSWORD</strong></a><br>
       <!--  <a href="register.php" class="text-center">Register a new membership</a> -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

     <div class="login-box">
    
    
      <div class="login-box-body" style="background:#f9ce1f !important; color:#fff;">
        <p class="login-box-msg">Landing First Time?</p>
       
            <div class="col-xs-12">
              <a class="btn btn-info btn-block btn-flat" href="register.php">Register</a>
            </div><!-- /.col -->
          
     

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    
    
    <!--FirebaseNotification-->
     <!-- <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script> -->
 
    <!-- <script src="firebase.js"></script> -->
    
    <!--  <script>
   
    function topicSubscribe(){
        try {
         window.JSInterface.subscribeTopic($("#username").val());
        }catch(err){}
        try{
             window.webkit.messageHandlers.subscribeTopic.postMessage($("#username").val());
        }catch(err){}
         subscribeTokenToTopic($("#username").val());
          setTimeout(
            function() {
               $("#btnlogin").click();
            },
            2000);
         }
       
       function topicSubscribeInq(){ 
       try {
         window.JSInterface.subscribeTopic($(".username").val());
       }catch(err){}
                 try{
             window.webkit.messageHandlers.subscribeTopic.postMessage($(".username").val());
        }catch(err){}
         subscribeTokenToTopic($(".username").val());
          setTimeout(
            function() {
               $("#doQuick").click();
            },
            2000);
       }
      
    </script> -->
    
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
