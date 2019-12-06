<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<?php

$bidders = $project_detail['bidder_id'];

$all_bidders = explode(',', $bidders);

?>
<style>
.feedback {
	background-color:#fff;
	border:1px solid #e1e1e1;
	padding: 15px
}
/* Rating Star Widgets Style */

.rating-stars ul {
	list-style-type:none;
	padding:0;
	-moz-user-select:none;
	-webkit-user-select:none;
}
.rating-stars ul > li {
	display:inline-block
}
/* Idle State of the stars */

.rating-stars ul > li.star > i.fa {
	font-size:1.2em; /* Change the size of the stars */
	color:#ccc; /* Color on idle state */
}
/* Hover state of the stars */

.rating-stars ul > li.star.hover > i.fa {
	color:#FFCC36;
}
/* Selected state of the stars */

.rating-stars ul > li.star.selected > i.fa {
	color:#FF912C;
}
.add-fund-bx {
	min-height: 188px;
	border: 1px dashed #ddd;
	position: relative;
}
.add-fund-btn-bx {
	text-align: center;
	padding-top: 32px;
}
.full-size {
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0px;
	top: 0px;
	z-index: 5;
	box-shadow: 0px 2px 6px 1px #c5bebe;
	background: #fff;
}
.cross-btn {
	position: absolute;
	right: 5px;
	top: 6px;
	font-size: 21px;
	z-index: 10;
	background: #000000b0;
	line-height: 30px;
	color: white;
	border-radius: 50%;
	display: inline-block;
	width: 28px;
	cursor: pointer;
	height: 28px;
	text-align: center;
}
.add-fund-title {
	padding: 10px;
	font-size: 16px;
}
.info-error, .info-success {
	padding: 4px 11px;
	border: 2px solid red;
	background-color: #f7baba;
	font-weight: bold;
	font-size: 11px;
	margin-bottom: 10px;
}
.info-success {
	border: 2px solid #1ab91a;
	background-color: #cceacd;
}
input.invalid, textarea.invalid, select.invalid {
	border: 1px solid red;
}
.table-rating {
}
.table-rating td {
	padding : 7px 16px 8px 0px;
}
</style>

<section id="mainpage">

