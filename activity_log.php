<?php require('header.php');

?>



      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

        <!-- Content Header (Page header) -->

          <section class="content-header">

<div class="row"><div class="col-md-3">

         <a href="activity_log.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">

                <span class="info-box-icon bg-green"><i class="fa fa-quote-left"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Total Logs</span>

                  <span class="info-box-number"><?php counterhome("activity_log",$argument="","activity_log"); ?><div id="activity_log"></div></span>

                </div><!-- /.info-box-content -->

              </div></a>

            </div>

            <div class="col-md-3">

         <a href="activity_log.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">

                <span class="info-box-icon bg-blue"><i class="fa fa-user"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Low Risk</span>

                  <span class="info-box-number"><?php $low = 'where risk = "Low Risk"'; counterhome("activity_log",$low,"low"); ?><div id="low"></div></span>

                </div><!-- /.info-box-content -->

              </div></a>

            </div>

            <div class="col-md-3">

         <a href="activity_log.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">

                <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Medium Risk</span>

                  <span class="info-box-number"><?php $med = 'where risk = "Medium Risk"'; counterhome("activity_log",$med,"med"); ?><div id="med"></div></span>

                </div><!-- /.info-box-content -->

              </div></a>

            </div>

            <div class="col-md-3">

         <a href="activity_log.php" style="letter-spacing: 1px; font-weight: bold; color:#000;"><div class="info-box">

                <span class="info-box-icon bg-red"><i class="fa fa-times"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">High Risk</span>

                  <span class="info-box-number"><?php $high = 'where risk = "High Risk"'; counterhome("activity_log",$high,"high"); ?><div id="high"></div></span>

                </div><!-- /.info-box-content -->

              </div></a>

            </div>

            </div>

        </section>



<script type="text/javascript">



var initList = setInterval(function(){ $("#my_div").load('activity_log_ajax_file.php');

}, 2000);



$(document).ready(function(){

    $("#my_div").mouseover(function(){

      clearInterval(initList);

    });

    $("#my_div").mouseout(function(){

      initList = setInterval(function(){ $("#my_div").load('activity_log_ajax_file.php');

}, 2000);



    });

});





  </script> 

 

  <div id="my_div"></div>    <!-- Main content -->

       

      </div><!-- /.content-wrapper -->

<?php include_once('footer.php');?>