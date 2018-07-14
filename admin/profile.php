<?php 
include "auth.php";
include "../db.php"; 
if(isset($_POST['update']))
{
    $emails = mysqli_real_escape_string($conn,strip_tags($_POST['email']));
    
    if(empty($emails)){
            $error = 'Please fill all the required fields!!';
    } else{
            $query_email = mysqli_query($conn,"select email from admins where email = '$emails' AND email!='$admin'");
            if (mysqli_num_rows($query_email) > 0){
            $msg = "<div class='alert alert-danger'>
                          <strong>Error!</strong> Email already Exists!!
                    </div>";
            } else{
            
            $query = "update admins set email='$emails' where email = '$admin' ";
                         
            if(mysqli_query($conn, $query)){
            $msg = "<div class='alert alert-success'>
                          <strong>Success!</strong> Profile Updated Successfuly!!
                        </div>";
            $_SESSION['admin'] = $emails;
            $admin = $_SESSION['admin'];
        }
    }
}
}
?>
<!doctype html>
<html lang="en">
<head>
	<title>Chage Profile</title>
	<?php $page="changepass"; $tab="settings"; include "includes/head.php"; ?>

</head>
<body>

<div class="wrapper">
<?php include "includes/nav.php"; ?>
        <div class="main-content">
            <div class="container-fluid">
               <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <form method="post">
                                   
                                        <div class="row">
                                        <div class="col-md-12">
                                           <?php
                                             if(isset($msg)){
                                                echo $msg;
                                             }
                                             ?>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input required name="email" type="email" class="form-control" placeholder="Home Address" value="<?php echo $admin; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <button name="update" type="submit" class="btn btn-primary btn-fill pull-right">Update Email</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Chage Password</h4><hr>
                            </div>
                            <div class="content">
                             <form onSubmit="return submitForm();" id="pass-change" method="post">
                                    <div id="msg"></div>
                                           
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input required name="newpass" type="password" class="form-control" placeholder="Enter New Password">
                                            </div>
                                       
                                   
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input required name="cpass" type="password" class="form-control" placeholder="Confirm Password">
                                            </div>
                                        
                                    <button id="submit-btn" type="submit" class="btn btn-primary btn-fill pull-right">Change Password</button>
                                    <div class="clearfix"></div>
                                </form>
                                </div>
                        </div>
                    </div>





                </div>

            </div>
        </div>

           <?php include "includes/footer.php"; ?>


    </div>


</body>

    <?php include "includes/scripts.php"; ?>	
    <script>
    function submitForm() {
        $("#msg").empty();
        $("#submit-btn").html('Please Wait');
        $("#submit-btn").attr('disabled',true);
        setTimeout(function(){
        $.ajax({type:'POST', url:'change_pass.php', data:$('#pass-change').serialize(), success: function(response) {
           $('#msg').html(response).show();
           $("#submit-btn").html('Submit');
           $("#submit-btn").attr('disabled',false);
           $('#pass-change')[0].reset();
        }});
        },1000);
        return false;
    }     
    </script>
</html>
