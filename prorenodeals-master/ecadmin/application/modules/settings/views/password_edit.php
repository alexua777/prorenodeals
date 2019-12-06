
<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Password Setting Management</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h5><i class="la la-check-square"></i> Modify Password </h5>
              <a href="#" class="minimize2"></a> </div>
            <!-- End .panel-heading -->
            <?php
				if ($this->session->flashdata('succ_msg')) {
					echo '<div class="succ_msg alert-success">';
					echo $this->session->flashdata('succ_msg');
					echo '</div>';
				}
				if ($this->session->flashdata('error_msg')) {
					echo '<div class="alert-error error_msg">';
					echo $this->session->flashdata('error_msg');
					echo '</div>';
				}
				?>
            <div class="panel-body">
              <form id="validate" action="<?php echo base_url(); ?>settings/pass_edit/<?php echo $id;?>/" class="form-horizontal" role="form" name="password" method="post">
                <?php
                $user=$this->auto_model->getFeild('username','admin','admin_id',$id);
				?>
                <div class="form-group">
                  <label class="call-form-label" for="required">Userename</label>
                  <input type="text" id="required" name="username" class="form-control" value="<?php echo ucwords($user);?>" readonly="readonly">
                </div>
                <!-- End .control-group  -->
                
                <div class="form-group">
                  <label class="call-form-label" for="required">Old Password</label>
                    <input type="password" id="required" name="old_pass" class="required form-control">
                    <?php echo form_error('old_pass', '<label class="error" for="required">', '</label>'); ?>
                </div>
                <!-- End .control-group  -->
                
                <div class="form-group">
                    <label class="call-form-label" for="required">New Password</label>
                    <input type="password" id="required" name="new_pass" class="required form-control">
                    <?php echo form_error('new_pass', '<label class="error" for="required">', '</label>'); ?>
                </div>
                
                <!--<div class="form-group">
						<label class="col-lg-2 control-label" for="required">Confirm Password</label>
						<div class="col-lg-6">
							
							<input type="text" id="required" name="con_pass" class="required form-control">
							<?php //echo form_error('con_pass', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div>--><!-- End .control-group  -->
                
                <div class="form-group">
                      <button type="submit" name="change_pass" class="btn btn-primary">Save</button>&nbsp;
                      <button type="button" onclick="redirect_to('<?php echo base_url().'settings/pass_edit'; ?>');" class="btn btn-secondary">Cancel</button>
                </div>
                <!-- End .form-group  -->
                
              </form>
            </div>
            <!-- End .panel-body --> 
          </div>
          <!-- End .widget --> 
        </div>
        <!-- End .col-lg-12  --> 
      </div>
      <!-- End .row-fluid  --> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
