
<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li><a href="#"><i class="icon16 i-home-4"></i>Home</a></li>
<li><a href="#">site settings</a></li>
<li class="active">setting List</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
<h1><i class="icon20 i-list-4"></i> Add/Modify settings </h1>
</div>

<div class="row">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
			<h4>Add/Modify settings</h4>
			<a href="#" class="minimize2"></a>
		</div><!-- End .panel-heading -->
	
		<div class="panel-body">
		
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
			<form id="validate" action="<?php echo base_url(); ?>settings/add" class="form-horizontal" role="form" name="state" method="post">
		   
			
	 
				 <input type="hidden" name="id" value="<?php echo $id; ?>" />
		   
				<div class="form-group">
					<label class="col-lg-2 control-label" for="required">Meta title</label>
					<div class="col-lg-6">
						
						<input type="text" id="required" value="<?php echo $meta_title; ?>" name="meta_title" class="required form-control">
						
					</div>
				</div><!-- End .control-group  -->
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Meta Keys</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $meta_keys; ?>" name="meta_keys" type="text" />
					</div>
				</div><!-- End .control-group  -->
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Meta Description</label>
					<div class="col-lg-3">
                    <textarea><?=$meta_desc?></textarea>
					</div>
				</div><!-- End .control-group  -->
				
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Upload Logo</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $upload_logo; ?>" name="userfiles" type="file" />
					</div>
				</div><!-- End .control-group  -->
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Company Description</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $comp_desc; ?>" name="comp_desc" type="text" />
					</div>
				</div><!-- End .control-group  -->
				
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Support Mail</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $support_mail; ?>" name="support_mail" type="text" />
					</div>
				</div><!-- End .control-group  -->
				
				
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Admin email</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $meta_keys; ?>" name="meta_keys" type="text" />
					</div>
				</div><!-- End .control-group  -->
				
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="digits">Meta Keys</label>
					<div class="col-lg-3">
						<input class="form-control" id="digits" value="<?php echo $meta_keys; ?>" name="meta_keys" type="text" />
					</div>
				</div><!-- End .control-group  -->
				
				
				
				
				
				
				
				<div class="form-group">
					<label class="col-lg-2 control-label" for="agree">Status</label>
					<label class="checkbox-inline">
						<input class="form-control" type="radio" id="status" name="status" value="Y" checked="checked"  />Online<input class="form-control" <?php if( $status =='N' ){ echo 'checked';  } ?> type="radio" id="status" name="status" Value="N">Offline
					</label>
				</div>
				
				<!-- End .control-group  -->
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
