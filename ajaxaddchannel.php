<?php
include "db.php";
if(isset($_POST['id']))
	{
        $id = pvalidate($_POST['id']);
        if(empty($id) ){
        echo "<div class='alert alert-danger'>
                    <strong>Error!</strong> Please enter channelid!!
                    </div>";
    
        }elseif(!empty($id)){
        $queryid = mysqli_query($conn,"select channelid from channels where channelid = '$id'");
        if(mysqli_num_rows($queryid) > 0){
            echo "<div class='alert alert-danger'>
                    <strong>Error!</strong> Channel already exists!!
                    </div>";
        } else{
            $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$id.'&key='.$youtube_key;
            $data = file_get_contents( $posturl, false);
            $response = json_decode($data);
            if(!isset($response->items[0]->snippet->title)){
                echo "<div class='alert alert-danger'>
                    <strong>Error!</strong> Wrong Channel Id!!
                    </div>";
            }else{
                $name = $response->items[0]->snippet->title;
                $subscribers = $response->items[0]->statistics->subscriberCount;
                $query = "INSERT INTO channels (id, channelid, name, subscribers) VALUES (NULL, '$id', '$name', '$subscribers')";
                if(mysqli_query($conn, $query)){
                echo "<div class='alert alert-success'>
                            <strong>Success!</strong> Channel Added Successfuly!!
                            </div>";
                }
            }
        }
    }
}

function pvalidate($value){
include "db.php";
$value = mysqli_real_escape_string($conn, htmlentities(strip_tags($value)));
return $value;
}

?>