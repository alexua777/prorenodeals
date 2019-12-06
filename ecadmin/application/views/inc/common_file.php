<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= SITE_TITLE ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Originatesoft" />
        <meta name="description" content="<?= SITE_DESC ?>" />
        <meta name="keywords" content="<?= SITE_KEY ?>" />
        <meta name="application-name" content="<?=SITE_TITLE ?>" />

		<!--<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">-->
        <!-- Core stylesheets do not remove -->
        <?php /*?><link href="<?= CSS ?>bootstrap/bootstrap.css" rel="stylesheet" /><?php */?>
        <link href="<?=CSS?>bootstrapnew.css" rel="stylesheet" />
        <link href="<?= CSS ?>icons.css" rel="stylesheet" />
        <link href="<?= CSS ?>ui/jquery.ui.all.css" rel="stylesheet" />        
        <!--<link rel="stylesheet" href="<?= CSS ?>bootstrap-3.1.1.min.css" type="text/css" />
        <link rel="stylesheet" href="<?= CSS ?>bootstrap-multiselect.css" type="text/css" /> -->
        <link href="<?= CSS ?>line-awesome.min.css" rel="stylesheet" />

        <!-- Plugins stylesheets -->
        <link href="<?= JS ?>plugins/misc/fullcalendar/fullcalendar.css" rel="stylesheet" /> 
        <link href="<?= JS ?>plugins/forms/uniform/uniform.default.css" rel="stylesheet" /> 
        <link href="<?= JS ?>plugins/ui/jgrowl/jquery.jgrowl.css" rel="stylesheet" /> 
		<link rel="stylesheet" href="<?=SITE_URL?>assets/css/foundation.css" type="text/css" />


		
        <!-- Plugins stylesheets -->

        <link href="<?= JS ?>plugins/forms/select2/select2.css" rel="stylesheet" />
        <!-- app stylesheets -->
        <link href="<?= CSS ?>app.css" rel="stylesheet" /> 
		<link href="<?= CSS ?>style.css" rel="stylesheet" /> 
        <!-- Custom stylesheets ( Put your own changes here ) -->
        <link href="<?= CSS ?>custom.css" rel="stylesheet" /> 		
        <!-- Force IE9 to render in normal mode -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?= JS ?>html5shiv.js"></script>
          <script src="<?= JS ?>respond.min.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= IMAGE ?>ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= IMAGE ?>ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= IMAGE ?>ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= IMAGE ?>ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?= IMAGE ?>ico/favicon.png">
        <!-- Le javascript
        ================================================== -->
        
<script src="<?= JS ?>jquery-2.1.1.min.js"></script>
<script src="<?= JS ?>jquery-ui-1.9.2.min.js"></script>
<script src="<?=JS?>conditionizr.min.js"></script>  