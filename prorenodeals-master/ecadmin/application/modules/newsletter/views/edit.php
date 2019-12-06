
<section id="content">
    <div class="wrapper">
     <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'career'; ?>">Job List</a></li>
		<li class="breadcrumb-item active"><a>Edit Career Job</a></li>
      </ol>
    </nav>         
        <div class="container-fluid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><i class="la la-edit"></i> Modify Career</h5>
                            <a href="#" class="minimize2"></a>
                        </div>
                        <div class="panel-body">
                        <form id="validate" action="<?php echo base_url(); ?>career/edit/<?php echo $id;?>" class="form-horizontal" role="form" name="cms" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                             <input type="hidden" name="currimg" value="<?php echo $image; ?>" />

			<div class="form-group">
				<label class="col-lg-2 control-label" for="required">Enter Job Position</label>
				<div class="col-lg-9">
					<input type="text" id="position" name="position" value="<?php echo $position;?>" class="form-control">
					<?php echo form_error('position', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
             <div class="form-group">
                    <label class="col-lg-2 control-label" for="agree">Add image</label>
                    <div class="col-lg-6">
                    <?php
                            if ($image!= '') {
                                ?>
                             
                            <img src="<?php echo SITE_URL . "assets/career_image/" . $image; ?>" style="max-height: 75px; max-width: 100px;" />

                            <?php }else{ ?>
                            
                              <img src="<?php echo SITE_URL . "assets/images/noimg.jpg" ; ?>" style="max-height: 75px; max-width: 100px;" />
                            <?php
                            
                            } ?><br />
                        <input class="form-control" type="file" id="userfile" name="userfile"/>
                </div>
            </div>
                                 <!-- End .control-group  -->
			<div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Overview</label>
				<div class="col-lg-9">
			<textarea name="overview" id="overview" class="col-lg-7 valid form-control" rows="5" cols="40"><?php echo $overview; ?></textarea>
			<?php echo display_ckeditor($coverview); ?>
            <?php echo form_error('overview', '<label class="error" for="required">', '</label>'); ?>
			</div>
			</div><!-- End .control-group  -->
			
            <div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Responsiblity</label>
				<div class="col-lg-9">
			<textarea name="responsiblity" id="responsiblity" class="col-lg-7 valid form-control" rows="5" cols="40"><?php echo $responsiblity; ?></textarea>
			<?php echo display_ckeditor($cresponsiblity); ?>
            <?php echo form_error('responsiblity', '<label class="error" for="required">', '</label>'); ?>
			</div>
			</div><!-- End .control-group  -->
            
            
            <div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Qualification</label>
				<div class="col-lg-9">
			<textarea name="qualification" id="qualification" class="col-lg-7 valid form-control" rows="5" cols="40"><?php echo $qualification; ?></textarea>
			<?php echo display_ckeditor($cqualification); ?>
            <?php echo form_error('qualification', '<label class="error" for="required">', '</label>'); ?>
			</div>
			</div><!-- End .control-group  -->
			
            <div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Extra</label>
				<div class="col-lg-9">
			<textarea name="extra" id="extra" class="col-lg-7 valid form-control" rows="5" cols="40" id="required"><?php echo $extra; ?></textarea>
			<?php echo display_ckeditor($cextra); ?>
			</div>
			</div><!-- End .control-group  -->
            
            <div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Compensation</label>
				<div class="col-lg-9">
			<textarea name="compensation" id="compensation" class="col-lg-7 valid form-control" rows="5" cols="40" id="required"><?php echo $compensation; ?></textarea>
			<?php echo display_ckeditor($ccompensation); ?>
            <?php echo form_error('compensation', '<label class="error" for="required">', '</label>'); ?>
			</div>
			</div><!-- End .control-group  -->
            
            <div class="form-group">
				<label class="col-lg-2 control-label" for="digits">Contact</label>
				<div class="col-lg-9">
			<textarea name="contact" id="contact" class="col-lg-7 valid form-control" rows="5" cols="40" id="required"><?php echo $contact; ?></textarea>
			<?php echo display_ckeditor($ccontact); ?>
            <?php echo form_error('contact', '<label class="error" for="required">', '</label>'); ?>
			</div>
			</div><!-- End .control-group  -->

                                <div class="form-group">
                                    <label for="radio" class="col-lg-2 control-label">Status</label>
                                    <label class="radio-inline">
                                        <div class="radio"><span><input type="radio" id="status" name="status" value="Y" checked="checked"  /></span></div> Online
                                    </label>
                                    <label class="radio-inline">
                                        <div class="radio"><span class="checked"><input <?php if ($status == 'N') {
                                            echo 'checked';
                                        } ?> type="radio" id="status" name="status" Value="N"></span></div> Offline
                                    </label>                                           
                                </div>

                                <!-- End .control-group  -->
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'career'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- End .form-group  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