<div class="container-fluid">
  <div class="row">
	<?php $this->load->view('dashboard/dashboard-left'); ?>
    <aside class="col-lg-10 col-md-9 col-12">
    
      <div class="row">
        <div class="col-lg-9 col-12"> 
          <?php echo $breadcrumb; ?>
          <!-- Nav tabs -->
          
          <?php $this->load->view('employer_tab'); ?>
          
          <!-- Tab panes -->
          
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="overview">
              <?php if(count($request) > 0){?>
              <h4>Freelancer request</h4>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <?php foreach($request as $k => $v){ 

			$fname = getField('fname', 'user', 'user_id', $v['freelancer_id']);

			

			?>
                    <tr>
                      <td><?php echo $fname; ?> wants to start this project on <i><?php echo date('d M, Y', strtotime($v['start_date']));?></i></td>
                      <td><a href="javascript:void(0)" onclick="readComment(this)" data-msg="<?php echo $v['comment']; ?>"><i class="zmdi zmdi-comment-text zmdi-18x"></i></a></td>
                      <td><a href="javascript:void(0)" onclick="confirmRequest('<?php echo $v['request_id']; ?>', 'A')">Accept</a> | <a href="javascript:void(0)" class="red-text" onclick="confirmRequest('<?php echo $v['request_id']; ?>', 'R')">Deny</a></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <hr />
              <?php }  ?>
              <?php if(count($project_schedule) > 0){ ?>
              <?php if($project_detail['status'] == 'PS'){ ?>
              <div class="alert alert-warning">
                <p>Project is paused for now.</p>
              </div>
              <?php } ?>
              <?php if($project_detail['status'] == 'C'){ ?>
              <div class="alert alert-warning">
                <p>Project is marked as completed.</p>
              </div>
              <?php } ?>
              <?php if($project_detail['status'] == 'S'){ ?>
              <div class="alert alert-warning">
                <p>Project has been stopped because you have not enough balance in your project deposit. Please add fund to your project deposit</p>
              </div>
              <?php } ?>
              <h4>Summary</h4>
              <div class="row">
                <div class="col-sm-6">
                  <?php

				$total_deposit = get_project_deposit($project_id);

				$total_release = get_project_release_fund($project_id);

				$total_pending = get_project_pending_fund($project_id);

				$remaining_bal = $total_deposit - $total_release - $total_pending;

			?>
                  <ul class="list-group">
                    <li class="list-group-item">Total Deposited Amount <span class="badge pull-right"><?php echo CURRENCY. format_money($total_deposit); ?></span></li>
                    <li class="list-group-item">Total Fund Release <span class="badge pull-right"><?php echo CURRENCY. format_money($total_release); ?></span></li>
                    <li class="list-group-item">Total Fund Pending <span class="badge pull-right"><?php echo CURRENCY. format_money($total_pending); ?></span></li>
                    <li class="list-group-item"><b>Remaining Balance </b><span class="badge pull-right"><?php echo CURRENCY. format_money($remaining_bal); ?></span></li>
                  </ul>
                </div>
                <div class="col-sm-6">
                  <?php if($project_detail['status'] != 'C'){ ?>
                  <div class="add-fund-bx table">
                    <div class="add-fund-btn-bx">
                      <p>Mimimum deposit : <b><i><?php echo CURRENCY. format_money($min_deposit); ?></i></b></p>
                      <p><b>Deposit Fund</b></p>
                      <button class="btn btn-site hide" onclick="$('.add-fund-form-bx').fadeIn();">Add Project Fund</button>
                      <button class="btn btn-site" onclick="addProjectFundDirect('<?php echo $min_deposit; ?>',this)">Add Project Fund</button>
                    </div>
                    <div class="add-fund-form-bx full-size" style="display:none;"> <span class="cross-btn" onclick="$('.add-fund-form-bx').fadeOut();">&times;</span>
                      <div class="add-fund-title">Add Project Fund</div>
                      <div id="balanceError" style="padding: 10px;"></div>
                      <form style="padding: 10px; display:none;" onsubmit="addProjectFund(this, event)" action="<?php echo base_url('projectdashboard_new/add_project_fund')?>">
                        <?php

						$user_wallet_id = get_user_wallet($user_id);

						$wallet_bal  = get_wallet_balance($user_wallet_id);

						$weekly_min_deposit = $this->projectdashboard_model->getWeeklyMinDeposit($project_id);

						if($weekly_min_deposit > $remaining_bal){

							$amount_to_add = number_format(($weekly_min_deposit - $remaining_bal), 2);

						}else{

							$amount_to_add = 0;

						}

						?>
                        <p>Current Account Balance : <span class="pull-right"><b><?php echo CURRENCY. format_money($wallet_bal);?></b></span></p>
                        <div class="input-group">
                          <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
                          <input type="text" name="amount" class="form-control" placeholder="Enter Amount ($)" value="<?php echo $amount_to_add; ?>" readonly>
                          <span class="input-group-addon" style="padding: 0px; border: none;">
                          <button class="btn btn-success">Add Fund</button>
                          </span> </div>
                      </form>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <h4>Freelancer List</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Freelancer</th>
                      <th>Hourly rate</th>
                      <th>Project start date</th>
                      <th>Approx hours</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($project_schedule as $k => $v){ 

			$fname = getField('fname', 'user', 'user_id', $v['freelancer_id']);

			$lname = getField('lname', 'user', 'user_id', $v['freelancer_id']);

			$f_logo = getField('logo', 'user', 'user_id', $v['freelancer_id']);

			$pf_user_image = '';



		if($f_logo!=''){

			$pf_user_image = base_url('assets/uploaded/'.$f_logo) ;

		if(file_exists('assets/uploaded/cropped_'.$f_logo)){

			$pf_user_image = base_url('assets/uploaded/cropped_'.$f_logo) ;

		}

		}else{

			$pf_user_image = base_url('assets/images/user.png'); 

		}



			$name = $fname.' '.$lname;

			

			$freelancer_private_feedback =$freelancer_public_feedback = array();

			

			$freelancer_given_public_feedback = $freelancer_given_private_feedback = array();

			

			$is_freelancer_feedback_done = false;

			

			if(!empty($feedback['private'][$user_id.'|'.$v['freelancer_id']])){

				$freelancer_private_feedback = $feedback['private'][$user_id.'|'.$v['freelancer_id']];

			}

			

			if(!empty($feedback['public'][$user_id.'|'.$v['freelancer_id']])){

				$freelancer_public_feedback = $feedback['public'][$user_id.'|'.$v['freelancer_id']];

			}

			

			if(!empty($feedback['public'][$v['freelancer_id'].'|'.$user_id])){

				$freelancer_given_public_feedback =$feedback['public'][$v['freelancer_id'].'|'.$user_id];

				$is_freelancer_feedback_done=true;

			}

			

			if(!empty($feedback['private'][$v['freelancer_id'].'|'.$user_id])){

				$freelancer_given_private_feedback =$feedback['private'][$v['freelancer_id'].'|'.$user_id];

				$is_freelancer_feedback_done=true;

			}

		

			

			$status = '<span class="orange-text">Pending</span>';

			

			if($v['is_project_start'] == 1){

				$status = '<span class="green-text">Active</span>';

			}

			

			if($v['is_project_paused'] == 1){

				$status = '<span class="orange-text">Paused</span>';

			}

			

			if($v['is_contract_end'] == 1){

				$status = '<span class="red-text">Ended</span>';

			}

			$bid_row = get_row(array('select' => '*', 'from' => 'bids', 'where' => array('project_id' => $project_id, 'bidder_id' => $v['freelancer_id'])));

			$h_rate = !empty($bid_row['total_amt']) ? $bid_row['total_amt'] : 0 ;

			$approx_hrs = !empty($bid_row['available_hr']) ? $bid_row['available_hr'] : 0 ;

			$approx_hrs .= ' hrs';

			?>
                    <tr>
                      <td><a href="<?php echo base_url('clientdetails/showdetails/'.$v['freelancer_id']); ?>"><img src="<?php echo $pf_user_image; ?>" height="60" width="60" class="img-circle"/>&nbsp; <?php echo $name; ?></a></td>
                      <td><?php echo CURRENCY. format_money($h_rate);?></td>
                      <td><?php echo date('d M, Y', strtotime($v['project_start_date']));?></td>
                      <td><?php echo $approx_hrs;?></td>
                      <td><?php echo $status; ?></td>
                      <td><?php if(($project_detail['status'] == 'P') && ($v['is_contract_end'] == 0)){ ?>
                        <a title="Give bonus" href="javascript:void(0)" onclick="giveBonus('<?php echo $project_id?>', '<?php echo $v['freelancer_id'];?>');"><i class="fas fa-euro-sign fa-18x"></i></a> &nbsp; <a href="javascript:void(0)" title="End Contract" onclick="endContractOpen(this);" data-freelancer-id="<?php echo $v['freelancer_id']; ?>" data-name="<?php echo $name; ?>"><i class="zmdi zmdi-close-circle zmdi-18x"></i></a> &nbsp;
                        <?php if($v['manual_request_enable'] == 1){ ?>
                        <a href="javascript:void(0)" title="Disable Manual Request" onclick="freelancer_action('<?php echo $v['schedule_id']?>', 'manual_request_enable', 0);"><i class="zmdi zmdi-thumb-down zmdi-18x"></i></a> &nbsp;
                        <?php }else{ ?>
                        <a href="javascript:void(0)" title="Enable Manual Request" onclick="freelancer_action('<?php echo $v['schedule_id']?>', 'manual_request_enable', 1);"><i class="zmdi zmdi-thumb-up zmdi-18x"></i></a> &nbsp;
                        <?php } ?>
                        <?php if($v['is_project_paused'] == 1){ ?>
                        <a title="Start" href="javascript:void(0)" onclick="pauseAction('<?php echo $v['schedule_id']?>', 0)"><i class="zmdi zmdi-play-circle zmdi-18x"></i></a>
                        <?php }else{ ?>
                        <a  title="Pause" href="javascript:void(0)" onclick="pauseAction('<?php echo $v['schedule_id']?>', 1)"><i class="zmdi zmdi-pause-circle zmdi-18x"></i></a>
                        <?php } ?>
                        &nbsp; <a title="Message" href="<?php echo base_url('message/browse/'.$project_id.'/'.$v['freelancer_id']); ?>"><i class="zmdi zmdi-email-open zmdi-18x"></i></a>
                        <?php }else if($v['is_contract_end'] == 1){ ?>
                        <?php if(!empty($freelancer_public_feedback)){ ?>
                        <a href="javascript:void(0);" data-freelancer-id="<?php echo $v['freelancer_id']; ?>" data-name="<?php echo $name; ?>" onclick="updateFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_public_feedback);?>' data-private-feedback='<?php echo json_encode($freelancer_private_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                        <?php } ?>
                        <?php if($is_freelancer_feedback_done){ ?>
                        | <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($freelancer_private_public_feedback); ?>' data-name="<?php echo $name; ?>">View Freelancer Feedback</a>
                        <?php } ?>
                        <?php }else{ echo '-' ; } ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <h4>Project Activity:
                <?php if($project_detail['status'] == 'P'){ ?>
                <a href="javascript:void(0)" class="btn btn-site pull-right btn-sm" data-toggle="modal" data-target="#createActivityModal">Create Activity</a>
                <?php } ?>
              </h4>
              <div class="panel-group" id="accordion" style="margin-top: 20px;">
                <?php if(count($activity_list) > 0){foreach($activity_list as $k => $v){  ?>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1;?>"> <?php echo $v['task'];?><span class="badge pull-right"><?php echo count($v['assigned_user']); ?></span> <span class="pull-right" style="font-size:18px;padding: 0 10px;margin-top:-3px"><i class="fa fa-eye" title="<?php echo __('projectdashboard_view_details','View detail'); ?>"></i></span></a> </h4>
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
              <?php }else{  ?>
              <div class="alert alert-warning">
                <p>No schedules yet .</p>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        
        <?php $this->load->view('right-section');?>
      </div>
    </aside>
  </div>
</div>
</section>

<!-- modals -->

<div id="msgModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
		<h5 class="modal-title">Comment</h5>
		<button type="button" class="close" data-dismiss="modal" onclick="$('#msgModal').modal('hide');">&times;</button>        
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#msgModal').modal('hide');">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="createActivityModal" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo __('projectdashboard_create_activity','Create Activity'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="$('#createActivityModal').modal('hide');">&times;</button>
        
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('projectdashboard/project_activity/'.$project_detail['project_id'].'?return=projectdashboard_new/employer/overview/'.$project_detail['project_id']);?>" method="post" id="create_activity_form" onsubmit="return checkCreateActivityForm();">
          <label><?php echo __('projectdashboard_project','Project'); ?></label>
          <p><b><?php echo $project_detail['title']; ?></b></p>
          <div class="form-group">
            <label><?php echo __('projectdashboard_title','Title'); ?></label>
            <input type="text" class="form-control" name="task" value="">
            <?php echo form_error('task', '<div class="error">', '</div>');?> </div>
          <div class="form-group">
            <label><?php echo __('projectdashboard_description','Descriptions'); ?></label>
            <textarea class="form-control" name="desc"></textarea>
            <?php echo form_error('desc', '<div class="error">', '</div>');?> </div>
          <div class="form-group">
            <label style="display:block"><?php echo __('projectdashboard_assigned_to','Assigned To'); ?></label>
            <?php

					$allowed_freelancer = $this->db->select('freelancer_id')->where(array('manual_request_enable' => 1, 'is_project_start' => 1, 'is_contract_end' => 0, 'project_id' => $project_id))->get('project_schedule')->result_array();

					$allowed_freelancer_array = array();

					if(count($allowed_freelancer) > 0){

						foreach($allowed_freelancer as $k => $v){

							$allowed_freelancer_array[] = $v['freelancer_id'];

						}

					}

						

					if(count($all_bidders) > 0){

						foreach($all_bidders as $k => $v){

							if(!in_array($v, $allowed_freelancer_array)){

								continue;

							}

					$user_detail = $this->db->select('fname,lname,user_id')->where(array('user_id' => $v))->get('user')->row_array();

					?>
            <div class="checkbox checkbox-inline">
              <input type="checkbox" class="magic-checkbox" name="freelancer[]" id="activity_userN_<?php echo $user_detail['user_id']; ?>" value="<?php echo $user_detail['user_id']; ?>">
              <?php echo $user_detail["fname"].' '.$user_detail["lname"]; ?>
              <label for="activity_userN_<?php echo $user_detail['user_id']; ?>"></label>
            </div>
            <?php 	} } ?>
            <?php echo form_error('freelancer[]', '<div class="error">', '</div>');?>
            <div class="clearfix"></div>
            <div id="freelancerError" class="red-text"></div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-site"><?php echo __('projectdashboard_create','Create'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title"><?php echo __('projectdashboard_give_bonus','Give Bonus'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#givebonus').modal('hide');"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <div id="bonusmessage" class="login_form"></div>
        <form action="" name="givebonusform" class="form-horizontal givebonusform" method="POST">
          <input type="hidden" name="bonus_freelancer_id" id="bonus_freelancer_id" value="0"/>
          <input type="hidden" name="bonus_amount_total" value="0" id="bonus_amount_total"/>
          <div class="form-group">
            <?php 

			$paypal_commission_percent = getField('deposite_by_paypal_commission', 'setting', 'id', 1);

			$paypal_commission_percent = str_replace('.00', '', $paypal_commission_percent);

			?>
            <div class="col-xs-12">
              <label><?php echo __('projectdashboard_amount','Amount'); ?>: </label>
              <div class="input-group"> <span class="input-group-addon"><i class="fas fa-euro-sign"></i></span>
                <input type="text" class="form-control" size="30" value="0" name="bonus_amount" id="bonus_amount" style="max-width:100px" onblur="checkBonus(this.value)">
                <span class="input-group-text"><?php echo $paypal_commission_percent; ?>% + <?php echo CURRENCY; ?>0.35 Paypal Fees = <b><?php echo CURRENCY; ?><span id="bonus_total">0.00</span> Total</b></span> </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label><?php echo __('projectdashboard_reason','Reason'); ?>: </label>
              <textarea type="text" class="form-control" name="bonus_reason" id="bonus_reason"> </textarea>
            </div>
          </div>
          <div class="text-right"> 
            
            <!--<button type="button" onclick="sendbonus()" id="sbmt" class="btn btn-site"><?php echo __('projectdashboard_paynow','Pay Now'); ?></button>-->
            
            <button type="button" onclick="sendbonus_paypal()" id="sbmt" class="btn btn-site"><?php echo __('projectdashboard_paynow','Pay Now'); ?></button>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<!-- End Contract Modal -->

<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form-horizontal" onsubmit="submitEndContractForm(this, event)" action="<?php echo base_url('projectdashboard_new/end_contract')?>" id="endContractForm">
        <input type="hidden" name="freelancer_id" value=""/>
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
        <div class="modal-header">
        <h5 class="modal-title">End contract with VK Bishu </h5>
          <button type="button" class="close" onclick="$('#contractModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
          
        </div>
        <div class="modal-body" style="background-color:#f5f5f5">
          <?php

		$this->config->load('rating_reviews', TRUE);

		$reason = $this->config->item('reason', 'rating_reviews');

		$strength = $this->config->item('strength', 'rating_reviews');

		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');

		?>
          <p>Share your experience</p>
          <div class="feedback">
            <h4>Private Feedback</h4>
            <h6>Never share feedback directly</h6>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Reason for ending contract:</label>
                <select class="form-control" name="private[reason]">
                  <?php if(count($reason) > 0){foreach($reason as $k => $v){ ?>
                  <option value="<?php echo $v['val'];?>"><?php echo $v['text'];?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>How likely you recommended to your friends:</label>
                <h6>Very Unlikely <span class="pull-right">Very Likely</span></h6>
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                  <?php for($i=1; $i<=10; $i++){ 

					if($i <= 3){

						$class = 'danger';

					}else if($i > 3 && $i <= 7){

						$class = 'warning';

					}else{

						$class = 'success';

					}

					?>
                  <label class="btn btn-<?php echo $class; ?>">
                    <input type="radio" name="private[recommend_to_friend]" value="<?php echo $i; ?>">
                    <?php echo $i; ?> </label>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>What do you think are their strengths?</label>
                <br />
                <?php if(count($strength) > 0){foreach($strength as $k => $v){ ?>
                <div class="checkbox checkbox-inline">
                  <input type="checkbox" class="magic-checkbox" id="strength_<?php echo $k+1;?>" name="private[strength][]" value="<?php echo $v['val'];?>"/>
                  <label for="strength_<?php echo $k+1;?>"><?php echo $v['text'];?></label>
                </div>
                <?php } } ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Rate their english proficiency:</label>
                <br />
                <?php if(count($english_proficiency) > 0){foreach($english_proficiency as $k => $v){ ?>
                <div class="radio radio-inline">
                  <input type="radio" class="magic-radio" name="private[english_proficiency]" id="rate_<?php echo $k+1; ?>" value="<?php echo $v['val'];?>" <?php echo $k == 0 ? 'checked="checked"' : '';?>/>
                  <label for="rate_<?php echo $k+1; ?>"><?php echo $v['text'];?></label>
                </div>
                <?php } } ?>
              </div>
            </div>
          </div>
          <div class="feedback">
            <h4>Public Feedback</h4>
            <h6>This feedback share worldwide</h6>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Feedback to Freelancer</label>
                <div class='rating-widget'>
                  <div class='rating-stars'>
                    <table class="table-rating">
                      <tr>
                        <td><div id="rating_skills"></div></td>
                        <td>Skills</td>
                      </tr>
                      <tr>
                        <td><div id="rating_quality"></div></td>
                        <td>Quality of works</td>
                      </tr>
                      <tr>
                        <td><div id="rating_availablity"></div></td>
                        <td>Availability</td>
                      </tr>
                      <tr>
                        <td><div id="rating_communication"></div></td>
                        <td>Communication</td>
                      </tr>
                      <tr>
                        <td><div id="rating_cooperation"></div></td>
                        <td>Cooperation</td>
                      </tr>
                    </table>
                    <input type="hidden" name="public[skills]" value="0" id="rating_skills_input"/>
                    <input type="hidden" name="public[quality_of_work]" value="0" id="rating_quality_input"/>
                    <input type="hidden" name="public[availablity]" value="0" id="rating_availablity_input"/>
                    <input type="hidden" name="public[communication]" value="0" id="rating_communication_input"/>
                    <input type="hidden" name="public[cooperation]" value="0" id="rating_cooperation_input"/>
                    <input type="hidden" name="public[average]" value="0" id="rating_average_input"/>
                  </div>
                </div>
                <h4>Total Score: <span id="avg_rating_view">0</span></h4>
                <div id="review_id_field"></div>
                <div id="feedback_id_field"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Comments:</label>
                <textarea rows="4" class="form-control"  name="public[comment]" placeholder="Type your comment here.."></textarea>
              </div>
            </div>
            <div id="freelancer_payment_endError"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default"  onclick="$('#contractModal').modal('hide');">Cancel</button>
          <button type="submit" class="btn btn-site">End Contract</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="readReviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Feedback By Vk Bishu</h5>
        <button type="button" class="close" onclick="$('#readReviewModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body" style="background-color:#f5f5f5">
        <div class="feedback" id="private_feedback_readonly_box">
          <h4>Private Feedback</h4>
          <div class="row">
            <div class="col-sm-6">Reason for ending contract</div>
            <div class="col-sm-6"><span id="reason_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Recommend to friend</div>
            <div class="col-sm-6"><span id="recommend_to_friend_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">Your strength</div>
            <div class="col-sm-6"><span id="strength_readonly"></span></div>
          </div>
          <div class="row">
            <div class="col-sm-6">English proficiency</div>
            <div class="col-sm-6"><span id="english_proficiency_readonly"></span></div>
          </div>
        </div>
        <div class="feedback" id="public_feedback_readonly_box">
          <h4>Public Feedback</h4>
          <div class="form-group">
            <div class="col-xs-12">
              <div class='rating-widget'>
                <div class='rating-stars'>
                  <table class="table-rating">
                    <tr>
                      <td><div id="rating_behaviour_readonly"></div></td>
                      <td>Behavior</td>
                    </tr>
                    <tr>
                      <td><div id="rating_payment_readonly"></div></td>
                      <td>Payment</td>
                    </tr>
                    <tr>
                      <td><div id="rating_availablity_readonly"></div></td>
                      <td>Availability</td>
                    </tr>
                    <tr>
                      <td><div id="rating_communication_readonly"></div></td>
                      <td>Communication</td>
                    </tr>
                    <tr>
                      <td><div id="rating_cooperation_readonly"></div></td>
                      <td>Cooperation</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="form-group">
            <div class="col-xs-12">
              <div id="comment_readonly"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="$('#readReviewModal').modal('hide');">Close</button>
      </div>
    </div>
  </div>
</div>
<script>

 $(function () {

	 

	$("#rating_skills").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		onSet: function (rating, rateYoInstance) {

			$('#rating_skills_input').val(rating);

			check_total_rating();

		}

	});

	

	$("#rating_quality").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		onSet: function (rating, rateYoInstance) {

			$('#rating_quality_input').val(rating);

			check_total_rating();

		}

	});

	

	$("#rating_availablity").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		onSet: function (rating, rateYoInstance) {

			$('#rating_availablity_input').val(rating);

			check_total_rating();

		}

	});

	

	$("#rating_communication").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		onSet: function (rating, rateYoInstance) {

			$('#rating_communication_input').val(rating);

			check_total_rating();

		}

	});

	

	$("#rating_cooperation").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		onSet: function (rating, rateYoInstance) {

			$('#rating_cooperation_input').val(rating);

			check_total_rating();

		}

	});

	

	/* read only star */

	

	$("#rating_behaviour_readonly").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		readOnly: true

	});

	

	$("#rating_payment_readonly").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		readOnly: true

		

	});

	

	$("#rating_availablity_readonly").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		readOnly: true

		

	});

	

	$("#rating_communication_readonly").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		readOnly: true

		

	});

	

	$("#rating_cooperation_readonly").rateYo({

		normalFill: "#ddd",

		ratedFill: "#FF912C",

		rating    : 0,

		fullStar: true,

		starWidth: "20px",

		spacing: "5px",

		readOnly: true

		

	});

	



});

 </script> 
