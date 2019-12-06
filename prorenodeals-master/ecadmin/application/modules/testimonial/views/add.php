<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>testimonial/">Testimonial List</a></li>
        <li class="breadcrumb-item active">Testimonial Management</a></li>
      </ol>
    </nav>
        <div class="container-fluid">
            
			<?php
            //$year = $this->uri->segment(3);
            ?>
				
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
                <h5><i class="la la-plus-square"></i> Add Testimonial</h5>            
                <a href="#" class="minimize2"></a>
            </div>
            <div class="panel-body">
      		<form id="validate" action="<?php echo base_url(); ?>testimonial/add" class="form-horizontal" role="form" name="team"  method="post" enctype="multipart/form-data">

					<div class="form-group">
                    <label class="col-form-label">User's Name</label>
                    <select name="user_id" id="select1" class="select2" placeholder="Select a User">
                    <option></option>
                    <?php
                    foreach($user as $key=>$val)
                    {
                    ?>
                    <option value="<?php echo $val['user_id'];?>"><?php echo $val['name'];?></option>
                    <?php	
                    }
                    ?>
                    </select>
                    <?php echo form_error('user_id', '<label class="error">', '</label>'); ?>
                </div>
                <!-- End .control-group  -->
                
                     
                            
            <div class="form-group">
            <label class="col-form-label" for="elastic">User's feedback</label>            
            <textarea class="required form-control elastic" id="textarea1" rows="3" name="description" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php echo set_value('description');?></textarea>
            </div>    
            
           
        <div class="form-group">
            <label class="col-form-label" for="agree">Status</label>   <br />                     
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
              <label class="custom-control-label" for="status">Online</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="status_2" name="status" value="N">
              <label class="custom-control-label" for="status_2">Offline</label>
            </div>
        </div>
        
        <input type="submit" name="submit" class="btn btn-primary" value="Add">&nbsp;
        <button type="button" onclick="redirect_to('<?php echo base_url() . 'testimonial/'; ?>');" class="btn btn-secondary">Cancel</button>
            

			</form>
            </div><!-- End .panel-body -->
        </div><!-- End .widget -->
                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
