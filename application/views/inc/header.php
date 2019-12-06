<?php
$unread_msg = 0;
$user= $this->session->userdata('user');
if($this->session->userdata('user')){
	$name=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id)." ".$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
	$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);
			if($logo==''){
				$logo="images/user.png";
			}else{
				if(file_exists('assets/uploaded/cropped_'.$logo)){
					$logo="uploaded/cropped_".$logo;
				}else{
					$logo="uploaded/".$logo;
				}
				
			}
	$plan=$user[0]->membership_plan;
	if($plan==1){$img="FREE_img.png";}elseif($plan==2){$img="SILVER_img.png";}elseif($plan==3){$img="GOLD_img.png";}elseif($plan==4){$img="PLATINUM_img.png";}	

	$dir = "user_message/";
	$filename=$dir."user_".$user[0]->user_id.".newmsg";
	if(!file_exists($filename)){
		$unread_msg = 0;
	}else{
		$unread_msg=file_get_contents($filename);
	}
	
}
$style='';
if($unread_msg == 0){
	$style = 'display:none;';
}
?>

<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
<div class="container-fluid">
	<?php 
    $currLang='';
     if($this->session->userdata('lang')){
        $currLang = $this->session->userdata('lang'); 
    }
    ?>
    <?php if($currLang == 'arabic'){ ?>
        <a class="navbar-brand" href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?=ASSETS?>img/logo_ar.png" alt="" title=""></a>
        <?php }else{ ?>
        <a class="navbar-brand" href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title=""></a>
	<?php } ?>
    <a href="javascript:void(0)" class="mobile-menu" style="display:none"><i class="icon-feather-grid"></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <div class="navbar-collapse-header"><div class="collapse-brand"><a class="navbar-brand" href="<?=VPATH?>" alt="<?=SITE_TITLE?>" title="<?=SITE_TITLE?>"><img src="<?=ASSETS?>img/<?php echo SITE_LOGO;?>" alt="" title=""></a></div><a href="#navbarSupportedContent" class="collapse-close" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"><i class="icon-feather-x"></i></a></div>
  	<?php
$langMap = array(
	'arabic'=>IMAGE.'cuntryflag/uae.png',
	'spanish'=>IMAGE.'cuntryflag/spanish.png',
	'swedish'=>IMAGE.'cuntryflag/swedish.png',
	'english'=>IMAGE.'cuntryflag/britain.png',
);