<script type="text/javascript">



function check_total_rating(){

	var rating_skills_input = parseInt($('#rating_skills_input').val());

	var rating_quality_input = parseInt($('#rating_quality_input').val());

	var rating_availablity_input = parseInt($('#rating_availablity_input').val());

	var rating_communication_input = parseInt($('#rating_communication_input').val());

	var rating_cooperation_input = parseInt($('#rating_cooperation_input').val());

	

	var avg = ((rating_skills_input + rating_quality_input + rating_availablity_input + rating_communication_input + rating_cooperation_input) / 5); 

	$('#rating_average_input').val(avg);

	$('#avg_rating_view').html(avg);

}



function addProjectFund(f , e){

	ajaxSubmit(f , e , function(res){

		if(res.status == 0){

			$(f).find('[name="amount"]').val('');

		}else{

			location.reload();

		}

	});

}



function requestDate(f, e){

	

	ajaxSubmit(f, e , function(res){

		if(res.status == 1){

			location.reload();

		}

	});

}





function ajaxSubmit(f, e , callback){

	

	$('.invalid').removeClass('invalid');

	$('.error-bx').empty();

	e.preventDefault();

	var fdata = $(f).serialize();

	var url = $(f).attr('action');

	$.ajax({

		url : url,

		data: fdata,

		dataType: 'json',

		type: 'POST',

		success: function(res){

			if(res.errors){

				for(var i in res.errors){

					i = i.replace('[]', '');

					$('[name="'+i+'"]').addClass('invalid');

					$('#'+i+'Error').html(res.errors[i]).addClass('error-bx');

				}

				

				var offset = $('.invalid:first').offset();

				

				if(offset){

					$('html, body').animate({

						scrollTop: offset.top - 150

					});

				}

				

				

			}

			

			if(typeof callback == 'function'){

				callback(res);

			}

		}

	});

}



