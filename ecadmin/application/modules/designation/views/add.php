<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>designation/">Designations List</a></li>

            </ul>
        </div>

        <div class="container-fluid">
            
			<?php
            //$year = $this->uri->segment(3);
            ?>
				
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
                            <h4>Add Media Content</h4>
                        
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                  <form id="validate" action="<?php echo base_url(); ?>designation/add" class="form-horizontal" role="form" name="media"  method="post" enctype="multipart/form-data">

                               
								
								
								        <div class="form-group">
								<label class="col-lg-2 control-label" for="required">Designation name</label>
								<div class="col-lg-6">
									<input type="text" id="required" value="<?php echo set_value('designation'); ?>" name="designation" class="required form-control">
									<?php echo form_error('designation', '<label class="error" for="required">', '</label>'); ?>
								</div>
							</div>
							<!-- End .control-group  -->
								
											
						
                       
					<div class="form-group">
						<label class="col-lg-2 control-label" for="agree">Status</label>
						<label class="checkbox-inline">
							<input class="form-control" type="radio" id="status" name="status" value="Y" checked="checked" />Online<input class="form-control" type="radio" id="status" name="status" Value="N">Offline
						</label>
					</div>

                                <!-- End .control-group  -->
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Add">
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'designation/'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- End .form-group  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
