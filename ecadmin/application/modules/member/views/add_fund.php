<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>member/member_list/">Member List</a></li>
        <li class="breadcrumb-item active"><a>Add fund</a></li>
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
          <h5><i class="la la-plus-square"></i> Add Fund </h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>member/add_fund/<?php echo $user_id;?>" class="form-horizontal" role="form" name="state" method="post" >
            <div class="form-group">
              <label class="col-form-label" for="required">Add Amount</label>
                <input type="text" id="required" value="0" name="amount" class="required form-control">
                <?php echo form_error('amount', '<label class="error" for="required">', '</label>'); ?>
            </div>
            <!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-form-label" for="required">Reason</label>              
                <input type="text" id="required" value="" name="reason" class="required form-control" >
                <?php echo form_error('reason', '<label class="error" for="required">', '</label>'); ?>
            </div>            
            <input type="submit" name="submit" class="btn btn-primary" value="Update">&nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'member/member_list/'; ?>');" class="btn btn-secondary">Cancel</button>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
  </div>
</section>
