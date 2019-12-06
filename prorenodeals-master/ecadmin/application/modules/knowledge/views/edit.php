<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>knowledge/knowledge_list/">Knowledge List</a></li>
        <li class="breadcrumb-item active">Knowledge Management</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php
			$id = $this->uri->segment(3);
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
          <h5><i class="la la-edit"></i> Edit Knowledge </h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>knowledge/edit_knowledge/<?php echo $id;?>/" class="form-horizontal" role="form" name="state" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>" />
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label">Title</label>
              <div class="col-lg-10 col-md-9">
                <input type="text" value="<?php echo $all_data['title']; ?>" name="title" class="form-control">
                <?php echo form_error('title', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="required">Knowledge Type</label>
              <div class="col-lg-10 col-md-9">
                <select  name="knowledge_type" class="form-control">
                  <option value="">Please Select</option>
                  <?php
                            if (count($cat_data) > 0) {
                                foreach ($cat_data as $key => $val) {
                        ?>
                  <option value="<?php echo $val['id']?>" <?php if($val['id']==$all_data['knowledge_type']){echo "selected";}?>><?php echo $val['name']?></option>
                  <?php
                          }
                          }
                          ?>
                </select>
                <?php echo form_error('knowledge_type', '<label class="error">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="digits">Content</label>
              <div class="col-lg-10 col-md-9">
                <textarea name="knowledge_content" id="knowledge_content"  class="col-lg-7 form-control" rows="5" cols="40"><?php echo html_entity_decode($all_data['content']); ?></textarea>
                <?php echo display_ckeditor($ckeditor); ?> <?php echo form_error('knowledge_content', '<label class="error">', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Meta Title</label>
              <div class="col-lg-10 col-md-9">
                <input id="curl" value="<?php echo $all_data['meta_title']; ?>" type="text" name="meta_title" class="required form-control" />
                <?php echo form_error('meta_title', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Meta Keywords</label>
              <div class="col-lg-10 col-md-9">
                <input id="curl" value="<?php echo $all_data['meta_key']; ?>" type="text" name="meta_keys" class="required form-control" />
                <?php echo form_error('meta_keys', '<label class="error" for="required">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" >Meta Description</label>
              <div class="col-lg-10 col-md-9">
                <textarea class="form-control elastic" id="textarea1" name="meta_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 74px;"><?php echo html_entity_decode($all_data['meta_description'])?></textarea>
              </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="url">Enter Order</label>
              <div class="col-lg-10 col-md-9">
                <input id="order" value="<?php echo $all_data['order']; ?>" type="text" name="order" class="form-control" />
                <?php echo form_error('order', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <div class="row">
              <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>
              <div class="col-lg-10 col-md-9">
              	<div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data['status']) && $all_data['status'] == 'Y') { echo "checked";} ?>>
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if (isset($all_data['status']) && $all_data['status'] == 'N') {
    echo "checked"; } ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>               
                </div>
            </div>
            
            <!-- End .control-group  -->
            <div class="row">
              <div class="col-lg-2 col-md-3">&nbsp;</div>
              <div class="col-lg-10 col-md-9">
                <input type="submit" name="submit" class="btn btn-primary" value="Add">
                &nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'knowledge/knowledge_list/'; ?>');" class="btn btn-secondary">Cancel</button>
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
