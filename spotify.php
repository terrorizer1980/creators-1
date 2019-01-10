<?php
session_start();
include 'db.php';
include 'includes/init.php';
require_once 'SpotifyApi/src/Request.php';
require_once 'SpotifyApi/src/Session.php';
require_once 'SpotifyApi/src/SpotifyWebAPI.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

$session = new SpotifyWebAPI\Session(
    '9626752eafad4523b1c695d05b6d8748',
    'd7ada7ffe7514e5395fbe20aab20ba88'
);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);
$artist = $api->getArtist($id);
//echo "<pre>";
//var_dump($artist);
//echo '--------';
$albums = $api->getArtistAlbums($id);
$toptracks = $api->getArtistTopTracks($id, 'country=US');
$relatedartists = $api->getArtistRelatedArtists($id);
//var_dump($albums);
?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Spotify Profile</title>
        <?php include 'includes/head.php'; ?>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="assets/js/jquery.range.css">
    </head>

    <body>
        <?php $page='index'; include 'includes/nav.php'; ?>
        <div class="list">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Spotify Profile for Artist: <b><?php echo $artist->name; ?></b></h5>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                       <center>
                        <img class="img-fluid rounded-circle" src="<?php echo $artist->images[1]->url; ?>" alt="">
                       </center>
                       </div>
                    </div>
                    <div class="col-lg-6">
                        <p>Followers: <b><?php echo number_format($artist->followers->total); ?></b></p>
                        <p>Popularity: <b><?php echo ($artist->popularity); ?></b></p>
                        <p>URI: <b><?php echo ($artist->uri); ?></b></p>
                        <p>Genres: <br> <b><?php echo implode(', ', $artist->genres); ?></b></p>
                        <p>Href: <b><a target="_blank" href="https://open.spotify.com/artist/<?php echo $id; ?>">https://open.spotify.com/artist/<?php echo $id; ?></a></b></p>
                        <p>Followers: <b><?php echo ($artist->followers->total); ?></b></p>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Top Tracks (Previews)</h5>
                    </div>
                </div>
                <div class="row">
                    <?php foreach($toptracks->tracks as $track){ ?>
                        <div class="col-lg-4" style="margin-bottom:10px">
                           <center>
                            <audio controls>
                                <source src="<?php echo $track->preview_url; ?>" type="audio/mpeg"/>
                            </audio>
                            <p style="margin-top:5px"><a style="color:#666;text-decoration:underline" target="_blank" href="<?php echo $track->external_urls->spotify; ?>"><?php echo $track->name; ?></a></p>
                           </center>
                        </div> 
                    <?php } ?>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Artist Albums</h5>
                    </div>
                </div>
                    <div class="row">
                        <?php $i=1; foreach($albums->items as $item){ ?>
                            <div class="col-lg-2" style="margin-bottom:10px">
                               <center>
                                <img class="img-fluid rounded-circle" src="<?php echo $item->images[1]->url; ?>" alt="">
                                <p style="margin-top:5px"><?php echo $item->name; ?></p>
                               </center>
                            </div> 
                        <?php $i++; } ?>
                    </div><br>
            <div class="row">
                <div class="col-lg-12">
                    <h5>Related Artists</h5>
                </div>
            </div>
            <div class="row">
                <?php foreach($relatedartists->artists as $artist){ ?>
                    <div class="col-lg-2 col-6" style="margin-bottom:10px">
                       <center>
                        <a href="<?php echo $artist->external_urls->spotify; ?>" target="_blank"><img style="width:150px;height:150px;object-fit:cover" class="img-fluid rounded-circle" src="<?php echo $artist->images[1]->url; ?>" alt=""></a>
                        <p style="margin-top:5px"><a style="color:#666;text-decoration:underline" href="<?php echo $artist->external_urls->spotify; ?>" target="_blank"><?php echo $artist->name; ?></a></p>
                       </center>
                    </div>
                <?php } ?>
            </div>
                
            </div>
        </div>
    </body>
    <?php include 'includes/scripts.php'; ?>
    <script src="assets/js/app.js?<?php echo time(); ?>"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </html>