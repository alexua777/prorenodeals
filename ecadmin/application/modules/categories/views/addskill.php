<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'Categories'; ?>">Category list</a> </li>
        <li class="breadcrumb-item active"><a>Add New Skill</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-plus-square"></i> Add Project Skill</h5>
          <a href="#" class="minimize2"></a> </div>
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>categories/addskill/<?php echo $cat_id;?>" class="form-horizontal" role="form" name="adminmenu" method="post">
            <div class="form-group">
              <label class="col-form-label" for="required">Skill Name</label>
              <input type="text" id="required" value="<?php echo set_value('skill_name'); ?>" name="skill_name" class="required form-control">
            </div>
            <div class="form-group">
              <label for="radio" class="col-form-label">Status</label>
              <br />
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                <label class="custom-control-label" for="status">Online</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                <label class="custom-control-label" for="status_2">Offline</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'categories/'; ?>');" class="btn btn-secondary">Cancel</button>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
  </div>
</section>
