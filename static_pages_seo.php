<?php include_once('header.php'); ?>
<?php 

if(!checkAdmin()) {

header("Location: login.php");

exit();

}

?>



<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            S.E.O Tools
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">S.E.O For Pages</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
      <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
              <?php

    if(isset($_POST['doSubmit']))

{



$checkrecord = mysqli_query($con, "select * from static_seo");
$countit = mysqli_num_rows($checkrecord);
if ($countit == 0) {
  
$inscq = "INSERT INTO static_seo (`id`,`page_title`,`page_description`,`page_keywords`,`page_author`,`page_publisherid`)

       VALUES ('1',$_POST[title]','$_POST[description]','$_POST[keywords]','$_POST[author]','$_POST[publisher]')

       " or die("Error in the query" . mysqli_error($con)); 
$finalize = mysqli_query($con, $inscq); 

if ($finalize == 1) {?>

<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Successfull!</h4>
                    Your Settings have been saved successfully.
                  </div>
      
 <?php }
}
else {

$finalized = mysqli_query($con, "update static_seo set page_title='$_POST[title]',page_description='$_POST[description]',page_author='$_POST[author]',page_publisherid='$_POST[publisher]',page_keywords='$_POST[keywords]'");
if ($finalized == 1) {?>


      <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Successfull!</h4>
                    Your Settings have been updated successfully.
                  </div>
 <?php }
}
}

    ?>
        <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Static Pages SEO Setting</h3>
                  <?php $rs_settings = mysqli_query($con, "select * from static_seo where id='1'");
$row_settingss = mysqli_fetch_array($rs_settings); ?>
                </div>
                <div class="box-body">
                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="title" class="control-label">Enter Page Title</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Page Title" name="title" value="<?php echo $row_settingss['page_title']; ?>">
                  </div>
                  <br>
                  <label for="author" class="control-label">Enter Page Author Name</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Page Author" name="author" value="<?php echo $row_settingss['page_author']; ?>" >
                  </div>
                  
                      <br />
                      <label for="publisher" class="control-label">Enter Google Publisher ID</label>
                  <div class="input-group">
                     <span class="input-group-addon"><i class="fa fa-google"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Google Publisher" name="publisher" value="<?php echo $row_settingss['page_publisherid']; ?>" >
                  </div>
                  <br />
                   <div class="form-group">
                        <label for="Description" class="col-sm-3 control-label">Enter Page Description</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" rows = "3" name="description"><?php echo $row_settingss['page_description']; ?></textarea>
                        </div>
                      </div>
                   <br />
                  
                  <div class="form-group">
                    <label for="keyword" class="col-sm-3 control-label">Enter Page Keywords</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" rows = "3" name="keywords"><?php echo $row_settingss['page_keywords']; ?></textarea>
                        </div>
                    </div>
                  <br>
                 

                 
<br />

                
                     
<input type="submit" name="doSubmit" id="doSubmit" class="btn btn-success pull-right" value="Save Setting" />
                </div><!-- /.box-body -->
              </div><!-- /.box -->
</div>
<div class="col-md-2"></div>
      </div><!--/row-->
    
<p> 

  </div><!--/.fluid-container-->
  
      <!-- end: Content -->
    </div><!--/#content.span10-->
    </div><!--/fluid-row-->
    
  
  </div>
  </div></div></div>
  <div class="clearfix"></div>
<?php include('footer.php');?>
