<?php
session_start();
include 'db.php';
include_once 'includes/Pagination.php';
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
    <!doctype html>
    <html lang="en">

    <head>
        <title>Channels</title>
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
            
            #infomodal.modal-dialog{
                overflow-y: initial !important
            }
            
            #infomodal.modal-body{
                height: 500px;
                overflow-y: auto;
            }
            
            .youtubes {
                background-color: #000;
                margin-bottom: 30px;
                position: relative;
                padding-top: 56.25%;
                overflow: hidden;
                cursor: pointer;
            }
            .youtubes img {
                width: 100%;
                top: -16.84%;
                left: 0;
                opacity: 0.7;
            }
            .youtubes .play-button {
                width: 90px;
                height: 60px;
                background-color: #e13b2b;
                box-shadow: 0 0 30px rgba( 0,0,0,0.6 );
                z-index: 1;
                opacity: 0.8;
                border-radius: 6px;
            }
            .youtubes .play-button:before {
                content: "";
                border-style: solid;
                border-width: 15px 0 15px 26.0px;
                border-color: transparent transparent transparent #fff;
            }
            .youtubes img,
            .youtubes .play-button {
                cursor: pointer;
            }
            .youtubes img,
            .youtubes iframe,
            .youtubes .play-button,
            .youtubes .play-button:before {
                position: absolute;
            }
            .youtubes .play-button,
            .youtubes .play-button:before {
                top: 50%;
                left: 50%;
                transform: translate3d( -50%, -50%, 0 );
            }
            .youtubes iframe {
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
            }
            
             .tag a {
                display: inline-block;
                padding: 3px 15px;
                color: #666;
                border: 1px solid #dedede;
                border-radius: 50px;
            }
            
        </style>
        <link rel="stylesheet" href="assets/js/jquery.range.css">
    </head>

    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="list">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($q)){ ?>
                        <h5>
                        <?php echo $totalrows; ?> creators found for keyword: <b><?php echo $q; ?></b>
                        </h5>
                        <?php }elseif(isset($c1)){ ?>
                        <h5>
                        Comparing: <?php echo $c1; ?> and <?php echo $c2; ?>
                        </h5>
                        <?php }else{ ?>
                        <h5><?php echo number_format($rowCount); ?> creators found </h5>
                        <?php } ?>
                    </div>
                </div>
                   
                <div class="row">
					 <div class="col-lg-9">
                                <div class="form-group">
                                    <form action="" method="get" id="search-form">
										<input id="search" name="q" type="search" class="form-control" placeholder="Search Channels..." value="<?php if(isset($q)){ echo $q; } ?>">
									</form>
                                </div>
                                <div class="form-group">
                                    <div class="tag">
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <button class="btn btn-block btn-primary" id="showfilters">Show Filters</button>
                                </div>
                            </div>
                            
                        </div>
                         
                           <div class="row" id="filters" style="display:none">
                               <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Sort by</label>
                                    <form action="" method="get">
                                       <?php if(isset($q)){ ?>
                                           <input type="hidden" name="q" value="<?php echo $q; ?>">
                                       <?php } ?>
                                        <select onchange="this.form.submit()" name="sortBy" class="form-control" id="">
                                           <option <?php if($sort=='subs'){ echo 'selected'; } ?>  value="subs">Subscribers</option>
                                           <option <?php if($sort=='views'){ echo 'selected'; } ?>  value="views">Views</option>
                                       </select>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Order By</label>
                                    <form action="" method="get">
                                       <?php if(isset($q)){ ?>
                                           <input type="hidden" name="q" value="<?php echo $q; ?>">
                                       <?php } ?>
                                        <select onchange="this.form.submit()" name="orderBy" class="form-control" id="">
                                           <option <?php if($ord=='asc'){ echo 'selected'; } ?> value="asc">Ascending</option>
                                           <option <?php if($ord=='desc'){ echo 'selected'; } ?>  value="desc">Descending</option>
                                       </select>
                                    </form>
                                </div>
                            </div>
                            
                           </div>
                           <div class="col-lg-12" id="searchloader" style="display:none">
                                <center><i class="fa fa-spinner fa-2x fa-spin"></i></center>
                            </div>
                            <div class="row"  id="youtubers">
                               
                                <?php include 'data.php'; ?>
                            </div>
                            <?php if(!isset($q) && !isset($c1)){ ?>
                            <div class="row">
                                 <div class="col-lg-12 text-center">
                                   <button id="loadmore" class="btn btn-danger">Load More</button><br><br>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                </div>
                <!-- The Modal -->
                <div class="modal " id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Add Channel</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                        <form action="" id="addchannelform" method="post">
                      <!-- Modal body -->
                      <div class="modal-body">
                        
                            <div class="form-group">
                                <input name="id"  type="text" class="form-control" placeholder="Enter Channel ID">
                            </div>
                            <div id="msg"></div>
                            <div class="form-group">
                                <button id="addchannelbtn" class="btn btn-danger btn-block" type="submit">Submit</button>
                            </div>
                      </div>

                      
                    </form>
                    </div>
                  </div>
                </div>
                <div class="modal" id="infomodal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header" style="background:#e13b2b;display:block">
                        <p style="color:white;margin-bottom:0"><i class="fa fa-eye"></i> <span id="cviews"></span> <span class="float-right"> <i class="fa fa-users"></i> <span id="csubs"></span></span></p>
                        
                      </div>

                      <div class="modal-body">
                        <center>
                           <div class="form-group">
                                <h4 id="ctitle"></h4>
                            </div>
                            <div class="form-group">
                                <img id="cimg" width="150" class="img-fluid rounded-circle"/>
                            </div>
                            <div class="form-group">
                                <h4>Latest Videos</h4>
                            </div>
                            <p id="videoloader"><i class="fa fa-spinner fa-spin"></i></p>
                            <div id="cvideos">
                               <div class="youtubes" data-embed="qs3t7zgKmAk"> 
                
                                    <div class="play-button"></div> 

                                </div>
                            </div>
                            
                        </center>
                      </div>

                      

                    </div>
                  </div>
                </div>
        </body>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(document).ready(function() {
            
        });
    </script>
    <script>
        
            $(document).on('click', '.youtubes', function(){
                var iframe = document.createElement( "iframe" );
                iframe.setAttribute( "frameborder", "0" );
                iframe.setAttribute( "allowfullscreen", "" );
                iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );
                this.innerHTML = "";
                this.appendChild( iframe );
            });

			function init() {
                var imgDefer = document.getElementsByTagName('img');
                for (var i = 0; i < imgDefer.length; i++) {
                    if (imgDefer[i].getAttribute('data-src')) {
                        imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
                    }
                }

                $('.details').tooltipster({
                    delay: 10,
                    contentAsHTML: true,
                    maxWidth: 500,
                    interactive: true,
                    multiple: false,
                    //delay: [0, 200],
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
            }
        
            window.onload = init;
            var search = false;
            $(document).ready(function () {
                $("#search").autocomplete({
                    source: "autocomplete.php",
                    minLength: 2,
                    select: function(event, ui) {
                        
                        if(search==false){
                            $('#youtubers').empty();
                            $("#homelink").text("Clear Search");
                            search = true;
                        }
                        $('#youtubers').hide();
                        $('#searchloader').show();
                        $('#loadmore').hide();
                        $(".tag").append(' <a href="#!">'+$("#search").val()+'</a>');
                        $.ajax({
                           url: "getdata",
                           data : {search: ui.item.channelid ,offset:0, order:'<?php echo $ord; ?>', sort: '<?php echo $sort; ?>'},
                           type: "POST",
                           success : function(data){
                             if(data){
                                $("#search").val('');
                                $('#searchloader').hide();
                                $('#youtubers').prepend(data);
                                $('#youtubers').show();
                                init();
                             }else{
                                $('#youtubers').html('No records found');
                             }
                           },
                        });
                    }
                });
            });
        
            $(document).ready(function () {
                $(".comparetext").autocomplete({
                    source: "autocomplete.php",
                    minLength: 2,
                    select: function(event, ui) {
                       
                    }
                });
            });
        
        
            $(document).on('click','.showinfoimg',function(e){
                e.preventDefault();
                $(this).parent().find('.showinfo').click();
            });
        
        
            $(document).on('click','.showinfo',function(e){
                e.preventDefault();
                var title = $(this).attr('data-title');
                var channelid = $(this).attr('data-channelid');
                var subs = $("#"+channelid+'-subs').text();
                var img = $("#"+channelid+'-img').attr('src');
                var views = $("#"+channelid+'-views').text();
                $("#ctitle").html(title);
                $("#csubs").html(subs);
                $("#cviews").html(views);
                $("#cimg").attr('src', img);
                $("#videoloader").show();
                $("#cvideos").empty();
                $('#infomodal').modal('show');
                $.ajax({
                   url: "ajaxgetvideos",
                   type: "POST",
                   data: {id:channelid},
                   success : function(data){
                     if(data){

                       $("#videoloader").hide();
                       $("#cvideos").html(data);

                     }else{

                     }
                   },
                });
            });
        

        var offset = 0;
        $('#loadmore').click(function(e) {
            e.preventDefault();
            var elem = $(this);
            elem.prop('disabled', true);
            elem.html('<i class="fa fa-spinner fa-spin"></i> Loading');
            offset+=40;
            $.ajax({
               url: "getdata",
               data : {normal: 1,offset:offset, order:'<?php echo $ord; ?>', sort: '<?php echo $sort; ?>'},
               type: "POST",
               success : function(data){
                 if(data){
                    elem.prop('disabled', false);
                    elem.html('Load More');
                    $('#youtubers').append(data);
                    init();
                 }else{
                    elem.html('No more records');
                 }
               },
            });
        });

        $(function () {
              var btn = $("#addchannelbtn");
              $('#addchannelform').on('submit', function (e) {
                e.preventDefault();
                $("#msg").html('');
                btn.prop('disabled', true);
                btn.html('<i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    type: 'post',
                    url: 'ajaxaddchannel.php',
                    data: $('#addchannelform').serialize(),
                    success: function (data) {
                      btn.prop('disabled', false);
                      btn.html('Submit');
                      $("#msg").html(data);
                    }
                });
            });
          });
        
          var show = false;
          $("#showfilters").click(function(e){
              e.preventDefault();
              if(show==false){
                  $("#filters").slideDown();
                  $(this).html('Hide Filters')
                  show = true;
              }else{
                  $("#filters").slideUp();
                  $(this).html('Show Filters')
                  show = false;
              }
          });
        
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </html>