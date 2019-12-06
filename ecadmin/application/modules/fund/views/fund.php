<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>fund/addfund">Add Fund by Wire Transfer List</a></li>
            </ul>
        </div>


        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-table-2"></i>Add Fund List </h1>
            </div>
            <div class="row">

                <div class="col-lg-12">
                        
            
                    </br>
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Deposit Date</th>
                                <th style="text-align:left;">User Name</th>
                                <th style="text-align:left;">Details</th>
                                <th style="text-align:center;">Amount</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                                
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
                                'title' => 'Active'
                            );
							?>
                            <div id="prodlist">
                            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
					$user_name =$this->auto_model->getFeild('username','user','user_id',$val['user_id']);
                            ?>

                                    <tr> 

                                        <td style="text-align:left;"><?= date('d-M-Y',strtotime($val['dep_date'])); ?></td>
                                        <td style="text-align:left;"><?= ucwords($user_name); ?></td>
                                        <td>
                                       Transaction Id : <b><?= $val['trans_id'] ?></b><br />
											Payee Name :   <?= ucwords($val['payee_name']) ?><br />
                                       	  Bank Name :  <?= ucwords($val['dep_bank']) ?>
                                          Branch Name :  <?= ucwords($val['dep_branch']) ?>
                                        </td>
                                        
                                        <td style="text-align:center;"><?php
										 if($val['amount']!=0)
										{
											echo '$'.$val['amount'];
										}?>
                                        </td>
                                          <td align="center" id="ac">
<?php
                                            if ($val['status'] == 'Y') { ?>
                                                <span class="i-checkmark-3 green"></span>
                                           <?php } else { ?>
                                            <span class="i-checkmark-3 red"></span>

                                        <?php        
                                            }
                                            ?>

                                        </td>
                                        <td align="center" id="ac">
<?php
                                            if ($val['status'] == 'N') { ?>
                                            <a style="text-decoration: none;" href="<?php echo VPATH;?>fund/release/<?php echo $val['id'];?>">Approve</a> |
                                           <?php } ?>
                                            <a style="text-decoration: none;" href="<?php echo VPATH;?>fund/deleteAddFund/<?php echo $val['id'];?>">Delete</a>


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
              </div>
                    <?php
                    	echo $links;
					?>
                </div><!-- End .col-lg-6  -->
            </div><!-- End .row-fluid  -->

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>

