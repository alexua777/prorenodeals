<section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
<li class="active"><a href="<?php echo base_url(); ?>event/page">News List</a></li>
<li class="active">Edit News</li>
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
				<h5>Modify News </h5>
				<a href="#" class="minimize2"></a>
			</div><!-- End .panel-heading -->
		
			<div class="panel-body">
	<form id="validate" action="<?php echo base_url(); ?>event/edit/<?=$all_data['event_id']?>" class="form-horizontal" role="form" name="event" method="post">
			   <input type="hidden" name="id" value="<?php echo $all_data['event_id']; ?>" />
			
			   		<!-- End .control-group  -->
					<div class="form-group">
						<label class="col-lg-2 control-label" for="required">Enter News Title</label>
						<div class="col-lg-6">
							
							<input type="text" id="required" value="<?php if(isset($all_data['event_name'])){ echo $all_data['event_name'];  }?>" name="event_name" class="required form-control">
							<?php echo form_error('News title', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div><!-- End .control-group  -->
                                        
                                        
                                        
                       <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Description</label>
						<div class="col-lg-6">
                          <textarea name="event_desc" id="text-editor" class="col-lg-7 valid form-control" rows="15" cols="40"><?php if(isset($all_data['event_desc'])){ echo $all_data['event_desc'];  }?>
                          </textarea>				 
						  <?php echo form_error('Event Description', '<label class="error" for="required">', '</label>'); ?>
						</div>
					</div><!-- End .control-group  -->
					
                                        
                  <!-- End .control-group  -->
			
                        <div class="form-group">
						<label class="col-lg-2 control-label" for="required">Date</label>
							<div class="col-lg-6">
						   <input name="start_date" type="text" class="required form-control date_time" id="strtdt" value="<?php if(isset($all_data['start_date'])){ echo $all_data['start_date'];  }?>" />
                           <span class="help-block blue">(Example: dd/mm/yyyy hh:mm:ss)</span>
						   <?php echo form_error('start_date', '<label class="error" for="required">', '</label>'); ?>	
							</div>
						</div>
					<?php /*?><div class="form-group">
						<label class="col-lg-2 control-label" for="required">End date</label>
						<div class="col-lg-6">
						   <input name="end_date" type="text" class="required form-control date_time" id="enddt" value="<?php if(isset($all_data['end_date'])){ echo $all_data['end_date'];  }?>" />
                           <span class="help-block blue">(Example: dd/mm/yyyy hh:mm:ss)</span>
						   <?php echo form_error('end_date', '<label class="error" for="required">', '</label>'); ?>	
						</div>
					</div><?php */?>  
            <!-- End .control-group  -->      
					<div class="form-group">
						<div class="col-lg-offset-2">
							<div class="pad-left15">
								<input type="submit" name="submit" class="btn btn-primary" value="Save">
								<button type="button" onclick="redirect_to('<?php echo base_url(); ?>event/page');" class="btn">Cancel</button>
							</div>
						</div>
					</div><!-- End .form-group  -->
					
				</form>
			</div><!-- End .panel-body -->
		</div><!-- End .widget -->
	
</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
