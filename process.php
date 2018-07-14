<?php

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
    $youtube_key = 'AIzaSyA7dxlViSTWdJGzgq-EhRcdiRKTU-FS2xA';
    $url = 'https://youtube.com/channel/UCq-Fj5jknLsUf-MWSy4_brA';
    if (strpos($url,'/channel/') == true) {
        $pos = strrpos($url, '/');
        $id = $pos === false ? $url : substr($url, $pos + 1);
        $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics,topicDetails,brandingSettings&id='.$id.'&key='.$youtube_key;
    }
    $data = file_get_contents( $posturl, false, stream_context_create($arrContextOptions));
    $response = json_decode($data);
    //$logo = $response->items[0]->snippet->thumbnails->high->url;
    echo "<pre>";
    var_dump($response);

?>