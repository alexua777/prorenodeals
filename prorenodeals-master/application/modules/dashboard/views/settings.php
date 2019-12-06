<script src="<?=JS?>mycustom.js"></script>
<script>

function setpassword(){ 

 // var f=true;

  if($("#old_pass").val().length<6){

	$("#old_passError").text("<?php echo __('dashboard_setting_password_minimum_charecter','Password Minimum 6 Character'); ?>");

	$("#old_passError").css("color","#FF0000");

  //  f=false;

  }

  else if($("#new_pass").val().length<6){

	$("#new_passError").text("<?php echo __('dashboard_setting_password_minimum_charecter','Password Minimum 6 Character'); ?>");

	$("#new_passError").css("color","#FF0000");

  //  f=false;                        

  } 

  else if($("#confirm_pass").val().length<6){

	$("#confirm_passError").text("<?php echo __('dashboard_setting_password_minimum_charecter','Password Minimum 6 Character'); ?>");

	$("#confirm_passError").css("color","#FF0000");

//    f=false;                        

  } 

 

  else{ 

	FormPost('#update_btn',"<?=VPATH?>","<?=VPATH?>dashboard/changepass",'changepass_frm');
   
  }


} 



// Check for security question Answer

function securityCheck(){

var qus = $("#question").val();
var ans = $("#answer").val();	

if(qus == ''){
$("#questionError").text("<?php echo __('dashboard_setting_please_choose_your_new_security_question','!Please choose your new Security Question'); ?>");

$("#questionError").css("color","#d50000");
}    
else if(ans == ''){

$("#answerError").text("<?php echo __('dashboard_setting_answer_is_required','!Answer is required.'); ?>");

$("#answerError").css("color","#d50000");


}	
else{

 FormPost('#create_btn',"<?=VPATH?>","<?=VPATH?>dashboard/createquestion",'security_question');
 
 var newquestion=$("#question").val();
 console.log(newquestion);
 alert('Data added succesfully');
 var url= "<?php echo current_url();?>";
 //console.log(url);
 window.location.href=url;
}
$("#security_question").get(0).reset()				
$("#create_btn").removeAttr('disabled');
document.getElementById("create_btn").value="Create";
}

function resetAnswer(){
$.ajax({
	url : '<?php echo base_url('dashboard/resetanswer')?>',
	type:'post',
	dataType: 'json',
	success: function(res){
		alert(res.message);
	}
});
//FormPost('#create_btn',"<?=VPATH?>","<?=VPATH?>dashboard/resetanswer",'security_question');

}


</script>

