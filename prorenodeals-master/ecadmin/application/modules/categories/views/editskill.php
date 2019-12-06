<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a onclick="redirect_to('<?php echo base_url() . 'categories/'; ?>');">Category list</a></li>
        <li class="breadcrumb-item active"><a>Modify Skill</a> </li>
      </ol>
    </nav>    
    <div class="container-fluid">            
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><i class="la la-check-square"></i> Add/Modify Skill</h5>
            </div><!-- End .panel-heading -->

            <div class="panel-body">
                <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                <form id="validate" action="<?php echo base_url(); ?>categories/editskill/<?php echo $id;?>" class="form-horizontal" role="form" name="adminmenu" method="post">


                    
                    <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />

                    <div class="row">
                        <label class="col-md-3 control-label" for="required">Skill Name</label>
                        <div class="col-md-9">
                            <input type="text" id="required" value="<?php echo $skill_name; ?>" name="skill_name" class="required form-control">
                           
                        </div>
                    </div><!-- End .control-group  -->
                   
                    <div class="row">
						<label for="radio" class="col-md-3 control-label">Status</label>
                        <div class="col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status_1" name="status" value="Y" checked="checked">
                          <label class="custom-control-label" for="status_1">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status_2" <?php if ($status == 'N') { echo 'checked'; } ?> name="status" value="N">
                          <label class="custom-control-label" for="status_2">Offline</label>
                        </div>
                      </div>
					</div>
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" onclick="redirect_to('<?php echo base_url() . 'categories/viewskill/'.$cat_id; ?>');" class="btn btn-secondary">Cancel</button>                        </div>
                    </div><!-- End .form-group  -->

                </form>
            </div><!-- End .panel-body -->
        </div>
                <!-- End .widget -->
            

    </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
