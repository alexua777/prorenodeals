<script type="text/javascript">

function loginFormPost(){

	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>forgot_pass/check",'forgotPass');

}

</script>
<script src="<?=JS?>mycustom.js"></script>
<script src="<?php echo JS;?>formValidation.js"></script>
<script src="<?php echo JS;?>bootstrap.validate.js"></script>

<section class="sec">
  <div class="container">
      <aside class="accessPanel">
        <?php echo $breadcrumb;?>
        <div class="success alert-success alert" style="display:none; position: absolute;"> <?php echo __('forgotpass_new_password_has_been_sent_to_your_email','New password was sent to your email.'); ?></div>
        <?php $attributes = array('id' => 'forgotPass','class' => 'form-horizontal','role'=>'form','name'=>'register','onsubmit'=>"disable");

        echo form_open('', $attributes);

        ?>
        <div class="general-form">
          <h6 class="text-muted"><?php echo __('forgotpass_to_recover_your_password_end_text','To recover your password, enter the email address associated with your account.'); ?></h6>
          <div class="clearfix">&nbsp;</div>
          <div class="form-group">
              <label for="" class="control-label"><?php echo __('forgotpass_email_id','Email ID'); ?>:</label>
              <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo set_value('user_email');?>">
              <span id="agree_termsError" class="rerror"></span> <span id="user_emailError" class="rerror"></span> 
          </div>
          <div class="form-group text-right">
            <?php echo __('forgotpass_go_back_to','Go back to'); ?> <a href="<?php echo VPATH;?>login"><?php echo __('forgotpass_sign_in','Sign In'); ?></a>
          </div>
          <button type="submit" class="btn btn-site btn-block" id="submit-check" onclick="loginFormPost()"><?php echo __('forgotpass_submit','Submit'); ?></button>
        </div>
        </form>
      </aside>
  </div>
</section>
<style>
.breadcrumb {
	display:none
}
</style>
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
<div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
<?php  

 }

  }



?>
<div class="clearfix"></div>
<script type="text/javascript">

$(document).ready(function() {

    $('#forgotPass').formValidation({

        framework: 'bootstrap',

        icon: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        

        fields: {                

            

            user_email: {

                validators: {

                    notEmpty: {

                        message: '<?php echo __('forgotpass_the_email_address_is_required','The email address is required'); ?>'

                    },

                    emailAddress: {

                        message: '<?php echo __('forgotpass_the_input_is_not_a_valid_email_address','The input is not a valid email address'); ?>'

                    }

                }

            }            			

					

        }

    });

   

});



</script>