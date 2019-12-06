<section class="sec">
<?php echo $breadcrumb;?>
<script src="js/mycustom.js"></script>
<div class="container">
<div class="row">

<div class="dashboard_wrap clearafter">
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
<!--dash_content-->
<div class="dash_content5">
<ul>
<li><label>Client Name <em>:</em></label> <span><?php echo ucwords($client_name);?></span></li>
<li><label>Total Working Hour <em>:</em></label> <span><?php echo +$totalhours;?> Hours <?php echo $totalaecond;?> Minutes</span></li>
<li><label>Freelancer Name <em>:</em></label> <span><?php echo ucwords($freelancer_name);?></span></li>
<li><label>Hourly Rate <em>:</em></label> <span><?php echo CURRENCY.$rate;?></span></li>
<li><label>Total Cost <em>:</em></label> <span><?php echo CURRENCY;?><?php echo $total_cost;?></span></li>
<li><label>Money Relesed <em>:</em></label> <span>$00.00</span></li>
</ul>

<?PHP $USERID = $f[0]->user_id ?>
<?PHP $pid ?>
<?php $Statuscheck = $this->projectdashboard_model->projectpaused($USERID,$pid); 
//print_r($Statuscheck); die;

?>
<div class="dash_content4">
<p>If time tracker software is not feasible for you please click here to send total working hrs to your employer.</p>
<div style="clear:both;"></div>
<div  class="manualbox">
<?php if($Statuscheck[0]['projectstatus']=='N') {  ?>
	<a href="#"  class="manualbott" data-toggle="modal" data-target="#myModal">Request Manual Hour</a>
<?php }  else {
?>	
	<a href="#"  class="manualbott" style="pointer-events:none;" data-toggle="modal" data-target="#myModal">Request Manual Hour</a>
	<span style="text-align:center; color:red; margin-top:10px; ">Client has paused the contract</span>
 <?php }?>
</div>

</div>

</div><!--dash_content-->

<div class="dash_search clearafter">
<form action="" method="get">
<ul>
<li class="start_time"><input type="text" class="" placeholder="Start date" name="fromdate" id="datepicker_from" readonly="readonly" value="<?php echo $this->input->get('fromdate');?>"/></li>
<li class="end_time"><input type="text" class="" placeholder="End date" name="todate" id="datepicker_to" readonly="readonly" value="<?php echo $this->input->get('todate');?>"/></li>
<li class="search_submit"><input type="submit" class="submit_btn" value="Go" /></li>
</ul>
</form>
</div><!--dash_search-->
<div class="dash_table">
<ul>
<li><span class="tab_head">Date</span> <span class="tab_head">Duration</span> <span class="tab_head">Hourly Rate</span> <span class="tab_head">Cost</span> <span class="tab_head">Payment Status</span></li>
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
<li><span class="tab_cell"><?php echo date('d F, Y',strtotime($vals['start_time']));?></span> <span class="tab_cell"><?php echo ($days_new*24)+$hours_new;?> hours <?php echo $minutes_new;?> minutes</span> <span class="tab_cell"><?php echo CURRENCY;?><?php echo $client_amt;?></span> <span class="tab_cell"><?php echo CURRENCY; ?><?php echo $total_cost_new;?></span> <span class="tab_cell"><?php echo $payment;?></span></li>
<?php
}
}
}
else
{
?>
<li><div class="no_found">No data found!!</div></li>
<?php	
}
?>

</ul>
</div><!--dash_table-->
<div class="pagination">
<?php echo $pagination;?>
</div>
<div style="clear:both;"></div>

