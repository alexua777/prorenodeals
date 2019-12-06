<link href="<?php echo ASSETS;?>plugins/marker/marker.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.css"/>
<script src="<?php echo ASSETS;?>plugins/rating/jquery.rateyo.js"></script>
<style>
hr {
    margin-top: 10px;
    margin-bottom: 10px;
   
}
</style>

<?php
$this->load->model('projectdashboard_new/projectdashboard_model');
$p_user_image = '';
$login_user_image = '';

if($entry_user_detail['logo']!=''){
	$p_user_image = base_url('assets/uploaded/'.$entry_user_detail['logo']) ;
if(file_exists('assets/uploaded/cropped_'.$entry_user_detail['logo'])){
	$p_user_image = base_url('assets/uploaded/cropped_'.$entry_user_detail['logo']) ;
}
}else{
	$p_user_image = base_url('assets/images/user.png'); 
}

$login_user_logo = getField('logo','user', 'user_id', $login_user_id);

if($login_user_logo!=''){
	$login_user_image = base_url('assets/uploaded/'.$login_user_logo) ;
if(file_exists('assets/uploaded/cropped_'.$login_user_logo)){
	$login_user_image = base_url('assets/uploaded/cropped_'.$login_user_logo) ;
}
}else{
	$login_user_image = base_url('assets/images/user.png'); 
}


$cityCountry = $this->projectdashboard_model->getCountryCityDetails_user($entry_user_detail['country'],$entry_user_detail['city']);
$p_fullname = $entry_user_detail['fname'].' '.$entry_user_detail['lname'];
$total_likes = $this->db->where(array('is_liked' => '1', 'entry_id' => $entry_detail['entry_id']))->count_all_results('entry_likes');
$is_user_liked = $this->db->where(array('is_liked' => '1', 'entry_id' => $entry_detail['entry_id'], 'user_id' => $login_user_id))->count_all_results('entry_likes');

$page_url = base_url('contest/entries/'.$entry_detail['contest_id']);
$fb_share_link = "https://www.facebook.com/sharer/sharer.php?u=$page_url";
$twt_share_link = "https://twitter.com/home?status=https%3A//www.facebook.com/sharer/sharer.php?u=$page_url";
$lnkdin_share_link = "https://www.linkedin.com/shareArticle?mini=true&url=https%3A//www.facebook.com/sharer/sharer.php?u=$page_url&title=contest&summary=&source=";

