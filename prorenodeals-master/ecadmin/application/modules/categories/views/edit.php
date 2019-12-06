<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'categories/'; ?>">Category list</a></li>
        <li class="breadcrumb-item active"><a>Edit Category</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Edit Category</h5>
          <a href="#" class="minimize2"></a> </div>        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>categories/edit/<?php echo $cat_id;?>" class="form-horizontal" role="form" name="adminmenu" method="post" enctype="multipart/form-data">
            <?php if ($parent_name != '') { ?>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Parent Name </label>
              <div class="col-lg-10 col-md-9">
                <input type="text" readonly="readonly" value="<?php echo $parent_name; ?>" name="parent_name" class=" form-control">
              </div>
            </div>
            <?php } ?>
            <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
            <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
			
			<div class="row">
				<label class="col-lg-2 col-md-3 col-form-label" for="required">Image (150px X 150px)</label>
				<div class="col-lg-10 col-md-9">
				<?php
				if($image!='')
				{
				?>
				<input type="hidden" name="currimage" value="<?php echo $image;?>"/>
				<img src="<?php echo SITE_URL;?>assets/skill_image/<?php echo $image?>" alt="Skill image" width="40" height="47" style="background-color: rgb(228, 228, 228);"/><br />
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
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $cat_name; ?>" name="cat_name" class="required form-control">
              </div>
            </div>            
            <div class="row" hidden>
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Arabic Category Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $arabic_cat_name; ?>" name="arabic_cat_name" class=" form-control">
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Spanish Category Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $spanish_cat_name; ?>" name="spanish_cat_name" class=" form-control">
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Swedish Category Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $swedish_cat_name; ?>" name="swedish_cat_name" class=" form-control">
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Icon Class</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="<?php echo $icon_class; ?>" name="icon_class" class="form-control">
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
                <button type="submit" class="btn btn-primary">Save</button>
                &nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'categories/'; ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .row  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>      
    </div>
  </div>
</section>
