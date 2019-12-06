
<script src="<?=JS?>mycustom.js"></script>

<section class="sec-60">
  <div class="container">
    <div class="row"> <?php echo $leftpanel;?> 
      <!-- Sidebar End -->
      <div class="col-md-9 col-sm-8 col-xs-12">
      <?php echo $breadcrumb;?>
        <ul class="tab">
          <li><a  class="selected" href="<?php echo VPATH;?>myfinance/" >Add Fund</a></li>
          <li><a  href="<?php echo VPATH;?>myfinance/milestone" >Milestone</a></li>
          <li><a  href="<?php echo VPATH;?>myfinance/withdraw" >Withdraw Fund</a></li>
          <li><a  href="<?php echo VPATH;?>myfinance/transaction" >Transaction History</a></li>
          <li><a  href="<?php echo VPATH;?>membership/" >Membership</a></li>
        </ul>
        <div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?><?php echo $balance;?></div>
        
        <!--EditProfile Start-->
        <h4>
          <?php 
	
	if($this->session->flashdata('succ_msg')){
	
		echo $this->session->flashdata('succ_msg');
	
	}elseif($this->session->flashdata('error_msg')){
	
		echo $this->session->flashdata('error_msg');
	
	}
	
	
	?>
        </h4>
        
          <div class="notiftext">
            <h6>Instruction</h6>
            <h6>Account Information</h6>
          </div>
          <div class="messagtext3">
            <h2><strong>Please transfer the amount you wish to add to your wallet into this account:<br>
              <p></p>
              If you have made the deposit, then <a style="float:none !important;" href="#" onClick="hds();">Click here</a>. </strong> </h2>
            <h3>Account Name : <?php echo BANK_AC_NAME;?><br>
              Account No : <?php echo BANK_AC;?><br>
              Bank Name : <?php echo BANK_NAME;?><br>
              Bank Address : <?php echo BANK_ADDRESS;?><br>
            </h3>
            <div id="frm" 
    <?php
    if(!form_error('trans_id') && !form_error('payee_name') && !form_error('dep_bank') && !form_error('dep_date') && !form_error('amount')){
	?>
    style="display:none;"<?php }?>>
            <form name="wire_account" class="form-horizontal" method="post" action="<?php echo VPATH?>myfinance/addFundWire">
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Transaction ID or Teller No :</label>
                  <input type="text" class="acount-input" id="trans_id" size="15" name="trans_id" tooltipText="Enter Your Transaction Id" value="<?php echo set_value('trans_id');?>" />
                  <?php echo form_error('trans_id', '<div class="error-msg2">','</div>'); ?> </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Amount</label>
                  <input type="text" id="amount" class="acount-input" name="amount" size="50" tooltipText="Enter Your Amount" value="<?php echo set_value('amount');?>" />
                  <?php echo form_error('amount', '<div class="error-msg2">','</div>'); ?>
                  </div>
              </div>
              
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Depositor's Name</label>
                  <input type="text" id="payee_name" class="acount-input" name="payee_name" size="50" tooltipText="Enter Payee Name" value="<?php echo set_value('payee_name');?>" />
                  <?php echo form_error('payee_name', '<div class="error-msg2">','</div>'); ?>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Bank Name</label>
                  <input type="text" id="dep_bank" name="dep_bank" class="acount-input" size="20" tooltipText="Deposited Bank Name" value="<?php echo set_value('dep_bank');?>" />
                  <?php echo form_error('dep_bank', '<div class="error-msg2">','</div>'); ?>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Bank Branch (Enter branch name or write "online")</label>
                  <input type="text" id="dep_branch" name="dep_branch" class="acount-input" size="20" tooltipText="Deposited Branch Name" value="<?php echo set_value('dep_branch');?>" />
                  <div class="focusmsg" id="dep_branchFocus" style="display:none"></div>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-xs-12">
                  <label>Transaction Date</label>
                  <input type="text" id="dep_date" class="acount-input" name="dep_date" size="30" readonly tooltipText="Transaction Date" value="<?php echo set_value('dep_date');?>" />
                  <?php echo form_error('dep_date', '<div class="error-msg2">','</div>'); ?>
                  </div>
              </div>
              
              <input type="submit" name="save_wire" class="submit_bott" value="Submit">
              <a href="<?php echo VPATH;?>myfinance/">
              <input type="button" name="cancel" class="submit_bott" value="Cancel">
              </a>
             
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
      <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
      <?php  
 }
  }

?>
    </div>
    <!-- Left Section End --> 
  </div>
  </div>
</section>
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
  function hds()
  {
		$('#frm').show();  
	}
	

</script>