?>
<div class="row">
        	<aside class="col-sm-8">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                  <!-- Indicators -->
				  
                  <ol class="carousel-indicators">
				  <?php if(count($entry_files) > 0){foreach($entry_files as $k => $v){ ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $k;?>" class="<?php echo $k == 0 ? 'active' : '';?>"></li>
                  <?php } } ?>
                  </ol> 
                
                  <!-- Wrapper for slides -->
				 
                  <div class="carousel-inner" role="listbox">
					<?php if(count($entry_files) > 0){foreach($entry_files as $k => $v){ ?>
					 
					  <div class="item <?php echo $k == 0 ? 'active' : '';?> markerBox" data-item-id="<?php echo $v['entry_file_id']; ?>">
						  <img src="<?php echo  base_url('assets/attachments/'.$v['filename']); ?>" alt="<?php echo $p_fullname; ?> photos">                      
						</div>
					
					<?php } } ?>
                  </div>
				  
                
                  <!-- Controls 
                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev" style="background-image:none">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style="background-image:none">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>-->
                </div>
            </aside>
			
            <aside class="col-sm-4">
            	<div class="modal-header p-0 mb-15">
                    <button type="button" class="close" onclick="$('#entryModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
                    <p>&nbsp;</p>
                </div>
            	<div class="profile_pic pic-sm">
              		<span><img alt="" src="<?php echo $p_user_image;?>" class="img-circle"></span>
            	</div>
                <div class="pull-left">
					<h4><a href="<?php echo base_url('clientdetails/showdetails/'.$entry_user_detail['user_id']); ?>"><?php echo $p_fullname;?></a></h4>
                	 <p><img src="<?php echo ASSETS;?>images/cuntryflag/<?php echo !empty($cityCountry['Code2'])? strtolower($cityCountry['Code2']) : ''; ?>.png"> <span><?php echo !empty($cityCountry['city_name']) ? $cityCountry['city_name'] : ''; ?></span> , <?php echo !empty($cityCountry['Name'])? $cityCountry['Name'] : ''; ?></p>
            	</div>
                <div class="clearfix"></div>
                <h4><?php echo $entry_detail['title']; ?></h4>
                <p><?php echo $entry_detail['description']; ?></p>
                <hr />
				<?php if($login_user_id != $entry_detail['user_id']){ ?>
				<div>
					<div id="entry_rating" style="padding-bottom: 10px;"></div>
				</div>
				<hr />
				<?php } ?>
				<?php if(in_array($login_user_id, $allowed_users)){ ?>
				<div>
					<a href="javascript:void(0)" onclick="toggleMarker()">Add marker</a>
				</div>
				<hr/>
				<?php } ?>
				
                <div class="choose_favourite">
                  <a href="javascript:void(0)" class="pull-left <?php echo $is_user_liked > 0 ? 'active' : '';?>" onclick="toggleLike(this)" data-total-likes="<?php echo $total_likes; ?>" data-is-liked="<?php echo $is_user_liked; ?>" data-entry-id="<?php echo $entry_detail['entry_id']; ?>"><i class="zmdi zmdi-favorite zmdi-18x"></i> <span class="counter"><?php echo $total_likes; ?></span> Likes</a>
				  
                  <div class="pull-right"><i class="zmdi zmdi-share zmdi-18x"></i> Share:
					  <a href="<?php echo $fb_share_link; ?>" target="_blank"><i class="zmdi zmdi-facebook-box zmdi-18x"></i></a> 
					  <a href="<?php echo $twt_share_link; ?>" target="_blank"><i class="zmdi zmdi-twitter-box zmdi-18x"></i></a>
					  <a href="<?php echo $lnkdin_share_link; ?>" target="_blank"><i class="zmdi zmdi-linkedin-box zmdi-18x"></i></a>
                  </div>
				  
                  <div class="clearfix"></div>
                </div>
                <h4>Comments</h4>
				
				<div id="entry-comment-list">
					<!--  entry comments -->
					<?php if(count($entry_comments) > 0){foreach($entry_comments as $k => $v){ 
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
						<div id="entry_comment_item_<?php echo $v['comment_id']; ?>">
							<div class="media comment-box mt-0">
								<div class="media-left">
									<img src="<?php echo $logo; ?>" height="45" width="45" class=""/>
								</div>
								<div class="media-body">
									<p><a href="<?php echo base_url('clientdetails/showdetails/'.$v['user_id']);?>"><?php echo $v['user_info']['fname'].' '.$v['user_info']['lname']; ?></a><span class="pull-right"><?php echo date('d M, H:i A', strtotime($v['datetime'])); ?></span></p>
									<p class=""><?php echo $v['comment']; ?></p>
								</div>
							</div>
						</div>
						<?php } } ?>
						
				</div>
               
                <hr />
				
                <div class="media comment-box mt-0">
					<div class="media-left"><img src="<?php echo $login_user_image; ?>" height="64" width="64" class=""/></div>
					<div class="media-body">
						<div id="entry-comment-form-wrapper">
							
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
		          
            </aside>
			
        </div>
<script src="<?php echo JS;?>jquery.nicescroll.min.js"></script>
	
<script id="entry-comment-form" type="text/template">
	<form onsubmit="postCommentAjax(this, event)">
		<textarea class="form-control" name="comment" rows="3" placeholder="Write a comment" onkeypress="check_key_entry(event)"></textarea>
		<input type="hidden" name="entry_id" value="<?php echo $entry_detail['entry_id'];?>"/>
		<button id="entryCommentSubmitBtn" class="hidden">Send</button>
	</form>
