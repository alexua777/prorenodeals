
<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li> 
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'menulist'; ?>">Admin menu list</a></li>       
        <li class="breadcrumb-item active"><a>Edit Administrator menu</a></li>
      </ol>
    </nav>        

        <div class="container-fluid">            
		<div class="panel panel-default">
                        <div class="panel-heading">
                            <h5><i class="la la-edit"></i> Edit Administrator Menu</h5>
                            <a href="#" class="minimize2"></a>
                        </div>
                        <div class="panel-body">
                        	<?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                            <form id="validate" action="<?php echo base_url(); ?>adminmenu/edit/" class="form-horizontal" role="form" name="adminmenu" method="post">


                                <?php if ($parent_name != '') { ?>
                                    <div class="row">
                                        <label class="col-lg-2 col-md-3 col-form-label" for="required">Parent Name </label>
                                        <div class="col-lg-10 col-md-9 col-xs-12">
                                            <input type="text" readonly="readonly" value="<?php echo $parent_name; ?>" name="parent_id" class=" form-control">
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />

                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Name</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input type="text" id="required" value="<?php echo $name; ?>" name="name" class="required form-control">
                                       
                                    </div>
                                </div><!-- End .control-group  -->
                                
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="required">Description</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">

                                        <input type="text" id="required" value="<?php echo $title; ?>" name="title" class="required form-control">
                                        
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="url">URL</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input id="curl" value="<?php echo $url; ?>" type="text" name="url" class="required form-control" />
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="digits">Menu Order</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input class="form-control" id="digits" value="<?php echo $ord; ?>" name="ord" type="text" />
                                    </div>
                                </div><!-- End .control-group  -->
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label" for="digits">Style Class</label>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <input class="form-control" id="digits" value="<?php echo $style_class; ?>" name="style_class" type="text" />
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
                                          <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php if ($status == 'N') { echo 'checked'; } ?>>
                                          <label class="custom-control-label" for="status_2">Offline</label>
                                        </div>                                            
                                    </div>                                          
                                </div>
                                <div class="row">
                                    <div class="col-lg-10 col-md-9 col-xs-12"></div>
                                    <div class="col-lg-10 col-md-9 col-xs-12">
                                        <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                                        <button type="button" onclick="redirect_to('<?php echo base_url() . 'adminmenu'; ?>');" class="btn btn-secondary">Cancel</button>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
