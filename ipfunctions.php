<?php include_once('header.php');

if (isset($_GET['ip']) && isset($_GET['status'])) {
  $msg = array();
$err = array();
$date = date("Y-m-d H:i:s");
 foreach($_GET as $key => $value) {
                $get[$key] = filter($value);
            }

            $ip = $get['ip'];
            $status = $get['status'];

            if ($status == 1) {
              $doti = mysqli_query($con, "INSERT INTO `blocked_ips`(`ip`, `cdate`) VALUES ('$ip','$date')");
              if ($doti == 1) {
                $msg[] = "<strong>(".$ip . ")</strong> IP Has Been Blocked Successfully.";
              }
              else {
                $err[] = "Error Occurred";
              }
            }
            elseif ($status == 2) {
              $remit = mysqli_query($con, "DELETE FROM `blocked_ips` WHERE `ip` = '$ip'");
              if ($remit) {
                $msg[] = "<strong>(".$ip . ")</strong> IP Has Been Un-Blocked Successfully.";
              }
              else {
                $err[] = "Error Occurred";
              }
            }

}
?>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6" style="margin-top: 20%;">
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
  </div>
  <div class="col-md-3"></div>
  </div>
  <script type="text/javascript">
    window.setTimeout(function() {
    window.location.href = 'activity_log.php';
}, 5000);
  </script>
</section>


</div>

<?php include_once('footer.php');?>