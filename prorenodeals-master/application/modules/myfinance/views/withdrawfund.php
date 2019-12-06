     

<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">

<div class="container-fluid">

<div class="row">

<?php $this->load->view('dashboard/dashboard-left'); ?>
   

<aside class="col-md-10 col-sm-9 col-12">
<?php echo $breadcrumb;?> 

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

<ul class="nav nav-tabs">

    <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/" ><?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>

    <li class="nav-item hidden"><a class="nav-link" href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li> 

    <li class="nav-item"><a class="nav-link active" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 

    <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li> 

    <li class="nav-item hide"><a class="nav-link" href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li> 

</ul>



<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo format_money($balance,TRUE);?></div>





<?php /*if(!empty($question[0]['question'])) { ?>



<?php

// echo "<pre>";

 //print_r($question);



 $attributesSecurity = array('id' => 'security_questionAnswer','class' => 'form-horizontal securityQuestion','role'=>'form','name'=>'security_questionAnswer');



 // echo form_open('', $attributesSecurity);   



?> 

<div class="form-horizontal">

<div id="formCheck" class="whiteSec">

<?php // if($question[0]['question']){ ?>

<div class="form-group">

    <label class="col-md-3 col-sm-4">Existing Question:</label>

    <div class="col-md-9 col-sm-8 col-12">

    	<input id="existvalue" class="form-control" type="text" readonly value="<?php echo $question[0]['question'];?>" >

    </div>

</div>

<?php// } ?> 



<div class="form-group">

    <label class="col-md-3 col-sm-4">Answer: <span>*</span></label>

    <div class="col-md-9 col-sm-8 col-12">

        <input class="form-control" id="answer" name="answer" type="text" value="" tooltiptext="Enter Your Answer">

        <span id="answerError" class="error-msg13"></span>

    </div>

</div> 



<div class="form-group">

<div class="col-md-9 col-md-offset-3 col-sm-8 col-sm-offset-4 col-12">

    <button type="submit" id="next" name="submit" onclick="securityCheckBeforePay()" class="btn btn-site">Next</button>

   <!--  <button type="button" class="btn-normal btn-color submit bottom-pad7" disabled="disabled" onclick="setpassword()" id="update_btn">Update</button> -->

</div>

</div>

</form>

</div>

</div>



<?php } else { ?>



<div class="leftlogin" id="formCheck" >

<div class="createLink">Please Create Security Question First &nbsp;<a href="<?php echo VPATH;?>dashboard/setting">Click here</a></div>



</div>



<?php }*/ ?>



<!--EditProfile Start-->

<div class="clearfix"></div>

<div id="editshow" class="table-responsive">	 	 	

<table class="table table-dashboard">

<thead>

<tr><th><?php echo __('myfinance_method','Method'); ?></th>	<th class="hidden"><?php echo __('myfinance_flance_fees_per_withdrawal','Flance Fees (per withdrawal)'); ?></th> 	<th><?php echo __('myfinance_account','Account'); ?></th> <th><?php echo __('myfinance_withdraw','Withdraw'); ?></th>  <th><?php echo __('myfinance_actions','Actions'); ?></th></tr>

</thead>

<tbody>

<?php 

$pay_pal="";

$wire_acn ="";

$pay_skrill="";

foreach($bank_account as $bank_acc){



    if($bank_acc['account_for'] =='P'){

    $pay_pal = $bank_acc['paypal_account'];

    

    }elseif($bank_acc['account_for'] =='W'){

    

    $wire_acn = $bank_acc['wire_account_no'];

    }elseif($bank_acc['account_for'] =='S'){

    

    $pay_skrill = $bank_acc['skrill_account'];

    }



}



?>





<?php 

