<?php
session_start();
include 'db.php';
include 'includes/init.php';
?>
    <!doctype html>
    <html lang="en">

    <head>
        <title>Channels</title>
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
                                <button data-title="Latest Videos" class="showvideos btn btn-danger"><i class="fa fa-video"></i></button>
                                <button data-twitter="" data-title="Latest Tweets" class="showtweets btn btn-primary"><i class="fab fa-twitter"></i></button>
                                <a href="" target="_blank" style="color:white" class="instagram btn instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="form-group">
                                <h4 id="detailtitle">Latest Videos</h4>
                            </div>
                            <p id="videoloader"><i class="fa fa-spinner fa-spin"></i></p>
                            <div id="cvideos">
                               <div class="youtubes" data-embed="qs3t7zgKmAk"> 
                
                                    <div class="play-button"></div> 

                                </div>
                            </div>
                            <div id="tweets">
                                
                            </div>
                        </center>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        </body>
    <?php include 'includes/scripts.php'; ?>
    <script>
        var offset = 0;
        $('#loadmore').click(function(e) {
            e.preventDefault();
            var elem = $(this);
            elem.prop('disabled', true);
            elem.html('<i class="fa fa-spinner fa-spin"></i> Loading');
            offset+=40;
            $.ajax({
               url: "ajax/getdata",
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
    </script>
    <script src="assets/js/app.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </html>