$curr_lang = 'english';
if($this->session->userdata('lang')){
	$curr_lang = $this->session->userdata('lang');
}

 ?>
        <ul class="navbar-nav mr-auto">
	  	<?php if($this->session->userdata('user')) { ?>
            			
            <li class="nav-item"><a class="nav-link" href="<?=VPATH?>dashboard"><?php echo __('dashboard','Dashboard'); ?></a> </li>
        <?php } ?>
		<?php if($this->session->userdata('user')){
			$user= $this->session->userdata('user'); //print_r($user);
        	if($user[0]->account_type == 'F'){ ?>
         	
          
            <li class="nav-item"><a class="nav-link" href="<?=VPATH?>findjob/"><?php echo __('find_job','Find Jobs'); ?></a></li>
            <li class="nav-item hide"><a class="nav-link" href="<?=VPATH?>contest/browse"><?php echo __('find_contest','Find Contest'); ?></a></li>
          
        <?php }
        }else{ ?>
        	
         
            <li class="nav-item"><a class="nav-link" href="<?=VPATH?>findjob/"><?php echo __('find_job','Find Jobs'); ?></a></li>
            <li class="nav-item hide"><a class="nav-link" href="<?=VPATH?>contest/browse"><?php echo __('find_contest','Find Contest'); ?></a></li>
         
		<?php } ?>
        <?php if($this->session->userdata('user')){ 
		$user= $this->session->userdata('user');
		if($user[0]->account_type == 'E'){
		?>
			<li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Post</a>        	
			  <ul class="dropdown-menu">
				<li><a href="<?=VPATH?>postjob/"><?php echo __('post_project','Post Project'); ?></a></li>
				<li class="hide"><a href="<?=VPATH?>contest/post_contest"><?php echo __('post_contest','Post Contest'); ?></a></li>
			  </ul>
			</li> 
		
			<!--<li><a href="<?=VPATH?>postjob" <? if($current_page=="postjob"){?> id="current"<? }?>><?php echo __('post_job','POST JOB'); ?></a></li> -->
		<?php } }else{/*  ?>
			<li><a href="<?=VPATH?>login?refer=postjob/" <? if($current_page=="postjob"){?> id="current"<? }?>>POST JOB</a></li> 
		<?php */} ?>
        <?php if($this->session->userdata('user')){
			$user= $this->session->userdata('user');
        	if($user[0]->account_type == 'E'){?>
			<li class="nav-item"><a class="nav-link" href="<?=VPATH?>findtalents/" <? if($current_page=="findtalent"){?> id="current"<? }?>><?php echo __('find_contractor','Find Contractor'); ?></a></li>
            
        <?php }
        }else{?>
        <li class="nav-item"><a class="nav-link" href="<?=VPATH?>findtalents/">Find Contractor</a></li>  
        <?php /*?><li><a href="<?=VPATH?>findtalents/" <? if($current_page=="findtalent"){?> id="current"<? }?>><?php echo __('find_contractor','Find Contractor'); ?></a></li> <?php */?>
        <?php }?>  
         
         
      </ul>
      
      
 <?php
 if($this->session->userdata('user')){
	
 	  if($this->router->fetch_class()=="affiliate"){
?>
 		<ul class="nav navbar-nav">
            <li class="profile-imgEcnLi"><a href="<?=VPATH?>affiliate/dashboard/" <? if($current_page=="dashboard"){?>id="current"<? }?>><i class="fa fa-user" style="font-size:20px"  id="head_noti_profile"></i>&nbsp;</a>
              <ul>
                <li><a href="<?=VPATH?>affiliate/dashboard/" <? if($current_page=="dashboard"){?>id="current"<? }?>><?php echo __('dashboard','Dashboard'); ?></a></li>
                <li><a href="<?=VPATH?>affiliate/logout/" <? if($current_page=="logout"){?>id="current"<? }?>><?php echo __('logout','Logout'); ?></a></li>
              </ul>
            </li>
		</ul>
 	  	
<?php	  }else{
	
?>

<ul class="nav navbar-nav navbar-right">
		<li class="hidden"><span class="dropdown language">
          <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <img src="<?php echo $langMap[$curr_lang]?>" alt="">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="min-width:40px;">
		  <?php foreach($langMap as $key =>$v){?>
            <li><a onClick="changeLang(this,'<?php echo $key ?>')"><img src="<?php echo $v;?>" alt=""></a></li>
            
			<?php } ?>
          </ul>
        </span></li>
        <li class="nav-item" style="position: relative;"><a class="nav-link" href="<?=VPATH?>message/browse" <? if($current_page=="membership"){?>id="current"<? }?>><i class="icon-feather-mail hidden-md"></i> <span class="visible-md">Message</span></a><span class="badge badge-success" id="msg_count" style="<?php echo $style;?>"><?php echo $unread_msg; ?></span></li>
        
		<li class="headnotification"><a href="javascript:void(0)" class="nav-link Noback"> <i class="icon-feather-bell hidden-md"></i> <span class="badge badge-success" id="head_noti"></span> <span class="visible-md">Notification</span></a> </li>
        
                

		<li class="profile-imgEcnLi hidden"><a href="javascript:void(0)" <? if($current_page=="dashboard"){?>id="current"<? }?> class="Noback profile-imgEcn hidden-xs">
        <i class="zmdi zmdi-account profile-imgEcn" style="font-size:20px" id="head_noti_profile"></i>&nbsp;</a>  </li>
		<li>
		<figure class="profile-imgEc toggle-leftbar m-0"> <img src="<?=VPATH?>assets/<?=$logo?>" alt="" width="36" height="36" class="img-circle"> </figure>
		</li>
        <?php if($this->session->userdata('user')){ 
		$user= $this->session->userdata('user');
		if($user[0]->account_type == 'E'){
		?>
        <li><span class="e-btn"><a class="btn btn-site" href="<?=VPATH?>postjob/">Post Project</a></span></li>
        <?php } }else{
		} ?>
		</ul>
<?php			
	  }
 	
 	}
 
 ?>
    
     <?php if(!$this->session->userdata('user')){ ?>
     <?php /*?><form class="form-inline my-2 my-lg-0" action="<?php echo (!empty($_GET['lookin']) AND $_GET['lookin'] == 'findjob') ? VPATH.'findjob/browse' : VPATH.'findtalents';?>" id="header_search_form">
            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-prepend">
                  <div class="dropdown">
					<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-color:#ddd">
   <span id="srch_txt"><?php echo (!empty($_GET['lookin']) AND $_GET['lookin'] == 'findjob') ? __('jobs','Jobs') : __('contractor','Contractor');?></span> <span class="caret"></span>
  </button>
  <div class="dropdown-menu" aria-labelledby="menu1" style="left:0;right:auto">
    <a class="dropdown-item srch_dropdown_item" href="#" data-srch="Freelancer"><?php echo __('contractor','Contractor'); ?></a>
    <a class="dropdown-item srch_dropdown_item" href="#" data-srch="Jobs"><?php echo __('jobs','Jobs'); ?></a>
  </div>
</div>

                  
                  </span>
                  <input type="hidden" name="lookin" value="<?php echo !empty($_GET['lookin']) ? $_GET['lookin'] : 'freelancer';?>" id="lookin"/>
                  <input type="text" class="form-control" placeholder="<?php echo __('search','Search'); ?>" name="q" value="<?php echo !empty($_GET['q']) ? $_GET['q'] : '';?>">
                </div>
            </div>
      </form><?php */?>      
            <span class="hidden-xs">&nbsp;&nbsp;</span> 
                 
        
          <span class="dropdown language hidden">
              <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <img src="<?php echo $langMap[$curr_lang]?>" alt="">
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="min-width:40px;">
              <?php foreach($langMap as $key =>$v){?>
                <li><a onClick="changeLang(this,'<?php echo $key ?>')"><img src="<?php echo $v;?>" alt=""></a></li>
                
                <?php } ?>
              </ul>
            </span>
            <?php         
      if($this->router->fetch_class()=="affiliate"){
            if(!$this->session->userdata('user_affiliate')){
            ?>
                    <a  class="btn btn-accent" href="<?=VPATH?>affiliate/" <? if($current_page=="signup"){?>id="current"<? }?>> <?php echo __('register','REGISTER'); ?></a>
                    <a  class="btn btn-warning" href="<?=VPATH?>affiliate/"> <?php echo __('login','Login'); ?></a>
            <?php
            }
            ?>
    <?php
     }else{ 
      if(!$this->session->userdata('user')){
     ?>
     		<div class="header-widget">
            <a href="<?=VPATH?>login/"><i class="zmdi zmdi-sign-in"></i> <?php echo __('signin','Sign in'); ?></a>
            
            <a href="<?=VPATH?>signup/" <? if($current_page=="signup"){?>id="current"<? }?>><i class="zmdi zmdi-account"></i> <?php echo __('register','REGISTER'); ?></a>
            
            <a class="btn btn-site" href="<?=VPATH?>login?refer=postjob/">Post Project</a>
            </div>
    <?php }
    }?>   
          
     <?php } ?> 
  </div>
  </div>
