<?php require ("controls/ovais.php");
$err = array();
$msg = array();

$date = date("Y-m-d H:i:s");


/******************* ACTIVATION BY FORM**************************/
if(isset($_POST['doCancel']))
{
header("Location: login.php");  
}
if(isset($_POST['doReset']))
    {
        // $Email=$_REQUEST['user_email'];


foreach($_POST as $key => $value) {
  $data[$key] = filter($value);
}

 if(empty($data['user_email']))
                {
                $err[] = "Email is Required.";
                }
                else {

                // Validate Email
                if(!isEmail($data['user_email'])) {
                $err[] = "Invalid Email Address.";
                //header("Location: register.php?msg=$err");
                //exit();
                } 

                 $user_email = $data['usr_email'];
               }

//check if active code and user is valid as precaution
$fec = "select * from users where user_email='$user_email'"; 
$rs_check = mysqli_query($con, $fec); 
$useit = mysqli_fetch_array($rs_check);
$num = mysqli_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
  $err[] = "Error - Sorry no such account exists or registered.";
  activity_log(basename($_SERVER['PHP_SELF']),"Invalid Reset Password Attempt. No User Registered with this Email.","Medium Risk",$user='',$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date,$user_email,$pass="");
  //header("Location: forgot.php?msg=$msg");
  //exit();
  }


