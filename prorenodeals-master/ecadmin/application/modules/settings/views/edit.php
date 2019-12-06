<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Site Settings Management</a> </li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php
            if ($this->session->flashdata('succ_msg')) {
                ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
        <?= $this->session->flashdata('succ_msg') ?>
      </div>
      <?php
            }
            if ($this->session->flashdata('error_msg')) {
                ?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
            }
            ?>
      <ul class="nav nav-pills nav-fill mb-3">
        <li class="nav-item"> <a class="nav-link active" href="<?= base_url() ?>settings/edit/45">Site Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/account_edit/45">Account Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/transfer_edit/45">Transfer Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/maintenance_setting/45">Site Under Maintenance</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/email_setting/1">Email Setting</a> </li>
      </ul>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-check-square"></i> Modify Site Settings</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>settings/edit/1" class="form-horizontal" enctype="multipart/form-data" role="form" name="settings" method="post">
            <input type="hidden" name="id" value="<?php echo $all_data['id'];  ?>" />
            <div class="row">
              <label class="col-md-3 col-form-label">Site Title</label>
              <div class="col-md-9">
                <input type="text" value="<?php echo $all_data['site_title']; ?>" name="site_title" class="  form-control">
                <?php echo form_error('site_title', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label">Meta Description</label>
              <div class="col-md-9">
                <textarea name="meta_desc" class="form-control elastic" rows="5"  cols="6" ><?php echo $all_data['meta_desc']; ?></textarea>
                <?php echo form_error('meta_desc', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            <div class="row">
              <label class="col-md-3 col-form-label">Meta Keys</label>
              <div class="col-md-9">
                <textarea name="meta_keys" class=" form-control elastic" rows="5"  cols="6"><?php echo $all_data['meta_keys']; ?></textarea>
                <?php echo form_error('meta_keys', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <?php /*?><div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Company Description</label>
                                    <div class="col-md-9">

                                <textarea name="comp_desc" class="  form-control elastic" rows="8"  cols="40" id=" "><?php echo $all_data['comp_desc']; ?></textarea>							 <?php echo form_error('comp_desc', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div><?php */?>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Admin Mail</label>
              <div class="col-md-9">
                <input type="email" value="<?php echo $all_data['admin_mail']; ?>" name="admin_mail" class="form-control">
                <?php echo form_error('admin_mail', '<label class="error" >', '</label>'); ?> </div>
            </div>
            <!-- End .control-group  -->
            
            <?php /*?><div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Career Mail</label>
                                    <div class="col-md-9">

                                        <input type="email" id=" " value="<?php echo $all_data['career_mail']; ?>" name="career_mail" class="  form-control">								 <?php echo form_error('career_mail', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Support Mail</label>
                                    <div class="col-md-9">

                                        <input type="email" id=" " value="<?php echo $all_data['support_mail']; ?>" name="support_mail" class="  form-control">							 <?php echo form_error('support_mail', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div>

      


                                <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Address</label>
                                    <div class="col-md-9">

                                        <textarea name="address" class="  form-control elastic" rows="5"  cols="40" id=" "><?php echo html_entity_decode($all_data['address']) ?></textarea>   <?php echo form_error('address', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div><?php */?>
            <div class="row">
              <label class="col-md-3 col-form-label" >Corporate Address</label>
              <div class="col-md-9">
                <textarea name="corporate_address" class=" form-control elastic" rows="5"  cols="40"><?php echo html_entity_decode($all_data['corporate_address']) ?></textarea>
                <?php echo form_error('corporate_address', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Map</label>
              <div class="col-md-9">
                <textarea name="map" class="  form-control elastic" rows="8"  cols="40" id=" "><?php echo html_entity_decode($all_data['map']); ?></textarea>
                <?php echo form_error('map', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Contact No</label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['contact_no']; ?>"  name="contact_no" class="  form-control">
                <?php echo form_error('contact_no', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <?php /*?><div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Office No</label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php echo $all_data['office_no']; ?>"  name="office_no" class="  form-control">	
                                         <?php echo form_error('office_no', '<label class="error" for=" ">', '</label>'); ?>
                                    </div>
                                </div><?php */?>
            <?php /*?><div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Corporate No</label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php echo $all_data['corporate_no']; ?>"  name="corporate_no" class="  form-control">	  <?php echo form_error('corporate_no', '<label class="error" for=" ">', '</label>'); ?>
                                    </div>
                                </div>



                                <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Telephone</label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php echo $all_data['telephone']; ?>"  name="telephone" class="  form-control">	
										 <?php echo form_error('telephone', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Customer Care No:</label>
                                    <div class="col-md-9">
                                        <input type="text" id=" " value="<?php echo $all_data['customer_care_no']; ?>" name="customer_care_no" class="  form-control">							 <?php echo form_error('customer_care_no', '<label class="error" for=" ">', '</label>'); ?>

                                    </div>
                                </div><?php */?>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Facebook</label>
              <div class="col-md-9">
                <input type="url" id=" " value="<?php echo $all_data['facebook']; ?>" name="facebook" class="  form-control">
                <?php echo form_error('facebook', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            
            <!--     <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Google Plus</label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php //echo $all_data['google_plus']; ?>" name="google_plus" class="  form-control">

                                    </div>
                                </div>-->
            
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Twitter</label>
              <div class="col-md-9">
                <input type="url" id=" " value="<?php echo $all_data['twitter']; ?>"  name="twitter" class="  form-control">
                <?php echo form_error('twitter', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">LinkedIn</label>
              <div class="col-md-9">
                <input type="url" id=" " value="<?php echo $all_data['linkedin']; ?>"  name="linkedin" class="  form-control">
                <?php echo form_error('linkedin', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Pinterest</label>
              <div class="col-md-9">
                <input type="url" id=" " value="<?php echo $all_data['pinterest']; ?>"  name="pinterest" class="  form-control">
                <?php echo form_error('pinterest', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label" for=" ">RSS</label>
              <div class="col-md-9">
                <input type="url" id=" " value="<?php echo $all_data['rss']; ?>"  name="rss" class="  form-control">
                <?php echo form_error('rss', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label" for=" ">Your Facebook APP ID </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['my_app_id']; ?>"  name="my_app_id" class="  form-control">
                <?php echo form_error('my_app_id', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label" for=" ">Your Facebook APP Secret </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['my_app_secret']; ?>"  name="my_app_secret" class="  form-control">
                <?php echo form_error('my_app_secret', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <?php /*?><div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Your Location API Key </label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php echo $all_data['my_app_key']; ?>"  name="my_app_key" class="  form-control">										 <?php echo form_error('my_app_key', '<label class="error" for=" ">', '</label>'); ?>


                                    </div>
                                </div><?php */?>
            
            <!--     <div class="row">
                                    <label class="col-md-3 col-form-label" for=" ">Youtube</label>
                                    <div class="col-md-9">

                                        <input type="text" id=" " value="<?php //echo $all_data['pinterest']; ?>"  name="pinterest" class="  form-control">


                                    </div>
                                </div>-->
            
            <div class="row">
              <label class="col-md-3 col-form-label" for="agree">Email Verification</label>
              <div class="col-md-9">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="abc" name="email_verify" value="Y" checked="checked" <?php if (isset($all_data['email_verify']) && $all_data['email_verify'] == 'Y') {	echo "checked";	} ?>>
                  <label class="custom-col-form-label" for="abc">On</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="def" <?php if (isset($all_data['email_verify']) && $all_data['email_verify'] == 'N') {	echo "checked";	} ?> name="email_verify" value="N">
                  <label class="custom-col-form-label" for="def">Off</label>
                </div>
              </div>
            </div>
            
            <!-- End .control-group  -->
            
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Job Expiration Days:</label>
              <div class="col-md-9">
                <input type="text" id="job_expiration" value="<?php echo $all_data['job_expiration']; ?>" name="job_expiration" class="form-control"/>
                Days <?php echo form_error('job_expiration', '<label class="error">', '</label>'); ?> </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Restricted words:</label>
              <div class="col-md-9">
                <textarea name="bad_words" class="form-control"><?php echo $all_data['bad_words']; ?></textarea>
              </div>
            </div>
            <?php if ($all_data['site_logo'] != '') { ?>
            <div class="row">
              <label class="col-md-3 col-form-label">Current Logo</label>
              <div class="col-md-9"> <img src="<?php echo SITE_URL . "assets/img/" . $all_data['site_logo']; ?>"  style="max-height: 80px;"/>
                <input type="hidden" value="<?php echo $all_data['site_logo']; ?>" name="site_logo" />
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <label class="col-md-3 col-form-label" >Choose Logo</label>
              <div class="col-md-9">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" value="" id="site_logo" name="site_logo">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
            </div>
            <?php if ($all_data['favicon'] != '') { ?>
            <div class="row">
              <label class="col-md-3 col-form-label">Current Favicon</label>
              <div class="col-md-9"> <img src="<?php echo SITE_URL . "assets/favicon/" . $all_data['favicon']; ?>"  style="max-height: 80px;"/>
                <input type="hidden" value="<?php echo $all_data['favicon']; ?>" name="favicon" />
              </div>
            </div>
            <?php } ?>
            <div class="row">
              <label class="col-md-3 col-form-label" >Choose Favicon</label>
              <div class="col-md-9">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" value="" id="favicon" name="userfile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Footer Text </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['footer_text']; ?>"  name="footer_text" class="form-control">
                <?php echo form_error('footer_text', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>			
			
			 <div class="row">
              <label class="col-md-3 col-form-label" for=" ">Free bids per month </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['free_bid_per_month']; ?>"  name="free_bid_per_month" class="  form-control">
                <?php echo form_error('free_bid_per_month', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
			
			<fieldset>			<legend><b>Analytics</b></legend>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">No of Customers </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['no_of_users']; ?>"  name="no_of_users" class="  form-control">
                <?php echo form_error('no_of_users', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
			
			 <div class="row">
              <label class="col-md-3 col-form-label" for=" ">No of Contractors </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['no_of_contractors']; ?>"  name="no_of_contractors" class="  form-control">
                <?php echo form_error('no_of_contractors', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
			
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">No of on-going projects </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['no_of_projects']; ?>"  name="no_of_projects" class="  form-control">
                <?php echo form_error('no_of_projects', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>
            <div class="row">
              <label class="col-md-3 col-form-label" for=" ">No of completed projects </label>
              <div class="col-md-9">
                <input type="text" id=" " value="<?php echo $all_data['no_of_completed_prolects']; ?>"  name="no_of_completed_prolects" class="  form-control">
                <?php echo form_error('no_of_completed_prolects', '<label class="error" for=" ">', '</label>'); ?> </div>
            </div>			</fieldset>
           
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home content(section-1) top:</label>
              <div class="col-md-9">
                <textarea name="content_sec1" class="form-control"><?php echo $all_data['content_sec1']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-2) header</label>
              <div class="col-md-9">
                <textarea name="content_sec2_header" class="form-control"><?php echo $all_data['content_sec2_header']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-2) body:</label>
              <div class="col-md-9">
                <textarea name="content_sec2_body" class="form-control"><?php echo $all_data['content_sec2_body']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Client say (Section-3):</label>
              <div class="col-md-9">
                <textarea name="content_sec3" class="form-control"><?php echo $all_data['content_sec3']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-4) left:</label>
              <div class="col-md-9">
                <textarea name="content_sec4_left" class="form-control"><?php echo $all_data['content_sec4_left']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-4) right:</label>
              <div class="col-md-9">
                <textarea name="content_sec4_right" class="form-control"><?php echo $all_data['content_sec4_right']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-5) bottom header:</label>
              <div class="col-md-9">
                <textarea name="content_sec5_header" class="form-control"><?php echo $all_data['content_sec5_header']; ?></textarea>
              </div>
            </div>
            <div class="row" hidden>
              <label class="col-md-3 col-form-label">Home Content(section-5)bottom body:</label>
              <div class="col-md-9">
                <textarea name="content_sec5_body" class="form-control"><?php echo $all_data['content_sec5_body']; ?></textarea>
              </div>
            </div>	
			
			<fieldset>			
			<legend><b>Dispute</b></legend>			
			<div class="row">              
				<label class="col-md-3 col-form-label">Dispute Respond Time (in Hours)</label>              
				<div class="col-md-9">                
				<input name="constant[DISPUTE_RESPOND_TIME]" class="form-control" value="<?php echo $all_data['DISPUTE_RESPOND_TIME']; ?>"/>
				</div>            
			</div>												
			</fieldset>	
			
			<fieldset>			
			<legend><b>Facebook Login</b></legend>			
			<div class="row">              
				<label class="col-md-3 col-form-label">Facebook APP ID</label>              
				<div class="col-md-9">                
				<input name="constant[FB_APP_ID]" class="form-control" value="<?php echo $all_data['FB_APP_ID']; ?>"/>       
				</div>            
			</div>											
			</fieldset>
			
			<fieldset>			
			<legend><b>Google Login</b></legend>			
			<div class="row">              
				<label class="col-md-3 col-form-label">API Key</label>              
				<div class="col-md-9">                
				<input name="constant[GOOGLE_API_KEY]" class="form-control" value="<?php echo $all_data['GOOGLE_API_KEY']; ?>"/>
				</div>            
			</div>						
			<div class="row">              
				<label class="col-md-3 col-form-label">Google Client ID</label>              
				<div class="col-md-9">                
				<input name="constant[GOOGLE_CLIENT_ID]" class="form-control" value="<?php echo $all_data['GOOGLE_CLIENT_ID']; ?>"/>				
				</div>            
			</div>						
			</fieldset>	
			
			
			<fieldset>			
			<legend><b>Google Captcha</b></legend>			
			<div class="row">             
			<label class="col-md-3 col-form-label">Google Captcha ( <b>Site Key</b>)</label>              
			<div class="col-md-9">                
			<input name="constant[GOOGLE_CAPTCHA_SITE_KEY]" class="form-control" value="<?php echo $all_data['GOOGLE_CAPTCHA_SITE_KEY']; ?>"/>
			</div>       	    
			</div>						
			<div class="row">              
			<label class="col-md-3 col-form-label">Google Captcha (<b> Secret Key</b>)</label>              
			<div class="col-md-9">               
			
			<input name="constant[GOOGLE_CAPTCHA_SECRET_KEY]" class="form-control" value="<?php echo $all_data['GOOGLE_CAPTCHA_SECRET_KEY']; ?>"/>			
			</div>            
			</div>						
			</fieldset>			
			
            <div class="row">
              <div class="col-md-9 offset-md-3">
                <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn btn-secondary">Cancel</button>
              </div>
            </div>
            <!-- End .row  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
      <!-- End .widget --> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