function readComment(ele){

	var msg = $(ele).data('msg');

	if(msg == ''){

		msg = '<i>No comments</i>';

	}

	$('#msgModal').find('.modal-body').html('<p>'+msg+'</p>');

	$('#msgModal').modal('show');

	

}



function confirmRequest(req_id, action){

	if(req_id && action){

		$.ajax({

			url : '<?php echo base_url('projectdashboard_new/confirm_request')?>',

			data: {request_id: req_id, action: action},

			dataType: 'json',

			type: 'POST',

			success: function(res){

				if(res.status == 1){

					location.reload();

				}

			}

		});

	}

	

	

}



function giveBonus(p_id, f_id){

	$('#bonus_freelancer_id').val(f_id);

	$("#bonusmessage").html('');

	$('#givebonus').modal('show');

}



function sendbonus(){

	$("#bonusmessage").html('Wait...');

	var requestbonis=$(".givebonusform").serialize();

	$(".givebonusform button#sbmt").attr('disabled', 'disabled');

	$.ajax({

		data:$(".givebonusform").serialize(),

		type:"POST",

		dataType: "json",

		url:"<?php echo base_url('findtalents/givebonus')?>",

		success:function(response){

			

			if(response['status']=='OK'){

				

				$("#bonusmessage").html('<div class="info-success">'+response['msg']+'</div>');

				/* $(".givebonusform").css('display','none');

				$("#givebonus div.modal-footer button#sbmt").css('display','none'); */

				$(".givebonusform")[0].reset();	

				

			}else{

				

				$("#bonusmessage").html('<div class="info-error">'+response['msg']+'</div>');	

				

			}

			$(".givebonusform button#sbmt").removeAttr('disabled');

		}

	});

}



