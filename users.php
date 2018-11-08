<?php error_reporting(0);
include 'controls/ovais.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
  $get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
  $post[$key] = filter($value);
}

if($POST['doBan'] == 'Ban') {

if(!empty($_POST['u'])) {
  foreach ($_POST['u'] as $uid) {
    $id = filter($uid);
    $upquery = "update users set banned='1' where id='$id' and `user_name` <> 'admin'" or die("Error in the query" . mysqli_error($con)); 
    mysqli_query($con, $upquery);
  }
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doUnban'] == 'Unban') {

if(!empty($_POST['u'])) {
  foreach ($_POST['u'] as $uid) {
    $id = filter($uid);
    $updquer = "update users set banned='0' where id='$id'" or die("Error in the query" . mysqli_error($con)); 
    mysqli_query($con, $updquer);
  }
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doDelete'] == 'Delete') {

if(!empty($_POST['u'])) {
  foreach ($_POST['u'] as $uid) {
    $id = filter($uid);
    $delquery = "delete from users where id='$id' and `user_name` <> 'admin'" or die("Error in the query" . mysqli_error($con)); 
    mysqli_query($con, $delquery);
  }
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doApprove'] == 'Approve') {

if(!empty($_POST['u'])) {
  foreach ($_POST['u'] as $uid) {
    $id = filter($uid);
    $apquery = "update users set approved='1' where id='$id'" or die("Error in the query" . mysqli_error($con)); 
    mysqli_query($con, $apquery);
    
    $emqyer = "select user_email from users where id='$uid'" or die("Error in the query" . mysqli_error($con));
    $ku = mysqli_query($con, $emqyer);
    list($to_email) = mysqli_fetch_row($ku); 
 
$message = 
"Hello,\n
Thank you for registering with us. Your account has been activated...\n

*****LOGIN LINK*****\n
http://$host$path/admin/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

@mail($to_email, "SEEMALIVE | User Activation", $message,
    "From: \"SEEMALIVE | ADMIN\" <authenticate@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
   
  }
 }
 
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];  
 header("Location: $ret");
 exit();
}

// $rs_all = mysql_query("select count(*) as total_all from users") or die(mysql_error());
// $rs_active = mysql_query("select count(*) as total_active from users where approved='1'") or die(mysql_error());
// $rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");               

// list($total_pending) = mysql_fetch_row($rs_total_pending);
// list($all) = mysql_fetch_row($rs_all);
// list($active) = mysql_fetch_row($rs_active);


      require_once('header.php');
      require_once('leftmenu.php'); ?>

            <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Registered Members
            <small>Membership Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Membership Panel</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
                <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Available Members</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <p><?php 
    if(!empty($msg)) {
    echo $msg[0];
    }
    ?></p>
     <style type="text/css">
     .form-login{
      padding: 10px;
     }
     </style>
     <br>
    <?php 

  // Webpage Paging

  $tbl_name="file";    //your table name

  // How many adjacent pages should be shown on each side?

  $adjacents = 3;

  //Count Records in tables

  $targetpage = "admin.php";  //your file name  (the name of this file)

  $limit = 10;                 //how many items to show per page

  $page = $_GET['page'];

  if($page) 

    $start = ($page - 1) * $limit;      //first item to display on this page

  else

    $start = 0;               //if no page var is given, set start to 0 

    

  //$GetRecord=mysql_query("SELECT * FROM student");

  

$query2="select * from users" or die("Error in the query" . mysqli_error($con)); 

  $_SESSION['GlobalQuery']=$query2;

  $result2=mysqli_query($con, $query2);

  $total_pages=mysqli_num_rows($result2);

  $query  = "select * from users LIMIT $start, $limit" or die("Error in the query" . mysqli_error($con)); 

  $pag_result = mysqli_query($con, $query); 





  

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

    $pagination .= "<div class=\"pagination\">";

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
                  

                  <form name "searchform" action="admin.php" method="post" class="niceform">
                          <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i>Users Available</h4>
                            <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i>Selection</th>
                                  <th><i class=" fa fa-edit"></i> User Name</th>
                                  <th><i class=" fa fa-edit"></i> Password</th>
                                  <th><i class=" fa fa-edit"></i> Email</th>
                                  <th><i class=" fa fa-edit"></i> Level</th>
                                  <th><i class=" fa fa-edit"></i> Approve Status</th>
                                  <th><i class=" fa fa-edit"></i> Ban Status</th>
                                  <th><i class=" fa fa-edit"></i> Controls</th>
                              </tr>
                              </thead>
                              <tbody>
                              
                            
                              

<?php while ($rrows = mysqli_fetch_array($pag_result)) {?>
          <tr> 
            <td><input name="u[]" type="checkbox" value="<?php echo $rrows['id']; ?>" id="u[]"></td>
            <td><?php echo $rrows['user_name'];?></td>
            <td><?php echo $rrows['itsmeadmin']; ?></td>
            <td><?php echo $rrows['user_email']; ?></td>
            <td><?php echo $rrows['user_level']; ?></td>
            <td> <span id="approve<?php echo $rrows['id']; ?>"> 
              <?php if($rrows['approved']!='1') { echo "Pending"; } else {echo "Active"; }?>
              </span> </td>
            <td><span id="ban<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['banned']) { echo "no"; } else {echo "yes"; }?>
              </span> </td>
            <td> <font size="2"><a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#approve<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-success">Approve</span></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-danger">Ban</span></a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'><span class="label label-warning">Unban</span></a> 
              <a href="javascript:void(0);" onclick='$("#edit<?php echo $rrows['id'];?>").show("slow");'><span class="label label-primary">Edit</span></a> 
              </font> </td>
          </tr>
          <tr> 
            <td colspan="7">
      
      <div style="display:none;font: normal 11px arial; padding:10px; background: #e6f3f9" id="edit<?php echo $rrows['id']; ?>">
      
      <input type="hidden" name="id<?php echo $rrows['id']; ?>" id="id<?php echo $rrows['id']; ?>" value="<?php echo $rrows['id']; ?>">
      User Name: <input name="user_name<?php echo $rrows['id']; ?>" id="user_name<?php echo $rrows['id']; ?>" type="text" size="10" value="<?php echo $rrows['user_name']; ?>" >
      User Email:<input id="user_email<?php echo $rrows['id']; ?>" name="user_email<?php echo $rrows['id']; ?>" type="text" size="20" value="<?php echo $rrows['user_email']; ?>" >
      Level: <input id="user_level<?php echo $rrows['id']; ?>" name="user_level<?php echo $rrows['id']; ?>" type="text" size="5" value="<?php echo $rrows['user_level']; ?>" > 1->user,5->admin
      <br><br>New Password: <input id="pass<?php echo $rrows['id']; ?>" name="pass<?php echo $rrows['id']; ?>" type="text" size="20" value="" > (leave blank)
      <input name="doSave" class = "btn btn-success btn-xs" type="button" id="doSave" value="Save" 
      onclick='$.get("do.php",{ cmd: "edit", pass:$("input#pass<?php echo $rrows['id']; ?>").val(),user_level:$("input#user_level<?php echo $rrows['id']; ?>").val(),user_email:$("input#user_email<?php echo $rrows['id']; ?>").val(),user_name: $("input#user_name<?php echo $rrows['id']; ?>").val(),id: $("input#id<?php echo $rrows['id']; ?>").val() } ,function(data){ $("#msg<?php echo $rrows['id']; ?>").html(data); });'> 
      <a  onclick='$("#edit<?php echo $rrows['id'];?>").hide();' href="javascript:void(0);"><button class = "btn btn-danger btn-xs">Close</button></a>
     
      <div style="color:red" id="msg<?php echo $rrows['id']; ?>" name="msg<?php echo $rrows['id']; ?>"></div>
      </div>
      
      </td>
          </tr>
          <?php } ?>
        </tbody>
        </table>
        
       </div>
       
 <?php echo $pagination; ?>
 <br />
 <br />
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once('footer.php'); ?>