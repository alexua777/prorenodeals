<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'add/page'; ?>">Advertise List</a></li>
                <li class="breadcrumb-item active">Add Advertise</li>
            </ol>
        </nav>
		
        <div class="container-fluid">                        
		<div class="panel panel-default">
                        <div class="panel-heading">                             
                            <h5><i class="la la-plus-square"></i> Add New Advertise</h5>
                            <a href="#" class="minimize2"></a>
                        </div><!-- End .panel-heading -->
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

                        <div class="panel-body">
                            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
                            <form id="validate" action="<?php echo base_url(); ?>add/add_advertise" class="form-horizontal" role="form" name="banner" method="post" enctype="multipart/form-data">
                                <div class="row">
                                	<div class="col-md-6">
                                    <label class="col-form-label">Choose Page</label>                                    
                                    <select name="page_name[]" for="required"  class="form-control" id="page_name" multiple="multiple">
                                        <option value="home">Home</option>
                                         <option value="login">Login</option>
                                          <option value="sitemap">Sitemap</option>
                                           <option value="postjob">Postjob</option>
                                            <option value="findtalent">Find talent</option>
                                             <option value="findjob">Find Job</option>
                                              <option value="contactus">Contact Us</option>
                                               <option value="aboutus">About Us</option>
                                                <option value="service_agreement">Service agreement</option>
                                                 <option value="refund_policy">Refund policy</option>
                                                  <option value="privacy_policy">Privacy policy</option>
                                                   <option value="faq">FAQ</option>
                                                    <option value="sitemap">Sitemap</option>
                                        <option value="success_tips">Success tips</option>
                                         <option value="dashboard">Dashboard</option>
                                          <option value="professional_profile">Professional Profile</option>
                                           <option value="client_profile">Client Profile</option>
                                            <option value="professional_project">Project Professional</option>
                                             <option value="client_project">Project client</option>
                                              <option value="myfinance">Myfinance</option>
                                               <option value="membership">Membership</option>
                                                <option value="dispute_list">Dispute list</option>
                                                 <option value="dispute_discussion">Dispute discussion</option>
                                                  <option value="edit_profile">Edit profile</option>
                                                   <option value="portfolio_list">Portfolio list</option>
                                                    <option value="add_portfolio">Add/Edit portfolio</option>
                                        <option value="feedback">Feedback</option>
                                         <option value="close_account">Close Account</option>
                                          <option value="inbox">Inbox</option>
                                           <option value="notification">Notification</option>
                                            <option value="referrence_list">Reference list</option>
                                             <option value="add_refereence">Add Reference</option>
                                              <option value="setting">Setting</option>
                                               <option value="teastimonial_details">Testimonial Details</option>
                                                <option value="terms_condition">Terms and Condition</option>
                                    </select>	
                                    </div>
                                    <div class="col-md-6">
                                    	<label class="col-form-label">Position</label>
                                    	<select name="position[]" for="required"  class="form-control" id="position" multiple="multiple">
                                        	<option value="H">Header</option>
                                         	<option value="M">Middle</option>
                                            <option value="F">Footer</option>                                              
                                        </select>
                                    </div>
                                </div>
                               
                                
                               <div class="form-group">
                                    <label class="col-form-label">Ad Type</label><br />
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="type" name="type" value="B" checked="checked" onclick="javascript:yesnoCheck();">
                                      <label class="custom-control-label" for="type">Banner</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="type1" name="type" value="A" onclick="javascript:yesnoCheck();" <?php echo set_checkbox('type', 'A'); ?>>
                                      <label class="custom-control-label" for="type1">Adsense</label>
                                    </div>                                    
                                </div>
                                
                                <div class="form-group" id="show1" style="display:none">
								<label class="col-form-label">Advert Code</label>
								<div class="col-lg-3">
								<textarea class="form-control" id="advertise_code"  name="advertise_code"></textarea>
								</div>
                                </div>
                                <div id="ban">
                                <div class="form-group">
                                    <label class="col-form-label" for="userfile">Image</label>
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="userfile" name="userfile" value="<?php echo set_value('userfile'); ?>">
                                      <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>															
									<label ><font color="#FF0000">Width:</font> 728px; <font color="#FF0000">Height:</font> 90px;</label>
                                </div>
                                
                                <div class="form-group">
								<label class="col-form-label">Banner Url</label>								
								<textarea class="form-control" id="banner_url" name="banner_url" ><?php echo set_value('banner_url');?></textarea>
                                <label >Please do not put <font color="#FF0000">http://</font> before your url.</label>								
                                </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="radio" class="col-form-label">Status</label><br />
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                                      <label class="custom-control-label" for="status">Online</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" class="custom-control-input" id="status_2" name="status" Value="N" <?php echo set_checkbox('status', 'N'); ?>>
                                      <label class="custom-control-label" for="status_2">Offline</label>
                                    </div>                                                                                       
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save">&nbsp;
                                <button type="button" onclick="redirect_to('<?php echo base_url() . 'add'; ?>');" class="btn btn-secondary">Cancel</button>

                            </form>
                        </div><!-- End .panel-body -->
                    </div>
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
