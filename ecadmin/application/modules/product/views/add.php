<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>product/product_list/">Product List</a></li>

            </ul>
        </div>

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

                            <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                            <h4>Add New Product </h4>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                            <form id="validate" action="<?php echo base_url(); ?>product/add_product" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">



           <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Product Name</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control">
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
                    <option value="<?php echo $val['comp_id']?>"><?php echo $val['name']?></option>
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
					<input type="text" id="required" value="<?php echo set_value('batch'); ?>" name="batch" class="required form-control">
					<?php echo form_error('batch', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Product No</label>
				<div class="col-lg-6">
					<input type="text" id="product_no" value="<?php echo set_value('product_no'); ?>" name="product_no" class="required form-control" readonly="readonly"><input type="button" name="openbx" value="Generate Product No" onclick="gnrt()"/> 
					<?php echo form_error('product_no', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Manufacture Date</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('mdate'); ?>" name="mdate" class="required date form-control">
					<?php echo form_error('mdate', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Expiry Date</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('edate'); ?>" name="edate" class="required date form-control">
					<?php echo form_error('edate', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">NAFDAC No</label>
				<div class="col-lg-6">
					<input type="text" id="nafdc" value="<?php echo set_value('nafdac'); ?>" name="nafdac" class="required form-control">
					<?php echo form_error('nafdac', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Contact No.</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('phone'); ?>" name="phone" class="required form-control">
					<?php echo form_error('phone', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            <div class="form-group">
				<label class="col-lg-2 control-label" for="required">Email</label>
				<div class="col-lg-6">
					<input type="text" id="required" value="<?php echo set_value('email'); ?>" name="email" class="required form-control">
					<?php echo form_error('email', '<label class="error" for="required">', '</label>'); ?>
				</div>
			</div><!-- End .control-group  -->
            
            <div class="form-group">
              <label class="col-lg-2 control-label" for="agree">Status</label>
              <label class="checkbox-inline">
              <input class="form-control" type="radio" id="status" name="status" value="Y" checked="checked" />Online<input class="form-control" <?php echo set_checkbox('status', 'N'); ?> type="radio" id="status" name="status" Value="N">Offline
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
<script>
function gnrt()
{
	var naf=Math.floor(Math.random()*(9999999999999-1000000000000+1)+1000000000000);
	$('#product_no').val(naf);
}
</script>