function pauseAction(sid, val){

	if(sid){

		$.ajax({

			url : '<?php echo base_url('projectdashboard_new/pause_freelancer')?>',

			data: {schedule_id: sid, action: val},

			dataType: 'json',

			type: 'POST',

			success: function(res){

				if(res.status == 1){

					location.reload();

				}

			}

		});

	}

}



function freelancer_action(sid, field, val){

	if(sid && field){

		$.ajax({

			url : '<?php echo base_url('projectdashboard_new/freelancer_action_ajax')?>',

			data: {schedule_id: sid, action: val, col: field},

			dataType: 'json',

			type: 'POST',

			success: function(res){

				if(res.status == 1){

					location.reload();

				}

			}

		});

	}

}



function submitEndContractForm(f , e){

	ajaxSubmit(f , e , function(res){

		if(res.status == 1){

			location.reload();

		}

	});

}



function endContractOpen(ele){

	var f_id = $(ele).data('freelancerId');

	var name = $(ele).data('name');

	

	$('#endContractForm').find('[name="freelancer_id"]').val(f_id);

	$('#endContractForm').find('button[type="submit"]').html('End Contract');

	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/end_contract')?>');

	

	$('#contractModal').find('.modal-title').html('End contract with ' + name);

	$('#contractModal').modal('show');

	

	resetPrivateData();

	resetPublicData();

}





