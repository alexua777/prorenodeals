<!-- Title, Breadcrumb Start--><?php  $user = $this->session->userdata('user');$account_type = $user[0]->account_type;/* get_print($user); */?>

<script type="text/javascript">
function editFormPost(){
FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/check",'editprofile');
$(window).scrollTop(20);
}
</script>       
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-md-10 col-sm-9 col-12">
<?php echo $breadcrumb;?>
<div class="profile_right">
<div class="success alert-success alert" style="display:none"><?php echo __('dashboard_editprofile_your_msg_has_been_sent_successfully','Your message has been sent successfully.'); ?> <a class="close" data-dismiss="alert" aria-label="close">×</a></div>
<span id="agree_termsError" class="error-msg13" style="display:none"></span>
<!--EditProfile Start-->
<?php
    $attributes = array('id' => 'editprofile','class' => 'form-horizontal','role'=>'form','name'=>'editprofile','onsubmit'=>"disable", 'enctype'=>'multipart/form-data');
    echo form_open('', $attributes);
?>
<!--<h4 class="title-sm">Edit Professional Profile</h4>-->

<div class="editprofile" style="padding:15px; background-color:#fff; border:1px solid #e0e0e0">
	<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
<div class="row">
    <div class="col-sm-6 col-12">
    <p><?php echo __('dashboard_editprofile_username','Username'); ?> :</p>
    <h5><font color="#666666"><?php echo $username;?></font></h5>
    </div>
    <div class="col-sm-6 col-12">
    	<div class="form-field">
        <label><?php echo __('dashboard_editprofile_designation','Designation'); ?>: </label>
        <input type="text" class="form-control" size="30" value="<?php echo $slogan;?>" name="slogan" id="slogan"  /> 
        </div>
    </div>
</div>   
<div class="row" hidden>
    <div class="col-sm-6 col-12">
    	<div class="form-field">
        <label><?php echo __('dashboard_editprofile_first_name','First Name'); ?> : *</label>
        <input type="text" class="form-control" size="30" name="fname"  id="fname" value="<?php echo $fname;?>" required />    
        <span id="fnameError" class="error-msg13"></span>
        </div>
    </div>
    <div class="col-sm-6 col-12">
    	<div class="form-field">
    	<label><?php echo __('dashboard_editprofile_last_name','Last Name'); ?>: * </label>
        <input type="text" class="form-control" size="30" name="lname" id="lname"  value="<?php echo $lname;?>" required   />
        <span id="lnameError" class="error-msg13"></span>
        </div>
    </div>
</div>
<?php if($account_type == 'F'){?>
<div class="row" hidden>
	<div class="col-sm-6 col-12">
		<div class="form-field">
			<label>Company name : *</label>
			<input type="text" class="form-control" name="company"  id="company" value="<?php echo $company;?>" required />
			<span id="companyError" class="error-msg13"></span>
		</div>
	</div>
	<div class="col-sm-6 col-12">
		<div class="form-field">
			<label>Contact Number : *</label>
			<input type="text" class="form-control" name="phone"  id="phone" value="<?php echo $phone;?>" />
			<span id="companyError" class="error-msg13"></span>
		</div>
	</div>
</div>
<?php  } ?>

<div class="row" <?php if($cname){?>hidden<?php }?>>
    <div class="col-sm-6 col-12" hidden>
        <label><?php echo __('dashboard_editprofile_country_name','Country Name'); ?>: *</label>
        <select class="form-control" size="1" id="country" name="country" required onchange="citylist(this.value)">
        <option value=""><?php echo __('dashboard_editprofile_select_country','Select Country'); ?></option>
        <?php
		$country = 'CAN'; /* default country is canada */ 
        foreach($country_list as $key=>$val)
        {
        ?>
         
         <option value="<?php echo $val['code'];?>" <?php if($val['code']==$country){echo "selected";}?>><?php echo $val['name'];?></option>
        <?php
        }
        ?>
        
        </select>
        <span id="countryError" class="rerror"></span>
		<input type="hidden" name="country" value="<?php echo $country; ?>"/>
    </div>

    <div class="col-sm-6 col-12">
    <div class="form-field">
    <label><?php echo __('dashboard_editprofile_city_name','City Name'); ?>: *</label>
    <select class="form-control" id="city" name="city">    
	<option value=""><?php echo __('dashboard_editprofile_select_city','Select City'); ?></option>
    <?php
	$city_list = get_country_city($country);
	print_select_option($city_list, 'city_id', 'name', $cname);
    ?>
	</select>
    <div class="focusmsg" id="cityFocus" style="display:none"><?php echo __('dashboard_editprofile_select_city','Select City'); ?></div>
    
    <span id="cityError" class="error-msg13"></span>
    
    </div>
	</div>
</div>


<div class="form-group">
    <label><?php echo __('dashboard_editprofile_overview','Overview'); ?> :</label>
    <textarea class="form-control" name="overview" id="overview" rows="5"><?php echo $overview;?></textarea>
     <div class="focusmsg" id="overviewFocus" style="display:none"></div>
</div>

<h4><?php echo __('dashboard_editprofile_this_information_will_be_public','This information will be public.'); ?></h4>

<?php
$profile_links = json_decode(getField('profile_links', 'user', 'user_id', $user_id), true);
$links_fields = array(
	'facebook_link' => array(
		'label' => 'Facebook Link',
		'value' => !empty($profile_links['facebook_link']) ? $profile_links['facebook_link'] : '',
	),
	'twitter_link' => array(
		'label' => 'Twitter Link',
		'value' => !empty($profile_links['twitter_link']) ? $profile_links['twitter_link'] : '',
	),
	'instagram_link' => array(
		'label' => 'Instagram Link',
		'value' => !empty($profile_links['instagram_link']) ? $profile_links['instagram_link'] : '',
	),
	'linkedin_link' => array(
		'label' => 'Linkedin Link',
		'value' => !empty($profile_links['linkedin_link']) ? $profile_links['linkedin_link'] : '',
	),
	'website_link' => array(
		'label' => 'Website Link',
		'value' => !empty($profile_links['website_link']) ? $profile_links['website_link'] : '',
	),
	'other_link' => array(
		'label' => 'Other Link',
		'value' => !empty($profile_links['other_link']) ? $profile_links['other_link'] : '',
	)
);
?>
<div class="row">
<?php foreach($links_fields as $field_name => $field){ ?>
<div class="col-md-6">
<div class="form-field">
	<label><?php echo $field['label']; ?> : </label>
	<input type="text" class="form-control"  value="<?php echo $field['value']; ?>" name="profile_links[<?php echo $field_name; ?>]" id="<?php echo $field_name; ?>"   />
    <span id="fbError" class="error-msg13"></span>
</div>
</div>
<?php } ?>
</div>


<input class="btn btn-site" type="button" id="submit-check" onclick="editFormPost()" value="<?php echo __('dashboard_editprofile_submit','Submit'); ?>" /></div>
<div class="clearfix"></div>
</form>
<!--EditProfile Start-->

</div>                                              


<div class="clearfix"></div>

</div>
<div class="spacer-20"></div>  
</div>
</section>
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
							console.log(data);
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