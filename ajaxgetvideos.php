<?php
include 'db.php';
$channelid = $_POST['id'];
$posturl = "https://www.googleapis.com/youtube/v3/search?key=$youtube_key&channelId=$channelid&part=snippet,id&type=video&order=date&maxResults=5";
$data = file_get_contents( $posturl, false);
$response = json_decode($data);
$data = "";
foreach($response->items as $item){
    $data.= '<div class="youtubes" data-embed="'.$item->id->videoId.'"> 
                    <div class="play-button"></div> 
                    <img class="thumbs" src="https://img.youtube.com/vi/'.$item->id->videoId.'/sddefault.jpg">
                </div>';
}
echo $data;
?>