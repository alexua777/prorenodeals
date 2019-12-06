<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'adminuser/type_list'; ?>">User type list</a></li>
        <li class="breadcrumb-item active"><a>Modify User Type</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Edit User Type</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>adminuser/edit_type/" class="form-horizontal" role="form" name="adminmenu" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="form-group">
                <label class="col-form-label" for="required">Name</label>              
                <input type="text" id="required" value="<?php echo $name; ?>" name="name" class="required form-control">
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group checkGroup">
              <label class="col-form-label" for="required">Set Menu Permission</label><br />
              <?php
  
								  if($menus!=""){ 
								   $menus=explode(",",$menus); 
								  }
								  else{ 
									  $menus[]=0;
								  }
								  
								?>
              <?php
                               foreach($leftmenu as $key=>$val)
							   {
							   ?>
              <div class="custom-control custom-checkbox custom-control-inline">              
                <input type="checkbox" class="custom-control-input" id="check_<?php echo $val['id'];?>" name="user_perm[]" value="<?php echo $val['id'];?>"
							 <?php 
                                 if(in_array($val['id'],$menus)){ 
                                   echo "checked='checked'";
                                 }
                               ?>  
                                >
                
              <label class="custom-control-label" for="check_<?php echo $val['id'];?>"><?php echo $val['name'];?></label>
              </div>
              <?php
							   }
							?>
            </div>
            <div class="form-group">
              <label class="col-form-label">Status</label><br />     
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') { echo 'checked'; } ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
            <button type="button" onClick="redirect_to('<?php echo base_url() . 'adminuser/type_list'; ?>');" class="btn btn-secondary">Cancel</button>
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
