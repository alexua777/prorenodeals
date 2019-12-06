   

<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">  

<div class="container-fluid">

<div class="row">
<?php $this->load->view('dashboard/dashboard-left'); ?> 

<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?>  
<!--ProfileRight Start-->

<ul class="nav nav-tabs">

    <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>

    <li class="nav-item hidden"><a class="nav-link" href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li> 

    <li class="nav-item"><a class="nav-link active" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 

    <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li> 

    <li class="nav-item hide"><a class="nav-link" href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li> 

</ul>

<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?><?php echo $balance;?></div>

<!--EditProfile Start-->

	 	 	

<h4><?php echo __('myfinance_paypal_account_details','Paypal Account Details'); ?></h4>



<?php 



if($this->session->flashdata('succ_msg')){



echo $this->session->flashdata('succ_msg');



}elseif($this->session->flashdata('error_msg')){



echo $this->session->flashdata('error_msg');



}





?>



<div class="whiteSec"> 

<div class="methodbox">



<form name="paypal_setting" class="form-horizontal" method="post">

<input type="hidden" name="account_for" value="P"> 





<div style="margin: 0 0 15px; overflow:hidden">

<p><?php echo __('myfinance_paypal_account_setting_text','If you are registered with Paypal then just enter your registered account email id in the space provided below. Otherwise first register yourself in paypal site and then provide the registered account email id. Please note that all payments will be provided to you in your registered account email id as provided by you'); ?></p>

</div>



<?php 

$pay_pal='';

foreach($bank_account as $bank_acc){



if($bank_acc['account_for'] =='P'){

$pay_pal = $bank_acc['paypal_account'];



}



}



?>



<div class="form-group">

<label><?php echo __('myfinance_paypal_account_no','PayPal A/C No'); ?> :</label>

<input type="text" class="form-control" id="paypal_account" size="15" name="paypal_account"  <?php if($pay_pal !="") { ?> value ="<?php echo $pay_pal; ?>"<?php }else{ ?>value="<?php echo set_value('paypal_account');?>"<?php }?>>

<?php echo form_error('paypal_account', '<div class="error-msg13">','</div>'); ?>

</div>



<div class="form-group">

<input type="submit" name="update" value="<?php echo __('myfinance_update','Update'); ?>" class="btn btn-site" >

&nbsp;

<a href="<?php echo VPATH;?>myfinance/withdraw"><input type="button" name="cancel"  value="<?php echo __('myfinance_cancel','Cancel'); ?>" class="btn btn-warning"></a>


</div>





</form>



</div>



</div>

                

</aside>
</div>

</div>               



</section>                    

<script> 

  function setamt(){ 

    $("#amount").val($("#depositamt_txt").val());

  }

</script>