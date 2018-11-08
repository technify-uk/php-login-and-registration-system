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
$zip = $data['zip'];
$full_name = $data['full_name'];
$countrycode = $data['countrycode'];
$tel = $data['tel'];
$idx = $data['edit_id'];
$itsmeadmin = $data['pwd'];
$password = PwdHash($itsmeadmin);
$email = $data['user_email'];

  $upquery = "update users set full_name='$full_name', countrycode='$countrycode', tel='$tel', pwd='$password', user_email='$email', itsmeadmin='$itsmeadmin', address = '$address', address1 = '$address1', city = '$city', country = '$country', zip = '$zip', user_email = '$email' where id='$idx'"; 
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
            I NEED 4 MY CARS
            <small>User Profile Dashboard</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Details</li>
          </ol>
        </section>
<?php 
$id = $_SESSION['user_id'];
$rs_settings = mysqli_query($con, "select * from users where id='$id'");
$row_settings = mysqli_fetch_array($rs_settings); ?>
        <!-- Main content -->
        <section class="content">
          <div class="row">

              <div class="col-md-4">

                   
              <a href="user_cars.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-car"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Cars</span>
                  <span class="info-box-number"><?php $uid = $row_settings['id']; totalcars($uid,$table = "cars");?></span>
                </div><!-- /.info-box-content -->
              </div></a></div>

 <div class="col-md-4">
              <a href="user_inquiry.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-history"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Enquiries</span>
                  <span class="info-box-number"><?php $uid = $row_settings['id']; totalcars($uid,$table = "inquiry");?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box --></div>

               <!-- /.info-box -->
            
          
              
               
                
                <div class="col-md-4">

                   
              <a href="user_quotation.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-quote-left"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Quotations</span>
                  <span class="info-box-number"><?php $uid = $row_settings['id']; totalcars($uid,$table = "quotation");?></span>
                </div><!-- /.info-box-content -->
              </div></a></div>
 <div class="col-md-4">
              <a href="user_inquiry.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Orders</span>
                  <span class="info-box-number"><?php $uid = $row_settings['id']; totalcars($uid,$table = "orders");?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
</div>

 <div class="col-md-4">
              <a href="user_invoice.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Invoices</span>
                  <span class="info-box-number"><?php $uid = $row_settings['id']; totalcars($uid,$table = "invoice");?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
</div>

 <div class="col-md-4">
              <a href="user_profile.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Profile</span>
                  <span class="info-box-number"><i class="fa fa-cog"></i></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
</div>
               <!-- /.info-box -->
            
          
              
               
                
                </div><!-- /.col -->
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
                  else{
                    echo "Registered Member";
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
                    <div class="col-sm-3 border-right dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">Email</h5>
                        <span class="description-text"><?php echo $row_settings['user_email']; ?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 border-right dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">Contact #</h5>
                        <span class="description-text"><?php echo $row_settings['countrycode'] . $row_settings['tel']; ?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 border-right dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">No. of Cars Registered</h5>
                        <span class="description-text"><?php $uid = $row_settings['id']; totalcars($uid,$table = "cars");?></span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 dashboard_box">
                      <div class="description-block">
                        <h5 class="description-header">Inquires Placed</h5>
                        <span class="description-text"><?php $uid = $row_settings['id']; totalcars($uid,$table = "inquiry");?></span>
                      </div><!-- /.description-block -->
                    </div>
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
            <?php

            if (isset($_POST['doDelete'])) {

  $del = $_REQUEST['delete'];
$query = mysqli_query($con, "delete from cars where id='$del'");
if ($query == 1) {
 $msg[] = "Car Deleted Successfully.";
}

}


if(isset($_POST['doUpdateCar']))

{

    $err = array();
    $msg = array();

     foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }

                $car = $data['edit_id'];
$userz = $data['users_id'];


                if(empty($data['makemodel']) || empty($data['yearofmanufacture']) || empty($data['cc']))
                {
                $err[] = "Provide Complete Car Details. Thanks.";
                }
                else{


$fetch_cnicfff = mysqli_query($con,"SELECT photo from cars where id = '$car'");
    list($oldcnicf) = mysqli_fetch_row($fetch_cnicfff);

    if ($oldcnicf!=$_FILES['photo']['name']){
    $CNICF=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "admin/uploads/cars/".$CNICF);}
    
    if ($oldcnicf==""){
    $CNICF=$_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "admin/uploads/cars/".$CNICF);}
    
    if ($oldcnicf==$_FILES['photo']['name']){
    $CNICF=$oldcnicf;}
     if ($_FILES['photo']['name']=="") {
      $CNICF=$oldcnicf;
    }






   $abc = "UPDATE `cars` SET `location`='$data[location]',`usersid`='$userz',`makemodel`='$data[makemodel]',`yearofmanufacture`='$data[yearofmanufacture]',`vin`='$data[vin]',`fullreg`='$data[fullreg]',`cc`='$data[cc]',`cdate`=now(),`status`='1',`photo`='$CNICF' WHERE id = '$car'";
    $upd = mysqli_query($con, $abc);
    if ($upd == 1) {

    // $_SESSION['full_name'] = $_POST['full_name'];
    $msg[] = "Car Updated Successfully.";
    }
    else {

    $err[] = "An Error Occurred. Please Re check.";
    }

    }
}