function updateFeedback(ele){

	var f_id = $(ele).data('freelancerId');

	var name = $(ele).data('name');

	

	var private_feedback = $(ele).data('privateFeedback');

	var public_feedback = $(ele).data('publicFeedback');

	

	if(private_feedback){

		setPrivateData(private_feedback);

	}

	

	if(public_feedback){

		setPublicData(public_feedback);

	}

	

	$('#endContractForm').find('[name="freelancer_id"]').val(f_id);

	$('#endContractForm').find('button[type="submit"]').html('Update Feedback');

	$('#endContractForm').attr('action', '<?php echo base_url('projectdashboard_new/upateReview')?>');

	

	$('#contractModal').find('.modal-title').html('Update Feedback of ' + name);

	$('#contractModal').modal('show');

}



function setPrivateData(data){

	var f = $('#endContractForm');

	var strength = data.strength;

	if(strength){

		strength = JSON.parse(strength);

	}else{

		strength = [];

	}

	

	var feedback_id = data.feedback_id;

	

	$('#feedback_id_field').html('<input type="hidden" name="feedback_id" value="'+feedback_id+'"/>');

	

	f.find('[name="private[reason]"]').val(data.reason);

	f.find('[name="private[strength][]"]').val(strength);

	f.find('[name="private[recommend_to_friend]"]').filter('[value="'+data.recommend_to_friend+'"]').attr('checked', 'checked').parent().addClass('active');

	f.find('[name="private[english_proficiency]"]').filter('[value="'+data.english_proficiency+'"]').attr('checked', 'checked');

	

}