<!--For Manual Time-->
<div> <h2 class="dash_headline2">For Manual Time</h2>
<div class="dash_table">
<ul>
<li><span class="tab_head8">Start Date</span> <span class="tab_head8">End Date</span> <span class="tab_head8">Duration</span> <span class="tab_head8">Hourly Rate</span> <span class="tab_head8">Cost</span> <span class="tab_head8">Action</span> <span class="tab_head8">Payment Status</span></li>
<?php
if(count($manual_tracker_details)>0)
{
foreach($manual_tracker_details as $keys=>$vals)
{
	//print_r($vals);
if($vals['worker_id']==$f[0]->user_id){	
	$total_cost_new = 0;
	$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$vals['worker_id']));
	$total_cost_new=$client_amt*floatval($vals['hour']);
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
<li><span class="tab_cell tab_cell8"><?php echo date('d F, Y',strtotime($vals['start_time']));?></span>
<span class="tab_cell tab_cell8"><?php echo date('d F, Y',strtotime($vals['stop_time']));?></span>
 <span class="tab_cell tab_cell8"><?php echo $vals['hour'];?> hours </span> <span class="tab_cell tab_cell8"><?php echo CURRENCY;?><?php echo $client_amt;?></span> <span class="tab_cell tab_cell8"><?php echo CURRENCY; ?><?php echo round($total_cost_new,2);?></span>
 <span class="tab_cell tab_cell8">
 <?php
 if($vals['status']=="Y" || $vals['status']=="N") { echo "NA"; }
 else
 {
 ?> 
 <a href="<?php echo VPATH;?>projecthourly/change_status/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/freelancer">Accept</a> | <a href="<?php echo VPATH;?>projecthourly/delete_request/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/">Decline</a> 
 <?php
 }
 ?>
 <a href="#" onclick="loadActivity('<?php echo $vals['activity']; ?>', this)" data-comment="<?php echo $vals['comment']; ?>">Comments</a>
 </span><span class="tab_cell tab_cell8"><?php echo $payment;?></span></li>
<?php
}
}
}
else
{
?>
<li><div class="no_found">No data found!!</div></li>
<?php	
}
?>

</ul>
</div>
</div>

<!--For Manual Time-->

</div><!--dashboard_wrap-->
 
</div><!--row--> 
</div>
<!--container--> 
</section>

<!-------For Manual Time----------->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send your work duration</h4>
      </div>
      <div class="modal-body">     
       
       <div id="enquiry_form">
			<form action="<?php echo VPATH?>projecthourly/manual_hour/<?=$pid?>" method="post">
            
            <div class="menualinpubox">
           <p> Start Date :</p>
                   <input type="text" class="menualinpu" placeholder="Start date" required name="start_date" id="tracker_from" readonly="readonly" value="<?php echo $this->input->get('start_date');?>"/>
            </div>           
            
            <div class="menualinpubox">
            <p>End Date :</p>
           <input type="text" class="menualinpu" placeholder="End date" required name="to_date" id="tracker_to" readonly="readonly" value="<?php echo $this->input->get('to_date');?>"/>
            </div>            
            
            <div class="menualinpubox">
            <p>Total hour :</p>          
            <input type="text" class="menualinpu" placeholder="Total hour" required name="duration" value="<?php echo $this->input->get('duration');?>"/>
            </div> 

			<div class="menualinpubox">
			<?php
			$f_id = $f[0]->user_id;
			$activity =$this->db->select('*')->from('project_activity')->where("project_id = '$pid' AND id IN(select activity_id from serv_project_activity_user where assigned_to = '$f_id')")->get()->result_array();
			
			?>
            <p>Choose activity :</p>          
				<div class="pull-left" style="width:58%;"> 
					<?php if(count($activity) > 0){foreach($activity as $k => $v){ ?>
					<label><input type="checkbox" class="" placeholder="Total hour" name="activity[]" value="<?php echo $v['id'];?>"/> <?php echo $v['task']; ?> </label> <a href="#" class="pull-right" data-toggle="popover" title="Description" data-placement="left" data-content="<?php echo !empty($v['desc']) ? $v['desc'] : 'N/A'; ?>"><i class="fa fa-lg fa-info-circle"></i></a><br/>
					<?php } }else{ ?>
						No activity 
					<?php  } ?>
					
					
				</div>
			
            </div> 			
			
			 <div class="menualinpubox">
            <p>Comments :</p>          
				<textarea name="comment" class="menualinpu"></textarea>
            </div> 
			
            <div class="menualbottright">           
            <input type="submit" class="submit_btn" value="Submit" name="submit" />
            </div>           
            </form>
	   </div>               
        
      </div>
      <div class="modal-footer" style="border-top:none !important">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
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