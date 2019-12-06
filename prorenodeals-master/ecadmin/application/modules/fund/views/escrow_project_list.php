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
        <li class="breadcrumb-item active"><a>Escrow Statistics</a></li>
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
                                <th>Project&nbsp;ID&nbsp;#</th>
                                <th>Project</th>
                                <th>Escrow&nbsp;Amount($)</th>
                                <th>Released&nbsp;Amount($)</th>
                                <th>Pending&nbsp;Balance($)</th>
                                <th>Detail</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                       
                          
                            <?php
							$total_pending = 0;
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
								$pending_bal = ($val['total_credit'] - $val['total_debit']);
								$total_pending += $pending_bal;
								?>

                                    <tr> 
										
										<td><?php echo $val['project_id'];?></td>
                                        <td title="<?php echo !empty($val['title']) ? $val['title'] : ''; ?>"><?php echo !empty($val['title']) ? (strlen($val['title']) > 60 ? substr($val['title'], 0, 60).'...' : $val['title']) : '-'; ?></td>
                                        
                                        <td><font color="green"><?php echo !empty($val['total_credit']) ? $val['total_credit'] : ''; ?></font></td>
                                        <td><font color="red"><?php echo !empty($val['total_debit']) ? $val['total_debit'] : ''; ?></font></td>
                                        <td><font color="orange"><?php echo $pending_bal ; ?></font></td>
										<td align="center">
										<?php if($val['project_type'] == 'F'){ ?>
										<a href="<?php echo base_url('fund/escrow_list_new?project_id='.$val['project_id']);?>" title="View"><i class="la la-eye _165x"></i></a>
										<?php }else{  ?>
										<a href="<?php echo base_url('fund/escrow_project_txn/'.$val['project_id']);?>" title="View"><i class="la la-eye _165x"></i></a>
										<?php } ?>
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
						<tr>
							<td colspan="4"></td>
							<td colspan="2"><b>Total Pending : $ <?php echo $pending_escrow_balance; ?></b></td>
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
