<?php include_once('header.php'); ?>



<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            General Website Options
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">General Theme Options</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
      <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <?php

    if(isset($_POST['doSubmit']))


{

  $SQL23="SELECT logo_pic FROM general_web_options where id='1'";
    $RES1=mysqli_query($con, $SQL23);
    $ROW1=mysqli_fetch_array($RES1); $photoStatus=$ROW1[0]; 
    if ($photoStatus!=$_FILES['photo']['name']){
    $photo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);}
    if ($_SESSION['photopath']==""){
    $photo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);}
    if ($_FILES['photo']['tmp_name']==""){
    $photo=$_SESSION['photopath'];
      }


function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}



$checkrecord = mysqli_query($con, "select * from general_web_options");
$countit = mysqli_num_rows($checkrecord);
if ($countit == 0) {
  
$inscq = "INSERT INTO general_web_options (`id`,`company_title`,`logo_pic`,`logo_title`,`logo_h`,`logo_w`,`logo_css`,`email2`,`phone2`,`email`,`phone`,`fax`,`address`,`footer_copyright`)

       VALUES ('1','$_POST[company_title]','$photo','$_POST[logo_title]','$_POST[logo_h]','$_POST[logo_w]','$_POST[logo_css]','$_POST[email2]','$_POST[phone2]','$_POST[email]','$_POST[phone]','$_POST[fax]','$_POST[address]','$_POST[footer_copyright]')

       " or die("Error in the query" . mysqli_error($con)); 
$finalize = mysqli_query($con, $inscq); 

if ($finalize == 1) {?>

<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Successful!</h4>
                    Your Settings have been saved successfully.
                  </div>
      
 <?php }
}
else {

$finalized = mysqli_query($con, "update general_web_options set 
  company_title='$_POST[company_title]',logo_pic='$photo',logo_title='$_POST[logo_title]',
  logo_h='$_POST[logo_h]',logo_w='$_POST[logo_w]',logo_css='$_POST[logo_css]',
  email='$_POST[email]',email2='$_POST[email2]',phone='$_POST[phone]',phone2='$_POST[phone2]',fax='$_POST[fax]',address='$_POST[address]',footer_copyright='$_POST[footer_copyright]'");
if ($finalized == 1) {?>


      <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Successfull!</h4>
                    Your Settings have been updated successfully.
                  </div>
 <?php }
}
}

    ?>
        <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">General Setting</h3>
                  <?php $rs_settings = mysqli_query($con, "select * from general_web_options where id='1'");
$row_settingss = mysqli_fetch_array($rs_settings); ?>
                </div>
                <div class="box-body">
                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                  <label for="phone" class="control-label">Enter Company Name</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-star"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Company Name" name="company_title" value="<?php echo $row_settingss['company_title']; ?>">
                  </div>
                  <br>
                  <label for="phone" class="control-label">Enter Company Contact Number</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Company Phone" name="phone" value="<?php echo $row_settingss['phone']; ?>">
                  </div>
                  <br>
                  <label for="phone2" class="control-label">Enter Company Contact Number 2</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Company Phone 2" name="phone2" value="<?php echo $row_settingss['phone2']; ?>">
                  </div>
                  <br>
                  <label for="fax" class="control-label">Enter Company Fax Number</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fax"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Company Fax" name="fax" value="<?php echo $row_settingss['fax']; ?>" >
                  </div>
                  <br />
                  <label for="author" class="control-label">Enter Company Email Address</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" placeholder="Enter Company Email" name="email" value="<?php echo $row_settingss['email']; ?>" >
                  </div>
                  <br />
                  <label for="author" class="control-label">Enter Company Email Address 2</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" placeholder="Enter Company Email 2" name="email2" value="<?php echo $row_settingss['email2']; ?>" >
                  </div>
                  <br>
                  <label for="author" class="control-label">Enter Footer Copyright &copy; Line</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-copyright"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Footer Line" name="footer_copyright" value="<?php echo $row_settingss['footer_copyright']; ?>" >
                  </div>
                  <br>

                  <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Company Address</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" rows = "3" name="address"><?php echo $row_settingss['address']; ?></textarea>
                        </div>
                      </div>
                      <br />
                  <div class="col-md-6">
                  <div class="input-group">
                   <?php $_SESSION['photopath'] = $row_settingss['logo_pic'];?>
                      <span><label>Change Website Logo</label>
                       <span class="file-input btn btn-block btn-info btn-file">
                Browse&hellip; <input type="file" name="photo">

            </span></span>
             
            </div></div>
            <div class="col-md-6"><center><img src="uploads/<?php echo $row_settingss['logo_pic']; ?>" width="75px" height="75px" alt="No Logo"></center></div>
            <br /><br />
            <br /><br />
<label for="logo title" class="control-label">Enter Logo Title</label>
<div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-plus"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Logo Title" name="logo_title" value="<?php echo $row_settingss['logo_title']; ?>">
                  </div>
                  <br />
                  <label for="logoheight" class="control-label">Enter Custom Logo Height (Only if Necessary)</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Logo Height" name="logo_h" value="<?php echo $row_settingss['logo_h']; ?>">
                  </div>
                  <br />
                  <label for="logowidth" class="control-label">Enter Custom Logo Width (Only if Necessary)</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Logo Width" name="logo_w" value="<?php echo $row_settingss['logo_w']; ?>">
                  </div>
                  <br>
                  <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Logo Custom Css (Only if Necessary)</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" rows = "3" name="logo_css"><?php echo $row_settingss['logo_css']; ?></textarea>
                        </div>
                      </div>
                      <br />

                
                     
<input type="submit" name="doSubmit" id="doSubmit" class="btn btn-success pull-right" value="Save Setting" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
</div>
<div class="col-md-2"></div>
      </div><!--/row-->
    
<p> 

  </div><!--/.fluid-container-->
  
      <!-- end: Content -->
    </div><!--/#content.span10-->
    </div><!--/fluid-row-->
    
  
  </div>
  </div></div></div>
  <div class="clearfix"></div>
<?php include('footer.php');?>
