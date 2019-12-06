     
<?php
$user = $this->session->userdata('user');
$account_type = $user[0]->account_type;
?>


<script src="<?=JS?>mycustom.js"></script>

<section id="mainpage">

    <div class="container-fluid">

    <div class="row">

	<?php $this->load->view('dashboard/dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb;?> 
<ul class="nav nav-tabs">

        <li class="nav-item"><a class="nav-link active" href="<?php echo VPATH;?>myfinance/" > <?php echo __('myfinance_add_fund','Add Fund'); ?></a></li>

        <li class="nav-item hidden"><a class="nav-link" href="<?php echo VPATH;?>myfinance/milestone" ><?php echo __('myfinance_milestone','Milestone'); ?></a></li> 
		
		<?php if($account_type == 'F'){ ?>
		
        <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/withdraw" ><?php echo __('myfinance_withdraw_fund','Withdraw Fund'); ?></a></li> 
		<?php } ?>

        <li class="nav-item"><a class="nav-link" href="<?php echo VPATH;?>myfinance/transaction" ><?php echo __('myfinance_transaction_history','Transaction History'); ?></a></li> 

        <li class="nav-item hide"><a class="nav-link" href="<?php echo VPATH;?>membership/" ><?php echo __('myfinance_membership','Membership'); ?></a></li> 

    </ul>

    <div class="balance mb-10">

    <span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> <?php echo __('myfinance_balance','Balance'); ?>: </span><?php echo CURRENCY;?> <?php echo format_money($balance,TRUE);?></div>    

    <!--

    <?php //if(!empty($question[0]['question'])) { ?>

    

    <?php

    // echo "<pre>";

    // print_r($question);

    

   // $attributesSecurity = array('id' => 'security_questionAnswer','class' => 'form-horizontal securityQuestion','role'=>'form','name'=>'security_questionAnswer');

    

   // echo form_open('', $attributesSecurity);   

    

    ?>     

    <div class="leftlogin" id="formCheck" style="border-right-style: none;">

    <?php //if($question[0]['question']){ ?>

    <div class="form-group">        

        <label class="col-md-3 col-sm-4 col-12">Existing Question:</label>

        <div class="col-md-9 col-sm-8 col-12">

            <input id="existvalue" class="form-control" type="text" readonly value="<?php //echo $question[0]['question'];?>" >

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

    		<input type="button" value="Next" id="next" name="submit" onclick="securityCheckBeforePay()" class="btn btn-site">

    		<!--<button type="button" class="btn-normal btn-color submit bottom-pad7" disabled="disabled" onclick="setpassword()" id="update_btn">Update</button>

    	</div>

    </div>    

    </form>

    </div>

    

    

    <?php //} else { ?>

    

    <div class="leftlogin" id="formCheck" >

    <div class="createLink">Please Create Security Question First &nbsp;<a href="<?php echo VPATH;?>dashboard/setting">Click here</a></div>

    

    </div>

    </div>

    

    <?php// } ?> -->

    <!--EditProfile Start-->

    <div class="table-responsive" id="editshow">

    <table class="table table-bordered table-middle">

    	<thead><tr><th colspan="2"><?php echo __('myfinance_method','Method'); ?></th><th><?php echo __('myfinance_amount','Amount'); ?></th> <th><?php echo __('myfinance_actions','Actions'); ?></th></tr></thead>   

        <tbody>           

    <?php 

    if($paypal_setting=="Y"){ 

    ?>

    <tr>

    <td><h4>Paypal</h4>

    <div class="paypalimg"><a href="javascript:void(0)"><img src="<?php echo VPATH;?>assets/images/check.png"></a></div>

    </td>

    <td>

    

    <p><?php echo __('myfinance_available_immediately','Available immediately'); ?> <br />

    <?php echo __('myfinance_pay_in','Pay In'); ?> <?php echo CURRENCY;?> <br />

    <?php echo __('myfinance_100_percent_safe','100% Safe'); ?></p>

    </td>

    <td>

    <div class="input-group mb-0">

	<?php 

	$amount_to_add = get('amt_to_add');

	if($amount_to_add > 0 == false){

		$amount_to_add = 0;

	}

	?>

    <div class="input-group-prepend"><span class="input-group-text"><?php echo CURRENCY;?></span></div>

    <input type="text" class="form-control input-sm"  name="depositamt_txt" id="depositamt_txt" onkeyup="setamt('')" title="<?php echo __('myfinance_enter_desired_amount_you_wish_to_add','Enter desired amount you wish to add'); ?>" value="<?php echo $amount_to_add; ?>">

    </div>

    </td>

    <td>

    

    <!--- Paypal Integration Code Start --->    

    

    <?php

	

    $return_url = base_url() . 'myfinance/payment_confirm/'. $user_id;

    $cancel_url = base_url() . 'myfinance/payment_cancel/'. $user_id;

    $notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id;

    $paypal_url = '';

    if(PAYPAL_MODE=="DEMO")

    {

    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    }

    else

    {

    $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

    }

    ?>

    <form action="<?php echo $paypal_url; ?>" method="post">

    <input type="hidden" name="amount" id="amount" value="0"/>

    <input name="currency_code" type="hidden" value="CAD">

    <input name="shipping" type="hidden" value="0">

    <input name="return" type="hidden" value="<?php echo $return_url; ?>">

    <input name="cancel_return" type="hidden" value="<?php echo $cancel_url; ?>">

    <input name="notify_url" type="hidden" value="<?php echo $notify_url; ?>">

    <input name="cmd" type="hidden" value="_xclick">

    <input name="business" type="hidden" value="<?php echo PAYPAL;?>">

    <input name="item_name" type="hidden" value="Add Cash in Account">

    <input name="no_note" type="hidden" value="1">

    <input type="hidden" name="no_shipping" value="1">

   <!-- <input name="lc" type="hidden" value="">

    <input name="bn" type="hidden" value="PP-BuyNowBF">

     <input type="submit" class="singbnt" name="submit" value="Confirm and pay"><br /> -->

    <button class="btn btn-info btn-block" type="submit" disabled="disabled" id="pay_btn"><?php echo __('myfinance_pay','Pay'); ?></button> 

    </form>

    <?php 

    if($wire_setting=="Y"){  

    ?>

    <h2><strong><a href=<?php echo VPATH."myfinance/addFundWire";?>><?php echo __('myfinance_or_pay_by_wire_transfer','Or Pay by Wire Transfer'); ?></a></strong></h2>

    <?php      

    }

    ?>

    

    

    <!-- Paypal Integration Code End -->

    

    </td>

    </tr>    

    <?php    

    

    }

    else if($wire_setting=="Y"){ 

    ?>

    <tr>

    	<td><a href=<?php echo VPATH."myfinance/addFundWire";?>>Pay by Wire Transfer</a></td>

    </tr>

    <?php    

    

    }

    ?>    

    <?

    if($skrill_setting=="Y"){

    ?>

    <!---------------------skrill------------------->

    

    <tr>   

    <td><h4>Skrill</h4>

    <div class="paypalimg"><a href="javascript:void(0)"><img src="<?php echo VPATH;?>assets/images/skrill.png"></a></div>

    </td>

    <td>

    <p>Available immediately <br />

    Pay In <?php echo CURRENCY;?> <br />

    100% Safe</p>

    </ul>

    </td>

    <td>

	

    <div class="amountbox">

    <?php echo CURRENCY;?> <input type="text" class="amountinput" value="0" name="depositamt_txtS" id="depositamt_txtS" onkeyup="setamt('S')" title="Enter desired amount you wish to add">

    </div>

    </td>

    <td>

    <form action="https://pay.skrill.com" method="post" >

    <input type="hidden" name="pay_to_email" value="<?=SKRILL?>">

    <input type="hidden" name="status_url" value="<?=VPATH?>payment_notify/notify_skrill/">

    <input type="hidden" name="return_url" value="<?=VPATH?>myfinance/payment_confirm/<?=$user_id?>">

    <input type="hidden" name="cancel_url" value="<?=VPATH?>myfinance/payment_cancel/<?=$user_id?>">

    <input type="hidden" name="merchant_fields" value="custom">

    <input type="hidden" name="custom" value="<?=$user_id?>">

    <input type="hidden" name="language" value="EN">

    <input type="hidden" name="amount" id="amountS" value="0">

    <input type="hidden" name="currency" value="EUR">

    <input type="hidden" name="detail1_description" value="jobbid:Add Cash in Account">

    <input type="hidden" name="detail1_text" value="jobbid:Add Cash in Account">

    <input type="hidden" name="confirmation_note" value="jobbid:Add Cash in Account">

    <button class="btn-normal btn-color submit bottom-pad2 top-pad2 bottom-left2" type="submit" disabled="disabled" id="pay_btnS">Pay</button>

    </form>

    </td>

    

    

    

    </tr>

    

    <!--------------Skrill-------------------> 

    <?php }?>	
	
	<tr>

    <td><h4>Credit Card</h4>

    <div class="paypalimg"><a href="javascript:void(0)"><img src="<?php echo ASSETS;?>images/payment-logo_1.png" style="width: 120px;"/></a></div>

    </td>

    <td>

    

    <p><?php echo __('myfinance_available_immediately','Available immediately'); ?> <br />

    <?php echo __('myfinance_pay_in','Pay In'); ?> <?php echo CURRENCY;?> <br />

    <?php echo __('myfinance_100_percent_safe','100% Safe'); ?></p>

    </td>

    <td>

    <div class="input-group mb-0">

	<?php 

	$amount_to_add = get('amt_to_add');

	if($amount_to_add > 0 == false){

		$amount_to_add = 0;

	}

	?>

    <div class="input-group-prepend"><span class="input-group-text"><?php echo CURRENCY;?></span></div>

    <input type="text" class="form-control input-sm"  title="<?php echo __('myfinance_enter_desired_amount_you_wish_to_add','Enter desired amount you wish to add'); ?>" value="<?php echo $amount_to_add; ?>" id="amount_stripe" onkeyup="check_amount(this.value, '#pay_btn_stripe')">

    </div>

    </td>

    <td>

    
	<button class="btn btn-info btn-block" type="button" id="pay_btn_stripe" onclick="pay_stripe()" disabled><?php echo __('myfinance_pay','Pay'); ?></button> 
   
    <!-- Stripe Integration Code End -->

    

    </td>

    </tr>
	

	

    </tbody>

    </table>

    </div>                       


     <!-- Left Section End -->

    </aside>

    </div>               

</section>            

<script> 





function setamt(s){ 

      

/*

 Exchage Code        

 */



  var dataString = 'amt='+$("#depositamt_txt"+s).val();

  var amt = parseFloat($("#depositamt_txt"+s).val());

  

  if(amt > 0){

	 var paypal_commission_percent = parseFloat('<?php echo getField('deposite_by_paypal_commission', 'setting', 'id', 1);?>');

	  var commission = ((amt * paypal_commission_percent)/100);

	  amt += commission;

	  amt += 0.35;  

	  $("#amount"+s).val(amt.toFixed(2));

	  $("#pay_btn"+s).removeAttr("disabled");        

  }else{

	$("#pay_btn"+s).attr("disabled", true);  

  }

 

  

  

 /*  $.ajax({

     type:"POST",

     data:dataString,

     url:"<?php echo VPATH;?>myfinance/exchagerate",

     success:function(return_data){

          $("#amount"+s).val(return_data);

     

		if($("#amount"+s).val()!="" && $("#amount"+s).val()!="0"){

			$("#pay_btn"+s).removeAttr("disabled");        

		}

		else{

			$("#pay_btn"+s).attr("disabled", true);        

		}

	}

  }); */

  

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

			

					  alert('Answer Matched you can pay Now !!')

					  

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

  

  

setamt('');

  

  

</script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
<?php 
$user_email = getField('email', 'user', 'user_id', $user_id);
?>
function check_amount(amt, btn_ref){
	var amount = parseInt($('#amount_stripe').val());
	if(isNaN(amount)){
		amount = 0;
	}
	if(amount > 0){
		$(btn_ref).removeAttr('disabled');
	}else{
		$(btn_ref).attr('disabled', 'disabled');
	}
}

function pay_stripe(){
	var amount = parseInt($('#amount_stripe').val());
	if(isNaN(amount)){
		amount = 0;
	}
	
	if(amount == 0){
		return false;
	}
	paycard(amount);
}

function paycard(amount){
	event.preventDefault();
	handler = stripe_checkout(amount);
	handler.open({
		image: '<?php echo ASSETS;?>img/<?php echo SITE_LOGO;?>',
		locale: 'auto',
		name: "ProRenoDeals",
		description: "Add Fund",
		amount: amount*100,
		email: '<?php echo $user_email;?>',
		currency:'CAD',
    });
	
}

function stripe_checkout(amount) {
  var handler = StripeCheckout.configure({
    key: '<?php echo STRIPE_PUBLISHABLE_KEY; ?>',
    token: function(token) {
      // Send the charge through
      $.post("<?php echo base_url('myfinance/make_payment_stripe');?>", 
       {token: token.id, amount: amount}, function(data) {
        if (data["status"] == "ok") {
          location.reload();
        } else {
          // Deal with error
         alert(data["message"]);
        }
      },'json');
    }
  });
  return handler;
 }
</script> 