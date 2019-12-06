
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			maxDate: new Date(),
			showOn: "button",
			buttonImage: "<?=ASSETS?>/images/caln.png",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "<?=ASSETS?>/images/caln.png",
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd'
		});
	});
	</script>


<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ul class="breadcrumb">
                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="active"><a href="<?= base_url() ?>fund/transaction_history">Transaction History List</a></li>
            </ul>
        </div>


        <div class="container-fluid">
            <div id="heading" class="page-header">
                <h1><i class="icon20 i-table-2"></i> Transaction History </h1>
            </div>
            <div class="row">

                <div class="col-lg-12">	<form action="<?php echo base_url('fund/search'); ?>" method="get">				<table class="table">					<tr>					<td><input type="text" id="datepicker_from" name="from_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo !empty($from_txt)?$from_txt: set_value('from_txt');?>" placeholder="From date"/></td>										<td><input type="text" id="datepicker_to" name="to_txt" readonly="readonly" size="15" style="margin-right: 6px;"  value="<?php echo !empty($to_txt)?$to_txt:set_value('to_txt');?>" placeholder="To date"/></td>					<td><input type="text" id="uname" name="uname" size="15" value="<?php echo !empty($uname)? $uname :set_value('uname');?>" Placeholder="Name/ User Name/ Email"/></td>
				<td>
					<input type="text" name="project" value="<?php echo !empty($srch['project']) ? $srch['project'] : '';?>" placeholder="Project"/>
				</td>
				<td>
				
				<select id="trnxs" name="trnxs"><option value="">Select Type</option>
				<option value="DR" <?php echo (!empty($trnxs) AND $trnxs == 'DR') ? 'selected="selected"' : '';?> >DR</option>
				<option value="CR" <?php echo (!empty($trnxs) AND $trnxs == 'CR') ? 'selected="selected"' : '';?> >CR</option>
				</select></td><td>
				<input type="submit" name='submit' id="submit" class="btn" value="SEARCH"></td>
				<td>
					<?php 
					$srch_query_string = !empty($srch) ? '?'.http_build_query($srch) : '';
					?>
					<a href="<?php echo base_url('fund/exportTxn').$srch_query_string;?>" class="btn btn-info">Export</a>
				</td>
				</tr>
				</table>
				
				</form>
                    </br>
  
                     <div id="prod">
                    <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>  	
                            <tr>
                                <th style="text-align:left;">Transaction Date</th>
                                <th style="text-align:left;">Details</th>
                                <th style="text-align:left;">Activity</th>
                                <th style="text-align:center;">Credit/Debit</th>
                                <th style="text-align:center;">Amount</th>
                               
                                <th style="text-align:center;" id="stt">Status</th>
                                
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
                            <?php															//print_r($all_data);//die();
                            if (count($all_data) > 0) {								
                                foreach ($all_data as $key => $val) {
									$user_name =$this->auto_model->getFeild('username','user','user_id',$val['user_id']);									
                                    ?>

                                    <tr> 

                                        <td style="text-align:left;"><?= date('d-M-Y H:i:s',strtotime($val['transction_date'])); ?></td>
                                        <td>
                                       Transaction Id : <b><?= $val['paypal_transaction_id'] ?></b><br />
                                       Project Name : <b><?php if($val['project_id']!="") { echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']); } ?></b><br />
											User Name :   <?= ucwords($user_name) ?><br />
                                       	  Description :  <?= ucwords($val['transaction_for']) ?>
                                        </td>
										<td style="text-align:center;"><?= $val['activity'] ?></td>
                                        <td style="text-align:center;"><?= $val['transction_type'] ?></td>
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
<script>
function hdd()
{
	var from=$( "#datepicker_from" ).val();	
	var to=$( "#datepicker_to" ).val();	
	var uname=$( "#uname" ).val();	
	var trnxs=$( "#trnxs" ).val();
	//window.location.href='<?php echo base_url();?>fund/search/'+from+'/'+to+'/'+uname+'/'+trnxs+'/';
} 
</script>
