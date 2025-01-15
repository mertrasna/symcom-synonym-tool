<?php
$_SESSION['current_page'] = $actual_link;
// $baseUrl = 'http://www.newrepertory.com/comparenew/';
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Symcom | <?php echo $admin; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jasny-bootstrap/jasny-bootstrap.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/bootstrap/dist/css/bootstrap.min.css">
  <!-- dropify -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/dropify/css/dropify.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/font-awesome/css/fontawesome-all.min.css">
  <!-- <link rel="stylesheet" href="<?php echo $baseUrl;?>plugins/font-awesome/css/fontawesome-all.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/skins/_all-skins.min.css">
  <!-- Jquery UI-->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/jquery-ui/themes/base/jquery-ui.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- sweet alert 2 -->
  <link rel="stylesheet" type="text/css" href="<?php echo $absoluteUrl;?>plugins/sweetalert2/sweetalert2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>plugins/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/AdminLTE.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom.css">
  <!-- customized font -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php if(preg_match("/quellen/", $actual_link) || preg_match("/zeitschriften/", $actual_link)) {
  ?>
  <link rel="stylesheet" href="<?php echo $absoluteUrl;?>assets/css/custom-datepicker.css">
  <?php } ?>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

  <header class="main-header cd-main-header animate-search">
    <!-- Logo -->
    <a href="<?php echo $absoluteUrl;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>C</span>
      <!-- logo for regular state and mobile devices -->
      <div class="logo-lg"><img class="img-responsive" src="<?php echo $absoluteUrl;?>assets/img/logo-big.png" alt="logo"></div>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top cd-main-nav-wrapper">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group search">
              <span class="fa fa-search desktop-show"></span>
              <input type="text" class="form-control search-box" id="navbar-search-input" placeholder="Suche...">
              <span class="closeBtn mobile-show"><button class="btn btn-success btn-sm">x</button></span>
            </div>
          </form>
        <ul class="nav navbar-nav adv-search-link">
            <li class="normal-search mobile-show"><a href="#">Suche</a></li>
            <li><a href="#search" class="cd-search-trigger">Erweiterte Suche</a></li>
        </ul>
      </div> -->
    </nav>
    <div id="search" class="cd-main-search">
      <form>
        <div class="search-input">
          <input type="search" placeholder="Suche...">
        </div>

        <div class="cd-search-suggestions">
          <div class="box-body">
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="form-group">
                        <label for="arznei" class="sr-only">Arznei</label>
                        <select id="arznei" class="form-control" name="arznei">
                          <option value="">Arznei Wahlen</option>
                          <option value="AFG">Afghanistan</option>
                          <option value="ALB">Albania</option>
                          <option value="DZA">Algeria</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="kapitel" class="sr-only">Kapitel</label>
                        <select id="kapitel" class="form-control" name="kapitel">
                          <option value="">Kapitel Wahlen</option>
                          <option value="AFG">Afghanistan</option>
                          <option value="ALB">Albania</option>
                          <option value="DZA">Algeria</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="potenz" class="sr-only">potenz</label>
                        <select id="potenz" class="form-control" name="potenz">
                          <option value="">Potenz Wahlen</option>
                          <option value="AFG">Afghanistan</option>
                          <option value="ALB">Albania</option>
                          <option value="DZA">Algeria</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-xs-6">
                      <div class="form-group">
                        <label for="quella" class="sr-only">quella</label>
                        <select id="quella" class="form-control" name="quella">
                          <option value="">Quella Wahlen</option>
                          <option value="AFG">Afghanistan</option>
                          <option value="ALB">Albania</option>
                          <option value="DZA">Algeria</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="version" class="sr-only">version</label>
                        <select id="version" class="form-control" name="version">
                          <option value="">Version Wahlen</option>
                          <option value="AFG">Afghanistan</option>
                          <option value="ALB">Albania</option>
                          <option value="DZA">Algeria</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="Unklarheiten" class="sr-only">Unklarheiten</label>
                        <select id="Unklarheiten" class="form-control" name="Unklarheiten">
                          <option value="">Unklarheiten</option>
                          <option value="ja">Ja</option>
                          <option value="nein">Nein</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button class="btn btn-success" type="submit" id="advSearch">Suche</button>
                      <button class="btn btn-default" type="button" id="advSearchCancelBtn">Abbrechen</button>
                    </div>
                  </div>  
              
              </div>
        </div> <!-- .cd-search-suggestions -->

        <a class="close"></a>
      </form>
    </div> <!-- .cd-main-search -->
  </header>
  