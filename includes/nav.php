<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid justify-content-center">
      <a class="navbar-brand" href="index">Youtube</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="index">Home</a>
          </li>
          
          
          
          <li class="nav-item btn-submit-recipe">
            <form action="" method="get" id="search-form">
                <input id="search" name="q" style="margin-top:17px" type="text" class="form-control" placeholder="Search Channels..." value="<?php if(isset($q)){ echo $q; } ?>">
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>