<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'categories'; ?>">Category list</a></li>
        <li class="breadcrumb-item active">Add New Category</a></li>
      </ol>
    </nav>        
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">                     
                    <h5><i class="la la-plus-square"></i> Add Project Category</h5>
                    <a href="#" class="minimize2"></a>
                </div><!-- End .panel-heading -->

                <div class="panel-body"> 
                    <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>

                    <form id="validate" action="<?php echo base_url(); ?>categories/add" class="form-horizontal" role="form" name="adminmenu" method="post" enctype="multipart/form-data">


                        <?php
                        $p_id = $this->uri->segment(3);
                        if ($p_id == '') {
                            $p_id = set_value('parent_id');
                        }
                        if ($p_id != '') {
                            $p_name = $this->auto_model->getFeild('cat_name', 'categories', 'cat_id', $p_id);
                            ?>  




                            <div class="row">
                                <label class="col-md-3 col-form-label" for="required">Parent Name </label>
                                <div class="col-md-9">
                                    <input type="text" readonly="readonly" value="<?php echo $p_name; ?>" name="parent_id" class=" form-control">
                                    <input type="hidden" name="parent_id" value="<?php echo $p_id; ?>" />

                                </div>
                            </div>
                        <?php } ?>
						
						<div class="row">								
							<label class="col-md-3 col-form-label" for="required">Image(40px X 47px) </label>								
							<div class="col-md-9">									
							<div class="custom-file mt-1">									  
							<input type="file" class="custom-file-input" id="userfile" name="userfile">									  
							<label class="custom-file-label" for="userfile">Choose file</label>									
							</div>								
							</div>							
						</div>
						
                        <div class="row">
                            <label class="col-md-3 col-form-label" for="required">Category Name</label>
                            <div class="col-md-9">
                                <input type="text" id="required" value="<?php echo set_value('cat_name'); ?>" name="cat_name" class="required form-control">

                            </div>
                        </div> 
                        
                        <div class="row" hidden>
                            <label class="col-md-3 col-form-label" for="required">Arabic Category Name</label>
                            <div class="col-md-9">
                                <input type="text" id="required" value="<?php echo set_value('arabic_cat_name'); ?>" name="arabic_cat_name" class=" form-control">

                            </div>
                        </div> 
                        
                        <div class="row" hidden>
                            <label class="col-md-3 col-form-label" for="required">Spanish Category Name</label>
                            <div class="col-md-9">
                                <input type="text" id="required" value="<?php echo set_value('spanish_cat_name'); ?>" name="spanish_cat_name" class=" form-control">

                            </div>
                        </div> 
                        
                        <div class="row" hidden> 
                            <label class="col-md-3 col-form-label" for="required">Swedish Category Name</label>
                            <div class="col-md-9">
                                <input type="text" id="required" value="<?php echo set_value('swedish_cat_name'); ?>" name="swedish_cat_name" class=" form-control">

                            </div>
                        </div> 
                        
                        <div class="row" hidden>
                            <label class="col-md-3 col-form-label" for="required">Icon Class</label>
                            <div class="col-md-9">
                                <input type="text" value="<?php echo set_value('icon_class'); ?>" name="icon_class" class="form-control">

                            </div>
                        </div><!-- End .control-group  -->
                        
                        

					<div class="row">
                    <label for="radio" class="col-md-3 col-form-label">Status</label>
                    <div class="col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                          <label class="custom-control-label" for="status">Online </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                          <label class="custom-control-label" for="status_2">Offline</label>
                        </div>
                    </div>     
                    </div>          
               
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'categories/'; ?>');" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div><!-- End .row  -->

                    </form>
                </div><!-- End .panel-body -->
            </div><!-- End .widget -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