</nav>
<section class="menuA">
    <div id="slidemenu"></div>  
</section>
</header>
<!-- Header End --> 

<script type="text/javascript">

function postjob_fn(){
	$("#post_div").toggle();
	document.getElementById("login_div").style.display="none";
	}
	
function login_fn(){
	document.getElementById("post_div").style.display="none";
	$("#login_div").toggle();
}
 
 function check()
 {
	var title=$('#title_name').val();
	var mail=$('#mail').val();
    var atpos = mail.indexOf("@");
    var dotpos = mail.lastIndexOf(".");
    
	if(title=='' || title=='What do want to get done?')
	{
		alert('job title cant be left blank');
		return false;	
	}
	else if(mail=='' || mail=='Your email address')
	{
		alert('email cant be left blank');
		return false;	
	}
	else if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
	else
	{
		return true; 
	}
}      
   
</script>
<?php 
 if($this->session->userdata('user')){ 
 $user=$this->session->userdata('user');
   
	$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
	$user_wallet_id = get_user_wallet($user[0]->user_id);
	$acc_balance=get_wallet_balance($user_wallet_id);
 
 ?>
<div class="ecdevsec">
  <div class="user-sidebar-container quicknav" style="display: none;">
    <div class="sidebar user-sidebar">
      <div class="user-sidebar-info">
        <figure class="profile-img"> <a href="<?=VPATH?>dashboard"> <img src="<?=VPATH?>assets/<?=$logo?>"> </a> </figure>
        <div class="user-sidebar-name">
          <h4><?=ucwords($name)?></h4>
		  <b><?php echo __('header_sticky_balance','BALANCE'); ?> :</b> <?php echo CURRENCY.' '.$acc_balance;?>
		   <?php if($user[0]->account_type == 'F'){ ?>
		  <a href="<?php echo base_url('tracker.zip');?>" target="_blank" class="btn btn-primary" style="margin-top:10px" hidden>Download Tracker</a>	
		   <?php } ?>
        </div>
        <!--<div class="user-sidebar-status" style="margin-bottom:10px"> <img src="<?php// echo IMAGE;?><?=$img?>"> </div>-->
        
        <!--<a href="<?//=VPATH?>dashboard/tracker/" target="_blank" class="btn btn-warning btn-sm" style="color:#FFF">Download Timetracker</a>--> </div>
      <nav class="sidebar-nav menu ">
        <ul>
          <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_my_account','My Account'); ?></a></li>
          <li class="hide"> <a class="sidebar-link"  href="<?=VPATH?>membership/"><i class="zmdi zmdi-account"></i> <?php echo __('header_sticky_membership','Membership'); ?> </a></li>
        <?php if($user[0]->account_type == 'E'){ ?>  <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/myproject_client"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_posted_job','My Posted Jobs'); ?></a></li> <?php } ?>
         <?php if($user[0]->account_type == 'F'){ ?> <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/myproject_working"><i class="fa fa-briefcase"></i> <?php echo __('header_sticky_my_working_job','My Working Jobs'); ?></a></li><?php } ?>
          <li><a class="sidebar-link"  href="<?=VPATH?>myfinance"><i class="fa fa-list-alt"></i> <?php echo __('header_sticky_add_fund','Add Fund'); ?></a></li>
          <li> <a class="sidebar-link"  href="<?=VPATH?>myfinance/transaction"><i class="fa fa-list-alt"></i> <?php echo __('header_sticky_transaction_history','Transaction History'); ?></a></li>
        
          <li><a class="sidebar-link"  href="<?=VPATH?>dashboard/setting"><i class="fa fa-cogs"></i> <?php echo __('header_sticky_settings','Settings'); ?></a></li>
          <li><a class="sidebar-link"   href="<?=VPATH?>user/logout/"><i class="fa fa-sign-out-alt"></i> <?php echo __('header_sticky_logout','Logout'); ?></a></li>
        </ul>
      </nav>
      <span class="sidebar-close-alt">&times;</span> </div>
  </div>
</div>
<? }?>
<?php 
 if($this->session->userdata('user')){ 
 ?>
<div class="profileSe" style="display: none">
    <!--<div class="profileSetop">
      <div class="profileSetopBTN">
        <input name="view" checked="" id="online" type="radio">
        <label class="BtN btnSec" for="online">Online</label>
        <input name="view" id="invisible" type="radio">
        <label class="BtN btnSec" for="invisible">Invisible</label>
      </div>      
    </div>-->
    <ul class="secentList">
      <li title="<?=ucwords($name)?>" class="secentListInactive"> <a href="<?=VPATH?>dashboard" class="secentListItem secentListItemActive"> <span class=""> <img src="<?=VPATH?>assets/<?=$logo?>" style="height: 36px;width: 36px;border-radius: 18px;"></span>
        <?=ucwords($name)?>
        </a> </li>
   
    <!--<li><a href="<?//=VPATH?>dashboard/setting" class="secentListItem SectionBottom"><i class="fa fa-cogs"></i> Settings</a> </li>-->
    <li><a href="<?=VPATH?>user/logout/" class="secentListItem" title="Log out"> <i class="fa fa-sign-out"></i> Log out <span class="float-right">
    <?=$user[0]->username?>
    </span> </a> </li></ul>
    </div>
    
    <div class="header-notifications-dropdown">
        <div class="header-notifications-headline">
            <h4>Notifications</h4>
        </div>
        <div class="header-notifications-content">
            <ul class="notiH"></ul>                    
            <a href="<?=VPATH?>notification/" class="btn btn-block btn-site">Show more</a>
        </div>            
    </div>
    
<!--<ul class="notiH" role="menu" style="width:300px; display:none"></ul>
<a href="<?=VPATH?>notification/" class="btn btn-block btn-site">Show more</a>-->


<?php 
}
 ?>
 
 
 <style>
 
 .notification:after, .notification:before {
	right: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
}
.notification {
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #5b6779;
    background: #6f7a8a;
    padding: 0px 6px;
    position: relative;
    color: #f2f2f2;
    font-weight: bold;
    font-size: 12px;
}
.notification.red {
    border-color: #be3d3c;
    background: #d8605f;
    color: #f2f2f2;
}
.notification:before {
    border-color: rgba(182, 119, 9, 0);
    border-right-color: #5b6779;
    border-width: 7px;
    top: 50%;
    margin-top: -7px;
}
.notification.red:before {
    border-color: rgba(190, 61, 60, 0);
    border-right-color: #be3d3c;
}
.notification.red:after {
    border-color: rgba(216, 96, 95, 0);
    border-right-color: #d8605f;
}
.notification:after {
    border-color: rgba(111, 122, 138, 0);
    border-right-color: #6f7a8a;
    border-width: 6px;
    top: 50%;
    margin-top: -6px;
}
</style>
<script>
	jQuery(document).ready(function($){
		$('.srch_dropdown_item').click(function(e){
			e.preventDefault();
			var srch = $(this).attr('data-srch');
			if(srch == 'Freelancer'){
				// $('#srch_txt').html(srch);
				$('#srch_txt').html('<?php echo __('contractor','Contractor'); ?>');
				$('#header_search_form').attr('action' , '<?php echo VPATH;?>findtalents');
				$('#lookin').val('freelancer');
			}
			
			if(srch == 'Jobs'){
				// $('#srch_txt').html(srch);
				$('#srch_txt').html('<?php echo __('jobs','Jobs'); ?>');
				$('#header_search_form').attr('action' , '<?php echo VPATH;?>findjob/browse');
				$('#lookin').val('findjob');
			}
		});
	});
</script>

<script>
$(document).ready(function () {


    //stick in the fixed 100% height behind the navbar but don't wrap it
    //$('#slide-nav.navbar-inverse').after($('<div class="inverse" id="navbar-height-col"></div>'));
  
    $('#slide-nav.navbar-default').after($('<div id="navbar-height-col"></div>'));  

    // Enter your ids or classes
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; // the menu inside the slide menu itself
    var slidewidth = '80%';
    var menuneg = '-100%';
    var slideneg = '-100%';


    $("#slide-nav").on("click", toggler, function (e) {

        var selected = $(this).hasClass('slide-active');
        $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });
        $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });
        $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(this).toggleClass('slide-active', !selected);
        $('#slidemenu').toggleClass('slide-active');
        $('#page-content, .navbar, .navbar-header').toggleClass('slide-active');
    });

    var selected = '#slidemenu, #page-content, .navbar, .navbar-header';

    $(window).on("resize", function () {

        if ($(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
            $(selected).removeClass('slide-active');
        }
    });

});

</script>

<div id="page-content">
