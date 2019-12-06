<?php if(count($list) > 0){foreach($list as $k => $v){
$invite_count = 0;
if(!empty($project_id)){
	$invite_count = $this->db->where(array('project_id' => $project_id, 'freelancer_id' => $v['user_id']))->count_all_results('new_inviteproject');
}
if(!empty($v['logo'])){
	$img = $v['logo'];
}else{
	$img = 'useruser.png';
}
?>

<?php if($invite_count > 0){ ?>
<div class="item" id="freelancer_row_<?php echo $v['user_id']?>" data-user="<?php echo $v['user_id'];?>">
  <img class="avatar" src="<?php echo VPATH.'assets/uploaded/'.$img; ?>" width="50" height="50">
  <p class="mb-1"><?php echo $v['fname'].' '.$v['lname']?> <span class="badge badge-warning">Already invited</span></p>
  <p hidden> &nbsp; <span class="hourly_rate">$  <?php echo $v['hourly_rate'];?>/hr</span>
 <span style="display:none;"> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i></span>
  </p>
  <a href="<?php echo base_url('clientdetails/showdetails').'/'.$v['user_id']; ?>" class="btn btn-sm btn-site"><?php echo __('postjob_view_profile','View profile'); ?></a>
  
</div>
<?php }else{ ?>
<div class="item" id="freelancer_row_<?php echo $v['user_id']?>" onclick="setActive(this);" data-user="<?php echo $v['user_id'];?>">
  <img class="avatar" src="<?php echo VPATH.'assets/uploaded/'.$img; ?>" width="50" height="50">
  <p class="mb-1"><?php echo $v['fname'].' '.$v['lname']?></p>
  <p hidden> &nbsp;<span class="hourly_rate">$  <?php echo $v['hourly_rate'];?>/hr</span>
 <span style="display:none;"> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i> <i class="zmdi zmdi-star"></i></span>
  </p>
  <a href="<?php echo base_url('clientdetails/showdetails').'/'.$v['user_id']; ?>" class="btn btn-sm btn-site"><?php echo __('postjob_view_profile','View profile'); ?></a>
  
</div>
<?php } ?>

<?php } } ?>


