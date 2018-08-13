<?php
include '../db.php';
if(isset($_GET['term'])){
    $q = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['term'])));
    $return_arr = array();
    $query = 'select * from channels where name LIKE "%'.$q.'%" limit 10';
    $run = mysqli_query($conn, $query);
    if(mysqli_num_rows($run)>0){
            while($row = mysqli_fetch_array($run)){
                $return_arr[] = array(
                        'value' => $row['name'],
                        'channelid' => $row['channelid']
                );
            }
    }else{
        
    }
    
     echo json_encode($return_arr);
}
?>