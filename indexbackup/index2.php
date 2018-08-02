<?php
session_start();
include 'db.php';
include 'functions.php';
include_once 'includes/Pagination.php';
if(!isset($_SESSION['sortBy'])){
    $ord = 'desc';
}else{
    $ord = $_SESSION['sortBy'];
}
if(isset($_GET['sortBy'])){
    $order = $_GET['sortBy'];
    if($order=='lh'){
        $ord = 'asc';
        $_SESSION['sortBy'] = 'asc';
    }else{
        $ord = 'desc';
        $_SESSION['sortBy'] = 'desc';
    }
}
$limit = 40;
$offset = isset($_GET['page'])?(($_GET['page']-1)*$limit):0;
$queryNum = $conn->query("SELECT COUNT(*) as postNum FROM channels");
$resultNum = $queryNum->fetch_assoc();
$rowCount = $resultNum['postNum'];
$pagConfig = array(
    'baseURL'=>'http://localhost/creators/index2.php',
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);
$pagination =  new Pagination($pagConfig);
if(isset($_GET['q'])){
    $q = mysqli_real_escape_string($conn, htmlentities(strip_tags($_GET['q'])));
    $query = 'select * from channels where name LIKE "%'.$q.'%" limit 40';
}else{
    $query = "select * from channels order by subscribers $ord LIMIT $offset,$limit";
}

$run = mysqli_query($conn, $query);
?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Channels Page: <?php echo $_GET['page']; ?></title>
        <?php include 'includes/head.php'; ?>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            .ui-autocomplete{
                z-index: 2000;
            }
            .details{
                cursor: pointer;
            }
			
			input[type="search"]::-webkit-search-cancel-button {
			-webkit-appearance: searchfield-cancel-button;
			}
        </style>
    </head>

    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="list">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($q)){ ?>
                        <h5>
                            <?php echo mysqli_num_rows($run); ?> creators found for keyword: <b><?php echo $q; ?></b></h5>

                        <?php }else{ ?>
                        <h5>
                            <?php echo number_format($rowCount); ?> creators found </h5>
                        <?php } ?>

                    </div>
                    <div class="col-lg-12">
                        <div class="row">
							
							<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Search Channels</label>
                                    <form action="" method="get" id="search-form">
										<input id="search" name="q" type="search" class="form-control" placeholder="Search Channels..." value="<?php if(isset($q)){ echo $q; } ?>">
									</form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Sort by Subscribers</label>
                                    <form action="" method="get">
                                       <?php if(isset($q)){ ?>
                                           <input type="hidden" name="q" value="<?php echo $q; ?>">
                                       <?php } ?>
                                        <select onchange="this.form.submit()" name="sortBy" class="form-control" id="">
                                           <option value="">Select</option>
                                           <option <?php if($ord=='asc'){ echo 'selected'; } ?> value="lh">Low to High</option>
                                           <option <?php if($ord=='desc'){ echo 'selected'; } ?> value="hl">High to Low</option>
                                       </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php 
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
                    $channeldata[$i]['subscribers'] = $item->statistics->subscriberCount != 0 ? $item->statistics->subscriberCount: 'N/A';
                    $channeldata[$i]['views'] = $item->statistics->viewCount;
                    $channeldata[$i]['image'] = $item->snippet->thumbnails->high->url;
                    $channeldata[$i]['country'] = isset($item->snippet->country) ? $item->snippet->country : 'N/A';
                    $channeldata[$i]['description'] = $item->snippet->description;
                    $channeldata[$i]['videos'] = $item->statistics->videoCount;
                    $channeldata[$i]['keywords'] = isset($item->brandingSettings->channel->keywords) ? $item->brandingSettings->channel->keywords : 'N/A';
                    $i++;
                    updateSubs($conn, $item->id, $item->statistics->subscriberCount);
                    updateViews($conn, $item->id, $item->statistics->viewCount);
                }
                  if($ord == 'asc'){
                      usort($channeldata, function ($item1, $item2) {
                        return $item1['subscribers'] <=> $item2['subscribers'];
                    });
                  }else{
                      usort($channeldata, function ($item1, $item2) {
                        return $item2['subscribers'] <=> $item1['subscribers'];
                    });
                  }
                    
                for ($i = 0; $i < count($channeldata); $i++) {
            
          ?>

                    <div class="col-lg-3 col-sm-6">
                        <div class="box grid recipes">
                            <div class="by"><i class="fa fa-eye" aria-hidden="true"></i>
                                <a title="Total Views Count" href="#!" style="color:white" class="details">
                                    <?php echo convert($channeldata[$i]['views']); ?>
                                </a> <span title="Subscribers Count" class="pull-right details"><i class="fa fa-users" aria-hidden="true"></i> <?php echo convert($channeldata[$i]['subscribers']); ?></span></div>
                            <a href="#">
              <img src="https://discoverbrands.co/public/img/loader.gif" data-src="<?php echo $channeldata[$i]['image'] ?>" alt="">
            </a>
                            <h2>
                                <a target="_blank" href="https://www.youtube.com/channel/<?php echo $channeldata[$i]['id']; ?>">
                                    <?php echo shortTitle($channeldata[$i]['title']); ?>
                                </a>
                            </h2>

                           

                            <p><span class="details" title='<p><span style="text-decoration:underline">Channel Title:</span><br><?php echo filteredDesc($channeldata[$i]['title']);  ?></p><p><span style="text-decoration:underline">Description:</span><br><?php echo filteredDesc($channeldata[$i]['description']); ?></p><p><span style="text-decoration:underline">Country:</span><br><?php echo filteredDesc($channeldata[$i]['country']); ?></p><p><span style="text-decoration:underline">Keywords:</span><br><?php echo filteredDesc($channeldata[$i]['keywords']); ?></p>'><i class="fa fa-info-circle" style="color:#e13b2b;cursor:pointer"></i> More</span> - <span class="details" title="Total Videos Count"><i class="fa fa-video" style="color:#e13b2b"></i> <b><?php echo $channeldata[$i]['videos']; ?></b></span></p>
                            <br>
                        </div>
                    </div>
                    <?php 
        }
        ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if(!isset($_GET['q'])){echo $pagination->createLinks();} ?>
                    </div>
                </div>
                <br>
                <br>
                <?php } ?>




            </div>
        </div>



    </body>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('.details').tooltipster({
                delay: 10,
                contentAsHTML: true,
                maxWidth: 500,
                interactive: true,
                multiple: false,
                delay: [0, 200],
                trigger: 'custom',
                triggerOpen: {
                    mouseenter: true,
                    touchstart: true
                },
                triggerClose: {
                    click: true,
                    mouseleave: true,
                    tap: true
                }
            });
        });
    </script>
    <script>
        function init() {
            var imgDefer = document.getElementsByTagName('img');
            for (var i = 0; i < imgDefer.length; i++) {
                if (imgDefer[i].getAttribute('data-src')) {
                    imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
                }
            }
        }
        window.onload = init;
        
        $(document).ready(function () {
        $("#search").autocomplete({
            source: "autocomplete.php",
            minLength: 3,
            select: function(event, ui) {
                $("#search-form").submit();
            }
        });
    });

        <?php $r = isset($_GET['page'])? ($_GET['page']+1):2; ?>
        window.onload = function() {
            window.location.href = "http://localhost/creators/index2?page=<?php echo $r; ?>";
        }
        
        
        
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </html>