
<?php echo $breadcrumb;?>
<script>
function paushjob(id){
$('.paush').html('Wait...');

   $.ajax({
	type: "POST",
	url: "<?=VPATH?>projecthourly/paushjob/",
	data: {'id':id},
	dataType: "json",
	cache: false,
	success: function(msg) {
	
	 if (msg['status'] == 'OK') {
		$('.paush').html(msg['msg']);
		}else{
			$('.paush').html(msg['msg']);
		}			
	}
 })
}    	
</script>
<script src="js/mycustom.js"></script>
<section class="breadcrumb-classic">  
  <div class="container">
    <div class="row">
    <aside class="col-sm-6 col-xs-12">
		<h3>Workroom</h3>
    </aside>
    <aside class="col-sm-6 col-xs-12">
        <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li><a href="<?php echo base_url('findtalents');?>">Project</a></li>
      <li class="active">Workroom</li>
  </ol>   
    </aside>            
    </div>
	</div>       
</section>
<div class="clearfix"></div>
<section class="sec whiteBg">
<div class="container">

<div class="row">
<aside class="col-sm-6 col-xs-12">
<h4 class="title-sm"><?php echo $project_name;?></h4> 

<?php
$seconds=0;
$totalaecond=0;
$total_cost=0;
$totalhours=0;
foreach($tracker_details as $key=>$val)
{
	$seconds= strtotime($val['stop_time']) - strtotime($val['start_time']);	
if($seconds<1){
$seconds=0;
}
$days    = floor($seconds / 86400);
$hours   = floor(($seconds - ($days * 86400)) / 3600);
$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$val['worker_id']));
$total_cost=$total_cost+$client_amt*(($days*24)+$hours+$minutes/60);
$totalaecond=$totalaecond+$minutes;
if($totalaecond==60){
$totalhours=$totalhours+1;
$totalaecond=0;
}
}
?>
<div class="dash_content">
<div class="row-5">
    <article class="col-sm-4 col-xs-12">
    <div class="widget-workroom">
        <h4>Total Working Hour <em>:</em></h4> 
        <span><?php echo $totalhours;?> Hours <?php echo $totalaecond;?> Minutes</span>
	</div>
    </article>
    <article class="col-sm-4 col-xs-12">
    <div class="widget-workroom">
        <h4>Total Cost <em>:</em></h4>
        <span><?php echo CURRENCY;?><?php echo $total_cost;?></span>
    </div>
    </article>
    <article class="col-sm-4 col-xs-12">
    <div class="widget-workroom">
        <h4>Money Relesed <em>:</em></h4>
        <span><?php echo CURRENCY;?>00.00</span>
    </div>
    </article>
</div>
</div>
<div class="dash_search clearafter">
<form action="" method="get">
<div class="row-5">
<article class="col-sm-5 col-xs-12">
<div class="start_time">
	<input type="text" class="form-control" placeholder="Start date" name="fromdate" id="datepicker_from" readonly="readonly" value="<?php echo $this->input->get('fromdate');?>"/>
</div>
</article>
<article class="col-sm-5 col-xs-12">
<div class="end_time">
	<input type="text" class="form-control" placeholder="End date" name="todate" id="datepicker_to" readonly="readonly" value="<?php echo $this->input->get('todate');?>"/>
</div>
</article>
<article class="col-sm-2 col-xs-12">
<div class="search_submit">
	<input type="submit" class="btn btn-success btn-block submit_btn" value="Go" />
</div>
</article>
</div>
</form>
</div>
</aside>

<aside class="col-sm-6 col-xs-12">
<h4 class="title-sm">&nbsp;</h4>
<div class="dash_graph">
<img src="<?php echo ASSETS;?>img/dash_graph.jpg" alt="" class="img-responsive" />
</div>
<?php if($showpaush==1){?>
<button onclick="paushjob('<?php echo $pid;?>')" class="btn btn-warning pull-right paush" style='background: #eea236'><?php if($currentstats=='PS'){?>Project Pause<? }elseif($currentstats=='P'){?>Project Active<? }?></button>
<?php }?>


<a href="<?php echo VPATH;?>dashboard/closeproject/<?php echo $pid;?>/" class="btn btn-info download_tracker">Close this job</a>

<a href="<?php echo base_url('jobdetails/activity');?>/<?php echo $pid;?>" class="btn btn-success">View Activity</a>

<a href="<?php echo base_url('jobdetails/activity');?>/<?php echo $pid;?>?action=add" class="btn btn-primary">Add Activity</a>

</aside>
</div>

<div class="dash_table">
<table class="table table-dashboard">
<thead>

<tr><th>Freelancer Name</span> <th>Date</span> <th>Duration</span> <th>Hourly Rate</span> <th>Cost</span> <th>Action</span> <th>Escrow Status</span> <th>Payment Status</span></tr>
</thead>
<tbody>
<?php