<section id="mainpage">
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('dashboard-left'); ?>
      <aside class="col-lg-10 col-md-9 col-12">
      <?php echo $breadcrumb;?>
      <?php		$succ_msg = get_flash('succ_msg');		$error_msg = get_flash('error_msg');		?>
      <?php if($succ_msg){ ?>
      <div class="alert alert-success alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> <?php echo $succ_msg; ?> </div>
      <?php } ?>
      <?php if($error_msg){ ?>
      <div class="alert alert-danger alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> <?php echo $error_msg; ?> </div>
      <?php } ?>
    
        <div class="card">
        <div class="card-body">
          <?php $user_sess = $this->session->userdata('user'); $login_user_id = $user_sess[0]->user_id; $u_info = get_row(array('select' => 'account_type,featured,featured_till,featured_last_update,featured', 'from' => 'user', 'where' => array('user_id' => $login_user_id)));			if($u_info['featured'] == '1'){			?>
          <div class="alert alert-info text-left"> <strong>Info!</strong> Your profile is upgraded to <span class="label label-success">Featured</span> and is valid till <span class="label label-danger"><?php echo date('d M, Y', strtotime($u_info['featured_till']));?></span> </div>
          <?php } ?>
          <!-- For new user-->
          <?php
		  /*
$attributesSecurity = array('id' => 'security_question','class' => 'form-horizontal securityQuestion','role'=>'form','name'=>'security_question');

echo form_open('', $attributesSecurity);   

?>
          <?php if(!empty($question[0]['question'])){ ?>
          <div class="form-group">
            <div class="col-xs-12">
              <label><?php echo __('dashboard_setting_existion_querstion','Existing Question'); ?>:</label>
              <input id="existvalue" class="form-control" type="text" readonly value="<?php echo $question[0]['question'];?>." >
            </div>
          </div>
          <?php } ?>
         
		   <?php if(!empty($question[0]['question'])){ 
		   
		   if(!empty($reset_code)){
		   
		   ?>
             			  
				<div class="form-group">
            <div class="col-xs-12">
              <label> <?php echo __('dashboard_setting_reset_security_question','Reset Security Question Answer'); ?><span>*</span></label>
              <select class="form-control" size="1" id="question" name="question" tooltiptext="Select question">
                <option label="<?php echo __('dashboard_setting_please_select','Please select...'); ?>" value=""><?php echo __('dashboard_setting_please_select','Please select...'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?>" id="1" value="<?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?>"><?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?>" id="2" value="<?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?>"><?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?>" id="3" value="<?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?>"><?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?>" id="4" value="<?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?>"><?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?>" id="5" value="<?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?>"><?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?>" id="6" value="<?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?>"><?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?>" id="7" value="<?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?>"><?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?>" id="8" value="<?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?>"><?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?>" id="9" value="<?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?>"><?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?>" id="10" value="<?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?>"><?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?>" id="11" value="<?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?>"><?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?>" id="12" value="<?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?>"><?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?>" id="13" value="<?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?>"><?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?></option>
				
              </select>
              <span id="questionError" class="error-msg13"></span>
			   </div>
			  </div>
			  <div class="form-group">
				<div class="col-xs-12">
				  <label><?php echo __('dashboard_setting_answer','Answer'); ?>: <span>*</span></label>
				  <input class="form-control" id="answer" name="answer" type="text" value="" tooltiptext="Enter Your Answer">
				  <input class="form-control" id="answerVal" name="answerVal" type="hidden" value="">
				  <span id="answerError" class="error-msg13"></span> </div>
			  </div>
		   <?php } ?>
                <?php } else{?>
			<div class="form-group">
            <div class="col-xs-12">
              <label> <?php echo __('dashboard_setting_question','Questions'); ?><span>*</span></label>
              <select class="form-control" size="1" id="question" name="question" tooltiptext="Select question">
                <option label="<?php echo __('dashboard_setting_please_select','Please select...'); ?>" value=""><?php echo __('dashboard_setting_please_select','Please select...'); ?></option>
                
				<option label="<?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?>" id="1" value="<?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?>"><?php echo __('dashboard_setting_your_mothers_maiden_name','Your mother\'s maiden name'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?>" id="2" value="<?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?>"><?php echo __('dashboard_setting_your_first_pets_name','Your first pet\'s name'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?>" id="3" value="<?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?>"><?php echo __('dashboard_setting_the_name_of_your_elementary_school','The name of your elementary school'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?>" id="4" value="<?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?>"><?php echo __('dashboard_setting_your_elementary_school_mascot','Your elementary school mascot'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?>" id="5" value="<?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?>"><?php echo __('dashboard_setting_your_best_friends_nickname','Your best friend\'s nickname'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?>" id="6" value="<?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?>"><?php echo __('dashboard_setting_your_favorite_sports_team','Your favorite sports team'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?>" id="7" value="<?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?>"><?php echo __('dashboard_setting_your_favorite_writer','Your favorite writer'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?>" id="8" value="<?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?>"><?php echo __('dashboard_setting_your_favorite_actor','Your favorite actor'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?>" id="9" value="<?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?>"><?php echo __('dashboard_setting_your_favorite_singer','Your favorite singer'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?>" id="10" value="<?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?>"><?php echo __('dashboard_setting_your_favorite_song','Your favorite song'); ?></option>
				
                <option label="<?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?>" id="11" value="<?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?>"><?php echo __('dashboard_setting_the_name_of_the_street_you_grew_up_on','The name of the street you grew up on'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?>" id="12" value="<?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?>"><?php echo __('dashboard_setting_make_and_model_of_your_first_car','Make and model of your first car'); ?></option>
				
				
                <option label="<?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?>" id="13" value="<?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?>"><?php echo __('dashboard_setting_the_city_where_you_first_met_your_spouse','The city where you first met your spouse'); ?></option>
				
				
              </select>
              <span id="questionError" class="error-msg13"></span>
			   </div>
			  </div>
			  <div class="form-group">
				<div class="col-xs-12">
				  <label><?php echo __('dashboard_setting_answer','Answer'); ?>: <span>*</span></label>
				  <input class="form-control" id="answer" name="answer" type="text" value="" tooltiptext="Enter Your Answer">
				  <input class="form-control" id="answerVal" name="answerVal" type="hidden" value="">
				  <span id="answerError" class="error-msg13"></span> </div>
			  </div>
                <?php } ?>
                
         
		   <?php if(!empty($question[0]['question']) && (empty($reset_code))){   ?>
          <input type="button" value="<?php echo __('dashboard_setting_reset','Reset'); ?>" id="reset_ans_btn" onclick="resetAnswer()" class="btn btn-info">
		 
		   <?php }else{ ?>
		   <input type="button" value="<?php echo __('dashboard_setting_create','Create'); ?>" id="create_btn" name="submit" onclick="securityCheck()" class="btn btn-site">
		   <?php } ?>
          <!--<button type="button" class="btn-normal btn-color submit bottom-pad7" disabled="disabled" onclick="setpassword()" id="update_btn">Update</button>-->
          
          </form>
		  <?php */ ?>
          <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>

          <div class="form-horizontal">
            <div class="form-group">
                <label><?php echo __('dashboard_setting_email','Email'); ?> : <span> <font color="#666666"><?php echo $user_mail;?></font> </span></label>              
            </div>
            <div class="form-group hidden">              
                <div class="checkbox checkbox-inline">
                  <input class="magic-checkbox" type="checkbox" name="change_pass" id="change_pass" value="" onclick="showpass()" checked>
                  <label for="change_pass"><?php echo __('dashboard_setting_change_password','Change Password'); ?>:</label>
              </div>
            </div>
            <div class="alert alert-success" style="display:none"><?php echo __('dashboard_setting_your_message_has_been_sent_successfully','Your message has been sent successfully.'); ?></div>
            <?php

