      

<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">
<?php echo $breadcrumb;?>

<!--ProfileRight Start-->
<ul class="tab">
<li><a  href="<?php echo VPATH;?>myfinance/" >Add Fund</a></li>
<li><a  href="<?php echo VPATH;?>myfinance/milestone" >Milestone</a></li> 
<li><a  class="selected" href="<?php echo VPATH;?>myfinance/withdraw" >Withdraw Fund</a></li> 
<li><a  href="<?php echo VPATH;?>myfinance/transaction" >Transaction History</a></li> 
<li><a  href="<?php echo VPATH;?>membership/" >Membership</a></li> 
</ul>
<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?><?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="editprofile"> 	 	 	
<div class="notiftext">
	<h2>Financial Account</h2>	


<?php 
	
	if($this->session->flashdata('succ_msg')){
	
		echo $this->session->flashdata('succ_msg');
	
	}elseif($this->session->flashdata('error_msg')){
	
		echo $this->session->flashdata('error_msg');
	
	}
	
	
	?>

 </div>

<div class="whiteSec">

<form name="wire_account"  method="post">
			
				<input type="hidden" name="account_for" value="W"> 
				
				
				<div class="login_form">
				<label>Bank A/C No :</label>				
				
				<input type="text" class="form-control" id="wire_account_no" size="15" name="wire_account_no"  <?php if($bank_account[0]['wire_account_no'] !="") { ?> value ="<?php echo $bank_account[0]['wire_account_no']; ?>"<?php }else{ ?>value="<?php echo set_value('wire_account_no');?>"<?php }?> tooltipText="Enter Your Bank A/C No" />  
				<?php echo form_error('wire_account_no', '<div class="error-msg13">','</div>'); ?>
				</div>
				
				
				<div class="login_form">
				<label>A/C Name</label>
				
				<input type="text" id="wire_account_name" class="form-control" name="wire_account_name" size="50"   <?php if($bank_account[0]['wire_account_name'] !="") { ?> value ="<?php echo $bank_account[0]['wire_account_name']; ?>"<?php }else{ ?>value="<?php echo set_value('wire_account_name');?>" <?php }?> tooltipText="Enter Your Bank A/C Name">
				<?php echo form_error('wire_account_name', '<div class="error-msg13">','</div>'); ?>
				</div>
				
				
				
				<div class="login_form">
				<label>Swift/Bank Code</label>
				
				<input type="text" id="wire_account_IFCI_code" name="wire_account_IFCI_code" class="form-control" size="20"   <?php if($bank_account[0]['wire_account_IFCI_code'] !="") { ?> value ="<?php echo $bank_account[0]['wire_account_IFCI_code']; ?>"<?php }else{ ?>value="<?php echo set_value('wire_account_IFCI_code');?>" <?php }?> tooltipText="Enter Your Swift/Bank Code">
				<?php echo form_error('wire_account_IFCI_code', '<div class="error-msg13">','</div>'); ?>
				</div>
				
				
				
				<div class="login_form">
				<label>Street Address</label>
				
				<input type="text" id="address" class="form-control" name="address" size="50"  <?php if($bank_account[0]['address'] !="") { ?> value ="<?php echo $bank_account[0]['address']; ?>"<?php }else{ ?>value="<?php echo set_value('address');?>"<?php } ?> tooltipText="Enter Your Bank Street address">
				<?php echo form_error('address', '<div class="error-msg13">','</div>'); ?>
				
				</div>
				
				
				
				<div class="login_form">
				<label>City</label>
				<input type="text" id="city" name="city" class="form-control" size="50"  <?php if($bank_account[0]['city'] !="") { ?> value ="<?php echo $bank_account[0]['city']; ?>"<?php }else{ ?>value="<?php echo set_value('city');?>" <?php }?> tooltipText="Enter Your Bank City">
				<?php echo form_error('city', '<div class="error-msg13">','</div>'); ?>
				</div>
				
				
				<div class="login_form">
				<label>Country</label>
				
				<input type="text" id="country" name="country" class="form-control" size="50" <?php if($bank_account[0]['country'] !="") { ?> value ="<?php echo $bank_account[0]['country']; ?>"<?php }else{ ?> value="<?php echo set_value('country');?>" <?php } ?> tooltipText="Enter Your Bank Country">
				
				<?php echo form_error('country', '<div class="error-msg13">','</div>'); ?>

				</div>
				
				<div class="login_form">
				<label>Email</label>
				<input type="text" id="wire_account_email" name="wire_account_email" class="form-control" size="50" <?php if($bank_account[0]['wire_account_email'] !="") { ?> value ="<?php echo $bank_account[0]['wire_account_email']; ?>"<?php }else{ ?> value="<?php echo set_value('wire_account_email');?>" <?php } ?> />
				<?php echo form_error('wire_account_email', '<div class="error-msg13">','</div>'); ?>
				</div>
				
				<div class="login_form">
				
				<input type="submit" name="save_wire" class="btn-normal btn-color submit  bottom-pad" value="Submit">
				<a href="<?php echo VPATH;?>myfinance/withdraw"><input type="button" name="cancel" class="btn-normal btn-color submit  bottom-pad" value="Cancel"></a>
				</div>
			
			
			
			</form>	

</div>
	 
</div>
                  
                       
<?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
        
      if($type=='A'&& $code!=""){ 
?>
<div class="addbox">
 <?php 
   echo $code;
 ?>
</div>                      
<?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
        <div class="addbox">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>
            
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>