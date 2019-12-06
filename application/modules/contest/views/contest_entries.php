<script src="<?php echo JS?>bootbox.js"></script>
<?php
$user = $this->session->userdata('user');
$login_user_id = $user[0]->user_id;

$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

if($logo==''){
	$logo=base_url("assets/images/user.png");
}else{
	if(file_exists('assets/uploaded/cropped_'.$logo)){
		$logo=base_url("assets/uploaded/cropped_".$logo);
	}else{
		$logo=base_url("assets/uploaded/".$logo);
	}
}
?>
<style type="text/css">
.panel-heading {
	border-color:#ddd
}
.panel-heading > h4 {
	margin: 5px 0
}
.shadow_1 .comment-box {
	padding: 15px;
	border-bottom: 1px solid #e1e1e1;
}
.shadow_1 .comment-box .form-control {
	margin-bottom:10px
}
.comment-list li{
	padding:10px 15px;
	border-bottom: 1px solid #e1e1e1;
}
@media (min-width: 1200px) {
.modal-lg {
    width: 1170px;
}
}
</style>

<?php $this->load->view('section-top'); ?>

<section class="sec dashboard">

	<div class="container">
	
	<form id="filterForm">
	<div class="row">
		<div class="col-sm-6">
		<?php if($entries_count > 0){ ?>
		<h4><?php echo $entries_count;?> <small>Total Entries</small></h4>
		<?php }else{ ?>
		<h4 class="text-danger">No Entries found</h4>
		<?php } ?>
		</div>
		<div class="col-sm-3">
		<table style="width:100%;">
			<tr>
				<td>View:</td>
				<td>
					<select class="form-control" onchange="performSearch()" name="view">
					<option value="">All Entries</option>
					<option value="ME" <?php echo (!empty($srch['view']) && $srch['view'] == 'ME') ? 'selected="selected"' : '';?>>My Entries</option>
					<option value="A" <?php echo (!empty($srch['view']) && $srch['view'] == 'A') ? 'selected="selected"' : '';?>>Active</option>
					<option value="W" <?php echo (!empty($srch['view']) && $srch['view'] == 'W') ? 'selected="selected"' : '';?>>Withdrawn</option>
					
					</select>
				</td>
			</tr>
		</table>
	
		</div>
		<div class="col-sm-3">
		<table style="width:100%;">
			<tr>
				<td>Sort by:</td>
				<td>
					<select class="form-control" onchange="performSearch()" name="order_by">
					<option value="">Default</option>
					<option value="recent" <?php echo (!empty($srch['order_by']) && $srch['order_by'] == 'recent') ? 'selected="selected"' : '';?>>Recent</option>
					<option value="old" <?php echo (!empty($srch['order_by']) && $srch['order_by'] == 'old') ? 'selected="selected"' : '';?>>Old</option>
					</select>
				</td>
			</tr>
		</table>
		</div>
	</div>
	</form>
	
	<div class="clearfix"></div>
	<br/>
	<div class="row-10">
	
		<?php if(count($entries_list) > 0){foreach($entries_list as $k => $v){ 
		$img = IMAGES.'no-image.png';
		if(!empty($v['entry_files'][0])){
			$img = base_url('assets/attachments/'.$v['entry_files'][0]['filename']);
		}
		$fname = getField('fname', 'user', 'user_id', $v['user_id']);
		$lname = getField('lname', 'user', 'user_id', $v['user_id']);
		$name  = $fname . ' ' . $lname;
		$total_likes = $this->db->where(array('is_liked' => '1', 'entry_id' => $v['entry_id']))->count_all_results('entry_likes');
		$is_user_liked = $this->db->where(array('is_liked' => '1', 'entry_id' => $v['entry_id'], 'user_id' => $login_user_id))->count_all_results('entry_likes');
		$is_sealed_entry = $v['is_sealed'] == 1 ? true : false;
		$is_auth_user = false;
		if($login_user_id == $details['user_id']){
			$is_auth_user = true;
		}else{
			if($login_user_id == $v['user_id']){
				$is_auth_user = true;
			}
		}
		$is_withdraw = false;
		if($v['is_withdraw'] == 1){
			$is_withdraw = true;
		}
		$entry_avg_rating = 0;
		$entry_avg_rating_row = $this->db->select('avg(rating) as rating')->where('entry_id', $v['entry_id'])->get('entry_rating')->row_array();
		if(!empty($entry_avg_rating_row['rating'])){
			$entry_avg_rating = round($entry_avg_rating_row['rating']);
		}
		
		?>
		<article class="col-md-3 col-sm-6 col-xs-12" id="contest_entry_<?php echo $v['entry_id']; ?>">
		<div class="card">
		
		<?php if($is_withdraw){ ?>
		
		 <div class="picture">
			<a href="javascript:void(0);" style="cursor: default"><img class="img-responsive" src="<?php echo IMAGE.'withdraw.png'; ?>" alt="Card image cap"></a>
			
			<?php if($login_user_id == $v['user_id']){ ?>
            <div class="hoverBlock">
          	<a href="javascript:void(0)" class="btn btn-site" onclick="confirm_repost('<?php echo $v['entry_id']; ?>')">Repost</a>
			</div>
			<?php } ?>
			
          
		  </div>
		  
		  <div class="card-body">
			<h4 class="card-title"><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>" target="_blank">&nbsp;</a></h4>
			<p class="card-text">#<?php echo $v['entry_id'];?></p>
		 </div>
		  
		  
		<?php }else{ ?>
		
		<?php if($is_sealed_entry && $is_auth_user){ ?>
		  <div class="picture">
			<a href="javascript:void(0);" onclick="entryDetail('<?php echo $v['entry_id'];?>');"><img class="card-img-top img-responsive" src="<?php echo $img; ?>" alt="Card image cap"></a>
			
			<?php if($login_user_id == $v['user_id']){ ?>
            <div class="hoverBlock">
          	<a href="javascript:void(0)" class="btn btn-site" onclick="confirm_withdraw('<?php echo $v['entry_id']; ?>')">Withdraw</a> <a href="javascript:void(0)" onclick="resale('<?php echo $v['entry_id']; ?>')" class="btn btn-grey">Sale entry</a> </div>
			<?php } ?>
			
         
		  </div>
          
		  <div class="card-body">
			<h4 class="card-title"><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>" target="_blank"><?php echo $name; ?></a></h4>
			<p class="card-text">#<?php echo $v['entry_id'];?></p>
			
			<?php if($login_user_id == $details['user_id']){ ?>
				
				<?php if(($details['status'] != 'C') && ($v['is_awarded'] == 0)){ ?>
				<a href="javascript:void(0)" onclick="awardContest('<?php echo $v['entry_id']; ?>', '<?php echo $v['contest_id']; ?>')" class="awardBtn btn btn-site">Award</a>
				<?php } ?>
			
				<?php if($v['is_awarded'] == 1){ ?>
					<a href="javascript:void(0)" class="awardBtn btn btn-success">Awarded</a>
				<?php }  ?>
				
			<?php } ?>
			
		  </div>
		  <?php }elseif(!$is_sealed_entry){ ?>
		  <div class="picture">
		  
			<a href="javascript:void(0);" onclick="entryDetail('<?php echo $v['entry_id'];?>');"><img class="card-img-top img-responsive" src="<?php echo $img; ?>" alt="Card image cap"></a>
		  
		  <?php if($login_user_id == $v['user_id']){ ?>
            <div class="hoverBlock">
          	<a href="javascript:void(0)" class="btn btn-site" onclick="confirm_withdraw('<?php echo $v['entry_id']; ?>')">Withdraw</a> <a href="javascript:void(0)" onclick="resale('<?php echo $v['entry_id']; ?>')" class="btn btn-grey">Sale entry</a> </div>
			<?php } ?>
			
		  </div>
		  
		  <div class="card-body">
			<h4 class="card-title"><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>" target="_blank"><?php echo $name; ?></a></h4>
			<p class="card-text">#<?php echo $v['entry_id'];?></p>
			
			<?php if($login_user_id == $details['user_id']){ ?>
				
				<?php if(($details['status'] != 'C') && ($v['is_awarded'] == 0)){ ?>
				<a href="javascript:void(0)" onclick="awardContest('<?php echo $v['entry_id']; ?>', '<?php echo $v['contest_id']; ?>')" class="awardBtn btn btn-site">Award</a>
				<?php } ?>
			
				<?php if($v['is_awarded'] == 1){ ?>
					<a href="javascript:void(0)" class="awardBtn btn btn-success">Awarded</a>
				<?php }  ?>
				
			<?php } ?>
			
		  </div>
		  <?php }else{  ?>
		    <div class="picture text-center"><a href="javascript:void(0);" style="cursor:not-allowed"><img class="img-responsive" src="<?php echo IMAGE;?>shield.png" alt="" style="display:initial"></a></div>
			
            <div class="card-body">
            	<h4 class="card-title"><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>" target="_blank">&nbsp;</a></h4>
				<p class="card-text">#<?php echo $v['entry_id'];?></p>
            </div>
			
		  <?php } ?>
		  
		  <?php } ?>
		  
          <div class="card-action text-right choose_favourite">
		  <?php if($is_withdraw){ ?>
			<div><strong>Withdraw</strong></div>
		  <?php }else{ ?>
			<?php if(($is_sealed_entry && $is_auth_user) || (!$is_sealed_entry)){ ?>
			<div class="pull-left entry-rating">
				<?php 
				for($i=1; $i<=5; $i++){
					
					if($i <= $entry_avg_rating){
						echo '<i class="zmdi zmdi-star"></i>';
					}else{
						echo '<i class="zmdi zmdi-star-outline"></i>';
					}
					
				}
				?>
			</div>
		   <a href="javascript:void(0)" class="<?php echo $is_user_liked > 0 ? 'active' : '';?>" onclick="toggleLike(this)" data-total-likes="<?php echo $total_likes; ?>" data-is-liked="<?php echo $is_user_liked; ?>" data-entry-id="<?php echo $v['entry_id']; ?>"><i class="zmdi zmdi-favorite zmdi-18x"></i> <span class="counter"><?php echo $total_likes; ?></span> Likes</a>
		   
		   <?php }else{  ?>
		   
		   <div><strong>Sealed</strong></div>
		   
		   <?php /*
		   <a href="javascript:void(0)" class="<?php echo $is_user_liked > 0 ? 'active' : '';?>" data-total-likes="<?php echo $total_likes; ?>" data-is-liked="<?php echo $is_user_liked; ?>" data-entry-id="<?php echo $v['entry_id']; ?>"><i class="zmdi zmdi-favorite zmdi-18x"></i> <span class="counter"><?php echo $total_likes; ?></span> Likes</a>
		   <?php */ ?> 
		   
		   <?php }  ?>
		   <?php } ?>
          </div>
		</div>
		</article>
		<?php } }else{  ?>
		<!--<div class="col-xs-12"><div class="no-result">No Entries Found</div></div>-->					
		<?php } ?>
		
		<div class="clearfix"></div>
		<?php echo $links ; ?>
		<!--<article class="col-md-3 col-sm-6 col-xs-12">
		<div class="card">
		  <div class="picture"><a href="#" data-toggle="modal" data-target="#entryModal"><img class="card-img-top img-responsive" src="<?php echo base_url('assets/images/12.jpg')?>" alt="Card image cap"></a></div>
		  <div class="card-body">
			<h5 class="card-title">Card title</h5>
			<p class="card-text">#Demo</p>
		  </div>
          <div class="card-action text-right choose_favourite">
              <a href="#" class="active"><i class="zmdi zmdi-favorite zmdi-18x"></i> 0</a>
          </div>
		</div>
		</article>-->
		
	
		
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-12 col-md-8">
			
			<div class="white shadow_1">
				<div class="panel-heading"><h4>Public Clarification Board</h4></div>
				<div class="media comment-box mt-0">
					<div class="media-left"><img src="<?php echo $logo; ?>" height="64" width="64" class=""/></div>
					<div class="media-body">
						<div id="comment-form-wrapper">
							<form onsubmit="ajaxSubmit(this, event)">
							<textarea class="form-control" name="comment" id="comment-input" rows="3" placeholder="Write a comment" onkeypress="check_key(event)"></textarea>
							<input type="hidden" name="contest_id" value="<?php echo $contest_id; ?>"/>
							<p class="text-muted f-12">Request contest holder to increase prize.</p>
							<button class="hide btn btn-primary" id="commentSubmitBtn">Post</button>
							</form>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="comment-list-box">
					<ul class="comment-list">
						<?php 
						$login_user_logo = $logo;
						if(count($contest_comments) > 0){foreach($contest_comments as $k => $v){ 
						$profile_pic = $v['user_info']['logo'];
						if(!empty($profile_pic)){
							$logo = base_url('assets/uploaded/'.$profile_pic);
							if(file_exists('./assets/uploaded/cropped_'.$profile_pic)){
								$logo = base_url('assets/uploaded/cropped_'.$profile_pic);
							}
						}else{
							$logo = base_url("assets/images/user.png");
						}
						?>
						<li class="comment-list-item" id="comment_item_<?php echo $v['comment_id']; ?>">
							<div class="media">
								<div class="media-left">
									<img src="<?php echo $logo; ?>" height="64" width="64" class=""/>
								</div>
								<div class="media-body">
									<p><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']);?>"><?php echo $v['user_info']['fname'].' '.$v['user_info']['lname']; ?></a><span class="pull-right"><?php echo date('d M, H:i A', strtotime($v['datetime'])); ?> <?php if($login_user_id != $v['user_id']){ ?> <a href="javascript:void(0);" onclick="$('#reply_comment_wrapper_<?php echo $v['comment_id'];?>').toggle();"><i class="fa fa-reply"></i></a> <?php } ?></span></p>
									<p class=""><?php echo $v['comment']; ?></p>
								</div>
							</div>
							<ul class="comment-list" id="reply_comments_<?php echo $v['comment_id']; ?>">
								<?php
								if(count($v['comment_replies']) > 0){foreach($v['comment_replies'] as $val){ 
								$profile_pic = $val['user_info']['logo'];
								if(!empty($profile_pic)){
									$logo = base_url('assets/uploaded/'.$profile_pic);
									if(file_exists('./assets/uploaded/cropped_'.$profile_pic)){
										$logo = base_url('assets/uploaded/cropped_'.$profile_pic);
									}
								}else{
									$logo = base_url("assets/images/user.png");
								}
								?>
								<li class="comment-list-item">
									<div class="media">
										<div class="media-left">
											<img src="<?php echo $logo; ?>" height="64" width="64" class=""/>
										</div>
										<div class="media-body">
											<p><a href="<?php echo base_url('clientdetails/showdetails/'.$val['user_id']);?>"><?php echo $val['user_info']['fname'].' '.$val['user_info']['lname']; ?></a><span class="pull-right"><?php echo date('d M, H:i A', strtotime($val['datetime'])); ?> </span></p>
											<p class=""><?php echo $val['comment']; ?></p>
										</div>
									</div>
								</li>
								<?php } }?>
							</ul>
							
							<div class="media comment-box mt-0 reply-box" id="reply_comment_wrapper_<?php echo $v['comment_id'];?>" style="display:none;">
								<div class="media-left"><img src="<?php echo $login_user_logo; ?>" height="64" width="64" class=""/></div>
								<div class="media-body">
									<div id="reply_comment_form_<?php echo $v['comment_id'];?>">
										<form onsubmit="ajaxSubmitChild(this, event, '<?php echo $v['comment_id'];?>')">
										<textarea class="form-control" name="comment" id="comment-input-child" rows="3" placeholder="Reply" onkeypress="check_key(event, '<?php echo $v['comment_id'];?>')"></textarea>
										<input type="hidden" name="contest_id" value="<?php echo $contest_id; ?>"/>
										<input type="hidden" name="parent_id" value="<?php echo $v['comment_id'];?>"/>
										<button class="hide btn btn-primary" id="submit-cmnt-btn-child">Post</button>
										</form>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</li>
						<?php } } ?>
						
					</ul>
				</div>
			</div>
			
		</div>
		<div class="col-sm-12 col-md-4">
		
		<?php if(count($similar_contest)){ ?>
        <div class="panel panel-default">
			<div class="panel-heading"><h4>Similar Contests</h4></div>
        	<div class="panel-body">
			<?php foreach($similar_contest as $k => $v){
				$poster_fname = getField('fname', 'user', 'user_id', $v['user_id']);
				$poster_lname = getField('lname', 'user', 'user_id', $v['user_id']);
				$poster_name = $poster_fname.' '.$poster_lname;
				?>
            	<div class="dataList-items">
                	<h5><a href="<?php echo base_url('contest/contest_detail/'.$v['contest_id']); ?>"><?php echo strlen($v['title']) > 25 ? substr($v['title'], 0, 25) : $v['title']; ?></a></h5>
                    <p><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']); ?>">by <?php echo $poster_name; ?></a> <span class="pull-right"><?php echo CURRENCY.''.$v['budget']?></span></p>
                </div>
				<?php } ?>
                
        	</div>
        </div>
		<?php } ?>
        
		<div class="panel panel-default hidden">
        	<div class="panel-heading"><h4>Completed Contests</h4></div>
        	<div class="panel-body">
            	<div class="dataList-items">
                	<h5><a href="#">Personal brand identity design</a></h5>
                    <p><a href="#">by Ritesh Das</a> <span class="pull-right">$200 USD</span></p>
                </div>
                <div class="dataList-items">
                	<h5><a href="#">Personal brand identity design</a></h5>
                    <p><a href="#">by Ritesh Das</a> <span class="pull-right">$200 USD</span></p>
                </div>
                <div class="dataList-items">
                	<h5><a href="#">Personal brand identity design</a></h5>
                    <p><a href="#">by Ritesh Das</a> <span class="pull-right">$200 USD</span></p>
                </div>
        	</div>
        </div>
		
	</div>

