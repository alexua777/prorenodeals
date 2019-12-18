<!-- Footer Start -->

<?php

$page_partner=$this->auto_model->getFeild('partner','pagesetup','id','1');

$page_newsletter=$this->auto_model->getFeild('newsletter','pagesetup','id','1');

$page_posts=$this->auto_model->getFeild('posts','pagesetup','id','1');

$page_popular_links=$this->auto_model->getFeild('popular_links','pagesetup','id','1');

$footer_text=$this->auto_model->getFeild('footer_text','setting','id','1');



$event=$this->auto_model->getalldata('','event','status','Y');

$partner=$this->auto_model->getalldata('','partner','status','Y',6);

$popular=$this->auto_model->getalldata('','popular','id','1');



$lang = $this->session->userdata('lang');

?>

<div class="clearfix"></div>
<footer>
  <div>
    <div class="container">
      <div class="row">
        <?php  if($page_popular_links=='Y') { ?>
        <article class="col-md-3 col-sm-6 col-12">
          <h4><?php echo __('popular_','Company'); ?></h4>
          <ul class="foot-nav">
            <li><a href="<?=VPATH?>information/info/about_us/" <? if($current_page=="about_us"){?>id="current"<? }?>><?php echo __('about_us','About Us'); ?></a></li>
            <li><a href="<?php echo VPATH;?>knowledgebase/" <? if($current_page=="knowledge_base"){?>id="current"<? }?>><?php echo __('success_tips','Success Tips'); ?></a></li>
            <?php  foreach($popular as $vals){ ?>
            <?php if($vals->faq=='Y'){ ?>
            <li><a href="<?php echo  base_url()?>faq_help"><?php echo __('faqs','FAQs'); ?></a></li>
            <?php } ?>
            <?php if($vals->sitemap=='Y'){ ?>
            <li><a href="<?php echo  base_url()?>sitemap"><?php echo __('sitemap','Sitemap'); ?></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
        </article>
        <?php } ?>
        <?php

	/* $top_categories = $this->db->select("p.category , c.cat_name,c.arabic_cat_name,c.spanish_cat_name,c.swedish_cat_name, COUNT(p.id) AS total")->from('projects p')->join('categories c', 'c.cat_id=p.category', 'LEFT')->where(array('p.status'=>'O','p.project_status'=>'Y'))->group_by('p.category')->order_by('total' , 'DESC')->limit(5 , 0)->get()->result_array(); */

	$this->load->model('user/user_model');

	$catagory_no=$this->auto_model->getFeild('skill_no','pagesetup','id','1');

	$top_skill = $this->user_model->get_top_skills($catagory_no);

	

	?>
        <?php  if($page_popular_links=='Y') { ?>
        <article class="col-md-3 col-sm-6 col-12">
          <h4><?php echo __('browse_','Legal'); ?></h4>
          <ul class="foot-nav">
            <?php /* if($vals->terms=='Y'){ ?>
            <li><a href="<?php echo  base_url()?>information/info/terms_condition"><?php echo __('terms_&_conditions','Terms & Conditions'); ?></a></li>
            <?php } */ ?>
            <li><a href="<?php echo  base_url()?>information/info/service_agreement_clients"><?php echo __('service_provider_','Service Agreement for Clients'); ?></a></li>
            <li><a href="<?php echo  base_url()?>information/info/service_agreement_contractors"><?php echo __('service_provider_','Service Agreement for Contractors'); ?></a></li>
            <?php /* if($vals->refund=='Y'){ ?>
            <li><a href="<?php echo  base_url()?>information/info/refund_policy"><?php echo __('refund_policy','Refund Policy'); ?></a></li>
            <?php } */ ?>
            <?php if($vals->privacy=='Y'){ ?>
            <li><a href="<?php echo  base_url()?>information/info/privacy_policy"><?php echo __('privecy_policy','Privacy Policy'); ?></a></li>
            <?php } ?>
            <li><a href="<?php echo  base_url()?>information/info/cookies_policy"><?php echo __('cookies_policy','Cookies Policy'); ?></a></li>
            <li><a href="<?php echo  base_url()?>information/info/claims_resolution_policy"><?php echo __('claims_resolution_policy','Claims Resolution Policy'); ?></a></li>
            <?php

			$count = 0;

			/* foreach($catagories as $k => $val){ */

			foreach($top_skill as $k => $val){

				switch($lang){

					case 'arabic':

						$categoryName = !empty($val['arabic_cat_name'])? $val['arabic_cat_name'] : $val['skill_name'];

						break;

					case 'spanish':

						//$categoryName = $val['spanish_cat_name'];

						$categoryName = !empty($val['spanish_cat_name'])? $val['spanish_cat_name'] : $val['skill_name'];

						break;

					case 'swedish':

						//$categoryName = $val['swedish_cat_name'];

						

						$categoryName = !empty($val['swedish_cat_name'])? $val['swedish_cat_name'] : $val['skill_name'];

						break;

					default :

						$categoryName = $val['skill_name'];

						break;

				}

			?>
            <li> <a href="<?php echo base_url('findjob/browse?skills[]='.$val['id']); ?>"><?php echo $categoryName; ?></a> </li>
            <?php } ?>
          </ul>
          
          <!--<ul class="foot-nav">

			<?php if(count($top_categories) > 0){ foreach($top_categories as $k => $v){  

			

			switch($lang){

				case 'arabic':

					$categoryName = !empty($v['arabic_cat_name'])? $v['arabic_cat_name'] : $v['cat_name'];

					break;

				case 'spanish':

					//$categoryName = $val['spanish_cat_name'];

					$categoryName = !empty($v['spanish_cat_name'])? $v['spanish_cat_name'] : $v['cat_name'];

					break;

				case 'swedish':

					//$categoryName = $val['swedish_cat_name'];

					

					$categoryName = !empty($v['swedish_cat_name'])? $v['swedish_cat_name'] : $v['cat_name'];

					break;

				default :

					$categoryName = $v['cat_name'];

					break;

			}

			

			?>

			<li><a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($v['cat_name']).'/'.$v['category']?>"><?php echo $categoryName;?></a></li>

			<?php } } ?>	

        </ul>--> 
          
        </article>
        <?php } ?>
        <?php  if($page_popular_links=='Y') { ?>
        <article class="col-md-3 col-sm-6 col-12">
          <h4><?php echo __('','Help Desk'); ?></h4>
          <ul class="foot-nav">
            <?php if($vals->contact=='Y'){ ?>
            <li><a href="<?php echo VPATH;?>contact/"><?php echo __('contact_us','Contact Us'); ?></a></li>
            <?php } ?>
          </ul>
        </article>
        <?php } ?>
        <?php /*?><a class="twitter-timeline" data-width="250" data-height="300" data-theme="dark" data-link-color="#19CF86" href="https://twitter.com/TwitterDev">Tweets by TwitterDev</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script> <?php */?>
        <?php  if($page_newsletter=='Y'){ ?>
        <article class="col-md-3 col-sm-6 col-12">
          <div class="newsletter">
            <h4><?php echo __('subscribe_','Subscribe'); ?></h4>
            <div class="spacer-10"></div>
            <form>
              <input type="email" name="" id="sub_email" class="form-control" placeholder="<?php echo __('email_address','Email Address'); ?>" />
              <span id="subs_error" style="float: left;margin-top: 0px; margin-bottom: 8px; width: 100%;color:#f00;font-size: 12px; display:none;"><?php echo __('enter_your_email','Enter your email'); ?>!!!</span>
              <button type="button" class="btn btn-site btn-block" id="subscription" value="Subscribe" onclick="getSubscription()"><?php echo __('subscribe','Subscribe'); ?></button>
            </form>
          </div>
        </article>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="copyright text-center">
    <div class="container">
      <p><?php echo $footer_text; ?></p>
    </div>
  </div>
</footer>
<div class="gotop"><i class="fa fa-arrow-up"></i></div>
</div>
<!--page-content end (start in header.php)-->

<?php if($current_page!='home'){?>
<script src="<?=JS?>moment-with-locales.js"></script> 
<script src="<?=JS?>bootstrap-datetimepicker.min.js"></script> 
<?php }?>
<script src="<?php echo ASSETS;?>plugins/cookie-bar/dist/jquery.cookieMessage.min.js"></script> 
<?php if($current_page!='home'){?>
<script type="text/javascript">

	$(function () {

		$('.datepicker').datetimepicker({

		format: 'YYYY-MM-DD',		minDate: new Date()

		/*debug:true*/

	});

	});

</script> 

<?php }?>
<script src="<?=JS?>popper.min.js"></script> 
<script src="<?=JS?>bootstrap.min.js"></script> 
<?php if($this->session->userdata('user')){?>
<script>

var is_open_notification = 0;

jQuery(document).ready(function(){

    setInterval(function(){

		var dataString = '';

	 	 jQuery.ajax({

		 type:"POST",

		 data:dataString,

		 url:"<?php echo base_url();?>dashboard/getNotificationcount/",

		 success:function(return_data)

		 {

			//alert(return_data);

			if(return_data>0)

			{

			jQuery("#head_noti").html(return_data).show();

			jQuery('.count_list').html('');

			jQuery('.count_list').html(return_data);

			jQuery('.count_list').show();

			}else{

			jQuery("#head_noti").hide();

			}

		 }

		});

	}, 3000);		

	

	setInterval(function(){		

	var dataString = '';	 	 

	jQuery.ajax({		

		type:"POST",		

		data:dataString,		 

		url:"<?php echo base_url();?>dashboard/getMessagecount/",		 

		success:function(return_data){			

			/*alert(return_data);*/			

			if(return_data>0){				

				jQuery("#msg_count").html(return_data).show();			

			}else{				

				jQuery("#msg_count").hide();			

			}		 

		}		

	});	

	}, 30000);	

	

	setTimeout(function(){

		var matches=[];

		 jQuery('.notifid').each(function() {

		 	if(jQuery(this).hasClass('unread')){

				matches.push(jQuery(this).val());

			}

		

		});

	var dataString = 'notifid='+matches;

	 	 jQuery.ajax({

		 type:"POST",

		 data:dataString,

		 url:"<?php echo base_url();?>dashboard/updatenotification/",

		 success:function(return_data)

		 {

			/*alert(return_data);*/

			if(return_data>0)

			{

				jQuery('.notifbox').removeClass('notif_active');

			}

		 }

		});

		

	}, 6000);





	

jQuery( "li.headnotification" ).on('click',function(e) {

	e.stopPropagation();

console.log(is_open_notification);

if(is_open_notification > 0){

	jQuery(".header-notifications-dropdown").fadeOut();

	is_open_notification = 0;

}else{

	

is_open_notification = 1;	

if(jQuery(".headnotification").length){

var positionright=jQuery(".headnotification").position();



var head_noti= document.getElementById("head_noti").offsetWidth;

if(head_noti>0){

var mimx=215+parseFloat(head_noti);

}else{

var mimx=245;

}

var l=parseFloat(positionright.left)-parseFloat(mimx);

jQuery('.header-notifications-dropdown').css('left',l+"px");

}

jQuery('.notiH').html(' <li><a href="#" class="">Loading...</a></li>');

		jQuery.ajax({

		 type:"POST",

		 url:"<?php echo base_url();?>dashboard/getnotification/",

		 success:function(return_data)

		 {

			

				jQuery('.notiH').html(return_data);

				jQuery('.header-notifications-dropdown').show();

			

		 }

		});

}

		

});

 jQuery('.sidebar-close-alt').click(function(e) {

		jQuery(".quicknav").fadeOut();

		});

jQuery('.toggle-leftbar img').click(function(e) {

		jQuery(".quicknav").fadeIn();

		});

jQuery('.toggle-leftbar').click(function(e) {

	if(jQuery(".profile-imgEcnLi").length){

var positionright=jQuery(".profile-imgEcnLi").position();

/* console.log(positionright);



console.log(head_noti); */



var mimx=297;

var l=parseFloat(positionright.left)-parseFloat(mimx);

jQuery('.profileSe').css('left',l+"px");

}

		jQuery(".profileSe").fadeIn();

		})	

});

jQuery(document).click(function(e) {

if(!jQuery(e.target).is('.toggle-leftbar') && jQuery('.profileSe').has(e.target).length=== 0) {

jQuery(".profileSe").fadeOut();

}



is_open_notification = 0;

 /* jQuery(".notiH").fadeOut(); */

jQuery('.header-notifications-dropdown').hide();



if(!jQuery(e.target).is('.headnotification a') && jQuery('.notiH').has(e.target).length=== 0) {

/* jQuery(".notiH").fadeOut();

is_open_notification = 0;

console.log(is_open_notification); */

}

})



</script>
<?php }?>
<?php

      if($current_page=='jobdetails')

	  {

	  ?>
<script type="text/javascript" src="<?php echo ASSETS;?>js/new_ajaxfileupload.js"></script>
<?php

	  }

	  ?>
<?php

      if($current_page=='dashboard' || $current_page=="talentdetails")

	  {

	  ?>

<!--<script src="<?php echo VPATH?>assets/js/mootools-1.2.1-core-yc.js" type="text/javascript"></script> 

<script src="<?php echo VPATH?>assets/js/mootools-1.2-more.js" type="text/javascript"></script> 

<script src="<?php echo VPATH?>assets/js/jd.gallery.js" type="text/javascript"></script> 

<script type="text/javascript">

			function startGallery() {

				var myGallery = new gallery($('myGallery'), {

					timed: true

				});

			}

			window.addEvent('domready',startGallery);

		</script>-->

<?php

		}

		if($current_page=='editprofile_professional' || $current_page=='postjob' || $current_page=='editportfolio' || $current_page=='addportfolio')

		{

				if($current_page!='postjob'){

		?>

<!--<script type="text/javascript" src="<?php echo JS;?>jquery.min.js"></script>-->

<? }?>
<script type="text/javascript" src="<?php echo JS;?>ajaxfileupload.js"></script>
<?php

		}

      ?>




<?php
$pagemethod=$this->router->fetch_method();
$pageclass=$this->router->fetch_class();
if($pageclass=='user' && $pagemethod=='index'){
	$footerjs=array('superfish.js','jquery.gmap.min.js','custom.js'); 
}else{
 	$this->minify->enabled = FALSE;
	$footerjs=array('superfish.js', 'tytabs.js','jquery.gmap.min.js','circularnav.js','imagesloaded.pkgd.min.js','jflickrfeed.js','waypoints.min.js','spectrum.js','custom.js'); 
 }
$this->minify->js($footerjs,'footer');
echo $this->minify->deploy_js(true, 'footer.min.js','footer');
?>

<script>

	var $ = jQuery;

	/*$(function() {



		$( "#datepicker_from" ).datepicker({



			maxDate: new Date(),

			

			showOn: "button",



			buttonImage: "<?php echo ASSETS;?>images/caln.png",



			buttonImageOnly: true



		});



	});



	$(function() {



		$( "#datepicker_to" ).datepicker({



			showOn: "button",



			buttonImage: "<?php echo ASSETS;?>images/caln.png",



			buttonImageOnly: true



		});



	});

	

	$(function() {



		$( "#dep_date" ).datepicker({



			maxDate: new Date(),

			

			showOn: "button",



			buttonImage: "<?php echo ASSETS;?>images/caln.png",



			buttonImageOnly: true



		});



	});

	

	$(function() {



		$( ".mdt" ).datepicker({

			

			minDate: new Date(),

			

			showOn: "button",



			buttonImage: "<?php echo ASSETS;?>images/caln.png",



			buttonImageOnly: true



		});



	});*/

	

	function getSubscription(){ 

	     if($("#sub_email").val()==""){ 

		   $("#subs_error").show();

		 }

		 else{ 

			 var dataString = 'email='+$("#sub_email").val();

			 

			  $.ajax({

				 type:"POST",

				 data:dataString,

				 url:"<?php echo VPATH;?>user/newsletterSubscription",

				 success:function(return_data){

					  if(return_data== '1'){

						$("#subs_error").text("<?php echo __('subscription_successful','Thank you. Your newsletter subscription is successful.'); ?>");  

						$("#subs_error").css("color","#FFFFFF");

						$("#subs_error").show();

						$("#sub_email").val('');

					  }

					  else if(return_data== '2'){ 

						$("#subs_error").text("<?php echo __('subscription_failed','Sorry..! Unable to process your request.'); ?>");  

						$("#subs_error").show();					  

					  }

					  else if(return_data== '3'){ 

						$("#subs_error").text("<?php echo __('alert_email_exist','Sorry..! This Email Id already exist.'); ?>");  

						$("#subs_error").show();					  

					  }

					   else if(return_data== '4'){ 

						$("#subs_error").text("<?php echo __('alert_valid_email','Enter a valid email.'); ?>");  

						$("#subs_error").show();					  

					  }

					  else{ 

    					  $("#subs_error").show();	

					  }

				 }

			  });		   

		   

		   

		 }

	  }

	

	

	</script> 

<!--<script type="text/javascript">

    var tooltipObj = new DHTMLgoodies_formTooltip();

    tooltipObj.setTooltipPosition('right');

    tooltipObj.setPageBgColor('#EEEEEE');

    tooltipObj.setTooltipCornerSize(15);

    tooltipObj.initFormFieldTooltip();

</script>-->
<?php if($current_page!='home'){?>

<script src="<?php echo JS;?>select2.min.js"></script> 
<script type="text/javascript">

function select2load(){

//$(".select2-selection__choice").remove(); // clear out values selected

}

</script> 
<?php }?>
<script>

function changeLang(ele,lang){

	//alert(lang);

	$.ajax({

		url:"<?php echo base_url('user/changeLanguage'); ?>",

		type:"post",

		dataType:"JSON",

		data : {language:lang},

		success : function(data){

			if(data.status==1){

				 //$(this).parent().parent().prev().html($(this).html() + '<span class="caret"></span>');    

				location.reload();

			}

		}

	});

}


$.cookieMessage({
	mainMessage: 'This website uses cookies. By using this website you consent to our use of these cookies. For more information visit our <a href="<?php echo base_url('information/info/privacy_policy');?>" target="_blank">Privacy Policy</a>. ',
	expirationDays: 30,
	cookieName: 'cookieMessage',
	acceptButton: 'Got It !'


});

</script>
</body></html>