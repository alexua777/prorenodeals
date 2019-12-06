<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'banner/page'; ?>">Banner List</a></li>
        <li class="breadcrumb-item active"><a>Add Banner</a></li>
      </ol>
    </nav>
        
	<div class="container-fluid">            
    <div class="panel panel-default">
        <div class="panel-heading">                             
            <h5><i class="la la-plus-square"></i> Add New Banner</h5>                            
        </div>

        <div class="panel-body">
            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
            <?php
            if($this->session->flashdata('error_msg'))
            {
            echo '<div class=" red alert ">'.$this->session->flashdata('error_msg').'</div>'; 
            }
            ?>
            <form id="validate" action="<?php echo base_url(); ?>banner/add" class="form-horizontal" role="form" name="banner" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label class="col-lg-2 col-md-3 col-form-label">Display For</label>
                    <div class="col-lg-10 col-md-9">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="display_for" name="display_for" value="D" onchange="desktop();"   checked="checked">
                      <label class="custom-control-label" for="display_for">Desktop</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" <?php echo set_checkbox('display_for', 'M'); ?> onchange="mobile();" id="display_for_2" name="display_for" value="M">
                      <label class="custom-control-label" for="display_for_2">Mobile</label>
                    </div> </div>                                                     
                </div>

                <div class="row" id="banner_type_loader" style="display: none">
                    <label class="col-lg-2 col-md-3 col-form-label"></label>
                    <div class="col-lg-10 col-md-9">
                        <img src="<?php echo SITE_URL . "assets/images/zoomloader.gif"; ?>" style="max-height: 75px; max-width: 100px;" />
                        Please wait...</div>
                </div>
                <span id="banner_type_position"></span>

                <div class="row">
                    <label class="col-lg-2 col-md-3 col-form-label" for="userfile">Image</label>
                    <div class="col-lg-10 col-md-9">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="userfile" name="userfile"  value="<?php echo set_value('userfile'); ?>">
                      <label class="custom-file-label" for="userfile">Choose file</label>
                    </div>                                                                    
                        <span id="img_size"><label >Width: <font color="#FF0000">1920px</font> &nbsp; Height: <font color="#FF0000">1080px</font></label></span>
                    </div>
                </div>
                
                <div class="row">
                <label class="col-lg-2 col-md-3 col-form-label">Title</label>
                <div class="col-lg-10 col-md-9">
                <input class="form-control" id="title" value="<?php echo set_value('title');?>" name="title" type="text" />
                </div>
                </div>
                <div class="row">
                <label class="col-lg-2 col-md-3 col-form-label">Description</label>
                <div class="col-lg-10 col-md-9">
                <textarea class="form-control" id="description" name="description" ><?php echo set_value('description');?></textarea>
                </div>
                </div>
                
                <div class="row">
                <label class="col-lg-2 col-md-3 col-form-label">Url</label>
                <div class="col-lg-10 col-md-9">
                <textarea class="form-control" id="url" name="url" ><?php echo set_value('url');?></textarea>
                <label >Please do not put <font color="#FF0000">http://</font> before your url.</label>
                </div>
                </div>
                
                <div class="row">
                    <label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
                    <div class="col-lg-10 col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                          <label class="custom-control-label" for="customRadioInline1">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                          <label class="custom-control-label" for="customRadioInline2">Offline</label>
                        </div>
                    </div>                                   
                </div>
                <div class="row">
                   <div class="col-lg-2 col-md-3">&nbsp;</div>
			  		<div class="col-lg-10 col-md-9">
                            <input type="submit" name="submit" class="btn btn-primary" value="Save"/>&nbsp;
                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'banner'; ?>');" class="btn btn-secondary">Cancel</button>
                        
                    </div>
                </div><!-- End .row  -->

            </form>
        </div><!-- End .panel-body -->
    </div>
                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
function desktop(){
	
		$('#img_size').html('<label >Width: <font color="#FF0000">1920px</font> &nbsp; Height: <font color="#FF0000">980px</font></label>');
}
function mobile(){
	
	$('#img_size').html('<label >Width: <font color="#FF0000">480px</font> &nbsp; Height: <font color="#FF0000">360px</font></label>');
}
</script>
