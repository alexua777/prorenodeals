<table class="table">
	<?php if(count($projects) > 0){foreach($projects as $k => $v){ ?>
	<tr>
		<td><a href="<?php echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
		<td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly'; ?></td>
		<td><?php echo __('talentdetails_emp_posted_on','Posted on'); ?> : <?php echo date('d M, Y', strtotime($v['post_date'])); ?></td>
		
	</tr>
	<?php } }else{  ?>
	<tr>
		<td colspan="10">
		<?php 
		if($type == 'O'){
			echo 'No open projects';
		}else if($type == 'C'){
			echo 'No completed projects';
		}
		?>
		</td>
	</tr>
	<?php } ?>
	
</table>
<?php echo $links; ?>