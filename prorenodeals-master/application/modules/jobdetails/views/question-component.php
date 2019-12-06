<style>
.comment-list.child, .comment-box.reply-box {
    padding-left: 50px;
}

.input-footer {
    background-color: #ededed;
    padding: 10px;
    clear: both;
}

.input-footer button{
	float: right;
    margin-top: -3px;
}

</style>
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
<div class="card">
	<div class="card-header"><h4>Ask your questions</h4></div>
    <div class="card-body">
    <?php /*?><section class="comments">
						<h3 class="margin-top-45 margin-bottom-0">Comments <span class="comments-amount">(5)</span></h3>

						<ul>
							<li>
								<div class="avatar"><img src="images/user-avatar-placeholder.png" alt=""></div>
								<div class="comment-content"><div class="arrow-comment"></div>
									<div class="comment-by">Kathy Brown<span class="date">12th, June 2018</span>
										<a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a>
									</div>
									<p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
								</div>

								<ul>
									<li>
										<div class="avatar"><img src="images/user-avatar-placeholder.png" alt=""></div>
										<div class="comment-content"><div class="arrow-comment"></div>
											<div class="comment-by">Tom Smith<span class="date">12th, June 2018</span>
												<a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a>
											</div>
											<p>Rrhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque.</p>
										</div>
									</li>
									<li>
										<div class="avatar"><img src="images/user-avatar-placeholder.png" alt=""></div>
										<div class="comment-content"><div class="arrow-comment"></div>
											<div class="comment-by">Kathy Brown<span class="date">12th, June 2018</span>
												<a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a>
											</div>
											<p>Nam posuere tristique sem, eu ultricies tortor.</p>
										</div>

										<ul>
											<li>
												<div class="avatar"><img src="images/user-avatar-placeholder.png" alt=""></div>
												<div class="comment-content"><div class="arrow-comment"></div>
													<div class="comment-by">John Doe<span class="date">12th, June 2018</span>
														<a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a>
													</div>
													<p>Great template!</p>
												</div>
											</li>
										</ul>

									</li>
								</ul>

							</li>

							<li>
								<div class="avatar"><img src="images/user-avatar-placeholder.png" alt=""> </div>
								<div class="comment-content"><div class="arrow-comment"></div>
									<div class="comment-by">John Doe<span class="date">15th, May 2015</span>
										<a href="#" class="reply"><i class="fa fa-reply"></i> Reply</a>
									</div>
									<p>Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris.</p>
								</div>

							</li>
						 </ul>

					</section><?php */?>
    <div class="media comment-box mb-3">
        <img src="<?php echo $logo; ?>" alt="" height="48" width="48" class="rounded-circle mr-3" />
        <div class="media-body">
            <div id="comment-form-wrapper">
                <form onsubmit="ajaxSubmit(this, event)">
                <textarea class="form-control mb-3" name="comment" id="comment-input" rows="3" placeholder="Type your question" onkeypress="check_key(event)"></textarea>
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
				<div class="btn btn-outline-success btn-file">
                	<i class="fa fa-paperclip"></i>
					<input type="file" name="attachment"/>					
				</div>
                <button class="btn btn-site" id="commentSubmitBtn">Post</button>
                </form>
            </div>
        </div>
    </div>

    <div class="comment-list-box">

        <ul class="comment-list">

            <?php 

            $login_user_logo = $logo;

            if(count($project_comments) > 0){foreach($project_comments as $k => $v){ 

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

                <div class="media mb-3">
                    <img src="<?php echo $logo; ?>" height="48" width="48" class="rounded-circle mr-3"/>
                    <div class="media-body">

                        <h4><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']);?>"><?php echo $v['user_info']['fname'].' '.$v['user_info']['lname']; ?></a></h4>
                        <?php if($login_user_id != $v['user_id']){ ?> <a href="javascript:void(0);" class="btn btn-sm btn-outline-success float-right" onclick="$('#reply_comment_wrapper_<?php echo $v['comment_id'];?>').toggle();"><i class="fa fa-reply"></i></a> <?php } ?>
                        <p class="text-muted"><?php echo date('d M, H:i A', strtotime($v['datetime'])); ?> </p>

                        <p class=""><?php echo $v['comment']; ?></p>
						
						<?php if($v['attachment']){ ?>
						<div><a href="<?php echo base_url('assets/uploaded/'.$v['attachment'])?>" target="_blank">Attachment</a></div>
						<?php } ?>

                    </div>

                </div>

                <ul class="comment-list child" id="reply_comments_<?php echo $v['comment_id']; ?>">

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

                        <div class="media mb-3">
                            <img src="<?php echo $logo; ?>" alt="" height="48" width="48" class="rounded-circle mr-3"/>
                            <div class="media-body">

                                <h4><a href="<?php echo base_url('clientdetails/showdetails/'.$val['user_id']);?>"><?php echo $val['user_info']['fname'].' '.$val['user_info']['lname']; ?></a></h4>
                                <p class="text-muted"><?php echo date('d M, H:i A', strtotime($val['datetime'])); ?> </p>

                                <p class=""><?php echo $val['comment']; ?></p>
								
								<?php if($val['attachment']){ ?>
								<div><a href="<?php echo base_url('assets/uploaded/'.$val['attachment'])?>" target="_blank">Attachment</a></div>
								<?php } ?>
						
                            </div>

                        </div>

                    </li>

                    <?php } }?>

                </ul>

                

                <div class="media comment-box mb-3 reply-box" id="reply_comment_wrapper_<?php echo $v['comment_id'];?>" style="display:none;">

                    <img src="<?php echo $login_user_logo; ?>" alt="" height="48" width="48" class="rounded-circle mr-3" />

                    <div class="media-body">

                        <div id="reply_comment_form_<?php echo $v['comment_id'];?>">

                            <form onsubmit="ajaxSubmitChild(this, event, '<?php echo $v['comment_id'];?>')">

                            <textarea class="form-control mb-3" name="comment" id="comment-input-child" rows="3" placeholder="Reply" onkeypress="check_key(event, '<?php echo $v['comment_id'];?>')"></textarea>

                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>

                            <input type="hidden" name="parent_id" value="<?php echo $v['comment_id'];?>"/>
							<div class="btn btn-outline-success btn-file">
                            	<i class="fa fa-paperclip"></i>
								<input type="file" name="attachment"/>								
							</div>
                            <button class="btn btn-site" id="submit-cmnt-btn-child">Post</button>
                            </form>

                        </div>

                    </div>

                </div>

            </li>

            <?php } } ?>

            

        </ul>

    </div>
    </div>
