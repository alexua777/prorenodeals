<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a onclick="redirect_to('<?php echo base_url() . 'email'; ?>');">Email List</a></li>
        <li class="breadcrumb-item active"><a>Add Email Template</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-plus-square"></i> Add Email Template</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>email/add" class="form-horizontal" role="form" name="email" method="post">
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Mail Type</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="type" value="<?php echo set_value('type'); ?>" name="type" class="form-control">
                <?php echo form_error('type', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Subject</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="subject" value="<?php echo set_value('subject'); ?>" name="subject" class="form-control">
                <?php echo form_error('subject', '<label class="error">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="template">Template</label>
              <div class="col-lg-9">
                <textarea name="template" id="contents" class="col-lg-7 form-control" rows="18" cols="40"></textarea>
                <?php echo display_ckeditor($ckeditor); ?> <?php echo form_error('template', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
				<div class="col-lg-10 col-md-9">
                  <button type="submit" class="btn btn-primary">Save </button>&nbsp;
                  <button type="button" onclick="redirect_to('<?php echo base_url() . 'email'; ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .row  -->
            
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
