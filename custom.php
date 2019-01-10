<?php
include 'db.php';
$conn2 =  mysqli_connect('localhost', 'root', '', 'music');
$youtube_key = 'AIzaSyAMwSQU5ZumKTFhRERSsKYgfY3iA9Oz4X8';
$query = 'select * from channels limit 500 offset 2040';
$run = mysqli_query($conn, $query);
if(mysqli_num_rows($run)>0){
    
    while($row = mysqli_fetch_array($run)){ 
        $channelid = $row['channelid'];
        echo $channelid."<br>";
        
        $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=topicDetails,status,brandingSettings,contentDetails,contentOwnerDetails,localizations,snippet,statistics,topicDetails&id='.$channelid.'&key='.$youtube_key;
        $data = file_get_contents( $posturl, false);
        $response = json_decode($data);
        
        
        $country = isset($response->items[0]->snippet->country) ? $response->items[0]->snippet->country : 'N/A';
        $tags = isset($response->items[0]->brandingSettings->channel->keywords) ? $response->items[0]->brandingSettings->channel->keywords : 'N/A';
        
        $query2 = "INSERT INTO channels (id, channelid, country, tags) VALUES (NULL, '$channelid', '$country', '$tags')";
        mysqli_query($conn2, $query2);
    }
}