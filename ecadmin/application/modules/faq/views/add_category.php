<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'faq/category_list'; ?>">Category list</a></li>
        <li class="breadcrumb-item active"><a>Add New Category</a></li>
      </ol>
    </nav>
    <div class="container-fluid">      
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-plus-square"></i> Add/Modify Faq Category</h5>
          <a href="#" class="minimize2"></a> </div>
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>faq/add_category" class="form-horizontal" role="form" name="adminmenu" method="post">
            <?php
			$p_id = $this->uri->segment(3);
			if ($p_id == '') {
				$p_id = set_value('parent_id');
			}
			if ($p_id != '') {
				$p_name = $this->auto_model->getFeild('name', 'faq_category', 'id', $p_id);
				?>
            <div class="form-group">
              <label class="col-form-label" for="required">Parent Name </label>
              <input type="text" readonly="readonly" value="<?php echo $p_name; ?>" name="parent_id" class=" form-control">
              <input type="hidden" name="parent_id" value="<?php echo $p_id; ?>" />
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="col-form-label">Category Name</label>
              <input type="text" id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control">
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-form-label" for="required">Order</label>
              <input type="text" id="required" value="<?php echo set_value('ord'); ?>" name="ord" class="required form-control">
            </div>
            
            
            <div class="form-group">
              <label for="radio" class="col-form-label">Status</label>
              <br />
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                <label class="custom-control-label" for="status">Online</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" <?php echo set_checkbox('status', 'N'); ?> id="status_2" name="status" value="N">
                <label class="custom-control-label" for="status_2">Offline</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;
            <button type="button" onClick="redirect_to('<?php echo base_url() . 'faq/category_list'; ?>');" class="btn btn-secondary">Cancel</button>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
