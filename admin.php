<?php ob_start();
require_once('header.php'); 
if(!checkSuperAdmin() && !checkAdmin()) {
header("Location: index.php");
ob_clean();
exit();
}
$msg = array();
$err = array();
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @preg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');


if (isset($_POST['doDelete'])) {

  $del = $_POST['delete'];
$query = mysqli_query($con, "delete from users where id='$del'");
if ($query == 1) {
  echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Deleted');

    </SCRIPT>");
}

}

// $rs_all = mysql_query("select count(*) as total_all from users") or die(mysql_error());
// $rs_active = mysql_query("select count(*) as total_active from users where approved='1'") or die(mysql_error());
// $rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");               

// list($total_pending) = mysql_fetch_row($rs_total_pending);
// list($all) = mysql_fetch_row($rs_all);
// list($active) = mysql_fetch_row($rs_active);


      


      ?>

            <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
<form action="" method="post">
            <div class="row">
<style type="text/css">button:focus{    outline: none !important;}</style>
 <div class="col-md-4">
                <button type="submit" name="user_level" value="" style="border:none; background:transparent; width: 100%; font-family: inherit; ">
             <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">All Users</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="","adstof"); ?><div id="adstof"></div></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box --></button></div>
                    <div class="col-md-4">
                      <button type="submit" name="user_level" value="1" style="border: none;
    background: transparent; width: 100%; font-family: inherit; ">
             <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Customers</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="where user_level = 1","cust"); ?><div id="cust"></div></span>
                </div><!-- /.info-box-content -->
              </div></button></div>

              
              <div class="col-md-4">
                <button type="submit" name="user_level" value="2689" style="border:none; background:transparent; width: 100%; font-family: inherit; ">
             <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-user-secret"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Super Admins</span>
                  <span class="info-box-number"><?php counterhome("users",$v2="where user_level = 2689","edm"); ?><div id="edm"></div></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box --></button></div>


            </div>
            </form>
        </section>

        <!-- Main content -->
        <section class="content">
                <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Available Members</h3>
                  



                  <?php 

if(isset($_POST['doEdit'])) {
     foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }
 $id = $data['edit_id']; 
// $SQL23="SELECT photo FROM users where id=". $id;
//     $RES1=mysqli_query($con, $SQL23);
//     $ROW1=mysqli_fetch_array($RES1); $logoStatus=$ROW1['photo']; 

//      if ($_FILES['photo']['name']!="" && $logoStatus!=$_FILES['photo']['name']){

//        $photoName = time().'_'.$_FILES['photo']['name'];
//     $valid_extensions = array("jpeg", "jpg", "png");
//         $temporary = explode(".", $_FILES["photo"]["name"]);
//         $photo_extension = end($temporary);
//         if((($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == "image/jpeg")) && in_array($photo_extension, $valid_extensions)){
//             $sourcePath = $_FILES['photo']['tmp_name'];
//             $targetPath = "uploads/profile/".$photoName;
//             if(move_uploaded_file($sourcePath,$targetPath)){
//                 $CNICF = $photoName;
//             }
//         } else {$err[] = "Invalid File Type. Only .jpg, .png, .jpeg allowed.";
//       }

//   }
    
//     if ($logoStatus==""){

//        $photoName = time().'_'.$_FILES['photo']['name'];
//     $valid_extensions = array("jpeg", "jpg", "png");
//         $temporary = explode(".", $_FILES["photo"]["name"]);
//         $photo_extension = end($temporary);
//         if((($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == "image/jpeg")) && in_array($photo_extension, $valid_extensions)){
//             $sourcePath = $_FILES['photo']['tmp_name'];
//             $targetPath = "uploads/categories/photos/".$photoName;
//             if(move_uploaded_file($sourcePath,$targetPath)){
//                 $CNICF = $photoName;
//             }
//         } else {$err[] = "Invalid File Type. Only .jpg, .png, .jpeg allowed.";
//       }

//   }
    
//     if ($logoStatus==$_FILES['photo']['name']){
//     $CNICF=$logoStatus;}
    
//     if ($_FILES['photo']['name']=="") {
//       $CNICF=$logoStatus;
//     }

if (empty($data['full_name'])) {
  $err[] = "Full Name is Required.";
}
else{
$full_name = $data['full_name'];
}
$tel = $data['tel'];
$countrycode = $data['countrycode'];
  
$itsmeadmin = $data['password'];
$password = PwdHash($itsmeadmin);
if (empty($data['user_email'])) {
  $err[] = "Email is Required.";
}
else{
$email = $data['user_email'];
if (!isEmail($email)) {
  $err[] = "Invalid Email Address";
}
else{
  $email = $data['user_email'];
}
}
$approved = $data['approved'];
$level = $data['user_level'];
if (!empty($data['password'])) {
   $upquery = "update users set full_name='$full_name', user_level='$level', pwd='$password', user_email='$email', approved='$approved', countrycode='$countrycode', tel='$tel' where id='$id'"; 
   $upit =  mysqli_query($con, $upquery);
 }
 else{
$upquery = "update users set full_name='$full_name', user_level='$level', user_email='$email', approved='$approved', countrycode='$countrycode', tel='$tel' where id='$id'"; 
   $upit =  mysqli_query($con, $upquery);
 }
