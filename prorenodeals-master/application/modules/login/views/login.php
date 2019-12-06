<!-- Content Start -->

<script type="text/javascript">

 var RecaptchaOptions = {

    theme : 'white'

 };

 </script>

<script type="text/javascript">



function loginFormPost(){

//	alert('alert');

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>login/check",'logform');



}

</script>
<script src="<?=JS?>mycustom.js"></script>
<link rel="stylesheet" href="css/formValidation.css"/>
<script src="js/formValidation.js"></script>
<script src="js/bootstrap.validate.js"></script>
<section class="sec">
<div class="container">
    <aside class="accessPanel">
       <?php echo $breadcrumb;?>
      <div class="general-form">
        
        <?php
		 $this->load->helper('cookie');
		$attributes = array('id' => 'logform','class' => 'form-horizontal','role'=>'form','name'=>'logform','onsubmit' =>"loginFormPost();return false;");

		echo form_open('', $attributes);
		
		$cookie_str = get_cookie('r_m_i');
		if($cookie_str){
			$cookie_info = unserialize($cookie_str);
		}else{
			$cookie_info = array();
		}

		  ?>
        <div id="agree_termsError" class="error-msg5 error alert-error alert alert-danger" style="display:none"></div>
        <input type="hidden" name="refer" value="<?php echo $refer;?>" readonly="readonly"/>
        <div class="form-group">
            <label for="" class="control-label"><?php echo __('login_email_id','Email ID'); ?>:</label>
            <input type="text" class="form-control" value="<?php echo !empty($cookie_info['uname']) ? $cookie_info['uname'] : '';?>" name="username">
            <span id="usernameError" class="error-msg13"></span>
        </div>
        <div class="form-group">
            <label for="" class="control-label"><?php echo __('login_password','Password'); ?>:</label>
            <input type="password" class="form-control" value="<?php echo !empty($cookie_info['pwd']) ? $cookie_info['pwd'] : '';?>" name="password">
            <span id="passwordError" class="error-msg13"></span> 
        </div>
        <div class="form-group">
        	<div class="radio-inline">
            <input type="checkbox" class="magic-checkbox" value="1" name="remember_me" id="remember_me" <?php echo !empty($cookie_info) ? 'checked' : '';?>>
            <label for="remember_me"><?php echo __('login_remember_me','Remember Me') ?> </label>       
            </div>             
            <a href="<?php echo VPATH;?>forgot_pass" class="float-right"><?php echo __('login_forget_passowrd','Forgot Password?'); ?></a> 
        </div>
        <button class="btn btn-site btn-block"><?php echo __('login_sign_in','Sign In'); ?></button>
        </form>
        <div class="social-login-separator"><span>or</span></div>
        <div class="social-login-buttons row">        
            <div class="col-sm-6">
				<button class="btn btn-block facebook-login" onclick="facebook_login();" id="login-button2"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
            </div>
        	<div class="col-sm-6">
          		<button id="login-button" class="btn btn-block google-login"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
            </div>
        </div>
      </div>
    </aside>
</div>
</section>
<style>
.breadcrumb {
	display:none
}
</style>
<?php 
$this->load->view('google_login');
$this->load->view('facebook_login');
?>

<script type="text/javascript">

$(document).ready(function() {

    $('#signInForm').formValidation({

        framework: 'bootstrap',

        icon: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        

        fields: {

                

            username: {

                validators: {

                    notEmpty: {

                        message: '<?php echo __('login_username_field_required','The username or email id is required'); ?>'

                    },

                    stringLength: {

                        min: 6,

                        max: 20,

                        message: '<?php echo __('The username must be more than 6 and less than 12 characters long','The username must be more than 6 and less than 12 characters long'); ?>'

                    },

                    regexp: {

                        regexp: /^[a-zA-Z0-9_\.]+$/,

                        message: '<?php echo __('login_username_field_required_alphabetic_number','The username can only consist of alphabetical, number, dot and underscore'); ?>'

                    }

                }

            },

            /*email: {

                validators: {

                    notEmpty: {

                        message: 'The email address is required'

                    },

                    emailAddress: {

                        message: 'The input is not a valid email address'

                    }

                }

            },*/

            password: {

                validators: {

                    notEmpty: {

                        message: '<?php echo __('login_password_required','The password is required'); ?>'

                    },

					

                    different: {

                        field: 'username',

                        message: '<?php echo __('login_password_username_required','The password cannot be the same as username'); ?>'

                    },

					

				}

				},				

					

        }

    });



        // Reset form

        $('#signUpForm').formValidation('resetForm', true);

    });



</script> 
