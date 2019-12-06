 <!-- Content Start -->
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
         <div id="main">

             <?php echo $breadcrumb;?>

    <script type="text/javascript">

	function loginFormPost(){
	
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>affiliate/logincheck",'logform');

    }
	
	function registerFormPost(){
	FormPost('#submit-ckck',"<?=VPATH?>","<?=VPATH?>affiliate/signupcheck",'register');
    }
	
	</script>      

	<script src="<?=JS?>mycustom.js"></script>	

           <!-- Main Content start-->

            <div class="content">

               <div class="container">

                      
                  <div class="row">
                     <div class="sidebar col-lg-12 col-md-3 col-sm-4 col-xs-12">
                        <!-- Left nav Widget Start -->
                        <div class="widget category">
         
 <!--Log In start-->  
                       
<div class="profile_right"><h1>
        <a href="javascript:void(0)" onclick="showdiv('l')" class="selected" id="alogin">Log In</a>
</h1>

<h1>
<a  href="javascript:void(0)" onclick="showdiv('s')" id="asingup">Sign Up</a>
</h1>




<?php
if($this->session->flashdata('log_eror'))
{
?>
<span class="error-msg5 error alert-error alert"><?php echo $this->session->flashdata('log_eror');?></span>
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
	$attributes = array('id' => 'logform','class' => 'reply','role'=>'form','name'=>'logform','onsubmit' =>"loginFormPost();return false;");
	echo form_open('', $attributes);
?>
<span id="agree_termsError" class="error-msg5 error alert-error alert" style="display:none"></span>
                   
<!--LoginLeft Start-->          
   
<div class="editprofile" id="login_div2">

<div class="leftlogin">
<div class="login_form"><p>User Name:
<span>*</span></p><input class="loginput6" id="username" name="username" type="text" value="" tooltipText="Enter Your Name or Email Id"/>
 
<span id="usernameError" class="error-msg13 rerror"></span></div>

<div class="login_form"><p>Password:
<span>*</span></p><input class="loginput6" id="password" name="password" type="password" value="" tooltipText="Enter Your Valid Password" />
 
<span id="passwordError" class="error-msg13 rerror"></span></div>

<div class="login_form"><input type="submit" value="Login" id="submit-check" class="btn-normal btn-color submit  bottom-pad"> 

<a href="<?php echo VPATH;?>affiliate/forgot_pass"> Forgot Password ?</a>

</div>
<div style="clear:both; height:15px;"></div>
</div>
</form>
<!--LoginLeft End--> 





<!--LoginRight Start--> 
<div class="rightlogin"><h2>Welcome to Jobbid.org<br />
<span>The World's Leading Site for Online Work</span></h2>
<div class="logimg">
	
	
	
	
	
</div>
</div>
<!--LoginRight End--> 


</div>






</div>

 <!--Log In End-->  




                        </div>
                        <!-- Left nav Widget End -->
                     </div>
                     <!-- Sidebar End -->
                      
                     <div class="col-lg-12 col-md-9 col-sm-8 col-xs-12">
                       
                        
                    <!--ProfileRight Start-->
                    <div class="profile_right" style="margin-top:0px !important;">
                        <div class="success alert-success alert" style="display:none"></div> 
                    <?php
                    $attributes = array('id' => 'register','class' => 'reply','role'=>'form','name'=>'register','onsubmit' =>"registerFormPost();return false;");
                    echo form_open('', $attributes);
                    ?>    
                    <!--<h1>
                    <a class="selected" href="javascript:void(0)" onclick="showdiv('s')">Sign Up</a>
                    </h1>-->
                    
                    
                    <!--EditProfile Start-->
                    <div class="editprofile" id="signup_div" style="display:none;">
                    
                    <!--SingupLeft Start--> 
                    <div class="leftlogin">
                    
                    
                    <div class="login_form"><p>First Name:
                    <span>*</span></p><input class="loginput6" id="fname" name="fname" type="text" value="<?php echo set_value('fname');?>"  tooltipText="Enter Your First Name" />
                    
                    <span id="fnameError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>Last Name:
                    <span>*</span></p><input class="loginput6" type="text" id="lname" name="lname" value="<?php echo set_value('lname');?>"  tooltipText="Enter Your Last Name" />
                    
                    <span id="lnameError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>User Name:
                    <span>*</span></p><input class="loginput6" id="regusername" name="regusername" type="text" value="<?php echo set_value('regusername');?>" tooltipText="Enter User Name" />
                    
                    <span id="regusernameError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>Email:
                    <span>*</span></p><input class="loginput6" type="email" id="email" name="email" value="<?php echo set_value('email');?>"  tooltipText="Enter Your Valid Email Id"/>
                    
                    <span id="emailError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>Confirm Email:
                    <span>*</span></p><input class="loginput6" type="email" id="cnfemail" name="cnfemail" value=""   tooltipText="Enter Confirm Email Id" />
                    
                    <span id="cnfemailError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>Password:
                    <span>*</span></p><input class="loginput6" id="regpassword" name="regpassword" type="password" value=""  tooltipText="Enter Password" />
                    
                    <span id="regpasswordError" class="error-msg13"></span></div>
                    
                    <div class="login_form"><p>Confirm Password:
                    <span>*</span></p><input class="loginput6" type="password" id="cpassword" name="cpassword" value=""  tooltipText="Enter Confirm Password" />
                    
                    <span id="cpasswordError" class="error-msg13"></span></div>
                    <div class="loginfor_right loginfor2">
                    <?= recaptcha() ?>
                    <span id="captchaError" class=""></span>
                    </div>
                    <div class="loginfor_right"><p><input type="checkbox" name="termsandcondition" value="Y" style="vertical-align:middle"/> By registering you confirm that you accept the 
                                                <a target="_blank" href="<?php echo VPATH;?>information/info/terms_condition"> Terms and Conditions</a>
                                                and 
                                                <a target="_blank" href="<?php echo VPATH;?>information/info/privacy_policy">Privacy Policy</a>
                                                </p>   
                                                <span id="termsandconditionError" class="error-msg_13 rerror"></span>                         
                    </div>
                    
                                                
                    <div class="loginfor_right"> <input type="submit" value="Register" id="submit-ckck" class="btn-normal btn-color submit  bottom-pad"></div>
                      
                    <div style="clear:both; height:15px;"></div>  
                    </div>
                    <!--EditProfile Start-->
                    </form>
                    <!--SingupLeft End-->
                    
                    
                    <!--SingupRight Start--> 
                    <div class="rightlogin">
                    <div class="signtext"><h2>How it works for employer</h2>
                    <div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/postright_bg2.png"></div>
                    </div>
                    
                    
                    <div class="signtext"><h2>How it works for Freelancer</h2>
                    <div class="logimg"><img title="" alt="" src="<?php echo ASSETS;?>images/works_freelancerbg.png"></div>
                    </div>
                    
                    </div>
                    <!--SingupRight End--> 
                    </div>
                    
                    
                    
                    </div>                       
                    <!--ProfileRight Start-->                       
<div class="clearfix"></div>
<?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
        
      if($type=='A'&& $code!=""){ 
?>
<div class="addbox2">
 <?php 
   echo $code;
 ?>
</div>                      
<?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
        <div class="addbox2">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
<div style="clear:both;"></div>
                     </div>
                     <!-- Left Section End -->
                  </div>

               </div>

            </div>

            <!-- Main Content end-->

           

			

            <!-- Our Clients Start-->

            

         </div>

         <!-- Content End -->

    
    <script>
      function showState(v){ 
          if(v!="Nigeria"){ 
              $("#state_div").hide();
          }
          else{ 
            $("#state_div").show();
          }
      }
function citylist(country)
{
	
	var dataString = 'cid='+country;
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

function showdiv(v){ 
  if(v=='s'){ 
    $("#signup_div").show();
    $("#login_div2").hide();
    $("#asingup").addClass("selected");
    $("#alogin").removeClass("selected");
  }
  else if(v=='l'){ 
    $("#login_div2").show();  
    $("#signup_div").hide();
    $("#alogin").addClass("selected");
    $("#asingup").removeClass("selected");    
  }
} 
    </script>