function resetPrivateData(){

	var f = $('#endContractForm');

	

	$('#feedback_id_field').html('');

	

	f.find('[name="private[reason]"]').val('');

	f.find('[name="private[strength][]"]').val([]);

	f.find('[name="private[recommend_to_friend]"]').removeAttr('checked').parent().removeClass('active');

	f.find('[name="private[english_proficiency]"]').filter('[value="difficult"]').attr('checked', 'checked');

	

}





function setPublicData(data){

	

	var f = $('#endContractForm');

	var review_id = data.review_id;

	

	$('#review_id_field').html('<input type="hidden" name="review_id" value="'+review_id+'"/>');

	

	f.find('[name="public[skills]"]').val(data.skills);

	f.find('[name="public[quality_of_work]"]').val(data.quality_of_work);

	f.find('[name="public[availablity]"]').val(data.availablity);

	f.find('[name="public[communication]"]').val(data.communication);

	f.find('[name="public[cooperation]"]').val(data.cooperation);

	f.find('[name="public[average]"]').val(data.average);

	f.find('[name="public[comment]"]').val(data.comment);

	

	$("#rating_skills").rateYo("rating", data.skills);

	$("#rating_quality").rateYo("rating", data.quality_of_work);

	$("#rating_availablity").rateYo("rating", data.availablity);

	$("#rating_communication").rateYo("rating", data.communication);

	$("#rating_cooperation").rateYo("rating", data.cooperation);

	

}



function resetPublicData(){

	var f = $('#endContractForm');

	

	$('#review_id_field').html('');

	

	f.find('[name="public[skills]"]').val(0);

	f.find('[name="public[quality_of_work]"]').val(0);

	f.find('[name="public[availablity]"]').val(0);

	f.find('[name="public[communication]"]').val(0);

	f.find('[name="public[cooperation]"]').val(0);

	f.find('[name="public[average]"]').val(0);

	f.find('[name="public[comment]"]').val('');

	

	$("#rating_skills").rateYo("rating", 0);

	$("#rating_quality").rateYo("rating", 0);

	$("#rating_availablity").rateYo("rating", 0);

	$("#rating_communication").rateYo("rating", 0);

	$("#rating_cooperation").rateYo("rating", 0);

}



