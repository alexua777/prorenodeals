<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>project/">Project Management</a></li>        
        <li class="breadcrumb-item active"><a>Milestone list</a></li>
      </ol>
    </nav> 

        <div class="container-fluid">
                    <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                        </div> 
                        <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                        </div>
    <?php
}
?>
                    <div class="text-right mb-2"><a href="<?=base_url().'project/process/'?>" class="btn btn-primary"><i class="la la-arrow-left"></i> Back to project list</a></div>                    <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Milestone No</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Bidder</th>
                                <th>Employer</th>
                              	<th>Description</th>
                              	<th>Request By</th>
                                <th>Milestone Approval</th>
                                <th>Fund Release</th>
                                <th>Invoice</th>
                              	<th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>                                                                             
                    		<?php
                            if (count($all_data) > 0) {
							//print_r($all_data);die;
                                foreach ($all_data as $key => $val) {
                                    
									?>

                                    <tr>  
                                         <td align="center"><?php echo $val['id'];?></td>
                                        
                                         <td align="center"><?php echo $val['milestone_no'];?></td>
                                 
                                	   <td align="center"><?php if($val['amount']!= 0 && $val['amount']!='')
									    echo '$'.$val['amount'] ;?></td>
                                        
                                        <td align="center"><?php echo date('d-M-Y',strtotime($val['mpdate'])) ;?></td>
                                         
                                       <td ><?php echo $val['bidder']// ;?></td>                               
                                        <td ><?php echo $val['employer'] ;?></td> 
                                        <td><?php echo $val['description'];?></td>   
                                        <?php
										$request_by="";
										if($val['request_by']=="E")
										{
											$request_by="Employer";
										}
										elseif($val['request_by']=="F")
										{
											$request_by="Freelancer";
										}
										?>                                        
                                        <td><?php echo $request_by;?></td>  
                                        
                                        <?php
										$client_approval="";
										if($val['client_approval']=="D")
										{
											$client_approval="Milestone is not set";
										}
										elseif($val['client_approval']=="Y")
										{
											$client_approval="Milestone is approved";
										}
										elseif($val['client_approval']=="N")
										{
											$client_approval="Waiting for approval";
										}
										?>                                        
                                        <td><?php echo $client_approval;?></td>
                                        
                                        <?php
										$fund_release="";
										if($val['fund_release']=="A")
										{
											$fund_release="Approved";
										}
										elseif($val['fund_release']=="P")
										{
											$fund_release="Pending";
										}
										elseif($val['fund_release']=="R")
										{
											$fund_release="Requested";
										}
										?>                                        
                                        <td><?php echo $fund_release;?></td>
                                        
                                        <?php
										$release_payment="";
										if($val['release_payment']=="Y")
										{
											$release_payment="Approved";
										}
										elseif($val['release_payment']=="N")
										{
											$release_payment="Not Set Yet";
										}
										elseif($val['release_payment']=="R")
										{
											$release_payment="Requested";
										}
										elseif($val['release_payment']=="D")
										{
											$milestone_paymentid=$this->auto_model->getFeild('id','milestone_payment','milestone_id',$val['id'],'');
											$pay_status=$this->auto_model->getFeild('status','dispute','milestone_id',$milestone_paymentid,'');
											if($pay_status=="Y")
											{
												$release_payment="Dispute Resolved";
											}
											else
											{
												$release_payment="<a href='".base_url().'fund/dispute/'."'>Disputed</a>";
											}
										}
										?>                                        
                                        <td>
											<?php 
											if($val['release_payment']=="Y")
											{
												echo '<a href="'.SITE_URL.'dashboard/invoice/'.$val['invoice_id'].'/F" target="_blank">Invoice</a>';
											}else{
												echo '--';
											}?>
										</td>
                                        <td><?php echo $release_payment;?></td>
                                 
                                    </tr>



                                    <?php
                                }
                           } else {
                                ?>
                                <tr>
                                    <td colspan="2" align="center" style="color:#F00;">No records found...</td>
                                </tr>
							
						<?php
                    }
                    ?>                     
                        </tbody>
                    </table>
              </div>                                    
        </div>
    </div> 
</section>

     


