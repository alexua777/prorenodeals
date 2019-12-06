
<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
               <li class="breadcrumb-item"><a onclick="redirect_to('<?php echo base_url() . 'menulist'; ?>');">Admin menu list</a> </li>
            <li class="breadcrumb-item active">Add Administrator menu</a></li>
            </ol>
        </nav>

        <div class="container-fluid">            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><i class="la la-plus-square"></i> Add Administrator Menu</h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body"> 
                            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>

                            <form id="validate" action="<?php echo base_url(); ?>adminmenu/add" class="form-horizontal" role="form" name="adminmenu" method="post">


                                <?php
                                $p_id = $this->uri->segment(3);
                                if ($p_id == '') {
                                    $p_id = set_value('parent_id');
                                }
                                if ($p_id != '') {
                                    $p_name = $this->auto_model->getFeild('name', 'adminmenu', 'id', $p_id);
                                    ?>  
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Parent Name </label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input type="text" readonly="readonly" value="<?php echo $p_name; ?>" name="parent_id" class=" form-control">
                                        <input type="hidden" name="parent_id" value="<?php echo $p_id; ?>" />

                                    </div>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Name</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input type="text" id="required" value="<?php echo set_value('name'); ?>" name="name" class="required form-control">

                                    </div>
                                </div><!-- End .control-group  -->
                                
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Description</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input type="text" id="required" value="<?php echo set_value('title'); ?>" name="title" class="required form-control">

                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="url">URL</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input id="curl" value="<?php echo set_value('url'); ?>" type="text" name="url" class="required form-control" />
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="digits">Menu Order</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input class="form-control" id="digits" value="<?php echo set_value('ord'); ?>" name="ord" type="text" />
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="digits">Style Class</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input class="form-control" id="digits" value="<?php echo set_value('style_class'); ?>" name="style_class" type="text" />
                                    </div>
                                </div><!-- End .control-group  -->

                                <div class="row">
                            <label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
                            <div class="col-lg-10 col-md-9 col-xs-12">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                              <label class="custom-control-label" for="status">Online</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" id="status2" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                              <label class="custom-control-label" for="status2">Offline</label>
                            </div>  							                                                
                            </div>            
                       </div>
                        <div class="row">
                        	<div class="col-lg-2 col-md-3">&nbsp;</div>
                            <div class="col-lg-10 col-md-9 col-xs-12">                                
                                    <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                                    <button type="button" onclick="redirect_to('<?php echo base_url() . 'adminmenu'; ?>');" class="btn btn-secondary">Cancel</button>                              
                            </div>
                        </div><!-- End .row  -->

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-12  --> 
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
