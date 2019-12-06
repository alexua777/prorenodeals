
<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'cms'; ?>">Meta Section List</a></li>
        <li class="breadcrumb-item active"><a>Edit Meta Section</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Modify Meta Section</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>meta/edit/" class="form-horizontal" role="form" name="meta" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="form-group">
              <label class="col-form-label" for="url">Enter Page Name</label>
                <input id="pagename" readonly value="<?php echo $pagename; ?>" type="text" name="pagename" class="required form-control" />
                <?php echo form_error('pagename', '<label class="error" for="required">', '</label>'); ?> 
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-form-label" for="url">Meta Title</label>
                <input id="curl" value="<?php echo $meta_title; ?>" type="text" name="meta_title" class="required form-control" />
                <?php echo form_error('meta_title', '<label class="error" for="required">', '</label>'); ?> 
            </div>
            <div class="form-group">
              <label class="col-form-label" for="url">Meta Keywords</label>              
                <input id="curl" value="<?php echo $meta_keys; ?>" type="text" name="meta_keys" class="required form-control" />
                <?php echo form_error('meta_keys', '<label class="error" for="required">', '</label>'); ?> 
            </div>
            <div class="form-group">
              <label class="col-form-label" for="digits">Meta Description</label>
                <textarea class="form-control elastic" id="textarea1" name="meta_desc" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php echo $meta_desc ?></textarea>
              
            </div>
            <div class="form-group">
              <label for="radio" class="col-form-label">Status</label>
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') {
                                            echo 'checked';
                                        } ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
                            
            </div>
            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'meta'; ?>');" class="btn btn-secondary">Cancel</button>
            
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
      <!-- End .widget --> 
    </div>
    <!-- End .col-lg-12  --> 
  </div>
  <!-- End .row-fluid  -->
  
  </div>
  <!-- End .container-fluid  -->
  </div>
  <!-- End .wrapper  --> 
</section>
