<?php 
ob_start();
require_once('header.php'); 
if(!checkAdmin() && !checkSuperAdmin()) {
header("Location: index.php");
exit();
}
$err = array();
$msg = array();



if ($_GET['pp']!="") {
  
  foreach($_GET as $key => $value) {
  $get[$key] = filter($value);
}

$id = $get['pp'];
  if (is_numeric($id)) {
    $id = $get['pp'];
  }
  else{
    header("Location: admin.php");
  }

}
elseif ($_POST['pp']!="") {
  foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }

    $id = $data['pp'];
    if (is_numeric($id)) {
    $id = $get['pp'];
  }
  else{
    header("Location: admin.php");
  }
 } 
else {

header("Location: index.php");
}





?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo strtoupper($web['company_title']);?>
            <small>Public Profile</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Details</li>
          </ol>
        </section>
<?php $rs_settings = mysqli_query($con, "select * from users where id='$id'");
$is_found = mysqli_num_rows($rs_settings);
if ($is_found > 0) {
 
$row_settings = mysqli_fetch_array($rs_settings); 
}
else{
header("Location: admin.php");
}
?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
           
 <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-orange-active">
                  <div class="row">
                   
                  <h3 class="widget-user-username"><?php echo strtoupper($row_settings['full_name']); ?></h3>
                  <h5 class="widget-user-desc"><?php 
                  if ($row_settings['user_level']==119) {
                    echo "Administrator";
                  }
                  elseif ($row_settings['user_level']==2) {echo "Staff";}
                  elseif ($row_settings['user_level']==1) {echo "User";}
                  else {
                    echo "Super Administrator";
                  }

                  ?></h5>
                
           
            </div>

          </div>
                <div class="widget-user-image">
                  <img class="img-circle" width="100px" height="100px" src="uploads/profile/<?php echo $row_settings['photo']; ?>" alt="<?php echo $row_settings['full_name']; ?>" style="border:2px solid #ff7701;">
                </div>
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-6 border-right dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">Email</h5>
                        <span class="description-text"><?php echo $row_settings['user_email']; ?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-6 border-right dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">Contact #</h5>
                        <span class="description-text"><?php echo $row_settings['countrycode'] . $row_settings['tel']; ?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    
                  
                  </div><!-- /.row -->
                </div>
              </div>    
                  
              <style type="text/css">.widget-user .box-footer {
    padding-top: 60px !important;

}
.widget-user .widget-user-image>img {
  width: 100px !important;
  height: 100px !important;
}
.content {
  padding-left: 30px !important;
  padding-right: 30px !important;
}
.boxz {
    
    border-top: 3px solid #00a7d0 !important;
     border-bottom: 3px solid #00a7d0 !important;
}
</style>


          </div>


          <!-- Info boxes -->
          <div class="row">


        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>
