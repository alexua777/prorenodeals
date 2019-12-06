<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>document_type/list_record/">Document Type List</a></li>
        <li class="breadcrumb-item active"><a>Edit Bid Plan</a></li>
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
          <h5><i class="la la-edit"></i> Edit/Modify Bid Plan </h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
            
			 <div class="form-group">
              <label class="col-form-label" for="required">Name</label>
                <input type="text" id="required" value="<?php echo $all_data['name']; ?>"  name="name" class="required form-control">
                <?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?> 
            </div>
			
				<div class="row">
				<label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
				<div class="col-lg-10 col-md-9">
					<div class="custom-control custom-radio custom-control-inline">
					  <input type="radio" class="custom-control-input" id="status" name="status" value="<?php echo STATUS_ACTIVE; ?>" checked="checked">
					  <label class="custom-control-label" for="status">Active </label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
					  <input type="radio" class="custom-control-input" id="status_2" name="status" value="<?php echo STATUS_INACTIVE; ?>" <?php echo $all_data['status'] == STATUS_INACTIVE ? 'checked' : ''; ?>>
					  <label class="custom-control-label" for="status_2">Inactive</label>
					</div>
				</div>     
			</div> 
			
            <!-- End .control-group  -->
            
            <input type="submit" name="submit" class="btn btn-primary" value="Update">&nbsp;
			<button type="button" onclick="redirect_to('<?php echo base_url() . 'bid_plan/bid_plan_list/'; ?>');" class="btn btn-secondary">Cancel</button>
	
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
