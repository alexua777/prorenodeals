
<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a onclick="redirect_to('<?php echo base_url() . 'addpos/page'; ?>');">Advertise type list</a></li>
                <?php
                if ($id == "") {
                    echo '<li class="active">Add advertise position</li>';
                } else {
                    echo '<li class="active">Modify advertise position</li>';
                }
                ?>
            </ul>
        </div>

        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-list-4"></i>Advertise position management </h1>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="icon"><i class="icon20 i-stack-checkmark"></i></div>
                            <?php
                            if ($id == "") {
                                echo '<h4>Add advertise position</h4>';
                            } else {
                                echo '<h4>Modify advertise position</h4>';
                            }
                            ?>

                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->

                        <div class="panel-body">
<?php
if ($id == "") {
    ?>
                                <form id="validate" action="<?php echo base_url(); ?>addpos/add" class="form-horizontal" role="form" name="bannerpos" method="post">        
                                <?php
                            } else {
                                ?>
                                    <form id="validate" action="<?php echo base_url(); ?>addpos/edit" class="form-horizontal" role="form" name="bannerpos" method="post">
                                    <?php
                                }
                                ?>


                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />


<?php
if ($id == "") {
    ?>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="required">Select page name</label>
                                            <div class="col-lg-6">
                                                <select name="type" for="required"  class="select2 select_type required  form-control">
                                                    <option></option>
    <? foreach ($add as $key => $ban) { ?>
                                                        <option value="<? echo $ban['type']; ?>"><? echo str_replace("_", " ", $ban['type']); ?></option>
                                                    <? } ?>
                                                </select>	
                                            </div>
                                        </div>
    <?php
} else {
    ?>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="url">Page name</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="required" value="<?php echo $type; ?>" name="type" readonly="true" class="required form-control">	
                                            </div>
                                        </div><!-- End .control-group  -->
    <?php
}
?>




                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="required">Position</label>
                                        <div class="col-lg-6">
                                            <select name="position" for="required"  class="required  form-control">
                                                <option value="1" <?php
if ($position == '1') {
    echo 'selected';
}
?>>Top</option>
                                                <option value="2" <?php
                                                if ($position == '2') {
                                                    echo 'selected';
                                                }
                                                ?>>Left side</option>
                                                <option value="3" <?php
                                                if ($position == '3') {
                                                    echo 'selected';
                                                }
                                                ?>>Right side</option>
                                                <option value="4" <?php
                                                if ($position == '4') {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>Bottom</option>
                                                <option value="5" <?php
                                                if ($position == '5') {
                                                    echo 'selected';
                                                }
                                                ?>>Footer</option>
                                            </select>
                                                <?php echo form_error('position', '<label class="error" for="required">', '</label>'); ?>
                                        </div>
                                    </div><!-- End .control-group  -->

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="digits">Resolution</label>
                                        <div class="col-lg-1">
                                            <input class=" required form-control" id="digits" value="<?php echo $width; ?>" name="width" type="text"/>
                                            (Width)
<?php echo form_error('width', '<label class="error" for="required">', '</label>'); ?>
                                        </div>
                                        <div class="col-lg-1">
                                            <input class=" required form-control" id="digits" value="<?php echo $height; ?>" name="height" type="text"/>
                                            (Height)
<?php echo form_error('height', '<label class="error" for="required">', '</label>'); ?>
                                        </div>
                                    </div><!-- End .control-group  -->


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="agree">Price</label>
                                        <div class="col-lg-3">
                                            <input class=" required form-control" id="digits" value="<?php echo $price; ?>" name="price" type="text"/>

<?php echo form_error('price', '<label class="error" for="required">', '</label>'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="agree">Validity</label>
                                        <div class="col-lg-1">
                                            <input class=" required form-control" id="digits" value="<?php echo $validity; ?>" name="validity" type="text"/>
                                            (Days)
<?php echo form_error('validity', '<label class="error" for="required">', '</label>'); ?>
                                        </div> 
                                    </div>

                                    <!-- End .control-group  -->
                                    <div class="form-group">
                                        <div class="col-lg-offset-2">
                                            <div class="pad-left15">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                <button type="button" onclick="redirect_to('<?php echo base_url() . 'addpos/page'; ?>');" class="btn">Cancel</button>
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