if ($upit) {
  $msg[] = "Information Updated By Admin";
}
} ?>

                  <div class="box-tools">
                  <!-- <script>
function myFunction() {
    location.reload();
}
</script> -->

                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="name" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="submit" name="search"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div><!-- /.box-header -->
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
     <style type="text/css">
     .form-login{
      padding: 10px;
     }
     </style>
     <br>
    <?php 

  // Webpage Paging

  $tbl_name="users";    //your table name

  // How many adjacent pages should be shown on each side?

  $adjacents = 3;

  //Count Records in tables

  $targetpage = "admin.php";  //your file name  (the name of this file)

  $limit = 25;                 //how many items to show per page

  $page = $_GET['page'] = "";

  if($page) 

    $start = ($page - 1) * $limit;      //first item to display on this page

  else

    $start = 0;               //if no page var is given, set start to 0 

    

if(isset($_POST['search'])){  

  foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }

  if(preg_match("/[A-Z  | a-z]+/", $data['name'])){ 
    $name=$data['name']; 
  }

  $query2="select * from users where user_level !='2689' and full_name like '%".$name."%' OR user_email like '%".$name."%' order by id DESC " or die("Error in the query" . mysqli_error($con)); 

  $_SESSION['GlobalQuery']=$query2;

  $result2=mysqli_query($con, $query2);

  $total_pages=mysqli_num_rows($result2);

  $query  = "select * from users where user_level !='2689' and full_name like '%".$name."%' OR user_email like '%".$name."%' order by id DESC LIMIT $start, $limit" or die("Error in the query" . mysqli_error($con)); 

  $pag_result = mysqli_query($con, $query); 
  $count = mysqli_num_rows($pag_result);
  if ($count < 1) {
    
    echo "<center><h4 style='color:red;'>Sorry, No Record Available.</h4></center>";
  }

}
  else {



$query2="select * from users where user_level !='2689' order by id DESC" or die("Error in the query" . mysqli_error($con)); 

  $_SESSION['GlobalQuery']=$query2;

  $result2=mysqli_query($con, $query2);

  $total_pages=mysqli_num_rows($result2);

  $query  = "select * from users where user_level !='2689' order by id DESC LIMIT $start, $limit" or die("Error in the query" . mysqli_error($con)); 

  $pag_result = mysqli_query($con, $query); 
$count = mysqli_num_rows($pag_result);
  if ($count < 1) {
    
    echo "<center><h4 style='color:red;'>Sorry, No Record Available.</h4></center>";
  }



}

  

      /* Setup page vars for display. */

                        if ($page == 0) {

    $page = 1;

}     //if no page var is given, default to 1.

  $prev = $page - 1;              //previous page is page - 1

  $next = $page + 1;              //next page is page + 1

  $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.

  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 

    Now we apply our rules and draw the pagination object. 

    We're actually saving the code to a variable in case we want to draw it more than once.

  */

  $pagination = "";

  //echo $total_pages. " ".$page;



  if($lastpage > 1)

  { 

    $pagination .= "<div class=\"paginationh\">";

    //previous button

    if ($page > 1) 

      $pagination.= "<a href=\"$targetpage?page=$prev\"><< Previous</a>";

    else

      $pagination.= "<span class=\"disabled\"><< previous</span>";  

    

    //pages 

    if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up

    { 

      for ($counter = 1; $counter <= $lastpage; $counter++)

      {

        if ($counter == $page)

          $pagination.= "<span class=\"current\">$counter</span>";

        else

          $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         

      }

    }

    elseif($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some

    {

      //close to beginning; only hide later pages

      if($page < 1 + ($adjacents * 2))    

      {

        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

        {

          if ($counter == $page)

            $pagination.= "<span class=\"current\">$counter</span>";

          else

            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         

        }

        $pagination.= "...";

        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";

        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";   

      }

      //in middle; hide some front and some back

      elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

      {

        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";

        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";

        $pagination.= "...";

        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

        {

          if ($counter == $page)

            $pagination.= "<span class=\"current\">$counter</span>";

          else

            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         

        }

        $pagination.= "...";

        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";

        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";   

      }

      //close to end; only hide early pages

      else

      {

        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";

        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";

        $pagination.= "...";

        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

        {

          if ($counter == $page)

            $pagination.= "<span class=\"current\">$counter</span>";

          else

            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         

        }

      }

    }

    

    //next button

    if ($page < $counter - 1) {

                $pagination.= "<a href=\"$targetpage?page=$next\">Next >></a>";}

    else

      {

                $pagination.= "<span class=\"disabled\">next >></span>";

                }

    $pagination.= "</div>\n"; 

    }

?>    
        
    

                <div class="box-body table-responsive no-padding">
                <div class="box-content">
         <?php echo $pagination; ?>
  </div>
<?php if ($count > 0) {
    
    ?>
                          <table class="table table-striped table-advance table-hover">
                           
                              <thead>
                              <tr>
                              <th><i class=" fa fa-image"></i></th>
                               <th><i class=" fa fa-user"></i> Full Name</th>
                                  <th><i class=" fa fa-envelope"></i> Email</th>
                                  <th><i class=" fa fa-level-up"></i> User Type</th>
                                  <th><i class=" fa fa-key"></i> Approve Status</th>
                                  <th><i class=" fa fa-ban"></i> Ban Status</th>
                                  <th><i class=" fa fa-edit"></i> Controls</th>
                              </tr>
                              </thead>
                              <tbody>
                             <?php  } ?> 
                            
                              

<?php while ($rrows = mysqli_fetch_array($pag_result)) {?>
          <tr> 
            <td><?php if($rrows['photo']!=""){?><img src="uploads/profile/<?php echo $rrows['photo']; ?>" width="50" height="50"><?php } ?></td>
            <td><a href="profile_public.php?pp=<?php echo $rrows['id']; ?>" target="_blank"><?php echo strtoupper($rrows['full_name']); ?></a></td>
            <td><?php echo $rrows['user_email']; ?></td>

             <td> 
              <?php if($rrows['user_level']=='1') { echo "Customer"; } elseif($rrows['user_level']=='2') { echo "Staff"; } else {echo "Admin"; }?>
              </td>

            <td> <span id="approve<?php echo $rrows['id']; ?>"> 
              <?php if($rrows['approved']!='1') { echo "Pending"; } else {echo "Active"; }?>
              </span> </td>
            <td><span id="ban<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['banned']) { echo "no"; } else {echo "yes"; }?>
              </span> </td>
            <td> <font size="2"><a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#approve<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-success">Approve</span></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-danger">Ban</span></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-warning">Unban</span></a> 
              <a data-toggle="modal" href="#<?php echo $rrows['id']; ?>"><span class="label label-primary">Edit</span></a> 
              <a data-toggle="modal" href="#del<?php echo $rrows['id']; ?>"><span class="label label-danger">Delete</span></a> 
              </font> </td>
          </tr>

          <div class="modal fade" id="<?php echo $rrows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Account Modification For : <?php echo $rrows['full_name'];?></h4>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
         
          <input type="hidden" name="edit_id" value="<?php echo $rrows['id']; ?>">
       
                          <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" name="full_name" class="form-control" value="<?php echo $rrows['full_name'];?>" >
                        </div>
 
                         <div class="form-group">
                      
                      <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-6">
                          <label>Country Code</label>
                      <input type="text" name="countrycode" class="form-control" value="<?php echo $rrows['countrycode'];?>" >
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-6">
                      <label>Mobile</label>
                        <input type="text" name="tel" class="form-control" value="<?php echo $rrows['tel'];?>" >
                        </div>
                      </div>
                    <div class="form-group">
                      <label>Email Address</label>
                      <input type="text" name="user_email" class="form-control" value="<?php echo $rrows['user_email'];?>" >
                     </div>

                     <div class="form-group">
                    <label>Select User Level</label>
                    <select class="form-control select2" style="width: 100%;" name="user_level">
                      <option <?php if ($rrows['user_level'] == '1') {echo "selected";}?> value="1">User</option>
                      <option <?php if ($rrows['user_level'] == '2') {echo "selected";}?> value="2">Staff</option>
                      <option <?php if ($rrows['user_level'] == '119') {echo "selected";}?> value="119">Administrator</option>
                    </select>
                  </div><!-- /.form-group -->

                  <div class="form-group">
                    <label>Select User Status</label>
                    <select class="form-control select2" style="width: 100%;" name="approved">
                      <option selected="selected" value="1">Approve</option>
                      <option value="0">Pending</option>
                    </select>
                  </div><!-- /.form-group -->

                     <div class="form-group">
                      <label>User Password</label>
                      <input type="text" name="password" class="form-control" >
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

<!-- ************************** MOdal to delete confirm a record  ***************************** -->
  <div class="modal fade" id="del<?php echo $rrows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Delete Confirmation For User : <?php echo $rrows['full_name'];?></h4>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="modal-body">
         
          <input type="hidden" name="delete" value="<?php echo $rrows['id']; ?>">
              
            
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
        </tbody>
        </table>
        
       </div>
 <br />
 <br /><?php if ($count > 0) {
    
    ?>
    
                     <br /><?php } ?>
 <br />       
 <?php echo $pagination; ?>
 <br />
 <br />

              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>