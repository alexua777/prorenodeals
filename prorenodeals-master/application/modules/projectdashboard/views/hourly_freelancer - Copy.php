<?php
$f = $this->session->userdata('user');
?>
<?php $this->load->view('section-top');?>
<script src="<?php echo ASSETS;?>js/mycustom.js"></script>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
     <div class="tab-content" style="margin:10px 0 0; padding:0; border:none">
	<?php $data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$user_id)));
	if($data['pausedcontract']!='Y'){
	?>
	<a class="btn btn-grey manualbott pull-right" data-toggle="modal" data-target="#myModal" style="cursor: pointer;">Request Manual Hour</a>
	<?php } ?>
<div class="clearfix spacer-15"></div>   
<div class="table-responsive">    
	<table class="table">
    <thead>
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Duration</th>
            <th>Hourly Rate</th>
            <th>Cost</th>
            <th>Activity</th>
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
            //$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$pid,"bidder_id"=>$vals['worker_id']));
			$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$vals['worker_id'])));
			$client_amt = $data['total_amt'];
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($vals['minute']);
            $total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
            if($vals['payment_status']=='N')
            {
                $payment="<i class='fa fa-hourglass-half' title='Payment Pending' style='color:#f00'></i>";	
            }
            elseif($vals['payment_status']=='P')
            {
                $payment='<i class="zmdi zmdi-check-circle" style="color:#0c0;font-size: 18px"></i>';	
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
        <td class="text-center"><?php echo CURRENCY;?><?php echo $client_amt;?></td> 
        <td><?php echo CURRENCY; ?><?php echo round($total_cost_new,2);?></td>
        <td>
		<?php foreach($vals['acti'] as $r=>$s){
		if($r<=1){
	?>
		
		<?php echo !empty($s['task'])? (strlen($s['task']) > 15)? substr($s['task'],0,15).'...<br/>': $s['task'].'<br/>' : ''; ?>
		<?php } if($r==2){ ?> 
		<!--<a href="#" onclick="loadActivity('<?php // echo $vals['activity']; ?>', this)" data-comment="<?php // echo $vals['comment']; ?>" title="View more activities" class="btn btn-success btn-xs">View more</a>&nbsp;|&nbsp; -->
		<?php } } ?>
	<a href="#" onclick="loadActivity('<?php echo $vals['activity']; ?>', this)" data-comment="<?php echo $vals['comment']; ?>" title="Activity details"><i class="fa fa-eye"></i></a>
		
		</td>
        <td>
        <?php
        if($vals['status']=="Y" || $vals['status']=="N") { echo "NA"; }
        else
        {
        ?> 
        <a href="<?php echo VPATH;?>projecthourly/change_status/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>/freelancer?next=projectdashboard/hourly_freelancer/<?php echo $vals['project_id']?>">Accept</a> | <a href="<?php echo VPATH;?>projecthourly/delete_request/<?php echo $vals['id']?>/<?php echo $vals['project_id']?>?next=projectdashboard/hourly_freelancer/<?php echo $vals['project_id']?>">Decline</a> 
        <?php
        }
        ?>
        </td>
        <td><?php echo $payment;?> &nbsp;&nbsp;<a href="<?php echo base_url('dashboard/invoice/'.$vals['invoice_id'].'/'.'H'); ?>" target="_blank">Invoice</a></td>
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
		
        <!-- working area -->
      </div>
    </div>
  </div>
</section>


<style>
#ui-datepicker-div {
	top:220px !important
}
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
	border: 1px solid #ddd;
    border-top: none;
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


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="$('#myModal').modal('hide');" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send your work duration</h4>
      </div>
      <div class="modal-body">     
       
       <div id="enquiry_form">
			<form action="<?php echo VPATH?>projecthourly/manual_hour/<?php echo $project_id;?>" method="post" class="form-horizontal">            
           
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
			$activity =$this->db->select('*')->from('project_activity')->where("project_id = '$project_id' AND id IN(select activity_id from serv_project_activity_user where assigned_to = '$f_id' AND approved = 'Y')")->get()->result_array();
			
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
		$('#activity-box').toggle(100);
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
$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
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