</div>

<script type="text/template" id="comment-list-item-tmp">

	<li class="comment-list-item" id="comment_item_{COMMENT_ID}">

		<div class="media">

			<div class="media-left">

				<img src="{AVATAR}" alt="" height="48" width="48" class="img-circle mr-3" />

			</div>

			<div class="media-body">

				<p><a href="<?php echo base_url('clientdetails/showdetails');?>/{USER_ID}">{NAME}</a> <span class="pull-right">{DATE} </span></p>

				<p class="">{COMMENT}</p>
				
				<div>{ATTACHMENT}</div>

			</div>

		</div>

	</li>

</script>



<script type="text/template" id="comment-list-item-tmp-child">

	<li class="comment-list-item" id="comment_item_{COMMENT_ID}">

		<div class="media">

			<div class="media-left">

				<img src="{AVATAR}" alt="" height="48" width="48" class="img-circle mr-3" />

			</div>

			<div class="media-body">

				<p><a href="<?php echo base_url('clientdetails/showdetails');?>/{USER_ID}">{NAME}</a> <span class="pull-right">{DATE}</span></p>

				<p class="">{COMMENT}</p>
				
				<div>{ATTACHMENT}</div>

			</div>

		</div>

	</li>

</script>





<script type="text/template" id="post-comment-tmp">

	<form onsubmit="ajaxSubmit(this, event)">

	<textarea class="form-control mb-3" name="comment" id="comment-input" rows="3" placeholder="Write a comment" onkeypress="check_key(event)"></textarea>
		<input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>
		<div class="btn btn-outline-success btn-file">
			<i class="fa fa-paperclip"></i>
			<input type="file" name="attachment"/>			
		</div>
		<button class="btn btn-site" id="commentSubmitBtn">Post</button>
	</form>

