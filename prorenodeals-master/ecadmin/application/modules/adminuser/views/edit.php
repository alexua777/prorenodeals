<section id="content">
  <div class="wrapper">    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>adminuser/user_list/">Admin User List</a></li>
		<li class="breadcrumb-item active"><a>Edit Knowledge</a></li>
      </ol>
    </nav> 
    <div class="container-fluid">
      <?php
			$id = $this->uri->segment(3);
            ?>
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
          <h5><i class="la la-edit"></i> Edit Knowledge </h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>adminuser/edit_user/<?php echo $id;?>/" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id;?>" />
            <div class="form-group">
              <label class="col-form-label">Username</label>
              <input type="text" value="<?php echo $all_data['username']; ?>" name="username" class="form-control">
              <?php echo form_error('username', '<label class="error" >', '</label>'); ?> 
			  </div>
            <!-- End .control-group  -->
			
			
			
			 <div class="form-group">
              <label class="col-form-label">Admin name</label>
              <input type="text" value="<?php echo !empty($all_data['name']) ? $all_data['name'] : ''; ?>" name="name" class="form-control">
              <?php echo form_error('name', '<label class="error" >', '</label>'); ?> 
			  </div>
            <!-- End .control-group  -->
			
			<?php if(!empty($all_data['image'])){ ?>
			 <div class="form-group">
              <label class="col-form-label">Previous Image</label>
				<img src="<?php echo base_url('admin_images/'.$all_data['image']);?>" width="100"/>
			  </div>
			<?php } ?>
			<div class="form-group">
              <label class="col-form-label">Admin Image</label>
              <div class="custom-file">
				  <input type="file" class="custom-file-input" id="customFile" name="image">
				  <label class="custom-file-label" for="customFile">Choose file</label>
				</div>
			</div>
			  
            <div class="form-group">
              <label class="col-form-label">User Type</label>
              <select  name="user_type" class="form-control">
                <option value="">Please Select</option>
                <?php
            if (count($type_data) > 0) {
                foreach ($type_data as $key => $val) {
        ?>
                <option value="<?php echo $val['id']?>" <?php if($val['id']==$all_data['type']){echo "selected";}?>><?php echo $val['name']?></option>
                <?php
          }
          }
          ?>
              </select>
              <?php echo form_error('user_type', '<label class="error">', '</label>'); ?> </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-form-label">Email</label>
              <input type="text" value="<?php echo $all_data['email']; ?>" name="email" class="form-control">
              <?php echo form_error('email', '<label class="error">', '</label>'); ?> </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-form-label">Status</label>
              <br />
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data['status']) && $all_data['status'] == 'Y') {
    echo "checked";
} ?>>
                <label class="custom-control-label" for="status">Online</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if (isset($all_data['status']) && $all_data['status'] == 'N') {
    echo "checked";
} ?>>
                <label class="custom-control-label" for="status_2">Offline</label>
              </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Add">
            &nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'adminuser/user_list/'; ?>');" class="btn btn-secondary">Cancel</button>
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
