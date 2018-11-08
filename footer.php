
              <div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Update Profile For : <?php echo $row_settings['full_name'];?></h4>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
        <div class="modal-body">
         <center><img src="uploads/profile/<?php echo $row_settings['photo']; ?>"  alt="User profile picture"  style="max-height:350px !important;" class="img-responsive img-rounded" ></center>

          <input type="hidden" name="edit_id" value="<?php echo $row_settings['id']; ?>">
          <div class="form-group">
                      <label>Change Profile Picture</label>
                       <span class="file-input btn btn-block btn-info btn-file">
                Browse&hellip; <input type="file" name="photo">
            </span>
            </div>

                    
             
            
          
        </div>
        <div class="modal-footer">

          <button type="submit" name="doProfile" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
        <footer class="main-footer">
        <div class="pull-right hidden-xs">
          For Support Contact: <b><?php echo $web['phone'];?></b>
        </div>
        <strong><?php echo $web['footer_copyright'];?></strong>
      </footer>

     
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="plugins/jQuery/jquery-1.9.1.js"></script>
    <script langauge="javascript">
            window.setInterval("refreshDiv()", 5000);
            function refreshDiv(){
               
                document.getElementById("test");

            }
        </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/bootstrap-modal.js"></script>
        <script src="bootstrap/js/bootstrap-modalmanager.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
      $(function () {
        $(".textarea").wysihtml5();
      });
    </script>
    
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
     <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <script>
    $(".select2").select2();
  </script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
     <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    </script>
       

  </body>
</html>
