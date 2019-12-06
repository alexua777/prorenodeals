<?php $this->load->view('section-top');?>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active">
        <!-- working area -->
        <div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
                    <th><?php echo __('projectdashboard_milestone_no','Milestone No'); ?></th>
                    <th><?php echo __('projectdashboard_milestone_amount','Amount'); ?>(<?php echo CURRENCY;?>)</th> 
					<th><?php echo __('projectdashboard_milestone_date','Date'); ?></th>
                    <th><?php echo __('projectdashboard_milestone_project','Project'); ?></th>
                    <th><?php echo __('projectdashboard_milestone_title','Title'); ?></th>
                    <th><?php echo __('projectdashboard_milestone_payment_request','Payment Request'); ?></th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php 

				if(count($set_milestone_list)>0){  

				foreach($set_milestone_list as $row){
					$is_escrowed = 0;
					$escrow_row = $this->db->where('milestone_id', $row['id'])->get('escrow_new')->row_array();
					if(!empty($escrow_row)){
						$is_escrowed = 1;
					}					

				?>
				</tr>
				<tr>
				<td><?php echo $row['milestone_no']; ?> </td>
				<td><?php echo CURRENCY;?> <?php echo $row['amount'];?></td>
				<td class="width10per"><?php echo date("d M, Y", strtotime($row['mpdate'])) ;?></td>
				<td>

				<?php

				$project_name=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);

				echo $project_name;

				?>

				</td>

				<td><?php echo $row['title'];?></td>
				
				<?php

				if($row['client_approval']=='N')

				{

				?>

				<td><?php echo __('projectdashboard_milestone_not_approved_yet','Not Approved Yet'); ?></td>
				


				<?php	

				}

				elseif($row['client_approval']=='D')

				{

				?>

				<td><?php echo __('projectdashboard_milestone_mile_stone_decline','Milestone Declined'); ?></td>


				<?php	

				}else{ 
				if($row['release_payment']=='R'){
				?>
				<td><a href="<?php echo base_url('/dashboard/invoice/'.$row['invoice_id'].'/'.'F')?>"><?php echo __('projectdashboard_milestone_invoice','Invoice'); ?></a> | <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/releaseFund/<?php echo $row['id'];?>/A/', 'release')"><?php echo __('projectdashboard_milestone_relese','Release'); ?></a> | <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/cancelpayment/<?php echo $row['id'];?>', 'cancel')"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></a>
				
				<?php if(($is_escrowed == 1) && $escrow_row['status'] == 'P'){ ?>
					| <a onclick="milestone_action('<?php echo VPATH;?>myfinance/disputeMilestone/<?php echo $row['id'];?>/<?php echo $row['project_id']; ?>', 'dispute')" href="javascript:void(0);"><?php echo __('projectdashboard_milestone_dispute','Dispute'); ?></a>
				<?php } ?>
				</td>
				<?php 
				}else if($row['release_payment'] == 'N'){
					echo '<td>'.__('projectdashboard_milestone_not_requested_yet','Not Requested Yet').'</td>';
				} else if($row['release_payment'] == 'D'){
					echo '<td>'.__('projectdashboard_milestone_dispute','Disputed').' | <a href="'.base_url('projectdashboard/dispute_room/'.$row['id'].'/'.$row['project_id']).'">'.__('projectdashboard_milestone_view','View').'</a></td>';
				} else if($row['release_payment'] == 'C'){
					echo '<td>'.__('projectdashboard_milestone_cancelled','Cancelled').'</td>';
				}else if($row['release_payment'] == 'Y'){
					echo '<td> <a href="'.base_url('/dashboard/invoice/'.$row['invoice_id'].'/'.'F').'" target="_blank">'.__('projectdashboard_milestone_invoice','Invoice').'</a> | '.__('projectdashboard_milestone_paid','Paid').' </td>';
				} 

				}  
				?>
</tr>
				<?php
				}


				}
				
				else{ 

				?>
				<tr><td colspan="6" align="center"><?php echo __('projectdashboard_milestone_no_records_found','No Records Found') ?></td></tr>

				<?php    

				} 

				?>
				</tbody>
			</table>
        </div>
        <!-- working area -->
      </div>
    </div>
  </div>
</section>


<style>
.zmdi-hc-2x {
    font-size: 20px;
	color: #29b6f6;
}
ul.list-group {
	box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
}
ul.list-group li:last-of-type {
    border-bottom: none;
}
.magic-radio + label:before, .magic-checkbox + label:before {
	width: 18px;
    height: 18px;
}
.magic-radio + label:after {
    width: 8px;
    height: 8px;
}
</style>
<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body" id="infoContent">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');"><?php echo __('projectdashboard_milestone_close',''); ?></button>
        <a type="button" class="btn btn-primary" id="release-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_accept','Accept'); ?></a>
        <a type="button" class="btn btn-primary" id="cancel-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></a>
        <a type="button" class="btn btn-primary" id="dispute-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_dispute','Dispute'); ?></a>
      </div>
    </div>

  </div>
</div>

   
<script>
	
	function milestone_action(link, action){
		if(action == 'release'){
			$('#release-action-btn').attr('href', link);
			$('#release-action-btn').show();
			$('#cancel-action-btn').hide();
			$('#dispute-action-btn').hide();
			$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_relese_payment','Are you sure to release payment ?'); ?>');
		}else if(action == 'cancel'){
			$('#cancel-action-btn').attr('href', link);
			$('#cancel-action-btn').show();
			$('#release-action-btn').hide();
			$('#dispute-action-btn').hide();
			$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_cancel_payment','Are you sure to cancel payment ?'); ?>');
		}else if(action == 'dispute'){
			$('#dispute-action-btn').attr('href', link);
			$('#dispute-action-btn').show();
			$('#release-action-btn').hide();
			$('#cancel-action-btn').hide();
			$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_dispute_payment','Are you sure to dispute payment ?'); ?>');
		}
		$('#infoModal').modal('show');
	}
    function paytoWorker(v){

			  

              var opt=$("#action_select_"+v).val();

              if(opt!="") { 

                    var dataString = 'mid='+v;

                    var url="";

                    

                    if(opt=="R"){ 

                      url="<?php echo VPATH;?>myfinance/releasepayment";

                    }

                    else if(opt=="D"){		 

                      url="<?php echo VPATH;?>myfinance/dispute";

                    }

                    

                    

                    $.ajax({

                       type:"POST",

                       data:dataString,

                       url:url,

                       success:function(return_data){

                           if(return_data){

							 if(opt=="R") 

							 {

								 alert('<?php echo __('projectdashboard_milestone_you_have_successfully_relese_this_milestone','You have successfully release this milestone'); ?>');

                             	window.location.href="<?php echo VPATH;?>myfinance/milestone";

							 }

							 else if(opt=="D"){

								window.location.href="<?php echo VPATH;?>disputes/details/"+return_data; 

							 }

							 

                           }     

                       }

                   });                             

              }

            }

         

         </script>