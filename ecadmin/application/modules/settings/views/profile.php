<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li><a href="#"><i class="icon16 i-home-4"></i>Home</a></li>
<li><a href="#">Library</a></li>
<li class="active">Data</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
<h1><i class="icon20 i-list-4"></i> Add/Modify State Menu </h1>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
		<h4>Add/Modify State Menu</h4>
		<a href="#" class="minimize2"></a>
	</div><!-- End .panel-heading -->

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'state/add'; ?>" class="form-horizontal" role="form" name="state" method="post">
		
	  
	 
		
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Enter State Name</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('state_name'); ?>" name="state_name" class="required form-control">
					
				</div>
			</div><!-- End .control-group  -->
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Select Country</label>
				<div class="col-lg-6">
					<select name="country_id" for="required" id="required">
	   <option selected>Select State</option>
	   <? foreach($add as $key=> $country ){ ?>
       <option value="<? echo $country['id'];?>"><? echo $country['c_name'];?></option>
        <? }?>
	   </select>	
<?php echo form_error('country_id', '<label class="error" for="required">', '</label>'); ?>	
					
				</div>
			</div>
			
			
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Order</label>
				<div class="col-lg-3">
					<input class="form-control" id="digits" value="<?php echo set_value('ord'); ?>" name="order_id" type="text" />
				</div>
			</div><!-- End .control-group  -->
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
						<button type="button" onclick="redirect_to('<?php echo base_url().'state'; ?>');" class="btn">Cancel</button>
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