</script>

<script type="text/template" id="post-comment-tmp-child">
<form onsubmit="ajaxSubmitChild(this, event, '{PARENT_COMMENT_ID}')">

<textarea class="form-control mb-3" name="comment" id="comment-input-child" rows="3" placeholder="Reply" onkeypress="check_key(event, '{PARENT_COMMENT_ID}')"></textarea>

<input type="hidden" name="project_id" value="<?php echo $project_id; ?>"/>

<input type="hidden" name="parent_id" value="{PARENT_COMMENT_ID}"/>
<div class="btn btn-outline-success btn-file">
	<i class="fa fa-paperclip"></i>
	<input type="file" name="attachment"/>
</div>
<button class="btn btn-site" id="submit-cmnt-btn-child">Post</button>
</form>
</script>


<script>



function ajaxSubmit(f, e){

	e.preventDefault();
	
	var $submit_btn = $(f).find('button');
	

	var cmnt_inp = $('#comment-input').val();

	if(cmnt_inp.trim() == ''){

		return;

	}
	
	/* var fdata = $(f).serialize(); */
	var fdata = new FormData($(f)[0]);
	
	showLoader($submit_btn, 'sm', 20);
	
	$submit_btn.attr('disabled', 'disabled');
	
	$.ajax({

		url : '<?php echo base_url('jobdetails/post_comment_ajax')?>?type=project_comment',

		data: fdata,

		dataType: 'json',
		
		contentType: false,
		processData: false,

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
				
				html = html.replace(/{ATTACHMENT}/g, res.data.attachment);

				

				$('ul.comment-list').not('.child').prepend(html);

				

				resetCommentForm();

			} 

			

		}

	});

}



function ajaxSubmitChild(f, e, parent){

	e.preventDefault();

	

	var cmnt_inp = $('#reply_comment_form_'+parent).find('#comment-input-child').val();

	

	if(cmnt_inp.trim() == ''){

		return;

	}

	var $submit_btn = $(f).find('button');

	var fdata = new FormData($(f)[0]);
	
	showLoader($submit_btn, 'sm', 20);
	
	$submit_btn.attr('disabled', 'disabled');

	$.ajax({

		url : '<?php echo base_url('jobdetails/post_comment_ajax')?>?type=project_comment',

		data: fdata,

		dataType: 'json',

		type: 'POST',
		contentType: false,
		processData: false,

		success: function(res){

			

			if(res && res.status == 1){

				var html = $('#comment-list-item-tmp-child').html();

				

				html = html.replace(/{COMMENT_ID}/g, res.data.comment_id);

				html = html.replace(/{NAME}/g, res.data.name);

				html = html.replace(/{AVATAR}/g, res.data.avatar);

				html = html.replace(/{COMMENT}/g, res.data.comment);

				html = html.replace(/{DATE}/g, res.data.date);

				html = html.replace(/{USER_ID}/g, res.data.user_id);
				
				html = html.replace(/{ATTACHMENT}/g, res.data.attachment);

				

				$('#reply_comments_'+parent).append(html);

				var input_html = $('#post-comment-tmp-child').html();
				
				input_html = input_html.replace(/{PARENT_COMMENT_ID}/g, parent);
				
				$('#reply_comment_form_'+parent).html(input_html);

				/* $('#reply_comment_form_'+parent).find('#comment-input-child').val(''); */

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


</script>
