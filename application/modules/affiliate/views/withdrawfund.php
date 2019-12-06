
<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">
 <?php echo $leftpanel;?> 
 <!-- Sidebar End -->
 <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    
<!--ProfileRight Start-->
<?php
if($this->session->flashdata('succ_msg'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
<?php	
}
if($this->session->flashdata('error_msg'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('error_msg');?></div>
<?php
}
?>
<div class="profile_right">
<h1><a  class="selected" href="<?php echo VPATH;?>affiliate/withdraw" >Withdraw Fund</a></h1> 
<h1><a  href="<?php echo VPATH;?>affiliate/transaction" >Transaction History</a></h1> 

<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY;?> <?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="editprofile"> 	 	 	
<div class="notiftext"><h4>Method</h4>	<h4>Jobbid Fees (per withdrawal)</h4> 	<h4>Account</h4> <h4>Withdraw</h4>  <h4>Action</h4> </div>

<div class="methodbox">


<?php 
$pay_pal="";
$wire_acn ="";
foreach($bank_account as $bank_acc){

if($bank_acc['account_for'] =='P'){
$pay_pal = $bank_acc['paypal_account'];

}elseif($bank_acc['account_for'] =='W'){

$wire_acn = $bank_acc['wire_account_no'];
}

}

?>


<?php 
if($paypal_setting=="Y"){ 
?>

<div class="methodtext1">

<h2>Paypal</h2>


</div>

<div class="methodtext1">

<h2> <?php echo $paypal_fees;?>% </h2>


</div>

<div class="methodtext1">

<h2>

<?php if($pay_pal){

echo $pay_pal;

}else{

echo 'Not Registered';
}
?>

</h2>

</div>

<div class="methodtext1">

<h2>

<?php if($pay_pal){ ?>


<?php  if($balance>0) {?>

<a href="transfer/p"> Click Here </a>
<?php }else{ ?>

No Balance
<?php } ?>
<?php }else{

echo '--------';
}
?>

</h2>

</div>


<div class="methodtext1">

<h2>

<?php


if($pay_pal){ ?>
<a href="paypal_setting">Edit Account</a>
<?php }else{?>
<a href="paypal_setting">Add Account</a>
<?php }?>


</h2>

</div>

<?php 
}
?>
<?php 
if($wire_setting=="Y"){ 
?>	

<div class="methodtext1">

<h2>Wire Transfer</h2>


</div>

<div class="methodtext1">

<h2><?php echo CURRENCY." ".$wire_transfer_fees;?> </h2>


</div>

<div class="methodtext1">

<?php 


if($wire_acn){?>
<h2> Verified</h2>
<?php }else{?>
<h2>Not Registered</h2>
<?php } ?>

</div>

<div class="methodtext1">
<?php if($wire_acn){?>
<?php  if($balance>0) {?>
<h2><a href="transfer/w"> Click Here </a></h2>
<? } else{?>
<h2>No Balance</h2>
<?php } ?>

<?php }else{?>
<h2>------</h2>
<?php } ?>
</div>


<div class="methodtext1">

<h2>
<a href="wire_setting">
<?php if($wire_acn){
echo 'Edit Account';
}else{
echo 'Add Account';
}
?>
</a></h2>

</div>

<?php 
}
?>
</div>

</div>
<!--EditProfile End-->

</div>                       
<!--ProfileRight Start-->                       

 </div>
 <!-- Left Section End -->
</div>
</div>
           
         
<script> 
  function setamt(){ 
    $("#amount").val($("#depositamt_txt").val());
  }
</script>