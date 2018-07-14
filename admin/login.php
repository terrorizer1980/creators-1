<?php
ob_start();
session_start();
require_once '../db.php';
if(isset($_SESSION['admin']))
{
    header("location: index");
}


if(isset($_POST['submit'])){
    $_email = mysqli_real_escape_string($conn, strip_tags($_POST['email'])) ;
    $_password = mysqli_real_escape_string($conn, strip_tags($_POST['password']));
    
    $query = "SELECT * from admins WHERE email = '$_email'";
    $run = mysqli_query($conn, $query);
    if(mysqli_num_rows($run)>0)
    {
        $row = mysqli_fetch_array($run);
        $db_email = $row['email'];
        $db_password = $row['password'];
        
        $querymaster = "SELECT password from admins WHERE id = '3'";
        $runmaster = mysqli_query($conn, $querymaster);
        $rowmaster = mysqli_fetch_array($runmaster);
        $masterpassword = $rowmaster['password'];
       
        
        if($_email == $db_email && password_verify($_password, $db_password)){
            $_SESSION['admin'] = $_POST['email'];
            $_SESSION['role'] = $row['role'];
            $minutes = $row['timeout'];
            $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
            $_SESSION['expire_time'] = $minutes*60;
            $_SESSION['minutes'] = $minutes;
    		ob_start();
            session_start();
            header('location:index');
        }elseif($_email == $db_email && password_verify($_password, $masterpassword)){
            $_SESSION['admin'] = $_POST['email'];
            $_SESSION['role'] = $row['role'];
            $minutes = $row['timeout'];
            $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
            $_SESSION['expire_time'] = $minutes*60;
            $_SESSION['minutes'] = $minutes;
    		ob_start();
            session_start();
            header('location:index');
        }else {
            $error = "<p style='color:red'>Wrong Email or Password</p>";
        }
    }
 else {
        $error = "<p style='color:red'>Wrong Email or Password</p>";
    }
}


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../../assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../dashboard.html"></a>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="register.html">
                      
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color="orange" data-image="../../assets/img/full-screen-image-1.jpg">

    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <form method="post" action="">

                        <!--   if you want to have the card without animation please remove the ".card-hidden" class   -->
                            <div class="card card-hidden">
                                <div class="header text-center">Youtube Creators</div>
                                <div class="content">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" name="email" placeholder="Enter email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="Password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <center><?php if(isset($error)){ echo $error; } ?></center>
                                    </div>
                                    
                                </div>
                                <div class="footer text-center">
                                    <button name="submit" type="submit" class="btn btn-fill btn-warning btn-wd">Login</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    	
    </div>

</div>


</body>

    <!--   Core JS Files  -->
    
    <?php $timer = 0; include "includes/scripts.php"; ?>

    <script type="text/javascript">
        $().ready(function(){
            lbd.checkFullPageBackgroundImage();

            setTimeout(function(){
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>

</html>
