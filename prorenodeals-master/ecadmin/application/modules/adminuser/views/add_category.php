<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'adminuser/type_list'; ?>">User type list</a></li>
        <li class="breadcrumb-item active">Add New Type</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-check-square"></i> Add Admin User Type</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>adminuser/add_type" class="form-horizontal" role="form" name="adminmenu" method="post">
            <div class="form-group">
              <label class="col-form-label" for="required">Type Name</label>
              <input type="text" id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control" />
            </div>
            <div class="form-group checkGroup">
              <label class="col-form-label">Set Menu Permission</label><br />              
              <?php
                                foreach($leftmenu as $key=>$val)
                                {
                                ?>
              <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" name="user_perm[]" value="<?php echo $val['id'];?>" id="check_<?php echo $val['id'];?>">
                <label class="custom-control-label" for="check_<?php echo $val['id'];?>"><?php echo $val['name'];?></label>
              </div>
              <?php
                                }
                                ?>
            </div>
            <div class="form-group">
              <label class="col-form-label">Status</label><br />              
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="status" name="status" class="custom-control-input" value="Y" checked="checked">
                <label class="custom-control-label" for="status">Online</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="status2" name="status" class="custom-control-input" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                <label class="custom-control-label" for="status2">Offline</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;
            <button type="button" onClick="redirect_to('<?php echo base_url() . 'adminuser/type_list'; ?>');" class="btn btn-secondary">Cancel</button>
            <!-- End .form-group  -->
            
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
<style>
.checkbox-inline + .checkbox-inline {
	margin-left:0
}
@media (min-width: 768px) {
.checkbox-inline {
    width: 33%;
    margin-left: 0;	
}
</style>
