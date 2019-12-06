<?php $this->load->view('inc/common_file');?>

<!-- Le javascript

    ================================================== -->

<!-- Important plugins put in all pages -->

<script src="<?= JS ?>popper.min.js"></script>
<script src="<?= JS ?>bootstrap.min.js"></script>
<script src="<?=JS?>plugins/core/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?=JS?>plugins/core/jrespond/jRespond.min.js"></script>
<script src="<?=JS?>jquery.genyxAdmin.js"></script>

<!-- Form plugins -->

<script src="<?=JS?>plugins/forms/uniform/jquery.uniform.min.js"></script>
<script src="<?=JS?>plugins/forms/validation/jquery.validate.js"></script>
<script src="<?=JS?>jquery.form.js"></script>

<!-- Init plugins -->

<script src="<?=JS?>app.js"></script><!-- Core js functions -->

<script src="<?=JS?>pages/login.js"></script><!--Init plugins only for page -->
<style>
html {
	background-color:#52bf28;
	background: radial-gradient(#fddb3c 20%, #52bf28 100%);
}

body {
	background:none
}
.login-wrapper > div, .login-control > a {
	display: none;
}
.login-wrapper > .active, .login-control > a.active {
	display: block;
}
</style>
</head>
<body>
<div class="container-fluid">
  <div id="login">
    <div class="login-wrapper">
    <span class="text-center d-block"><img src="<?php echo IMAGE; ?>logo.png" alt="Admin" class="logo" /></span>
      <?php /*?><a class="navbar-brand" href="dashboard.html">

           <?=ucwords(SITE_TITLE)?></a><?php */?>
      <div id="log" class="active">
        <?php 

            echo validation_errors('<label class="error">', '</label>');

                        

            $attributes = array('role' => 'form','id' => 'login-form','class' => 'form-horizontal');

            echo form_open('login/loginprocess', $attributes);

                                                                    

			$remember = '';

			if(DEMO)

			{

				$username="admin";

				$password="adm1n";	

			}

			else

			{

			if(isset($username) && $username!='' && $password!='')

			{

				$remember= 'checked="checked"';

			}

				

			if(set_value('username')!='')

			{

				$username = set_value('username');

			}

			

			if(set_value('password')!='')

			{

				$password = set_value('password');

			}

			}

                            

            ?>
        
        <!--<h3 class="center text-uppercase">Login</h3>-->
        
        <?php if($error){ echo "<div class='text-center mb-2'><label class='error' id='previewregister'>".$error."</label></div>"; } ?>
        <div class="form-group">
            <div class="input-group input-group-lg mb-3">
              <input class="form-control" type="text" name="username" id="username" placeholder="Username" value="<?php echo htmlentities($username); ?>">
              <div class="input-group-append"> <span class="input-group-text"><i class="la la-user _125x"></i></span> </div>
            </div>
        </div>
        <!-- End .control-group  -->
        
        <div class="form-group">
        	<input type="hidden" name="login_val" id="login_val" value="0"/>
            <div class="input-group input-group-lg mb-3">
              <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>">
              <div class="input-group-append"> <span class="input-group-text"><i class="la la-key _125x"></i></span> </div>
            </div>
            <?php /*?><div class="custom-control custom-checkbox">

                  <input type="checkbox" class="custom-control-input" id="remember" value="1" name="remember" <?php echo $remember;?>>

                  <label class="custom-control-label" for="remember">Remember me?</label>

                </div><?php */?>
        </div>
        <!-- End .control-group  -->
        
        <div class="form-group">
            <button id="loginBtn" type="submit" class="btn btn-site btn-block">Login</button>
        </div>
        </form>
        <p class="text-center"><a href="javascript:void(0)" class="active toggleLogin" data-target="#forgot">Forgot your password?</a></p>
      </div>
      <div id="forgot">
        <? 

        echo validation_errors('<label class="error">', '</label>');

        echo "<label class='error' id='previewrforgot'>".$error."</label>";

        

        $attributes = array('id' => 'forgot-form','class' => 'form-horizontal');

        echo form_open('jobbid_v2/login/forgotpass', $attributes);

        ?>
        
        <!--<h3 class="center text-uppercase">Forgot password</h3>-->
        
        <div class="form-group">
            <div class="input-group input-group-lg mb-3">
              <input class="form-control" type="text" name="email" id="email-field" placeholder="Your email">
              <input type="hidden" name="forgot_val" id="forgot_val" value="0"/>
              <div class="input-group-append"> <span class="input-group-text"><i class="icon20 i-envelop-2"></i></span> </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" id="forgotBtn" class="btn btn-site btn-primary">Recover my password</button>
        </div>
        </form>
        <p class="text-center"><a class="toggleLogin" href="javascript:void(0)" data-target="#log">Login</a></p>
      </div>
    </div>
  </div>
  <div class="text-center login-control"></div>
</div>
<script>

	$('.toggleLogin').click(function(){

		var ele = $(this);

		var targetEle = ele.data('target');

		

		$('.login-wrapper > div').removeClass('active');

		$(targetEle).addClass('active');

		

	});

</script>
</body>
</html>