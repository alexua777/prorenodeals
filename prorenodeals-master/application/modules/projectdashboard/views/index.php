<?php $this->load->view('section-top');?>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
      <div class="row">
      <div class="col-sm-6 col-xs-12">
        <h4><?php echo __('projectdashboard_people_hire_for_project','People hire for project'); ?>:</h4>
        <div class="table-responsive">
        <table class="table">
        <tbody>
			<?php 
				$bidders = $project_details['bidder_id'];
				$all_bidders = explode(',', $bidders);
				if(count($all_bidders) > 0){ foreach($all_bidders as $k => $v){ 
				$user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $v)));
				?>
        	<tr>
            	<td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                <td class="text-right">
					<?php if($project_details['status'] == 'P'){ ?>
						<a href="<?php echo base_url('message/browse/'.$project_details['project_id'].'/'.$v);?>"><i class="zmdi zmdi-email zmdi-hc-2x" title="<?php echo __('projectdashboard_message','Message'); ?>"></i></a>&nbsp;
						<a href="javascript:void(0)" onclick="actionPerform('GB','<?php echo $v;?>')"><i class="zmdi zmdi-money zmdi-hc-2x" title="<?php echo __('projectdashboard_bonus','Bonus'); ?>"></i></a>&nbsp;
						<?php if($project_details['project_type'] == 'H'){
						$bid_row = get_row(array('select' => 'pausedcontract,status', 'from' => 'bids', 'where' => array('bidder_id' => $v, 'project_id' => $project_details['project_id'])));
						$is_pause = $bid_row['pausedcontract'];
						?>
						
						<?php if($is_pause == 'Y'){ ?>
						<a href="javascript:void(0);" onclick="recontractFreelancer('<?php echo $project_details['project_id'].'@@'.$v;?>');"><i class="zmdi zmdi-play-circle zmdi-hc-2x" title="<?php echo __('projectdashboard_start','Start'); ?>"></i></a>&nbsp;
						<?php }else{ ?>
						<a href="javascript:void(0);" onclick="pausecontractFreelancer('<?php echo $project_details['project_id'].'@@'.$v;?>');"><i class="zmdi zmdi-pause-circle zmdi-hc-2x" title="<?php echo __('projectdashboard_pause','Pause'); ?>"></i></a>&nbsp;
						<?php } ?>
						
						
						<?php } ?>
					<?php } ?>
						<?php if($project_details['status'] == 'C'){ ?>
						<a href="<?php echo base_url('dashboard/rating/'.$project_details['project_id'].'/'.$v); ?>"><i class="zmdi zmdi-star zmdi-hc-2x" title="<?php echo __('projectdashboard_rating','Rating'); ?>"></i></a>
						<?php } ?>
                </td>
            </tr>
			<?php } } ?>
        </tbody>
        </table>
        </div>
        <h4><?php echo __('projectdashboard_summary','Summary'); ?>:</h4>
		<?php 
		if($project_details['project_type'] == 'H'){
			$req_rows = $this->db->where(array("project_id"=>$project_details['project_id']))->get('project_tracker_manual')->result_array();
			
			$paid = $approved = $pending = $requested = array();
			if(count($req_rows) > 0){
				foreach($req_rows as $k => $vals){
					$total_cost_new = 0;
					$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_details['project_id'],"bidder_id"=>$vals['worker_id']));
					
					$minute_cost_min = ($client_amt/60);
					$total_min_cost = $minute_cost_min *floatval($vals['minute']);
					$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
					
					if($vals['status'] == 'Y' AND $vals['payment_status'] == 'P'){
						$paid[] = $total_cost_new;
						$approved[] = $total_cost_new;
					}else if($vals['status'] == 'Y'){
						$approved[] = $total_cost_new;
					}else if($vals['status'] == 'N'){
						$pending[] = $total_cost_new;
					}
					$requested[] = $total_cost_new;
				}
			}
			?>
			
				<ul class="list-group proamount" style="margin-bottom:20px">
					<li class="list-group-item"><?php echo __('projectdashboard_requested_amount','Requested Amount'); ?>: <span class="badge"><?php echo CURRENCY. round(array_sum($requested), 2); ?></span></li>
					<li class="list-group-item"><?php echo __('projectdashboard_approved_amount','Approved Amount'); ?>: <span class="badge"><?php echo CURRENCY. round(array_sum($approved), 2); ?></span></li>
					<li class="list-group-item"><?php echo __('projectdashboard_paid_amount','Paid Amount'); ?>: <span class="badge"><?php echo CURRENCY. round(array_sum($paid), 2); ?></span></li>
					<li class="list-group-item"><?php echo __('projectdashboard_pending_amount','Pending Amount'); ?>: <span class="badge"><?php echo CURRENCY. round(array_sum($pending), 2); ?></span></li>
				</ul>			
			
			
		<?php	
		}else{
		$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_details['project_id']);
		$bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_details['project_id'],'bidder_id'=>$bidder_id));
		$paid_amount=$this->autoload_model->getPaidAmount($project_details['project_id'],$bidder_id);
		if(!$paid_amount){
			$paid_amount=0;
		}
		
		$commission_amount = $this->projectdashboard_model->getCommission($project_details['project_id'], $bidder_id);
		$pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_details['project_id'], $bidder_id);
		$dispute_amount = $this->projectdashboard_model->getApproveDispute($project_details['project_id']);
		$remaining_bal = ($bidder_amt - $paid_amount - $pending_dispute_amount - $dispute_amount - $commission_amount);
		
		// include commission in total paid
		$paid_amount += $commission_amount;
		?>	
			<ul class="list-group proamount" style="margin-bottom:20px">
				<li class="list-group-item"><?php echo __('projectdashboard_project_amount','Project Amount'); ?> : <span class="badge"><?php echo CURRENCY. $bidder_amt; ?></span></li>
				<li class="list-group-item"><?php echo __('projectdashboard_paid_amount','Paid Amount'); ?> : <span class="badge"><?php echo CURRENCY. $paid_amount; ?></span></li>
				
				<?php if($pending_dispute_amount > 0){ ?>
				<li class="list-group-item"><?php echo __('projectdashboard_pending_dispute_amount','Pending Dispute Amount'); ?> : <span class="badge"><?php echo CURRENCY. $pending_dispute_amount;?></li>
				<?php } ?>
				
				<?php if($dispute_amount > 0){ ?>
				<li class="list-group-item"><?php echo __('projectdashboard_dispute_amount','Dispute Amount'); ?> : <span class="badge"><?php echo ' + '.CURRENCY. $dispute_amount; ?></li>
				<?php } ?>
				
				<li class="list-group-item"><?php echo __('projectdashboard_remaining_amount','Remaining Amount'); ?> : <span class="badge"><?php echo CURRENCY. ($remaining_bal); ?></span>
				</li>
				
			</ul>			
			
			
		<?php	
		}
		?>
	  </div>
      
		<?php if($project_details['project_type'] == 'H'){ ?>
        <div class="col-sm-6 col-xs-12">
        <h4><?php echo __('projectdashboard_project_activity','Project Activity'); ?>: <a href="#myModal" class="btn btn-site pull-right btn-sm" data-toggle="modal" data-target="#myModal"><?php echo __('projectdashboard_create_activity','Create Activity'); ?></a></h4>
		
		<div class="panel-group" id="accordion" style="margin-top: 20px;">	
			<?php if(count($activity_list) > 0){foreach($activity_list as $k => $v){  ?>
			 <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1;?>">
					<?php echo $v['task'];?><span class="badge pull-right"><?php echo count($v['assigned_user']); ?></span>
					<span class="pull-right" style="font-size:18px;padding: 0 10px;margin-top:-3px"><i class="fa fa-eye" title="<?php echo __('projectdashboard_view_details','View detail'); ?>"></i></span></a>
				  </h4>
				</div>
				<div id="collapse<?php echo $k+1;?>" class="panel-collapse collapse" style="padding:20px;">
					<p><b><?php echo __('projectdashboard_description','Description'); ?> : </b><?php echo !empty($v['desc']) ? $v['desc'] : 'N/A';?></p>							
					<p><b><?php echo __('projectdashboard_assigned_to','Assigned To'); ?></b></p>							
					<?php if(count($v['assigned_user']) > 0){foreach($v['assigned_user'] as $u){ ?>
						<p><?php echo $u['fname'].' '.$u['lname']; ?>
						<?php if($u['approved'] == 'Y'){
							echo '<span class="pull-right">'.__('projectdashboard_approved','Approved').'</span>';
						}else{
							echo '<span class="pull-right">'.__('projectdashboard_not_approved_yet','Not Approved yet').'</span>';
						}								
						?>
						</p>
					<?php } }else{ ?>
					 <p><?php echo __('projectdashboard_not_assigned_to_any_one','Not assigned to anyone'); ?></p>
					<?php } ?>
					
				</div>
			  </div>
			
		<?php } } ?>
		</div>
		</div>
		<?php } ?>
		
        </div>
	  </div>
    </div>
  </div>