if(count($tracker_details)>0)
{
foreach($tracker_details as $keys=>$vals)
{
	$freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$vals['worker_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$vals['worker_id']);
	$seconds_new = 0;
	$days_new    = 0;
	$hours_new   = 0;
	$minutes_new = 0;
	$seconds_new = 0;
	$total_cost_new = 0;
	
	$seconds_new = strtotime($vals['stop_time']) - strtotime($vals['start_time']);
	if($seconds_new<1){
	$seconds_new=0;
	}
	$days_new    = floor($seconds_new / 86400);
	$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
	$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
	$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
	
	$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$vals['worker_id']));
	
	$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
?>
<tr><th><?php echo $freelancer_name;?></th> <th><?php echo date('d F, Y',strtotime($vals['start_time']));?></th> <th><?php echo ($days_new*24)+$hours_new;?> hours <?php echo $minutes_new;?> minutes</th> <th><?php echo CURRENCY;?><?php echo $client_amt;?></th> <th><?php echo CURRENCY;?><?php echo $total_cost_new;?></th> <th><a href="<?php echo VPATH;?>projecthourly/screenshot/<?php echo $vals['id']?>/" class="view_screenshot">View screenshot</a></th> <th><?php if($vals['escrow_status']=='Y'){?><img src="<?php echo ASSETS;?>img/arrow_icon.png" alt="" /> <?php }else{?><a href="<?php echo VPATH;?>myfinance/releasefund_hourly/<?php echo $vals['id'];?>">Release Escrow</a><?php }?></th> <th class="cell_2 last_cell"><?php if($vals['escrow_status']=='Y'){if($vals['payment_status']=='P'){?><img src="<?php echo ASSETS;?>img/arrow_icon.png" alt="" /><?php }elseif($vals['payment_status']=='D'){echo "Payment Disputed";}else{?><a href="<?php echo VPATH;?>myfinance/releasepayment_hourly/<?php echo $vals['id'];?>">Release Payment</a>  <a href="<?php echo VPATH;?>myfinance/dispute_hourly/<?php echo $vals['id'];?>">Dispute Payment</a><?php }}else{ echo "Escorw is Pending";}?></th></tr>
<?php
}
}
else
{
?>
<tr><td colspan="8"><p class="no_found">No data found!!</td></tr>
<?php	
}
?>
</tbody>
</table>
</div>

<div class="pagination">
<?php echo $pagination;?>
</div>


<!--For Manual Time-->
<div class="clearfix"></div>
<h2 class="dash_headline2">For Manual Time</h2>
<div class="table-responsive dash_table">
<table class="table table-dashboard">
<thead>
<tr>
<th>Freelancer Name</th>
<th>Date</th>
<th>Duration</th>
<th>Hourly Rate</th>
<th>Cost</th> 
<th>Action</th> 
<th>Escrow Status</th> 
<th>Payment Status</th>
</tr>
</thead>
<tbody>

<?php
if(count($manual_tracker_details)>0)
{
//get_print($manual_tracker_details);
foreach($manual_tracker_details as $keys=>$vals)
{
	$freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$vals['worker_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$vals['worker_id']);
	
	$total_cost_new = 0;	
	$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$vals['worker_id']));
	$total_cost_new=$client_amt*floatval($vals['hour']);
?>
<tr>
<td><?php echo $freelancer_name;?></td> <td>
<?php echo date('d F, Y',strtotime($vals['start_time']));?></td> 
<td><?php echo $vals['hour'];?> hours 

<div style="display:none" id="hour_div_<?=$vals['id']?>">
<form action="<?php echo VPATH?>projecthourly/manual_hour_decline_employer/<?=$vals['id']?>/<?=$vals['project_id']?>" method="post">
<input type="text" name="hour" class="menualinput2" value="<?php echo $vals['hour'];?>"  /> 
<input type="submit" class="manualbott2" name="submit" value="Set"  />
<input type="button" class="manualbott2" name="submit" value="Cancel" onclick="javascript:$('#hour_div_<?=$vals['id']?>').hide();" />
</form>
</div>
</td> <td><?php echo CURRENCY;?><?php echo $client_amt;?></td> <td><?php echo CURRENCY;?><?php echo $total_cost_new;?></td> <td>
<?php
if($vals['status']=="N")
{
?>
<a href="<?php echo VPATH;?>projecthourly/change_status/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/employer">Accept</a> | <a href="javascript:void(0)" onclick="javascript:$('#hour_div_<?=$vals['id']?>').show();">Decline</a>
<?php
}
else if($vals['status']=="D") { echo "Waiting freelancer approval."; }
else { echo "NA"; }
?>
|<a href="#" onclick="loadActivity('<?php echo $vals['activity']; ?>', this)" data-comment="<?php echo $vals['comment']; ?>">Comments</a>
</td>
<?php
if($vals['status']=="Y")
{
?>
 <td><?php if($vals['escrow_status']=='Y'){?><img src="<?php echo ASSETS;?>img/arrow_icon.png" alt="" /> <?php } else { ?><a href="<?php echo VPATH;?>myfinance/releasefund_hourly_manual/<?php echo $vals['id'];?>">Release Escrow</a><?php } ?></td>
 
<td><?php if($vals['escrow_status']=='Y'){if($vals['payment_status']=='P'){?><img src="<?php echo ASSETS;?>img/arrow_icon.png" alt="" /><?php }elseif($vals['payment_status']=='D'){echo "Payment Disputed";}else{?><a href="<?php echo VPATH;?>myfinance/releasepayment_hourly_manual/<?php echo $vals['id'];?>">Release Payment</a>  <a href="<?php echo VPATH;?>myfinance/dispute_hourly_manual/<?php echo $vals['id'];?>">Dispute Payment</a><?php }}else{ echo "Escorw is Pending";}?></td>
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
<tr><td colspan="8"><p class="no_found">No data found!!</td></tr>
<?php	
}
?>

</tbody>
</table>
</div>

</div>
</section>



<div id="activityModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="$('#activityModal').modal('hide');">&times;</button>
        <h4 class="modal-title">Activity</h4>
      </div>
      <div class="modal-body">
	  
       <div id="activity_ajax"></div>
	   <b>Comment : </b>
	   <div id="activity_cmt"></div>
	   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#activityModal').modal('hide');">Close</button>
      </div>
    </div>

  </div>
</div>


<script>
  $( function() {
    $( "#datepicker_from" ).datepicker();
 } );
 
   $( function() {
    $( "#datepicker_to" ).datepicker();
 } );
 
 
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