</section>

<!-- Modal -->
<div class="modal fade" id="entryModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">      
      <div class="modal-body">
		
      </div>
      
    </div>
  </div>
</div>

<script type="text/template" id="comment-list-item-tmp">
	<li class="comment-list-item" id="comment_item_{COMMENT_ID}">
		<div class="media">
			<div class="media-left">
				<img src="{AVATAR}" height="64" width="64" class=""/>
			</div>
			<div class="media-body">
				<p><a href="<?php echo base_url('clientdetails/showdetails');?>/{USER_ID}">{NAME}</a> <span class="pull-right">{DATE} <a href="#"><i class="fa fa-reply"></i></a></span></p>
				<p class="">{COMMENT}</p>
			</div>
		</div>
	</li>
</script>

<script type="text/template" id="comment-list-item-tmp-child">
	<li class="comment-list-item" id="comment_item_{COMMENT_ID}">
		<div class="media">
			<div class="media-left">
				<img src="{AVATAR}" height="64" width="64" class=""/>
			</div>
			<div class="media-body">
				<p><a href="<?php echo base_url('clientdetails/showdetails');?>/{USER_ID}">{NAME}</a> <span class="pull-right">{DATE}</span></p>
				<p class="">{COMMENT}</p>
			</div>
		</div>
	</li>
