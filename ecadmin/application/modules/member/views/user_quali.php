
<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>  
        <li class="breadcrumb-item"><a href="<?= base_url()?>member/member_list">Member List</a></li>      
        <li class="breadcrumb-item active"><a>Member Details</a></li>
      </ol>
    </nav> 
        
        
 
        <div class="container-fluid">
            

                  
                    <?php $this->load->view('top_nav');?>
						
                  <div class="panel-body">
				   <form id="validate" action="<?php echo base_url(); ?>member/update_member/<?php echo $user_details['user_id'];?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
					<input type="hidden" name="referrer" value="<?php echo base_url();?>member/view_qualification/<?php echo $user_details['user_id'];?>"/>
					
					<div class="form-group">
					<label class="col-lg-2 control-label" for="required">Qualification</label>
					<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $user_details['qualification']; ?>" name="qualification" class="required form-control">
					<?php echo form_error('certification', '<label class="error" for="required">', '</label>'); ?>
					</div>
					</div>
					
					<!-- End .control-group  -->
					<div class="form-group">
					<div class="col-lg-offset-2">
					<div class="pad-left15">
					<input type="submit" name="submit" class="btn btn-primary" value="Update">
					<button type="button" onclick="redirect_to('<?php echo base_url() . 'member/member_list/'; ?>');" class="btn">Cancel</button>
					</div>
					</div>
					</div><!-- End .form-group  -->
					
					</form>
				  </div>
				   

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
