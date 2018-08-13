<?php
include '../db.php';
if(isset($_POST['channelid'])){
    
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
    
    $id = $_POST['channelid'];
    $posturl = 'https://www.googleapis.com/youtube/v3/search?key='.$youtube_key.'&channelId='.$id.'&part=snippet,id&order=date&maxResults=1';
    $data = file_get_contents( $posturl, false, stream_context_create($arrContextOptions));
    $response = json_decode($data);
    $count = count($response->items);
    $videoid = $response->items[0]->id->videoId;
    $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$id.'&key='.$youtube_key;
    
    $data = file_get_contents( $posturl, false, stream_context_create($arrContextOptions));
    $response = json_decode($data);
    if(count($response->items)>0){
        $data = array(
            'url'=>$response->items[0]->snippet->thumbnails->high->url,
            'channelId'=>$response->items[0]->id,
            'videoid'=> isset($videoid)?$videoid:'',
            'count'=>$count
        );
        echo json_encode($data);
    }else{
        echo "<script>alert('Error');</script>";
    }
}
?>