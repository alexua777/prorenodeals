<section class="sec">
<?php echo $breadcrumb;?>
<script src="js/mycustom.js"></script>
<div class="container">
<div class="row">
<div class="dashboard_wrap">
<h2 class="dash_headline"><?php echo $project_name;?> <span>Workroom</span></h2>
<a href="<?php echo VPATH;?>time_tracker/tracker.zip" target="_blank" class="download_tracker">Download tracker for Windows</a>
<a href="<?php echo VPATH;?>time_tracker/timetracker-mac.zip" target="_blank" class="download_tracker">Download tracker for Mac</a>
<?php
$f = $this->session->userdata('user');
$client_name=$this->auto_model->getFeild('fname','user','user_id',$project_details[0]['user_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$project_details[0]['user_id']);
$freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$f[0]->user_id)." ".$this->auto_model->getFeild('lname','user','user_id',$f[0]->user_id);
$seconds=0;
$totalaecond=0;
$total_cost=0;
$totalhours=0;
$t=0;
foreach($tracker_details as $key=>$val)
{
	
if($val['worker_id']==$f[0]->user_id){
$t++;
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
if($t==1){
$freelancer_name=$this->auto_model->getFeild('fname','user','user_id',$val['worker_id'])." ".$this->auto_model->getFeild('lname','user','user_id',$val['worker_id']);

}
}
}
$rate=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$f[0]->user_id));

?>
<div class="clearfix"></div>
<!--dash_content-->
<div class="dash_content5">
<div class="row">
    <article class="col-md-7 col-xs-12">
        <ul>
            <li><label>Client Name: </label> <span><?php echo ucwords($client_name);?></span></li>
            <li><label>Total Working Hour:</label> <span><?php echo +$totalhours;?> Hours <?php echo $totalaecond;?> Minutes</span></li>
            <li><label>Freelancer Name:</label> <span><?php echo ucwords($freelancer_name);?></span></li>
            <li><label>Hourly Rate:</label> <span><?php echo CURRENCY.$rate;?></span></li>
            <li><label>Total Cost:</label> <span><?php echo CURRENCY;?><?php echo $total_cost;?></span></li>
            <li><label>Money Relesed:</label> <span>$00.00</span></li>
        </ul>
        <div class="dash_search">
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
            <input type="submit" class="btn btn-success btn-block submit_btn" value="Go" /></li>
        </div>
    </article>
</div>
</form>
</div>
    </article>
<?PHP $USERID = $f[0]->user_id ?>
<?PHP $pid ?>
<?php $Statuscheck = $this->projectdashboard_model->projectpaused($USERID,$pid); 
//print_r($Statuscheck); die;

?>
    <article class="col-md-5 col-xs-12">
    	<div class="dash_content4 text-center">
        <p>If time tracker software is not feasible for you please click here to send total working hrs to your employer.</p>        
        <div  class="manualbox">
        <?php if($Statuscheck[0]['projectstatus']=='N') {  ?>
            <a href="#" class="btn btn-info manualbott" data-toggle="modal" data-target="#myModal">Request Manual Hour</a>
        <?php }  else {
        ?>	
            <a href="#"  class="btn btn-info manualbott" style="pointer-events:none;" data-toggle="modal" data-target="#myModal">Request Manual Hour</a>
            <span style="text-align:center; color:red; margin-top:10px; ">Client has paused the contract</span>
         <?php }?>
    	</div>    
    	</div>
	</article>
	
	<article class="col-md-5 col-xs-12">
	<div class="dash_content4 text-center">  
       <a href="#" id="viewActivity-btn" class="btn btn-primary">View activity</a>
	   <div class="activity-box" id="activity-box" style="display:none;">
			<?php 
			$f_id = $f[0]->user_id;
			$activity =$this->db->select('a.*,au.approved')->from('project_activity a')->join('project_activity_user au', 'au.activity_id=a.id', 'INNER')->where("a.project_id = '$pid' AND au.assigned_to = '$f_id'")->get()->result_array();
			?>
			<ul class="list-group" style="overflow: visible;">
				<?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
				<li class="list-group-item" style="width:100%;text-align:left; padding:10px;"><?php echo $v['task']; ?>
				<a href="#" class="pull-right" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : 'N/A'; ?>"><i class="fa fa-lg fa-info-circle"></i></a>
				<?php if($v['approved'] == 'N'){ ?>
					<a href="<?php echo base_url('projecthourly/approve_activity/'.$v['id']).'?project='.$pid;?>" class="pull-right" style="padding: 0px 8px;">Approve</a>
					<a href="<?php echo base_url('projecthourly/deny_activity/'.$v['id']).'?project='.$pid;?>" class="pull-right" style="padding: 0px 8px;">Deny</a>
				<?php }else{ ?>
					<span class="pull-right" style="padding: 0px 8px;">Approved</span>
				<?php } ?>
				</li>
				<?php } }else{ ?>
					No activity 
				<?php  } ?>	
			</ul>			
	   </div>
    </div>
	</article>
