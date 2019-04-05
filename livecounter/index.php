<!DOCTYPE html>
<html lang="en">

<head>
    <title>Youtube Live Subscribers Counter</title>
     <?php include "includes/head.php"; include "key.php"; ?>
    <!-- Template styles -->
    <style rel="stylesheet">
        /* TEMPLATE STYLES */
      
        main {
            padding-top: 3rem;
            padding-bottom: 2rem;
        }

        .extra-margins {
            margin-top: 1rem;
            margin-bottom: 2.5rem;
        }

        .jumbotron {
            text-align: center;
        }

        .navbar {
            background-color: #3b295a;
        }

        footer.page-footer {
            background-color: #3b295a;
            margin-top: 2rem;
        }
        .navbar .btn-group .dropdown-menu a:hover {
            color: #000 !important;
        }
        .navbar .btn-group .dropdown-menu a:active {
            color: #fff !important;
        }
 .btn-default {
            background: white;
            
    }
        
.btn-default.btn-on.active{background-color: #5BB75B;color: black;}
.btn-default.btn-off.active{background-color: #DA4F49;color: black;}

.btn-default.btn-on-1.active{background-color: #006FFC;color: black;}
.btn-default.btn-off-1.active{background-color: #DA4F49;color: black;}

.btn-default.btn-on-2.active{background-color: #00D590;color: black;}
.btn-default.btn-off-2.active{background-color: #A7A7A7;color: black;}

.btn-default.btn-on-3.active{color: #5BB75B;font-weight:bolder;}
.btn-default.btn-off-3.active{color: #DA4F49;font-weight:bolder;}

.btn-default.btn-on-4.active{background-color: #006FFC;color: #5BB75B;}
.btn-default.btn-off-4.active{background-color: #DA4F49;color: #DA4F49;}
.table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none;
}
        
        .btn-xs .btn-sm >td{
              
        }  
        .btn{
            text-transform: none;
          
        }
        
              .card-no-border .card {
            border-color: #d7dfe3;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 20px rgba(0,0,0,.05);
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }
        
        .card-img-top {
            border-top-right-radius: calc(.25rem - 1px);
            border-top-left-radius: calc(.25rem - 1px);
        }
        .card-block {
            -webkit-box-flex: 1;
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
        
        .little-profile .pro-img {
            margin-top: -80px;
            margin-bottom: 20px;
        }
        
        .little-profile .pro-img img {
    width: 100px;
    height: 100px;
    -webkit-box-shadow: 0 0 15px rgba(0,0,0,.2);
    box-shadow: 0 0 15px rgba(0,0,0,.2);
    border-radius: 100%;
}
    
        
        @media screen and (min-width: 601px) {
            .display-1{
                font-size: 5.0rem;
            }
            .padding-0{
                padding-right:0;
                padding-left:0;
            }
        }

        /* If the screen size is 600px wide or less, set the font-size of <div> to 30px */
        @media screen and (max-width: 600px) {
              .display-1{
                font-size: 3.0rem;
            }
        }
        
        
        
        .winner{
            background:#2cdcab;
            color:white;
        }
        
        .loser{
            background: #dc2c5d;
            color: white;
        }
        
        
        
        
    </style>
<link rel="stylesheet" href="odometer-theme-minimal.css">
</head>

<body>
<?php $page="compare"; include "includes/nav.php"; ?>

  
        <br>
    

    <main>

        <!--Main layout-->
        <div class="container">
            <!--First row-->
          
   

            <!--Second row-->
            <div class="row">
                
                <!--First columnn-->
                <div style="" class="col-md-5 col-sm-12 col-xs-12 padding-0 form-group">                                     
                <div class="card m-b-0 m-t-20 pewdiepie winner">
                <div class="card-block winner text-center p-t-0" id="c1loading">
                    <div class="card-body">
                        <div class="position-relative">
                            <div class="">
                                <h1 class="">Loading...</h1><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="" style="display:none" id="c1card">
                <img class="card-img-top img-fluid" id="yt_cover_vs1" style="max-height:200px;">
                            <div class="card-block little-profile p-b-0 text-center">
                                <div class="pro-img">
                                    <img src="" alt="user" id="yt_profile_vs1" class="rounded-circle img-fluid">
                                </div>
                                <h3 class="display-6 m-b-15 m-t-10 text-center vs1_name" id="yt_name_vs1"></h3>
                            </div>
                            <div class="card-block text-center p-t-0">
                                <div class="card-body">
                                    <div class="position-relative">
                                        <div class="">
                                            <h1 class="numbers display-1"></h1><br>
                                            <span>Subscribers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                 <div class="col-md-2 col-sm-12 col-xs-12 padding-0 form-group" style="margin:auto">
                    <center><h2 style="">Vs.</h2></center>
                 </div>
                 <div class="col-md-5 col-sm-12 col-xs-12  padding-0 form-group">                                     
                 <div class="card m-b-0 m-t-20 tseries loser">
                   <div class="card-block text-center p-t-0" id="c2loading">
                    <div class="card-body">
                        <div class="position-relative">
                            <div class="">
                                <h1 class="">Loading...</h1><br>
                            </div>
                        </div>
                    </div>
                </div>
                   <div class="" style="display:none" id="c2card">
                    <img id="yt_cover_vs2" class="card-img-top img-fluid" src="" style="max-height:200px;">
                            <div class="card-block little-profile p-b-0 text-center">
                                <div class="pro-img">
                                    <img src="" alt="user" id="yt_profile_vs2" class="rounded-circle img-fluid">
                                </div>
                                <h3 class="display-6 m-b-15 m-t-10 text-center vs1_name" id="yt_name_vs2"></h3>
                            </div>
                            <div class="card-block text-center p-t-0">
                                <div class="card-body">
                                    <div class="position-relative">
                                        <div class="">
                                            <h1 class="numbers2 display-1"></h1><br>
                                            <span>Subscribers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                  </div>
                  
                
                     
                <!--Third columnn-->
            </div><br><br>
            
            
            
            <br><br>
            <div class="row">
                <div class="col-md-12 padding-0">                                     
                <div class="card m-b-0 m-t-20" id="result">
                    <div class="card-block text-center p-t-0">
                        <div class="card-body">
                            <div class="position-relative">
                                <div class="">
                                    <h1 class="numbers3 display-3">500</h1><br>
                                    <span>Difference</span><br>
                                    <b><span id="msg"></span></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      
                </div>
            </div>
            <!--
            <div class="row" style="margin-top:50px">
                <div class="col-md-12">
                   <div class="md-form">
                      <input type="text" id="channelid" value="UC-lHJZR3Gqxm24_Vd_AJ5Yw" class="form-control">
                      <label for="form1">Channel ID</label>
                    </div>
                    
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button id="change" type="button" class="btn btn-primary">Change</button>
                </div>
            </div>
            -->
        </div>
        <!--/.Main layout-->

    </main>

    <!--Footer-->
    <?php include "includes/footer.php"; ?>

    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>

    <!-- Bootstrap dropdown -->
    <script type="text/javascript" src="js/popper.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
     <script src="odometer.min.js"></script>
    <script>
    
    var id = $("#channelid").val();
    var handle1;
    var handle2;
    //getSubs('UC-lHJZR3Gqxm24_Vd_AJ5Yw', handle1);
    //getSubs2('UCq-Fj5jknLsUf-MWSy4_brA', handle2);
        
    
    $("#change").on('click', function(){
       var id = $("#channelid").val();
       getSubs(id);
    });
    
    var el = document.querySelector('.numbers');
    od = new Odometer({
      el: el,
      value: 0,
      duration:500,
      // Any option (other than auto and selector) can be passed in here
      format: ',ddd',
      theme: 'minimal'
    });
        
    var el = document.querySelector('.numbers2');
    od2 = new Odometer({
      el: el,
      value: 0,
      duration:500,
      // Any option (other than auto and selector) can be passed in here
      format: ',ddd',
      theme: 'minimal'
    });
        
    var el = document.querySelector('.numbers3');
    od3 = new Odometer({
      el: el,
      value: 0,
      duration:500,
      // Any option (other than auto and selector) can be passed in here
      format: ',ddd',
      theme: 'minimal'
    });
        
    
    function getSubs(channelid, channel){
        $.ajax({
            url: "https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics,brandingSettings&id="+channelid+"&key=<?php echo $key; ?>",
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res);
                //alert(res.items[0].statistics.subscriberCount);
                if(channel==1){
                    $(".numbers").attr('data-sub', res.items[0].statistics.subscriberCount);
                }else{
                    $(".numbers2").attr('data-sub', res.items[0].statistics.subscriberCount);
                }
                $("#yt_name_vs"+channel).html(res.items[0].snippet.title);
                $("#yt_profile_vs"+channel).attr('src', res.items[0].snippet.thumbnails.high.url);
                $("#yt_cover_vs"+channel).attr('src', res.items[0].brandingSettings.image.bannerImageUrl);
                if(channel==1){
                    od.update(res.items[0].statistics.subscriberCount);
                }else{
                    od2.update(res.items[0].statistics.subscriberCount);
                }
                
                $("#c"+channel+"loading").hide();
                $("#c"+channel+"card").show();
                
            }
        });   
    }
        
    var msg = '';  var winner = ''; 
    handle = window.setInterval(function(){ 
         getSubs('UC-lHJZR3Gqxm24_Vd_AJ5Yw', 1);
         getSubs('UCq-Fj5jknLsUf-MWSy4_brA', 2);
        var val1 = parseInt($(".numbers").attr('data-sub'));
        var val2 = parseInt($(".numbers2").attr('data-sub'));
        var diff = val1-val2;
        
        if(val1>val2){
            msg = 'PewDiePie is Winning';
            winner = 'pewdiepie';
        }else{
            msg = 'T-Series is Winning';
            winner = 'tseries';
        }
        
        
        
        setTimeout(function(){ 
            $("#msg").html(msg); 
            if(winner=='pewdiepie'){
                $("#result").addClass('winner');
            }else{
                $("#result").addClass('loser');
            }
        }, 5000);
        od3.update(Math.abs(diff));
    }, 2000);
    
    
 
    $("#channel1").on('change', function(){
        var channel1id = $(this).val();
        var channel2id = $("#channel2").val();
        window.clearInterval(handle);
        handle = null;
        handle = window.setInterval(function(){ 
            getSubs(channel1id, 1);
            getSubs(channel2id, 2);
            var val1 = parseInt($(".numbers").attr('data-sub'));
            var val2 = parseInt($(".numbers2").attr('data-sub'));
            var diff = val1-val2;
            od3.update(Math.abs(diff));
        }, 2000);
    });
        
    $("#channel2").on('change', function(){
        var channel1id = $("#channel1").val();
        var channel2id = $(this).val();
        window.clearInterval(handle);
        handle = null;
        handle = window.setInterval(function(){ 
            getSubs(channel1id, 1);
            getSubs(channel2id, 2);
            var val1 = parseInt($(".numbers").attr('data-sub'));
            var val2 = parseInt($(".numbers2").attr('data-sub'));
            var diff = val1-val2;
            od3.update(Math.abs(diff));
        }, 2000);
    });
    
    </script>
</body>
</html>