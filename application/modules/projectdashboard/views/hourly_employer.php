<?php $this->load->view('section-top');?>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
    <div class="tab-content" style="margin:10px 0 0; padding:0; border:none">
      <div role="tabpanel" class="tab-pane active">
        <!-- working area -->
		<table class="table table-dashboard">
    <thead>
        <tr>
            <th><?php echo __('projectdashboard_hourlyemployer_freelancer_name','Freelancer Name'); ?></th>
            <th><?php echo __('projectdashboard_hourlyemployer_date','Date'); ?></th>
            <th style="min-width:100px"><?php echo __('projectdashboard_hourlyemployer_duration','Duration'); ?></th>
            <th><?php echo __('projectdashboard_hourlyemployer_hourly_rate','Hourly Rate'); ?></th>
            <th><?php echo __('projectdashboard_hourlyemployer_cost','Cost'); ?></th> 
            <th><?php echo __('projectdashboard_hourlyemployer_activity','Activity'); ?></th> 
            <th><?php echo __('projectdashboard_hourlyemployer_action','Action'); ?></th> 
            <th><?php echo __('projectdashboard_hourlyemployer_escrow_status','Escrow Status'); ?></th> 
            <th class="text-center" style="width:150px"><?php echo __('projectdashboard_hourlyemployer_payment_status','Payment Status'); ?></th>
        </tr>
    </thead>
	<tbody>

	<?php
    if(count($manual_tracker_details)>0){
	foreach($manual_tracker_details as $keys=>$vals){
        $freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$vals['worker_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$vals['worker_id']);
        
        $total_cost_new = 0;	
        
		$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$vals['worker_id'])));
		$client_amt = $data['total_amt'];
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($vals['minute']);
            $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
		
    ?>
    <tr>
    <td><?php echo $freelancer_name;?></td>
    <td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td> 
    <td><?php echo floatval($vals['hour']);?> hrs <?php echo floatval($vals['minute']); ?> <?php echo __('projectdashboard_hourlyemployer_min','min'); ?>    
    <div style="display:none" id="hour_div_<?=$vals['id']?>">
    <form action="<?php echo VPATH?>projecthourly/manual_hour_decline_employer/<?=$vals['id']?>/<?=$vals['project_id']?>?next=projectdashboard/hourly_employer/<?=$vals['project_id']?>" method="post">
    <input type="text" name="hour" class="form-control input-sm" value="<?php echo floatval($vals['hour']);?>" style="width:60px;display:inline;margin-bottom:5px;" />
	<select name="minute" class="form-control input-sm" style="width:82px;display:inline;margin-bottom:5px;">
	<option><?php echo __('projectdashboard_hourlyemployer_min','min'); ?></option>
	<?php for($i=5;$i<60;$i=$i+5){ ?>
	<option value="<?php echo $i; ?>" <?php if($vals['minute'] == $i){ echo 'selected'; } ?>><?php echo $i.' '.__('projectdashboard_hourlyemployer_min','min'); ?></option>
	<?php } ?>
	</select>
    <br />
    <input type="submit" class="btn btn-xs btn-site" name="submit" value="<?php echo __('projectdashboard_hourlyemployer_set','Set'); ?>" style="width:60px" />
    <input type="button" class="btn btn-xs btn-warning" name="submit" value="<?php echo __('projectdashboard_hourlyemployer_cancel','Cancel'); ?>" onclick="javascript:$('#hour_div_<?=$vals['id']?>').hide();" style="width:82px" />
    </form>
    </div>
    </td> 
	<td align="center"><?php echo CURRENCY;?><?php echo $client_amt;?></td> <td><?php echo CURRENCY;?><?php echo round($total_cost_new,2);?></td> 
	<td><?php foreach($vals['acti'] as $r=>$s){
		if($r<=1){
	?>
		
		<?php echo !empty($s['task'])? (strlen($s['task']) > 15)? substr($s['task'],0,15).'...<br/>': $s['task'].'<br/>' : ''; ?>
		<?php } if($r==2){ ?> 
		<!-- <a href="#" onclick="loadActivity('<?php // echo $vals['activity']; ?>', this)" data-comment="<?php // echo $vals['comment']; ?>" title="View more activities" class="btn btn-success btn-xs">View more</a>&nbsp;|&nbsp; -->
		<?php } } ?>
	<a href="#" onclick="loadActivity('<?php echo $vals['activity']; ?>', this)" data-comment="<?php echo $vals['comment']; ?>" title="<?php echo __('projectdashboard_hourlyemployer_activity_details','Activity details'); ?>" style="position: absolute;  right: 10px; top: 6px;">
    <i class="fa fa-eye"></i></a>
	</td>
	<td>
    <?php
    if($vals['status']=="N")
    {
    ?>
    <a href="javascript:void(0);" data-href="<?php echo VPATH;?>projecthourly/change_status/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/employer?next=projectdashboard/hourly_employer/<?=$vals['project_id']?>" onclick="confirm_modal(this);"><i class="zmdi zmdi-thumb-up active" title="<?php echo __('projectdashboard_hourlyemployer_accept','Accept'); ?>"></i></a>&nbsp; <a href="javascript:void(0)" onclick="javascript:$('#hour_div_<?=$vals['id']?>').show();"><i class="zmdi zmdi-thumb-down deactive" title="<?php echo __('projectdashboard_hourlyemployer_decline','Decline'); ?>"></i></a> &nbsp;
    <?php
    }
    else if($vals['status']=="D") { echo __('projectdashboard_hourlyemployer_waiting_for_freelancer_approval','Waiting for freelancer approval.'); }
    else { echo "NA"; }
    ?>
    	
	|&nbsp;<a href="<?php echo base_url('dashboard/invoice/'.$vals['invoice_id'].'/'.'H');?>" target="_blank"><i class="fa fa-file-pdf-o" style="color:#f00"></i></a>
	|&nbsp;<a href="<?php echo base_url('dashboard/invoice/'.$vals['invoice_id'].'/'.'H');?>" target="_blank" download><i class="fa fa-download" style="color:#f00"></i></a>
    </td>
	<?php if(($vals['status']=="N") && ($vals['status']!="Y"))
    { ?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>

	<?php }?>
    <?php
    if($vals['status']=="Y")
    {
    ?>
     <td class="text-center"><?php if($vals['escrow_status']=='Y'){?><i class="zmdi zmdi-check active" style="font-size:22px"></i> <?php } else { ?><a href="<?php echo VPATH;?>myfinance/releasefund_hourly_manual/<?php echo $vals['id'];?>?next=projectdashboard/hourly_employer/<?=$vals['project_id']?>"><?php echo __('projectdashboard_hourlyemployer_release_escrow','Release Escrow'); ?></a><?php } ?></td>
     
    <td class="text-center">
	
	<?php if($vals['escrow_status']=='Y'){if($vals['payment_status']=='P'){?><i class="zmdi zmdi-check active" style="font-size:22px"></i><?php }elseif($vals['payment_status']=='D'){echo "Payment Disputed";}else{?><a data-href="<?php echo VPATH;?>myfinance/releasepayment_hourly_manual/<?php echo $vals['id'];?>?next=projectdashboard/hourly_employer/<?=$vals['project_id']?>" onclick="confirm_modal(this);" href="javascript:void(0);"><?php echo __('projectdashboard_hourlyemployer_release_payment','Release Payment'); ?></a> 

	<a style="display:none;" href="<?php echo VPATH;?>myfinance/dispute_hourly_manual/<?php echo $vals['id'];?>?next=projectdashboard/hourly_employer/<?=$vals['project_id']?>"><?php echo __('projectdashboard_hourlyemployer_dispute_payment','Dispute Payment'); ?></a><?php }}else{ echo "Escorw is Pending";}?>
	
	</td>
    <?php
    }
    ?> 
     </tr>
    <?php
    }
    }
    else
    {
    ?>
    <tr><td colspan="8"><p class="no_found"><?php echo __('projectdashboard_hourlyemployer_no_data_found','No data found!!!'); ?></td></tr>
    <?php	
    }
    ?>

	</tbody>
