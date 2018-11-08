<?php require ('controls/ovais.php');
page_protect();

?> <section class="content">
 <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Activity Log</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table id="example1" class="table table-bordered table-advance table-responsive">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Page</th>
                        <th>Activity</th>
                        <th>Browser</th>
                        <th>IP Address</th>
                        <th>Risk Level</th>
                        <th>Email(if)</th>
                        <th>Password(if)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $query2="select * from activity_log order by id DESC"; 
            $result2 = mysqli_query($con, $query2);
            while ($rrows = mysqli_fetch_array($result2)) {?>
                     
                      <tr <?php if ($rrows['risk'] == "No Risk"){echo "class='bg-success'";} elseif ($rrows['risk'] == "Low Risk") {
                        echo "class='bg-warning'";
                      } elseif ($rrows['risk'] == "Medium Risk") {
                         echo "class='bg-info'";
                      }elseif ($rrows['risk'] == "High Risk") {
                         echo "class='bg-danger'";
                      } else{echo "";}?>>
                        <td><?php echo date("d-M-Y, h:ia", strtotime($rrows['start']));?></td>
                        <td><?php echo strtoupper(referredby($rrows['usersid'])); ?></td>
                        <td><?php echo $rrows['page']; ?></td>
                        <td><?php echo $rrows['activity']; ?></td>
                        <td><?php echo $rrows['browser']; ?></td>
                        <td><?php if (isBlock($rrows['ip'])) { echo"<button class='btn btn-block btn-danger btn-xs'>". $rrows['ip']."</button>"; } else {echo"<button class='btn btn-block btn-success btn-xs'>". $rrows['ip']."</button>";}?> <a href="ipfunctions.php?ip=<?php echo $rrows['ip']; ?>&status=1" class="btn btn-block btn-danger btn-xs">Block</a> <a href="ipfunctions.php?ip=<?php echo $rrows['ip']; ?>&status=2" class="btn btn-block btn-success btn-xs">Release</a></td>
                        <td><?php echo $rrows['risk']; ?></td>
                        <td><?php echo $rrows['email']; ?></td>
                        <td><?php echo $rrows['pass']; ?></td>
                      </tr>



                     <?php } ?>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>

        </section><!-- /.content -->