<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php getTitle() ?></title>
  <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
  <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
  <link rel="stylesheet" href="<?php echo $css; ?>front.css">
</head>

<body>

<nav class="navbar navbar-inverse navngh">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display  -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed drop" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img class="logo" src="layout/images/logo/logo3.png"></a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        
        <?php 
          if (isset($_SESSION['user'])) { ?>

          <div class="pull-right">
            <div class="btn-group my-info">
              <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php echo $sessionUser ?>
                <sapn class="caret"></sapn>
              </span>
              <ul class="dropdown-menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="newad.php">New Product</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div> 
          </div>

          <?php 

          } else {
      ?>
      <br>
      <a href="login.php" style="color: #ccc;">
          <span class="pull-right"><b>Login | Signup</b></span>
      </a>
      <?php } ?>
      </ul>
    </div>  
  </div>
  
</nav>

  