</script>

<script type="text/template" id="comment-entry-item-tmp">
	<div class="media comment-box mt-0" id="entry_comment_item_{COMMENT_ID}">
		
		<div class="media-left">
			<img src="{AVATAR}" height="45" width="45" class=""/>
		</div>
		<div class="media-body">
			<p><a href="<?php echo base_url('clientdetails/showdetails');?>/{USER_ID}">{NAME}</a> <span class="pull-right">{DATE}</span></p>
			<p class="">{COMMENT}</p>
		</div>
		
	</div>
</script>

<script>
function postCommentAjax(f , e){
	e.preventDefault();
	
	var cmnt_inp = $(f).find('[name="comment"]').val();
	if(cmnt_inp.trim() == ''){
		return;
	}
	
	var fdata = $(f).serialize();
	$.ajax({
		url : '<?php echo base_url('contest/post_comment_ajax'); ?>?type=entry_comment',
		data: fdata,
		dataType: 'json',
		type: 'POST',
		success: function(res){
			
			if(res && res.status == 1){
				var html = $('#comment-entry-item-tmp').html();
				
				html = html.replace(/{COMMENT_ID}/g, res.data.comment_id);
				html = html.replace(/{NAME}/g, res.data.name);
				html = html.replace(/{AVATAR}/g, res.data.avatar);
				html = html.replace(/{COMMENT}/g, res.data.comment);
				html = html.replace(/{DATE}/g, res.data.date);
				html = html.replace(/{USER_ID}/g, res.data.user_id);
				
				$('#entry-comment-list').append(html);
				
				resetEntryCommentForm();
			} 
			
		}
	});
}

function resetEntryCommentForm(){
	var form = $('#entry-comment-form').html();
	$('#entry-comment-form-wrapper').html(form);
}

function check_key_entry(e){
	var key = e.which || '';
	if(key == 13){
		$('#entryCommentSubmitBtn').click();
		e.preventDefault();
	}
}

resetEntryCommentForm();
</script>



<script>
	
