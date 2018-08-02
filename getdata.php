<?php
include 'db.php';
if(isset($_POST['normal'])){
    $offset = $_POST['offset'];
    $ord = $_POST['order'];
    $sort = $_POST['sort'];
    $limit = 40;
    $query = "select * from channels order by $sort $ord LIMIT $offset,$limit";
    $run = mysqli_query($conn, $query);
    $json = include('data.php');
    return $json;
    exit;
}

if(isset($_POST['filter'])){
    $offset = $_POST['offset'];
    $ord = $_POST['order'];
    $limit = 40;
    $sort = $_POST['sort'];
    $subscribers = $_POST['subscribers'];
    $operator = $_POST['operator'];
    $query = "select * from channels where subscribers $operator $subscribers order by subscribers $ord LIMIT $offset,$limit";
    $run = mysqli_query($conn, $query);
    $json = include('data.php');
    return $json;
    exit;
}

if(isset($_POST['search'])){
    $offset = $_POST['offset'];
    $ord = $_POST['order'];
    $limit = 40;
    $sort = $_POST['sort'];
    $search = $_POST['search'];
    $query = "select * from channels where channelid = '$search'";
    $run = mysqli_query($conn, $query);
    $json = include('data.php');
    return $json;
    exit;
}

?>