</script>


<script type="text/template" id="post-comment-tmp">
	<form onsubmit="ajaxSubmit(this, event)">
	<textarea class="form-control" name="comment" id="comment-input" rows="3" placeholder="Write a comment" onkeypress="check_key(event)"></textarea>
		
		<input type="hidden" name="contest_id" value="<?php echo $contest_id; ?>"/>
		<p class="text-muted f-12">Request contest holder to increase prize.</p>
		<button class="hide btn btn-primary" id="commentSubmitBtn">Post</button>
	</form>
</script>

<script>

function ajaxSubmit(f, e){
	e.preventDefault();
	
	var cmnt_inp = $('#comment-input').val();
	if(cmnt_inp.trim() == ''){
		return;
	}
	
	var fdata = $(f).serialize();
	$.ajax({
		url : '<?php echo base_url('contest/post_comment_ajax')?>?type=contest_comment',
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			
			if(res && res.status == 1){
				var html = $('#comment-list-item-tmp').html();
				
				html = html.replace(/{COMMENT_ID}/g, res.data.comment_id);
				html = html.replace(/{NAME}/g, res.data.name);
				html = html.replace(/{AVATAR}/g, res.data.avatar);
				html = html.replace(/{COMMENT}/g, res.data.comment);
				html = html.replace(/{DATE}/g, res.data.date);
				html = html.replace(/{USER_ID}/g, res.data.user_id);
				
				$('ul.comment-list').prepend(html);
				
				resetCommentForm();
			} 
			
		}
	});
}

