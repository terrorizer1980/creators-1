<?php
include "auth.php";
include "../db.php";
if(isset($_POST['submit']))
	{
        $id = pvalidate($_POST['id']);
        
        
        if(empty($id) ){
        $msg = 'Please fill all the required fields!!';
    
        }elseif(!empty($id)){
        $queryid = mysqli_query($conn,"select channelid from channels where channelid = '$id'");
        if(mysqli_num_rows($queryid) > 0){
            $msg = "<div class='alert alert-danger'>
                    <strong>Error!</strong> Channel already exists!!
                    </div>";
        } else{
            $posturl = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$id.'&key='.$youtube_key;
            $data = file_get_contents( $posturl, false);
            $response = json_decode($data);
            if(!isset($response->items[0]->snippet->title)){
                $msg = "<div class='alert alert-danger'>
                    <strong>Error!</strong> Wrong Channel Id!!
                    </div>";
            }else{
                $name = $response->items[0]->snippet->title;
                $subscribers = $response->items[0]->statistics->subscriberCount;
                $query = "INSERT INTO channels (id, channelid, name, subscribers) VALUES (NULL, '$id', '$name', '$subscribers')";
                if(mysqli_query($conn, $query)){
                $success = "<div class='alert alert-success'>
                            <strong>Success!</strong> Channel Added Successfuly!!
                            </div>";
                }
            }
            
                     
        
            
    }
        
}
}

function pvalidate($value){
include "../db.php";
$value = mysqli_real_escape_string($conn, htmlentities(strip_tags($value)));
return $value;
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>
    Add New Channel
    </title>
	<?php include "includes/head.php"; ?>
	
</head>
<body>

<div class="wrapper">
    <?php $page="addnewchannel"; $tab="channels"; include "includes/nav.php"; ?>
    
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <?php if(isset($msg)){ echo $msg; } ?>
                        <?php if(isset($success)){ echo $success; ?>
                           
                        <div class="card">
                            <div class="header">
                                New Channel Info
                            </div>
                            <div class="content">
                                <table class="table">
                                    <tr>
                                    <th>Title</th>
                                    <td><?php echo ucwords($name); ?></td>
                                    </tr>
                                    <tr>
                                    <th>Subscribers</th>
                                    <td><?php echo $subscribers; ?></td>
                                    </tr>
                                </table>
                            </div>    
                        </div>
                        <?php } ?>
                        <div class="card">
                            <div class="header">
                               Add New Channel
                            </div>
                            <hr>
                            <div class="content">
                               
                                <form enctype="multipart/form-data" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                                <label>Enter Youtube Channel Id</label>
                                                <input required name="id" type="text" class="form-control" placeholder="Enter Channel Id" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <button name="submit" type="submit" class="btn btn-primary btn-fill pull-right">Submit</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div> <!-- end card -->

                    </div> <!--  end col-md-6  -->

                    

                </div> <!-- end row -->

            </div>
        </div>

           <?php include "includes/footer.php"; ?>


    </div>


</body>
    <!--   Core JS Files  -->
    <?php include "includes/scripts.php"; ?>


</html>
