<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>partner/">Partner List</a></li>
        <li class="breadcrumb-item active"><a>Add Partner</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php
            //$year = $this->uri->segment(3);
            ?>
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
          <h5><i class="la la-plus-square"></i> Add Partners</h5>
          <a href="#" class="minimize2"></a> </div>        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>partner/add" class="form-horizontal" role="form" name="team"  method="post" enctype="multipart/form-data">
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Name</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control">
                <?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Add Image</label>
              <div class="col-lg-10 col-md-9">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="userfile" name="userfile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
            </div>            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="elastic">URL</label>
              <div class="col-lg-10 col-md-9">
                <textarea class="required form-control elastic" id="textarea1" rows="3" name="url" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php echo set_value('url');?></textarea>
              </div>
            </div>            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>
              <div class="col-lg-10 col-md-9">
              	<div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N">
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
              <div class="col-lg-10 col-md-9">
                <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;                
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'partner/'; ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>            
          </form>
        </div>
      </div>      
    </div>
  </div>
</section>
