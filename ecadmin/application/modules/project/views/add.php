<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li> 
        <li class="breadcrumb-item"><a href="<?= base_url() ?>membership_plan/membership_plan_list/">Membership Plan List</a></li>       
        <li class="breadcrumb-item active">Add Membership<a></a></li>
      </ol>
    </nav>        
        <div class="container-fluid">            
                <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                        </div> 
                        <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                        </div>
    <?php
}
?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><i class="la la-plus-square"></i> Add New Membership Plan</h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

      <div class="panel-body">
        <form id="validate" action="<?php echo base_url(); ?>membership_plan/add_membership_plan/" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">



            <div class="form-group">
				<label class="col-form-label" for="required">Plan Name</label>
					<input type="text" id="required" value="" name="name" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
            </div>
            
            <div class="form-group">
				<label class="col-form-label" for="required">Plan Price</label>
					<input type="text" id="required" value="" name="price" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
            </div>
            
            <div class="form-group">
				<label class="col-form-label" for="required">No of Skill</label>
					<input type="text" id="required" value="" name="skills" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
            </div>
            
             <div class="form-group">
				<label class="col-form-label" for="required">No of Bids</label>
					<input type="text" id="required" value="" name="bids" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
            </div>
            
             <div class="form-group">
				<label class="col-form-label" for="required">No of Portfolio</label>
					<input type="text" id="required" value="" name="portfolio" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>				
            </div> 
            <div class="form-group">
				<label class="col-form-label" for="required">Days</label>
				
					<input type="text" id="required" value="" name="days" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
				
            </div>
           
            <div class="form-group">
              <label class="col-form-label">Status</label>
              <label class="checkbox-inline">
              <input class="form-control" type="radio" id="status" name="status" value="Y" />Online
              <input class="form-control" type="radio" id="status" name="status" Value="N" />Offline
              </label>
            </div>

			<input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
			<button type="button" onclick="redirect_to('<?php echo base_url() . 'membership_plan/membership_plan_list/'; ?>');" class="btn btn-secondary">Cancel</button>

                            </form>
                        </div>
                    </div>
                
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>