<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
		
		});
	});
	</script>
<section id="content">
<div class="wrapper">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url() ?>fund/wallet">Wallet List</a></li>
      <?php
			$wallet_title = getField('title', 'wallet', 'wallet_id', $wallet_id);
		?>
      <li class="breadcrumb-item active"><a>Transaction Detail (<?php echo $wallet_title; ?>)</a></li>
    </ol>
  </nav>
  <div class="container-fluid">
    <?php
				if($this->session->flashdata('succ_msg')){
				?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
    <?php
				}
				if($this->session->flashdata('error_msg')){
				
				?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
    <?php
				}
				?>
   
     
   	<form action="">	<?php if(!empty($wallet_type) && $wallet_type == 'tax'){ 	$csv_url = base_url('fund/txn_to_csv/'.$wallet_id);	if($srch){		$csv_url .= '?'.http_build_query($srch);	}	?>	<table class="table">		<tr>			<td>				<select class="form-control" name="year">					<option value="">Year</option>					<?php 					$current_year = date('Y');					$year_till = 2017;					while($current_year >= $year_till){ ?>					<option value="<?php echo $current_year; ?>" <?php echo (!empty($srch['year']) && $srch['year'] == $current_year) ? 'selected' : '';?>><?php echo $current_year; ?></option>					<?php $current_year--; } ?>				</select>			</td>			<td>				 <input type="text" class="form-control" placeholder="Date" id="datepicker_from" name="from" readonly="readonly" value="<?php echo !empty($srch['from']) ? $srch['from'] : ''; ?>">			</td>			<td>				<input type="text" class="form-control" id="datepicker_to" name="to" readonly="readonly" value="<?php echo !empty($srch['to']) ? $srch['to'] : ''; ?>">			</td>			<td> <button type="submit" name='submit' id="submit" class="btn btn-primary">Search</button></td>			<td> <a href="<?php echo $csv_url;?>" class="btn btn-success">Export as CSV</a></td>		</tr>	</table>	<?php }else{  ?>	 <div class="input-group mb-3">        <input type="text" class="form-control" placeholder="Date" id="datepicker_from" name="from" readonly="readonly" value="<?php echo !empty($srch['from']) ? $srch['from'] : ''; ?>">        <input type="text" class="form-control" id="datepicker_to" name="to" readonly="readonly" value="<?php echo !empty($srch['to']) ? $srch['to'] : ''; ?>">        <div class="input-group-append">          <button type="submit" name='submit' id="submit" class="btn btn-primary">Search</button>        </div>      </div>	<?php } ?>		 </form>
    <div id="prod">
      <table class="table table-hover table-bordered adminmenu_list" id="example1">
        <thead>
          <tr>
            <th>Txn ID #</th>
            <th>Datetime</th>
            <th>Info</th>
            <th>Status</th>
            <th>Debit (Dr)</th>
            <th>Credit (Cr)</th>
            <th align="center">Detail</th>
          </tr>
        </thead>
        <tbody>
          <?php
                               $attr = array(
                                
                                'class' => 'la la-times _165x red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
          <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { ?>
          <tr>
            <td><a href="javascript:void(0)" onclick="loadTxnDetail('<?php echo $val['txn_id']?>'); "><?php echo !empty($val['txn_id']) ? $val['txn_id'] : '-'; ?></a></td>
            <td><?php echo !empty($val['datetime']) ? $val['datetime'] : 'N/A'; ?></td>
            <td><?php echo !empty($val['info']) ? $val['info'] : ''; ?></td>
            <td align="center"><?php
										$status = '';
										switch($val['status']){
											case 'Y' : 
												$status = '<font color="green">Success</font>';
											break;
											case 'P' : 
												$status = '<font color="blue">Pending</font>';
											break;
											case 'N' : 
												$status = '<font color="red">Rejected</font>';
											break;
										}
										echo $status;
										?></td>
            <td align="center">$ <?php echo !empty($val['debit']) ? $val['debit'] : '0.00'; ?></td>
            <td align="center">$ <?php echo !empty($val['credit']) ? $val['credit'] : '0.00'; ?></td>
            <td align="center"><a href="javascript:void(0)" onclick="loadTxnDetail('<?php echo $val['txn_id']?>'); " title="View"><i class="la la-eye _165x"></i></a></td>
          </tr>
          <?php
                                }
                            } else {
                                ?>
          <tr>
            <td colspan="7" align="center" style="color:#F00">No records found...</td>
          </tr>
          <?php
							}
							?>
        </tbody>
      </table>
      <table class="table table-hover table-bordered adminmenu_list">
        <tr>
          <th>Total Debit : $ <?php echo $debit_total; ?></th>
          <th>Total Credit : $ <?php echo $credit_total; ?></th>
          <th>Origional Balance : $ <?php echo $org_val = (string) ($credit_total - $debit_total); ?></th>
          <th>Wallet Balance : $ <?php echo $wallet_val = get_wallet_balance($wallet_id); ?> &nbsp;
            <?php if($wallet_id == ESCROW_WALLET){
								if($org_val > 0){
									echo '<a href="'.base_url('fund/escrow_project_list').'">View Detail</a>';
								}
							}
							?>
          </th>
          <th><?php if($org_val != $wallet_val){ ?>
            <button class="btn btn-default" onclick="updateWalletBalance('<?php echo $wallet_id?>'); ">Update</button>
            <?php  } ?></th>
        </tr>
      </table>
      <?php echo $links;?> </div>
  </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
<div id="txnDetailModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Transaction Detail</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="modal_body">
        <p>Some text in the modal.</p>
      </div>
    </div>
  </div>
</div>
<style>
  @media print {
  body * {
    visibility: hidden;
  }
  #st{ display: none;}
  #ac{ display: none;}
  #stt{ display: none;}
  #acc{ display: none;}
  #example1_length{ display: none;}
  #example1_filter{ display: none;}
  .pagination{ display: none;}
  .crumb{ display: none;}
  #sidebar{ display: none;}
  #prod * {
    visibility: visible;
  }
  #prod {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<script>
function prnt()
{
  window.print();
}


</script> 
<script>
function updateWalletBalance(wallet_id){
	if(wallet_id){
		$.ajax({
			url : '<?php echo base_url('fund/update_wallet');?>',
			data: {wallet_id: wallet_id, cmd: 'update_origional'},
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res.status == 1){
					location.reload();
				}
			}
		});
	}
}

function loadTxnDetail(txn_id){
	$('#txnDetailModal').modal('show');
	$('#modal_body').html('<center>Loading Transaction Detail ...</center>');
	if(txn_id){
		$.get('<?php echo base_url('fund/txn_detail_ajax?txn_id='); ?>'+txn_id, function(res){
			$('#modal_body').html(res);
		});
	}
}

</script> 
