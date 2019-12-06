
<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
	<li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
	<li class="active"><a onclick="redirect_to('<?php echo base_url() . 'advertisement'; ?>');">Advertisement List</a></li>
	<li class="active">Add Advertisement</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
	<h1><i class="icon20 i-list-4"></i>Advertisement Management</h1>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
				<h4>Add New Banner</h4>
				<a href="#" class="minimize2"></a>
			</div><!-- End .panel-heading -->

			<div class="panel-body">
				<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
				<form id="validate" action="<?php echo base_url(); ?>advertisement/add" class="form-horizontal" role="form" name="advertisement" method="post" enctype="multipart/form-data">
				    <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Select Type</label>
						<div class="col-lg-6">
							<select name="type" for="required"  class="select2 select_type required  form-control">
								<option></option>
								<? foreach ($add as $key => $ban) { ?>
									<option value="<? echo $ban['type']; ?>"><? echo str_replace("_", " ", $ban['type']); ?></option>
								<? } ?>
							</select>	
						</div>
					</div>
					
					<div class="form-group">
                                    <label class="col-lg-2 control-label" for="userfile">Image</label>
                                    <div class="col-lg-6">
                                        <input id="userfile" value="<?php echo set_value('userfile');?>" type="file" name="userfile" class="form-control" />
                                    </div>
                    </div>
                    
                    <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Link</label>
						<div class="col-lg-6">
							<input type="text" id="required" value="<?php echo set_value('link'); ?>" name="link" class="required form-control">
							<?php echo form_error('link', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label" for="required">Order</label>
						<div class="col-lg-6">
							<input type="text" id="required" value="<?php echo set_value('order'); ?>" name="order" class="required form-control">
							<?php echo form_error('order', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div>
					
                   <div class="form-group">
                            <label for="radio" class="col-lg-2 control-label">Status</label>
                            <label class="radio-inline">
                              <div class="radio"><span>
                                      <input type="radio" id="status" name="status" value="Y"   checked="checked">
                                  </span>
                              </div> Online
                            </label>
                            <label class="radio-inline">
                              <div class="radio"><span class="checked">
                                      <input <?php echo set_checkbox('status', 'N'); ?> type="radio" id="status" name="status" Value="N">
                                  </span>
                              </div> Offline
                            </label>               
                       </div>
					<div class="form-group">
						<div class="col-lg-offset-2">
							<div class="pad-left15">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button type="button" onclick="redirect_to('<?php echo base_url() . 'advertisement'; ?>');" class="btn">Cancel</button>
							</div>
						</div>
					</div><!-- End .form-group  -->

				</form>
			</div><!-- End .panel-body -->
		</div><!-- End .widget -->
	</div><!-- End .col-lg-12  --> 
</div><!-- End .row-fluid  -->

</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