$attributes = array('id' => 'changepass_frm','class' => 'form-horizontal','role'=>'form','name'=>'changepass_frm','onsubmit'=>"disable");

echo form_open('', $attributes);   

?>
            <div class="settinbox" id="opass_div" style="display: none;">
              <div class="form-group">
                  <label><?php echo __('dashboard_setting_old_password','Old Password'); ?> :</label>
                  <input type="password" name="old_pass" id="old_pass" placeholder="<?php echo __('dashboard_setting_enter_your_old_password','Enter Your Old Password'); ?>" value="" class="form-control" tooltipText="Enter Your Old Password" />
                  <span id="old_passError" class="error-msg13"></span> 
              </div>
            </div>
            <div class="settinbox" id="npass_div" style="display: none;">
              <div class="form-group">
                  <label><?php echo __('dashboard_setting_new_password','New Password'); ?> :</label>
                  <input type="password" name="new_pass" id="new_pass" placeholder="<?php echo __('dashboard_setting_enter_your_new_password','Enter Your New Password'); ?>" value="" class="form-control" tooltipText="Enter Your New Password" />
                  <span id="new_passError" class="error-msg13"></span> 
              </div>
              <div class="settinbox" id="cpass_div" style="display: none;">
                <div class="form-group">
                    <label><?php echo __('dashboard_setting_confirm_password','Confirm Password'); ?> :</label>
                    <input type="password" name="confirm_pass" id="confirm_pass" placeholder="<?php echo __('dashboard_setting_reenter_your_new_password','Re-Enter Your New Password'); ?>" value="" class="form-control" tooltipText="Enter Your Confirm Password" />
                    <span id="confirm_passError" class="error-msg13"></span>
                </div>
              </div>
              <input class="btn btn-site" type="button" onclick="setpassword()" id="update_btn" value="<?php echo __('dashboard_setting_update','Update'); ?>" />
              <!--<button type="button" class="btn-normal btn-color submit bottom-pad7" disabled="disabled" onclick="setpassword()" id="update_btn">Update</button>-->
              
              </form>
              
            </div>
          </div>
          </div>
        </div>
          <?php if($u_info['account_type'] == 'F'){?>
          	  
              <div class="card" id="feature_profile">
              	<div class="card-header"><h4>Make your profile featured</h4></div>
              <div class="card-body">
                <p>Want to get searched on the top? <a href="javascript:void(0)" onclick="$('#toggleView').toggle(200);"><b>Feature your Profile </b></a></p>
                
                <div id="toggleView" style="display:none;">
                  <h4>Profile Feature Plan</h4>
                  <div class="row text-center">
                  <div class="col">
                  <a data-next="<?php echo base_url('dashboard/feature_profile?type=monthly'); ?>" href="javascript:void(0)" data-confirm-text="Are you sure to upgrade profile to feature ?" class="well d-block" onclick="confirm_first(this)"><b>MONTHLY</b>
                  <h2><?php echo CURRENCY.PROFILE_FEATURED_MONTHLY;?></h2>
                  </a>
                  </div>
                  
                  <div class="col">
                  <a data-next="<?php echo base_url('dashboard/feature_profile?type=yearly'); ?>" href="javascript:void(0)" data-confirm-text="Are you sure to upgrade profile to feature ?" class="well d-block" onclick="confirm_first(this)"><b>YEARLY</b>
                  <h2><?php echo CURRENCY.PROFILE_FEATURED_YEARLY;?></h2>
                  </a>
                  </div>
                  </div>
              </div>
              </div>
              <?php } ?>
          
          <!--EditProfile End--> 

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

      
      <!-- Left Section End --> 
      
    </div>
  </div>
  </div>
</section>
<script>

$("#question").on('change', function () {
    var ansval=$(this).find('option:selected').attr('id');
	
	document.getElementById('answerVal').value = ansval;
});
  function showpass(){ 

    $("#opass_div").toggle();

    $("#npass_div").toggle();

    $("#cpass_div").toggle();

    

    if($("#change_pass").is(":checked")){ 

         $("#update_btn").show();

       $("#update_btn").removeAttr('disabled');

    }



    

  }
  
  showpass();

</script> 