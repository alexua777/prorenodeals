<?php echo $breadcrumb;?>
            
<script type="text/javascript">

	function loginFormPost(){
	  FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>login/check",'member_logform');
        }
	
	function registerFormPost(){
	  FormPost('#submit-ckck',"<?=VPATH?>","<?=VPATH?>signup/check",'member_register');
        }
		
	function Kazi(id){
		$('#'+id+'Focus').show();
	}
	function Nasim(id){
		$('#'+id+'Focus').hide();
	}


</script>               
            
            
<script src="<?=JS?>mycustom.js"></script> 

<div class="container">
<div class="row">
 
 <!-- Sidebar End -->
 <div class="col-md-9 col-sm-8 col-xs-12">
    
                        
<!--Member Information Start-->   
<div class="profile_right">
<h1><a href="javascript:void(0)" class="selected">Member Information</a></h1>
<div class="editprofile">
<div style="clear:both; height:15px;"></div>
<a style="cursor: pointer;" class="facebott"><img src="<?php echo VPATH;?>assets/images/facebott.png" alt="" title=""></a>
<a style="cursor: pointer;" class="linkedbott"><img src="<?php echo VPATH;?>assets/images/linkedbott.png" alt="" title=""></a>
<div style="clear:both; height:15px;"></div>


<div class="mainacount" id="login_frm">
<?php
if($this->session->flashdata('log_eror'))
{
?>
<span class="error-msg5 error alert-error alert"><?php echo $this->session->flashdata('log_eror');?></span>
<?php	
}
?>
<div class="success alert-success alert" style="display:none">Login Successful. Proceed to Next</div> 
<?php
    $attributes = array('id' => 'member_logform','class' => 'reply','role'=>'form','name'=>'logform','onsubmit'=>"disable");
    echo form_open('', $attributes);
?>  
<span id="agree_termsError" class="error-msg3 error alert-error alert" style="display:none"></span>

        <div class="acount_form">
            <p>User/email :</p>
            <input type="text" id="username" name="username" value="<?php echo $this->session->flashdata("mail");?>" class="acount-input"   />
            <div class="focusmsg" id="usernameFocus" style="display:none">Enter User Name </div>
            <span id="usernameError" class="error-msg3"></span>
        </div>
        <div class="acount_form">
            <p>Password :</p>
            <input type="password" value="" name="password" id="password" class="acount-input"   />
            <div class="focusmsg" id="passwordFocus" style="display:none">Enter Your Valid Password  </div>
            <span id="passwordError" class="error-msg3"></span>
        </div>

        <div class="acount_form">
            <div class="masg3">
                <input type="button" name="Login" class="btn-normal btn-color submit bottom-pad2" value="Login" onclick="loginFormPost()" id="submit-check">
                <h2 style="width:100%">New user ? <a href="javascript:void(0)" onclick="showsignup()" >Register</a> here</h2>
             <h2 style="color:#F00">   <a href='<?php echo VPATH;?>forgot_pass' >Forgot Password ?</a></h2>
            </div>
        </div>
</form>    
</div>



<div class="mainacount" id="signup_frm" style="display: none;"><div style="clear:both; height:12px;"></div>
<div class="success alert-success alert" style="display:none">Registration Successful.</div> 
<?php
$attributes = array('id' => 'member_register','class' => 'reply','role'=>'form','name'=>'register','onsubmit'=>"disable");
echo form_open('', $attributes);

$smail=$this->session->flashdata("mail");
$stitle= $this->session->flashdata("title");       
        

$this->session->set_flashdata('stitle',$stitle);
$this->session->set_flashdata('smail',$smail);
?>
    
<div class="acount_form"><p>First Name : </p>
    <input type="text" value="" name="fname" id="fname" class="acount-input"   />
     <div class="focusmsg" id="fnameFocus" style="display:none">Enter Your First Name </div>
  <span class="error-msg3" id="fnameError"></span>
</div>
<div class="acount_form"><p>Last Name : </p>
    <input type="text" value="" name="lname" id="lname" class="acount-input"   />
    <div class="focusmsg" id="lnameFocus" style="display:none">Enter Your Last Name </div>
  <span class="error-msg3" id="lnameError"></span>
</div>
<div class="acount_form"><p>Username : </p>
    <input type="text" value="" name="regusername" id="regusername" class="acount-input"   />
     <div class="focusmsg" id="regusernameFocus" style="display:none">Enter User Name </div>
  <span class="error-msg3" id="regusernameError"></span>
