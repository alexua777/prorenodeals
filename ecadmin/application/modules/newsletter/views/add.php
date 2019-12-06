<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'career'; ?>">Career List</a></li>
        <li class="breadcrumb-item active"><a>Add Career</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-plus-square"></i> Add Career job</h5>
          <a href="#" class="minimize2"></a> </div>
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>career/add" class="form-horizontal" role="form" name="career" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-lg-2 control-label" for="required">Enter Job Position</label>
              <div class="col-lg-9">
                <input type="text" id="position" name="position" value="<?php echo set_value('role');?>" class="form-control">
                <?php echo form_error('position', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            <div class="form-group">
              <label class="col-lg-2 control-label" for="agree">Add Logo</label>
              <div class="col-lg-6">
                <input class="form-control" type="file" id="userfile" name="userfile"/>
              </div>
            </div>
            <!-- End .control-group  -->
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Overview</label>
              <div class="col-lg-9">
                <textarea name="overview" id="overview" class="col-lg-7 valid form-control" rows="5" cols="40" id="required">
                <?php echo set_value('overview'); ?>
                </textarea>
                <?php echo display_ckeditor($overview); ?> <?php echo form_error('overview', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Responsiblity</label>
              <div class="col-lg-9">
                <textarea name="responsiblity" id="responsiblity" class="col-lg-7 valid form-control" rows="5" cols="40" id="required">
                <?php echo set_value('responsiblity'); ?>
                </textarea>
                <?php echo display_ckeditor($responsiblity); ?> <?php echo form_error('responsiblity', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Qualification</label>
              <div class="col-lg-9">
                <textarea name="qualification" id="qualification" class="col-lg-7 valid form-control" rows="5" cols="40" id="required">
                <?php echo set_value('qualification'); ?>
                </textarea>
                <?php echo display_ckeditor($qualification); ?> <?php echo form_error('qualification', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Extra</label>
              <div class="col-lg-9">
                <textarea name="extra" id="extra" class="col-lg-7 valid form-control" rows="5" cols="40"><?php echo set_value('extra'); ?></textarea>
                <?php echo display_ckeditor($extra); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Compensation</label>
              <div class="col-lg-9">
                <textarea name="compensation" id="compensation" class="col-lg-7 valid form-control" rows="5" cols="40" id="required">
                <?php echo set_value('compensation'); ?>
                </textarea>
                <?php echo display_ckeditor($compensation); ?> <?php echo form_error('compensation', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="digits">Contact</label>
              <div class="col-lg-9">
                <textarea name="contact" id="contact" class="col-lg-7 valid form-control" rows="5" cols="40"><?php echo set_value('contact'); ?></textarea>
                <?php echo display_ckeditor($contact); ?> <?php echo form_error('contact', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label for="radio" class="col-lg-2 control-label">Status</label>
              <label class="radio-inline">
              <div class="radio"><span>
                <input type="radio" id="status" name="status" value="Y"   checked="checked">
                </span> </div>
              Online
              </label>
              <label class="radio-inline">
              <div class="radio"><span class="checked">
                <input <?php echo set_checkbox('status', 'N'); ?> type="radio" id="status" name="status" Value="N">
                </span> </div>
              Offline
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" onclick="redirect_to('<?php echo base_url().'career'; ?>');" class="btn">Cancel</button>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
      <!-- End .widget --> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
