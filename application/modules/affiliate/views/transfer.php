<script type="text/javascript">
	function setTotal(val){
		
		var p_c =  $('#processign_charge').val();
		var am_t =  $('#amount_transfer').val();
		var bal=$('#user_balance').val();
		
		if(am_t*1 > bal*1){
			$('#amount_transfer').val('');
			$('#amount_transfer').attr("placeholder", "Amount should not be greater than available balance");
			$('#total_amount').val('');
			}else{
			var t_a = (am_t*1-(p_c*am_t/100));
			$('#total_amount').val(t_a);
			$('#charge').val(p_c*am_t/100);
			}
		
	}
	
	
</script>


	<?php 
	
	
		if($tras_type =='p'){
			$transfar_through = 'PayPal';
			$processign_charge = $paypal_fees;
		
		}elseif($tras_type =='w'){
			$transfar_through = 'Wire Transfer';
			$processign_charge = $wire_transfer_fees;
		
		}
	
	
	
		foreach($bank_account as $bank_acc){
				
					if($bank_acc['account_for'] == strtoupper($tras_type)){
						$account_id = $bank_acc['account_id'];
					
					}
				
				}
	
	
	
	
	
	?>
            <!-- Title, Breadcrumb Start-->
            <?php echo $breadcrumb;?>      

			<script src="<?=JS?>mycustom.js"></script>
               <div class="container">
                  <div class="row">
                     <?php echo $leftpanel;?> 
                     <!-- Sidebar End -->
                     <div class="col-md-9 col-sm-8 col-xs-12">
                        
                        
<!--ProfileRight Start-->
<div class="profile_right">
<h1><a  class="selected" href="<?php echo VPATH;?>affiliate/withdraw" >Withdraw Fund</a></h1> 
<h1><a  href="<?php echo VPATH;?>affiliate/transaction" >Transaction History</a></h1> 

<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="editprofile"> 	 	 	
<div class="notiftext">
	<span style="color:#fff;" > Transfer through : <?php echo $transfar_through;?></span>	
<h4>


<?php 
	
	if($this->session->flashdata('succ_msg')){
	
		echo $this->session->flashdata('succ_msg');
	
	}elseif($this->session->flashdata('error_msg')){
	
		echo $this->session->flashdata('error_msg');
	
	}
	
	
	?>
</h4>

 </div>

<div class="methodbox">

	
	
	
	<div>
		
			<form name="transfer_save"  method="post">
			
				<input type="hidden" name="transfer_through" value="<?php echo strtoupper($tras_type);?>" /> 
				
				<input type="hidden" name="account_id" value="<?php echo $account_id;?>" />
				<div class="acount_form">
				<p>Balance Amount (<?php echo CURRENCY;?>)</p>
				
				
				<input type="text" class="acount-input" id="user_balance" size="15" name="user_balance"  value="<?php echo $balance;?>" readonly    />    <div class="focusmsg" id="user_balanceFocus" style="display:none">Your Current Balance</div>
                
	
				</div>
				
				
				<div class="acount_form">
				<p>Enter amount (<?php echo CURRENCY;?>)</p>
				
				<input type="text" id="amount_transfer" class="acount-input" name="amount_transfer" size="50" onkeyup="setTotal(this.value);"    tooltipText="Enter Amount to Transfer" />    <div class="focusmsg" id="amount_transferFocus" style="display:none">Enter amount you wish to withdraw. Please note this amount should be less  than your available balance and must be greater than processing charge</div>
				<?php echo form_error('amount_transfer', '<div class="error-msg3">','</div>'); ?>
				</div>
				
				
				
				<div class="acount_form">
				<p>Jobbid Fees (-%<?php echo $processign_charge;?>)</p>
				<input type="hidden" id="processign_charge" name="processign_charge" class="acount-input" size="20" value="<?php echo $processign_charge;?>" readonly   />
                <input type="text" id="charge" name="charge" class="acount-input" size="20" value="0.00" readonly   />    <div class="focusmsg" id="chargeFocus" style="display:none">Processing charge for withdraw money</div>
				</div>
				
				
				
				<div class="acount_form">
				<p>Freelancer Receives (<?php echo CURRENCY;?>)</p>
				<input type="text" id="total_amount" class="acount-input" name="total_amount" size="50"  readonly    />    <div class="focusmsg" id="total_amountFocus" style="display:none">Total amount you will receive after admin verification</div>
				
				
				</div>
				
				
				<div class="acount_form">
				<h4>
				<input type="submit" name="save_wire" class="submit_bott" value="Submit">
				<a href="<?php echo VPATH;?>affiliate/withdraw"><input type="button" name="cancle" class="submit_bott" value="Cancel"></a>
				</h4>
				</div>
			
			
			
			</form>
		
		
		
		
	</div>
	
	

</div>
	 
</div>
<!--EditProfile End-->

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