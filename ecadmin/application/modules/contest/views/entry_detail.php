<?php
$p_user_image = '';

if($entry_user_detail['logo']!=''){
	$p_user_image = SITE_URL.'assets/uploaded/'.$entry_user_detail['logo'];
if(file_exists('../assets/uploaded/cropped_'.$entry_user_detail['logo'])){
	$p_user_image = SITE_URL.'assets/uploaded/cropped_'.$entry_user_detail['logo'] ;
}
}else{
	$p_user_image = SITE_URL.'assets/images/user.png'; 
}


$p_fullname = $entry_user_detail['fname'].' '.$entry_user_detail['lname'];
$total_likes = $this->db->where(array('is_liked' => '1', 'entry_id' => $entry_detail['entry_id']))->count_all_results('entry_likes');
?>
<div class="row">
	<aside class="col-sm-12">
		<div class="modal-header p-0 mb-15">
			<button type="button" class="close" onclick="$('#entryModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
			<p>&nbsp;</p>
		</div>
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  
		  <!-- <ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol> -->
		
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
			<?php if(count($entry_files) > 0){foreach($entry_files as $k => $v){ ?>
			  <div class="carousel-item <?php echo $k == 0 ? 'active' : '';?>">
				  <img src="<?php echo  SITE_URL.'assets/attachments/'.$v['filename']; ?>" alt="<?php echo $p_fullname; ?> photos" class="img-fluid">                      
				</div>
			<?php } } ?>
		  </div>
		
		  <!-- Controls -->
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
		</div>
	</aside>
	
</div>
		
