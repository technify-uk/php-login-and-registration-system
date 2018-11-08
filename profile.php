<?php 
ob_start();
require_once('header.php'); 
$err = array();
$msg = array();

// if ($_GET['pp']!="") {
//   $id = $_GET['pp'];
// }
// elseif ($_POST['pp']!="") {
//     $id = $_REQUEST['pp'];
//  } 
// else {

// header("Location: index.php");
// }

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

if(isset($_POST['doEdit'])) {

foreach($_POST as $key => $value) {
  $data[$key] = filter($value);
}

$address = $data['address'];
$address1 = $data['address1'];
$city = $data['city'];
$country = $data['country'];
$post_code = $data['post_code'];
$full_name = $data['full_name'];
$countrycode = $data['countrycode'];
$tel = $data['tel'];
$idx = $data['edit_id'];
$itsmeadmin = $data['pwd'];
$password = PwdHash($itsmeadmin);


  if(!empty($itsmeadmin)){
  $upquery = "update users set full_name='$full_name', countrycode='$countrycode', tel='$tel', pwd='$password', address = '$address', address1 = '$address1', city_id = '$city', country_id = '$country', post_code = '$post_code' where id='$idx'"; 
  }
  else {
    $upquery = "update users set full_name='$full_name', countrycode='$countrycode', tel='$tel', address = '$address', address1 = '$address1', city_id = '$city', country_id = '$country', post_code = '$post_code' where id='$idx'"; 
  }
  $chc = mysqli_query($con, $upquery);
    if ($chc == 1) {
      $msg[] = "Profile Updated Successfully.";
    } else { $err[] = "Error. Contact Admin."; }
}

 



?>

     
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $web['company_title'];?>
            <small>User Profile Dashboard</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Details</li>
          </ol>
        </section>
<?php 
$id = $_SESSION['user_id'];
$rs_settings = mysqli_query($con, "select u.*,c.title as country, ci.title as city from users as u join country as c on c.country_id = u.country_id join city as ci on ci.city_id = u.city_id where u.id='$id'");
$row_settings = mysqli_fetch_array($rs_settings); ?>
        <!-- Main content -->
        <section class="content">
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
           <div class="row">
            <div class="col-md-6">
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
            <div class="row">

  


                <div class="widget-user-image">
                <a data-toggle="modal" href="#profile"><img class="img-circle" width="100px" height="100px" src="uploads/profile/<?php if(!empty($row_settings['photo'])){echo $row_settings['photo'];} else {echo "default.png";} ?>" alt="<?php echo $row_settings['full_name']; ?>" style="border:2px solid #ff7701;"></a>
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
</div>


            <div class="col-md-6">
              <div class="box boxz">
                <div class="box-header with-border">
                  <div class="user-block">
                    
                    <span class="username"><a href="#">Details : <?php echo $row_settings['full_name'];?></a></span>
                    <span class="description">Joining Date : <?php echo $row_settings['date'];?></span>
                  </div><!-- /.user-block -->
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul>
                    <li>Address : <?php echo $row_settings['address'];?></li>
                    <li>Address(contd) : <?php echo $row_settings['address1'];?></li>
                    <li>City : <?php echo $row_settings['city'];?></li>
                    <li>Zip / Postal Code : <?php echo $row_settings['post_code'];?></li>
                    <li>Country : <?php echo $row_settings['country']; ?></li>
                 
               </ul>
                <div class="text-right">
               <a data-toggle="modal" href="#update" title="Edit User Information" class="btn btn-info">Update Profile &amp; Password</a></div>
                </div><!-- /.box-body -->
            
          
              </div>
            </div>
           
         <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Your Profile Dear :  <?php echo $row_settings['full_name'];?></h4>
        </div>
        <form action="profile.php" method="post">
        <div class="modal-body">
         
          <input type="hidden" name="edit_id" value="<?php echo $row_settings['id']; ?>">
        

                      <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" name="full_name" class="form-control" value="<?php echo $row_settings['full_name'];?>" >
                        </div>
                      <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="user_email" class="form-control" value="<?php echo $row_settings['user_email'];?>" disabled="">
                        </div>
                        <div class="form-group">
                      <label>Password (leave it blank if dont want to change)</label>
                      <input type="password" name="pwd" class="form-control" >
                     </div>
                        <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="address" class="form-control" value="<?php echo $row_settings['address'];?>" >
                        </div>
                         <div class="form-group">
                      <label>Address (contd)</label>
                      <input type="text" name="address1" class="form-control" value="<?php echo $row_settings['address1'];?>" >
                        </div>
                           <div class="form-group">
                            <label>Select Country</label>
            <select class="form-control" id="country" name="country">
                 <option>Select Country</option>
                <?php $country_fetch = mysqli_query($con,"SELECT * FROM country where status = '1'");
                while ($country = mysqli_fetch_array($country_fetch)) {?>
                <option value="<?php echo $country['country_id'];?>"><?php echo $country['title'];?></option>
            <?php } ?>
            </select>
          </div>
            <div class="form-group">
            <label>Select City</label>
            <select class="form-control" id="city" name="city">
                <option>Select Country First</option>
            </select>
          </div>
                    <div class="form-group">
                      <label>Zip / Postal Code</label>
                      <input type="text" name="post_code" class="form-control" value="<?php echo $row_settings['post_code'];?>" >
                     </div>
                      

                     <div class="form-group row">
                      <div class="col-md-3">
                      <label>Country Code</label>
                      <input type="text" name="countrycode" class="form-control" value="<?php echo $row_settings['countrycode'];?>" >
                    </div>
                    <div class="col-md-9">
                      <label>Mobile</label>
                      <input type="text" name="tel" class="form-control" value="<?php echo $row_settings['tel'];?>" >
                    </div>
                     </div>
          
        </div>
        <div class="modal-footer">

          <button type="submit" name="doEdit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
                <div class="col-md-6">

                </div><!-- /.col -->
              </div><!-- /.row -->

  

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
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
      <?php require_once('footer.php');?>