$query_carszzx = mysqli_query($con, "SELECT * FROM `cars` WHERE id = '$car' AND usersid = ". $_SESSION['user_id']); 
                $car_info = mysqli_fetch_array($query_carszzx);
      ?>

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
                    <li>Zip / Postal Code : <?php echo $row_settings['zip'];?></li>
                    <li>Country : <?php echo $row_settings['country']; ?></li>
                 
               </ul>
                <div class="text-right">
               <a data-toggle="modal" href="#update" title="Edit User Information" class="btn btn-info">Update Profile</a></div>
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
        <form action="user_profile.php" method="post">
        <div class="modal-body">
         
          <input type="hidden" name="edit_id" value="<?php echo $row_settings['id']; ?>">
        

                      <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" name="full_name" class="form-control" value="<?php echo $row_settings['full_name'];?>" >
                        </div>
                      <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="user_email" class="form-control" value="<?php echo $row_settings['user_email'];?>" >
                        </div>
                        <div class="form-group">
                      <label>Password</label>
                      <input type="text" name="pwd" class="form-control" value="<?php echo $row_settings['itsmeadmin'];?>" >
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
                      <label>City</label>
                      <input type="text" name="city" class="form-control" value="<?php echo $row_settings['city'];?>" >
                        </div>
                        <div class="form-group">
                      <label>Country</label>
                      <input type="text" name="country" class="form-control" value="<?php echo $row_settings['country'];?>" >
                     </div>
                    <div class="form-group">
                      <label>Zip / Postal Code</label>
                      <input type="text" name="zip" class="form-control" value="<?php echo $row_settings['zip'];?>" >
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

  

          <div class="box boxz">
                <div class="box-header">
                  <h3 class="box-title">Cars Registered By User</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tr>
                      <th>Registration</th>
                      <th>VIN</th>
                      <th>Make &amp; Model</th>
                      <th>Year of Manufacture</th>
                      <th>Engine Size (cc)</th>   
                      <th>Added On</th>   
                      <th>Controls</th>  
                     
                      <!-- 
                      <th style="width: 80px">Action</th> -->
                    </tr>
                   
                  <?php 
                $pub_car = "SELECT * FROM cars WHERE usersid = ". $row_settings['id'];
                  $query_carss = mysqli_query($con, $pub_car);
                  while ($car_info = mysqli_fetch_array($query_carss)) {?>
                   <tr>
                    <td><?php echo strtoupper($car_info['fullreg']);?></td>
                     <td><?php echo strtoupper($car_info['vin']);?></td>
                      <td><?php echo strtoupper($car_info['makemodel']);?></td>
                      <td><?php echo strtoupper($car_info['yearofmanufacture']);?></td>
                      <td><?php echo strtoupper($car_info['cc']);?></td>
                      <td><?php echo date("d-M-Y, h:i:sa", strtotime($car_info['cdate']));?></td>
                      <td><font size="2"> <a data-toggle="modal" href="#editt<?php echo $car_info['id']; ?>"><span class="label label-warning"><i class="fa fa-edit"></i></span></a> 
              <a data-toggle="modal" href="#del<?php echo $car_info['id']; ?>"><span class="label label-danger"><i class="fa fa-trash"></i></span></a></font> </td>
                      
                      <td>
                        
                      </td><!-- 
                      <td><a href="#"><span class="badge bg-red">Logout</span></a></td> -->

 </tr>

          <div class="modal fade" id="editt<?php echo $car_info['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Updating Car Details For : <?php echo $car_info['makemodel'];?></h4>
        </div>
        <form action="profile_public.php?pp=<?php echo $car_info['usersid']; ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
         
          <input type="hidden" name="edit_id" value="<?php echo $car_info['id']; ?>">
          <input type="hidden" name="users_id" value="<?php echo $car_info['usersid']; ?>">

          <div class="form-group">
                                            <label for="example-text-input" class="col-12 col-md-4 col-form-label">Car Registered in :</label>
                                            <div class="col-12 col-md-8">
                                                
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="location" id="1a" value="UK" data-id="1" <?php if ($car_info['location']=='UK') {
                                                            echo "checked";
                                                        }?>>
                                                        <label for="1a">UK</label>
                                                    </div>
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="location" id="2a" value="Other" data-id="2" <?php if ($car_info['location']=='Other') {
                                                            echo "checked";
                                                        }?>>
                                                        <label for="2a">Other</label>
                                                    </div>
                                             
                                                 </div>
                                        </div>
       
                          <div class="form-group">
                      <label>Registration # </label>
                       <input class="form-control" placeholder="Full Registration" type="text" name="fullreg" value="<?php echo $car_info['fullreg'];?>">
                        </div>
  <div class="form-group">
                      <label>VIN # </label>
                       <input class="form-control" placeholder="VIN Number" type="text" name="vin" value="<?php echo $car_info['vin'];?>">
                        </div>

 <div class="form-group">
                      <label>Make n Model</label>
                      <input class="form-control" placeholder="Car Make And Model" type="text" name="makemodel" value="<?php echo $car_info['makemodel'];?>">
                        </div>
                        <div class="form-group">
                      <label>Year of Manufacture</label>
                      <input class="form-control" placeholder="Car Year of Manufacture" type="text" name="yearofmanufacture" value="<?php echo $car_info['yearofmanufacture'];?>">
                        </div>
                        <div class="form-group">
                      <label>Engine Size (cc)</label>
                        <input class="form-control" placeholder="Engine Size (cc)" type="text" name="cc" value="<?php echo $car_info['cc'];?>">
                        </div>
                        Current Image : <center><img src="uploads/cars/<?php echo $car_info['photo'];?>" width="100px"></center>
               <div class="form-group">
                <label class="btn btn-primary" style="cursor: pointer;">
                                                Choose… <input type="file" name="photo" style="display: none;">
                                             </label>
                                           </div>
          
        </div>
        <div class="modal-footer">

          <button type="submit" name="doUpdateCar" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- ************************** MOdal to delete confirm a record  ***************************** -->
  <div class="modal fade" id="del<?php echo $car_info['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Delete Confirmation For Car : <?php echo $car_info['makemodel'];?></h4>
        </div>
        <form action="profile_public.php?pp=<?php echo $car_info['usersid']; ?>" method="post">
        <div class="modal-body">
         
          <input type="hidden" name="delete" value="<?php echo $car_info['id']; ?>">
              
            
            <p>Record Once Deleted Cannot be recovered. You can ban a record to disable it so that you can unban it whenever you require it again.</p>
<h4>Are You Sure You Want to Delete Record?</h4>
          
        </div>
        <div class="modal-footer">

          <button type="submit" name="doDelete" class="btn btn-block btn-danger">Delete</button>
          <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



                      <?php } ?>


                   
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->







                    <div class="box boxz">
                <div class="box-header">
                  <h3 class="box-title">Payment History</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tr>
                      <th>Order No.</th>
                      <th>Date</th>
                      <th>Amount</th>   
                     
                      <!-- 
                      <th style="width: 80px">Action</th> -->
                    </tr>
                   
                  <?php 
                 $akss = "select u.full_name, u.cnic, c.title as cometi,t.* from transactions as t JOIN users as u ON t.membersid = u.id JOIN cometi as c on t.cometiid = c.id where t.membersid = ". $_SESSION['user_id'];
                  $query_trxs = mysqli_query($con, $akss);
                  while ($trxs = mysqli_fetch_array($query_trxs)) {?>
                   <tr>
                      <td><?php echo $trxs['receiptno'];?></td>
                      <td><?php echo date("d-M-Y, h:i:sa", strtotime($trxs['date']));?></td>
                      <td><?php echo $trxs['amount'];?></td>
                      
                      <td>
                        
                      </td><!-- 
                      <td><a href="#"><span class="badge bg-red">Logout</span></a></td> -->
 </tr>
                      <?php } ?>


                   
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->



        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <?php require_once('footer.php');?>