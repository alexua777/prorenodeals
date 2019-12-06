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
        <li class="breadcrumb-item"><a href="<?= base_url() ?>fund/project_transaction">Project Transaction History</a></li>
        <li class="breadcrumb-item active"><a>Project Transaction Detail (Project: <?php echo $project_title; ?>)</a></li>
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
        <input type="text" class="form-control" id="datepicker_from" name="from" readonly="readonly" size="15" value="<?php echo !empty($srch['from']) ? $srch['from'] : ''; ?>"/>
        <input type="text" class="form-control" id="datepicker_to" name="to" readonly="readonly" size="15" value="<?php echo !empty($srch['to']) ? $srch['to'] : ''; ?>"/>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name='submit' id="submit">Search</button>
      </div>
    </div>                      
    </form>
    <div id="prod">
      <table class="table table-hover table-bordered adminmenu_list" id="example1">
        <thead>
          <tr>
            <th>Txn ID #</th>
            <th>Wallet Info</th>
            <th>Datetime</th>
            <th>Info</th>
            <th>Status</th>
            <th>Debit (Dr)</th>
            <th>Credit (Cr)</th>
          </tr>
        </thead>
        <tbody>
          <?php
                               $attr = array(
                                
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
          <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { ?>
          <tr>
            <td><?php echo !empty($val['txn_id']) ? $val['txn_id'] : '-'; ?></td>
            <td><?php
											$wallet_id = $val['wallet_id'];
											$wallet_title = getField('title', 'wallet', 'wallet_id', $wallet_id);
											$type = 'From :';
											if($val['credit'] > 0){
												$type = 'To :';
											}
											?>
              <p><b>Wallet ID # : </b><?php echo $wallet_id; ?><br/>
                <b><?php echo $type; ?> </b><?php echo $wallet_title; ?> (Wallet)</p></td>
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
      <table class="table table-hover table-bordered adminmenu_list hidden">
        <tr>
          <th>Total Debit : $
            <?php //echo $debit_total; ?></th>
          <th>Total Credit : $
            <?php //echo $credit_total; ?></th>
          <th>Origional Balance : $
            <?php //echo $org_val = ($credit_total - $debit_total); ?></th>
          <th>Wallet Balance : $
            <?php //echo $wallet_val = get_wallet_balance($wallet_id); ?></th>
        </tr>
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
