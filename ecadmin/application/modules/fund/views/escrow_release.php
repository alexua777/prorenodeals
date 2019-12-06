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
                                <th style="text-align:center;">Reason</th>
                                <th style="text-align:center;">Date</th>
                               
                                <th style="text-align:center;" id="stt">Action</th>
                                
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
                                'onclick' => "javascript: return confirm('Do you want to active this?');",
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                                'onclick' => "javascript: return confirm('Do you want to inactive this?');",
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active'
                            );
							  $atr5 = array(
                                'class' => 'i-hammer-2 green',
                                'title' => 'Bid List'
                            );

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
							?>
                            <div id="prodlist">
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									
									
                                    ?>

                                    <tr> 	

                                        <td style="text-align:left;"><?php echo $val['id'] ?></td>
                                        <td>
                                     	    Escrow By : <b><?php echo ucwords($val['worker']) ?></b><br />
											Escrow To :   <?php echo ucwords($val['employer']) ?><br />
                                       	 	  Project :  <?php echo ucwords($val['project_name']) ?><br />
                                              Amount(USD) :  <?php if($val['amount']!=0 && $val['amount']!='')
																		{
																			echo '$'.$val['amount'];
																		}
															?> 
                                              
                                        </td>
                                        <td style="text-align:center;"><?php echo $val['reason'] ?></td>
                                        <td style="text-align:center;"><?php echo date('F j,Y g:i a',strtotime($val['add_date'])); ?></td>
                                          <td align="center" id="ac">
											
                                         <?php
										 // release_type P=Paid D=Dispute U=Unpaid
										 if($val['release_type']=='P')
										 {	
										    echo 'Paid' ;
										 }
										 elseif($val['release_type']=='D')
										 {
											 echo 'Dispute'; 											 
										 }
										 elseif($val['release_type']=='U')
										 {
											 echo 'Unpaid'; 											 
										 }
											
									
									   
                                         ?>


                                        </td>
                                        
                                
                                      
                                    </tr>



                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" align="center">No records found...</td>
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