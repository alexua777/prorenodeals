<style>
#freelancer_list_input_wrapper{
	position: relative;
}

#freelancer_list_input_wrapper .close_list{
	position: absolute;
    right: 9px;
    top: 2px;
    z-index: 10;
    padding: 4px 11px;
    border-radius: 50%;
    background-color: #746a6a;
    color: white;
    cursor: pointer;
	display: none;
}
</style>

<div class="invite_freelancer_wrapper">
	<h5 class="text-uppercase b">Invite User</h5>
	<div class="ui fluid selection dropdown">
	<input type="hidden" name="user">
	<i class="dropdown icon"></i>
	<div id="freelancer_list_input_wrapper">
	<input type="text" class="form-control" placeholder="Search user by name or email" onkeyup="search_freelancer(this.value)" id="search_freelancer_input"/>
	<span class="close_list">x</span>
	</div>
	<?php
	$inv_user_id = get('inv_user');
	
	$inv_user = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $inv_user_id)));
	$inv_user_logo = get_user_logo($inv_user_id);
	?>
	<div class="menu" id="freelancer_list" style="display:none"></div>
	
	<div class="menu" id="selected_freelancer_list" style="<?php echo $inv_user ? '' : 'display:none';?>"> 
	<?php if($inv_user){ ?>
		<div class="item selected" id="freelancer_row_<?php echo $inv_user['user_id']?>" onclick="setActive(this);" data-user="<?php echo $inv_user['user_id']?>">
			<img class="avatar" src="<?php echo $inv_user_logo;?>" width="50" height="50">
			<?php echo $inv_user['fname'].' '. $inv_user['lname']; ?>
			<p>&nbsp;</p>

		  <a href="<?php echo base_url('clientdetails/showdetails').'/'.$inv_user['user_id']; ?>" class="btn btn-sm btn-site"><?php echo __('postjob_view_profile','View profile'); ?></a>
		  <input type="hidden" name="freelancer[]" value="<?php echo $inv_user['user_id']; ?>">
		</div>
		<?php } ?>
	</div>
	</div>
</div>

<script>
function search_freelancer(val){
	$.get('<?php echo base_url('postjob/search_freelancer')?>?term='+val, function(res){
		$('#freelancer_list').show();
		$('.close_list').show();
		$('#freelancer_list').html(res);
	});
}

$('.close_list').click(function(){
	$('#freelancer_list').html('');
	$('#search_freelancer_input').val('');
	$(this).hide();
});

</script>