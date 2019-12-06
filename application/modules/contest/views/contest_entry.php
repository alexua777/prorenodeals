<style type="text/css">
.input-file input[type=file] {
	opacity: 0;
	position: absolute;
	top: 0px;
	left: 0px;
	height: 100%;
	width: 100%;
	z-index: 10;
	cursor: pointer;
}
.file-dropper {
	position: relative;
	height: 100px;
	padding: 10px;
	border: 1px dashed #ddd;
	margin-bottom: 15px;
}
input.invalid, select.invalid, textarea.invalid {
	border: 1px solid red;
	border-bottom: 2px solid red;
}
.images_list {
}
.images_list .list-container {
	height: 100px;
	width: 100px;
	float: left;
	border: 1px dashed #ddd;
	margin: 10px 10px;
	position: relative;
	background: white;
}
.images_list .list-container .progress {
	margin: 35px 5px;
}
.images_list .list-container img {
	height: 100px;
	width: 100px;
}
.images_list .list-container .remove {
	position: absolute;
	height: 25px;
	width: 25px;
	background: black;
	color: white;
	text-align: center;
	border-radius: 50%;
	padding: 5px 9px;
	right: 3px;
	top: 3px;
	opacity: 0.6;
	cursor: pointer;
	font-size: 13px;
}
</style>
<section class="sec dashboard">
<div class="container">

  <div class="row">
    <aside class="col-sm-8 col-xs-12">
	<?php
	$succ_msg = get_flash('succ_msg');
	if(!empty($succ_msg)){
	?>
	<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success!</strong> <?php echo $succ_msg; ?>
	</div>
	<?php } ?>
      <div class="whiteBg shadow_1 p-15">
      <div class="btn-group btn-group-justified" data-toggle="buttons">
        <label class="btn btn-default active">
          <input type="radio" name="entry_type" value="1" checked="checked">
          I want to submit an entry right away </label>
        <label class="btn btn-default">
          <input type="radio" name="entry_type" value="2">
          I am participating in this contest </label>
      </div>
      <br>
      <form id="entry-form" onsubmit="ajaxSubmit(this, event)">
        <div class="form-group">
          <label>Entry title: </label>
          <input type="text" name="title" class="form-control" placeholder="What is the entry title ?">
        </div>
        <div class="form-group">
          <label>Describe your entry: </label>
          <textarea class="form-control" name="description" placeholder="Describe your entry, include important details" rows="6"></textarea>
        </div>
        <div class="form-group">
          <label>Licensed Content: </label>
          <div class="radio">            
              <input type="radio" class="magic-radio" name="licensed" id="licensed_1" value="1" checked="checked">
              <label for="licensed_1">This entry is entirely my own</label>
          </div>
          <div class="radio">            
              <input type="radio" class="magic-radio" name="licensed" id="licensed_2" value="2">
              <label for="licensed_2">This entry contains elements I did not create.</label>
          </div>
        </div>
        <label>Entry Sell Price: </label>
        <p>Enter the price you want to sell this entry for. If you don't win, the contest holder may still buy your entry at this price . </p>
        <div class="form-group input-group col-sm-6"> <span class="input-group-addon"><?php echo CURRENCY; ?></span>
          <input type="text" class="form-control" placeholder="" name="sale_price">
        </div>
        <div class="clearfix"></div>
        <h4>Promote my entry </h4>
        <table class="table">
          <tr>
            <td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" name="is_highlight" id="is_highlight" value="1"/><label for="is_highlight">&nbsp;</label></div></td>
            <td><span class="label label-info">HIGHLIGHT</span></td>
            <td>Hightlight your entry to make it visually stand out from the rest. </td>
            <td><b><?php echo CURRENCY.'&nbsp;'.CONTEST_ENTRY_HIGHLIGHT_PRICE;?> </b></td>
          </tr>
          <tr>
			<?php
			$is_sealed_contest = getField('is_sealed', 'contest', 'contest_id', $contest_id);
			?>
            <td><div class="checkbox m-0"><input type="checkbox" class="magic-checkbox" name="is_sealed" id="is_sealed" value="1" <?php echo $is_sealed_contest == 1 ? 'checked="checked" onclick="return false;"' : ''; ?>/><label for="is_sealed">&nbsp;</label></div></td>
			
            <td><span class="label label-primary">SEALED</span></td>
            <td><b>Seal</b> your entry to ensure your idea is unique. Only you and the contest holder will be able to view yor sealed entry.</td>
            <td><b>FREE</b></td>
          </tr>
        </table>
        <input type="hidden" name="contest_id" value="<?php echo $contest_id;?>"/>
        <div id="hidden_attachments"></div>
        <div class="form-group">
          <button class="btn btn-site">Post My Entry</button>
        </div>
      </form>
      
	  <form id="participate-form" style="display: none;">
        <div class="participate">
          <p>Note : This will notify contest holder that you will work on an entry and submit it before the contest ends.</p>
          <div class="form-group">
            <button class="btn btn-site" type="button" onclick="notifyHolder()">Submit</button>
          </div>
        </div>
      </form>
      </div>
    </aside>
    <aside class="col-sm-4 col-xs-12">
      <div class="whiteBg shadow_1 p-15">
      <div class="file-dropper-wrapper">
        <div class="file-dropper text-center">
          <div class="input-file">
            <h5>Add Files</h5>
            <input type="file" onchange="uploadFiles(this)">
            <button type="button" class="btn btn-site">Browse Your Files</button>
          </div>
        </div>
        <div class="images_list"> 
          
          <!--<div class="list-container">
						<div class="progress">
						  <div class="progress-bar" role="progressbar" aria-valuenow="70"
						  aria-valuemin="0" aria-valuemax="100" style="width:70%">
							70%
						  </div>
						</div>
					</div>
					
					<div class="list-container">
						<span class="remove">X</span>
						<img class="img-responsive" src="http://localhost/flance_v2/assets/images/11.jpg" alt="Card image cap">
					</div>--> 
          
        </div>
        <div class="clearfix"></div>
        <p>Please ensure you have read the contest brief and feedback left by the contest holder on the public clarification board. Support files types are : <b>JPG, PNG, GIF</b> . </p>
		<div id="attachmentsError" class="rerror"></div>
      </div>
      </div>
    </aside>
  </div>

