
<?php if($page && $page == 'milestone_view'){ 
if(count($milestone) > 0){ ?>

<table class="table">
<tr>
	<th>Title</th>
	<th>Date</th>
	<th>Amount (<?php echo CURRENCY;?>)</th>
</tr>
<?php foreach($milestone as $k => $v){ 
$total[] = $v['amount'];
$pay_date = $v['mpdate'] != '0000-00-00' ? $v['mpdate'] : 'At Project End';
?>
<tr>
<td><?php echo $v['title']; ?></td>
<td><?php echo $pay_date; ?></td>
<td><?php echo $v['amount']; ?></td>
</tr>
<?php } ?>

<tr>
<td></td>
<td><b>Total (<?php echo CURRENCY; ?>)</b></td>
<td><?php echo array_sum($total); ?></td>
</tr>

</table>

<?php } ?>

<?php }else if($page && $page == 'milestone_check'){ ?>

<?php 
$hire = true;
$paypal_fee_percent = getField('deposite_by_paypal_commission', 'setting', 'id', 1);
$total = array();
if(count($milestone) > 0){ ?>
<h5>Milestone Detail</h5>
<table class="table">
<tr>
	<th>Title</th>
	<th>Date</th>
	<th>Amount (<?php echo CURRENCY;?>)</th>
</tr>
<?php foreach($milestone as $k => $v){ 
$total[] = $v['amount'];
$pay_date = $v['mpdate'] != '0000-00-00' ? $v['mpdate'] : 'At Project End';
?>
<tr>
<td><?php echo $v['title']; ?></td>
<td><?php echo $pay_date; ?></td>
<td><?php echo $v['amount']; ?></td>
</tr>
<?php }  /* $total_sum = array_sum($total);$tax_amount = (($total_sum*HST_RATE)/100); */$tax_amount = $bid_detail['tax_amount'];/* $total_sum += $tax_amount; */$total_sum = $bid_detail['total_amt'];?><tr><td><?php echo HST_RATE;?>% HST</td><td>--</td><td><?php echo $tax_amount;?></td></tr><?php  


if($total_sum > $wallet_balance){
$hire = false;	

/* $paypal_comm = ($total_sum * $paypal_fee_percent)/100;
$paypal_comm += 0.35;
$paypal_comm = number_format($paypal_comm, 2);
$total_sum += $paypal_comm;
$amount_to_pay = $total_sum - $wallet_balance; */

$diff = clean_money_format(($total_sum - $wallet_balance));

$paypal_pay_amount = get_paypal_pay_amount($diff);
$stripe_pay_amount = get_strip_pay_amount($diff);
$stripe_comm = ($stripe_pay_amount - $diff);
$paypal_comm = ($paypal_pay_amount - $diff);

/* $paypal_comm = ($diff * $paypal_fee_percent)/100;
$paypal_comm += 0.35;
$paypal_comm = number_format($paypal_comm, 2); */

$amount_to_pay = $diff + $paypal_comm;

$amount_to_pay = number_format($amount_to_pay, 2);
/* $total_sum += $paypal_comm; */
?>
<tr hidden>
<td>Paypal Fee = <?php echo str_replace('.00', '', $paypal_fee_percent); ?>% + <?php echo CURRENCY;?>0.35</td>
<td>---</td>
<td><?php echo $paypal_comm; ?></td>
</tr>
<?php } ?>
<tr>
<td></td>
<td><b>Total (<?php echo CURRENCY; ?>)</b></td>
<td><?php echo number_format($total_sum, 2); ?></td>
</tr>
</table>
<?php }else{  
$project_id = getField('project_id', 'bids', 'id', $bid_id);
$project_type = getField('project_type', 'projects', 'project_id', $project_id);
if($project_type == 'H'){
	$bid_amount = getField('total_amt', 'bids', 'id', $bid_id);
	$available_hr = getField('available_hr', 'bids', 'id', $bid_id);

?>
<h5>Bid Detail</h5>
<p><b>Bid Amount : </b> <?php echo CURRENCY. $bid_amount; ?></p>
<p><b>Approximate hours to do the job : </b> <?php echo $available_hr > 0 ? $available_hr . ' hr(s)' : 'N/A '; ?></p>
<?php } } ?>


<?php if(!$hire){ ?>

<div class="success alert-danger alert" hidden>Your current account balance is <b><?php echo CURRENCY.$wallet_balance; ?></b>, you will need to add <b><?php echo CURRENCY.$amount_to_pay; ?></b> into your account. Your money is secure and will be paid once the job is completed and you are satisfied.</div>

<div class="success alert-danger alert">Your current account balance is <b><?php echo CURRENCY.$wallet_balance; ?></b>, you will need to add remaining amount into your account. Your money is secure and will be paid once the job is completed and you are satisfied.</div>

<div class="card">
  <div class="card-header">
    Add Remaining Fund
  </div>
  <div class="card-body">
	   <div class="row">
		  <div class="col-sm-6">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">Via Paypal</h5>
				<p class="card-text">Fee : <?php echo CURRENCY.$paypal_comm;?></p>
				  <p class="card-text bold"><b>Pay Amount : <?php echo CURRENCY.$paypal_pay_amount;?></b></p>
				<button class="btn btn-primary" onclick="addFund('<?php echo $paypal_pay_amount?>', '<?php echo $bid_id;?>', this)">+ Add Fund</button>
			  </div>
			</div>
		  </div>
		  <div class="col-sm-6">
			<div class="card">
			  <div class="card-body">
				<h5 class="card-title">Via Credit Card</h5>
				  <p class="card-text">Fee : <?php echo CURRENCY.$stripe_comm;?></p> 
			   <p class="card-text bold"><b>Pay Amount : <?php echo CURRENCY.$stripe_pay_amount;?></b></p>
				<button class="btn btn-primary" onclick="addStripeFund('<?php echo $stripe_pay_amount?>', '<?php echo $bid_id;?>', this)"> + Add Fund</button>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>

<?php } ?>

<div class="pull-right">
<button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#hireFreelancer').modal('hide'); $('#hireResponse').html('');">Cancel</button>
<?php if($hire){ ?>
<button type="button" class="btn btn-primary" id="accept-freelancer-btn" onclick="prvdHire(this, '<?php echo $bidder_id; ?>')">Accept</button>
<?php }else{ ?>
<button type="button" class="btn btn-site" id="accept-freelancer-btn" onclick="addFund('<?php echo $amount_to_pay?>', '<?php echo $bid_id;?>', this)" hidden>+ Add Funds</button>
<?php } ?>
</div>

<div class="clearfix"></div>
<?php } ?>