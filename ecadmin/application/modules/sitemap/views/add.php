
<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
<li class="active"><a onclick="redirect_to('<?php echo base_url() . 'sitemap'; ?>');">Sitemap List</a></li>
<li class="active">Add Sitemap</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
<h1><i class="icon20 i-list-4"></i> Add/Modify Sitemap  </h1>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
		<h4>Add/Modify Sitemap </h4>
		<a href="#" class="minimize2"></a>
	</div><!-- End .panel-heading -->

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'sitemap/add'; ?>" class="form-horizontal" role="form" name="state" method="post">
		
	      
		   
		
		
		
			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Enter  Name</label>
				<div class="col-lg-6">
					<input type="text"  id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control" placeholder="maximum length  100">
					
				</div>
			</div><!-- End .control-group  -->
			
			
			
			
			
			<div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Url</label>
				<div class="col-lg-6">
					<input class=" required form-control" value="<?php echo set_value('url'); ?>" name="url" />
				</div>
			</div><!-- End .control-group  -->
			
			<div class="form-group">
				<div class="col-lg-offset-2">
					<div class="pad-left15">
						 <button type="submit" class="btn btn-primary">Save changes</button>
						 
						<button type="button" onclick="redirect_to('<?php echo base_url().'sitemap'; ?>');" class="btn">Cancel</button>
						
						
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