if($paypal_setting=="Y"){ 

?>

<tr>

<td><?php echo __('myfinance_paypal','Paypal'); ?></td>

<td class="hidden"><?php echo $paypal_fees;?>%</td>

<td><?php if($pay_pal){



echo $pay_pal;



}

else{



echo __('myfinance_not_register','Not Registered');

}

?></td>

<td>

<?php if($pay_pal){ ?>





<?php  if($balance>0) {?>



<a href="transfer/p"> <?php echo __('myfinance_click_here','Click Here'); ?> </a>

<?php }else{ ?>



    <?php echo __('myfinance_no_balance','No Balance'); ?>

<?php } ?>

<?php }else{



echo '--------';

}

?>

</td>





<td>

<?php

if($pay_pal){ ?>

<a href="paypal_setting"><?php echo __('myfinance_edit_account','Edit Account'); ?></a>

<?php }else{?>

<a href="paypal_setting"><?php echo __('myfinance_add_account','Add Account'); ?></a>

<?php }?>

</td>

</tr>

<?php 

}

?>

<?php 

if($skrill_setting=="Y"){ 

?>

<tr>  

<td>Skrill</td>

<td><?php echo $skill_fees;?>%</td>

<td><?php if($pay_skrill){



echo $pay_skrill;



}else{



echo 'Not Registered';

}

?></td>

<td>

<?php if($pay_skrill){ ?>

<?php  if($balance>0) {?>



<a href="transfer/s"> Click Here </a>

<?php }else{ ?>



    No Balance

<?php } ?>

<?php }else{



echo '--------';

}

?></td>

<td><?php





if($pay_skrill){ ?>

<a href="skrill_setting">Edit Account</a>

<?php }else{?>

<a href="skrill_setting">Add Account</a>

<?php }?></td>

</tr>

<?php 

}

?>

<?php 

if($wire_setting=="Y"){ 

?>	

<tr>

<td>Wire Transfer</td>

<td><?php echo CURRENCY." ".$wire_transfer_fees;?></td>

<td><?php 





if($wire_acn){?>

Verified

<?php }else{?>

Not Registered

<?php } ?>

</td>

<td><?php if($wire_acn){?>

<?php  if($balance>0) {?>

<a href="transfer/w"> Click Here </a>

<? } else{?>

No Balance

<?php } ?>



<?php }else{?>

------

<?php } ?></td>

<td><a href="wire_setting">

<?php if($wire_acn){

echo 'Edit Account';

}else{

echo 'Add Account';

}

?>

</a></td>

</tr>

<?php 

}

?>

</tbody>

</table>

</div>

<!--EditProfile End-->

</aside>

</div>

</div>     

</section>                   

<script> 

  function setamt(){ 

    $("#amount").val($("#depositamt_txt").val());

  }

  

  // Check Answer Validation before Next step

  function securityCheckBeforePay(){

  

				var ans = $("#answer").val();	

				

			    if(ans == ''){

				

				$("#answerError").text("! Answer is required.");

				

				$("#answerError").css("color","#d50000");

				

				

				}	

			     else{

				 				

					var dataString = 'answer='+$("#answer").val();

					$.ajax({

					type:"POST",

					data:dataString,

					url:"<?php echo VPATH;?>myfinance/checkAnswerBeforePay",

					beforeSend: function (){

					   $(".error").remove();

					   

					},

					success:function(return_data){

					

					//alert(return_data);

					if(return_data == 'Y')

					{

					  alert("Answer Matched you can Edit Your Account !!");

					  $("#next").removeAttr('disabled');

					  $("#formCheck").hide();

					  $("#editshow").show();

					}

					else

					{

						//$('#formCheck').prepend('<span class="error">Answer Doesnt Match Try Again !!</span>');

						$("#answerError").text("Answer Do not Match Try Again !!");

						$("#editshow").hide();

					}

					}

				});

				 

				/* 	

				  var result = FormPost('#next',"<?=VPATH?>","<?=VPATH?>myfinance/checkAnswerBeforePay",'security_questionAnswer');

				  if(result == 'Y')

				  {

					  $("#create_btn").removeAttr('disabled');

					  $("#formCheck").hide();

					  $("#editshow").show();

				  }

					else

					{

					$("#editshow").hide();

					}	 */				

				 

               }

  

  }

  

</script>