(function(){
	
	'use strict';
	
	var markerCount = 1;
	
	var CONFIG = {
		url : {
			save_marker: '<?php echo base_url('contest/save_marker')?>',
			save_comment: '<?php echo base_url('contest/save_marker_comment')?>',
			delete_marker: '<?php echo base_url('contest/delete_marker')?>',
			change_color: '<?php echo base_url('contest/change_marker_color')?>',
		},
		markerSize: 30,
		login_user: {
			user_id: <?php echo $login_user_id;?>,
			name: '<?php echo !empty($login_user_detail['name']) ? $login_user_detail['name'] : ''; ?>',
			logo: '<?php echo $login_user_image; ?>',
		},
		markerColor:[{className: 'dotBlue', color: '#29b6f6'}, {className: 'dotRed', color: '#f00'}, {className: 'dotGreen', color: '#0d0'}, {className: 'dotYellow', color: '#fd0'}],
		allowed_users: <?php echo json_encode($allowed_users); ?>
	};
	
	var is_enable_marker = false;
	
	var toggleMarker = function(){
		is_enable_marker = !is_enable_marker;
		if(is_enable_marker){
			$('.markerBox').addClass('markoverlay');
		}else{
			$('.markerBox').removeClass('markoverlay');
		}
	}
	
	window.toggleMarker = toggleMarker;
	
	var Marker = function(ele){
		
		var markerUnique = 'marker_'+markerCount;
		
		
		
		var marker_list = [] , _self = this;
		
		var next_marker_name = 1;
	
		var marker_class = 'marker';
		
		this.container = $(ele);
		this.container.attr('id', markerUnique);
		
		var ITEM_ID = this.container.data('itemId');
		this.ITEM_ID = ITEM_ID;
		/* attaching events to container */
		
		this.container.on('click', function(e){
			
			$('.popoverC').hide();
			$('.popoverC').data('isVisible', 0);
			
			if(!is_enable_marker){
				return false;
			}
			
			var pos = {};
			var c_height = $(this).height();
			var c_width = $(this).width();
			pos.posX = e.offsetX;
			pos.posY = e.offsetY;
			
			var marker_size = CONFIG.markerSize; 
			
			if(e.offsetY > marker_size){
				pos.posY  -= (marker_size/2);
			}else if(e.offsetY+marker_size > c_height){
				pos.posY -= (marker_size/2);
			}
			
			if(e.offsetX > marker_size){
				pos.posX  -= (marker_size/2);
			}else if(e.offsetX+marker_size > c_width){
				pos.posX -= (marker_size/2);
			}
			
			var c_marker = _self.add(pos);
			
			var post = JSON.parse(c_marker.getData());
			$.ajax({
				url : CONFIG.url.save_marker,
				data: post,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						c_marker.setId(res.data.marker_id);
						toggleMarker();
					}
				}
			});
			
		});
		
		markerCount++;
		
		this.add = function(p){
			
			var created_by = p.user_id || CONFIG.login_user.user_id;
			var color = '';
			
			if(CONFIG.markerColor.length > 0){
				for(var i=0; i < CONFIG.markerColor.length; i++){
					color += '<i class="fa fa-circle '+CONFIG.markerColor[i].className+'" style="color:'+CONFIG.markerColor[i].color+'" data-color="'+CONFIG.markerColor[i].color+'"></i>';
				}
			}
			
			var ele = $('<div class="'+marker_class+'">'+next_marker_name+'</div>');
			
			var inp_form = $('<input type="text" class="form-control input-sm" placeholder="Write your comment here"/>');

			var content_tmpl = $('<div class="comment_wrapper"></div>');
			var pop_header = $('<div class="pop_header"><span>Comments</span></div>');
			var pop_delete = $('<a href="#" title="Delete marker" class="delete"><i class="fa fa-trash"></i></a>');
			var pop_close = $('<a href="#" title="Close" class="close-c"><i class="fa fa-times-circle"></i></a>');
			var pop_color_picker = $('<div class="dotted">'+color+'</ul>');
			
			if(CONFIG.login_user.user_id == created_by){
				pop_header.append(pop_delete);
			}
			
			pop_header.append(pop_close);
			pop_header.append(pop_color_picker);
			
			pop_color_picker.on('click', 'i', function(e){
				var color = $(this).data('color');
				_self.setColor(color);
				pop_color_picker.find('i').removeClass('active');
				$(this).addClass('active');
				
			});
			
			pop_close.on('click', function(e){
				e.preventDefault();
				_self.pop.hide();
			});
			
			pop_delete.on('click', function(e){
				e.preventDefault();
				var c = confirm('Are you sure to delete this marker ? ');
				
				if(c){
					$.ajax({
						url : CONFIG.url.delete_marker,
							data: {marker_id : _self.content.marker_id, deleted_by: CONFIG.login_user.user_id},
							type: 'POST',
							dataType: 'json',
							success: function(res){
								if(res.status == 1){
									_self.destroy();
								}
							}
					});
				}
			});
			
			
			inp_form.on('keypress', function(e){
				if(e.which == 13){
					var value = inp_form.val();
					
					if(value == ''){
						return ;
					}
					inp_form.val('');
					
					var d = JSON.parse(_self.getData());
					if(d.marker_id !== null){
						
						var post = {};
						
						post.marker_id = d.marker_id;
						post.comment = value;
						
						$.ajax({
							url : CONFIG.url.save_comment,
							data: post,
							type: 'POST',
							dataType: 'json',
							success: function(res){
								if(res.status == 1){
									_self.addContent(value);
									content_tmpl.getNiceScroll().resize();
								}
							}
						});
						
					}
					
				}
			});
			
			var _self = {};
			
			_self.setColor =  function(color){
				
				var d = JSON.parse(_self.getData());
				
				if(d.marker_id !== null){
					$.ajax({
						url : CONFIG.url.change_color,
						data: {marker_id : d.marker_id, color: color},
						type: 'POST',
						dataType: 'json',
						success: function(res){
							if(res.status == 1){
								_self.content.color = color;
								$(_self.element).css('background-color', color);
							}
						}
					});
				}
				
			}; 
			
			_self.addContent = function(c){
				var comment = {
					comment_id : null,
					marker_id : p.marker_id || null,
					comment : c,
					datetime : new Date(),
					user_id : CONFIG.login_user.user_id || 0,
					user_detail : CONFIG.login_user || {},
				};
				_self.content.list.push(comment);
				
				_self.renderContent();
				
			};
			
			
			_self.renderContent = function(){
				var html = _self.content.toHtml();
				$(content_tmpl).html(html);
			};
			
			_self.setId = function(id){
				_self.content.marker_id = id;
			};
			
			_self.element = ele;
			_self.posX = p.posX;
			_self.posY = p.posY;
			_self.color =  p.color || CONFIG.markerColor[0].color;
			
			pop_color_picker.find('i[data-color="'+_self.color+'"]').addClass('active');
			
			_self.content = {
				item_id : ITEM_ID,
				marker_id: p.marker_id || null,
				editable : true,
				list : p.comments || [],
				name: p.name || next_marker_name,
				toHtml: function(){
					var html = '<ul>';
					var all_list = _self.content.list;
					if(all_list.length > 0){
						for(var i in all_list){
							var logo = '<div class="avatar"><img src="'+all_list[i].user_detail.logo+'" width="40" height="40"/></div>';
							var content = '<div class="avatar-details"><h5>'+all_list[i].user_detail.name+'</h5><p>'+all_list[i].comment+'</p></div>';
							
							var c = '<li>' + logo + content + '</li>';
							
							html += c;
						}
					}
					html += '</ul>';
					return html;
					
				}
			};
			
			_self.css = {
				'height': CONFIG.markerSize+'px',
				'width': CONFIG.markerSize+'px',
				'left' : _self.posX+'px',
				'top' : _self.posY+'px',
				'background-color' : _self.color,
			};
			
			
			$(_self.element).css(_self.css);
			
			$(_self.element).on('click', function(e){
				e.stopPropagation();
				
				if(_self.pop.isVisible()){
					_self.pop.hide();
				
				}else{
					_self.pop.show();
					content_tmpl.getNiceScroll().resize();
					
				}
				
			});
			
			
			next_marker_name++;
			
			var container = this.container;
			$(container).append(_self.element);
			
			_self.pop = new popOverC(this.container, _self);
			_self.pop.setContent(pop_header);
			_self.pop.setContent(content_tmpl);
			_self.pop.setContent(inp_form);
			$(inp_form).wrap('<div class="input-wrapper"></div>');
			_self.pop.show();
			
			_self.renderContent();
			content_tmpl.niceScroll();
			
			_self.getData = function(){
				
				var c = _self.content;
				
				c.posX = _self.posX;
				c.posY = _self.posY;
				
				return JSON.stringify(c);
				
			};
			
			_self.destroy = function(){
				$(_self.element).remove();
				_self.pop.destroy();
			};
			return _self;
		};
		
		this.load = function(){
			var _self = this;
			if(marker_list.length > 0){
				for(var i in marker_list){
					_self.add(marker_list[i]);
				}
			}
			
		};
		
		this.getMarker = function(){
			
			return marker_list;
			
		};
		
		
	};
	
	
	
	function popOverC(parent, ele){
		
		var _self = this;
		var extra_distance = 10;
		
		var p_width = $(parent).width();
		var p_height = $(parent).height();
		var pos_cls = 'leftTop';
		this.className = 'popoverC';
		this.unique_id =  'popoverC_item_' + $('.'+this.className).length + 1;
		this.element = $('<div class="'+this.className+'" data-is-visible="1"></div>');
		
		this.isVisible = function(){
			var v = $(this.element).data('isVisible');
			
			return v == 1;
		}
		
		this.element.attr('id', this.unique_id);
		
		this.posX = null; 
		this.posY = null; 
		this.width = 300;
	
		
		var ele_left = parseFloat(ele.posX);
		var ele_top = parseFloat(ele.posY);
		var ele_width = $(ele.element).width();
		var ele_height = $(ele.element).height();
		
		ele_left += (ele_width + extra_distance);
		
		this.posX = ele_left;
		this.posY = ele_top;
		
		if((this.posX + ele_width + this.width) > p_width){
			this.posX -= (this.width+ele_width+(extra_distance*2));
			pos_cls = 'rightTop';
		}
	
		
		var css = {
			'width': this.width+'px',
			'left' : _self.posX,
			'top' : _self.posY,
		};
		
		this.element.css(css);
		
		
		
		this.setContent = function(content){
			_self.element.append(content);
		};
		
		this.setParent = function(ele){
			this.parent = ele;
		};
		
		this.getId = function(){
			return this.unique_id;
		};
		
		this.show = function(){
			this.hideAll();
			$(this.element).show();
			$(this.element).data('isVisible', '1');
			
			this.recalculateCss();
			
		};
		
		this.recalculateCss = function(){
			var p_height = $(parent).height();
			var p_width = $(parent).width();
			
			var e_height = $(this.element).height() - ele_height;
			
			var arrow_cls = 'leftTop';
			
			var pos_Y = this.posY;
			
			if((pos_Y + e_height) > p_height){
				pos_Y -= (e_height);
				arrow_cls = 'leftBottom';
				
				if((ele_left + ele_width + this.width) > p_width){
					arrow_cls = 'rightBottom';
				}
			
			}else{
				if((ele_left + ele_width + this.width) > p_width){
					arrow_cls = 'rightTop';
				}
			}
			
			var css = {
				'top' : pos_Y,
			};
			
			
			this.element.removeAttr('class');
			var  cls = this.className;
			cls += ' ' + arrow_cls; 
			this.element.addClass(cls);
			
			this.element.css(css); 
			
		
		};
		
		this.hide = function(){
			$(this.element).hide();
			$(this.element).data('isVisible', '0');
		};
		
		this.hideAll = function(){
			$('.'+this.className).hide();
			$('.'+this.className).data('isVisible', '0');
			
		};
		
		this.destroy = function(){
			$(this.element).remove();
		};
		
		$(this.element).on('click', function(e){
			e.stopPropagation();
		});
		
		$(parent).append(this.element);
		this.element.addClass(pos_cls);
		
	}
	
	window.Marker = Marker;

})();


