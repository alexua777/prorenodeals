<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'skills/'; ?>">Skills list</a></li>
        <li class="breadcrumb-item active">Edit Skills</a></li>
      </ol>
    </nav>

        <div class="container-fluid">           
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">                             
                            <h5><i class="la la-edit"></i> Edit Skills</h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                        	<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                            <form id="validate" action="<?php echo base_url(); ?>skills/edit/" class="form-horizontal" role="form" name="adminmenu" method="post" enctype="multipart/form-data">


                                <?php if ($parent_name != '') { ?>
                                    <div class="row">
                                        <label class="col-lg-2 col-md-3 col-form-label" for="required">Parent Name </label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" readonly="readonly" value="<?php echo $parent_name; ?>" name="parent_name" class=" form-control">


                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-md-3 col-form-label" for="required">Skill Image </label>
                                        <div class="col-lg-10 col-md-9">
                                        <?php
                                        if($image!='')
										{
										?>
                                        <input type="hidden" name="currimage" value="<?php echo $image;?>"/>
                                        <img src="<?php echo SITE_URL;?>assets/skill_image/<?php echo $image?>" alt="Skill image" width="60" height="55"/><br />
                                        <?php
										}
										?>
                                        <div class="custom-file mt-1">
                                          <input type="file" class="custom-file-input" id="userfile" name="userfile">
                                          <label class="custom-file-label" for="userfile">Choose file</label>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />

                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Skill Name</label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" id="required" value="<?php echo $skill_name; ?>" name="skill_name" class="required form-control">
                                       
                                    </div>
                                </div><!-- End .control-group  -->
								
								<div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Arabic Skill Name</label>
                                    <div class="col-lg-10 col-md-9">
                                     <input type="text"  value="<?php echo $arabic_skill_name; ?>" name="arabic_skill_name" class="form-control">

                                    </div>
                                </div><!-- End .control-group  -->
								
								<div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Spanish Skill Name</label>
                                    <div class="col-lg-10 col-md-9">
                                  <input type="text"  value="<?php echo $spanish_skill_name; ?>" name="spanish_skill_name" class="form-control">

                                    </div>
                                </div><!-- End .control-group  -->
								
								<div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Swedish Skill Name</label>
                                    <div class="col-lg-10 col-md-9">
                             <input type="text"  value="<?php echo $swedish_skill_name; ?>" name="swedish_skill_name" class="form-control">

                                    </div>
                                </div><!-- End .control-group  -->
								
                               <div class="row">
                                        <label class="col-lg-2 col-md-3 col-form-label" for="required">Skill Image </label>
                                        <div class="col-lg-10 col-md-9">
                                        <?php
                                        if($image!='')
										{
										?>
                                        <input type="hidden" name="currimage" value="<?php echo $image;?>"/>
                                        <img src="<?php echo SITE_URL;?>assets/skill_image/<?php echo $image?>" alt="Skill image" width="60" height="55"/><br />
                                        <?php
										}
										?>                                            
										<div class="custom-file mt-1">
                                          <input type="file" class="custom-file-input" id="customFile" name="userfile">
                                          <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        </div>
                                    </div>
                                <div class="row">
                                     <label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
                                     <div class="col-lg-10 col-md-9">
                                         <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                                          <label class="custom-control-label" for="status">Online</label>
                                         </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') { echo 'checked'; } ?>>
                                          <label class="custom-control-label" for="status_2">Offline</label>
                                        </div>       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">&nbsp;</div>
                  					<div class="col-lg-10 col-md-9">
                                            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'skills/'; ?>');" class="btn btn-secondary">Cancel</button>
                                        
                                    </div>
                                </div><!-- End .row  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-12  --> 
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
