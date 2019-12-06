<?php $this->load->view('section-top');?>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
     <div class="tab-content" style="margin:10px 0 0">
      <div role="tabpanel" class="tab-pane active" id="home">
        
		<?php 
		$user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $project_details['user_id'])));
		?>
        <div class="row">
        
        <div class="col-sm-6 col-xs-12">
        <h4>Employer </h4>
        <div class="table-responsive">
        <table class="table">
        <tbody>
        	<tr>
            	<td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                <td class="text-right">
					<?php if($project_details['status'] == 'P'){ ?>
						<a href="<?php echo base_url('message/browse/'.$project_details['project_id'].'/'.$project_details['user_id']);?>"><i class="zmdi zmdi-email zmdi-hc-2x" title="Message"></i></a>&nbsp;
						<?php } ?>
						<?php if($project_details['status'] == 'C'){ ?>
						<a href="<?php echo base_url('dashboard/rating/'.$project_details['project_id'].'/'.$project_details['user_id']); ?>"><i class="zmdi zmdi-star zmdi-hc-2x" title="Rating"></i></a>
						<?php } ?>
                </td>
            </tr>
        </tbody>
        </table>
        </div>
		
		
        <h4>Summary:</h4>
        <?php 
		if($project_details['project_type'] == 'H'){
			 $total_cost_new = 0;
            $client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_details['project_id'],"bidder_id"=>$user_id));
			$req_rows = $this->db->where(array("project_id"=>$project_details['project_id'],"worker_id"=>$user_id))->get('project_tracker_manual')->result_array();
			
			$paid = $approved = $pending = $requested = array();
			if(count($req_rows) > 0){
				foreach($req_rows as $k => $vals){
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
					<li class="list-group-item">Requested Amount: <span class="badge"><?php echo CURRENCY. round(array_sum($requested), 2); ?></span></li>
					<li class="list-group-item">Approved Amount: <span class="badge"><?php echo CURRENCY. round(array_sum($approved), 2); ?></span></li>
					<li class="list-group-item">Paid Amount: <span class="badge"><?php echo CURRENCY. round(array_sum($paid), 2); ?></span></li>
					<li class="list-group-item">Pending Amount: <span class="badge"><?php echo CURRENCY. round(array_sum($pending), 2); ?></span></li>
				</ul>			
			
			
		<?php	
		}else{
		$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_details['project_id']);
		$bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_details['project_id'],'bidder_id'=>$bidder_id));
		$paid_amount=$this->autoload_model->getPaidAmount($project_details['project_id'],$bidder_id);
		if(!$paid_amount){
			$paid_amount = 0;
		}
		$commission_amount = $this->projectdashboard_model->getCommission($project_details['project_id'], $bidder_id);
		$pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_details['project_id'], $bidder_id);
		$dispute_amount = $this->projectdashboard_model->getApproveDispute($project_details['project_id']);
		$remaining_bal = ($bidder_amt - $paid_amount - $pending_dispute_amount - $dispute_amount - $commission_amount);
		?>	
			<ul class="list-group proamount" style="margin-bottom:20px">
				<li class="list-group-item">Project Amount : <span class="badge"><?php echo CURRENCY. $bidder_amt; ?></span></li>
				<li class="list-group-item">Paid Amount : <span class="badge"><?php echo CURRENCY. $paid_amount; ?></span></li>
				
				<?php if($pending_dispute_amount > 0){ ?>
				<li class="list-group-item">Pending Dispute Amount : <span class="badge"><?php echo CURRENCY. $pending_dispute_amount;?></li>
				<?php } ?>
				
				<?php if($dispute_amount > 0){ ?>
				<li class="list-group-item">Dispute Amount : <span class="badge"><?php echo ' - '.CURRENCY. $dispute_amount; ?></li>
				<?php } ?>
				<li class="list-group-item">Commission : <span class="badge"><?php echo CURRENCY. ($commission_amount); ?></span>
				</li>
				
				<li class="list-group-item">Remaining Amount : <span class="badge"><?php echo CURRENCY. ($remaining_bal); ?></span>
				</li>
			</ul>			
			
			
		<?php	
		}
		?>
        </div>
		
		<?php if($project_details['project_type'] == 'H'){ ?>
		
		<div class="col-sm-6 col-xs-12">
        <h4>Project Activity: </h4>
		<?php 
			$f_id = $user_id;
			$activity =$this->db->select('a.*,au.approved')->from('project_activity a')->join('project_activity_user au', 'au.activity_id=a.id', 'INNER')->where("a.project_id = '{$project_details['project_id']}' AND au.assigned_to = '$f_id'")->get()->result_array();
			?>
			<ul class="list-group activityLOG" style="overflow: visible;">
				<?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
				<li class="list-group-item" style="width:100%;text-align:left; padding:10px;"><?php echo $v['task']; ?>
				<a href="javascript:void(0)" class="pull-right" rel="infopop" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : 'N/A'; ?>"><i class="fa fa-lg fa-info-circle"></i></a>
				<?php if($v['approved'] == 'N'){ ?>
					<a href="<?php echo base_url('projectdashboard/approve_activity/'.$v['id']).'?project='.$project_details['project_id'];?>" class="pull-right" style="padding: 0px 8px;">Approve</a>
					<a href="<?php echo base_url('projectdashboard/deny_activity/'.$v['id']).'?project='.$project_details['project_id'];?>" class="pull-right" style="padding: 0px 8px;">Deny</a>
				<?php }else{ ?>
					<span class="pull-right" style="padding: 0px 8px;"><i class="zmdi zmdi-thumb-up"></i></span>
				<?php } ?>
				</li>
				<?php } }else{ ?>
					<div class="whiteBg" style="padding:10px 15px">No activity </div>
				<?php  } ?>
			</ul>
		</div>
		
		
		<?php } ?>
        
		
		
        </div>
	  </div>
    </div>
  </div>
</section>

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
$(document).ready(function(){
    $('.activityLOG').popover({
		 selector: '[rel=infopop]',
         trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	$('#viewActivity-btn').click(function(){
		$('#activity-box').toggle(300);
		if(s == 0){
			$(this).html('Hide Activity');
			s = 1;
		}else{
			$(this).html('Show Activity');
			s = 0;
		}
	});
	
});
</script>