</section>





<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo __('projectdashboard_create_activity','Create Activity'); ?></h4>
      </div>
      <div class="modal-body">
       
			<form action="<?php echo base_url('projectdashboard/project_activity/'.$project_details['project_id']);?>" method="post" id="create_activity_form">
				<label><?php echo __('projectdashboard_project','Project'); ?></label>
				<p><b><?php echo $project_details['title']; ?></b></p>
				<div class="form-group">
					<label><?php echo __('projectdashboard_title','Title'); ?></label>
					<input type="text" class="form-control" name="task" value="">
					<?php echo form_error('task', '<div class="error">', '</div>');?>
				 </div>
				 
				 <div class="form-group">
					<label><?php echo __('projectdashboard_description','Descriptions'); ?></label>
					<textarea class="form-control" name="desc"></textarea>
					<?php echo form_error('desc', '<div class="error">', '</div>');?>
				 </div>
				
						<div class="form-group">
				<label style="display:block"><?php echo __('projectdashboard_assigned_to','Assigned To'); ?></label>
				<?php
					if(count($all_bidders) > 0){
						foreach($all_bidders as $k => $v){
					$user_detail = $this->db->select('fname,lname,user_id')->where(array('user_id' => $v))->get('user')->row_array();
					?>
					<div class="checkbox checkbox-inline">
					  <label><input type="checkbox" name="freelancer[]" value="<?php echo $user_detail['user_id']; ?>"><?php echo $user_detail["fname"].' '.$user_detail["lname"]; ?></label>
					</div>
					<?php 	} } ?>
					<?php echo form_error('freelancer[]', '<div class="error">', '</div>');?>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-site"><?php echo __('projectdashboard_create','Create'); ?></button>
				 </div>
				 
			</form>
				
      </div>
      
    </div>

  </div>
