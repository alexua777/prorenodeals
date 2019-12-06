<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>faq/faq_list/">FAQ List</a></li>
        <li class="breadcrumb-item active"><a>Add FAQ</a></li>
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
              <h5><i class="la la-plus-square"></i> Add/Modify FAQ </h5>
              <a href="#" class="minimize2"></a> </div>
            <!-- End .panel-heading -->
            
            <div class="panel-body">
              <form id="validate" action="<?php echo base_url(); ?>faq/add_faq" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-form-label">Question</label>
                  <input type="text" id="question" value="<?php echo set_value('question'); ?>" name="question" class="form-control">
                  <?php echo form_error('question', '<label class="error">', '</label>'); ?> </div>
                
                
                <div class="form-group">
                  <label class="col-form-label">Faq Type</label>                  
                    <select id="category" name="category" class="form-control">
                      <option value="">Please Select</option>
                      <?php
                                        if (count($cat_data) > 0) {
                                			foreach ($cat_data as $key => $val) {
                                    ?>
                      <option value="<?php echo $val['id']?>" <?php echo set_select('category', $val['id']); ?>><?php echo $val['name']?></option>
                      <?php
                                      }
									  }
									  ?>
                    </select>
                    <?php echo form_error('category', '<label class="error">', '</label>'); ?> 
                </div>
                
                
                <div class="form-group">
                  <label class="col-form-label" for="digits">Answer</label>                  
                    <textarea name="answers" id="answers" class="col-lg-7 form-control" rows="5" cols="40"></textarea>
                    <?php echo display_ckeditor($ckeditor); ?> <?php echo form_error('answers', '<label class="error">', '</label>'); ?> 
                </div>
                
                
                <div class="form-group">
                  <label class="col-form-label">Enter Order</label>
                    <input id="order" value="<?php echo set_value('order'); ?>" type="text" name="order" class="form-control" />
                    <?php echo form_error('order', '<label class="error">', '</label>'); ?> 
                </div>
                
                
                <div class="form-group">
                  <label class="col-form-label">Status</label><br />
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                    <label class="custom-control-label" for="customRadioInline1">Online</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="status" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                    <label class="custom-control-label" for="customRadioInline2">Offline</label>
                  </div>                  
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'faq/faq_list/'; ?>');" class="btn btn-secondary">Cancel</button>

                
              </form>
            </div>
           </div>          
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
