<?php 
include 'functions.php';
$channelids = array();
if(mysqli_num_rows($run)>0){

while($row = mysqli_fetch_array($run)){ 
    $channelid = $row['channelid'];
    $channelids[] = $channelid;
}
$ids = implode(',', $channelids);
$posturl = 'https://www.googleapis.com/youtube/v3/channels?part=topicDetails,status,brandingSettings,contentDetails,contentOwnerDetails,localizations,snippet,statistics,topicDetails&order=viewCount&id='.$ids.'&key='.$youtube_key;
$data = file_get_contents( $posturl, false);
$response = json_decode($data);

$i = 0;
$channeldata = array();
foreach($response->items as $item){
    $channeldata[$i]['id'] = $item->id;
    $channeldata[$i]['title'] = $item->snippet->title;
    $channeldata[$i]['subscribers'] = $item->statistics->subscriberCount != 0 ? $item->statistics->subscriberCount: 0;
    $channeldata[$i]['views'] = $item->statistics->viewCount;
    $channeldata[$i]['image'] = $item->snippet->thumbnails->high->url;
    $channeldata[$i]['country'] = isset($item->snippet->country) ? $item->snippet->country : 'N/A';
    $channeldata[$i]['description'] = $item->snippet->description;
    $channeldata[$i]['videos'] = $item->statistics->videoCount;
    $channeldata[$i]['keywords'] = isset($item->brandingSettings->channel->keywords) ? $item->brandingSettings->channel->keywords : 'N/A';
    $socialmedia = getSocialLinks($item->id, $conn);
    $channeldata[$i]['instagram'] = $socialmedia['instagram'];
    $channeldata[$i]['twitter'] = $socialmedia['twitter'];
    updateSubs($conn, $item->id, $item->statistics->subscriberCount);
    updateViews($conn, $item->id, $item->statistics->viewCount);
    $i++;
    
}

if(!isset($c1)){
if($sort=='views'){
  if($ord == 'asc'){
      usort($channeldata, function ($item1, $item2) {
        return $item1['views'] <=> $item2['views'];
    });
  }else{
      usort($channeldata, function ($item1, $item2) {
        return $item2['views'] <=> $item1['views'];
    });
  }
}elseif($sort=='subscribers'){
    if($ord == 'asc'){
      usort($channeldata, function ($item1, $item2) {
        return $item1['subscribers'] <=> $item2['subscribers'];
    });
  }else{
      usort($channeldata, function ($item1, $item2) {
        return $item2['subscribers'] <=> $item1['subscribers'];
    });
  }
}
}

for ($i = 0; $i < count($channeldata); $i++) {

?>

    <div class="col-lg-3 col-sm-6" id="<?php echo $channeldata[$i]['id']; ?>">
        <div class="box grid recipes">
            <div class="by"><i class="fa fa-eye" aria-hidden="true"></i>
                <span id="<?php echo $channeldata[$i]['id']; ?>-views" title="Total Views Count" style="color:white" class="details">
                    <?php echo convert($channeldata[$i]['views']); ?>
                </span> <span id="<?php echo $channeldata[$i]['id']; ?>-subs" title="Subscribers Count" class="pull-right details"><i class="fa fa-users" aria-hidden="true"></i> <?php echo $channeldata[$i]['subscribers']==0? 'N/A':convert($channeldata[$i]['subscribers']); ?></span></div>
            <a href="#" class="showinfoimg">
              <img id="<?php echo $channeldata[$i]['id']; ?>-img" src="https://discoverbrands.co/public/img/loader.gif" data-src="<?php echo $channeldata[$i]['image'] ?>" alt="">
            </a>
            <h2>
                <a class="showinfo" data-twitter="<?php echo $channeldata[$i]['twitter']; ?>" data-instagram="<?php echo $channeldata[$i]['instagram']; ?>" data-channelid="<?php echo $channeldata[$i]['id']; ?>" data-title="<?php echo $channeldata[$i]['title']; ?>" target="_blank" href="https://www.youtube.com/channel/<?php echo $channeldata[$i]['id']; ?>">
                    <?php echo shortTitle($channeldata[$i]['title']); ?>
                </a>
            </h2>

           <p><span class="details" title='<p><span style="text-decoration:underline">Channel Title:</span><br><?php echo filteredDesc($channeldata[$i]['title']);  ?></p><p><span style="text-decoration:underline">Description:</span><br><?php echo filteredDesc($channeldata[$i]['description']); ?></p><p><span style="text-decoration:underline">Country:</span><br><?php echo filteredDesc($channeldata[$i]['country']); ?></p><p><span style="text-decoration:underline">Keywords:</span><br><?php echo filteredDesc($channeldata[$i]['keywords']); ?></p>'> <i class="fa fa-info-circle" style="color:#e13b2b;cursor:pointer"></i> More</span> - <span class="details" title="Total Videos Count"><i class="fa fa-video" style="color:#e13b2b"></i> <b><?php echo $channeldata[$i]['videos']; ?></b></span></p>
            <br>
        </div>
    </div>

    <?php 
        }}else{ echo '<script>alert("No more records")</script>'; }
    ?>