
<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb;?>
<script type="text/javascript">
function editFormPost(){
     $("#old_passError").text('');
     $("#new_passError").text('');
     $("#confirm_passError").text('');
 if($("#change_pass").is(":checked")){ 
    if($("#old_pass").val().length<6){
            $("#old_passError").text("Password Minimum 6 Character");
            $("#old_passError").css("color","#FF0000");
          //  f=false;
          }
          else if($("#new_pass").val().length<6){
            $("#new_passError").text("Password Minimum 6 Character");
            $("#new_passError").css("color","#FF0000");
          //  f=false;                        
          } 
          else if($("#confirm_pass").val().length<6){
            $("#confirm_passError").text("Password Minimum 6 Character");
            $("#confirm_passError").css("color","#FF0000");
        //    f=false;                        
          }else{
            FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>affiliate/check",'editprofile');
        }
        }else{
            FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>affiliate/check",'editprofile');
        }
}
</script>       
<script src="<?=JS?>mycustom.js"></script>
<div class="container">
      <div class="row">
         <?php echo $leftpanel;?> 
         <!-- Sidebar End -->
         <div class="col-md-9 col-sm-8 col-xs-12">
            
            
<!--ProfileRight Start-->
<div class="profile_right">
<div class="success alert-success alert" style="display:none">Your message has been sent successfully.</div>
<span id="agree_termsError" class="error-msg13" style="display:none"></span>
<!--EditProfile Start-->
<?php
$attributes = array('id' => 'editprofile','class' => 'reply','role'=>'form','name'=>'editprofile','onsubmit'=>"disable", 'enctype'=>'multipart/form-data');
echo form_open('', $attributes);
?>
<!--<h1>
<a class="selected" href="javascript:void(0)">Edit  Profile</a>
</h1> -->
<div class="font_20">Edit  Profile</div>

<div class="editprofile">
<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
<div class="login_form"><p>Username :
<span><font color="#666666"><?php echo $username;?></font></span></p></div>

<div class="login_form"><p>First Name : *</p><input type="text" class="loginput6" size="30" name="fname"  id="fname" value="<?php echo $fname;?>" required
/>    
<span id="fnameError" class="error-msg13"></span>
</div>
<div class="login_form"><p>Last Name : * </p><input type="text" class="loginput6" size="30" name="lname" id="lname"  value="<?php echo $lname;?>" required   />    <div class="focusmsg" id="lnameFocus" style="display:none">Enter Your Last Name </div>
<span id="lnameError" class="error-msg13"></span>
</div>
<div class="login_form"><span>Change Password :</span>
<input name="change_pass" id="change_pass" onclick="showpass()" type="checkbox" value="Y">
</div>
<div class="settinbox" id="opass_div" style="display: none;">

<div class="login_form">
<p>Old Password :</p>
<input name="old_pass" id="old_pass"  type="text" value="" class="loginput6" tooltipText="Enter Your Old Password" />
<span id="old_passError" class="error-msg13"></span>    
</div>

</div>

<div class="settinbox" id="npass_div" style="display: none;">

<div class="login_form">
<p>New Password :</p>
<input name="new_pass" id="new_pass"  type="text" value="" class="loginput6" tooltipText="Enter Your New Password" />    
<span id="new_passError" class="error-msg13"></span>
</div>
</div>


<div class="settinbox" id="cpass_div" style="display: none;">
<div class="login_form">
<p>Confirm Password :</p>
<input name="confirm_pass" id="confirm_pass"  type="text" value="" class="loginput6" tooltipText="Enter Your Confirm Password" /> 
<span id="confirm_passError" class="error-msg13"></span>   
</div>

</div>










<div class="login_form">
<input class="btn-normal btn-color submit  bottom-pad" type="button" id="submit-check" onclick="editFormPost()" value="Submit" /></div>
<div style="clear:both; height:15px;"></div>
</div>
</form>
<!--EditProfile Start-->

</div>                       

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

<script>
function ajaxFileUpload()
{
		
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		$.ajaxFileUpload
		(
			{
				url:'<?php echo VPATH;?>dashboard/fileUpload',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							//alert(data.msg);
							$('#logo').val(data.msg);
							$('#imge').html('');
							$('#imge').html('<img src="<?php echo VPATH;?>assets/uploaded/'+data.msg+'">');
							//alert("logo:"+$('#logo').val());
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

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
	</script>	
	<script>
  function showpass(){ 
    $("#opass_div").toggle();
    $("#npass_div").toggle();
    $("#cpass_div").toggle();
    
    if($("#change_pass").is(":checked")){ 
        
       $("#update_btn").removeAttr('disabled');
    }
    else{
       $("#update_btn").attr('disabled','true');
    }
    
  }
</script>