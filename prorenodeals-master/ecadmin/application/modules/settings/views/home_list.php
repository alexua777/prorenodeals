<section id="content">
    <div class="wrapper">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Homepage module modify</a> </li>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5><i class="la la-check-square"></i> Modify Home page module</h5>
                        <a href="#" class="minimize2"></a>
                    </div><!-- End .panel-heading -->
    
                    <div class="panel-body">
                        <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                        <form id="validate" action="<?php echo base_url(); ?>settings/homepage/1" class="form-horizontal" role="form" name="settings" method="post">
                                
                    <div class="row">
                        <div class="col-md-6">
                        <label class="col-form-label">No. of testimonial shown</label><br />
                        <select name="testimonial_no" class="form-control">
                        <option value="">Please Select</option>
                        <?php
                        for($i=1;$i<=3;$i++)
                        {
                        ?>
                        <option value="<?php echo $i;?>" <?php if($all_data['testimonial_no']==$i){?> selected="selected"<?php }?>><?php echo $i;?></option>
                        <?php	
                        }
                        ?>
                        </select>
                        </div>
                        <div class="col-md-6">
                        <label class="col-form-label">No. of skill shown</label><br />
                        <input type="text" name="skill_no" value="<?php echo $all_data['skill_no']?>" class="form-control" />
                        </div>
                    </div>
                
                	<div class="row">
                        <div class="col-md-6">
                        <label class="col-form-label">Skill module view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" id="required" name="skills" value="Y" checked="checked" <?php if (isset($all_data['skills']) && $all_data['skills'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="required">On</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="skill_2" <?php if (isset($all_data['skills']) && $all_data['skills'] == 'N') {	echo "checked";	} ?> name="skills" value="N"><label class="custom-control-label" for="skill_2">Off</label>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Testimonial module view</label><br />
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="testimonial_1" name="testimonial" value="Y" checked="checked" <?php if (isset($all_data['testimonial']) && $all_data['testimonial'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="testimonial_1">On</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="testimonial_2" <?php if (isset($all_data['testimonial']) && $all_data['testimonial'] == 'N') {	echo "checked";	} ?> name="testimonial" value="N"><label class="custom-control-label" for="testimonial_2">Off</label>					
                            </div>
						</div>
					</div>
                
                <div class="row">
                	<div class="col-md-6">
                        <label class="col-form-label">CMS model view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" id="cms_1" name="cms" value="Y" checked="checked" <?php if (isset($all_data['cms']) && $all_data['cms'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="cms_1">On</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="cms_2" <?php if (isset($all_data['cms']) && $all_data['cms'] == 'N') {	echo "checked";	} ?> name="cms" value="N"><label class="custom-control-label" for="cms_2">Off</label>
                    	</div>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label">Counting module view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" id="counting_1" name="counting" value="Y" checked="checked" <?php if (isset($all_data['counting']) && $all_data['counting'] == 'Y') {	echo "checked";	} ?> />
            <label class="custom-control-label" for="counting_1">On</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="counting_2" <?php if (isset($all_data['counting']) && $all_data['counting'] == 'N') {	echo "checked";	} ?> name="counting" value="N"><label class="custom-control-label" for="counting_2">Off</label>
                        </div>
                    </div>
				</div>

                <div class="row">
                	<div class="col-md-6">
					<label class="col-form-label">Partner module view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="partner_1" name="partner" value="Y" checked="checked" <?php if (isset($all_data['partner']) && $all_data['partner'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="partner_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="partner_2" <?php if (isset($all_data['partner']) && $all_data['partner'] == 'N') {	echo "checked";	} ?> name="partner" value="N"><label class="custom-control-label" for="partner_2">Off</label>
                    </div>
                    </div>
                    <div class="col-md-6">
					<label class="col-form-label">Newsletter module view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="newsletter_1" name="newsletter" value="Y" checked="checked" <?php if (isset($all_data['newsletter']) && $all_data['newsletter'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="newsletter_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="newsletter_2" <?php if (isset($all_data['newsletter']) && $all_data['newsletter'] == 'N') {	echo "checked";	} ?> name="newsletter" value="N"><label class="custom-control-label" for="newsletter_2">Off</label>
					</div>                    
				</div>
				</div>
				
				
                <div class="row">
                	<div class="col-md-6">
					<label class="col-form-label">Posts module view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="posts_1" name="posts" value="Y" checked="checked" <?php if (isset($all_data['posts']) && $all_data['posts'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="posts_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="posts_2" <?php if (isset($all_data['posts']) && $all_data['posts'] == 'N') {	echo "checked";	} ?> type="radio" name="posts" value="N"><label class="custom-control-label" for="posts_2">Off</label></div>
                    </div>
                    <div class="col-md-6">
					<label class="col-form-label">Popular links module view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="popular_links_1" name="popular_links" value="Y" checked="checked" <?php if (isset($all_data['popular_links']) && $all_data['popular_links'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="popular_links_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="popular_links_2" <?php if (isset($all_data['popular_links']) && $all_data['popular_links'] == 'N') {	echo "checked";	} ?> type="radio" name="popular_links" value="N"><label class="custom-control-label" for="popular_links_2">Off</label></div>
				</div>
				</div>
				<button type="submit" class="btn btn-primary">Save</button>&nbsp;
				<button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn btn-secondary">Cancel</button>

                            </form>
                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-12  --> 
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
