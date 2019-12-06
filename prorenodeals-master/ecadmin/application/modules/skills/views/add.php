<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'skills/'; ?>">Skills list</a></li>
        <li class="breadcrumb-item active"><a>Add new Skills</a></li>
      </ol>
    </nav>        
    <div class="container-fluid">        
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><i class="la la-plus-square"></i> Add Skills</h5>
                        <a href="#" class="minimize2"></a>
                    </div><!-- End .panel-heading -->

                    <div class="panel-body"> 
                        <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>

                        <form id="validate" action="<?php echo base_url(); ?>skills/add" class="form-horizontal" role="form" name="adminmenu" method="post" enctype="multipart/form-data">


                            <?php
                            $p_id = $this->uri->segment(3);
                            if ($p_id == '') {
                                $p_id = set_value('parent_id');
                            }
                            if ($p_id != '') {
                                $p_name = $this->auto_model->getFeild('skill_name', 'skills', 'id', $p_id);
                                ?>  

                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Parent Name </label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" readonly="readonly" value="<?php echo $p_name; ?>" name="parent_id" class=" form-control">
                                        <input type="hidden" name="parent_id" value="<?php echo $p_id; ?>" />

                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Skill Image </label>
                                    <div class="col-lg-10 col-md-9">
                                        <div class="custom-file mt-1">
                                          <input type="file" class="custom-file-input" id="userfile" name="userfile">
                                          <label class="custom-file-label" for="userfile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <label class="col-lg-2 col-md-3 col-form-label" for="required">Skill Name</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" id="required" value="<?php echo set_value('skill_name'); ?>" name="skill_name" class="required form-control">

                                </div>
                            </div><!-- End .control-group  -->
                            
                            <div class="row">
                                <label class="col-lg-2 col-md-3 col-form-label" for="required">Arabic Skill Name</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" id="required" value="<?php echo set_value('arabic_skill_name'); ?>" name="arabic_skill_name" class="required form-control">

                                </div>
                            </div><!-- End .control-group  -->
                            
                            <div class="row">
                                <label class="col-lg-2 col-md-3 col-form-label" for="required">Spanish Skill Name</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" id="required" value="<?php echo set_value('spanish_skill_name'); ?>" name="spanish_skill_name" class="required form-control">

                                </div>
                            </div><!-- End .control-group  -->
                            
                            <div class="row">
                                <label class="col-lg-2 col-md-3 col-form-label" for="required">Swedish Skill Name</label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" id="required" value="<?php echo set_value('swedish_skill_name'); ?>" name="swedish_skill_name" class="required form-control">

                                </div>
                            </div><!-- End .control-group  -->
                            
                            

                        <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label">Status</label>
                        <div class="col-lg-10 col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                          <label class="custom-control-label" for="status">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input"  id="status_2" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
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
