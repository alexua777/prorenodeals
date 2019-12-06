<section id="content">
    <div class="wrapper">
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Popular Links module modify</a> </li>
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
                            <h5><i class="la la-check-square"></i> Modify Poular Links module</h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->


                        <div class="panel-body">

                            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                            <form id="validate" action="<?php echo base_url(); ?>settings/popular/1" class="form-horizontal" role="form" name="settings" method="post">
                                
					<div class="row">
                    <div class="col-md-6">
					<label class="col-form-label">1. Terms &amp; Condition view</label><br />
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="required" name="terms" value="Y" checked="checked" <?php if (isset($all_data['terms']) && $all_data['terms'] == 'Y') {	echo "checked";	} ?>>
                      <label class="custom-control-label" for="required">On</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="off" name="terms" value="N" <?php if (isset($all_data['terms']) && $all_data['terms'] == 'N') {	echo "checked";	} ?>>
                      <label class="custom-control-label" for="off">Off</label>
                    </div> 
                    </div>    
                    <div class="col-md-6">
					<label class="col-form-label">2. Service Provider Agreement view</label>	<br />
                    <div class="custom-control custom-radio custom-control-inline">				
					<input type="radio" class="custom-control-input" id="on_2" name="service" value="Y" checked="checked" <?php if (isset($all_data['service']) && $all_data['service'] == 'Y') {	echo "checked";	} ?> />
                    <label class="custom-control-label" for="on_2">On</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="off_2" <?php if (isset($all_data['service']) && $all_data['service'] == 'N') { echo "checked"; } ?> name="service" value="N">
					<label class="custom-control-label" for="off_2">Off</label>
                    </div>
				</div>  
                	</div>
                    <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">3. Refund policy view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="refund_1" name="refund" value="Y" checked="checked" <?php if (isset($all_data['refund']) && $all_data['refund'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="refund_1">On</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="refund_2" name="refund" value="N" <?php if (isset($all_data['refund']) && $all_data['refund'] == 'N') {	echo "checked";	} ?>>
                        <label class="custom-control-label" for="refund_2">Off</label>
                        </div>
					</div>   
                    <div class="col-md-6">
                        <label class="col-form-label">4. Privacy policy view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            			<input type="radio" class="custom-control-input" id="privacy_1" name="privacy" value="Y" checked="checked" <?php if (isset($all_data['privacy']) && $all_data['privacy'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="privacy_1">On</label>
            			</div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="privacy_2" name="privacy" value="N" <?php if (isset($all_data['privacy']) && $all_data['privacy'] == 'N') {	echo "checked";	} ?>><label class="custom-control-label" for="privacy_2">Off</label>
                        </div>
                    </div>   
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">5. FAQ view</label><br />
                        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="faq_1" name="faq" value="Y" checked="checked" <?php if (isset($all_data['faq']) && $all_data['faq'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="faq_1">On</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="faq_2" class="custom-control-input" <?php if (isset($all_data['faq']) && $all_data['faq'] == 'N') {	echo "checked";	} ?> name="faq" value="N">
                        <label class="custom-control-label" for="faq_2">Off</label>
                        </div>
					</div>              
                    <div class="col-md-6">
                   <label class="col-form-label">6. Sitemap view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" class="custom-control-input" id="sitemap_1" name="sitemap" value="Y" checked="checked" <?php if (isset($all_data['sitemap']) && $all_data['sitemap'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="sitemap_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="sitemap_2" <?php if (isset($all_data['sitemap']) && $all_data['sitemap'] == 'N') {	echo "checked";	} ?> name="sitemap" value="N"><label class="custom-control-label" for="sitemap_2">Off</label>
                    </div>
				</div>         					
					</div>
				<div class="row">                				
				<div class="col-md-6">
                   <label class="col-form-label">7. Contact Us view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" name="contact" value="Y" checked="checked" <?php if (isset($all_data['contact']) && $all_data['contact'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="">On</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" <?php if (isset($all_data['contact']) && $all_data['contact'] == 'N') {	echo "checked";	} ?> name="contact" value="N"><label class="custom-control-label" for="">Off</label>
                        </div>
				</div>
                <div class="col-md-6">
                   <label class="col-form-label">8. Facebook view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" class="custom-control-input" id="facebook_1" name="facebook" value="Y" checked="checked" <?php if (isset($all_data['facebook']) && $all_data['facebook'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="facebook_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="facebook_2" <?php if (isset($all_data['facebook']) && $all_data['facebook'] == 'N') {	echo "checked";	} ?> name="facebook" value="N"><label class="custom-control-label" for="facebook_2">Off</label>
                    </div>
				</div>
				</div>
                <div class="row">
                <div class="col-md-6">
                   <label class="col-form-label">9. Twitter view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="twitter_1" name="twitter" value="Y" checked="checked" <?php if (isset($all_data['twitter']) && $all_data['twitter'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="twitter_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" <?php if (isset($all_data['twitter']) && $all_data['twitter'] == 'N') {	echo "checked";	} ?> type="radio" name="twitter" value="N"><label class="custom-control-label" for="twitter_2">Off</label>
                    </div>
				</div>
                
                <div class="col-md-6">
                   <label class="col-form-label">10. Pinterest view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="pinterest_1" name="pinterest" value="Y" checked="checked" <?php if (isset($all_data['pinterest']) && $all_data['pinterest'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="pinterest_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="pinterest_2" <?php if (isset($all_data['pinterest']) && $all_data['pinterest'] == 'N') {	echo "checked";	} ?> name="pinterest" value="N"><label class="custom-control-label" for="pinterest_2">Off</label>					
				</div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                   <label class="col-form-label">11. Linkedin view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
		<input class="custom-control-input" type="radio" id="linkedin_1" name="linkedin" value="Y" checked="checked" <?php if (isset($all_data['linkedin']) && $all_data['linkedin'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="linkedin_1">On</label>
        			</div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="linkedin_2" <?php if (isset($all_data['linkedin']) && $all_data['linkedin'] == 'N') {	echo "checked";	} ?> name="linkedin" value="N"><label class="custom-control-label" for="linkedin_2">Off</label>
                    </div>
				</div>
                
                <div class="col-md-6">
                   <label class="col-form-label">12. RSS view</label><br />
					<div class="custom-control custom-radio custom-control-inline">
					<input type="radio" class="custom-control-input" id="rss_1" name="rss" value="Y" checked="checked" <?php if (isset($all_data['rss']) && $all_data['rss'] == 'Y') {	echo "checked";	} ?> /><label class="custom-control-label" for="rss_1">On</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="rss_2" <?php if (isset($all_data['rss']) && $all_data['rss'] == 'N') {	echo "checked";	} ?> name="rss" value="N"><label class="custom-control-label" for="rss_2">Off</label>
                    </div>
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
