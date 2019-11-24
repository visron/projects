<?php

function curPage() {
    return basename($_SERVER['PHP_SELF']);
}

$status = 1;
$curPage = curPage();

require_once('classes/Admins.class.php');
$admin = new Admin();

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == 'true') {
        $admin->logOut();
        header('location:login.php');
    }
}
//if (!$admin->checkLogin()) {
//    header('location:login.php');
//    exit();
//}
//@$roleID = $admin->getRoleById($_SESSION['TYPE']);
//$loggedInUsersInfo = $admin->getAdminInfo($_SESSION['UID']);
//$notifications = $ntf->fetchNotifications($_SESSION['UID']);
//print_r($notifications);
//print_r($_SESSION); //exit;
//require_once('Auth.php');


$testmsg = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>Oh snap!</strong> Change a few things up and try submitting again.</div>';
$alert_msg = '';

if (isset($_SESSION['status']) && isset($_SESSION['msg'])) {


    if ($_SESSION['status'] == 'pass') {
        $alert_msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
    } else if ($_SESSION['status'] == 'fail') {
        $alert_msg = '<div class="alert alert-warning alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
    } else {
        $alert_msg = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $_SESSION['msg'] . '</div>';
    }

    //$alert_msg .=  '<button type="button" class="close" data-dismiss="alert">&times;</button>'.$_SESSION['msg'].'</div>';
    //print_r($_SESSION); exit;

    unset($_SESSION['status']);
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<!--

TABLE OF CONTENTS.

Use search to find needed section.

=====================================================

|  1. $BODY                 |  Body                 |
|  2. $MAIN_NAVIGATION      |  Main navigation      |
|  3. $NAVBAR_ICON_BUTTONS  |  Navbar Icon Buttons  |
|  4. $MAIN_MENU            |  Main menu            |
|  5. $CONTENT              |  Content              |

=====================================================

-->


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>My TECH</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <!-- Open Sans font from Google CDN -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">
        <!-- LanderApp's stylesheets -->
        <link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/landerapp.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">	
        <link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
        <link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
    </head>

    <!-- 1. $BODY ======================================================================================	
            Body
            Classes:
            * 'theme-{THEME NAME}'
            * 'right-to-left'      - Sets text direction to right-to-left
            * 'main-menu-right'    - Places the main menu on the right side
            * 'no-main-menu'       - Hides the main menu
            * 'main-navbar-fixed'  - Fixes the main navigation
            * 'main-menu-fixed'    - Fixes the main menu
            * 'main-menu-animated' - Animate main menu
    -->
    <body class="theme-default main-menu-animated">
        <script>var init = [];</script>
        <!-- Demo script --> <script src="assets/demo/demo.js"></script> <!-- / Demo script -->
        <div id="main-wrapper">
            <!-- 2. $MAIN_NAVIGATION =====================================Main navigation-->
            <div id="main-navbar" class="navbar navbar-inverse" 
" role="navigation">
                <!-- Main menu toggle -->
                <button type="button" id="main-menu-toggle" STYLE="background:#33ccff;"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
                <div class="navbar-inner" >
                    <!-- Main navbar header -->
                    <div class="navbar-header"STYLE="background: #33ccff;" >
                        <!-- Logo -->
                        <a href="index.php"  class="navbar-brand">
                            <strong>My TECH</strong> PROJECTs 
                        </a>
                        <!-- Main navbar toggle -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
                    </div> <!-- / .navbar-header -->

                    <div id="main-navbar-collapse" style="background: linear-gradient(to bottom right, #33ccff 5%, #ccff99 85%);
" class="collapse navbar-collapse main-navbar-collapse">
                        <div>
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="index.php">Home</a>
                                </li>
                                
                            </ul> <!-- / .navbar-nav -->

                            <div class="right clearfix">
                                <ul class="nav navbar-nav pull-right right-navbar-nav">

                                    <!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================
                                    
                                                                                            Navbar Icon Buttons
                                    
                                                                                            NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.
                                    
                                                                                            Classes:
                                                                                            * 'nav-icon-btn-info'
                                                                                            * 'nav-icon-btn-success'
                                                                                            * 'nav-icon-btn-warning'
                                                                                            * 'nav-icon-btn-danger' 
                                    -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                            <img src="assets/demo/avatars/1.jpg" alt="">
                                            <span>
                                                <?php 
//                                                if(isset($_SESSION['FIRSTNAME'])){   
//                                                echo $_SESSION['FIRSTNAME'];         
//                                                }else{
                                                echo "ADMIN";
                                            //} 
                                            ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!--<li><a href="user_profile.php"><i class="dropdown-icon fa fa-cogs"></i>&nbsp;&nbsp;Profile</a></li>-->
                                            <!--<li><a href="index.php?logout=true"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>-->
                                        </ul>
                                    </li>
                                </ul> <!-- / .navbar-nav -->
                            </div> <!-- / .right -->
                        </div>
                    </div> <!-- / #main-navbar-collapse -->
                </div> <!-- / .navbar-inner -->
            </div> <!-- / #main-navbar -->
            <!-- /2. $END_MAIN_NAVIGATION -->

<?php include_once('sidemenu.php'); ?>

