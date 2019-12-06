<section id="content">
  <div class="wrapper">    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>   
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'add'; ?>">Advertise List</a></li>     
        <li class="breadcrumb-item active"><a>Edit Advertise</a></li>
      </ol>
    </nav>
    <div class="container-fluid"> 
      <script type="text/javascript">


function yesnoCheck() {
    var type=$('input[name=type]:checked').val();
	
	if(type=='B')
	{
		$('#ban').show();
		$('#show1').hide();	
	}
	else if(type=='A')
	{
		$('#show1').show();
		$('#ban').hide();		
	}
}

</script>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-edit"></i> Modify Advertise</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>add/edit/<?php echo $id; ?>/" class="form-horizontal" role="form" name="banner" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="row">
            <div class="col-md-6">
              <label class="col-form-label" for="required">Choose Page</label>
              
                <select name="page_name" for="required"  class="form-control" id="page_name" multiple="multiple" readonly>
                  <option value="home" <?php if($page_name=='home'){echo "selected";}?>>Home</option>
                  <option value="login" <?php if($page_name=='login'){echo "selected";}?>>Login</option>
                  <option value="sitemap" <?php if($page_name=='sitemap'){echo "selected";}?>>Sitemap</option>
                  <option value="postjob" <?php if($page_name=='postjob'){echo "selected";}?>>Postjob</option>
                  <option value="findtalent" <?php if($page_name=='findtalent'){echo "selected";}?>>Find talent</option>
                  <option value="findjob" <?php if($page_name=='findjob'){echo "selected";}?>>Find Job</option>
                  <option value="contactus" <?php if($page_name=='contactus'){echo "selected";}?>>Contact Us</option>
                  <option value="aboutus" <?php if($page_name=='aboutus'){echo "selected";}?>>About Us</option>
                  <option value="service_agreement" <?php if($page_name=='service_agreement'){echo "selected";}?>>Service agreement</option>
                  <option value="refund_policy" <?php if($page_name=='refund_policy'){echo "selected";}?>>Refund policy</option>
                  <option value="privacy_policy" <?php if($page_name=='privacy_policy'){echo "selected";}?>>Privacy policy</option>
                  <option value="faq" <?php if($page_name=='faq'){echo "selected";}?>>FAQ</option>
                  <option value="sitemap" <?php if($page_name=='sitemap'){echo "selected";}?>>Sitemap</option>
                  <option value="success_tips" <?php if($page_name=='success_tips'){echo "selected";}?>>Success tips</option>
                  <option value="dashboard" <?php if($page_name=='dashboard'){echo "selected";}?>>Dashboard</option>
                  <option value="professional_profile" <?php if($page_name=='professional_profile'){echo "selected";}?>>Professional Profile</option>
                  <option value="client_profile" <?php if($page_name=='client_profile'){echo "selected";}?>>Client Profile</option>
                  <option value="professional_project" <?php if($page_name=='professional_project'){echo "selected";}?>>Project Professional</option>
                  <option value="client_project" <?php if($page_name=='client_project'){echo "selected";}?>>Project client</option>
                  <option value="myfinance" <?php if($page_name=='myfinance'){echo "selected";}?>>Myfinance</option>
                  <option value="membership" <?php if($page_name=='membership'){echo "selected";}?>>Membership</option>
                  <option value="dispute_list" <?php if($page_name=='dispute_list'){echo "selected";}?>>Dispute list</option>
                  <option value="dispute_discussion" <?php if($page_name=='dispute_discussion'){echo "selected";}?>>Dispute discussion</option>
                  <option value="edit_profile" <?php if($page_name=='edit_profile'){echo "selected";}?>>Edit profile</option>
                  <option value="portfolio_list" <?php if($page_name=='portfolio_list'){echo "selected";}?>>Portfolio list</option>
                  <option value="add_portfolio" <?php if($page_name=='add_portfolio'){echo "selected";}?>>Add/Edit portfolio</option>
                  <option value="feedback" <?php if($page_name=='feedback'){echo "selected";}?>>Feedback</option>
                  <option value="close_account" <?php if($page_name=='close_account'){echo "selected";}?>>Close Account</option>
                  <option value="inbox" <?php if($page_name=='inbox'){echo "selected";}?>>Inbox</option>
                  <option value="notification" <?php if($page_name=='notification'){echo "selected";}?>>Notification</option>
                  <option value="referrence_list" <?php if($page_name=='referrence_list'){echo "selected";}?>>Reference list</option>
                  <option value="add_referrence" <?php if($page_name=='add_referrence'){echo "selected";}?>>Add Reference</option>
                  <option value="setting" <?php if($page_name=='setting'){echo "selected";}?>>Setting</option>
                  <option value="teastimonial_details" <?php if($page_name=='teastimonial_details'){echo "selected";}?>>Testimonial Details</option>
                  <option value="terms_condition" <?php if($page_name=='terms_condition'){echo "selected";}?>>Terms and Condition</option>
                </select>
              </div>
              <div class="col-md-6">
              <label for="radio" class="col-form-label">Position</label>
                <select name="position[]" for="required"  class="form-control" id="position" multiple="multiple" readonly>
                  <option value="H" <?php if($position=='H'){echo "selected";}?>>Header</option>
                  <option value="M" <?php if($position=='M'){echo "selected";}?>>Middle</option>
                  <option value="F" <?php if($position=='F'){echo "selected";}?>>Footer</option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="radio" class="col-form-label">Ad Type</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="type" name="type" value="B" onclick="javascript:yesnoCheck();" <?php if($type=='B'){?>checked="checked"<?php }?>>
                  <label class="custom-control-label" for="status">Banner</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="type1" name="type" Value="A" onclick="javascript:yesnoCheck();" <?php if($type=='A'){?>checked="checked"<?php }?>>
                  <label class="custom-control-label" for="type1">Adsense</label>
                </div>                              
            </div>
            <div class="form-group" id="show1" <?php if($type!='A'){?>style="display:none"<?php }?>>
                <label class="col-form-label">Advert Code</label>              
                <textarea class="form-control" id="advertise_code"  name="advertise_code"><?php echo $advertise_code;?></textarea>
            </div>
            
            <!-- End .control-group  -->
            <div id="ban" <?php if($type!='B'){?>style="display:none"<?php }?>>
              <div class="form-group">
                <label class="col-form-label" for="agree">Banner Image</label><br />
                
                  <?php
                        if ($banner_image != '') {
                            ?>
                  <input type="hidden" name="banner_image" value="<?php echo $banner_image;?>" />
                  <img src="<?php echo SITE_URL . "assets/ad_image/" . $banner_image; ?>" style="max-height: 75px; max-width: 100px;" />
                  <?php }else{ ?>
                  <img src="<?php echo SITE_URL . "assets/award_image/noimg.jpg" ; ?>" style="max-height: 75px; max-width: 100px;" />
                  <?php
                        
                        } ?>
                  
                  <div class="custom-file mt-2">
                      <input type="file" class="custom-file-input" id="userfile" name="userfile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                  </div>                  
                  <label ><font color="#FF0000">Width:</font> 728px; <font color="#FF0000">Height:</font> 90px;</label>
                
              </div>
              
              <!-- End .control-group  -->
              
              <div class="form-group">
                <label class="col-form-label" for="elastic">Banner URL</label>                
                  <textarea class="required form-control elastic" id="textarea1" rows="3" name="banner_url" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 76px;"><?php if(isset($banner_url)){ echo $banner_url;  }?>
</textarea>
                
              </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button>&nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url() . 'add'; ?>');" class="btn btn-secondary">Cancel</button>
          </form>
        </div>
        <!-- End .panel-body --> 
      </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
