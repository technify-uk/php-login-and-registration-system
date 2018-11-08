<?php require('controls/ovais.php');
session_start();
$err = array();
$msg = array();

if(isset($_POST['doRegister']))
{ 

/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
            foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }

                

            if(empty($data['full_name']) || strlen($data['full_name']) < 4)
                {
                $err[] = "Provide Your Name with minimum 4 Letters.";
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

                 $usr_email = $data['usr_email'];
               }

                $user_ip = $_SERVER['REMOTE_ADDR'];

                // stores sha1 of password
                 if(empty($data['pwd']) || strlen($data['pwd']) < 8)
                {
                $err[] = "Password with Minimum 8 Characters is Mandatory.";
                }
                else {
                $sha1pass = PwdHash($data['pwd']);
                }

                // Automatically collects the hostname or domain  like example.com) 
                $host  = $_SERVER['HTTP_HOST'];
                $host_upper = strtoupper($host);
                $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

                // Generates activation code simple 4 digit number
                $activ_code = rand(1000,9999);

                $Logo=$_FILES['photo']['name'];
                move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/profile/".$Logo);

                /************ USER EMAIL CHECK ************************************
                This code does a second check on the server side if the email already exists. It 
                queries the database and if it has any existing email it throws user email already exists
                *******************************************************************/

                $rs_duplicate = mysqli_query ($con, "select count(*) as total from users where user_email='$usr_email'");
                list($total) = mysqli_fetch_row($rs_duplicate);

                if ($total > 0)
                {
                $err[] = "The Email already exists. Please <a href='login.php'>Login Here</a>";
               
                }
                    /***************************************************************************/

                    if(verifyFormToken('form1') && empty($err)) {

         $sql_insert = "INSERT into `users` (`full_name`, `user_email`, `pwd`, `user_level`, `photo`, `address`, `address1`, `city_id`, `country_id`, `tel`, `countrycode`, `date`, `users_ip`, `activation_code`, `post_code`) VALUES ('$data[full_name]','$usr_email','$sha1pass','1','$Logo','$data[address]','$data[address1]','$data[city]','$data[country]','$data[phone]','$data[code]',now(),'$user_ip','$activ_code','$data[zip]')";
                                
                     
                   $addme =  mysqli_query($con,$sql_insert);
                   if ($addme == 1) {
                       
                    $user_id = mysqli_insert_id($con);  
                    $md5_id = md5($user_id);
                    mysqli_query($con, "update users set md5_id='$md5_id' where id='$user_id'");
                    //  echo "<h3>Thank You</h3> We received your submission.";
                   
                        ///////////////////////////////////////////////////////Email theme/////
                        /////////////////////////////////////////////////////////////////////////////////////////////

if($user_registration)  {
$a_link = "
*****ACTIVATION LINK*****\n
http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code
"; 
} else {
$a_link = 
"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
";
}

$to = $usr_email;

$subject = 'Registration Successful | '.$web['company_title'];

$headers = "From: \"".$web['company_title']."\" <".$web['company_email']."> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = "<!doctype html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

<title>Quick Enquiry Received by I Need 4 My Car</title>

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
                                        <a href='#'><img src='".$web['company_domain']."/uploads/".$web['company_logo']."' alt='".$web['company_title']."' border='0' width='200'/></a>
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
                                
                                <td valign='middle' style='padding:0 10px 10px 0'><a href='#' style='text-decoration: none; color: #272727; font-size: 16px; color: #272727; font-weight: bold; font-family:Arial, sans-serif '>Dear ".$data['full_name'].", Thanks for Registering with us :-) </a>
                                </td>
                            </tr>
                        </table>
                       Your Registered Email is : <br /><b> ".$usr_email." </b><br />
            
                    </td>
                </tr>
                <tr>
                                <td align='center'>
                                  <!-- The paragraph tag is important here to ensure that this table floats properly in Outlook 2007, 2010, and 2013
                                    To learn more about this fix check out this link: https://ineed4mycar.com 
                                    This fix is used for all floating tables in this responsive template
                                    The margin set to 0 is for Gmail -->
                                    <p style='mso-table-lspace:0;mso-table-rspace:0; margin:0'>
                                    <img width='267' src='".$web['company_domain']."/uploads/profile/".rawurlencode($Logo)."' alt='Profile Image' border='0' style='border-radius: 50px; width: 267px' class='deviceWidth' /></p>
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
                                                
                                                <td valign='middle' style='padding:0 10px 10px 0'><a href='#' style='text-decoration: none; font-size: 16px; color: #ccc; font-weight: bold; font-family:Arial, sans-serif '>Account Details</a>
                                                </td>
                                            </tr>
                                        </table>

                                        <h3 style='mso-table-lspace:0;mso-table-rspace:0; margin:0'>
                                            Following Information May be Helpful to Access Your Account.</h3>
                                            <p style='mso-table-lspace:0;mso-table-rspace:0; margin:0'>
                                            Website  : https://ineed4mycar.com<br />
                                            Email    : ".$usr_email."<br/>
                                            Password : ".$data['pwd']."<br/>
                                            $a_link;
                                            <br/>

                                            <table width='100' align='right'>
                                                <tr>
                                                    <td background='https://www.emailonacid.com/images/blog_images/Emailology/2013/free_template_1/blue_back.jpg' bgcolor='#409ea8' style='padding:5px 0;background-color:#409ea8; border-top:1px solid #77d5ea; background-repeat:repeat-x' align='center'>
                                                        <a href='".$web['company_domain']."'
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

      <!-- 2 Column Images - text left -->

      <table width='580' border='0' cellpadding='0' cellspacing='0' align='center' class='deviceWidth' bgcolor='#eeeeed' style='margin:0 auto;'>
        <tr>
<td valign='middle' style='padding:0 10px 10px 0'><a href='#' style='text-decoration: none; font-size: 16px; color: #ccc; font-weight: bold; font-family:Arial, sans-serif '>About ineed4mycar.com</a></td>
<td  style='font-size: 13px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px'>INEED4MYCAR is an online Platform which we have designed to simplify the ordering of car parts for your car ! All you have to do is send us an Enquiry for the spare parts you need for your car and we make sure the parts we Quote are the right ones to fit your car, leaving you free to get on with your day stress free. We offer quality aftermarket brans coupled with over 25 years experience in selling Automotive Car Parts. Payment is simple and easy using the safe and secure Paypal portal. Once we receive your payment we will deliver to your door.</td><br /></tr>d
</table>
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

                      if($user_registration)
                      {
                      $msg[] = "Visit Your Email and Click the link to activate your account. Thanks.";
                      }
                      else {
                        $msg[] = $a_link;
                      }   
                         } 
                         else {

                            $err[] = "An Error Occurred. Retry or Contact Admin.";
                         }
                     } else
{
  $err[] = "Don't Try to Penetrate.";
}    
                     }

                    ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register | <?php echo $web['company_title'];?></title>

    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">
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