</table>
</div>
<div id="infoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#infoModal').modal('hide');">&times;</button>
      </div>
      <div class="modal-body">
	  <p><?php echo __('projectdashboard_hourlyemployer_ara_you_sure_to_accept','Are you sure to accept ?'); ?> </p>
	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#infoModal').modal('hide');"><?php echo __('projectdashboard_hourlyemployer_cancel','Cancel'); ?></button>
		
        <a type="button" class="btn btn-primary" id="accept-btn"><?php echo __('projectdashboard_hourlyemployer_accept','Accept'); ?></a>
      </div>
    </div>

  </div>
</div>
		
        <!-- working area -->
      </div>
    </div>
  </div>
</section>

<div id="activityModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#activityModal').modal('hide');">&times;</button>
        <h4 class="modal-title"><?php echo __('projectdashboard_hourlyemployer_activity','Activity'); ?></h4>
      </div>
      <div class="modal-body">
	  
       <div id="activity_ajax"></div>
	   <b><?php echo __('projectdashboard_hourlyemployer_comment','Comment'); ?> : </b>
	   <div id="activity_cmt"></div>
	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#activityModal').modal('hide');"><?php echo __('projectdashboard_hourlyemployer_close','Close'); ?></button>
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

function confirm_modal(ele){
	var link = $(ele).attr('data-href');
	$('#accept-btn').attr('href', link);
	$('#infoModal').modal('show');
}


 function loadActivity(act, ele){
	var cmt = $(ele).data('comment');
	if(cmt == ''){
		cmt = 'N/A';
	}
	$('#activity_cmt').html(cmt);
	$.get('<?php echo base_url('projecthourly/getactivity?activity=')?>'+act, function(res){
		$('#activity_ajax').html(res);
		
	});
	$('#activityModal').modal('show');
	
 }
  </script>
