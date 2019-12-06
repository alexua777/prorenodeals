
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
    
        <div class="row">
        <article class="col-md-6 col-12">
            <?php
            $bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_detail['project_id']);
            $bidder_amt=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));            $admin_fee=$this->auto_model->getFeild('admin_fee','bids','','',array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id));						$bidder_amt +=  $admin_fee;						
            $paid_amount=$this->autoload_model->getPaidAmount($project_detail['project_id'],$bidder_id);
            if(!$paid_amount){
                $paid_amount=0;
            }
           
            $commission_amount = $this->projectdashboard_model->getCommission($project_detail['project_id'], $bidder_id);
			if(!$commission_amount){
				$commission_amount = 0;
			}
			
            $pending_dispute_amount = $this->projectdashboard_model->getPendingDispute($project_detail['project_id'], $bidder_id);
            $dispute_amount = $this->projectdashboard_model->getApproveDispute($project_detail['project_id']);
           
			$remaining_bal = number_format($bidder_amt, 2) - number_format($paid_amount, 2) - number_format($pending_dispute_amount, 2) - number_format($dispute_amount, 2) - number_format($commission_amount, 2);
			
			$remaining_bal = number_format($remaining_bal , 2);
            
            // include commission in total paid
            $paid_amount += $commission_amount;
			
			$bid_row = get_row(array(
				'select' => '*',
				'from' => 'bids',
				'where' => array('project_id'=>$project_detail['project_id'],'bidder_id'=>$bidder_id)
			));
            ?>
            <ul class="list-group proamount" style="margin-bottom:20px">
            	<li class="list-group-item list-header"><h4>Summary</h4></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Project Amount : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bidder_amt); ?></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">HST (<?php echo HST_RATE; ?>%) : <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bid_row['tax_amount']); ?></span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center"><b>Total Amount :</b> <span class="badge badge-warning badge-pill"><?php echo CURRENCY. format_money($bid_row['total_amt']); ?></span></li>
                
                <?php /*if($pending_dispute_amount > 0){ ?>
                <li class="list-group-item"><?php echo __('projectdashboard_pending_dispute_amount','Pending Dispute Amount'); ?> : <span class="badge"><?php echo CURRENCY. format_money($pending_dispute_amount);?></span></li>
                <?php } ?>
                
                <?php if($dispute_amount > 0){ ?>
                <li class="list-group-item"><?php echo __('projectdashboard_dispute_amount','Settled Dispute Amount'); ?> : <span class="badge"><?php echo ' + '.CURRENCY. format_money($dispute_amount); ?></span></li>
                <?php } ?>
                
                <li class="list-group-item"><?php echo __('projectdashboard_remaining_amount','Remaining Amount'); ?> : <span class="badge"><?php echo CURRENCY. format_money($remaining_bal); ?></span></li>
				*/ ?>

            </ul>
            
        </article>
        
        <article class="col-md-6 col-12">
            <div class="card" style="min-height:190px">              	   
				<div class="card-header"><h4>About Job</h4></div>
                <div class="card-body"><p><?php echo !empty($project_detail['description']) ? $project_detail['description'] : '' ; ?></p></div>
            </div>
        </article>
        
        </div>
        
            
		<h4>Contractor</h4>
        <table class="table bg-white">
        <tbody>
            <?php 
                $bidders = $project_detail['bidder_id'];
                $all_bidders = explode(',', $bidders);
                
                if(count($all_bidders) > 0){ foreach($all_bidders as $k => $v){ 
                $user_info = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $v)));
                
                $name = $user_info['fname'].' '.$user_info['lname'];
                
                $freelancer_private_feedback =$freelancer_public_feedback = array();
                
                $freelancer_given_public_feedback = $freelancer_given_private_feedback = array();
                
                $is_freelancer_feedback_done = false;
                
                if(!empty($feedback['private'][$user_id.'|'.$v])){
                    $freelancer_private_feedback = $feedback['private'][$user_id.'|'.$v];
                    
                }
                
                if(!empty($feedback['public'][$user_id.'|'.$v])){
                    $freelancer_public_feedback = $feedback['public'][$user_id.'|'.$v];
                }
                
                if(!empty($feedback['public'][$v.'|'.$user_id])){
                    $freelancer_given_public_feedback =$feedback['public'][$v.'|'.$user_id];
                    $is_freelancer_feedback_done=true;
                }
                
                if(!empty($feedback['private'][$v.'|'.$user_id])){
                    $freelancer_given_private_feedback =$feedback['private'][$v.'|'.$user_id];
                    $is_freelancer_feedback_done=true;
                }
            
                ?>
            <tr>
                <td><?php echo $user_info['fname'].' '.$user_info['lname'];?></td>
                <td class="text-right">
                    <?php if($project_detail['status'] == 'P'){ ?>
                        <a href="<?php echo base_url('message/browse/'.$project_detail['project_id'].'/'.$v);?>"  class="btn btn-site btn-sm">Message</a>&nbsp;
                        <a hidden href="javascript:void(0)" onclick="giveBonus('<?php echo $project_detail['project_id'];?>','<?php echo $v;?>')"><i class="fas fa-euro-sign fa-18x" title="<?php echo __('projectdashboard_bonus','Bonus'); ?>"></i></a>&nbsp;
                        
                    <?php } ?>
                    
                        <?php if($project_detail['status'] == 'C'){ ?>
                       
                       <?php if(!empty($freelancer_public_feedback)){ ?>
                     
                     <!--<a title="Update Review" href="javascript:void(0);" data-freelancer-id="<?php echo $v; ?>" data-name="<?php echo $name; ?>" onclick="updateFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_public_feedback);?>' data-private-feedback='<?php echo json_encode($freelancer_private_feedback);?>'><i class="zmdi zmdi-star zmdi-18x"></i></a>
                     
                     <a href="javascript:void(0)" onclick="update_review(this);" data-project-id="<?php echo $v['project_id']; ?>" data-freelancer-id="<?php echo $feedback_to_freelancer[0]['user_id']; ?>">Leave Feedback</a>-->
                     
                     <?php }else{  ?>
                     
                      <!--<a title="Give Review" href="javascript:void(0);" data-freelancer-id="<?php echo $v; ?>" data-name="<?php echo $name; ?>" onclick="updateFeedback(this)"><i class="zmdi zmdi-star zmdi-18x"></i></a>-->
                      
                      <a href="javascript:void(0)" title="Give Review" onclick="rating_review(this);" data-project-id="<?php echo $project_detail['project_id']; ?>" data-freelancer-id="<?php echo $v; ?>"><i class="zmdi zmdi-star zmdi-18x"></i></a>
                      
                     <?php } ?>
                 
                         <?php if($is_freelancer_feedback_done){ ?>
                        | <a href="javascript:void(0);" onclick="ReadFeedback(this)" data-public-feedback='<?php echo json_encode($freelancer_given_public_feedback); ?>' data-private-feedback='<?php echo json_encode($freelancer_private_public_feedback); ?>' data-name="<?php echo $name; ?>">View Freelancer Feedback</a>
                     <?php } ?>
                 
                        <?php } ?>
                </td>
            </tr>
            <?php } } ?>
        </tbody>        
        </table>
   
           
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

