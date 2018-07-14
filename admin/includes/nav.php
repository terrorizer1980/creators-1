 <div class="sidebar" data-color="orange" data-image="assets/img/full-screen-image-3.jpg">
        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="logo">
            
            <center>
			<a href="http://www.creative-tim.com" class="simple-text logo-normal">
				Youtube Creators
			</a>
           </center>
        </div>

    	<div class="sidebar-wrapper">
            

			<ul class="nav">
				<li class="<?php if($page=="index"){ echo "active"; } ?>">
					<a href="index">
						<i class="pe-7s-graph"></i>
						<p>Dashboard</p>
					</a>
				</li>
				
				
				
				
				
				<li>
					<a data-toggle="collapse" href="#channels">
                        <i class="pe-7s-play"></i>
                        <p>Channels
                           <b class="caret"></b>
                        </p>
                    </a>
					<div class="collapse <?php if($tab=="channels"){ echo "in"; } ?>" id="channels">
						<ul class="nav">
						  <li class="<?php if($page=="addnewchannel"){ echo "active"; } ?>">
								<a href="addnewchannel">
									<span class="sidebar-mini"><i class="fa fa-plus"></i></span>
									<span class="sidebar-normal">Add new channel</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				
				
				<li>
					<a data-toggle="collapse" href="#settings">
                        <i class="pe-7s-tools"></i>
                        <p>Settings
                           <b class="caret"></b>
                        </p>
                    </a>
					<div class="collapse <?php if($tab=="settings"){ echo "in"; } ?>" id="settings">
						<ul class="nav">

							
							
					
							
							<li class="<?php if($page=="changepass"){ echo "active"; } ?>">
								<a href="profile">
									<span class="sidebar-mini"><i class="fa fa-key"></i></span>
									<span class="sidebar-normal">Profile</span>
								</a>
							</li>
							
							
						</ul>
					</div>
				</li>
			</ul>
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-minimize">
					<button id="minimizeSidebar" class="btn btn-warning btn-fill btn-round btn-icon">
						<i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
						<i class="fa fa-navicon visible-on-sidebar-mini"></i>
					</button>
				</div>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Welcome, <?php echo $admin; ?></a>
				</div>
				<div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						
						
						<li class="dropdown dropdown-with-icons">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-list"></i>
								<p class="hidden-md hidden-lg">
									More
									<b class="caret"></b>
								</p>
							</a>
							<ul class="dropdown-menu dropdown-with-icons">
								<li>
									<a href="logout" class="text-danger">
										<i class="pe-7s-close-circle"></i>
										Log out
									</a>
								</li>
							</ul>
						</li>

					</ul>
				</div>
			</div>
		</nav>