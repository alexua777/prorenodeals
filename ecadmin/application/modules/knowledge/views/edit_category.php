<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'knowledge/category_list'; ?>">Knowledge list</a></li>
        <li class="breadcrumb-item active"><a>Edit Knowledge</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Edit Knowledge</h5>
          <a href="#" class="minimize2"></a> </div>        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>knowledge/edit_category/" class="form-horizontal" role="form" name="adminmenu" method="post">
            <?php if ($parent_name != '') { ?>
            <div class="form-group">
              <label class="col-form-label" for="required">Parent Name </label>
                <input type="text" readonly="readonly" value="<?php echo $parent_name; ?>" name="parent_name" class=" form-control">
            </div>
            <?php } ?>
            <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="form-group">
                <label class="col-form-label">Name</label>
                <input type="text" id="required" value="<?php echo $name; ?>" name="name" class="required form-control">
            </div>            
            <div class="form-group">
                <label class="col-form-label">Order</label>
                <input type="text" id="required" value="<?php echo $ord; ?>" name="ord" class="required form-control">
            </div>            
            <div class="form-group">
              <label class="col-form-label">Status</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') { echo 'checked'; } ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
            </div>
			<button type="submit" class="btn btn-primary">Save</button>&nbsp;
                  <button type="button" onClick="redirect_to('<?php echo base_url() . 'knowledge/category_list'; ?>');" class="btn btn-secondary">Cancel</button>
            
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
