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
        <div class="crumb">
            <ol class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
				<li class="active"><a href="<?= base_url('fund/escrow_project_list') ?>">Escrow statics</a></li>
                <li class="active">Escrow</li>
            </ol>
        </div>


        <div class="container-fluid">            			
			
				<?php
				if($this->session->flashdata('succ_msg')){
				?>
				<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?php echo $this->session->flashdata('succ_msg'); ?>
				</div> 
				<?php
				}
				if($this->session->flashdata('error_msg')){
				
				?>
				<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?php echo $this->session->flashdata('error_msg'); ?>
				</div>
				<?php
				}
				?>
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list">
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
							$total_credit = 0;
							$total_debit = 0;
						
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									$total_credit += $val['credit'];
									$total_debit += $val['debit'];
									?>

                                    <tr> 
										
									  <td><?php echo $val['txn_id'];?></td>
                                       <td>
										<?php
										$wallet_id = $val['wallet_id'];
										$wallet_title = getField('title', 'wallet', 'wallet_id', $wallet_id);
										$type = 'From :';
										if($val['credit'] > 0){
											$type = 'To :';
										}
										?>
										<b><?php echo $type; ?>  </b><?php echo $wallet_title; ?> (Wallet)</p>
										</td>
                                        
                                      
									  	<td><?php echo !empty($val['datetime']) ? $val['datetime'] : 'N/A'; ?></td>
										<td><?php echo !empty($val['info']) ? $val['info'] : ''; ?></td>
							
										<td align="center">
										<?php
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
										?>
										</td>
										<td align="center"><?php echo CURRENCY;?> <?php echo !empty($val['debit']) ? $val['debit'] : '0.00'; ?></td>
										<td align="center"><?php echo CURRENCY;?> <?php echo !empty($val['credit']) ? $val['credit'] : '0.00'; ?></td>
							
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
						<tr>
							<th colspan="4"></th>
							<th>Total Pending : $<?php echo (string) $total_credit - (string) $total_debit; ?></th>
							<th>Total Debit : $<?php echo $total_debit; ?></th>
							<th>Total Credit :  $<?php echo $total_credit; ?></th>
						</tr>
                        </tbody>
						
                    </table>
     
				<?php echo $links;?>
              </div>                                   

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>

<div id="txnDetailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Transaction Detail</h4>
      </div>
      <div class="modal-body" id="modal_body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