</div>
</section>
<script type="text/javascript">
	
	$(document).ready(function(){

		$('input[name="entry_type"]').change(function(){

			var val = $(this).val();

			if(val == 1){

				$('#entry-form').show();
				$('#participate-form').hide();
				$('.file-dropper-wrapper').show();
			}else{

				$('#entry-form').hide();
				$('#participate-form').show();
				$('.file-dropper-wrapper').hide();

			}


		});

	});
	
	function ajaxSubmit(f, e){
		$('.invalid').removeClass('invalid');
		$('.rerror').empty();
		e.preventDefault();
		var fdata = $(f).serialize();
		$.ajax({
			url : '<?php echo base_url('contest/contest_entry_ajax')?>',
			data: fdata,
			dataType: 'json',
			type: 'POST',
			success: function(res){
				if(res.errors){
					for(var i in res.errors){
						var j = i;
						i = i.replace('[]', '');
						$('[name="'+i+'"]').addClass('invalid');
						$('#'+i+'Error').html(res.errors[j]);
					}
					
					var offset = $('.invalid:first').offset();
					
					if(offset){
						$('html, body').animate({
							scrollTop: offset.top
						});
					}
					
				}else{
					location.href='<?php echo base_url('contest/entries/'.$contest_id)?>';
				}
			}
		});
	}
	
	function uploadFiles(ele){
		var allowed_type = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
		var files = $(ele)[0].files;
		
		var fdata = new FormData();
		fdata.append('file', files[0]);
		
		if(allowed_type.indexOf(files[0]['type']) < 0){
			$('#attachmentsError').html('Please upload a valid file');
			return false;
		}else{
			$('#attachmentsError').html('');
		}
		
		var key = Date.now();
		
		//var html = '<li class="list-group-item" id="file_'+key+'"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">0% </span></div></div></li>';
		
		var html = '<div class="list-container" id="file_'+key+'"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="sr-only">0% </span></div></div></div>';
		
		$('.images_list').prepend(html);
		
		$.ajax({
			 xhr: function() {
				var xhr = new window.XMLHttpRequest();

				xhr.upload.addEventListener("progress", function(evt) {
				  if (evt.lengthComputable) {
					
					var percentComplete = evt.loaded / evt.total;
					percentComplete = parseInt(percentComplete * 100);
					$('#file_'+key).find('.progress-bar').css('width', percentComplete+'%').attr('aria-valuenow', percentComplete);
					$('#file_'+key).find('.sr-only').html(percentComplete+'%');

				  }
				}, false);

				return xhr;
			},
			url : '<?php echo base_url('contest/upload_attachment')?>',
			data: fdata,
			dataType: 'JSON',
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(res){
				if(res.status == 1){
					//html = res['data']['org_filename']+'<input type="hidden" name="attachment" value=\''+res['data']['file_str']+'\'/> <a href="javascript:void(0);" onclick="removeAttachment('+key+')" class="pull-right">[X]</a>';
					
					html = '<span class="remove" onclick="removeAttachment('+key+')">X</span><img class="img-responsive" src="'+res['data']['file_path']+res['data']['filename']+'" alt="">';
					
					var html2 = '<input type="hidden" class="file_input_'+key+'" name="attachments[]" value=\''+res['data']['file_str']+'\'/>';
					
					$('#file_'+key).html(html);
					
					$('#hidden_attachments').append(html2);
				}else{
					$('#file_'+key).html(res.errors['file']);
				}
			}
		});
		
	}
	
	function removeAttachment(key){
		$('#file_'+key).remove();
		$('.file_input_'+key).remove();
	}
	
	function notifyHolder(){
		var fdata = {contest_id : <?php echo $contest_id;?>};
		$.ajax({
			url : '<?php echo base_url('contest/notify_ajax')?>',
			data: fdata,
			dataType: 'json',
			type: 'POST',
			success: function(res){
				if(res.errors){
					for(var i in res.errors){
						var j = i;
						i = i.replace('[]', '');
						$('[name="'+i+'"]').addClass('invalid');
						$('#'+i+'Error').html(res.errors[j]);
					}
					
					var offset = $('.invalid:first').offset();
					
					if(offset){
						$('html, body').animate({
							scrollTop: offset.top
						});
					}
					
				}else{
					location.reload();
				}
			}
		});
	}

</script> 
