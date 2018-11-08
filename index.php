<?php require('header.php'); 

$err = array();
$msg = array();
if(isset($_POST['doProfile'])) {
$id = $_SESSION['user_id'];
    $id = $_POST['edit_id'];
    $fetchhh = mysqli_query($con, "SELECT * from users where id = '$id'");
    $photois = mysqli_fetch_array($fetchhh);
    $cyrrebt = $photois['photo'];


    if ($cyrrebt!=$_FILES['photo']['name']){
    $Logo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/profile/".$Logo);}
    
    if ($cyrrebt==""){
    $Logo=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/profile/".$Logo);}
    
    if ($cyrrebt==$_FILES['photo']['name']){
    $Logo=$row_settings['photo'];}

        if ($_FILES['photo']['name']==""){
    $Logo=$cyrrebt;}
//}else $Logo=$_SESSION['logopath'];
// Filter POST data for harmful code (sanitize)


$queryy = "UPDATE users SET `photo` = '$Logo' WHERE id ='$id'";
 $update_pic = mysqli_query($con, $queryy);

//header("Location: profile.php?msg=Profile Sucessfully Updated.");
if ($update_pic ==1) {
$msg[] = "Profile Picture Updated.";

 }

}
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <!--  <section class="content-header">
          <h1>
            I Need 4 My Car
            <small>Dashboard | Admin End</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Homepage</li>
          </ol>
        </section>
 -->
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
     
<div class="row">
              <div class="col-md-12">
            <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Customer's Registration</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">

            
                   
             <div class="col-md-6 col-sm-6 col-xs-12">
              <a href="premium_ads.php">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-star"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Registered Today</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="where date = curdate()","usert"); ?><div id="usert"></div></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </a>
            </div>
<div class="clearfix visible-sm-block"></div>

            <div class="col-md-6 col-sm-6 col-xs-12">
             <a href="premium_ads.php"> <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Registration History</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="","userhis"); ?><div id="userhis"></div></span>
                </div><!-- /.info-box-content -->
              </div>
            </a><!-- /.info-box -->
            </div><!-- /.col -->


          </div>
        </div>
      </div>
        
</div>
       


        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php require_once('footer.php'); ?>
