<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>member/member_list/">Member List</a> </li>
        <li class="breadcrumb-item active"><a>Add New Member</a></li>
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
          <h5><i class="la la-plus-square"></i> Add New Member</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>member/add/" class="form-horizontal" role="form" name="addmember" method="post">
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">First Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="" name="fname" class="form-control">
                <?php echo form_error('fname', '<label class="error">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Last Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="" name="lname" class="form-control">
                <?php echo form_error('lname', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Username</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="" name="username" class="form-control">
                <?php echo form_error('username', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Email</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="" name="email" class="form-control">
                <?php echo form_error('email', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Confirm email</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="" name="cemail" class="form-control">
                <?php echo form_error('cemail', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Password</label>
              <div class="col-lg-10 col-md-9">
                <input type="password" value="" name="password" class="form-control">
                <?php echo form_error('password', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Confirm Password</label>
              <div class="col-lg-10 col-md-9">
                <input type="password" value="" name="cpassword" class="form-control">
                <?php echo form_error('cpassword', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Country</label>
              <div class="col-lg-10 col-md-9">
                <select id="country" name="country" class="required form-control" onchange="citylist(this.value)">
                  <option value="">Please Select</option>
                  <?php
                                        foreach($country as $c)
										{
										?>
                  <option value="<?php echo $c['code'];?>" <?php if($c['code']=="NGA"){echo "selected='selected'";}?> ><?php echo $c['name'];?></option>
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
                  <option value="<?php echo $c['name'];?>"><?php echo $c['name'];?></option>
                  <?php	
										}
										?>
                </select>
                <?php echo form_error('city', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>						 <div class="row">              <label class="col-lg-2 col-md-3 col-form-label">Account Type</label>                 <div class="col-lg-10 col-md-9">                           <div class="custom-control custom-radio custom-control-inline">                  <input type="radio" class="custom-control-input" id="account_type_F" name="account_type" value="F" checked="checked">                  <label class="custom-control-label" for="account_type_F">Freelancer</label>                </div>                <div class="custom-control custom-radio custom-control-inline">                  <input type="radio" class="custom-control-input" id="account_type_E" name="account_type" value="E">                  <label class="custom-control-label" for="account_type_E">Employer</label>                </div>              </div>            </div>			
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>   
              <div class="col-lg-10 col-md-9">           
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N">
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
              </div>
            </div>
            
            <!-- End .control-group  -->
            <div class="row">
                <div class="col-lg-2 col-md-3">&nbsp;</div>
				<div class="col-lg-10 col-md-9">
                  <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
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