<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- Content Start -->
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>

<script type="text/javascript">	

function registerFormPost(){

$('.error-msg').html('');
FormPost('#submit-ckck',"<?=VPATH?>","<?=VPATH?>signup/check",'register');
grecaptcha.reset(); /* resetting captha form */
/* Recaptcha.reload(); */
}
function checkuname(user)
 {
	var dataString = 'user='+user;
	$.ajax({
		type:"POST",
		data:dataString,
		url:"<?php echo VPATH;?>signup/usercheck",
		success:function(return_data){
		//  alert(return_data);
			if(return_data==0)
			{
			 //  alert('run');
			  $("#uisname").show();
			  $("#uisname").text("<?php echo __('signup_error_username_exist','This username is already in use, please try another'); ?>");
			  $( "#regusername" ).addClass( "error" );				  
			}else
			{
				$("#uisname").hide();
				$( "#regusername" ).removeClass( "error" );	
				$( "#regusername" ).addClass( "success" );
			}
		}
		})
 }
 function checkemail(email)
 {
	var dataString = 'email='+email;
//	alert(dataString);
	$.ajax({
		type:"POST",
		data:dataString,
		url:"<?php echo VPATH;?>signup/emailcheck",
		success:function(return_data){			
		//alert(return_data);
			if(return_data==0)
			{
			  $("#umail").show();
			  $("#umail").text("<?php echo __('signup_error_email_exist','This email is already in use, please try another'); ?>");
			  $( "#email" ).addClass( "error" );				  
			}else
			{
				$("#umail").hide();
				$( "#email" ).removeClass( "error" );	
			   $( "#email" ).addClass( "success" );
			}
		}
		})
 }
</script>
<script src="<?=JS?>mycustom.js"></script>

<div class="profile_right">
  <?php
if($this->session->flashdata('log_eror'))
{
?>
  <div class="error-msg5 error alert-error alert"><?php echo $this->session->flashdata('log_eror');?></div>
  <?php	
}
?>
  <?php
if($this->session->flashdata('refer_succ_msg'))
{
?>
  <div class="success alert-success alert"><?php echo $this->session->flashdata('refer_succ_msg');?></div>
  <?php	
}
?>
  <?php
/* $attributes = array('id' => 'logform','class' => 'reply','role'=>'form','name'=>'logform','onsubmit'=>"disable");
echo form_open('', $attributes); */
?>
  <span id="agree_termsError" class="error-msg5 error alert-error alert" style="display:none"></span>
  <?php
if(DEMO=='Y')
{
$username="pritamnath@originatesoft.com";
$password="123456";	
}
else
{
$username="";
if(set_value('username'))
{
	$username=	set_value('username');
}
$password="";	
}
?>
  <!--LoginLeft Start--> 
  
</div>


<div class="white-bg">
<div class="container">
      
</div>
</div>
<!--ProfileRight Start-->
<div class="profile_right" style="margin-top:0px !important;">
  <div class="success alert-success alert" style="display:none"></div>  
  <div id="signupForm">
    <section class="sec">
      <div class="container">
          <aside class="accessPanel">
          	<?php echo $breadcrumb;?>
            <div class="success alert-success alert" style="display:none"></div>            
            <div class="general-form"> 
              <?php $attributes = array('id' => 'register','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit' =>"registerFormPost();return false;");
