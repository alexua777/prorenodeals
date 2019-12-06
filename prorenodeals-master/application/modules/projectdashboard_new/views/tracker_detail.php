<div>
	<a href="<?php echo base_url('projectdashboard_new/view_tracker/'.$project_id.'/'.$freelancer_id.'?show_date='.$prev_day);?>"><i class="zmdi zmdi-chevron-left zmdi-hc-2x" style="position: relative; top: 5px;"></i></a> &nbsp; 
	<b><?php echo date('D , M d , Y', $curr_day);?></b> &nbsp; 
	<?php if($next_day <= strtotime(date('Y-m-d'))){ ?>
	<a href="<?php echo base_url('projectdashboard_new/view_tracker/'.$project_id.'/'.$freelancer_id.'?show_date='.$next_day);?>"><i class="zmdi zmdi-chevron-right zmdi-hc-2x" style="position: relative; top: 5px;"></i></a>
	<?php } ?>
</div>
<div>
	<table class="table">
		<?php if(count($tracker_group) > 0){foreach($tracker_group as $time => $items){ ?>
		<tr>
			<td width="5%" style="vertical-align: middle; "><?php echo $time; ?></td>
			<td width="95%">
			<?php if(is_array($items) && count($items) > 0){foreach($items as $k => $v){ 
			$image_name=base_url('time_tracker/mediafile').'/'.$project_id."_".$v['id'].".jpg";
			?>
			<div class="tracker_item">
					<img src="<?php echo $image_name; ?>" class="img-responsive">
					<div class="t_foot">
						<p><?php echo date('g:i A', strtotime($v['project_work_snap_time']));?></p>
					</div>
				</div>
			<?php } } ?>
			</td>
		</tr>
		<?php } }else{  ?>
		<tr>
			<td colspan="5"> No records found</td>
		</tr>
		<?php  } ?>
		
		<!--<tr>
			<td width="5%" style="vertical-align: middle; "> 5AM</td>
			<td width="95%">
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:00 am</p>
					</div>
				</div>
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:10 am</p>
					</div>
				</div>
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:20 am</p>
					</div>
				</div>
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:35 am</p>
					</div>
				</div>
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:45 am</p>
					</div>
				</div>
				<div class="tracker_item">
					<img src="http://localhost/flance_v2/time_tracker/mediafile/1519369817_7265.jpg" class="img-responsive">
					<div class="t_foot">
						<p><input type="checkbox"/> 7:55 am</p>
					</div>
				</div>
			</td>
		</tr>-->

	</table>
</div>