<section id="content">
    <div class="wrapper">        
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>  
        <li class="breadcrumb-item"><a href="<?= base_url() ?>product/product_list/">Product List</a></li>      
        <li class="breadcrumb-item active"><a>Edit Product</a></li>
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
                            <h5><i class="la la-edit"></i> Edit/Modify Product </h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                            <form id="validate" action="<?php echo base_url(); ?>product/edit_product/<?php echo $all_data['id'];?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">



           <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Product Name</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['name']; ?>" name="name" class="required form-control">
					<?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Company Name</label>
				<div class="col-lg-6">
					<select id="required" name="company" class="required form-control">
                    <option value="">Please Select</option>
                    <?php
                    foreach($company as $key=>$val)
					{
					?>
                    <option value="<?php echo $val['comp_id']?>" <?php if($all_data['company']==$val['comp_id']){echo "selected";}?>><?php echo $val['name']?></option>
                    <?php
					}
					?>
                    </select>
					<?php echo form_error('company', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Model/Batch No</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['model_no']; ?>" name="batch" class="required form-control">
					<?php echo form_error('batch', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Product No</label>
				<div class="col-lg-6">
					<input type="text" id="nafdc" value="<?php echo $all_data['product_no']; ?>" name="product_no" class="required form-control" readonly="readonly">
					<?php echo form_error('product_no', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Manufacture Date</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['manufacture_date']; ?>" name="mdate" class="required date form-control">
					<?php echo form_error('mdate', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Expiry Date</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['expire_date']; ?>" name="edate" class="required date form-control">
					<?php echo form_error('edate', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">NAFDAC No</label>
				<div class="col-lg-6">
					<input type="text" id="nafdc" value="<?php echo $all_data['nafdac_no']; ?>" name="nafdac" class="required form-control">
					<?php echo form_error('nafdac', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Contact No.</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['phone']; ?>" name="phone" class="required form-control">
					<?php echo form_error('phone', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Email</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo $all_data['email']; ?>" name="email" class="required form-control">
					<?php echo form_error('email', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="agree">Status</label>
              <label class="checkbox-inline">
              <input class="form-control" type="radio" id="status" name="status" value="Y" <?php if($all_data['status']=='Y'){echo "checked";} ?> />Online<input class="form-control" <?php if($all_data['status']=='N'){echo "checked";} ?> type="radio" id="status" name="status" Value="N">Offline
              </label>
            </div>

                                <!-- End .control-group  -->
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <input type="submit" name="submit" class="btn btn-primary" value="Add">
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'product/product_list/'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- End .form-group  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
