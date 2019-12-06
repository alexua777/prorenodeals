<?php 
if($invoice_row['hr'] > 0){
	$hr = (int)$manual_hour_row['hour']. ' hr '.' : '. (int) $manual_hour_row['minute'] . ' min ' ; 
}else{
	$hr = '--';
}


if(!empty($milestone_end_date)){
	$milestone_end_dateFixed = '<p>Due Date :'.$milestone_end_date.'</p>';
}
$projectType='Fixed';
$working_hr='Hour';
$hourlyRateCol='';
$hourlyRate='';
$activity = $project['title'];
$extraRow=3;
if($invoice_row['project_type'] == 'H'){
	$activity='';
	$working_hr='Working Hour';
	$projectType='Hourly';
	$hourlyRateCol = '<th style="padding: 8px;border-top: 1px solid #ccc;">Hourly Rate</th>';	
	$milestone_end_dateFixed='';
	$total_cost_new = 0;
	$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$manual_hour_row['project_id'],"bidder_id"=>$manual_hour_row['worker_id']));
	$hourlyRate = '<td style="padding: 8px;border-top: 1px solid #ccc;">'.$client_amt.'</td>';
	$minute_cost_min = ($client_amt/60);
	$total_min_cost = $minute_cost_min *floatval($manual_hour_row['minute']);
	$total_cost_new=(($client_amt*floatval($manual_hour_row['hour']))+$total_min_cost);
	$invoice_row['amount'] = round($total_cost_new, 2);
	foreach($manual_hour_row['acti'] as $k => $r){
		$activity.='<p>'.$r['task'].'</p>';
	}
	$extraRow=4;
}

$commission = $invoice_row['commission_amount'];
$commission_row = '';
if($commission  > 0){
	$commission_row = '<tr><td style="padding: 8px;border-top: 1px solid #ccc;">Commission</td><td style="padding: 8px;border-top: 1px solid #ccc;">'.$activity.'</td><td style="padding: 8px;border-top: 1px solid #ccc;"></td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$commission.'</td></tr>';
}

$item_amount = $invoice_row['amount'];
if($commission > 0){
	$item_amount  -= $commission;
}

$c = CURRENCY;
$html = <<<EOT
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>A simple, clean, and responsive HTML invoice template</title>
 
<link rel="icon" href="/images/favicon.png" type="image/x-icon">
<style>
body {
	font-family:Arial, Helvetica, sans-serif;
}
.table {
	border-collapse:collapse;
	max-width:100%;
	width:100%;
	border: 1px solid #ccc;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
	border:none;
    border-top: 1px solid #ddd;
}
tr {
	border: none;
}
th {
    text-align: left;
	text-transform:uppercase;
	font-weight:bold
}
</style>
</head>
<body>
<div class="invoice-box">
<table class="table" cellpadding="0" border="0" style="border:none;">
<tr>
<td style="border:none;"><img src="./assets/images/logo.png" alt="" style="border:none; width:100px;"></td>
<td style="border:none; text-align:right">
	<p>Invoice ID : #{$project['project_id']}-{$invoice_row['invoice_id']}</p>
	<p>Created Date : {$invoice_row['created_date']}</p>
							{$milestone_end_dateFixed}
</td>
</tr>
</table>
<div>&nbsp;</div>
<table class="table" cellpadding="5" style="border-collapse:collapse;">
<tr>
	<td style="border:none;padding:8px;"><b>BILL TO </b></td>		
	
	<td style="border:none;padding:8px;"><b>PROJECT DETAILS</b>
		
	</td>
	<td style="border:none;padding:8px;text-align:right;"><b style="display:none;">BILL OF</b>
		
	</td>
</tr>
<tr>
	<td style="border:none;padding:8px;"><p><lable>Name :</lable> {$owner_info['fname']} {$owner_info['lname']}</p><p><lable>Email :</lable> {$owner_info['email']}</p><p><lable>From :</lable> {$owner_info['city']},{$owner_info['country']}</p></td>
	<td style="border:none;padding:8px;"><p><lable>Project :</lable> {$project['title']} </p><p><lable>Project type :</lable> {$projectType} </p></td>
	<td style="border:none;padding:8px;text-align:right; display:none"><p><lable>Name :</lable> {$freelancer_info['fname']} {$freelancer_info['lname']}</p><p><lable>Email :</lable> {$freelancer_info['email']}</p><p><lable>From :</lable> {$freelancer_info['city']},{$freelancer_info['country']}</p></td>
</tr>
</table>

<table class="table" cellpadding="5" style="border-collapse:collapse;">
<thead>
<tr><th style="padding: 8px;border-top: 1px solid #ccc;">Title</th><th style="padding: 8px;border-top: 1px solid #ccc;">Project</th><th style="padding: 8px;border-top: 1px solid #ccc;">{$working_hr}</th>$hourlyRateCol<th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">Amount ($c)</th></tr>
</thead>
<tbody>
<tr><td style="padding: 8px;border-top: 1px solid #ccc;">{$milestone_title}</td><td style="padding: 8px;border-top: 1px solid #ccc;">{$activity}</td><td style="padding: 8px;border-top: 1px solid #ccc;">$hr</td>$hourlyRate<td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$item_amount}</td></tr>
$commission_row
</tbody>
<tfoot>
<tr><th colspan="{$extraRow}" style="padding: 8px;border-top: 1px solid #ccc;">Total Price ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$invoice_row['amount']}</th></tr>
</tfoot>

</table>
<p style="text-align:center;">This is a computer generated invoice</p>
</div>
</body>
</html>
EOT;
get_pdf($html, 'download.pdf', array('title' => 'INVOICE'));
//echo $html;
