
<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>
<!-- Title, Breadcrumb End-->

<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">
                      
<!--ProfileRight Start-->
<div class="profile_right">

<h1><a  class="selected" href="<?php echo VPATH;?>affiliate/withdraw" >Withdraw Fund</a></h1> 
<h1><a  href="<?php echo VPATH;?>affiliate/transaction" >Transaction History</a></h1> 


<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?><?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="editprofile"> 	 	 	
<div class="notiftext">
<h2>Paypal Account Details</h2>



<?php 
	
	if($this->session->flashdata('succ_msg')){
	
		echo $this->session->flashdata('succ_msg');
	
	}elseif($this->session->flashdata('error_msg')){
	
		echo $this->session->flashdata('error_msg');
	
	}
	
	
	?>


	</div>

<div class="methodbox">

	


	<form name="paypal_setting"  method="post">
		 <input type="hidden" name="account_for" value="P"> 


		<div style="margin: 20px;">
			If you are registered with Paypal then just enter your registered account email id in the space provided below.
			Otherwise first register yourself in paypal site and then provide the registered account email id.
			Please note that all payments will be provided to you in your registered account email id as provided by you
			</div>
			
			<?php 
			$pay_pal='';
			foreach($bank_account as $bank_acc){
				
					if($bank_acc['account_for'] =='P'){
					$pay_pal = $bank_acc['paypal_account'];
					
					}
				
				}
			
			?>
			
			
			
			<div class="login_form">
				<p>PayPal A/C No :</p>
				<input type="text" class="loginput6" id="paypal_account" size="15" name="paypal_account"  <?php if($pay_pal !="") { ?> value ="<?php echo $pay_pal; ?>"<?php }else{ ?>value="<?php echo set_value('paypal_account');?>"<?php }?>>
				<?php echo form_error('paypal_account', '<div class="error-msg13">','</div>'); ?>
				</div>
			
			<div class="acount_form">
				<div class="masg3">
				<input type="submit" name="update" value="Update" class="btn-normal btn-color submit  bottom-pad" >
				<a href="<?php echo VPATH;?>affiliate/withdraw"><input type="button" name="cancle"  value="Cancel" class="btn-normal btn-color submit  bottom-pad" ></a>
				</div>
			</div>

			
		</form>
			
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