</div><!--dash_content-->

<div class="divide30"></div>

<div class="table-responsive dash_table">
<table class="table table-dashboard">
    <thead>
        <tr>
            <th>Date</th>
            <th>Duration</th>
            <th>Hourly Rate</th>
            <th>Cost</th>
            <th>Payment Status</th>
        </tr>
    </thead>
	<tbody>
	<?php
    if(count($tracker_details)>0)
    {
		
    foreach($tracker_details as $keys=>$vals)
    {
    if($vals['worker_id']==$f[0]->user_id){
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
        if($vals['payment_status']=='N')
        {
            $payment="Payment Pending";	
        }
        elseif($vals['payment_status']=='P')
        {
            $payment='<img src="'.ASSETS.'img/arrow_icon.png" alt="" />';	
        }
        elseif($vals['payment_status']=='D')
        {
            $payment="Payment Disputed";	
        }
        
    ?>
    <tr>
        <td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td>
        <td><?php echo ($days_new*24)+$hours_new;?> hours <?php echo $minutes_new;?> minutes</td> 
        <td><?php echo CURRENCY;?><?php echo $client_amt;?></td> 
        <td><?php echo CURRENCY; ?><?php echo $total_cost_new;?></td> 
		<td><?php echo $payment;?></td>
	</tr>
	<?php
    }
    }
    }
    else
    {
    ?>
    <tr><td colspan="5"><p class="no_found">No data found!!</td></tr>
    <?php	
    }
    ?>
    </tbody>
</table>

</div><!--dash_table-->
<div class="pagination">
<?php echo $pagination;?>
</div>
<div style="clear:both;"></div>

<!--For Manual Time-->
<h4>For Manual Time</h4>
<div class="table-responsive dash_table">
<table class="table table-dashboard">
    <thead>
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Duration</th>
            <th>Hourly Rate</th>
            <th>Cost</th>
            <th>Action</th>
            <th>Payment Status</th>
        </tr>
     </thead>
    <tbody>      
		<?php
        if(count($manual_tracker_details)>0)
        {
        foreach($manual_tracker_details as $keys=>$vals)
        {
            //print_r($vals);
			//die();
        if($vals['worker_id']==$f[0]->user_id){	
            $total_cost_new = 0;
            $client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$vals['worker_id']));
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($vals['minute']);
            $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
            if($vals['payment_status']=='N')
            {
                $payment="Payment Pending";	
            }
            elseif($vals['payment_status']=='P')
            {
                $payment='<img src="'.ASSETS.'img/arrow_icon.png" alt="" />';	
            }
            elseif($vals['payment_status']=='D')
            {
                $payment="Payment Disputed";	
            }
            
        ?>
    <tr>
        <td><?php echo date('d F, Y',strtotime($vals['start_time']));?></td>
        <td><?php echo date('d F, Y',strtotime($vals['stop_time']));?></td>
        <td><?php echo floatval($vals['hour']);?> hours <?php echo floatval($vals['minute']); ?> Minute</td>
        <td><?php echo CURRENCY;?><?php echo $client_amt;?></td> 
        <td><?php echo CURRENCY; ?><?php echo round($total_cost_new,2);?></td>
        <td>
        <?php
        if($vals['status']=="Y" || $vals['status']=="N") { echo "NA"; }
        else
        {
        ?> 
        <a href="<?php echo VPATH;?>projecthourly/change_status/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/freelancer">Accept</a> | <a href="<?php echo VPATH;?>projecthourly/delete_request/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/">Decline</a> 
        <?php
        }
        ?>
        | <a href="#" onclick="loadActivity('<?php echo $vals['activity']; ?>', this)" data-comment="<?php echo $vals['comment']; ?>" title="Activity detail"><i class="fa fa-asterisk" aria-hidden="true"></i></a>
        </td>
        <td><?php echo $payment;?></td>
    </tr>
<?php
}
}
}
else
{
?>
<tr><td colspan="7"><p class="no_found">No data found!!</td></tr>
<?php	
}
?>

