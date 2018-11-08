<?php ob_start();
include_once('header.php'); 
 
if(!checkSuperAdmin() && !checkAdmin()) {
header("Location: index.php");
ob_clean();
exit();
}
 $err = array();
 $msg = array();

?>

<?php
    if(isset($_POST['doSubmit']))
{
  if(!empty($_FILES['photo']['name'])){
    $Icon = '';
    if(!empty($_FILES["photo"]["type"])){
        $photoName = time().'_'.$_FILES['photo']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["photo"]["name"]);
        $photo_extension = end($temporary);
        if((($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == "image/jpeg")) && in_array($photo_extension, $valid_extensions)){
            $sourcePath = $_FILES['photo']['tmp_name'];
            $targetPath = "uploads/profile/".$photoName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $Icon = $photoName;
            }
        } else {$err[] = "Invalid File Type. Only .jpg, .png, .jpeg allowed.";}
    }
   }
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
                $err[] = "Invalid email address.";
                //header("Location: register.php?msg=$err");
                //exit();
                } 

                 $usr_email = $data['user_email'];
               }



$chekdupli = "select count(*) as total from users where user_email='$usr_email'" or die("Error in the query" . mysqli_error($con)); 

$rs_dup = mysqli_query($con, $chekdupli);



list($dups) = mysqli_fetch_row($rs_dup);







if($dups > 0) {



  $err[] = "Email Already Registered.";

                  }

 // stores sha1 of password
                 if(empty($data['pwd']) || strlen($data['pwd']) < 8)
                {
                $err[] = "Password with Minimum 8 Characters is Mandatory.";
                }
                else {
                $sha1pass = PwdHash($data['pwd']);
              }


 $CDate=date("Y-m-d H:i:s");

if(verifyFormToken('form1') && empty($err)) {

$inscq = "INSERT INTO users (`photo`,`full_name`,`user_email`,`pwd`,`approved`,`date`,`user_level`)



       VALUES ('$Icon','$data[full_name]','$usr_email','$sha1pass','$data[approved]','$CDate','$data[user_level]')



       " or die("Error in the query" . mysqli_error($con)); 

$adduser = mysqli_query($con, $inscq); 



if ($adduser == 1) {

  

  $msg[] = "New User Successfully Added.";

 }







$message = 



"Welcome to ".$web['company_title']." You are registered with us. Your Details are as under:\n

User Email: $usr_email \n

Password: Your Provided. \n

*****LOGIN LINK*****\n



".$web['company_domain']."

Regards,

".$web['company_title']."\n

______________________________________________________



THIS IS AN AUTOMATED RESPONSE. 



***DO NOT RESPOND TO THIS EMAIL****



";







if($_POST['send'] == '1') {







  mail($usr_email, $web['company_title'], $message,



    "From: \"".$web['company_title']." Team\" <no-reply@$host>\r\n" .



     "X-Mailer: PHP/" . phpversion()); 







 }


}
else
{
  $err[] = "Don't Try to Penetrate.";
}

}





    ?>

<!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

       <section class="content-header">
<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
         <a href="admin.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">User's Database</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="","adm"); ?><div id="adm"></div></span>
                </div><!-- /.info-box-content -->
              </div></a>
</div>
<div class="col-md-2"></div>
        </section>



        <!-- Main content -->

        <section class="content">

      <div class="row">

      <div class="col-md-2"></div>

      <div class="col-md-8">



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

      }?>

    </div>
    <?php
     }

     if(!empty($msg))  { ?>

<div class="alert alert-success alert-dismissable">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                    <h4>  <i class="icon fa fa-check"></i> Successful!</h4>

                    <?php

      echo $msg[0]; ?>
</div>

<?php 
     }
$newToken = generateFormToken('form1');   
    /******************************* END ********************************/    

    ?>

        <div class="box box-info">

                <div class="box-header with-border">

                  <h3 class="box-title">Add New User</h3>

                </div>

                <div class="box-body">

                <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
<input type="hidden" name="token" value="<?php echo $newToken; ?>">
                  <!-- <label>User Name</label>

                  <div class="input-group">

                    <span class="input-group-addon">@</span>

                    <input type="text" class="form-control" placeholder="Username" name="user_name" required>

                  </div> 

                  <br>-->

                    <label>Full Name</label>

                  <div class="input-group">

                    <span class="input-group-addon">#</span>

                    <input type="text" class="form-control" placeholder="Enter Full Name" name="full_name" required>

                  </div>

                  <br>

                  <label>Valid Email</label>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                    <input type="text" class="form-control" placeholder="Email" name="user_email" required>

                  </div>

                  <br>

                  

                  <label>Password</label>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <input type="password" class="form-control" name="pwd" required>

                  </div>

<br />
                 <div class="input-group" style="width: 100%">

                    <label>Select User Level</label>

                    <select class="form-control select2" name="user_level">

                      <option selected="selected" value="1">User</option>
                      <option value="2">Staff</option>
                      <option value="119">Admin</option>

                    </select>

                  </div><!-- /.form-group -->
<!-- <br />
                  <label>Select Designation</label>

                  <div class="input-group">

                    <span class="input-group-addon">*</span>

                    <input type="text" class="form-control" placeholder="Job Designation" name="job" required>

                  </div> -->
<br />
                  <div class="input-group" style="width: 100%">

                    <label>Select User Status</label>

                    <select class="form-control select2" name="approved">

                      <option selected="selected" value="1">Approve</option>

                      <option value="0">Pending</option>

                    </select>

                  </div><!-- /.form-group -->

<div class="input-group">

                <label class="control-label" for="optionsCheckbox2">Send Details in Email?</label>

                <div class="icheckbox_flat-green">

                <input type="checkbox" class="flat-red" name="send" value="1" checked="checked"></div>

                </div>



              <!--   <div class="input-group">

                <label class="control-label" for="optionsCheckbox2">Add in Team Member's Area?</label>

                <div class="icheckbox_flat-green">

                <input type="checkbox" class="flat-red" name="team" value="1"></div>

                </div>
 -->

                  <br />

                  <label>Add Profile Picture</label>

                  <div class="input-group">

                  <span class="file-input btn btn-block btn-info btn-file">

                Browse&hellip; <input type="file" name="photo">

            </span>

            </div>

                     

<input type="submit" name="doSubmit" id="doSubmit" class="btn btn-success pull-right" value="Add User" />
</form>
                </div><!-- /.box-body -->

              </div><!-- /.box -->

</div>

<div class="col-md-2"></div>

     </div></section>

</div>

<?php include('footer.php');?>

