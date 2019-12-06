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
        <li class="breadcrumb-item"><a href="<?= base_url('fund/escrow_project_list') ?>">Escrow statics</a></li>   
        <li class="breadcrumb-item active"><a>Escrow</a></li>
      </ol>
    </nav>        
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
                                <th style="text-align:left;"> ID #</th>
                                <th style="text-align:left;">Project</th>
                                <th style="text-align:left;">Milestone Info</th>
                                <th style="text-align:left;">Amount</th>
                                <th style="text-align:center;">Status</th>
                                
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
							$total_credit = 0;
							$total_debit = 0;
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { 
								$total_credit += $val['amount'];
								if($val['status'] == 'R'){
									$total_debit += $val['amount'];
								}
								?>

                                    <tr> 

                                        <td><?php echo !empty($val['escrow_id']) ? $val['escrow_id'] : '-'; ?></td>
                                        <td title="<?php echo !empty($val['project_title']) ? $val['project_title'] : ''; ?>"><?php echo !empty($val['project_title']) ? (strlen($val['project_title']) > 60 ? substr($val['project_title'], 0, 60).'...' : $val['project_title']) : '-'; ?></td>
                                        
                                        <td>
										<?php 
										if(!empty($val['title'])){
											echo "<b>Title : </b> {$val['title']} <br/>";
										}else{
											echo "<b>Title : </b> <i>N/A</i> <br/>";
										}
										?>
										
										</td>
										<td>$ <?php echo !empty($val['amount']) ? $val['amount'] : '0.00'; ?></td>
                                       
										<td align="center">
										<?php 
											switch($val['status']){
												case 'R': 
												echo '<font color="green">Released</font>';
												break;
												case 'P': 
												echo '<font color="orange">Pending</font>';
												break;
												case 'D': 
												echo '<font color="red">Dispute</font>';
												break;
											}
										?>
										</td>
                                        
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
							<?php if(!empty($srch['project_id'])){ ?>
							<tr>
								<th colspan="2"></th>
								<th>Total Pending : $ <?php echo (string) $total_credit - (string) $total_debit; ?></th>
								<th>Total Deposited : $ <?php echo $total_credit; ?></th>
								<th>Total Released :  $ <?php echo $total_debit; ?></th>
							</tr>
							<?php } ?>
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
