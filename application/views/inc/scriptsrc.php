<!DOCTYPE HTML>
<?php 
$currLang='';
 if($this->session->userdata('lang')){
	$currLang = $this->session->userdata('lang');
}
$lang_pos = 'ltr';
if($currLang == 'arabic'){
	$lang_pos = 'rtl';
	}
?>
<html dir="<?php echo $lang_pos; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
if(isset($meta_tag)){ 
	echo $meta_tag  ;
}else{
?>
<?php $siteTitle=$this->auto_model->getFeild('site_title','setting','id',1); ?>
<title><?php echo !empty($siteTitle)? $siteTitle : ''; ?></title>
<meta name="author" content="Originatesoft" />
<meta name="description" content="<?=SITE_DESC?>" />
<meta name="keywords" content="<?=SITE_KEY?>" />
<meta name="application-name" content="<?php echo !empty($siteTitle)? $siteTitle : ''; ?>" />
<?php
}
?>
<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap');
</style>
<?php
$this->load->config('minify', TRUE, TRUE);

$pagemethod=$this->router->fetch_method();
$pageclass=$this->router->fetch_class();
if($pageclass=='user' && $pagemethod=='index'){
	
}
?>
<!-- Bootstrap core CSS -->
<?php if($currLang == 'arabic'){ ?>
<?php $this->minify->add_css('bootstrap.rtl.css');?>
<?php }else{ ?>
<?php $this->minify->add_css('bootstrap.css');?>
<?php } ?>
<!-- Fonts -->
<?php 
//$this->minify->add_css('fontawesome-all.min.css');
$this->minify->add_css('material-design-iconic-font.css');
$this->minify->add_css('feather.css');
if($pageclass=='user' && $pagemethod=='index'){
}else{
$this->minify->add_css('magic-check.css');
$this->minify->add_css('superfish.css');
}
$this->minify->add_css('style.css');
$this->minify->add_css('responsive.css');
?>
<!--[if lte IE 9]>
	  <script src="js/html5shiv.js"></script>
      <link href="css/ie.css" rel="stylesheet" type="text/css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
      <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
      <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<?php if($currLang == 'arabic'){
	$this->minify->add_css('style_ar.css');
	 ?>
<?php }else{ 
$this->minify->add_css('style_en.css');
?>
<?php } ?>
<?php
$this->minify->add_css('menusection.css');
if($pageclass=='user' && $pagemethod=='index'){
}else{
$this->minify->add_css('bootstrap-datetimepicker.css');
}
?>
<!-- Favicons -->
<link rel="shortcut icon" href="<?=ASSETS?>favicon/<?php echo SITE_FAVICON;?>">
<?php
if($pageclass=='user' && $pagemethod=='index'){
}else{
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<?php }?>
<?php if($current_page == 'dashboard'){
$this->minify->add_js('jquery-3.3.1.min.js');	
	 ?>
<?php }else{
	$this->minify->add_js('jquery-2.1.1.min.js');	
	?>
<?php }
if($pageclass=='user' && $pagemethod=='index'){
}else{	
$this->minify->add_js('animation.min.js');	
$this->minify->add_js('jquery.nicescroll.min.js');
}
?>
<?php
echo $this->minify->deploy_css(FALSE, 'header.min.css');
echo $this->minify->deploy_js(FALSE, 'header.min.js');
?>
<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <script src="<?=JS?>respond.min.js"></script>
  <![endif]-->
<!--[if IE]>
  <link rel="stylesheet" href="<?=CSS?>ie.css">
  <![endif]-->
<? echo $load_css_js;?>
<script>var VPATH = '<?php echo base_url();?>';</script>
<?php
if($pageclass=='user' && $pagemethod=='index'){
}else{
	?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<?php }?>
<link rel="stylesheet" href="<?php echo CSS;?>fontawesome-all.min.css">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-155300550-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-155300550-1');
</script>
</head>