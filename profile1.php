<?php 
include 'controls/ovais.php';
page_protect();

$err = array();
$msg = array();


if(isset($_POST['doUpdate']))
{


$rs_pwd = mysqli_query($con, "select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysqli_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
  if($old === PwdHash($_POST['pwd_old'],$old_salt))
  {
  $newsha1 = PwdHash($_POST['pwd_new']);
  mysqli_query($con, "update users set pwd='$newsha1', itsmeadmin='$_POST[pwd_new]' where id='$_SESSION[user_id]'");
  $msg[] = "Your new password is updated";
  //header("Location: profile.php?msg=Password Successfully Changed.");
  } else
  {
   $err[] = "Your old password is invalid";
   //header("Location: profile.php?msg=Your old password is invalid");
  }

}

    $SQL23="SELECT photo FROM users where id=".$_SESSION['user_id'];
    $RES1=mysqli_query($con, $SQL23);
    $ROW1=mysqli_fetch_array($RES1); $logoStatus=$ROW1[0]; 
    
    
  if(isset($_POST['doSave']))

{
//echo $_FILES['photo']['name'];
  //  if ($_FILES['photo']['name']!=""){
    if ($logoStatus!=$_FILES['photo']['name']){
    $Logo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/profile/".$Logo);}
    
    if ($_SESSION['logopath']==""){
    $Logo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/profile/".$Logo);}
    
    if ($_FILES['photo']['tmp_name']=="" && $_SESSION['user_id']!=""){
    $Logo=$_SESSION['logopath'];}
//}else $Logo=$_SESSION['logopath'];
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
  $data[$key] = filter($value);
}


mysqli_query($con, "UPDATE users SET
      `full_name` = '$data[name]',
      `address` = '$data[address]',
      `tel` = '$data[tel]',
      `photo` = '$Logo'
       WHERE id='$_SESSION[user_id]'
      ") or die(mysql_error());

//header("Location: profile.php?msg=Profile Sucessfully Updated.");
$msg[] = "Profile Sucessfully saved";
$_SESSION['logopath']="";
unset($_SESSION['logopath']);
 }

?>

<?php include_once('header.php');?>

<body>
    <?php include('topmenu.php');?> 
  <!-- start: Header -->
  
    <div class="container-fluid-full">
    <div class="row-fluid">
        
      <?php include('sidemenu.php');?>      
      <noscript>
        <div class="alert alert-block span10">
          <h4 class="alert-heading">Warning!</h4>
          <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
      </noscript>
      
      <!-- start: Content -->
      <div id="content" class="span10">
      
      
      <ul class="breadcrumb">
        <li>
          <i class="icon-home"></i>
          <a href="index.php">Home</a> 
          <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Profile</a></li>
      </ul>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <div class="row-fluid">
              <p> 
        <?php 
  if(!empty($err))  {
     echo "<div class=\"msg\">";
    foreach ($err as $e) {
      echo "* Error - $e <br>";
      }
    echo "</div>";  
     }
     if(!empty($msg))  {
      echo "<div class=\"msg\">" . $msg[0] . "</div>";

     }
    ?>
      </p>


      <h4>Here you can make changes to your profile. Please note that you will 
        not be able to change your email which has been already registered.</h4>
    </div>

<div class="row-fluid sortable">
        <div class="box span12">
          <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Profile Update Form</h2>
            <div class="box-icon">
              <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
              <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
              <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content">
          <?php $rs_settings = mysqli_query($con, "select * from users where id='$_SESSION[user_id]'");
$row_settings = mysqli_fetch_array($rs_settings); ?>
     <form method="post" action="profile.php" class="form-horizontal" name="myform" id="myform" enctype="multipart/form-data">
             <fieldset>
                
                <div class="control-group">
                <label class="control-label" for="disabledInput">User Name</label>
                <div class="controls">
                  <input class="input-xlarge disabled" id="disabledInput" name="user_name" type="text" value="<?php echo $row_settings['user_name']; ?>" disabled="">
                </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="disabledInput">Email Address</label>
                <div class="controls">
                  <input class="input-xlarge disabled" id="disabledInput" name="user_email" type="text" value="<?php echo $row_settings['user_email']; ?>" disabled="">
                </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="focusedInput">Your Name</label>
                <div class="controls">
                  <input class="input-xlarge focused" name="name" id="focusedInput" type="text" value="<?php echo $row_settings['full_name']; ?>">
                </div>
                </div>
                <div class="control-group hidden-phone">
                <label class="control-label" for="textarea2">Address Details</label>
                <div class="controls">
                <textarea class="cleditor" name="address" id="textarea2" rows="3"><?php echo $row_settings['address']; ?></textarea>
                </div>
              </div> 

              <div class="control-group">
                <label class="control-label" for="focusedInput">Contact No.</label>
                <div class="controls">
                  <input class="input-xlarge" name="tel" type="text" value="<?php echo $row_settings['tel']; ?>">
                </div>
                </div> 
              <div class="control-group">
                <label class="control-label" for="fileInput">Select New Profile Picture</label>
                <div class="controls">
                <input class="input-file uniform_on" id="fileInput" name="photo" type="file">
                </div>
              </div>   
              <style type="text/css">
                  .img-circle{
                    width: 100px;
                    height: 100px;
padding: 1px;
border: 1px solid #eee;
border-radius: 50%;


                  }
              </style>
              <div class="control-group">  
              <center>
            <img src="../uploads/profile/<?php echo $row_settings['photo']; 
                        //important codeing for profile Picture
                        $_SESSION['logopath']=$row_settings['photo']; ?>" class="img-circle" width="100px" height="100px">
            </center>    </div>
                
                <div class="form-actions">
                <input type="submit" name="doSave" id="doSave" value="UPDATE" class="btn btn-primary"/>
                </div>
              </fieldset>
              </form>
          
          </div>
        </div><!--/span-->
      
      </div><!--/row-->



     

<div class="row-fluid sortable">
        <div class="box span12">
          <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Update Your Password</h2>
            <div class="box-icon">
              <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
              <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
              <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content">
          <?php $rs_settings = mysqli_query($con, "select * from users where id='$_SESSION[user_id]'");
$row_settings = mysqli_fetch_array($rs_settings); ?>
     <form method="post" action="profile.php" class="form-horizontal" name="myform" id="myform">
             <fieldset>
                
                
                <div class="control-group">
                <label class="control-label" for="focusedInput">Old Password</label>
                <div class="controls">
                  <input class="input-xlarge focused" name="pwd_old" id="pwd_old" type="password">
                </div>
                </div>
                

              <div class="control-group">
                <label class="control-label" for="focusedInput">New Password</label>
                <div class="controls">
                  <input class="input-xlarge" name="pwd_new" id="pwd_new" type="password">
                </div>
                </div> 
              
                
                <div class="form-actions">
                <input name="doUpdate" type="submit" id="doUpdate" value="CHANGE" class="btn btn-primary"/>
                </div>
              </fieldset>
              </form>
          
          </div>
        </div><!--/span-->
      
      </div><!--/row-->





</div></div></div>








   <?php 
     include ('footer.php');
     ?>