function ajaxSubmitChild(f, e, parent){
	e.preventDefault();
	
	var cmnt_inp = $('#reply_comment_form_'+parent).find('#comment-input-child').val();
	console.log(cmnt_inp);
	if(cmnt_inp.trim() == ''){
		return;
	}
	
	var fdata = $(f).serialize();
	$.ajax({
		url : '<?php echo base_url('contest/post_comment_ajax')?>?type=contest_comment',
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			
			if(res && res.status == 1){
				var html = $('#comment-list-item-tmp-child').html();
				
				html = html.replace(/{COMMENT_ID}/g, res.data.comment_id);
				html = html.replace(/{NAME}/g, res.data.name);
				html = html.replace(/{AVATAR}/g, res.data.avatar);
				html = html.replace(/{COMMENT}/g, res.data.comment);
				html = html.replace(/{DATE}/g, res.data.date);
				html = html.replace(/{USER_ID}/g, res.data.user_id);
				
				$('#reply_comments_'+parent).append(html);
				
				$('#reply_comment_form_'+parent).find('#comment-input-child').val('');
			} 
			
		}
	});
}

function resetCommentForm(){
	var form = $('#post-comment-tmp').html();
	$('#comment-form-wrapper').html(form);
}


function check_key(e, par){
	var key = e.which || '';
	if(key == 13){
		if(par){
			$('#reply_comment_form_'+par).find('#submit-cmnt-btn-child').click();
		}else{
			$('#commentSubmitBtn').click();
		}
		
		e.preventDefault();
	}
}


