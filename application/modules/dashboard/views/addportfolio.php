
<script type="text/javascript">
/* function editFormPost(){
FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/checkportfolioedit",'addport_frm');
}
function addFormPost(){ 
FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/checkportfolio",'addport_frm');
} */

</script>       
<script src="<?=JS?>mycustom.js"></script>

<section class="sec">
<div class="container">

  <div class="row">
     <?php //echo $leftpanel;?> 
    <div class="col-md-8 offset-md-2 col-12">    
    <?php echo $breadcrumb;?>                       
	<a href="<?php echo base_url('dashboard/profile_professional');?>" class="pull-right btn btn-site" style="margin-bottom:10px"><i class="zmdi zmdi-long-arrow-left"></i> <?php echo __('dashboard_addportfolio_back_to_profile','Back to profile'); ?></a>
    <?php if($this->uri->segment(3)){ ?>
    <h4 class="title-sm"><?php echo __('dashboard_addportfolio_edit_portfolio','Edit Portfolio'); ?></h4>
    <?php }else{ ?>
    <h4 class="title-sm"><?php echo __('dashboard_addportfolio_add_portfolio','Add Portfolio'); ?></h4>	
    <?php } ?>
    
    <div class="clearfix"></div>		
    <div class="card">
    <div class="card-body">
    <div class="success alert-success alert" style="display:none"><?php echo __('dashboard_addportfolio_your_message_has_been_sent_successfully','Your message has been sent successfully.'); ?></div>    
    <span id="agree_termsError" class="error-msg2" style="display:none"></span>
        
    
    <form onsubmit="dashboard.savePortfolio(this, event)" id="addport_frm" class="form-horizontal" role="form">
	<input type="hidden" readonly="readonly" class="form-control"  value="<?php if($this->uri->segment(3)){echo $this->uri->segment(3);} ?>" name="pid" id="pid" />
    <div class="form-group">
    	<label><?php echo __('dashboard_addportfolio_title','Title'); ?> : </label>
        <input type="text" class="form-control" size="30" value="<?php if($this->uri->segment(3)){echo $title;} ?>" name="title" id="title" tooltipText="Enter Title" /> 
    <span id="titleError" class="error-msg2"></span>
    </div>
    <div class="form-group">
    <label><?php echo __('dashboard_addportfolio_description','Description'); ?> :</label>
        <textarea class="form-control" name="description" id="description" rows="3" style="min-width:56%" ><?php if($this->uri->segment(3)){echo $description;} ?></textarea>
    <span id="descriptionError" class="error-msg2"></span>
    </div>
    
    <div class="form-group">        
        <label><?php echo __('dashboard_addportfolio_tags','Tags'); ?></label>
            <input type="text" class="form-control" size="30" name="tags"  id="tags" value="<?php if($this->uri->segment(3)){echo $tags;} ?>"  /> 
            <span id="tagsError" class="error-msg2"></span>
    </div>
    
    <div class="form-group">
            <label><?php echo __('dashboard_addportfolio_url','URL'); ?></label>
            <input type="text" class="form-control" size="30" name="url" id="url"  value="<?php if($this->uri->segment(3)){echo $url;} ?>" />  
            <span id="urlError" class="error-msg2"></span>
    </div>
    
    <div class="form-group">
    <label><?php echo __('dashboard_addportfolio_portfolio','Portfolio'); ?> :</label>
    <div class="clearfix"></div>
    <img id="uploded_img" src="<?php if($this->uri->segment(3)){echo VPATH."assets/portfolio/".$thumb_img;} ?>" alt="" class="img-thumbnail"/> 
    <span id="img_name"> <?php if($this->uri->segment(3)){echo"(". $thumb_img .")";} ?> </span>
	 <span id="original_imgError" class="error-msg2"></span>
	 <span id="userfileError" class="error" style="color:red;"></span>
    <div class="masg2">        
    <div class="input-group" style="margin-bottom:8px">
		<input type="hidden" name="original_img"  id="original_img_name" value="<?php if($this->uri->segment(3)){echo $original_img;} ?>"/>
		<input type="hidden" name="thumb_img" id="thumb_img_name" value="<?php if($this->uri->segment(3)){echo $thumb_img;} ?>"/>
        <div class="input-group-prepend">
        <label class="btn btn-warning input-group-btn">
           
                <?php echo __('dashboard_addportfolio_browse','Browse'); ?>&hellip; <input type="file" class="form-control" size="30" name="userfile" id="userfile"onchange="dashboard.uploadPortfolioFile(this)" style="display: none;" multiple>
           
        </label>
        </div>
        <input type="text" class="form-control" readonly>
    </div>       
       
    </div>
    <img id="loading" src="<?php echo VPATH;?>assets/images/loading.gif" style="display:none;margin:10px;">
   <p class="text-danger">jpg, png , and jpeg files are allowed.</p> 
    </div>
    <div class="masg3" >
    <input class="btn btn-site" type="submit" id="submit-check" value="<?php echo __('dashboard_addportfolio_submit','Submit'); ?>" />    
    </div>
    </form>      
    </div>
    </div>
    </div>
	
	</div>                          
