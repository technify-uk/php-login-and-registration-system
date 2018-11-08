<?php 
require ('controls/ovais.php');
page_protect();
$rs_settings = mysqli_query($con, "select * from users where id='$_SESSION[user_id]'");
$row_settings = mysqli_fetch_array($rs_settings); 

?>
<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Welcome to <?php echo $web['company_title'];?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.5 -->
     
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="bootstrap/css/bootstrap-modal.css">
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Ionicons -->

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- jvectormap -->

    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <link rel="stylesheet" href="plugins/select2/select2.min.css">

    <!-- Theme style -->

    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins

         folder instead of downloading all of them to reduce the load. -->

    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

<!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    

   <?php function counterhome($v1,$v2 = "",$v3){
echo "<script type='text/javascript'>
$(document).ready(function() {
$.ajaxSetup({ cache: false });
var table = '".$v1."';
var where = '".$v2."';
var dd = '".$v3."';
setInterval(function() {
$('#'+dd).load('counterfunction.php',{var1:table,var2:where});
}, 1000); 
});
</script>";
}
?>
   
  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <style type="text/css">.select2-container {z-index: 10052 !important;}
.select2-drop-mask {z-index: 10052 !important;}
.paginationh {

margin-top: 5px;
clear: both;
text-align: center;
clear: both;
font-size: 12px;
}
.paginationh a {
padding: 2px 5px 2px 5px;
margin-right: 2px;
border: 1px solid #52bfea;
text-decoration: none;
color: #52bfea;
}

.paginationh span.disabled {
padding: 2px 5px 2px 5px;
margin-right: 2px;
border: 1px solid #f3f3f3;
color: #ccc;
}
.paginationh span.current {
padding: 2px 5px 2px 5px;
margin-right: 2px;
border: 1px solid #52bfea;
font-weight: bold;
background-color: #52bfea;
color: #FFF;
}
@media (max-width: 767px){
.skin-blue .main-header .navbar .dropdown-menu li a {
background: #367fa9 !important;
}

}
</style>
    <div class="wrapper">
       <script type="text/javascript">window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);</script>

      <header class="main-header">



        <!-- Logo -->

        <a href="index.php" class="logo">

          <!-- mini logo for sidebar mini 50x50 pixels -->

          <span class="logo-mini"><i class="fa fa-home"></i></span>

          <!-- logo for regular state and mobile devices -->

          <span class="logo-lg"><i class="fa fa-home"></i> <b><?php echo strtoupper($web['company_title']);?></b></span>

        </a>



        <!-- Header Navbar: style can be found in header.less -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="text-align: center; padding-top:0px; padding-bottom: 0px;">

<p style="font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif">Menu</p>
          </a>
          <a href="index.php" style="float: left;
          text-align: center;
    background-color: transparent;
    background-image: none;
    padding: 0px 15px;
    font-family: fontAwesome;
    color: #fff !important;" title="Go to Homepage">

            <i class="fa fa-home"></i><p style="font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif">Home</p>

          </a>

           

          <!-- Navbar Right Menu -->

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

              <!-- Messages: style can be found in dropdown.less-->

             

              <!-- User Account: style can be found in dropdown.less -->

              <li class="dropdown user user-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <img src="uploads/profile/<?php if(!empty($row_settings['photo'])){echo $row_settings['photo'];} else {echo "default.png";} ?>" class="user-image" alt="User Image" style="height:25px !important;">

                  <span class="hidden-xs"><?php echo strtoupper($row_settings['full_name']); ?></span>

                </a>

                <ul class="dropdown-menu">

                  <!-- User image -->

                  <li class="user-header">

                    <img src="uploads/profile/<?php if(!empty($row_settings['photo'])){echo $row_settings['photo'];} else {echo "default.png";} ?>" class="img-circle" alt="User Image">

                    <p>

                      <?php echo strtoupper($row_settings['full_name']); ?>

                      

                    </p>

                  </li>

                  <!-- Menu Body -->

                <!--   <li class="user-body">

                    <center><?php// echo $row_settings['job']; ?></center>

                  </li>
 -->
                  <!-- Menu Footer-->

                  <li class="user-footer">

                    <div class="pull-left">

                      <a href="profile.php" class="btn btn-info btn-flat">Profile</a>

                    </div>

                    <div class="pull-right">

                      <a href="logout.php" class="btn btn-danger btn-flat">Sign out</a>

                    </div>

                  </li>

                </ul>

              </li>

              <!-- Control Sidebar Toggle Button 

              <li>

                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>

              </li>-->

            </ul>

          </div>



        </nav>

      </header>



      <!-- Left side column. contains the logo and sidebar -->

      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->

        <section class="sidebar">

          <!-- Sidebar user panel -->

          <div class="user-panel">

            <div class="pull-left image">

              <img src="uploads/profile/<?php if(!empty($row_settings['photo'])){echo $row_settings['photo'];} else {echo "default.png";} ?>" class="img-circle" alt="User Image" style="height:45px !important">

            </div>

            <div class="pull-left info" style="font-size: 9px">

              <p><?php echo strtoupper($row_settings['full_name']); ?></p>

              <a href="profile.php"><i class="fa fa-circle text-success"></i> Profile</a>

            </div>

          </div>

<hr />      

          <ul class="sidebar-menu">

          <li>

              <a href="https://technify.uk" target="_blank">

                <i class="fa fa-th"></i> <span>Main Website</span></a>

            </li>

            <li class="active">

              <a href="index.php">

                <span style="color:#ff7701;"><i class="fa fa-dashboard"></i></span> &nbsp; <span>Homepage</span></a>

            </li>
<?php
if(checkSuperAdmin() || checkAdmin()) {?>
            <li class="treeview">

              <a href="#">

                <span style="color:#ff7701;"><i class="fa fa-users"></i></span> &nbsp;

                <span>Users</span>

                <i class="fa fa-angle-left pull-right"></i></span> &nbsp;

              </a>

              <ul class="treeview-menu">

                <li><a href="admin.php"><span style="color:#ff7701;"><i class="fa fa-check"></i></span> &nbsp; Registered</a></li>

                <li><a href="adduser.php"><span style="color:#ff7701;"><i class="fa fa-user-plus"></i></span> &nbsp; Add New</a></li>

              </ul>

            </li>

              

            <li>

              <a href="activity_log.php">

                <span style="color:#ff7701;"><i class="fa fa-quote-left"></i></span> &nbsp; <span>Activity Log</span></a>

            </li>
<?php } ?>
             <li>

              <a href="general_template_options.php">

                <i class="fa fa-trophy"></i> <span>General Web Options</span></a>

            </li>

         <li>

              <a href="logout.php">

                <span style="color:#ff7701;"><i class="fa fa-power-off"></i></span> &nbsp; <span>Sign Out</span>

              </a>

            </li>

            

           

          </ul>

        </section>
     

      </aside>
    