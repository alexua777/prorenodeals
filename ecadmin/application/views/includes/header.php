<?php
// content language (en = English)
header('Content-language: en');
// last modified
$time = filemtime("index.php");
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).' GMT');

// Disable caching of the current document:
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Pragma: no-cache');

//require_once("../configs/path.php");
$dark = "#0080C0";
$light = "#A8D3FF";
$td_bgcolor = "#F7F7F7";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$dotcom?> Admin </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Scriptgiant.com" />

 <!-- Headings -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700' rel='stylesheet' type='text/css'>
    <!-- Text -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

     <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:800" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Core stylesheets do not remove -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-theme.css" rel="stylesheet" />
    <link href="css/icons.css" rel="stylesheet" />
    <link href="css/genyx-theme/jquery.ui.genyx.css" rel="stylesheet" />

    <!-- Plugins stylesheets -->
      <!-- Plugins stylesheets -->
      <link href="js/plugins/forms/uniform/uniform.default.css" rel="stylesheet" />
      <link href="js/plugins/forms/switch/bootstrapSwitch.css" rel="stylesheet" />
      <link href="js/plugins/forms/spectrum/spectrum.css" rel="stylesheet" />
      <link href="js/plugins/forms/datepicker/datepicker.css" rel="stylesheet" />
      <link href="js/plugins/forms/select2/select2.css" rel="stylesheet" />
    <link href="js/plugins/forms/multiselect/ui.multiselect.css" rel="stylesheet" />

    <!-- app stylesheets -->
    <link href="css/app.css" rel="stylesheet" />
    <!-- <link rel="stylesheet/less" type="text/css" href="css/app.less" /> -->

    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="css/custom.css" rel="stylesheet" />

    <!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->

    <!-- Force IE9 to render in normal mode -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- Le javascript
    ================================================== -->
    <!-- Important plugins put in all pages -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
    <script src="js/conditionizr.min.js"></script>
    <script src="js/plugins/core/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="js/plugins/core/jrespond/jRespond.min.js"></script>
    <script src="js/jquery.genyxAdmin.js"></script>

    <!-- Form plugins -->
    <script src="js/jquery.mousewheel.js"></script>
    <script src="js/plugins/forms/uniform/jquery.uniform.min.js"></script>
    <script src="js/plugins/forms/autosize/jquery.autosize-min.js"></script>
    <script src="js/plugins/forms/inputlimit/jquery.inputlimiter.1.3.min.js"></script>
    <script src="js/plugins/forms/mask/jquery.mask.min.js"></script>
    <script src="js/plugins/forms/switch/bootstrapSwitch.js"></script>
    <script src="js/plugins/forms/globalize/globalize.js"></script>
    <script src="js/plugins/forms/spectrum/spectrum.js"></script><!--  Color picker -->
    <script src="js/plugins/forms/datepicker/bootstrap-datepicker.js"></script>
    <script src="js/plugins/forms/select2/select2.js"></script>
    <script src="js/plugins/forms/multiselect/ui.multiselect.js"></script>
    <script src="js/plugins/forms/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?=JS?>user_javascript.js"></script>
    <!-- Init plugins -->
    <script src="js/app.js"></script><!-- Core js functions -->
   
  </head>
  <body>
    <header id="header">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <a class="navbar-brand" href="index.php">
            <?=ucwords($dotcom)?> Control System<br>
            <div style=" font-size:10px; color:#CCC;"><?=showdate(date("Y-m-d"));?></div>
         <img src="images/mrtheo_logo.png" alt="Genyx admin" class="img-responsive"></a>

            <div class="collapse navbar-collapse" id="navbar-to-collapse">
                <!--<form id="top-search" class="navbar-form navbar-left" role="search">
                    <div class="input-group">
                        <input type="text" name="tsearch" id="tsearch" placeholder="Search here ..." class="search-query form-control">
                        <span class="input-group-btn">
                            <button type="submit" class="btn"><i class="icon16 i-search-2 gap-right0"></i></button>
                        </span>
                    </div>
                </form>-->
                <ul class="nav navbar-nav pull-right">
                    <li class="divider-vertical"></li>
                    <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon24 i-bell-2"></i>
                            <span class="notification red">6</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-calendar-2"></i> Admin Jenny add event</a></li>
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-file-zip"></i> User Dexter attach file</a></li>
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-stack-picture"></i> User Dexter attach 3 pictures</a></li>
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-cart-add"></i> New orders <span class="notification green">2</span></a></li>
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-bubbles-2"></i> New comments <span class="notification red">5</span></a></li>
                            <li role="presentation"><a href="#" class=""><i class="icon16 i-pie-5"></i> Daily stats is generated</a></li>
                        </ul>
                    </li>-->
                    <!--<li class="divider-vertical"></li>
                       <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon24 i-envelop-2"></i>
                            <span class="notification red">3</span>
                        </a>
                        <ul class="dropdown-menu messages" role="menu">
                            <li class="head" role="presentation">
                                <h4>Inbox</h4>
                                <span class="count">3 messages</span>
                                <span class="new-msg"><a href="#" class="tipB" title="Write message"><i class="icon16 i-pencil-5"></i></a></span>
                            </li>
                            <li role="presentation">
                                <a href="#" class="clearfix">
                                    <span class="avatar"><img src="images/avatars/peter.jpg" alt="avatar"></span>
                                    <span class="msg">Call me i need to talk with you</span>
                                    <button class="btn close"><i class="icon12 i-close-2"></i></button>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="clearfix">
                                    <span class="avatar"><img src="images/avatars/milen.jpg" alt="avatar"></span>
                                    <span class="msg">Problem with registration</span>
                                    <button class="btn close"><i class="icon12 i-close-2"></i></button>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#" class="clearfix">
                                    <span class="avatar"><img src="images/avatars/anonime.jpg" alt="avatar"></span>
                                    <span class="msg">I have question about ...</span>
                                    <button class="btn close"><i class="icon12 i-close-2"></i></button>
                                </a>
                            </li>
                            <li class="foot" role="presentation"><a href="email.html">View all messages</a></li>
                        </ul>
                    </li>-->
                    <li class="divider-vertical"></li>
                    <li class="dropdown user">
                         <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            <img src="images/adim.png" alt="Admin">
                            <span class="more"><i class="icon16 i-arrow-down-2"></i></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">

                            <li role="presentation"><a href="password_change.php" class=""><i class="icon16 i-user"></i> Password Change</a></li>
                            <li role="presentation"><a href="logout.php" class=""><i class="icon16 i-exit"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li class="divider-vertical"></li>
                </ul>
            </div><!--/.nav-collapse -->
        </nav>
    </header> <!-- End #header  -->

    <div class="main">
        <aside id="sidebar">
            <div class="side-options">
                <ul class="list-unstyled">
                    <li>
                        <a href="#" id="collapse-nav" class="act act-primary tip" title="Collapse navigation">
                            <i class="icon16 i-arrow-left-7"></i>
                        </a>
                    </li>
                </ul>
            </div>