</div>
<div class="acount_form"><p>Email : </p>
    <input type="text" value="<?php echo $smail;?>" name="email" id="email" class="acount-input"   />
     <div class="focusmsg" id="emailFocus" style="display:none">Enter Valid Email Id </div>
  <span class="error-msg3" id="emailError"></span>
</div>

<div class="acount_form"><p>Confirm Email : </p>
    <input type="text" value="<?php echo $stitle;?>" name="cnfemail" id="cnfemail" class="acount-input"   />
     <div class="focusmsg" id="cnfemailFocus" style="display:none">Enter Confirm Email Id </div>
  <span class="error-msg3" id="cnfemailError"></span>
</div>

<div class="acount_form"><p>Password : </p>
    <input type="password" value="" name="regpassword" id="regpassword" class="acount-input"   />
     <div class="focusmsg" id="regpasswordFocus" style="display:none">Enter Password </div>
  <span class="error-msg3" id="regpasswordError"></span>
</div>
<div class="acount_form"><p>Confirm Password : </p>
    <input type="password" value="" name="cpassword" id="cpass" class="acount-input"   />
     <div class="focusmsg" id="cpassFocus" style="display:none">Enter Confirm Password </div>
  <span class="error-msg3" id="cpassError"></span>
</div>


<div class="acount_form"><p>City : </p>
    <select required="" name="city" id="city" class="acount-input"   />
    <option value="">Please select</option>
	    <option value="Abeokuta">Abeokuta</option>
        <option value="Bama">Bama</option>
        <option value="Bauchi">Bauchi</option>
        <option value="Bida">Bida</option>
        <option value="Buguma">Buguma</option>
        <option value="Dutse">Dutse</option>
        <option value="Funtua">Funtua</option>
        <option value="Gboko">Gboko</option>
        <option value="Ibadan">Ibadan</option>
        <option value="Ife">Ife</option>
        <option value="Ikot Ekpene">Ikot Ekpene</option>
        <option value="Ila">Ila</option>
        <option value="Ilesa">Ilesa</option>
        <option value="Kaduna">Kaduna</option>
        <option value="Kano">Kano</option>
        <option value="Katsina">Katsina</option>
        <option value="Lagos">Lagos</option>
        <option value="Maiduguri">Maiduguri</option>
        <option value="Makurdi">Makurdi</option>
        <option value="Minna">Minna</option>
        <option value="Okene">Okene</option>
        <option value="Okigwe">Okigwe</option>
        <option value="Okpoko">Okpoko</option>
        <option value="Onitsha">Onitsha</option>
        <option value="Owerri">Owerri</option>
        <option value="Port Harcourt">Port Harcourt</option>
        <option value="Sagamu">Sagamu</option>
        <option value="Sapele">Sapele</option>
        <option value="Sokoto">Sokoto</option>
        <option value="Uyo">Uyo</option>
        <option value="Warri">Warri</option>
        <option value="Zaria">Zaria</option>
        </select>
         <div class="focusmsg" id="cityFocus" style="display:none">Select City </div>
  <span class="error-msg3" id="cityError"></span>
</div>

<div class="acount_form">
    <p>
<iframe src="<?php echo VPATH;?>login/create_captcha" id="captcha" height="80" width="230"> </iframe><br/>


<!-- CHANGE TEXT LINK -->
<a href="#" onclick="
    document.getElementById('captcha').src='<?php echo VPATH;?>login/create_captcha';
    document.getElementById('captcha-form').focus();"
    id="change-image">Not readable? Change text.</a><br/></p>


<input type="text" name="captcha" id="captcha-form" autocomplete="off" class="acount-input"   />
 <div class="focusmsg" id="captcha-formFocus" style="display:none">Enter Valid Captcha </div><br/>
<span id="captchaError" class="error-msg5"></span>
</div>

<div class="acount_form"><div class="masg3"><input type="button" class="btn-normal btn-color submit bottom-pad2" onclick="registerFormPost()" id="submit-ckck" value="Submit">
<h2 style="width:100%">Already Registered ? <a href="javascript:void(0)" onclick="showlogin()">Login</a> here</h2></div>
</div>
</form>
</div>
</div>

</div>
<!--Member Information End-->         
                        
                        
<script>
  function showsignup(){ 
    $("#signup_frm").show();
    $("#login_frm").hide();
  }
  function showlogin(){ 
    $("#signup_frm").hide();
    $("#login_frm").show();
  }
</script>
 
                   
 </div>
 <!-- Left Section End -->
</div>
</div>               
