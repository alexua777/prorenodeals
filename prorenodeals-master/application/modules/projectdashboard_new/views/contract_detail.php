<?php

$total_working_minutes_week = get_project_min_week(date('Y-m-d'), $freelancer_id, $project_id);
$total_working_minutes = get_project_all_minutes($freelancer_id, $project_id);

$total_hours = $total_hours_curr_week = 0;
$total_mins = $total_mins_curr_week = 0;

if($total_working_minutes_week > 60){
	$total_hours_curr_week = round($total_working_minutes_week/60);
	$total_mins_curr_week = $total_working_minutes_week % 60;
}else{
	$total_mins_curr_week = $total_working_minutes_week;
}

if($total_working_minutes > 60){
	$total_hours = round($total_working_minutes/60);
	$total_mins = $total_working_minutes % 60;
}else{
	$total_mins = $total_working_minutes;
}



?>
<div class="well">
	<div class="row">
		<div class="col-sm-6">
			<p>This week</p>
			<p class="big"><?php echo $total_hours_curr_week.':'.$total_mins_curr_week;?>hrs</p>
		</div>
		<div class="col-sm-6">
		<p>Since start</p>
		<p class="big"><?php echo $total_hours.':'.$total_mins;?>hrs</p>
		</div>
	</div>
	</div>

	<div class="h-title">Time Tracking</div>
	<div class="row">
	<div class="col-sm-8">
		<img src="https://wedevs-com-wedevs.netdna-ssl.com/wp-content/uploads/2014/03/Time-Tracker.jpg" class="t_thumb"/>
		<div class="pull-right">
			<p>Memo : Forums Check</p>
			<a class="btn btn-site" href="<?php echo base_url('projectdashboard_new/view_tracker/'.$project_id.'/'.$freelancer_id); ?>">View Work Diary</a>
		</div>
	</div>
	<div class="col-sm-4"></div>
	</div>