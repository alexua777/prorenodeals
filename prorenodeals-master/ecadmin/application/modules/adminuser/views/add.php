<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>adminuser/user_list/">Admin User List</a></li>
        <li class="breadcrumb-item active">Add new user</a></li>
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
          <h5><i class="la la-check-square"></i> Add/Modify User </h5>
          <a href="#" class="minimize2"></a> </div>
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>adminuser/add_user" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Username</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="username" value="<?php echo set_value('username'); ?>" name="username" class="form-control">
                <?php echo form_error('username', '<label class="error">', '</label>'); ?> </div>
            </div>
			
			 <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Admin name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="name" value="<?php echo set_value('name'); ?>" name="name" class="form-control">
                <?php echo form_error('name', '<label class="error">', '</label>'); ?> </div>
            </div>
			
			<div class="row">
             <label class="col-lg-2 col-md-3 col-form-label">Admin Image</label>
			  <div class="col-lg-10 col-md-9">
              <div class="custom-file">
				  <input type="file" class="custom-file-input" id="customFile" name="image">
				  <label class="custom-file-label" for="customFile">Choose file</label>
				</div>
				</div>
			</div>
			
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">User Type</label>
              <div class="col-lg-10 col-md-9">
                <select id="user_type" name="user_type" class="form-control">
                  <option value="">Please Select</option>
                  <?php
                                        if (count($type_data) > 0) {
                                			foreach ($type_data as $key => $val) {
                                    ?>
                  <option value="<?php echo $val['id']?>" <?php echo set_select('user_type', $val['id']); ?>><?php echo $val['name']?></option>
                  <?php
                                      }
									  }
									  ?>
                </select>
                <?php echo form_error('user_type', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Email</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="email" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                <?php echo form_error('email', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Password</label>
              <div class="col-lg-10 col-md-9">
                <input id="password" value="<?php echo set_value('password'); ?>" type="text" name="password" class="required form-control" />
                <?php echo form_error('password', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" >Confirm Password</label>
              <div class="col-lg-10 col-md-9">
                <input value="<?php echo set_value('cpassword'); ?>" type="text" name="cpassword" class="required form-control" />
                <?php echo form_error('cpassword', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Status</label>
              <div class="col-lg-10 col-md-9">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_1" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status_1">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N">
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
              <div class="col-lg-10 col-md-9">
                <input type="submit" name="submit" class="btn btn-primary" value="Add">
                &nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'adminuser/user_list/'; ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
