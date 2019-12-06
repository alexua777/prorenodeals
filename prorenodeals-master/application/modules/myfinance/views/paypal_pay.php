<script src="<?=JS?>jquery.min.js"></script>
<p>Redirecting to paypal ....</p>
<?php
	
	if($cmd == 'award_job'){
		$project_id = getField('project_id', 'bids', 'id', $bid_id);
		$cancel_url = base_url() . 'jobdetails/details/'. $project_id;
		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=award_job&bid_id='.$bid_id.'&track_id='.$track_id;
		
	}else if($cmd == 'featured_project'){
		$cancel_url = base_url() . 'jobdetails/details/'. $project_id;
		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=featured_project&project_id='.$project_id.'&track_id='.$track_id;
		
	}else if($cmd == 'deposit_project_fund'){
		
		$cancel_url = base_url() . 'projectroom/employer/overview/'. $project_id;
		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=deposit_project_fund&project_id='.$project_id.'&track_id='.$track_id;
		
	}else if($cmd == 'process_invoice'){
		
		$cancel_url = base_url() . 'projectroom/invoices/'. $project_id;
		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=process_invoice&project_id='.$project_id.'&track_id='.$track_id.'&invoice_id='.$invoice_id;
		
	}else if($cmd == 'bonus_to_freelancer'){
		
		$cancel_url = base_url() . 'projectroom/employer/overview/'. $project_id;
		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=bonus_to_freelancer&freelancer_id='.$freelancer_id.'&track_id='.$track_id.'&reason='.$reason;
		
	}else if($cmd == 'feature_profile'){				$cancel_url = base_url() . 'dashboard/setting';		$return_url = base_url() . 'myfinance/paypal_process/?next='. urlencode($cancel_url).'&track_id='.$track_id;		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id.'?cmd=feature_profile&feature_type='.$feature_type.'&track_id='.$track_id.'&reason='.$reason;			}else{
		$return_url = base_url() . 'myfinance/payment_confirm/'. $user_id;
		$cancel_url = base_url() . 'myfinance/payment_cancel/'. $user_id;
		$notify_url = base_url() . 'myfinance/paypal_notify/'. $user_id;
	}
	
    
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
    <form action="<?php echo $paypal_url; ?>" method="post" id="pForm">
    <input type="hidden" name="amount" id="amount" value="<?php echo $amount > 0 ? $amount : 0; ?>"/>
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
    <button class="btn btn-info btn-sm btn-block" type="submit" style="display:none;"><?php echo __('myfinance_pay','Pay'); ?></button> 
    </form>
	
	<script>
		$(document).ready(function(){
			$('#pForm').submit();
		});
	</script>