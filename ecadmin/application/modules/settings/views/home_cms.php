<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Homepage CMS modify</a> </li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php
            if ($this->session->flashdata('succ_msg')) {
                ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php
            }
            if ($this->session->flashdata('error_msg')) {
                ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
            }
            ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-check-square"></i> Modify Home page cms</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>settings/homecms/1" class="form-horizontal" role="form" name="settings" method="post" enctype="multipart/form-data">
            <?php
                            foreach($all_data as $key=>$val)
							{
							?>
            <h5 class="text-uppercase"><?php echo $val['name'];?></h5>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Content Title</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" name="title_<?php echo $val['id'];?>" value="<?php echo $val['title']?>" class="form-control" />
              </div>
            </div>
            
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Logo</label>
              <div class="col-lg-10 col-md-9">
                <?php
                    if($val['image']!='')
					{
					?>
                <img src="<?php echo SITE_URL;?>assets/cms_image/<?php echo $val['image']?>" height="50" width="50"/><br>
                <?php	
					}
					?>
                <div class="custom-file mt-2">
                  <input type="file" name="image_<?php echo $val['id'];?>" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
            </div>
            
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Short description</label>
              <div class="col-lg-10 col-md-9">
                <textarea name="desc_<?php echo $val['id'];?>" class="form-control"><?php echo $val['desc']?></textarea>
              </div>
            </div>
            
            <!-- End .control-group  -->
            <?php	
							}
							?>
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
              <div class="col-lg-10 col-md-9">
                <button type="submit" class="btn btn-primary">Save</button>
                &nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .row  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
