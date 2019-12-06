<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-12">
<?php echo $breadcrumb;?>
<ul class="tab">
    <li><a href="<?php echo VPATH;?>myfinance/" >Add Fund</a></li>
    <li><a href="<?php echo VPATH;?>myfinance/milestone" >Milestone</a></li> 
    <li><a class="selected" href="<?php echo VPATH;?>myfinance/withdraw" >Withdraw Fund</a></li> 
    <li><a href="<?php echo VPATH;?>myfinance/transaction" >Transaction History</a></li> 
    <li><a href="<?php echo VPATH;?>membership/" >Membership</a></li> 
</ul>
<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?><?php echo $balance;?></div>
 	 	
<div class="notiftext"><h2>Paypal Account Details</h2></div>

<div class="whiteSec">
	<?php 
	
	if($this->session->flashdata('succ_msg')){
	
		echo $this->session->flashdata('succ_msg');
	
	}elseif($this->session->flashdata('error_msg')){
	
		echo $this->session->flashdata('error_msg');
	
	}
	
	
	?>
    
	<form name="skrill_setting"  method="post">
		 <input type="hidden" name="account_for" value="S"> 


			<div style="margin: 20px;">
			If you are registered with Skrill then just enter your registered account email id in the space provided below.
			Otherwise first register yourself in skrill site and then provide the registered account email id.
			Please note that all payments will be provided to you in your registered account email id as provided by you
			</div>
			
			<?php 
			$pay_skrill='';
			
			foreach($bank_account as $bank_acc){
				
					if($bank_acc['account_for'] =='S'){
					$pay_skrill = $bank_acc['skrill_account'];
					
					}
				
				}
			
			?>
			
			
			
            <div class="login_form">
            <label>Skrill A/C No :</label>
            <input type="text" class="form-control" id="skrill_account" size="15" name="skrill_account"  <?php if($pay_skrill !="") { ?> value ="<?php echo $pay_skrill; ?>"<?php }else{ ?>value="<?php echo set_value('skrill_account');?>"<?php }?>>
            <?php echo form_error('skrill_account', '<div class="error-msg13">','</div>'); ?>
            </div>
        
			<div class="acount_form">
				<div class="masg3">
				<input type="submit" name="update" value="Update" class="btn btn-site">&nbsp;
				<a href="<?php echo VPATH;?>myfinance/withdraw"><input type="button" name="cancel"  value="Cancel" class="btn btn-warning"></a>
				</div>
			</div>

			
		</form>
			
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
</section>           
         
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>