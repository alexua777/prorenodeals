<div id="user-document-ajax-wrapper">
<style>
#add_document_form {
    margin-top: 20px;
	display:none;
}
</style>
<?php
$doc_types = get_results(
	array(
		'select' => '*',
		'from' => 'document_type',
		'where' => array('status' => STATUS_ACTIVE)
	)
);

$doc_type_by_index = array();
foreach($doc_types as $k => $v){
	$doc_type_by_index[$v['document_type_id']] = $v['name'];
}
?>

<p>Documents </p>


<ul class="doc-list">
<?php if($documents){foreach($documents as $k => $v){
$status = $status_cls = '';
		if($v['status'] == STATUS_PENDING){
			$status = 'Pending';
			$status_cls = 'warning';
		}else if($v['status'] == STATUS_APPROVE){
			$status = 'Approved';
			$status_cls = 'success';
		}else if($v['status'] == STATUS_REJECT){
			$status = 'Rejected';
			$status_cls = 'danger';
		}	
$file_url = base_url('assets/uploaded/'.$v['file_name']); 
?>

	<li>
		<div class="upload-wrapper mb-3" id="file_<?php echo $v['id']; ?>">		
        <span class="badge badge-pill badge-success"><?php echo !empty($doc_type_by_index[$v['document_type']]) ? $doc_type_by_index[$v['document_type']] : 'Unknown'; ?></span><br />
        <span class="badge badge-pill badge-<?php echo $status_cls; ?>"><?php echo $status; ?></span><br />

		
		<a href="<?php echo $file_url;?>" target="_blank" title="view file"><img src="<?php echo $file_url;?>" alt="" /></a>
        <p><?php if($auth){ ?>
		<a href="javascript:void(0)" class="red-text" onclick="removeFile('<?php echo $v['id']; ?>', <?php echo $v['id']; ?>)"><i class="icon-feather-trash"></i></a>
		<?php } ?> <?php echo $v['org_file_name'];?></p>
		</div>
	</li>


<?php } } ?>
</ul>
<?php if($auth){ ?>

<button class="btn btn-site" onclick="$('#add_document_form').toggle();">Add Document</button>

<form id="add_document_form">
	
	<div class="form-group">
		<label>Document Type</label>
		<select class="form-control" name="document_type">
			<?php print_select_option($doc_types, 'document_type_id', 'name'); ?>
		</select>
	</div>

	<div class="form-group">
		<label>Document File</label>
        
		<div class="uploadButton">
			<input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple onchange="uploadFiles(this);"/>
            <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
		</div>
	</div>
	
	<div id="uploaded_files"></div>
	<button class="btn btn-site">Submit</button>
</form>


<?php } ?>




<script>
/* --------------------------------------------------------------
	MULTIPLE FILE UPLOAD
--------------------------------------------------------------  */


 function uploadFiles(ele){
	var files = ele.files;
	if(files.length > 0){
		for(i=0; i < files.length; i++){
			uploadOne(files[i] , i);
		}
	}
	$('#file_chooser').html('<input type="file" name="file[]" multiple="" style="position: absolute; cursor: pointer; top: 0px; width: 66px; height: 28px; left: 0px; z-index: 100; opacity: 0;" onchange="uploadFiles(this);">');
 }


 
function removeFile(index, doc_id){
	$('#file_'+index).remove();
	if(doc_id > 0){
		$.ajax({
			url : '<?php echo base_url('dashboard/remove_doc');?>',
			data: {id: doc_id},
			type: 'POST',
			success: function(res){
				if(res == 1){
					
				}
				
			}
		});
	}
}

 function uploadOne(file , ind){
	var formdata = new FormData();
	formdata.append('file', file);
	/* formdata.append('cmd', 'save_as_document'); */
	var file_name = file.name;
	
	var u_key = new Date().getTime()+'_'+ind;
	var html = ' <div class="uploaded_wrapper" id="file_'+u_key+'"> <div class="row"><div class="col-sm-6"><b>'+file_name+'</b></div><div class="col-sm-6 text-right"><div id="progress_'+u_key+'"><div class="progress"><div class="progress-bar" role="progressbar" id="progress_bar_'+u_key+'" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%;"> 0 % </div></div></div></div></div></div>';
	
	$('#uploaded_files').append(html);

	$.ajax({
		xhr: function() {
		var xhr = new window.XMLHttpRequest();
		xhr.upload.addEventListener("progress", function(evt) {
		  if (evt.lengthComputable) {
			var percentComplete = evt.loaded / evt.total;
			percentComplete = parseInt(percentComplete * 100);
			
			
			$('#progress_bar_'+u_key).css("width" , percentComplete + '%');
			$('#progress_bar_'+u_key).html(percentComplete + '%');
			

		  }
		}, false);

		return xhr;
	  },
		url : '<?php echo base_url('dashboard/upload_file')?>',
		type: 'POST',
		data : formdata,
		dataType: 'json',
		contentType: false,
		processData: false,
		success: function(res){
			if(res['result'] == 1){
				var file_obj = {
					file_name:  res['file_name'],
					org_file_name:  res['org_file_name']
				}
				var json_string = JSON.stringify(file_obj);
				 var html = '<input type="hidden" name="uploaded_files[]" value=\''+json_string+'\'/>';
				/* $('#file_'+u_key).append(html); */
				$('#progress_'+u_key).html('<a href="javascript:void(0)" class="red-text" onclick="removeFile(\''+u_key+'\', '+res['doc_id']+')"><i class="zmdi zmdi-delete"></i></a> '+html); 
			}else{
				var html = '<p style="color:red">'+res['error']+'</p>';
				$('#progress_'+u_key).html(html + ' <a href="javascript:void(0)" class="red-text" onclick="removeFile(\''+u_key+'\')"><i class="zmdi zmdi-delete"></i></a>');
			}
		}
	});

}

$('#add_document_form').submit(function(e){
	e.preventDefault();
	var f_data = $(this).serialize();
	var len = $(this).find('[name="uploaded_files[]"]').length;
	if(len == 0){
		$.alert({
			title: 'Error!',
			content: 'Please upload document file',
		});
		
		return;
	}else{
		
		
		$.ajax({
			url : '<?php echo base_url('dashboard/save_user_document');?>',
			data: f_data,
			type: 'POST',
			dataType: 'json',
			success: function(res){
				if(res.status == 1){
					refresh_doc();
				}
			}
			
		});
		
	}
	
	
});

function refresh_doc(){
	$('#add_document_form').off('submit');
	
	var $el =  $('#user-document-ajax-wrapper'),
	$container = $el.parent();
	var url = '<?php echo base_url('dashboard/load_ajax?page=user_document'); ?>';
	load_ajax_url(url, $container);
}
</script>
</div>