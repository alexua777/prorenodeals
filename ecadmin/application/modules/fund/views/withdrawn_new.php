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
      <li class="breadcrumb-item active"><a>Withdraw History</a></li>
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
    <form action="">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="From" id="datepicker_from" name="from" readonly="readonly" value="<?php echo !empty($srch['from']) ? $srch['from'] : ''; ?>">
        <input type="text" class="form-control" placeholder="To" id="datepicker_to" name="to" readonly="readonly" value="<?php echo !empty($srch['to']) ? $srch['to'] : ''; ?>">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" name='submit' id="submit">Search</button>
        </div>
      </div>
    </form>
    <div id="prod">
      <table class="table table-hover table-bordered adminmenu_list" id="example1">
        <thead>
          <tr>
            <th>Transaction Date</th>
            <th>Details</th>
            <th>Transaction Through</th>
            <th>Amount</th>
            <th>Net Pay</th>
            <th>Action Payment</th>
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
                                $p=0;
                                foreach ($all_data as $key => $val) {
									$accDetails =  (array) json_decode($val['reference']);
                                    ?>
          <tr>
            <td><?= date('d-M-Y H:i:s',strtotime($val['datetime'])); ?></td>
            <td><?php 
											$user = $val['user_details'];
										?>
              <b>User Name :</b>
              <?= ucwords($user['name']) ?>
              <br />
              <b>Email:</b>
              <?= $user['email'] ?>
              <br />
              <b>Account Balance:</b> $ <?php echo get_wallet_balance($val['wallet_id'] );?><br /></td>
            <td><?php 
											if($accDetails && $accDetails['account_for'] =="P"){
											
												echo 'PayPal';
											}else{
												if($accDetails){
													echo 'Wire Transfer';
												}
											}
											?>
              <br/>
              <?php 
											if($accDetails){ 
											?>
              <?php if($accDetails['account_for'] == 'P'){ ?>
              <b>Paypal ID :</b> <?php echo $accDetails['paypal_account']; ?>
              <?php }else{ ?>
              <b>Account number :</b> <?php echo $accDetails['wire_account_no']; ?><br/>
              <b>Name :</b> <?php echo $accDetails['wire_account_name']; ?><br/>
              <b>IFCI Code :</b> <?php echo $accDetails['wire_account_IFCI_code']; ?><br/>
              <?php } ?>
              <?php } ?></td>
            <td><?php
										 if($val['withdraw_amount']!=0)
										{
											echo '$'.$val['withdraw_amount'];
										}?></td>
            <td><?php echo '$' . $val['net_pay']; ?></td>
            <td align="center"><?php if($val['status'] == 'Y'){ ?>
              <font color="green">Paid</font>
              <?php }else if($val['status'] == 'P'){  ?>
              <button class="btn btn-outline-success btn-sm mb-1" onclick="handle_txn('<?php echo $val['txn_id']; ?>', 'approve')">Approve</button>
              <button class="btn btn-outline-danger btn-sm" onclick="handle_txn('<?php echo $val['txn_id']; ?>', 'deny')">&nbsp; Deny &nbsp;</button>
              <?php }else{  ?>
              <font color="red">Denied</font>
              <?php } ?></td>
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
      <?php echo $links;?> </div>
  </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
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
function handle_txn(txn_id, cmd){
	if(txn_id && cmd){
		$.ajax({
			url : '<?php echo base_url('fund/status_txn_new');?>',
			data: {txn_id: txn_id, cmd: cmd},
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
</script>