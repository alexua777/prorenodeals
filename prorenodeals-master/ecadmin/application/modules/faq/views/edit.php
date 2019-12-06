<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>faq/faq_list/">FAQ List</a></li>
        <li class="breadcrumb-item active"><a>Edit FAQ</a></li>
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
              <h5><i class="la la-edit"></i> Add/Modify FAQ </h5>
              <a href="#" class="minimize2"></a> </div>
            <!-- End .panel-heading -->
            <div class="panel-body">
              <form id="validate" action="<?php echo base_url(); ?>faq/edit_faq/<?php echo $id;?>/" class="form-horizontal" role="form" name="state" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>" />
                <div class="form-group">
                  <label class="col-form-label">Question</label>
                  <input type="text" value="<?php echo $all_data['question']; ?>" name="question" class="form-control">
                  <?php echo form_error('question', '<label class="error" >', '</label>'); ?> </div>
                <div class="form-group">
                  <label class="col-form-label" for="required">FAQ Category</label>
                  <select  name="category" class="form-control">
                    <option value="">Please Select</option>
                    <?php
												if (count($cat_data) > 0) {
													foreach ($cat_data as $key => $val) {
											?>
                    <option value="<?php echo $val['id']?>" <?php if($val['id']==$all_data['faq_cat']){echo "selected";}?>><?php echo $val['name']?></option>
                    <?php
											  }
											  }
											  ?>
                  </select>
                  <?php echo form_error('category', '<label class="error">', '</label>'); ?> </div>
                
                
                <div class="form-group">
                  <label class="col-form-label" for="digits">Answer</label>
                    <textarea name="answers"  class="col-lg-7 form-control" rows="5" cols="40"><?php echo html_entity_decode($all_data['answers']); ?></textarea>
                    <?php echo display_ckeditor($ckeditor); ?> <?php echo form_error('answers', '<label class="error">', '</label>'); ?>
                </div>
                
                <div class="form-group">
                  <label class="col-form-label" for="url">Enter Order</label>
                  <input id="order" value="<?php echo $all_data['order']; ?>" type="text" name="order" class="form-control" />
                  <?php echo form_error('order', '<label class="error" >', '</label>'); ?> </div>
                <div class="form-group">
                  <label class="col-form-label" for="agree">Status</label><br />
                  <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked" <?php if (isset($all_data['status']) && $all_data['status'] == 'Y') {
    echo "checked";
} ?>>
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if (isset($all_data['status']) && $all_data['status'] == 'N') {
    echo "checked";
} ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>                  
                </div>
                  <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
                  <button type="button" onclick="redirect_to('<?php echo base_url() . 'faq/faq_list/'; ?>');" class="btn btn-secondary">Cancel</button>
                
              </form>
            </div>
            <!-- End .panel-body --> 
          </div>
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
