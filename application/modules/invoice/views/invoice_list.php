<style>
.table thead > tr > th {
	background-color:#f5f5f5
}
.table > tbody > tr > td {
	border-color: #ccc;
}
.table > tbody > tr.blank_row > td {
	background-color:#f5f5f5;
	border-left:0;
	border-right:0;
	padding:3px;
}
tr.paid{
	border-left: 6px solid #37a737;
}
tr.pending{
	border-left: 6px solid #ff8318;

}
tr.deleted{
	border-left: 6px solid #e6112e;
}

tr.paid td.status{
	color: #37a737;
}
tr.pending td.status{
	color: #ff8318;
}
tr.deleted td.status{
	color: #e6112e;
}
@media (min-width: 768px) and (max-width: 991px){
.invoice_search {
	margin-top:10px
}
}
@media (max-width: 767px){
.invoice_search .col-xs-12 {
	margin-top:10px
}
}
</style>
<?php echo $breadcrumb;?>

<section id="mainpage">  
<div class="container-fluid">
<div class="row">
  <div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 

<div class="col-md-10 col-sm-9 col-xs-12">  
<div class="spacer-20"></div>
<div class="profile_right">

	<form>
	<div class="row">
		<div class="col-md-4 col-xs-12">
			<h3 style="margin:0px; margin-top: 5px;">Invoices</h3>
		</div>
		<div class="col-md-8 col-xs-12">        	
			<div class="row-10 invoice_search">	
				<div class="col-sm-5 col-xs-12">
					<input type="text" class="form-control" placeholder="Invoice number" name="invoice_number" value="<?php echo !empty($srch['invoice_number']) ? $srch['invoice_number'] : ''; ?>"/>
				</div>
				<div class="col-sm-5 col-xs-12">
					<select class="form-control" name="invoice_type">
						<option value="">Choose invoice type</option>
						<?php if(count($invoice_type)> 0){foreach($invoice_type as $k => $v){ ?>
						<option value="<?php echo $v['invoice_type_id'];?>" <?php echo (!empty($srch['invoice_type']) AND $srch['invoice_type'] == $v['invoice_type_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['type'];?></option>
						<?php } } ?>
					</select>
				</div>
				<div class="col-sm-2 col-xs-12">
				<button type="submit" class="btn btn-info btn-sm btn-block">Search</button>
				</div>
				
			</div>
		</div>
	</div>
	</form>
	<div class="spacer-20"></div>
	<div class="table-responsive">
    
	<table class="table">
        <thead>
        <tr>
            <th>Invoice Number</th> <th>Invoice type</th> <th>Date</th><th>From/To</th><th>Status</th><th>Invoice</th>
        </tr>
        </thead>
        <tbody>
		<?php if(count($invoice_list) > 0){foreach($invoice_list as $k => $v){
		if($v['sender_id'] == $user_id){
			$user_info = getField('fname', 'user', 'user_id', $v['receiver_id']);
		}else{
			if($v['sender_id']  > 0){
				$user_info = getField('fname', 'user', 'user_id', $v['sender_id']);
			}else{
				$user_info = SITE_TITLE;
			}
			
		}
		
		$is_paid = $is_deleted = $is_pending = 0;
		$row_class = '';
		if($v['is_paid'] != '0000-00-00 00:00:00'){
			
			$is_paid = 1;
			$row_class = 'paid';
		}else if($v['is_deleted'] != '0000-00-00 00:00:00'){
			$is_deleted = 1;
			$row_class = 'deleted';
		}else{
			$is_pending = 1;
			$row_class = 'pending';
		}
		?>
		<tr class="<?php echo $row_class; ?>">
           <td><?php echo $v['invoice_number']; ?></td>
           <td><?php echo $v['type']; ?></td>
           <td><?php echo $v['invoice_date']; ?></td>
           <td><?php echo $user_info; ?></td>
		     <td class="status">
		   <?php 
		   
		   if($is_pending == 1){
			   echo 'Pending';
		   }elseif($is_deleted == 1){
			   echo 'Deleted';
		   }elseif($is_paid == 1){
			   echo 'Paid';
		   }
		   
		   ?>
		   </td>
		   <td><a href="<?php echo base_url('invoice/detail/'.$v['invoice_id'])?>" target="_blank">View</a></td>
        </tr>
		<?php if(($k+1) != count($invoice_list)){ ?>
		<tr class="blank_row"><td colspan="6"></td></tr>
		<?php } ?>
		<?php } }else{   ?>
		<tr>
			<td colspan="10" style="text-align:left;">No records</td>
		</tr>
		<?php }   ?>
		
        </tbody>
        </table>
    
    </div>
    <?php echo $links; ?>
	

 
</div>
    
  </div>
</div>
</div>
</section>