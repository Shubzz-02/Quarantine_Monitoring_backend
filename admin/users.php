<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

ob_start();
session_start();

require_once "config/data.php";

if (!isset($_SESSION['email']) || empty($_SESSION['email'] || !isset($_SESSION['qqs']) || empty($_SESSION['qqs']))) {
    header("location: login.php");
    exit;
}

$email = $_SESSION['email'];
//echo $admin_fullname." ". $admin_email;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quarantine Monitoring | Users</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
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
<!--                    <div class="mdc-list-item mdc-drawer-item">-->
<!--                        <a class="mdc-drawer-link" href="vill.php">-->
<!--                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"-->
<!--                               aria-hidden="true">location_city</i>-->
<!--                            Villages-->
<!--                        </a>-->
<!--                    </div>-->
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="blocks.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">view_carousel</i>
                            Blocks
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
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card p-0">
                                <h6 class="card-title card-padding pb-0">Users</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-left">Full Name</th>
                                            <th>Phone No.</th>
                                            <th>User Role</th>
                                            <th>Block</th>
                                            <th>Count</th>
                                            <th>Date</th>
                                            <!--                                            <th>Protein (g)</th>-->
                                            <!--                                            <th>Sodium (mg)</th>-->
                                            <!--                                            <th>Calcium (%)</th>-->
                                            <!--                                            <th>Iron (%)</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?PHP
                                        while ($row = $users->fetch_assoc()) {
                                            echo "<tr><td class=\"text-left\">" . $row["full_name"] . "</td><td>" . $row["username"] . "</td><td>Nodal Officer</td><td>" . $row["block"] . "</td><td>" . $row["count"] . "</td><td>null</td></tr>";
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
<!-- End custom js for this page-->
</body>
</html>