(function(){
	
	
	$("#entry_rating").rateYo({
		normalFill: "#ddd",
		ratedFill: "#0d0",
		rating    : <?php echo !empty($given_rating['rating']) ? $given_rating['rating'] : 0 ?>,
		fullStar: true,
		starWidth: "20px",
		spacing: "5px",
		onSet: function (rating, rateYoInstance) {
			var post = {
				rating: rating,
				entry_id: '<?php echo $entry_detail['entry_id']; ?>',
			};
			$.ajax({
				url : '<?php echo base_url('contest/save_rating')?>',
				data: post,
				dataType: 'json',
				type: 'POST',
				success: function(res){
					if(res.status == 1){
						console.log('Saved');
					}
				}
			});
		}
	});
	
	<?php if(in_array($login_user_id, $allowed_users)){ ?>
	var markerList = [];
	var all_markers = <?php echo json_encode($entry_markers);?>;	
	$('.markerBox').each(function(){
		
		var m = new Marker($(this));
		markerList[m.ITEM_ID] = m;
		
	});

	if(Object.keys(all_markers).length > 0){
		for(var i in all_markers){
			
			var marker_one = all_markers[i];
			
			if(marker_one.length > 0){
				for(var j=0; j<marker_one.length; j++){
					markerList[i].add(marker_one[j]);
				}
			}
			
		}
		$('.popoverC').hide();
	}

	<?php }  ?>
	
})();	

	
</script>