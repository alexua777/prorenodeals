
<section id="content">
<div class="wrapper">
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'sitemap'; ?>">Sitemap List</a></li>
        <li class="breadcrumb-item active"><a>Modify Sitemap</a> </li>
        </ol>
	</nav> 

<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default">
	<div class="panel-heading">		 
		<h5><i class="icon20 la la-check-square"></i> Add/Modify Sitemap</h5>
		<a href="#" class="minimize2"></a>
	</div><!-- End .panel-heading -->

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'sitemap/edit'; ?>" class="form-horizontal" role="form" name="state" method="post">			      
		   <input type="hidden" value="<?=$id?>" name="id"/>						
			<div class="row">
				<label class="col-lg-2 control-label" for="required">Enter  Name</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $name; ?>" name="name" class="required form-control">
					
				</div>
			</div><!-- End .control-group  -->
															
			<div class="row">
				<label class="col-lg-2 control-label" for="digits">Url</label>
				<div class="col-lg-6">
					<input class="form-control" value="<?php echo $url; ?>" name="url"/>
				</div>
			</div><!-- End .control-group  -->
			
			<div class="row">
            	<div class="col col-lg-2"></div>
				<div class="col-lg-6">
						 <button type="submit" class="btn btn-primary">Save</button>&nbsp;						 
						<button type="button" onclick="redirect_to('<?php echo base_url().'sitemap'; ?>');" class="btn btn-secondary">Cancel</button>
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
