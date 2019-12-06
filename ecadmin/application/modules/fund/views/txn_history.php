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
        <li class="breadcrumb-item active"><a>Transaction History</a></li>
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
			
                     <form action="">
					<div class="input-group mb-3">
                      <input type="text" class="form-control" id="datepicker_from" name="from" readonly="readonly" value="<?php echo !empty($srch['from']) ? $srch['from'] : ''; ?>" placeholder="From"><input type="text" class="form-control" id="datepicker_to" name="to" readonly="readonly" value="<?php echo !empty($srch['to']) ? $srch['to'] : ''; ?>" placeholder="To"/>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name='submit' id="submit">Search</button>
                      </div>
                      <div class="input-group-append">
                      <a href="<?php echo base_url('fund/transaction_history_new'); ?>" class="btn btn-outline-danger" style="margin-left: 10px;">Clear Filter</a>
                      </div>
                    </div>                   					
					 
                    
					</form>
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list">
                        <thead>  	
                            <tr>
                                <th>Txn ID #</th>
                                <th>Key</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Detail</th>
                                
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

                                        <td><?php echo !empty($val['txn_id']) ? $val['txn_id'] : '-'; ?></td>
                                        <td title="<?php echo !empty($val['description']) ? $val['description'] : ''; ?>"><?php echo !empty($val['key']) ? $val['key'] : '-'; ?></td>
                                        <td><?php echo !empty($val['datetime']) ? $val['datetime'] : ''; ?></td>
                                        
                                        <td align="center">
										<?php
										$status = '';
										switch($val['status']){
											case 'Y' : 
												$status = '<font color="green">Success</font>';
											break;
											case 'P' : 
												$status = '<font color="orange">Pending</font>';
											break;
											case 'N' : 
												$status = '<font color="red">Rejected</font>';
											break;
										}
										echo $status;
										?>
										
										</td>
										<td align="center"><a href="javascript:void(0)"  onclick="loadTxnDetail('<?php echo $val['txn_id']; ?>');" title="Detail"><i class="la la-eye _165x"></i></a></td>
                                        
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
     
				<?php echo $links;?>
              </div>
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
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
function loadTxnDetail(txn_id){
	$('#txnDetailModal').modal('show');
	$('#modal_body').html('<center>Loading Transaction Detail ...</center>');
	if(txn_id){
		$.get('<?php echo base_url('fund/txn_detail_ajax')?>?txn_id='+txn_id, function(res){
			$('#modal_body').html(res);
		});
	}
}
</script>