</div>                               
</section>		 
<?php 
 $script_url="";
 if($this->uri->segment(3)){
   $script_url=VPATH."dashboard/uploadportfolio_edit/";
 } 
 else{ 
   $script_url=VPATH."dashboard/uploadportfolio/";
 }

?>

<script>
   
 function movefile(evt){ 
     
    var n=document.getElementById('userfile').files[0];         
      // $("#loading").show();
        $.ajaxFileUpload({
            url:'<?php echo $script_url;?>',
            secureuri:false,
            fileElementId:'userfile',
            dataType: 'json',
            data:{name:n.name, id:$("#pid").val()},
            success: function (data){
                $("#pid").val(data.pid);
                $("#img_name").text("("+data.msg+")");
                $("#uploded_img").attr("src","<?php echo VPATH."assets/portfolio/"?>"+data.msg);
                
                
		//$("#loading").hide();
               // window.location.href="<?php echo VPATH;?>dashboard/editportfolio";                
            }
    });
     
  }    
	</script>	
	
	
	<script>

var dashboard = (function($){
	
	
	var PORTFOLIO_PATH = '<?php echo base_url('assets/portfolio')?>/';
	
	var ret = {};
	
	ret.savePortfolio = function(form, evt){
		$('.error-msg2').empty();
		evt.preventDefault();
		var fdata = $(form).serialize();
		$('#submit-check').attr('disabled', 'disabled');
		$.ajax({
			url: '<?php echo base_url('dashboard/save_new_portfolio');?>',
			data: fdata,
			type: 'POST',
			dataType: 'json',
			success: function(res){
				if(res.status == 0){
					for(var i in res.errors){
						$('#'+i+'Error').html(res.errors[i]);
					}
				}else{
					location.href = '<?php echo base_url('dashboard/editportfolio')?>';
				}
				$('#submit-check').removeAttr('disabled');
			}
		});
		
	};
	
	ret.uploadPortfolioFile = function(ele){
		var file = $(ele)[0].files[0];
		var allowed_file_types = ["image/jpg", "image/jpeg", "image/png"];
		if(allowed_file_types.indexOf(file.type) == -1){
			$('#userfileError').html('<p>The filetype you are attempting to upload is not allowed.</p>');
			return;
		}else{
			$('#userfileError').html('');
		}
		
		if(file){
			$('.error').empty();
			var fdata = new FormData();
			fdata.append('userfile', file);
			$('#loading').show();
			$.ajax({
				url : '<?php echo base_url('dashboard/updatePortfolioFile')?>',
				data: fdata,
				type: 'POST',
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(res){
					$('#loading').hide();
					if(res.status == 1){
						$('#original_img_name').val(res.data.original_img);
						$('#thumb_img_name').val(res.data.thumb_img);
						$('#uploded_img').attr('src', PORTFOLIO_PATH + res.data.thumb_img);
						$('#img_name').html(res.data.original_img);
					}else{
						for(var i in res.error){
							$('#'+i+'Error').html(res.error[i]);
							$('#original_img_name').val('');
							$('#thumb_img_name').val('');
						}
					}
				}
				
			});
		}
	};
	
	return ret;
	
	
})(jQuery);

</script>