function ReadFeedback(ele){

	

	<?php

		$this->config->load('rating_reviews', TRUE);

		$reason = $this->config->item('reason', 'rating_reviews');

		$strength = $this->config->item('strength', 'rating_reviews');

		$english_proficiency = $this->config->item('english_proficiency', 'rating_reviews');

		$reason_arr = $strength_arr = $english_proficiency_arr = array();

		if(count($reason) > 0){

			foreach($reason as $k => $v){

				$reason_arr[$v['val']] = $v['text'];

			}

		}

		

		if(count($strength) > 0){

			foreach($strength as $k => $v){

				$strength_arr[$v['val']] = $v['text'];

			}

		}

		

		if(count($english_proficiency) > 0){

			foreach($english_proficiency as $k => $v){

				$english_proficiency_arr[$v['val']] = $v['text'];

			}

		}

	?>

	

	var reason , strength , english_proficiency;

	reason = <?php echo json_encode($reason_arr);?>;

	strength = <?php echo json_encode($strength_arr);?>;

	english_proficiency = <?php echo json_encode($english_proficiency_arr);?>;

	

	var public_feedback = $(ele).data('publicFeedback');

	var private_feedback = $(ele).data('privateFeedback');

	var name = $(ele).data('name');

	

	if(!$.isEmptyObject(private_feedback)){

		

		if(reason[private_feedback.reason]){

			$('#private_feedback_readonly_box').find('#reason_readonly').html(reason[private_feedback.reason]);

		}else{

			$('#private_feedback_readonly_box').find('#reason_readonly').html('');

		}

	

		if(english_proficiency[private_feedback.english_proficiency]){

			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html(english_proficiency[private_feedback.english_proficiency]);

		}else{

			$('#private_feedback_readonly_box').find('#english_proficiency_readonly').html('');

		}

	

	

		if(private_feedback.strength){

		

			var strength_text_arr = [];

			var strength_arr = JSON.parse(private_feedback.strength);

		

			for(var i=0; i<strength_arr.length;i++){

				var st_txt = strength[strength_arr[i]] || '';

				

				strength_text_arr.push(st_txt);

			}

			

			$('#private_feedback_readonly_box').find('#strength_readonly').html(strength_text_arr.join(', '));

			

		

		}else{

			$('#private_feedback_readonly_box').find('#strength_readonly').html('');

		}

		

		$('#private_feedback_readonly_box').find('#recommend_to_friend_readonly').html(private_feedback.recommend_to_friend);

		

	}else{

		$('#private_feedback_readonly_box').hide();

	}

	

	$("#rating_behaviour_readonly").rateYo("rating", public_feedback.behaviour);

	$("#rating_payment_readonly").rateYo("rating", public_feedback.payment);

	$("#rating_availablity_readonly").rateYo("rating", public_feedback.availablity);

	$("#rating_communication_readonly").rateYo("rating", public_feedback.communication);

	$("#rating_cooperation_readonly").rateYo("rating", public_feedback.cooperation);

	$('#comment_readonly').html(public_feedback.comment);

	$('#readReviewModal').find('.modal-title').html('Feedback by ' +  name);

	$('#readReviewModal').modal('show');

	

}





function checkCreateActivityForm(){

	var f_id = $('#create_activity_form');

	var title = f_id.find('[name="task"]').val();

	var freelancers = f_id.find('[name="freelancer[]"]:checked').length;

	var error = false;

	if(title == ''){

		f_id.find('[name="task"]').addClass('invalid');

		error = true;

	}else{

		f_id.find('[name="task"]').removeClass('invalid');

	}

	if(freelancers == 0){

		f_id.find('#freelancerError').html('Please choose freelancers.');

		error = true;

	}else{

		f_id.find('#freelancerError').html('');

	}

	

	if(error){

		return false;

	}

	

	return true;

	

}





function addProjectFundDirect(amt, ele){

	if(ele){

		$(ele).attr('disabled', 'disabled');

	}

	if(amt > 0){

		$.ajax({

			url : '<?php echo base_url('projectdashboard_new/add_project_fund')?>',

			data: {amount: amt, project_id: '<?php echo $project_id;?>'},

			type: 'POST',

			dataType: 'json',

			success: function(res){

				if(res.status == 0){

					$('.add-fund-form-bx').fadeIn();

					$('#balanceError').html(res.errors.balance);

				}else{

					location.reload();

				}

				$(ele).removeAttr('disabled');

			}

		});

	}

}



function checkBonus(bonus){

	if(isNaN(bonus)){

		bonus = 0;

		$('#bonus_amount').val(bonus);

	}

	bonus = parseFloat(bonus);

	if(bonus > 0){

		var paypal_fee_percent = parseFloat('<?php echo getField('deposite_by_paypal_commission', 'setting', 'id', 1); ?>');

		var paypal_commission = ((bonus * paypal_fee_percent)/100);

		paypal_total = bonus + paypal_commission;

		paypal_total += 0.35;

		$('#bonus_total').html(paypal_total.toFixed(2));

		$('#bonus_amount_total').val(paypal_total);

	}else{

		$('#bonus_total').html('0');

		$('#bonus_amount_total').val(0);

	}

	

	

	

}



function sendbonus_paypal(){

	$('#bonus_amount').removeClass('invalid');

	var bonus_amt = $('#bonus_amount_total').val();

	var bonus_reason = $('#bonus_reason').val();

	var bonus_freelancer_id = $('#bonus_freelancer_id').val();

	if(bonus_amt > 0){

		var url = '<?php echo base_url('myfinance/add_fund_paypal')?>?cmd=bonus_to_freelancer&freelancer_id='+bonus_freelancer_id+'&amt='+bonus_amt+'&reason='+bonus_reason+'&project_id=<?php echo $project_id; ?>';

		location.href=url;

	}else{

		$('#bonus_amount').addClass('invalid');

	}

}

</script>