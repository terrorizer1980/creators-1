<?php
function getTotalRows($conn, $query){
     $run = mysqli_query($conn, $query);
     $totalrows = mysqli_num_rows($run);
     return $totalrows;
}

if(!isset($_SESSION['orderBy'])){
    $ord = 'desc';
}else{
    $ord = $_SESSION['orderBy'];
}

if(isset($_GET['orderBy'])){
    $order = $_GET['orderBy'];
    if($order=='asc'){
        $ord = 'asc';
        $_SESSION['orderBy'] = 'asc';
    }else{
        $ord = 'desc';
        $_SESSION['orderBy'] = 'desc';
    }
}


if(!isset($_SESSION['sortBy'])){
    $sort = 'subscribers';
}else{
    $sort = $_SESSION['sortBy'];
}

if(isset($_GET['sortBy'])){
    $sorting = $_GET['sortBy'];
    if($sorting=='subs'){
        $sort = 'subscribers';
        $_SESSION['sortBy'] = 'subscribers';
    }else{
        $sort = 'views';
        $_SESSION['sortBy'] = 'views';
    }
}


$limit = 40;
$offset = 0;
$queryNum = $conn->query("SELECT COUNT(*) as postNum FROM channels");
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
if(isset($_GET['q'])){
    $q = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['q'])));
    $query = 'select * from channels where name LIKE "%'.$q.'%" limit 40';
    $query2 = 'select * from channels where name LIKE "%'.$q.'%"';
    $totalrows = getTotalRows($conn, $query2);
}elseif(isset($_GET['compare'])){
    $c1 = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['c1'])));
    $c2 = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['c2'])));
    $query = "select * from channels where name='$c1' OR name='$c2'";
}else{
    $query = "select * from channels order by $sort $ord LIMIT $limit";
    $query2 = "select * from channels";
    $totalrows = getTotalRows($conn, $query2);
}
$run = mysqli_query($conn, $query);
?>