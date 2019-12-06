<?php 
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
<h2>Flance </h2>
<table class="table" cellpadding="5" style="border-collapse:collapse;">
<thead>
<tr>
	<td colspan="3" style="border:none;padding:8px;"><b>BILL TO </b><br>
	<p>Venkatesh bishu</p>
	<p>123456789</p>
	Demo Address
	</td>
	<td style="border:none;padding:8px;text-align:right;"><b>INVOICE DETAILS</b><br/>
	<p>Invoice ID  #123456</p>
	<p>Created Date 10/3/2017</p>
	</td>
</tr>

<tr><th style="padding: 8px;border-top: 1px solid #ccc;">Description</th><th style="padding: 8px;border-top: 1px solid #ccc;">Project</th><th style="padding: 8px;border-top: 1px solid #ccc;">Hr</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">Amount</th></tr>
</thead>
<tbody>
<tr><td style="padding: 8px;border-top: 1px solid #ccc;">Demo title</td><td style="padding: 8px;border-top: 1px solid #ccc;">ABCD</td><td style="padding: 8px;border-top: 1px solid #ccc;">'25/6/2017</td><td style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">$500</td></tr>
</tbody>
<tfoot>
<tr><th colspan="3" style="padding: 8px;border-top: 1px solid #ccc;">Total Price ($)</th><th style="padding: 8px;border-top: 1px solid #ccc;text-align:right;">5000</th></tr>
</tfoot>

</table>
<p style="text-align:center;">This is a computer generated invoice</p>
</div>
</body>
</html>
EOT;
get_pdf($html, 'download.pdf', array('title' => 'Invoice'));
//echo $html;