<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#givebonus').modal('hide');"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('projectdashboard_give_bonus','Give Bonus'); ?></h4>
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
               <label><?php echo __('projectdashboard_amount','Amount'); ?>: </label>
               <div class="input-group">
               <span class="input-group-addon"><i class="fas fa-euro-sign"></i></span>
               <input type="text" class="form-control" size="30" value="0" name="bonus_amount" id="bonus_amount" style="max-width:100px" onblur="checkBonus(this.value)"> 
               <span class="input-group-text"><?php echo $paypal_commission_percent; ?>% + <?php echo CURRENCY; ?>0.35 Paypal Fees = <b><?php echo CURRENCY; ?><span id="bonus_total">0.00</span> Total</b></span>
               </div>
       </div>
       <div class="form-group">
           <label><?php echo __('projectdashboard_reason','Reason'); ?>: </label>
           <textarea type="text" class="form-control" name="bonus_reason" id="bonus_reason"> </textarea>
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


<div id="ajaxModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
    
    </div>
 </div>
</div>

<?php $this->load->view('employer_rating_review'); ?>
<script>
function giveBonus(p_id, f_id){
	$('#bonus_freelancer_id').val(f_id);
	$('#givebonus').modal('show');
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
				
				$("#bonusmessage").html('<div class="info-success">'+response['msg']+'</div>');
				$(".givebonusform").css('display','none');
				$("#givebonus div.modal-footer button#sbmt").css('display','none');
				$(".givebonusform")[0].reset();	
				
			}else{
				
				$("#bonusmessage").html('<div class="info-error">'+response['msg']+'</div>');	
				
			}
		}
	});
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

var serialize = function(obj) {
  var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}

function rating_review(ele){
	var p_id = $(ele).data('projectId');
	var freelancer_id = $(ele).data('freelancerId');
	var data = {
		page : 'rating_review',
		review_to_user: freelancer_id,
		review_from_user: '<?php echo $user_id;?>',
		job_id: p_id,
		review_to: 'freelancer',
		next: 'projectroom/employer/overview/<?php echo $project_id; ?>',
	};
	
	var query_str = serialize(data);
	var url = '<?php echo base_url('review/load_ajax_page')?>?'+query_str;
	load_ajax_modal(url);	
	console.log(query_str);
}


</script>