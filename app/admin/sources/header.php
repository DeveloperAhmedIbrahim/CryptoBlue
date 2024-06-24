<?php
if(!defined('CryptExchanger_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $settings['name']; ?> Admin Panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./assets/vendors/iconfonts/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="./assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./assets/css/vertical-layout-light/style.css">
  
  <link rel="stylesheet" href="./assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="https://virsymcoin.com/icon.png" />
</head>
<body class="sidebar-dark">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-dark">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="./"><img src="https://virsymcoin.com/logo.png" class="mr-2" style="width:100px;height:48px;margin:0 auto;" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="./"><img src="https://virsymcoin.com/icon.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-layout-grid2"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile ">
            <a  class="nav-link" href="./?a=logout" >
              <i class="fa fa-power-off"></i> Logout
            </a>
           
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-layout-grid2"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item <?php echo (!isset($_GET['a']))  ? "active" : ""; ?>">
            <a class="nav-link" href="./"><i class=" ti-dashboard  menu-icon"></i> <span class="menu-title">Dashboard</span></a>
          </li>
          <hr>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "exchange_gateways") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=exchange_gateways"><i class=" ti-credit-card  menu-icon"></i> <span class="menu-title">Exchange Gateways</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "exchange_directions") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=exchange_directions"><i class="  ti-direction-alt menu-icon"></i> <span class="menu-title">Exchange Directions</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "exchange_rates") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=exchange_rates"><i class=" ti-bar-chart-alt  menu-icon"></i> <span class="menu-title">Exchange Rates</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "exchange_rules") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=exchange_rules"><i class=" fa fa-flag  menu-icon"></i> <span class="menu-title">Exchange Rules</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "exchange_orders") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=exchange_orders"><i class="fa fa-refresh menu-icon"></i> <span class="menu-title">All Exchange Orders</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="<?php if(isset($_GET["a"]) && $_GET["a"] == "wallet" ){ echo "true"; } else { echo "false"; } ?>" aria-controls="ui-basic">
              <i class="fa fa-money menu-icon"></i>
              <span class="menu-title">Wallet</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?php if(isset($_GET["a"]) && $_GET["a"] == "wallet" ){ echo "show"; } ?>" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link <?php if(isset($_GET["b"]) && $_GET["b"] == "wallet_gateways"){ echo "active"; } ?>" href="./?a=wallet&b=wallet_gateways">All Gateways</a></li>
                <li class="nav-item"> <a class="nav-link <?php if(isset($_GET["b"]) && $_GET["b"] == "wallet_deposit"){ echo "active"; } ?>" href="./?a=wallet&b=wallet_deposit">Desposit Requests</a></li>
                <li class="nav-item"> <a class="nav-link <?php if(isset($_GET["b"]) && $_GET["b"] == "wallet_withdraw"){ echo "active"; } ?>" href="./?a=wallet&b=wallet_withdraw">Withdraw Requests</a></li>
                <li class="nav-item"> <a class="nav-link <?php if(isset($_GET["b"]) && $_GET["b"] == "wallet_transfer"){ echo "active"; } ?>" href="./?a=wallet&b=wallet_transfer">Transfer Logs</a></li>
                <li class="nav-item"> <a class="nav-link <?php if(isset($_GET["b"]) && $_GET["b"] == "wallet_manage"){ echo "active"; } ?>" href="./?a=wallet&b=wallet_manage">Manage Wallet Balances</a></li>
              </ul>
            </div>
          </li>
          <hr>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "users") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=users"><i class=" ti-user  menu-icon"></i> <span class="menu-title">All Users</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "withdrawals") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=withdrawals"><i class="fa fa-upload  menu-icon"></i> <span class="menu-title">Withdrawals</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "reviews") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=reviews"><i class=" ti-comment-alt  menu-icon"></i> <span class="menu-title">Reviews</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "tickets") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=tickets"><i class="fa fa-support  menu-icon"></i> <span class="menu-title">Support Tickets</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "news") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=news"><i class="fa fa-newspaper-o  menu-icon"></i> <span class="menu-title">Blog</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "pages") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=pages"><i class="fa fa-file-o  menu-icon"></i> <span class="menu-title">Pages</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "faq") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=faq"><i class="fa fa-question-circle  menu-icon"></i> <span class="menu-title">FAQ</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['a'] == "languages") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=languages"><i class="fa fa-globe menu-icon"></i> <span class="menu-title">Languages</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['b'] == "recaptcha") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=settings&b=recaptcha"><i class="fa fa-google menu-icon"></i> <span class="menu-title">reCaptcha Settings</span></a>
          </li>
          <li class="nav-item <?php echo (isset($_GET['a'])) && ($_GET['b'] == "smtp") ? "active" : ""; ?>">
            <a class="nav-link" href="./?a=settings&b=smtp"><i class="ti-email menu-icon"></i> <span class="menu-title">SMTP Settings</span></a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="https://webextee.com/"><i class="fa fa-question menu-icon"></i> <span class="menu-title">Help</span></a>
          </li>
          
          
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">