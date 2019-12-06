<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>banner/page">banner List</a></li>
        <li class="breadcrumb-item active">Edit Banner</a></li>
      </ol>
    </nav>        
        <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h5><i class="la la-edit"></i> Edit Banner Management</h5>
            </div>
            <!-- End .panel-heading -->
            <div class="panel-body">
                <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                <form id="validate" action="<?php echo base_url(); ?>banner/edit/<?php echo $id;?>" class="form-horizontal" role="form" name="banner" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        
                    <div class="row">
                     <label class="col-lg-2 col-md-3 col-form-label">Display For</label>
                     <div class="col-lg-10 col-md-9">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="display_for" name="display_for" <?php echo ($display_for == 'D')? 'checked="checked"':''; ?> value="D" onchange="desktop();">
                      <label class="custom-control-label" for="display_for">Desktop</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" onchange="mobile();" id="display_for_2" name="display_for" Value="M" <?php echo ($display_for == 'M')? 'checked="checked"':''; ?>  <?php echo set_checkbox('display_for', 'M'); ?>>
                      <label class="custom-control-label" for="display_for_2">Mobile</label>
                    </div>                                                               
                        
                        </div>
                    </div>	
                        
                    <div class="row" id="banner_type_loader" style="display: none">
                        <label class="col-lg-2 col-md-3 col-form-label" for="required"></label>
                        <div class="col-lg-10 col-md-9">
                            <img src="<?php echo SITE_URL . "assets/images/zoomloader.gif"; ?>" style="max-height: 75px; max-width: 100px;" />
                            Please wait...</div>
                    </div>
                    
                    <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label" for="required">Image</label>
                        <div class="col-lg-10 col-md-9">
                        <?php if ($image != '') { ?>
                                <img src="<?php echo SITE_URL . "assets/banner_image/" . $image; ?>" width="100" /><br />
                            <?php } ?>
                            <div class="custom-file mt-2">
                              <input type="file" class="custom-file-input" id="required"  name="userfile">
                              <label class="custom-file-label" for="required">Choose file</label>
                            </div>
                            <span id="img_size"><?php if($display_for == 'M'){ ?><label >Width: <font color="#FF0000">480px</font> &nbsp; Height: <font color="#FF0000">360px</font></label> <?php }else{ ?><label >Width: <font color="#FF0000">1920px</font> &nbsp; Height: <font color="#FF0000">1080px</font></label><?php } ?></span>
                        </div>
                    </div>
                    
                    <div class="row">
    <label class="col-lg-2 col-md-3 col-form-label">Title</label>
    <div class="col-lg-10 col-md-9">
        <input class="form-control" id="title" value="<?php echo $title; ?>" name="title" type="text" />
    </div>
                    </div>

                    <!-- End .control-group  -->
                    <div class="row">
    <label class="col-lg-2 col-md-3 col-form-label">Description</label>
    <div class="col-lg-10 col-md-9">
        <textarea class="form-control" id="description" name="description" ><?php echo $description;?></textarea>
    </div>
                    </div>
                    
                    <div class="row">
    <label class="col-lg-2 col-md-3 col-form-label">Url</label>
    <div class="col-lg-10 col-md-9">
        <textarea class="form-control" id="url" name="url" ><?php echo $url;?></textarea>
    </div>
                    </div>

                    <!-- End .control-group  -->
                    <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label">Status</label>
                        <div class="col-lg-10 col-md-9">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status" name="status" value="Y" <?php if($status=='Y'){?>checked="checked"<?php }?>>
                          <label class="custom-control-label" for="status">Online</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if($status=='N'){?>checked="checked"<?php }?>>
                          <label class="custom-control-label" for="status_2">Offline</label>
                        </div>                                                
                        </div>             
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2 col-md-3">&nbsp;</div>
			  			<div class="col-lg-10 col-md-9">
                                <input type="submit" class="btn btn-primary" name="submit" value="Save"/>&nbsp;
                                <button type="button" onclick="redirect_to('<?php echo base_url() . 'banner'; ?>');" class="btn btn-secondary">Cancel</button>
                            </div>                        
                    </div>
                    <!-- End .row  -->
                </form>
            </div>
            <!-- End .panel-body -->
        </div>
                    <!-- End .widget -->
                
            <!-- End .row-fluid  -->
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>
<script>
function desktop(){
	
		$('#img_size').html('<label >Width: <font color="#FF0000">1920px</font> &nbsp; Height: <font color="#FF0000">980px</font></label>');
}
function mobile(){
	
	$('#img_size').html('<label >Width: <font color="#FF0000">480px</font> &nbsp; Height: <font color="#FF0000">300px</font></label>');
}
</script>
