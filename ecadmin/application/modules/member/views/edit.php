<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>member/member_list/">Member List</a></li>
        <li class="breadcrumb-item active"><a>Edit member</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
}
?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Edit/Modify Member </h5>
          <a href="#" class="minimize2"></a> </div>
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>member/edit_member/<?php echo $all_data['user_id'];?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">First Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['fname']; ?>" name="fname" class="required form-control">
                <?php echo form_error('fname', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Last Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['lname']; ?>" name="lname" class="required form-control" >
                <?php echo form_error('lname', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  --> 
            
            <!--<div class="row">
        <label class="col-lg-2 col-md-3 col-form-label" for="agree">Gender</label>
        <label class="checkbox-inline">
            <input class="required form-control" type="radio" id="gender" name="gender" value="M" <?php if( $all_data['gender'] =='M' ){ echo 'checked';}?>/>Male<input class="form-control" <?php if( $all_data['gender'] =='F' ){ echo 'checked';  } ?> type="radio" id="gender" name="gender" Value="F">Female
        </label>
    </div>-->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Email</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['email']; ?>" name="email" class="required form-control">
                <?php echo form_error('email', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <?php if($all_data['account_type'] == 'F'){ ?>
            <div class="row">
				<label class="col-lg-2 col-md-3 col-form-label" for="phone">Phone</label>
				<div class="col-lg-10 col-md-9">
					<input type="text" id="phone" value="<?php echo $all_data['phone']; ?>" name="phone" class="required form-control">
					<?php echo form_error('phone', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div>
		
			
			<div class="row">
				<label class="col-lg-2 col-md-3 col-form-label" for="company">Company</label>
				<div class="col-lg-10 col-md-9">
					<input type="text" id="company" value="<?php echo $all_data['company']; ?>" name="company" class="required form-control">
					<?php echo form_error('company', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div>
			
			<?php } ?>
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Logo</label>
              <div class="col-lg-10 col-md-9">
                <?php
            if($all_data['logo']!='')
            {
            ?>
                <img src="<?php echo SITE_URL;?>assets/uploaded/<?php echo $all_data['logo'];?>"  height="60" width="60"/>
                <?php
            }
            else
            {
            ?>
                <img src="<?php echo SITE_URL;?>assets/user_images/default_profile_pic.jpg" height="60" width="60"/>
                <?php
            }
            ?>
                <div class="custom-file mt-2">
                  <input type="file" class="custom-file-input" id="userfile" name="userfile">
                  <label class="custom-file-label" for="userfile">Choose file</label>
                </div>
              </div>
            </div>
            
            <!--<div class="row">
        <label class="col-lg-2 col-md-3 col-form-label" for="address">Address</label>
        <div class="col-lg-10 col-md-9">
            <input type="text" id="address" value="<?php echo $all_data['address']; ?>" name="address" class="required form-control">
            <?php echo form_error('address', '<label class="error" for="required">', '</label>'); ?>
        </div>
    </div>--> 
            
            <!--<div class="row" >
        <label class="col-lg-2 col-md-3 col-form-label" for="required">Country</label>
        <div class="col-lg-10 col-md-9">
            <Select id="required" name="country" class="required form-control">
                <option value="">Please Select</option>
                <?php
                foreach($allcountry as $key=>$val)
                {
                ?>
                    <option value="<?php echo $val['code']?>" <?php if($val['code']==$all_data['country']){echo "selected";}?>><?php echo $val['name'];?></option>
                <?php
                }
                ?>
            </Select>
        </div>
    </div>
     <div class="row" >
        <label class="col-lg-2 col-md-3 col-form-label" for="required">City</label>
        <div class="col-lg-10 col-md-9">
            <Select id="required" name="city" class="required form-control">
                <option value="">Please Select</option>
                <?php
                foreach($allcity as $key=>$val)
                {
                ?>
                    <option value="<?php echo $val['id']?>" <?php if($val['id']==$all_data['city']){echo "selected";}?>><?php echo $val['city'];?></option>
                <?php
                }
                ?>
            </Select>
        </div>
    </div>
   <!-- <div class="row">
        <label class="col-lg-2 col-md-3 col-form-label" for="zip">Zip</label>
        <div class="col-lg-10 col-md-9">
            <input type="text" id="zip" value="<?php echo $all_data['zip']; ?>" name="zip" class="required form-control">
            <?php echo form_error('zip', '<label class="error" for="zip">', '</label>'); ?>
        </div>
    </div>  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Country</label>
              <div class="col-lg-10 col-md-9">
                <select id="country" name="country" class="required form-control" onchange="citylist(this.value)">
                  <option value="">Please Select</option>
                  <?php
                                foreach($country as $c)
                                {
                                ?>
                  <option value="<?php echo $c['code'];?>" <?php if($c['code']==$all_data['country']){echo "selected='selected'";}?> ><?php echo $c['name'];?></option>
                  <?php	
                                }
                                ?>
                </select>
                <?php echo form_error('country', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">City</label>
              <div class="col-lg-10 col-md-9">
                <select id="city" name="city" class="required form-control">
                  <option value="">Please Select</option>
                  <?php
                                foreach($state as $c)
                                {
                                ?>
                  <option value="<?php echo $c['id'];?>" <?php if($c['id']==$all_data['city']){echo "selected='selected'";}?> ><?php echo $c['name'];?></option>
                  <?php	
                                }
                                ?>
                </select>
                <?php echo form_error('city', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Verified</label>
              <div class="col-lg-10 col-md-9">
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="verify" name="verify" value="Y" <?php if($all_data['verify']=='Y'){echo "checked";} ?>>
                  <label class="custom-control-label" for="verify">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="verify_2" name="verify" value="N" <?php if($all_data['verify']=='N'){echo "checked";} ?>>
                  <label class="custom-control-label" for="verify_2">No</label>
                </div>              
                </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>
              <div class="col-lg-10 col-md-9">
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" <?php if($all_data['status']=='Y'){echo "checked";} ?>>
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if($all_data['status']=='N'){echo "checked";} ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline" hidden>
                  <input type="radio" class="custom-control-input" id="status_3" name="status" value="C" <?php if($all_data['status']=='C'){echo "checked";} ?>>
                  <label class="custom-control-label" for="status_3">Closed</label>
                </div>              
                </div>
            </div>
            
            <!-- End .control-group  -->
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
				<div class="col-lg-10 col-md-9">
                  <input type="submit" name="submit" class="btn btn-primary" value="Update">&nbsp;
                  <button type="button" onclick="redirect_to('<?php echo base_url() . 'member/member_list/'; ?>');" class="btn btn-secondary">Cancel</button>                
              </div>
            </div>
            <!-- End .row  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
      <!-- End .widget --> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
<script>
function citylist(country)
{
	
	var dataString = 'cid='+country;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>member/getcity/"+country,
     success:function(return_data)
     {
	 	//alert(return_data);
      	$('#city').html('');
		$('#city').html(return_data);
     }
    });
}
</script>