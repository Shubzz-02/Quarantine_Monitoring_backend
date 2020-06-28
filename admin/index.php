<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ob_start();
session_start();


require_once "config/data.php";
//

require_once 'config/BackgroundProcess.php';

if (!isset($_SESSION['email']) || empty($_SESSION['email'] || !isset($_SESSION['qqs']) || empty($_SESSION['qqs']))) {
    header("location: login.php");
    exit;
}

$process = new BackgroundProcess(" cd xlsx && php __getXls.block.php");
$process->run();

//if (isset($_GET['id']) && strcmp($_GET['id'], "download") == 0) {
//    getSlxs($process);
//}


$email = $_SESSION['email'];

//function getSlxs($process)
//{
//    if ($process->isRunning()) {
//
//    }
//
//    //header("Location: xlsx/__getXls.block.php");
////    $download = new GetXls();
////    $download->getXls();
//}

//echo $admin_fullname." ". $admin_email;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quarantine Monitoring | Home</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/css/jquery.toast.css">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="images/favicon.png"/>
</head>
<body>
<script src="js/preloader.js"></script>
<div class="body-wrapper">
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
        <div class="mdc-drawer__header">
            <a href="index.php" class="brand-logo">
                <img src="images/favicon.png" alt="logo">
            </a>
        </div>
        <div class="mdc-drawer__content">
            <div class="user-info">
                <p class="name"><?PHP echo $admin_fullname ?></p>
                <p class="email"><?PHP echo $admin_email ?></p>
            </div>
            <div class="mdc-list- group">
                <nav class="mdc-list mdc-drawer-menu">
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="index.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">home</i>
                            Dashboard
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="users.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">group</i>
                            Nodal Officers
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="blocks.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">view_carousel</i>
                            Blocks
                        </a>
                    </div>
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="download.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">cloud_download</i>
                            Download Data
                        </a>
                    </div>
                </nav>
            </div>
            <div class="profile-actions">
                <a href="javascript:;">Settings</a>
                <span class="divider"></span>
                <a href="config/logout.php">Logout</a>
            </div>
            <div class="mdc-card premium-card">
                <div class="d-flex align-items-center">
                    <div class="mdc-card icon-card box-shadow-0">
                        <i class="mdi mdi-shield-outline"></i>
                    </div>
                    <div>
                        <p class="mt-0 mb-1 ml-2 font-weight-bold tx-12">Shuzz</p>
                    </div>
                </div>
                <p class="tx-8 mt-3 mb-1">Follow.</p>
                <a href="#" target="_blank">
                    <span class="mdc-button mdc-button--raised mdc-button--white">LinkedIn</span>
                </a>
            </div>
        </div>
    </aside>

    <div class="main-wrapper mdc-drawer-app-content">
        <header class="mdc-top-app-bar">
            <div class="mdc-top-app-bar__row">
                <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                    <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">
                        menu
                    </button>
                    <span class="mdc-top-app-bar__title">Greetings <?PHP echo $admin_fullname ?></span>
                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field d-none d-md-flex">
                        <i class="material-icons mdc-text-field__icon">search</i>
                        <input class="mdc-text-field__input" id="text-field-hero-input">
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="text-field-hero-input" class="mdc-floating-label">Search..</label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
                    </div>
                </div>
                <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
                    <div class="menu-button-container menu-profile d-none d-md-block">
                        <button class="mdc-button mdc-menu-button">
                            <span class="d-flex align-items-center">
                              <span class="figure">
                                <img src="images/faces/face.png" alt="user" class="user">
                              </span>
                              <span class="user-name"><?PHP echo $admin_fullname ?></span>
                            </span>
                        </button>
                        <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                                <li class="mdc-list-item" role="menuitem">
                                    <div class="item-thumbnail item-thumbnail-icon-only">
                                        <i class="mdi mdi-account-edit-outline text-primary"></i>
                                    </div>
                                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="item-subject font-weight-normal">Edit profile</h6>
                                    </div>
                                </li>
                                <li class="mdc-list-item" role="menuitem">
                                    <div class="item-thumbnail item-thumbnail-icon-only">
                                        <i class="mdi mdi-settings-outline text-primary"></i>
                                    </div>
                                    <a href="config/logout.php">
                                        <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                            <h6 class="item-subject font-weight-normal">Logout</h6>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="divider d-none d-md-block"></div>
                    <div class="menu-button-container d-none d-md-block">
                        <button class="mdc-button mdc-menu-button">
                            <i class="mdi mdi-settings"></i>
                        </button>
                        <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                                <li class="mdc-list-item" role="menuitem">
                                    <div class="item-thumbnail item-thumbnail-icon-only">
                                        <i class="mdi mdi-alert-circle-outline text-primary"></i>
                                    </div>
                                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="item-subject font-weight-normal">Settings</h6>
                                    </div>
                                </li>
                                <li class="mdc-list-item" role="menuitem">
                                    <div class="item-thumbnail item-thumbnail-icon-only">
                                        <i class="mdi mdi-progress-download text-primary"></i>
                                    </div>
                                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="item-subject font-weight-normal">Update</h6>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrapper mdc-toolbar-fixed-adjust">
            <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--success">
                                <div class="card-inner">
                                    <h5 class="card-title">Total Blocks</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $total_blocks ?></h5>
                                    <!--                                    <p class="tx-12 text-muted">48% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">view_carousel</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--danger">
                                <div class="card-inner">
                                    <h5 class="card-title">Total Admins</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $total_admin ?></h5>
                                    <!--                                    <p class="tx-12 text-muted">55% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">face</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--primary">
                                <div class="card-inner">
                                    <h5 class="card-title">Total Villages</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $total_vill ?></h5>
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">location_city</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--info">
                                <div class="card-inner">
                                    <h5 class="card-title">Total Nodal Officers</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?php echo $total_users ?></h5>
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">people</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Blocks</h4>
                                    <div>
                                        <i class="material-icons refresh-icon">refresh</i>
                                        <i class="material-icons options-icon ml-2">more_vert</i>
                                    </div>
                                </div>
                                <div class="d-block d-sm-flex justify-content-between align-items-center">
                                    <h5 class="card-sub-title mb-2 mb-sm-0">Total Blocks and number of villages</h5>
                                </div>
                                <div class="mdc-layout-grid__inner mt-2">
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                                        <div class="table-responsive">
                                            <table class="table dashboard-table">
                                                <tbody>
                                                <?php
                                                $ct = 0;
                                                foreach ($block_data as $key => $value) {
                                                    if ($ct > 3) {
                                                        break;
                                                    } else {
                                                        $ct++;
                                                        echo "<tr> <td> <span class=\"flag-icon-container\"><i class=\"flag-icon flag-icon-in mr-2\"></i></span>$key</td><td class=\" font-weight-medium\">$value</td></tr>";
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <a href="blocks.php">
                                                <button class="mdc-button mdc-button--outlined mdc-button__ripple ">
                                                    All Blocks
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                                        <div id="revenue-map" class="revenue-world-map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0">Nodal Officers</h4>
                                    <div>
                                        <i class="material-icons refresh-icon">refresh</i>
                                        <i class="material-icons options-icon ml-2">more_vert</i>
                                    </div>
                                </div>
                                <div class="d-block d-sm-flex justify-content-between align-items-center">
                                    <h5 class="card-sub-title mb-2 mb-sm-0">Total Nodal Officers</h5>
                                </div>
                                <div class="mdc-layout-grid__inner mt-2">
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                                        <div class="table-responsive">
                                            <table class="table dashboard-table">
                                                <tbody>
                                                <?php
                                                $ct = 0;
                                                while ($row = $users->fetch_assoc() and ($ct < 8)) {
                                                    echo "<tr> <td>" . $row["full_name"] . "</td><td class=\" font-weight-medium\">" . $row["username"] . "</td> </td><td class=\" font-weight-medium\">" . $row["block"] . "</td></tr>";
                                                    $ct++;
                                                }
                                                //
                                                ?>
                                                </tbody>
                                            </table>
                                            <a href="users.php">
                                                <button class="mdc-button mdc-button--outlined mdc-button__ripple ">
                                                    All users
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card bg-info text-white">
                                <div class="d-flex justify-content-between">
                                    <h3 class="font-weight-normal">Download Data</h3>
                                    <i class="material-icons options-icon text-white">more_vert</i>
                                </div>
                                <div class="mdc-layout-grid__inner align-items-center">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                                        <div>
                                            <!--                                            <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>-->
                                            <!--                                            <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>-->
                                            <a href=download.php?id=download">
                                                <button class="mdc-button mdc-button--outlined ">
                                                    <i class="material-icons mdc-button__icon">get_app</i>
                                                    Download
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                                        <canvas id="impressions-chart" height="80"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <!-- partial:partials/_footer.html -->
            <footer>
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                            <span class="tx-14">Copyright © 2020 Quarantine Monitoring All rights reserved.</span>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">
                            <div class="d-flex align-items-center">
                                <a href="">Terms & Condition</a>
                                <span class="vertical-divider"></span>
                                <a href="">FAQ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- partial -->
        </div>
    </div>
</div>
<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="js/material.js"></script>
<script src="js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/dashboard.js"></script>
<script src="assets/vendors/js/jquery.toast.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.toast({
            heading: 'Welcome admin',
            text: 'Keep track of records.',
            position: 'top-right',
            loaderBg: '#311b92',
            icon: 'info',
            hideAfter: 2700,
            stack: 6
        })
    });
</script>
<!-- End custom js for this page-->
</body>
</html>

