<?php 

require ('controls/ovais.php');

page_protect(); 

if(!empty($_POST['var1']) || !empty($_POST['var2'])){
		
		$table = $_POST['var1'];
    $where = $_POST['var2'];
		$gotit = "SELECT * from $table $where";
	$fetch = mysqli_query($con,$gotit);
		echo $count = mysqli_num_rows($fetch);
	}

	?>