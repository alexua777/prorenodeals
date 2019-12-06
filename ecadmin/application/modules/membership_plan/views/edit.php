<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>membership_plan/membership_plan_list/">Membership Plan List</a></li>
        <li class="breadcrumb-item active">Edit Membership</a></li>
      </ol>
    </nav>
        
        <div class="container-fluid">
              <?php
                if ($this->session->flashdata('succ_msg')) {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                    </div> 
                    <?php
                }
                if ($this->session->flashdata('error_msg')) {
                    ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                    </div>
<?php
}
?>
                <div class="panel panel-default">
                    <div class="panel-heading">                         
                        <h5><i class="la la-edit"></i> Edit Membership Plan </h5>
                        <a href="#" class="minimize2"></a>
                    </div><!-- End .panel-heading -->

                <div class="panel-body">
                <form id="validate" action="<?php echo base_url(); ?>membership_plan/edit_membership/<?php echo $all_data['id'];?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">Plan Name</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['name']; ?>" name="name" class="required form-control" readonly="readonly">
                <?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div><!-- End .control-group  -->
        
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">Plan Price</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['price']; ?>" name="price" class="required form-control">
                <?php echo form_error('price', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
        
        <div class="row">
        <label class="col-lg-2 col-md-3 col-form-label" for="userfile">Plan Icon</label>
            <div class="col-lg-10 col-md-9">
            <?php
            if($all_data['icon']!='')
            {
            ?>
                <img src="<?php echo SITE_URL;?>assets/plan_icon/<?php echo $all_data['icon'];?>" width="50" height="50"/><br />
            <?php	
            }
            ?>
                <div class="custom-file mt-1">
                  <input type="file" class="custom-file-input" id="userfile" name="userfile" value="<?php echo set_value('userfile'); ?>">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                                
                <label >Width: <font color="#FF0000">100px</font> &nbsp; Height: <font color="#FF0000">100px</font></label>
            </div>
        </div>
        
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">No of Project</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['project']; ?>" name="project" class="required form-control">
                <?php echo form_error('project', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
        
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">No of Skill</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['skills']; ?>" name="skills" class="required form-control">
                <?php echo form_error('skills', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
        
         <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">No of Bids</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['bids']; ?>" name="bids" class="required form-control">
                <?php echo form_error('bids', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
        
         <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">No of Portfolio</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['portfolio']; ?>" name="portfolio" class="required form-control">
                <?php echo form_error('portfolio', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div> 
        
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">Bidwin Charge (in %)</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['bidwin_charge']; ?>" name="bidwin_charge" class="required form-control">
                <?php echo form_error('bidwin_charge', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
        
        <div class="row">
            <label class="col-lg-2 col-md-3 col-form-label" for="required">Days</label>
            <div class="col-lg-10 col-md-9">
                <input type="text" id="required" value="<?php echo $all_data['days']; ?>" name="days" class="required form-control">
                <?php echo form_error('days', '<label class="error" for="required">', '</label>'); ?>
            </div>
        </div>
       
        <div class="row">
          <label class="col-lg-2 col-md-3 col-form-label" for="agree">Status</label>
          <div class="col-lg-10 col-md-9">          
          	<div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="status" name="status" value="Y" <?php if($all_data['status']=='Y'){echo "checked";} ?>>
              <label class="custom-control-label" for="status">Online</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if($all_data['status']=='N'){echo "checked";} ?>>
              <label class="custom-control-label" for="status_2">Offline</label>
            </div>
	</div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-3">&nbsp;</div>
			<div class="col-lg-10 col-md-9">
                    <input type="submit" name="submit" class="btn btn-primary" value="Update">&nbsp;
                    <button type="button" onclick="redirect_to('<?php echo base_url() . 'membership_plan/membership_plan_list/'; ?>');" class="btn btn-secondary">Cancel</button>                
            </div>
        </div>

        </form>
    </div><!-- End .panel-body -->
    </div><!-- End .widget -->            
        </div> 
    </div> 
</section>
