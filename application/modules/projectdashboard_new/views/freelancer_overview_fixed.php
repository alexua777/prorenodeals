
<section id="mainpage">
<div class="container-fluid">

<div class="row">
<?php $this->load->view('dashboard/dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
    <div class="row">
    <aside class="col-lg-9 col-12">
    <?php echo $breadcrumb; ?> 
    <!-- Nav tabs -->
    <?php $this->load->view('freelancer_tab'); ?>
    
    <!-- Tab panes -->
    <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="overview">
        
        <div class="row">
        <article class="col-sm-6 col-12">
            <?php
            $bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_detail['project_id']);
            $bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));						
			
			$admin_fee=$this->auto_model->getFeild('admin_fee','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));						
			$bidder_amt +=  $admin_fee;			
            $paid_amount=$this->autoload_model->getPaidAmount($project_detail['project_id'],$bidder_id);
            if(!$paid_amount){
                $paid_amount = 0;
            }
            $commission_amount = $this->projectdashboard_model->getCommission($project_detail['project_id'], $bidder_id);
			if(!$commission_amount){
				$commission_amount = 0;
			}
			
            $pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_detail['project_id'], $bidder_id);
            $dispute_amount = $this->projectdashboard_model->getApproveDispute($project_detail['project_id']);
          
			$remaining_bal = (number_format($bidder_amt, 2) - number_format($paid_amount, 2) - number_format($pending_dispute_amount, 2) - number_format($dispute_amount, 2) - number_format($commission_amount, 2));
			
			$remaining_bal = number_format($remaining_bal, 2);
			
			$bid_row = get_row(array(
				'select' => '*',
				'from' => 'bids',
				'where' => array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id)
			));
			
            ?>            
            
            <ul class="list-group mb-3">
            	<li class="list-group-item list-header"><h4>Summary</h4></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Project Amount : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bidder_amt); ?></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">HST (<?php echo HST_RATE; ?>%) : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bid_row['tax_amount']); ?></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center"><b>Total Amount :</b> <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bid_row['total_amt']); ?></span></li>
                
				
                <?php /*if($pending_dispute_amount > 0){ ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">Pending Dispute Amount : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($pending_dispute_amount);?></span></li>
                <?php } ?>
                
                <?php if($dispute_amount > 0){ ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">Dispute Amount : <span class="badge badge-warning badge-pill"><?php echo ' - '.CURRENCY. format_money($dispute_amount); ?></span></li>
                <?php } ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">Commission : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($commission_amount); ?></span></li>						
                <li class="list-group-item d-flex justify-content-between align-items-center">Remaining Amount : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($remaining_bal); ?></span></li>	
				*/ ?>	
            </ul>
            
        </article>
        
        <article class="col-sm-6 col-12">
        	<div class="card about-card">
                <div class="card-header"><h4>About Job</h4></div>
                <div class="card-body">
                    <p><?php echo !empty($project_detail['description']) ? $project_detail['description'] : '' ; ?></p>
                </div>
            </div>
        </article>
        
        </div>
        <h4>Employer </h4>
        <?php  
        $user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $project_detail['user_id'])));
        $employer_fname = getField('fname', 'user', 'user_id', $project_detail['user_id']);
        $employer_lname = getField('lname', 'user', 'user_id', $project_detail['user_id']);
        $employer_name = $employer_fname.' '.$employer_lname;
            
        $employer_public_feedback = $employer_given_public_feedback = $employer_given_private_feedback = array();
            
        /* if(!empty($feedback['private'][$v['freelancer_id']])){
            $freelancer_private_feedback = $feedback['private'][$v['freelancer_id']];
        } */
        
        $is_employer_feedback_done = false;
        
        if(!empty($feedback['public'][$user_id.'|'.$project_detail['user_id']])){
            $employer_public_feedback = $feedback['public'][$user_id.'|'.$project_detail['user_id']];
        }
        
        if(!empty($feedback['public'][$project_detail['user_id'].'|'.$user_id])){
            $employer_given_public_feedback =$feedback['public'][$project_detail['user_id'].'|'.$user_id];
            $is_employer_feedback_done=true;
        }
        
        if(!empty($feedback['private'][$project_detail['user_id'].'|'.$user_id])){
            $employer_given_private_feedback =$feedback['private'][$project_detail['user_id'].'|'.$user_id];
            $is_employer_feedback_done=true;
        }
            
        ?>
        
        
            <div class="table-responsive">
            
            <table class="table">
             <thead>
                <tr>
                    <th>Employer </th><th>Requests</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                     <td>
                    <?php if($is_employer_feedback_done && check_user_review($user_id, $project_detail['project_id'])){ ?>
                        <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($employer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($employer_given_private_feedback); ?>' data-name="<?php echo $employer_name; ?>">View Employer Feedback</a>
                    <?php }else{ echo ' - ';} ?>
                   </td>
                    <td class="text-right">
                        <?php if($project_detail['status'] == 'P'){ ?>
                            <a href="<?php echo base_url('message/browse/'.$project_detail['project_id'].'/'.$project_detail['user_id']);?>" class="btn btn-site btn-sm">Message</a>&nbsp;
                            <?php } ?>
                            
                            <?php if($project_detail['status'] == 'C'){ ?>
                            
                            <!--<a href="<?php echo base_url('dashboard/rating/'.$project_detail['project_id'].'/'.$project_detail['user_id']); ?>"><i class="zmdi zmdi-star zmdi-18x" title="Rating"></i></a>-->
                            
                            <?php if(!empty($employer_public_feedback)){ /*?>
                            <a href="javascript:void(0);" title="Update Feedback" onclick="updateFeedback(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>" data-public-feedback='<?php echo json_encode($employer_public_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                            <?php*/ }else{ ?>
                                <a href="javascript:void(0);" title="Give Feedback" onclick="newFeedbackOpen(this)" data-employer-id="<?php echo $project_detail['user_id']; ?>" data-name="<?php echo $employer_name; ?>"><i class="zmdi zmdi-star zmdi-18x"></i></a>
                                
                                <?php } ?>
                                
                            <?php } ?>
                    </td>
                </tr>
            </tbody>
            </table>
            </div>
    	
    </div>
    
    
    </div>
    </aside>    
    
    <?php $this->load->view('right-section'); ?>

    </div>
</aside>
</div>
</div>
</section>

<?php $this->load->view('freelancer_rating_review'); ?>
<style>
@media (min-width:576px){
.about-card {
	min-height: 12.6rem;
}
}
.about-card p:first-child {
	margin-bottom:0
}
</style>