function awardContest(entry_id, contest_id){

	if(entry_id == ''){
		return ;
	}
	
	$.ajax({
		url : '<?php echo base_url('contest/award_contest')?>',
		data: {entry_id: entry_id, contest_id: contest_id},
		dataType: 'JSON',
		type: 'POST',
		beforeSend: function(){
			$('#contest_entry_'+entry_id).find('.awardBtn').html('Checking..').attr('disabled', 'disabled');
		},
		success: function(res){
			if(res.status == 1){
				location.reload();
			}
		}
	});
	
}


function entryDetail(id){
	$('#entryModal').find('.modal-body').html('<p class="text-center">Loading...</p>');
	$('#entryModal').modal('show');
	$.get('<?php echo base_url('contest/entry_detail')?>/'+id, function(res){
		$('#entryModal').find('.modal-body').html(res);
	});
}


function toggleLike(ele){
	var prev_stat = Boolean(Number($(ele).data('isLiked')));
	var entry_id = $(ele).data('entryId');
	var new_stat = !prev_stat;
	var is_liked = new_stat === true ? 1 : 0;
	
	var total_likes = $(ele).data('totalLikes');
	
	$.ajax({
		url : '<?php echo base_url('contest/toggle_like'); ?>?type=entry_like',
		data: {entry_id: entry_id ,  is_liked : is_liked},
		dataType: 'json',
		type: 'POST',
		success: function(res){
			
			if(res.status == 1){
				
				if(is_liked == 1){
					total_likes++;
					$(ele).addClass('active');
				}else{
					total_likes--;
					$(ele).removeClass('active');
				}
				
				$(ele).data('totalLikes' , total_likes);
				$(ele).data('isLiked', new_stat);
				$(ele).find('.counter').html(total_likes);
				
			}
		}
	});
	
}

