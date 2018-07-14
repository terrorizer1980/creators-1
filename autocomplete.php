<?php
include 'db.php';
if(isset($_GET['term'])){
    $q = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['term'])));
    $return_arr = array();
    $query = 'select * from channels where name LIKE "%'.$q.'%" limit 5';
    $run = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($run)){
        $return_arr[] = $row['name'];
    }
     echo json_encode($return_arr);
}
?>