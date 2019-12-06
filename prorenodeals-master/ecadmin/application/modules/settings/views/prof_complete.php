<section id="content">
<div class="wrapper">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Add/Modify Profile Completeness parameter</a></li>
      </ol>
	</nav> 


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
		<h5><i class="la la-check-square"></i> Set Profile Completeness Parameter</h5>
		<a href="#" class="minimize2"></a>
	</div><!-- End .panel-heading -->

	<div class="panel-body">
		<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
		<form id="validate" action="<?php echo base_url().'settings/profile_complete'; ?>" class="form-horizontal" role="form" name="state" method="post">

			<div class="row">
				<label class="col-md-3 col-form-label">Weightage for basic information</label>
				<div class="col-md-9">
                <div class="input-group">
                  <input type="text" value="<?php echo $all_data['basic_info']; ?>" name="basic_info" class="form-control">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
                </div>					              					
				</div>
			</div><!-- End .control-group  -->
            
            <div class="row">
				<label class="col-md-3 col-form-label">Weightage for social information</label>
				<div class="col-md-9">
                <div class="input-group">
					<input type="text" value="<?php echo $all_data['social_info']; ?>" name="social_info" class="form-control">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
				</div>	
				</div>
			</div><!-- End .control-group  -->
            
            <div class="row">
				<label class="col-md-3 col-form-label">Weightage for portfolio</label>
				<div class="col-md-9">
                <div class="input-group">
					<input type="text" value="<?php echo $all_data['portfolio_info']; ?>" name="portfolio_info" class="form-control">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
				</div>	
				</div>
			</div><!-- End .control-group  -->
            
            <div class="row">
				<label class="col-md-3 col-form-label">Weightage for skills information</label>
				<div class="col-md-9">
                <div class="input-group">
					<input type="text" value="<?php echo $all_data['skill_info']; ?>" name="skill_info" class="form-control">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
				</div>	
				</div>
			</div><!-- End .control-group  -->
            
            <div class="row">
				<label class="col-md-3 col-form-label">Weightage for finance information</label>
				<div class="col-md-9">
                <div class="input-group">
					<input type="text" value="<?php echo $all_data['finance_info']; ?>" name="finance_info" class="form-control">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
				</div>	
				</div>
			</div><!-- End .control-group  -->
            
            <div class="row">
				<label class="col-md-3 col-form-label">Weightage for reference information</label>
				<div class="col-md-9">
                <div class="input-group">
					<input type="text" value="<?php echo $all_data['reference_info']; ?>" name="reference_info" class="form-control">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">(in %)</span>
                  </div>
				</div>	
				</div>
			</div><!-- End .control-group  -->
			
			<div class="row">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url().'setting/edit/1'; ?>');" class="btn btn-secondary">Cancel</button>
			</div>
			</div><!-- End .row  -->
			
		</form>
	</div><!-- End .panel-body -->
</div>
</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
