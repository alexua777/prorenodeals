<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
	<li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
	<li class="active"><a onclick="redirect_to('<?php echo base_url() . 'news'; ?>');">News List</a></li>
	<li class="active">Add News</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
	<h1><i class="icon20 i-list-4"></i>News/Article Management</h1>
</div>
<script>
$(function() {
$("#strtdt").datepicker();
});
</script>	
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
				<h4>Add New News/Article</h4>
				<a href="#" class="minimize2"></a>
			</div><!-- End .panel-heading -->

			<div class="panel-body">
				<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
				<form id="validate" action="<?php echo base_url(); ?>news/add" class="form-horizontal" role="form" name="news" method="post" enctype="multipart/form-data">
				    <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Select Type</label>
						<div class="col-lg-6">
							<select name="type" for="required"  class="select2 select_type required  form-control">
							   <option value="">Select Type</option>	
                               <option value="news">News</option>
                               <option value="article">Article</option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="required">Title</label>
						<div class="col-lg-6">
							<input type="text" id="required" value="<?php echo set_value('title'); ?>" name="title" class="required form-control">
							<?php echo form_error('order', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div>
					
                    
                    <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Description</label>
						<div class="col-lg-6">
                          <textarea name="description" id="text-editor" class="col-lg-7 valid form-control" rows="15" cols="40" id="required"></textarea>				 
						  <?php echo form_error('description', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div>
					
                    <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Date</label>
						<div class="col-lg-6">
						   <input style= "width:514px;" name="news_date" type="text" class="required form-control" id="strtdt" value="<?php echo set_value('news_date'); ?>" />
						   <?php echo form_error('news_date', '<label class="error" for="required">', '</label>'); ?>	
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
						<label class="col-lg-2 control-label" for="agree">Status</label>
						<label class="checkbox-inline">
							<input class="form-control" type="radio" id="status" name="status" value="Y"   checked="checked">Online<input class="form-control" <?php echo set_checkbox('status', 'N'); ?> type="radio" id="status" name="status" Value="N">Offline
						</label>
					</div><!-- End .control-group  -->
					<div class="form-group">
						<div class="col-lg-offset-2">
							<div class="pad-left15">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button type="button" onclick="redirect_to('<?php echo base_url() . 'news'; ?>');" class="btn">Cancel</button>
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