function confirm_withdraw(entry_id=''){
bootbox.confirm({
		title:"Confirm ",
		message: "Are you sure to withdraw this entry ? <br/></br/>",
	
		buttons: {
			confirm: {
				label: "Yes",
				className: 'btn-success'
			},
			cancel: {
				label: "No",
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				$.ajax({
					url : '<?php echo base_url('contest/withdraw_contest')?>',
					data: {entry_id: entry_id},
					type: 'POST',
					dataType: 'json',
					success: function(res){
						if(res.status == 1){
							location.reload();
						}
					}
				});
			}
		}
	});	
}

function confirm_repost(entry_id){
	bootbox.confirm({
		title:"Confirm ",
		message: "Are you sure to repost this entry ? <br/></br/>",
	
		buttons: {
			confirm: {
				label: "Yes",
				className: 'btn-success'
			},
			cancel: {
				label: "No",
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				$.ajax({
					url : '<?php echo base_url('contest/withdraw_contest_repost')?>',
					data: {entry_id: entry_id},
					type: 'POST',
					dataType: 'json',
					success: function(res){
						if(res.status == 1){
							location.reload();
						}
					}
				});
			}
		}
	});	
}

function resale(entry_id){
	bootbox.prompt({
		title: "Enter your sale amount for this entry",
		inputType: 'text',
		callback: function (result) {
			if(result && isNaN(result) === false){
				$.ajax({
					url : '<?php echo base_url('contest/change_entry_price')?>',
					data: {entry_id: entry_id, price: result},
					type: 'POST',
					dataType: 'json',
					success: function(res){
						if(res.status == 1){
							location.reload();
						}
					}
				});
			}
		}
	});
}

function performSearch(){
	$('#filterForm').submit();
}
</script>
