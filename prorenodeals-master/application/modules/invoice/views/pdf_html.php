<?php 
$sender_information = (array) json_decode($invoice['sender_information']);
$receiver_information = (array) json_decode($invoice['receiver_information']);

$inv_row = '';
$total_amount_array = array();
if(count($invoice_row) > 0){
	foreach($invoice_row as $k => $v){
		$amount = $v['per_amount'] * $v['quantity'];
		$total_amount_array[] = $amount ;
		$inv_row  .= '<tr><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['description'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['per_amount'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;">'.$v['quantity'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$v['unit'].'</td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$amount.'</td></tr>';
	}
}

$total_amount = array_sum($total_amount_array);$net_total = $total_amount;

$extraRow= 4;$tax_row =  '';if($invoice['hst_rate'] > 0){	$tax_amount = get_percent($total_amount, $invoice['hst_rate']);		$tax_row = '<tr><th colspan="'.$extraRow.'" style="padding: 8px;border-top: 1px solid #ccc;">HST Rate('.$invoice['hst_rate'].'%)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">'.$tax_amount.'</th></tr>';		$net_total += $tax_amount;}
$site_logo = ASSETS.'img/'.SITE_LOGO;
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
<td style="border:none;"><img src="{$site_logo}" alt="" style="border:none; width:100px;"></td>
<td style="border:none; text-align:right">
	<p>Invoice Number : #{$invoice['invoice_number']}</p>
	<p>Created Date : {$invoice['invoice_date']}</p>
</td>
</tr>
</table>
<div>&nbsp;</div>
<table class="table" cellpadding="5" style="border-collapse:collapse;">
<tr>
	<td style="border:none;padding:8px;"><b>FROM </b></td>		
	
	
	<td style="border:none;padding:8px;text-align:right;"><b>TO</b>
		
	</td>
</tr>
<tr>
	<td style="border:none;padding:8px;"><p><lable>Name :</lable> {$sender_information['name']}</p>
	<p><lable>Address :</lable> {$sender_information['address']}</p></td>
	
	<td style="border:none;padding:8px;text-align:right;"><p><lable>Name :</lable>  {$receiver_information['name']}</p><p><lable>Address :</lable> {$receiver_information['address']} </p></td>
</tr>
</table>

<table class="table" cellpadding="5" style="border-collapse:collapse;">
<thead>
<tr><th style="padding: 8px;border-top: 1px solid #ccc;">Particulars</th><th style="padding: 8px;border-top: 1px solid #ccc;">Rate ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;">Quantity</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">Unit </th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">Amount ($c) </th></tr>
</thead>
<tbody>
{$inv_row}
</tbody>
<tfoot>
<tr><th colspan="{$extraRow}" style="padding: 8px;border-top: 1px solid #ccc;">Sub Total ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$total_amount}</th></tr>{$tax_row}<tr><th colspan="{$extraRow}" style="padding: 8px;border-top: 1px solid #ccc;">Net Total ($c)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">{$net_total}</th></tr>
</tfoot>

</table>
<p style="text-align:center;">This is a computer generated invoice</p>
</div>
</body>
</html>
EOT;
if($download){
	get_pdf($html, $filename, array('title' => 'INVOICE'), TRUE);
}else{
	get_pdf($html, 'download.pdf', array('title' => 'INVOICE'));
}

//echo $html;
