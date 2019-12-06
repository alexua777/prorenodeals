<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
<li class="active"><a href="javascript:;"onclick="redirect_to('<?php echo base_url() . 'advertise/page'; ?>');">Advertise List</a></li>
<li class="active">Add Advertise</li>
</ul>
</div>

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
		<h4>Add Advertise </h4>
		<a href="#" class="minimize2"></a>
	</div>

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'advertise/add/'; ?>" class="form-horizontal" role="form" name="event" method="post"  enctype="multipart/form-data">
            <!-- End .control-group  -->		
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Advertise Title</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('advertise_name'); ?>" name="advertise_name" class="required form-control">
                     <?php echo form_error('advertise_name', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
			
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Page Name</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('page_name'); ?>" name="page_name" class="required form-control">
                     <?php echo form_error('page_name', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Define Position</label>
				<div class="col-lg-6">
					Top : <input type="radio" id="required" value="T"  name="add_pos"  class="required form-control">
					Right : <input type="radio" id="required" value="R" name="add_pos" class="required form-control">
					Bottom : <input type="radio" id="required" value="B"  name="add_pos" class="required form-control">
					Left : <input type="radio" id="required"  value="L"  name="add_pos" class="required form-control">
                    <?php echo form_error('add_pos', '<label class="error" for="required">','</label>'); ?>  
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Image</label>
				<div class="col-lg-6">
					<input type="file" id="required" name="userfile" class="required form-control">
                     
				</div>
			</div>
			
			
			
			
				<div class="form-group">
						<label class="col-lg-2 control-label" for="required">Advertise Description</label>
						<div class="col-lg-6">
                          <textarea name="advartise_description" class="col-lg-7 valid form-control" rows="5" cols="30" id="required"></textarea>				 
						  <?php echo form_error('advartise_description', '<label class="error" for="required">', '</label>'); ?>
						</div>
				</div>
					
			<!-- End .control-group  -->
			<div class="form-group">
				<div class="col-lg-offset-2">
					<div class="pad-left15">
						 <input type="submit" name="submit" class="btn btn-primary" value="Save">
						<button type="button" onclick="redirect_to('<?php echo base_url(); ?>advertise/page');" class="btn">Cancel</button>
						
					</div>
				</div>
			</div><!-- End .form-group  -->
			
		</form>
	</div><!-- End .panel-body -->
</div>

</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