</div>



<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_give_bonus','Give Bonus'); ?></h4>
      </div>
      <div class="modal-body">
      <div id="bonusmessage" class="login_form"></div>
      <form action="" name="givebonusform" class="form-horizontal givebonusform" method="POST">
       <input type="hidden" name="bonus_freelancer_id" id="bonus_freelancer_id" value="0"/>
       
       <div class="form-group">
           <div class="col-xs-12">
               <label><?php echo __('projectdashboard_amount','Amount'); ?>: </label>
               <input type="text" class="form-control" size="30" value="0" name="bonus_amount" id="bonus_amount"> 
           </div>
       </div>
       <div class="form-group">
           <div class="col-xs-12">
           <label><?php echo __('projectdashboard_reason','Reason'); ?>: </label>
           <textarea type="text" class="form-control"  name="bonus_reason" id="bonus_reason"> </textarea>
           </div>
       </div>
       <button type="button" onclick="sendbonus()" id="sbmt" class="btn btn-site btn-sm"><?php echo __('projectdashboard_send','Send'); ?></button>
       </form>
	   <div class="clearfix"></div>
      </div>      
    </div>
  </div>
</div>


<style>
.tab-content {
	margin-top:10px;
	padding: 0;
	border:none;
}
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

<script>
    function actionPerform(v,i){ 
	//alert(v);alert(i);
        if(v=="E"){ 
            window.location.href=$("#eidta_"+i).attr('href');
        }
        else if(v=="C"){ 
          if(confirm('Are you sure to close this job?'))
		  {
		  	window.location.href=$("#closea_"+i).attr('href');
		  }
        } 
        else if(v=="IB"){ 
          window.location.href=$("#iba_"+i).attr('href');
        }
		
		else if(v=="PC"){ 
          window.location.href=$("#pc_"+i).attr('href');
        }
		
		else if(v=="SF"){ 
          window.location.href=$("#spa_"+i).attr('href');
        }
		else if(v=="M"){ 
          window.location.href=$("#m_"+i).attr('href');
        }
		
			else if(v=="VP"){ 
          window.location.href=$("#vp_"+i).attr('href');
        }
		
        else if(v=="SP"){ 
          window.location.href=$("#spa_"+i).attr('href');
        }        
        else if(v=="IBG"){ 
         $('#priject_id').val(i);        
        }
        else if(v=="EX"){ 
           showextend(i);
        }        
        else if(v=="GB"){ 
           givebonus(i);
        }
    }
    
 function givebonus(user_id)
{
	$("#givebonus div.modal-footer button#sbmt").css('display','inline-block');
	$("#bonus_freelancer_id").val(user_id);
	$(".givebonusform").css('display','block');
	$("#givebonus").modal();
	
}
function sendbonus(){
	$("#bonusmessage").html('Wait...');
	var requestbonis=$(".givebonusform").serialize();
	
	$.ajax({
		data:$(".givebonusform").serialize(),
		type:"POST",
		dataType: "json",
		url:"<?php echo base_url('findtalents/givebonus')?>",
		success:function(response){
			
				if(response['status']=='OK'){
					
					$("#bonusmessage").html('<div style="color:green;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');
					$(".givebonusform").css('display','none');
					$("#givebonus div.modal-footer button#sbmt").css('display','none');
					$(".givebonusform")[0].reset();	
					
				}else{
					
					$("#bonusmessage").html('<div style="color:red;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');	
					
				}
		}
	});
}  

function pausecontractFreelancer(data){

	var res = data.split("@@");
		var project_id =	res[0];
		var  userid		 =   res[1];
	
	 var dataString = 'projectid='+project_id+'&bidder_id='+userid;

		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/pausecontractFreelancer",
			 success:function(return_data) {
				alert("<?php echo __('projectdashboard_contract_paused','Contract Paused'); ?>");
				window.location.reload();
				
			 }
		});
	
	return false;
}


function recontractFreelancer(data){
	
	var res = data.split("@@");
		var project_id =	res[0];
		var  userid		 =   res[1];
	
	 var dataString = 'projectid='+project_id+'&bidder_id='+userid;
	
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/recontractFreelancer",
			 success:function(return_data){
				alert("<?php echo __('projectdashboard_contract_started','Contract Started'); ?>");
				window.location.reload();
			 }
		});
	
	return false;
}


</script>
