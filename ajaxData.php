<?php
require ('controls/ovais.php');

if(!empty($_POST["country_id"])){
    //Fetch all state data
    $query = mysqli_query($con, "SELECT * FROM city WHERE country_id = ".$_POST['country_id']." AND status = '1' ORDER BY title ASC");
    
    //Count total number of rows
    $rowCount = mysqli_num_rows($query);
    
    //State option list
    if($rowCount > 0){
        echo '<option value="">Select City Now</option>';
        while($row = mysqli_fetch_array($query)){ 
            echo '<option value="'.$row['city_id'].'">'.$row['title'].'</option>';
        }
    } else {
        echo '<option value="">No City in Record</option>';
    }
}


?>