echo form_open('', $attributes);
?>
            <div class="btn-group btn-group-justified" data-toggle="buttons">
              <label class="btn btn-success active" id="employee" value="employee" onclick="setAccountType('E')">
                <input type="radio" name="foo"> <?php echo __('signup_as_customer','Signup as Customer'); ?> 
              </label>
              <label class="btn btn-success" id="freelancer" value="freelancer" onclick="setAccountType('F')">
                <input type="radio" name="foo"> <?php echo __('signup_contractor','Singup as Contractor'); ?> 
              </label>
            </div>
            
              <div class="row">
                <div class="col-sm-6 col-12">
                  <div class="form-field">
                    <label for="" class="control-label"><?php echo __('signup_first_name','First Name'); ?></label>
                    <input type="text" class="form-control" value="<?php echo set_value('fname');?>" id="fname" name="fname">
                    <span id="fnameError" class="error-msg13"></span> </div>
                </div>
                <div class="col-sm-6 col-12">
                  <div class="form-field">
                    <label for="" class="control-label"><?php echo __('signup_last_name','Last Name'); ?></label>
                    <input type="text" class="form-control" value="<?php echo set_value('lname');?>" id="lname" name="lname">
                    <span id="lnameError" class="error-msg13"></span> </div>
                </div>
              </div>
              <div id="freelancer_component_wrapper"></div>
              <div class="form-group" hidden>
                <label for="" class="control-label"><?php echo __('signup_username','Username'); ?>:</label>
                <input type="text" class="form-control" value="<?php echo set_value('regusername');?>" id="regusername" name="regusername" onblur="checkuname(this.value)">
                <span id="uisname" style="display:none;" class="errormsg13 rerror"></span> <span id="regusernameError" class="error-msg13"></span> </div>
              <div class="form-group">
                <label for="" class="control-label"><?php echo __('signup_email_id','Email ID'); ?>:</label>
                <input type="email" class="form-control" value="<?php echo set_value('email');?>" id="email" name="email" onblur="checkemail(this.value)">
                <span id="umail" style="display:none;" class="errormsg13 rerror"></span> <span id="emailError" class="error-msg13"></span> </div>
              <div class="form-group" hidden>
                <label for="" class="control-label"><?php echo __('signup_conf_email_id','Confirm Email ID'); ?>:</label>
                <input type="email" class="form-control" value="" id="cnfemail" name="cnfemail">
                <span id="cnfemailError" class="error-msg13"></span> </div>
              <div class="form-group">
                <label for="" class="control-label"><?php echo __('signup_password','Password'); ?>:</label>
                <input type="password" class="form-control" value="" id="regpassword" name="regpassword">
                <span id="regpasswordError" class="error-msg13"></span> </div>
              <div class="form-group">
                <label for="" class="control-label"><?php echo __('signup_conf_password','Confirm Password'); ?>:</label>
                <input type="password" class="form-control" value="" id="cpassword" name="cpassword">
                <span id="cpasswordError" class="error-msg13"></span> </div>
              <?php
		$default_country = 'CAN';
		?>
              <div class="form-group" hidden>
                <label for="" class="control-label"><?php echo __('signup_country','Country'); ?>:</label>
                <select class="form-control" id="country" name="country" onchange="citylist(this.value)">
                  <?php  print_select_option($country_list, 'code', 'name', $default_country); ?>
                </select>
                <span id="countryError" class="error-msg13"></span>
                <input type="hidden" name="country" value="<?php echo $default_country;?>"/>
              </div>
              <?php 
		$city_list = get_country_city($default_country);
		?>
              <div class="form-group">
                <label for="" class="control-label">City:</label>
                <select class="form-control" id="city" name="city">
                  <option> --<?php echo __('signup_select_city','Select City') ?>--</option>
                  <?php  print_select_option($city_list, 'city_id', 'name','4080'); ?>
                </select>
                <span id="cityError" class="error-msg13"></span> </div>
              <div class="g-recaptcha" data-sitekey="<?php echo GOOGLE_CAPTCHA_SITE_KEY;?>"></div>
              <div> <span id="captchaError" class="error-msg13 rerror"></span> </div>
              <div class="form-group">
                <div class="checkbox checkbox-inline">
                  <input class="magic-checkbox" type="checkbox" name="termsandcondition" value="Y" id="termsandcondition">
                  <label for="termsandcondition" style="display:inline"><?php echo __('signup_tc_conf','By registering you confirm that you accept the') ?> &nbsp;</label>
				  
				  
				  <span id="contractor-terms" style="display:none;"> <!--<a href="<?php echo VPATH;?>information/info/terms_condition" target="_blank"><?php echo __('signup_terms_&_conditions','Terms & Conditions') ?></a>  ,--> <a href="<?php echo VPATH;?>information/info/service_agreement_contractors" target="_blank">Contractor Agreement</a> , <a href="<?php echo VPATH;?>information/info/claims_resolution_policy" target="_blank">Claim policy</a> &amp; <a href="<?php echo VPATH;?>information/info/privacy_policy" target="_blank"><?php echo __('signup_privecy_policy','Privacy Policy'); ?></a>. </span>
				  
				  <span id="employer-terms"> <!--<a href="<?php echo VPATH;?>information/info/terms_condition" target="_blank"><?php echo __('signup_terms_&_conditions','Terms & Conditions') ?></a>  ,--> <a href="<?php echo VPATH;?>information/info/service_agreement_clients" target="_blank">Client Agreement</a> ,  <a href="<?php echo VPATH;?>information/info/claims_resolution_policy" target="_blank">Claim policy</a> &amp; <a href="<?php echo VPATH;?>information/info/privacy_policy" target="_blank"><?php echo __('signup_privecy_policy','Privacy Policy'); ?></a>. </span>
                 
				  
				  </div>
                <br />
                <span id="termsandconditionError" class="error-msg13 rerror"></span> </div>
              <button type="submit" id="submit-ckck" class="btn btn-site btn-block"><?php echo __('signup_register','Register'); ?></button>
              <input type="hidden" name="account_type" id="account_type" value="E" />
              </form>
              <div class="social-login-separator"><span>or</span></div>
              <div class="social-login-buttons row">
                <div class="col-sm-6">
                  <button class="btn btn-block facebook-login" onclick="facebook_login();" id="login-button2"><i class="icon-brand-facebook-f"></i> <?php echo __('signup_register','Register'); ?> via Facebook</button>
                </div>
                <div class="col-sm-6">
                  <button id="login-button" class="btn btn-block google-login"><i class="icon-brand-google-plus-g"></i> <?php echo __('signup_register','Register'); ?> via Google+</button>
                </div>
              </div>
            </div>
          </aside>
      </div>
    </section>
    
    <!--SingupLeft End--> 
  </div>
 
  <?php $this->load->view('facebook_login'); ?>
  <?php $this->load->view('google_login'); ?>  

  <?php /*?><section class="sec signup hidden-xs" id="work_hire">
<div class="container">
<div class="row">
	

	
</div>
</div>  
</section><?php */?>

