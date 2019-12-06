
	<!-- working area -->
	
	<div class="table-responsive">
	  <table class="table table-hover table-borderless">
		<thead>
		  <tr>
			<th><?php echo __('projectdashboard_milestone_project','Project'); ?></th>
			<th><?php echo __('projectdashboard_milestone_amount','Amount'); ?>(<?php echo CURRENCY;?>)</th>
			<th><?php echo __('projectdashboard_milestone_date','Date'); ?></th>
			
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
		
		$project_id = $row['project_id'];


	?>
		  </tr>
		  <tr>
			<td><?php

		$project_name=$this->auto_model->getFeild("title","projects","project_id",$row['project_id']);

		echo $project_name;

		?></td>
			<td><?php echo CURRENCY;?> <?php echo format_money($row['amount']);?></td>
			<td class="width10per"><?php echo $row['mpdate'] != '0000-00-00' ? date("d M, Y", strtotime($row['mpdate'])) : 'At Project Ends' ;?></td>
			
			
			<?php if($row['client_approval']=='N'){ ?>
			<td><?php echo __('projectdashboard_milestone_not_approved_yet','Not Approved Yet'); ?></td>
			<?php } elseif($row['client_approval']=='D') { ?>
			<td><?php echo __('projectdashboard_milestone_mile_stone_decline','Milestone Declined'); ?></td>
			<?php }else{ if($row['release_payment']=='R'){ ?>
			<td><a href="<?php echo base_url('/invoice/detail/'.$row['invoice_id'].'/'.'F')?>" target="_blank"><?php echo __('projectdashboard_milestone_invoice','Invoice'); ?></a> | <a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/releaseFund/<?php echo $row['id'];?>/A/?next=dashboard/overview', 'release')">
			<?php echo __('projectdashboard_milestone_relese','Release'); ?></a> 
			<?php /*
			| 
			<a href="javascript:void(0);" onclick="milestone_action('<?php echo VPATH;?>myfinance/cancelpayment/<?php echo $row['id'];?>', 'cancel')"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></a>*/?>
			
			  <?php if(($is_escrowed == 1) && $escrow_row['status'] == 'P'){ ?>
			  | <a onclick="milestone_action('<?php echo VPATH;?>myfinance/disputeMilestone/<?php echo $row['id'];?>/<?php echo $row['project_id']; ?>', 'dispute')" href="javascript:void(0);"><?php echo __('projectdashboard_milestone_dispute','Dispute'); ?></a>
			  <?php } ?>
			  </td>
			<?php 

			}else if($row['release_payment'] == 'N'){

				if($row['approval'] == 'P'){

					echo '<td>';

					echo '<a href="javascript:void(0)" onclick="viewRequestData(this, '.$row['id'].')" data-request="'.htmlentities($row['requested_data']).'">View Request</a>';

					echo '</td>';

				}else if($row['approval'] == 'R'){

					echo '<td>'.__('projectdashboard_milestone_request_cancel','Request cancelled').'</td>';

				}else if($row['approval'] == 'A'){

					echo '<td>'.__('projectdashboard_milestone_request_approved','Request approved').'</td>';

				}else {

					echo '<td>'.__('projectdashboard_milestone_not_requested_yet','Not Requested Yet').'</td>';

				}

			} else if($row['release_payment'] == 'D'){
				
				$dispute_id = get_dispute_id($row['id'], $row['project_id']);
				
				echo '<td>'.__('projectdashboard_milestone_dispute','Disputed').' | <a href="'.base_url('projectdashboard/dispute_room/'.$dispute_id).'">'.__('projectdashboard_milestone_view','View').'</a></td>';

			} else if($row['release_payment'] == 'C'){

				echo '<td>'.__('projectdashboard_milestone_cancelled','Cancelled').'</td>';

			}else if($row['release_payment'] == 'Y'){

				echo '<td> <a href="'.base_url('/invoice/detail/'.$row['invoice_id'].'/'.'F').'" target="_blank">'.__('projectdashboard_milestone_invoice','Invoice').'</a> | '.__('projectdashboard_milestone_paid','Paid').' </td>';

			} 



		}  

		?>
		  </tr>
		  <?php

	}





	}else{ ?>
		  <tr>
			<td colspan="6" align="center"><?php echo __('projectdashboard_milestone_no_records_found','No Records Found') ?></td>
		  </tr>
		  <?php } ?>
		</tbody>
	  </table>
	</div>
	
	
<!-- modals -->

