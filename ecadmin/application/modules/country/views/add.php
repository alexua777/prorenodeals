
<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a onclick="redirect_to('<?php echo base_url() . 'country'; ?>');">Country List</a></li>
                <li class="active">Add Country</a></li>
            </ul>
        </div>

        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-list-4"></i> Country Management </h1>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                            <h4>Add Country</h4>
                            <?php
                            if ($this->session->flashdata('succ_msg')) {
                                echo '<div class=" succ_msg alert-success">';
                                echo $this->session->flashdata('succ_msg');
                                echo '</div>';
                            }
                            if ($this->session->flashdata('error_msg')) {
                                echo '<div class="alert-error error_msg">';
                                echo $this->session->flashdata('error_msg');
                                echo '</div>';
                            }
                            ?>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
                            <form id="validate" action="<?php echo base_url(); ?>country/add/" class="form-horizontal" role="form" name="country" method="post" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="required">Country Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" id="required" value="<?php echo set_value('c_name'); ?>"  name="c_name" class="required form-control">
                                        <?php echo form_error('c_name', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="required">Site url</label>
                                    <div class="col-lg-6">
                                        <input type="text" id="required" value="<?php echo set_value('domain'); ?>"  name="domain" class="required form-control">
                                        <?php echo form_error('domain', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="url">Country Code</label>
                                    <div class="col-lg-3">

                                        <input id="curl"  value="<?php echo set_value('c_code'); ?>" type="text" name="c_code" class="required form-control" /><?php echo form_error('c_code', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="digits">Upload Country Flag</label>
                                    <div class="col-lg-3">
                                        <input type="file" name="userfile"  class="pass_inpu2" id="userfile">
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="digits">Order</label>
                                    <div class="col-lg-3">
                                        <input class="form-control" id="digits" value="<?php echo set_value('order_id'); ?>" name="order_id" type="type" />
                                        <?php echo form_error('order_id', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="url">Latitude</label>
                                    <div class="col-lg-3">

                                        <input id="curl"  value="<?php echo set_value('lat'); ?>" type="text" name="lat" class="required form-control" /><?php echo form_error('lat', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="url">Longitude</label>
                                    <div class="col-lg-3">

                                        <input id="curl"  value="<?php echo set_value('lng'); ?>" type="text" name="lng" class="required form-control" /><?php echo form_error('lng', '<label class="error" for="required">', '</label>'); ?>
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="form-group">
                                    <label for="radio" class="col-lg-2 control-label">Status</label>
                                    <label class="radio-inline">
                                        <div class="radio"><span>
                                                <input type="radio" id="status" name="status" value="Y"   checked="checked">
                                            </span>
                                        </div> Online
                                    </label>
                                    <label class="radio-inline">
                                        <div class="radio"><span class="checked">
                                                <input <?php echo set_checkbox('status', 'N'); ?> type="radio" id="status" name="status" Value="N">
                                            </span>
                                        </div> Offline
                                    </label>               
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'country'; ?>');" class="btn">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- End .form-group  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-12  --> 
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
