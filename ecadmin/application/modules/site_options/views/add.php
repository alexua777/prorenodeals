
<section id="content">
<div class="wrapper">
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'site_options'; ?>">Options List</a></li>
        <li class="breadcrumb-item active"><a>Add Options</a> </li>
        </ol>
	</nav> 

<div class="container-fluid">

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'site_options/add'; ?>" class="form-horizontal" role="form" name="state" method="post">
		
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Enter Setting Key</label>
				<div class="col-lg-6">
					<input type="text"  id="required" value="<?php echo set_value('setting_key'); ?>" name="setting_key" class="required form-control">
				</div>
			</div><!-- End .control-group  -->
						
			<div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Setting Value</label>
				<div class="col-lg-6">
					<input class=" required form-control" id="digits" value="<?php echo set_value('setting_value'); ?>" name="setting_value" type="text" />
				</div>
			</div><!-- End .control-group  -->
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Is Editable</label>
				<div class="col-lg-6">
					<div class="custom-control custom-radio custom-control-inline">
					  <input type="radio" class="custom-control-input" id="abc" name="is_editable" value="1" checked="checked" <?php if (isset($all_data['is_editable']) && $all_data['is_editable'] == '1') {	echo "checked";	} ?>>
					  <label class="custom-control-label" for="abc">Yes</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
					  <input type="radio" class="custom-control-input" id="def" <?php if (isset($all_data['is_editable']) && $all_data['is_editable'] == '0') {	echo "checked";	} ?> name="is_editable" value="0">
					  <label class="custom-control-label" for="def">No</label>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-offset-2">
					<div class="pad-left15">
						 <button type="submit" class="btn btn-primary">Save changes</button>
						 
						<button type="button" onclick="redirect_to('<?php echo base_url().'site_options'; ?>');" class="btn">Cancel</button>
						
						
					</div>
				</div>
			</div>
			
			<!-- End .form-group  -->
		</form>
	</div><!-- End .panel-body -->
</div><!-- End .widget -->
</div><!-- End .col-lg-12  --> 
</div><!-- End .row-fluid  -->

</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
