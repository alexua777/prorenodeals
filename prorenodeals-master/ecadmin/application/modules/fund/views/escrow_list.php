<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>fund/transaction_history">Escrow Management</a></li>
            </ul>
        </div>


        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-table-2"></i> Escrow List</h1>
            </div>
            <div class="row">

                <div class="col-lg-12">
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Id</th>
                                <th style="text-align:left;">Details</th>
                                 <th style="text-align:center;">Total Amount</th>
                               
                                <th style="text-align:center;">Date</th>
                               	<th style="text-align:center;">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                       
                              <?php
                            $attr = array(
                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                'onclick' => "javascript: return confirm('Do you want to release payment?');",
                                'class' => ' i-hand yellow',
                                'title' => 'Unpaid'
                            );
                            $atr4 = array(
								'onclick' => "javascript: return confirm('Do you want to dispute?');",
                                'class' => 'i-thumbs-up-4 red',
                                'title' => 'Dispute'
                            );
							  $atr5 = array(
                                'class' => 'i-thumbs-up-3 green',
                                'title' => 'Release'
                            );

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
							?>
                            <div id="prodlist">
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									$emp_fname=$this->auto_model->getFeild('fname',"user",'user_id',$val['employer_id']);
									$emp_lname=$this->auto_model->getFeild('lname',"user",'user_id',$val['employer_id']);
									//$bidder_id=$this->auto_model->getFeild('bidder_id',"projects",'project_id',$val['project_id']);
									$wor_fname=$this->auto_model->getFeild('fname',"user",'user_id',$val['bidder_id']);
									$wor_lname=$this->auto_model->getFeild('lname',"user",'user_id',$val['bidder_id']);
									
									//$total_amt=$this->auto_model->getFeild('total_amt',"bids",'','',array('project_id'=>$val['project_id'],'bidder_id'=>$bidder_id));
									
									$title=$this->auto_model->getFeild('title',"projects",'project_id',$val['project_id']);
									
                                    ?>

                                    <tr> 	

                                        <td style="text-align:left;"><?php echo $val['id'] ?></td>
                                        <td>
                                     	    Project Name: <b><?php echo ucwords($title) ?></b><br />
											Employer Name :   <?php echo ucwords($emp_fname." ".$emp_lname) ?><br />
                                            Provider Name :   <?php echo ucwords($wor_fname." ".$wor_lname) ?><br />
                                       	 	 
                                        </td>
                                        
                                        <td style="text-align:center;"><?php echo CURRENCY;?> <?php echo $val['amount'];?></td>
                                        <td style="text-align:center;"><?php echo date('d-M-Y',strtotime($val['mpdate'])); ?></td>
                                        <td style="text-align:center;">
                                        <?php
										if($val['release_payment']=="D")
										{						
										?>
                                       <a class="active" href="<?php echo base_url() . 'fund/dispute'; ?>">View Disputes</a> 
                                        <?php
										}
										else
										{											
											echo "N/A";
										}
                                         ?>
                                        </td>
                                     
                                    </tr>



                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center" style="color:#F00">No active records found...</td>
                                </tr>
							
    <?php
}
?>
						
                        </tbody>
                    </table>
              </div>
                    <?php if ($page>30) {?>    

                      <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
                      <?php }  ?>
                </div><!-- End .col-lg-6  -->
            </div><!-- End .row-fluid  -->

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