</div>
<style>
.breadcrumb {
	display:none
}
</style> 
<template id="c-company">
<div>
<div class="form-group">
    <label for="" class="control-label"><?php echo __('signup_company','Company Name'); ?>:</label>
    <input type="text" class="form-control" value="" name="company">
    <span id="companyError" class="error-msg13"></span> 
</div>
<div class="form-group">
    <label for="" class="control-label">Contact Phone No:</label>
    <input type="text" class="form-control" value="" name="phone">
    <span id="phoneError" class="error-msg13"></span> 
</div>
</div>
</template> 

<script>
  function showState(v){ 
	  if(v!="Nigeria"){ 
		  $("#state_div").hide();
	  }
	  else{ 
		$("#state_div").show();
	  }
  }
  function setAccountType(accounttype){
	  $("#account_type").val(accounttype);
	//alert(accounttype);
	  $("#work_hire, #work_hireMobile").hide();
	  $("#signupForm").show();	  	  
	  var comp = null;	  
	  if(accounttype == 'F'){		
		comp = $('#c-company').html();  	
		$('#contractor-terms').show();
		$('#employer-terms').hide();
	  }else{
		$('#contractor-terms').hide();
		$('#employer-terms').show();  
	  }			  
	  $('#freelancer_component_wrapper').html(comp);	
  }
function citylist(country)
{	var dataString = 'cid='+country;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>login/getcity/"+country,
     success:function(return_data)
     {
	 	//alert(return_data);
      	$('#city').html('');
		$('#city').html(return_data);
     }
    });
}


</script>