<style type="text/css">
@media screen and (max-width: 600px) {

  .login-box{

      width: 360px;
      margin: 4% auto !important;
}

}
@media screen and (min-width: 600px) {
.login-box{

      margin: 4% auto !important;
      width: 600px;
}
}
  body{

  background:url("uploads/loginback.jpg") !important;
background-repeat: repeat !important;
    background-attachment: fixed;
    background-position: center; 
    background-size: 100% 100%;

  }

.form-control-feedback {

    right: 15px !important;
  }
</style>

  

    <div class="login-box">
      <script type="text/javascript">window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);</script>


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
$newToken = generateFormToken('form1');   
    /******************************* END ********************************/    
    ?>
     
      <div class="login-box-body">
        <p class="login-box-msg">Registration Form</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

<input type="hidden" name="token" value="<?php echo $newToken; ?>">
          <div class="row">
          <div class="form-group has-feedback col-md-12 col-sm-12 col-xs-12">
            <input name="full_name" id="full_name" type="text" class="form-control" placeholder="Your Name" required="" min="4" minlength="4">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
            <input type="email" name="usr_email" id="username" class="form-control" placeholder="Email" required="">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
            <input name="pwd" id="password" type="password" class="form-control" placeholder="Password" min="8" minlength="8">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
        </div>
        <div class="row">
          <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
            <input type="text" name="address" id="address" class="form-control" placeholder="Address">
            <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
            <input name="address1" id="address1" type="text" class="form-control" placeholder="Address (Contd.)">
            <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
          </div>

         <div class="form-group col-md-6 col-sm-12 col-xs-12">
            <select class="form-control" id="country" name="country">
                 <option>Select Country</option>
                <?php $country_fetch = mysqli_query($con,"SELECT * FROM country where status = '1'");
                while ($country = mysqli_fetch_array($country_fetch)) {?>
                <option value="<?php echo $country['country_id'];?>"><?php echo $country['title'];?></option>
            <?php } ?>
            </select>
          </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
            
            <select class="form-control" id="city" name="city">
                <option>Select Country First</option>
            </select>
          </div>
          <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
            <input type="text" name="zip" id="zip" class="form-control" placeholder="Postal / ZIP Code">
            <span class="glyphicon glyphicon-sort form-control-feedback"></span>
          </div>
          <div class="form-group col-md-2 col-sm-4 col-xs-4">
           
            <input name="phonecode" id="code" type="text" class="form-control" value="+44" placeholder="Code">
         
          </div>
           <div class="form-group has-feedback col-md-4 col-sm-8 col-xs-8" >
            
            <input name="phone" id="phone" type="text" class="form-control" placeholder="Phone">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        
        </div>

            <div class="form-group row">
                                          <label for="photo" class="col-md-3 col-form-label">Profile Image</label>
                                            <label class="btn btn-info" style="cursor: pointer;">
                                                Choose… <input type="file" id="photo" name="photo" style="display: none;">
                                             </label>
        
                                        </div>
         
           <div class="row">
            <div class="col-xs-12">
              <button type="submit" name="doRegister" class="btn btn-primary btn-block btn-flat">Register Now</button>
            </div><!-- /.col -->
          </div>
          </div>
        </form>

       

       <!--  <a href="forgot.php" class="btn btn-warning btn-block btn-flat">I forgot my password</a><br> -->
       <!--  <a href="register.php" class="text-center">Register a new membership</a> -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

     <div class="login-box">
    
    
      <div class="login-box-body">
        <p class="login-box-msg">Already Registered with us?</p>
       
            <div class="col-xs-12">
              <a class="btn btn-danger btn-block btn-flat" href="login.php">Login Now</a>
            </div><!-- /.col -->
          
     

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

   
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="plugins/jQuery/jquery-1.9.1.js"></script>
    <script langauge="javascript">
            window.setInterval("refreshDiv()", 5000);
            function refreshDiv(){
               
                document.getElementById("test");

            }
        </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/bootstrap-modal.js"></script>
        <script src="bootstrap/js/bootstrap-modalmanager.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
      $(function () {
        $(".textarea").wysihtml5();
      });
    </script>
    
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
     <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <script>
    $(".select2").select2();
  </script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
     <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    </script>
       
     <script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var mainIDs = $(this).val();
         //alert(mainIDs);
        if(mainIDs){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'country_id='+mainIDs,
                success:function(html){
                    $('#city').html(html);

                }
            }); 
        }else{
            $('#city').html('<option value="">Select Country First </option>');
        }
    });
});
</script>
    
  </body>
</html>