</tbody>
</table>
</div>


<!--For Manual Time-->

</div><!--dashboard_wrap-->
 
</div>
</div>
</div>
<!--container--> 
</section>

<!-------For Manual Time----------->
<script>
var s = 0;
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="$('#myModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send your work duration</h4>
      </div>
      <div class="modal-body">     
       
       <div id="enquiry_form">
			<form action="<?php echo VPATH?>projecthourly/manual_hour/<?=$pid?>" method="post" class="form-horizontal">            
           
            <div class="form-group">
                <label class="col-sm-4">Start Date:</label>
                <div class="col-sm-8 col-xs-12">
                <input type="text" class="form-control" placeholder="Start date" required name="start_date" id="tracker_from" readonly="readonly" value="<?php echo $this->input->get('start_date');?>"/>
                </div>
            </div>                       
                        
            <div class="form-group">
            	<label class="col-sm-4">End Date:</label>
                <div class="col-sm-8 col-xs-12">
                <input type="text" class="form-control" placeholder="End date" required name="to_date" id="tracker_to" readonly="readonly" value="<?php echo $this->input->get('to_date');?>"/>
                </div>
            </div>              
            
            <div class="form-group">
                <label class="col-sm-4">Total Duration:</label>       
				<div class="col-sm-4 col-xs-12">
                	<input type="text" class="form-control" placeholder="Total hour" required name="duration" value="<?php echo $this->input->get('duration');?>"/>
               </div>
			   <div class="col-sm-4 col-xs-12">
			   <select class="form-control" name="minute">
			   <option>Minutes</option>
			    <?php for($i=5;$i<60;$i++){ 
				if($i%5 == 0){
				?>
				
				 <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php }} ?>
			   </select>
			  
                	<!--<input type="text" class="form-control" placeholder="Total minute" required name="minute" value="<?php // echo $this->input->get('minute');?>"/> -->
               </div>
            </div> 

			<div class="form-group">
			<?php
			$f_id = $f[0]->user_id;
			$activity =$this->db->select('*')->from('project_activity')->where("project_id = '$pid' AND id IN(select activity_id from serv_project_activity_user where assigned_to = '$f_id' AND approved = 'Y')")->get()->result_array();
			
			?>
            <label class="col-sm-4">Choose activity:</label>          
			<div class="col-sm-8 col-xs-12">
					<?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
					<label><input type="checkbox" class="" placeholder="Total hour" name="activity[]" value="<?php echo $v['id'];?>"/> <?php echo $v['task']; ?> </label> <a href="#" class="pull-right" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : 'N/A'; ?>"><i class="fa fa-lg fa-info-circle"></i></a><br/>
					<?php } }else{ ?>
						<a class="btn btn-info btn-sm" onclick="$('#activity-box').show(300); $('#viewActivity-btn').html('Hide Activity'); $('#myModal').modal('hide'); s = 1;">View Activity</a>
					<?php  } ?>										
				</div>
			
            </div> 			
			
			 <div class="form-group">
                 <label class="col-sm-4">Comments:</label>      
                 <div class="col-sm-8 col-xs-12"><textarea name="comment" class="form-control"></textarea></div>
             </div> 
			
            <div class="form-group">           
                <div class="col-sm-8 col-sm-offset-4 col-xs-12">
                    <input type="submit" class="btn btn-site" value="Submit" name="submit" />
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>  
                </div>
            </div>
            </form>
	   </div>                       
      </div>      
    </div>
  </div>
</div>


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
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
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

<script>
$(function() {

		$( "#tracker_from" ).datepicker({

			maxDate: new Date()
		});

	});

	$(function() {

		$( "#tracker_to").datepicker();

	});
</script>


<script>
$(function() {

		$( "#datepicker_from" ).datepicker();

	});

	$(function() {

		$( "#datepicker_to").datepicker();

	});
	
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

<!-------For Manual Time----------->