<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#infoModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body" id="infoContent"> </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');"><?php echo __('projectdashboard_milestone_close',''); ?></button>
        <button type="button" class="gotoBtn btn btn-primary" id="release-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_accept','Accept'); ?></button>
        <button type="button" class="gotoBtn btn btn-primary" id="cancel-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_cancel','Cancel'); ?></button>
        <button type="button" class="gotoBtn btn btn-primary" id="dispute-action-btn" style="display:none"><?php echo __('projectdashboard_milestone_dispute','Dispute'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->

<div id="requestModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('#requestModal').modal('hide');">&times;</button>
        <h4 class="modal-title">Request</h4>
      </div>
      <div class="modal-body">
        <div id="commentB">
          <h4>Comment: </h4>
          <div id="commentV"></div>
        </div>
        <div id="attachmentB"> </div>
        <input type="hidden" id="choosen_milestone_id" value="0"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-site" onclick="milestoneRequestAction('A', this)">Approve</button>
        <button type="button" class="btn btn-danger" onclick="milestoneRequestAction('R', this)">Reject</button>
      </div>
    </div>
  </div>
</div>

<div id="ajaxModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
    
    </div>
 </div>
</div>

<script>

function milestone_action(link, action){

	if(action == 'release'){

		$('#release-action-btn').attr('data-goto', link);

		$('#release-action-btn').show();

		$('#cancel-action-btn').hide();

		$('#dispute-action-btn').hide();

		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_relese_payment','Are you sure to release payment ?'); ?>');

	}else if(action == 'cancel'){

		$('#cancel-action-btn').attr('data-goto', link);

		$('#cancel-action-btn').show();

		$('#release-action-btn').hide();

		$('#dispute-action-btn').hide();

		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_cancel_payment','Are you sure to cancel payment ?'); ?>');

	}else if(action == 'dispute'){

		$('#dispute-action-btn').attr('data-goto', link);

		$('#dispute-action-btn').show();

		$('#release-action-btn').hide();

		$('#cancel-action-btn').hide();

		$('#infoContent').html('<?php echo __('projectdashboard_milestone_are_you_sure_to_dispute_payment','Are you sure to dispute payment ?'); ?>');

	}

	$('#infoModal').modal('show');

}





function viewRequestData(ele, milestone_id){

	var req_data = $(ele).data('request');

	var comment = req_data.comments;

	var attachments = req_data.attachments;

	

	var attachment_str =  comment_str = '';

	

	$('#choosen_milestone_id').val(milestone_id);

	

	if(comment.length > 0){

		comment_str = comment;

	}else{

		comment_str = '<i>No comments</i>';

	}

	

	console.log(req_data);

	

	if(attachments.length > 0){

		attachment_str += '<h4>Attachments</h4>';

		for(var i in attachments){

			attachments[i] = JSON.parse(attachments[i]);

			var ATTACHMENT_URL = '<?php echo ASSETS;?>'+'attachments/'+attachments[i].filename;

			attachment_str += '<p><a href="'+ATTACHMENT_URL+'" target="_blank">'+attachments[i].org_filename+'</a></p>';

		}

	}

	

	$('#commentV').html(comment_str);

	$('#attachmentB').html(attachment_str);

	

	$('#requestModal').modal('show');

	

}



function milestoneRequestAction(action, ele){

	

	if(typeof ele != 'undefined'){

		$(ele).attr('disabled', 'disabled');

	}

	

	var m_id = $('#choosen_milestone_id').val();

	$.ajax({

		url: '<?php echo base_url('projectdashboard_new/milestone_request_action')?>',

		data: {milestone_id: m_id, action: action},

		type: 'POST',

		dataType: 'json',

		success: function(res){

			if(res.status == 1){

				location.reload();

			}

			

		}

	});

}



$('.gotoBtn').click(function(){

	var href = $(this).attr('data-goto');

	if(href){

		$(this).attr('disabled', 'disabled');

		location.href = href;

	}

});


function confirm_complete(pid){
	$.confirm({
		title: 'Confirm!',
		content: 'Do you want to mark this project as completed ?',
		buttons: {
			confirm: function () {
				mark_project_complete(pid);
			},
			cancel: function () {
				
			}
		}
	});

}

function mark_project_complete(p_id){
	if(p_id){
		$.ajax({
			url : '<?php echo base_url('dashboard/project_action_status');?>',
			data: {project_id: p_id, status: 'C'},
			type: 'POST',
			dataType: 'json',
			success: function(res){
				if(res.status == '1'){
					var option = {
						project_id: p_id,
					}
					if(res.call_bk){
						var cl_bk_fn = res.call_bk;
						option.bidder_id = res.bidder_id;
						window[cl_bk_fn](option);
					}
				}
			}
		});
	}
}

<?php
$login_user = $this->session->userdata('user');
$login_user_id = $login_user[0]->user_id;
?>
function review_employer(options){
	
	
	var url = '<?php echo base_url('review/load_ajax_page'); ?>?page=rating_review&review_to_user='+options.bidder_id+'&job_id='+options.project_id+'&review_from_user=<?php echo $login_user_id; ?>&review_to=freelancer&next=dashboard/overview';
	
	load_ajax_modal(url);
	
}


(function(){
	
	var call_back_fun = '<?php echo get('call_bk'); ?>';
	var p_id = '<?php echo get('p_id'); ?>';
	if(call_back_fun && typeof window[call_back_fun] == 'function'){
		window[call_back_fun](p_id);
	}


})();

</script> 