if(empty($err)) {

$new_pwd = GenPwd();
$pwd_reset = PwdHash($new_pwd);
//$sha1_new = sha1($new); 
//set update sha1 of new password + salt
$dwx = "update users set pwd='$pwd_reset', itsmeadmin='$new_pwd' WHERE 
             user_email='$user_email'" or die("Error in the query" . mysqli_error($con));
$rs_activ = mysqli_query($con, $dwx);
             if ($rs_activ == 1) {
               
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);             
             
//send email

// $message = 
// "Here are your new password details ...\n
// User Email: $user_email \n
// Password: $new_pwd \n

// Thank You,

// Administrator
// $host_upper
// ______________________________________________________
// THIS IS AN AUTOMATED RESPONSE. 
// ***DO NOT RESPOND TO THIS EMAIL****
// ";

//   mail($user_email, "Reset Password", $message,
//     "From: \"I NEED 4 MY CAR\" <no-reply@$host>\r\n" .
//      "X-Mailer: PHP/" . phpversion());   


$to = $user_email;

$subject = 'Account Information Modification.';

$headers = "From: \"LOOKUP.UK\" <no-reply@lookup.uk> \r\n";
$headers .= "Reply-To: info@lookup.uk \r\n";
$headers .= "CC: info@lookup.uk\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = "<!doctype html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

<title>Account Modification | LOOKUP.UK</title>

<style type='text/css'>
  .ReadMsgBody {width: 100%; background-color: #ffffff;}
  .ExternalClass {width: 100%; background-color: #ffffff;}
  body   {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Georgia, Times, serif}
  table {border-collapse: collapse;}

  @media only screen and (max-width: 640px)  {
          .deviceWidth {width:440px!important; padding:0;}
          .center {text-align: center!important;}
      }

  @media only screen and (max-width: 479px) {
          .deviceWidth {width:280px!important; padding:0;}
          .center {text-align: center!important;}
      }

</style>
</head>

<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='font-family: Georgia, Times, serif'>

<!-- Wrapper -->
<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center'>
  <tr>
    <td width='100%' valign='top' bgcolor='#ffffff' style='padding-top:20px'>

      <!-- Start Header-->
      <table width='580' border='0' cellpadding='0' cellspacing='0' align='center' class='deviceWidth' style='margin:0 auto;'>
        <tr>
          <td width='100%' bgcolor='#ffffff'>

                            <!-- Logo -->
                            <table border='0' cellpadding='0' cellspacing='0' align='center' class='deviceWidth'>
                                <tr>
                                    <td style='padding:10px 20px' class='center'>
                                        <a href='#'><img src='https://ineed4mycar.com/uploads/inlogo.jpg' alt='INEED4MYCAR' border='0' width='200'/></a>
                                    </td>
                                </tr>
                            </table><!-- End Logo -->

                            

          </td>
        </tr>
      </table><!-- End Header -->

      <!-- One Column -->
      <table width='580'  class='deviceWidth' border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#eeeeed' style='margin:0 auto;'>
        
                <tr>
                    <td style='font-size: 13px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px' bgcolor='#eeeeed'>

                        <table>
                            <tr>
                                
                                <td valign='middle' style='padding:0 10px 10px 0'><a href='#' style='text-decoration: none; color: #272727; font-size: 16px; color: #272727; font-weight: bold; font-family:Arial, sans-serif '>Dear ".$useit['full_name'].", Your Account Information has been Updated. </a>
                                </td>
                            </tr>
                        </table>
                       
            
                    </td>
                </tr>
                
      </table><!-- End One Column -->


<div style='height:15px;margin:0 auto;'>&nbsp;</div><!-- spacer -->


            <!-- 2 Column Images & Text Side by SIde -->
            <table width='580' border='0' cellpadding='0' cellspacing='0' align='center' class='deviceWidth' bgcolor='#202022' style='margin:0 auto;'>
                <tr>
                    <td style='padding:10px 0'>
                            
                            <table align='right' width='100%' cellpadding='0' cellspacing='0' border='0' class='deviceWidth'>
                                <tr>
                                    <td style='font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px'>

                                        <table>
                                            <tr>
                                                
                                                <td valign='middle' style='padding:0 10px 10px 0'><a href='#' style='text-decoration: none; font-size: 16px; color: #ccc; font-weight: bold; font-family:Arial, sans-serif '>Your Account Information:</a>
                                                </td>
                                            </tr>
                                        </table>

                                        <h3 style='mso-table-lspace:0;mso-table-rspace:0; margin:0'>
                                            Following Information May be Helpful to Access Your Account.</h3>
                                            <p style='mso-table-lspace:0;mso-table-rspace:0; margin:0'>
                                            Website  : https://ineed4mycar.com<br />
                                            Email    : ".$user_email."<br/>
                                            Password : ".$new_pwd."
                                            <br/>

                                            <table width='100' align='right'>
                                                <tr>
                                                    <td background='https://www.emailonacid.com/images/blog_images/Emailology/2013/free_template_1/blue_back.jpg' bgcolor='#409ea8' style='padding:5px 0;background-color:#409ea8; border-top:1px solid #77d5ea; background-repeat:repeat-x' align='center'>
                                                        <a href='https://ineed4mycar.com'
                                                        style='
                                                        color:#ffffff;
                                                        font-size:13px;
                                                        font-weight:bold;
                                                        text-align:center;
                                                        text-decoration:none;
                                                        font-family:Arial, sans-serif;
                                                        -webkit-text-size-adjust:none;'>
                                                                Login Now
                                                        </a>

                                                    </td>
                                                </tr>
                                            </table>

                                        </p>
                                    </td>
                                </tr>
                            </table>

                    </td>
                </tr>
                <tr>
                    <td bgcolor='#fe7f00'><div style='height:6px'>&nbsp;</div></td>
                </tr>
            </table><!-- End 2 Column Images & Text Side by SIde -->


<div style='height:15px;margin:0 auto;'>&nbsp;</div><!-- spacer -->


           

    </td>
  </tr>
</table> <!-- End Wrapper -->
<div style='display:none; white-space:nowrap; font:15px courier; color:#ffffff;'>
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
</div>
</body>
</html>
";


mail($to, $subject, $message, $headers);          
             
$msg[] = "Your account password has been reset and a new password has been sent to your email address.\n".$user_email;             
 activity_log(basename($_SERVER['PHP_SELF']),"User Password Reset Successfully.(".$useit['full_name'].")","No Risk",$useit['id'],$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$date);            
//$msg = urlencode();
//header("Location: forgot.php?msg=$msg");             
//exit();
 }
}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LOOKUP.UK | PASSWORD MODIFICATION</title>

    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="TECHNIFY.UK">
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
    <style type="text/css"> body{

  background:url("uploads/loginback.jpg") !important;
background-repeat: repeat !important;
    background-attachment: fixed;
    background-position: center; 
    background-size: 100% 100%;

  }</style>
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
  
      <div class="login-logo">
     <!--  <img src="uploads/inlogo.jpg" width="360px" height="120px"> -->
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Enter Your Email To Reset Password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <div class="form-group has-feedback">
            <input type="email" name="user_email" id="email" class="form-control" placeholder="Email" >
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          
          <div class="row">
            
            <div class="col-xs-6">
              <button type="submit" name="doReset" class="btn btn-primary btn-block btn-flat">Reset Password</button>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <button type="submit" name="doCancel" class="btn btn-primary btn-block btn-flat">Cancel</button>
            </div>
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
