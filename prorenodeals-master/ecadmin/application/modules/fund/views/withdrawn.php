<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
	<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo IMAGE;?>caln.png",
			buttonImageOnly: true
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo IMAGE;?>caln.png",
			buttonImageOnly: true
		});
	});
	</script>


<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ol class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>fund/transaction_history">Transaction History List</a></li>
                <li>Withdrawn History</li>                
            </ol>
        </div>


        <div class="container-fluid">           			
			
				<?php
				if($this->session->flashdata('succ_msg')){
				foreach($this->session->flashdata('succ_msg') as $val){
				?>
				<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?=$val ?>
				</div> 
				<?php
				}}
				if($this->session->flashdata('error_msg')){
				foreach($this->session->flashdata('error_msg') as $val){
				?>
				<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $val?>
				</div>
				<?php
				}}
				?>
			
			
			

                
                        <form action="<?=base_url()?>fund/search" method="post">
            
                    <div class="input-group-btn">
					<input type="text" id="datepicker_from" name="from_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo set_value('from_txt');?>"/>
					<input type="text" id="datepicker_to" name="to_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo set_value('to_txt');?>"/>
                  
                    <input type="submit" name='submit' id="submit" class="btn" value="SEARCH">
                    </div></br></form>
  
                     <div id="prod">
                         <form method="post" action="<?php echo VPATH;?>fund/approvepay">      
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Transaction Date</th>
                                <th style="text-align:left;">Details</th>
                                <th style="text-align:center;">Transaction Through</th>
                                <th style="text-align:center;">Amount</th>
                               
                                <th style="text-align:center;" id="stt">Status</th>
								<th style="text-align:center;" id="stt">Approved By</th>
								
								<th style="text-align:center;" id="stt">Action Payment</th>
                                
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
                                $p=0;
                                foreach ($all_data as $key => $val) {
								
                                    ?>

                                    <tr> 

                                        <td style="text-align:left;">
										<?= date('d-M-Y H:i:s',strtotime($val['transction_date'])); ?></td>
                                        <td>
										
										
                                       Correlation Id : <b><?php echo $val['corelation_id'];?></b><br />
									   
										<?php 
											$user = $val['user_details'];
										?>
									   
									   
										<b>User Name :</b>   <?= ucwords($user['name']) ?><br />
										<b>Email:</b>   <?= $user['email'] ?><br />
										<b>Account Balance:</b>  $ <?= $user['acc_balance'] ?><br />
                                       	<b> Account Details :
										<?php if($val['transer_through'] =="P"){
											
												echo '(PayPal)';
											}elseif($val['transer_through'] =="S"){
												echo '(Skrill)';
											}else{
											
												echo '(Wire Transfer)';
											}
										
										?>
										</b>
										<?php 
										
										$accDetails =  $val['account_details'];
										
										
										if($val['transer_through'] =="P"){
											
											echo '<br><b>PayPal Account : </b> '.$accDetails['paypal_account'];
											
											}elseif($val['transer_through'] =="S"){
											echo '<br><b>Skrill Account : </b> '.$accDetails['skrill_account'];		
											}else{
										
											echo '<br><b> Account No : </b> '.$accDetails['wire_account_no'];
											echo '<br><b> Account Name : </b> '.$accDetails['wire_account_name'];
											echo '<br><b> IFCI Code : </b> '.$accDetails['wire_account_IFCI_code'];
											echo '<br><b> Country : </b> '.$accDetails['country'];
										
											}?>

										
                                        </td>
                                        <td style="text-align:center;">
										
										<?php 

											if($val['transer_through'] =="P"){
											echo "Paypal";
											}elseif($val['transer_through'] =="S"){
												echo "Skrill";
											 }else{											
											echo "Wire Transfer";											
											}
											?>
										
										
										
										</td>
                                        <td style="text-align:center;"><?php
										 if($val['total_amount']!=0)
										{
											echo '$'.$val['total_amount'];
										}?>
                                        </td>
                                          <td align="center" id="ac">
<?php
                                            if ($val['status'] == 'Y') {?>
                                              
											  <span class="i-checkmark-3 green"></span>
                                            <?php } else {?>

                                                 <span class="i-checkmark-3 red"></span>
                                          <?php  }
                                            ?>

                                        </td>
                                        
                                        <td align="center" id="ac">
<?php
                                            if ($val['admin_id'] != 0) {
											echo $this->auto_model->getFeild('username','admin','admin_id',$val['admin_id'],'');
											 } else { echo "N/A";  }
                                            ?>

                                        </td>
										
										<td>
										
										<?php 
										if($val['transer_through'] =="P"){?>
										
										<!-- <a href="paypal_transfer/<?php echo $val['withdrawl_id']?>"> PayPal</a> -->
                                        <?php
                                        if($val['status'] == 'N')
										{
										?>                                        
                                        <input type=checkbox name='approve[]' value="<?php echo $val['withdrawl_id'];?>">&nbsp;Approve             
                                        <a href="paypal_transfer/<?php echo $val['withdrawl_id']?>" class="btn">Pay Now</a>                           <?php
										}
										else
										{
											echo "Approved";	
										}
										?>                                    
                                          <?
                                          }elseif($val['transer_through'] =="S"){
                                          
                                          ?>
                                          
                                           <?php
                                        if($val['status'] == 'N')
										{
										?>                                        
                                        <input type=checkbox name='approve[]' value="<?php echo $val['withdrawl_id'];?>">&nbsp;Approve             
                                        <!--<a href="paypal_transfer/<?php echo $val['withdrawl_id']?>" class="btn">Pay Now</a>-->                            <?php
										}
										else
										{
											echo "Approved";	
										}
										?>                                      
											<?php }else{ 
											if($val['status'] == 'N')
											{
											?>
											<a href="javascript:void(0);" onclick="javascript:if(confirm('Are you sure to approve this transaction?')){window.location.href='wire_transfer/<?php echo $val['withdrawl_id']?>'};">Approve</a>
											<?php 
											}
											else
											{
												echo "Approved";	
											}
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
						
                        </tbody>
                    </table>
                             <span style="float: right;margin-right: 40px;">
                                 <input type="submit" name="updt" value="UPDATE">                                 
                             </span>       
                             
                             
                </form>
				<?php echo $links;?>
              </div>                                    

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
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

function srch(id)
{
	var elmnt=$('#'+id).val();
	//alert(elmnt);
	var dataString = 'cid='+elmnt;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>product/getprod/"+elmnt,
     success:function(return_data)
     {
      	$('#prod').html('');
		$('#prod').html(return_data);
     }
    });
}
</script>