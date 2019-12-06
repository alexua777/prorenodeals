<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo SITE_URL;?>assets/plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<section id="content">
<div class="wrapper">
  <?php 
            if($status=='O'){
                    $fnc = 'open';
            }elseif($status=='F'){
                    $fnc = 'frozen';
            }
            elseif($status=='P'){
                    $fnc = 'process';
            }
            elseif($status=='C'){
                    $fnc = 'complete';
            }
            elseif($status=='E'){
                    $fnc = 'expire';
            }
            ?>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url() ?>project/<?=$fnc?>">Project List</a></li>
      <li class="breadcrumb-item active"><a>Project Management</a></li>
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
        <h5><i class="la la-edit"></i> Edit/Modify Project </h5>
        <a href="#" class="minimize2"></a> </div>
      <!-- End .panel-heading -->
      
      <div class="panel-body">
        <form id="validate" action="<?php echo base_url(); ?>project/edit_project/<?php echo $status;?>/<?php echo $id;?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
        
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          
          <!-- End .control-group  -->
          
          <div class="form-group">
            <label class="control-label" for="required">Edit Description</label>
              <textarea class="form-control elastic" id="textarea1" name="description" rows="3"></textarea>
              <?php echo form_error('description', '<label class="error" for="required">', '</label>'); ?>
          </div>
          <!-- End .control-group  --> 
            <input type="submit" name="submit" class="btn btn-primary" value="Update" <?php if($status!='O'){ ?> style="display:none;" <? } ?>>&nbsp;
			<button type="button" onclick="redirect_to('<?php echo base_url() . 'project/'.$fnc; ?>');" class="btn btn-secondary" <?php if($status!='O'){ ?> style="display:none;" <? } ?>>Cancel</button>          
                    
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
