<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<script src="<?php echo JS;?>formValidation.js"></script>
<script src="<?php echo JS;?>bootstrap.validate.js"></script>
<link rel="stylesheet" href="<?php echo ASSETS;?>plugins/chosen/chosen.min.css" type="text/css" />
<script src="<?php echo ASSETS;?>plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<style>
.item.selected {
	background-color: #e2dfdf;
}
.invalid {
	border: 1px solid red;
}
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
<?php $lang=$this->session->userdata('lang'); ?>
<section id="mainpage">
  <div class="container-fluid">
    <div class="row">
      <?php $this->load->view('dashboard/dashboard-left'); ?>
      <aside class="col-lg-10 col-md-9 col-12">
      <?php echo $breadcrumb;?>
        <div class="alert alert-success text-center" style="display:none;"><i class="fa fa-check-circle"></i> Your message has been sent successfully.</div>
        <?php
			$attributes = array('id' => 'postjob_frm','class' => 'form-horizontal','role'=>'form','name'=>'postjob_frm','onsubmit'=>"disable",'enctype'=>'multipart/form-data');
			echo form_open('', $attributes);
			?>
        <?php /*?><h3 class="form-title" id="post_job_title"><?php echo __('postjob_post_your_job','Post Your Job'); ?>:</h3><?php */?>
        <div class="post-form"> <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span> <span id="limit_termsError" class="rerror error alert-error alert" style="display:none"></span> <span id="job_det">
          <div class="form-group hidden">
            <label for=""><?php echo __('postjob_experience_level','Experience level'); ?>:</label>
            <?php
				$exp_levels = get_results(array('select' => '*', 'from' => 'experience_level', 'where' => array('status' => 'Y')));
				
				if(count($exp_levels) > 0){foreach($exp_levels as $k => $v){ 
				?>
            <div class="checkbox radio-inline">
              <input class="magic-radio" type="radio" name="exp_level" data-text="<?php echo $v['name'];?>" value="<?php echo $v['id'];?>" id="exp_level_<?php echo $v['id'];?>"  <?php echo $k == 0 ? 'checked="checked"' : '';?>>
              <label title="<?php echo $v['description']; ?>" for="exp_level_<?php echo $v['id'];?>"> <?php echo $v['name'];?> <a href="javascript:void(0)" rel="infopop" data-toggle="popover" title="" data-placement="right" data-content="<?php echo $v['description']; ?>" data-original-title="<?php echo $v['name']; ?>"><i class="fa fa-lg fa-info-circle"></i></a> </label>
            </div>
            <?php } } ?>
          </div>
          <div class="form-group">
            <label for=""><?php echo __('postjob_project_title','Project Title'); ?>:</label>
            <input type="text" class="form-control" value="" name="title" id="title">
            <span id="titleError" class="error-msg13 rerror"></span>
          </div>
          
          <div class="form-group">
            <label for=""><?php echo __('postjob_description_your_project_in_details','Describe Your Project in Detail'); ?>:</label>
            <textarea class="form-control" rows="5" name="description" id="description"></textarea>
            <span id="descriptionError" class="error-msg13 rerror"></span>
          </div>
          
          <div class="form-group">
            <label for=""><?php echo __('postjob_attachment','Attachment'); ?>:</label>
            <div class="drop btn-file"> <?php echo __('postjob_drag_and_drop_files_here','Drag &amp; Drop Files Here'); ?>
              <input type="file" multiple id="userfile" name="userfile" onchange="movefile(this)">
            </div>
            <input type="hidden" id="upload_file" name="upload_file" value="">
            <div style="display: none;" id="flist_div"></div>
          </div>
          <div class="form-group">
            <?php 
			$skill = $this->db->order_by('skill_name', 'asc')->get('skills')->result_array();
			?>
            <label class="d-block"><?php echo __('postjob_select_skills','Select Skill'); ?>: </label>
            <select class="form-control inputtag" name="subskill[]" data-placeholder="Choose skills" multiple>
              <?php if(count($skill) > 0){foreach($skill as $k => $v){ ?>
              <option value="<?php echo $v['id'];?>"><?php echo $v['skill_name'];?></option>
              <?php } } ?>
            </select>
            <span id="subskill_idError" class="error-msg13 rerror"></span> </div>
          <div class="form-group hide">
            <div class="col-sm-4 col-12">
              <p><?php echo __('postjob_project_environment','Project Environment'); ?>:</p>
              <div class="checkbox radio-inline">
                <input class="magic-radio" type="radio" name="environment" value="ON" id="1" checked>
                <label for="1"> <?php echo __('postjob_online','Online'); ?></label>
              </div>
              <div class="checkbox radio-inline">
                <input class="magic-radio" type="radio" name="environment" id="2" value="OFF">
                <label for="2"> <?php echo __('postjob_offline','Offline'); ?></label>
              </div>
            </div>
            <div class="col-sm-4 col-12">
              <p><?php echo __('postjob_project_visibility','Project Visibility'); ?>:</p>
              <div class="radio radio-inline">
                <input class="magic-radio" type="radio"  name="visibility" value="Public" id="3" checked>
                <label for="3"> <?php echo __('postjob_public','Public'); ?> <a href="javascript:void(0)" rel="infopop" data-toggle="popover" title="" data-placement="right" data-content="Public projects will be visible to all users" data-original-title="Public"><i class="fa fa-lg fa-info-circle"></i></a> </label>
              </div>
              <div class="radio radio-inline">
                <input class="magic-radio" type="radio" name="visibility" id="4" value="Private">
                <label for="4"> <?php echo __('postjob_private','Private'); ?> <a href="javascript:void(0)" rel="infopop" data-toggle="popover" title="" data-placement="right" data-content="Private project will only visible to users you will invite." data-original-title="Private"><i class="fa fa-lg fa-info-circle"></i></a> </label>
              </div>
            </div>
            <div class="col-sm-4 col-12 hide">
              <p><?php echo __('postjob_project_type','Project Type'); ?>:</p>
              <div class="radio radio-inline">
                <input class="magic-radio" type="radio" name="project_type" value="F" id="5" checked>
                <label for="5"> <?php echo __('postjob_fixed','Fixed'); ?></label>
              </div>
              <div class="radio radio-inline">
                <input class="magic-radio" type="radio" name="project_type" value="H" id="6">
                <label for="6"> <?php echo __('postjob_hourly','Hourly'); ?></label>
              </div>
            </div>
          </div>
          <div class="row" id="hourly_budget" style="display:none;">
            <div class="col-6">
              <label for=""><?php echo __('postjob_minimum_budget','Minimum Budget'); ?></label>
              <div class="input-group">
              <span class="input-group-text"><?php echo CURRENCY; ?></span>
                <input type="text" class="form-control" name="budget_min" value="5" placeholder="Minimum budget should be greater than 5"/>
              </div>
              <span id="budgetminError" class="error-msg13 rerror"></span> </div>
            <div class="col-6">
              <label for=""><?php echo __('postjob_maximum_budget','Maximum Budget'); ?></label>
              <div class="input-group"> <span class="input-group-addon"><?php echo CURRENCY; ?></span>
                <input type="text" class="form-control" name="budget_max" placeholder="Maximum budget should be greater than minimum budget" value=""/>
              </div>
              <span id="budgetmaxError" class="error-msg13 rerror"></span> </div>
            <div class="login_form logi_width multi_freelancer" style="display: none;">
              <p><?php echo __('postjob_multi_freelancer','Multi-freelancer'); ?> :<span style="color:#F00">*</span></p>
              <input type="radio" name="multi_freelancer" class="acount-radio2" value="Y" checked="checked" onchange="getMulti(this.value)">
              <?php echo __('postjob_yes','Yes'); ?>
              <input type="radio" name="multi_freelancer" class="acount-radio2" value="N" onchange="getMulti(this.value)">
              <?php echo __('postjob_no','No'); ?> <span id="multi_freelancerError" class="error-msg13 rerror"></span> </div>
            <div class="col-6">
              <label for=""><?php echo __('postjob_number_of_freelancer','Number Of Freelancer'); ?></label>
              <input type="text" class="form-control" name="no_of_freelancer" value="1"/>
              <span id="no_of_freelancerError" class="error-msg13 rerror"></span> </div>
            <div class="col-6">
              <label for="">Approx Hours</label>
              <input type="text" class="form-control" name="hr_per_week" placeholder="<?php echo __('postjob_hr_per_week','hr/week'); ?>" value="0"/>
              <span id="hr_per_weekError" class="error-msg13 rerror"></span> </div>
          </div>
          <div class="row">
            <div class="col-sm-4">             
              <label>Postal Code</label>
              <div class="form-field">
              <input type="text" class="form-control" name="postal_code"/>
              <span id="postal_codeError" class="error-msg13 rerror"></span>
              </div>
              </div>
            <div class="col-sm-4">
              <?php $start_date  = array( 'tomorrow' => 'Tomorrow', 'less_than_1_month' => 'Less than 1 month', 'in_1_2_month' => '1-2 month', 'more_than_2_month' => 'More than two month', ); ?>
              <label>Project start date</label>
              <div class="form-field">
              <select class="form-control" name="project_start_on">
                <option value="">Project start on</option>
                <?php print_select_option_assoc($start_date); ?>
              </select>
              <span id="project_start_onError" class="error-msg13 rerror"></span>
              </div>
              </div>
            <div class="col-sm-4">
              <label>Bidding Deadline</label>
              <div class="form-field">
              <input type="text" class="form-control datepicker" name="bidding_deadline"/>
              <span id="bidding_deadlineError" class="error-msg13 rerror"></span>
              </div>
              </div>
          </div>
		  
			<div class="form-group">
				<div class="radio-inline">
					<input type="checkbox" class="magic-checkbox" value="1" name="place_quote" id="place_quote">
					<label for="place_quote">Place Quote </label>
					<small>Allow contractor to place quote</small>
				</div>             
			</div>
		
          <div class="row" id="fixed_budget">
            <div class="col-sm-6">
              <div class="form-field">
                <label for=""><?php echo __('postjob_what_is_your_budget','What is your budget?'); ?></label>
                <select class="form-control" name="budgetall" id="budgetall">
                  <option value="0" selected="">--- <?php echo __('postjob_please_select','Please Select'); ?> ---</option>
                  <option value="20#100"><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 20 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 100</option>
                  <option value="100#250"><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 100 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 250</option>
                  <option value="250#500"><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 250 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 500</option>
                  <option value="500#1000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 500 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 1,000</option>
                  <option value="1000#2500" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 1,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 2,500</option>
                  <option value="2500#5000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 2,500 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 5,000</option>
                  <option value="5000#10000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 5,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 10,000</option>
                  <option value="10000#25000" ><?php echo __('postjob_between','Between'); ?> <?php echo CURRENCY;?> 10,000 <?php echo __('postjob_and','and'); ?> <?php echo CURRENCY;?> 25,000</option>
                  <option value="25000#" ><?php echo __('postjob_over','Over'); ?> <?php echo CURRENCY;?> 25,000</option>
                  <option value="other"><?php echo __('postjob_other','Other Amount'); ?></option>
                </select>
                <span id="budgetallError" class="error-msg13 rerror"></span> </div>
            </div>
            <div class="col-6" id="budget_other" style="display:none">
              <div class="form-field">
                <label for=""><?php echo __('postjob_quote_amount','Quote Amount'); ?></label>
                <input class="form-control fixed_budeget" id="fixed_budeget" type="text" name="fixed_budeget" value="0" placeholder="<?php echo __('postjob_budget_amount','Budget Amount'); ?>">
              </div>
            </div>
          </div>
          <div id="f_q_wapper"></div>
          <button class="btn btn-site mb-3" type="button" onclick="addQuestion()" id="add_qs_btn">Questions for contractor <i class="zmdi zmdi-plus-circle-o"></i></button>
		  
		  <div><?php $this->load->view('invite-freelancer'); ?></div>
		  
		  
          <br />
          <?php
		if($this->session->userdata('user'))
		{
		?>
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
          <?php
		 }
		 ?>
          <div id="promote_wrapper" hidden>
            <h5 class="text-uppercase b"><?php echo __('postjob_promote_your_listing_optional','Promote your listing (Optional)'); ?></h5>
            <div class="form-group">
              <div class="checkbox checkbox-inline">
                <input class="magic-checkbox" type="checkbox" name="featured" id="featured1" value="Y" onchange="checkPrice(this)">
                <label for="featured1"> <img src="<?php echo VPATH;?>assets/images/featured_new.png" alt="" style="float:left"> <span style="position: relative;top: -5px;"><?php echo __('postjob_featured_project_text','I want my project to be listed as a featured project. Featured projects attract more, higher quality bids. They appear prominently on the website.'); ?></span> </label>
              </div>
            </div>
            <div>
              <p id="featured_price_p_fixed" style="display:none;">Price to pay <span class=""><b><?php echo CURRENCY.''.FIXED_RATE; ?></b></span> </p>
              <p id="featured_price_p_hourly" style="display:none;">Price to pay <span  class="" ><b><?php echo  CURRENCY.''.HOURLY_RATE; ?></b></span> </p>
            </div>
          </div>
          <div id="fundError" class="error-msg13 rerror"></div>
          </span> 
          
          <!-- preview section -->
          <div class="preview_div" id="preview_div" style="display:none;">
            <h3 class="title-sm"><?php echo __('postjob_preview','PREVIEW'); ?></h3>
            <div class="labelBlock" id="labelBlock">
              <p>
                <label> <?php echo __('postjob_project_title','Project Title'); ?> :</label>
                <span id="p_title"></span></p>
              <p class="hide">
                <label> <?php echo __('postjob_experience_level','Experience level'); ?> :</label>
                <span id="p_exp_level"></span></p>
              <p>
                <label> <?php echo __('postjob_your_project_in_details','Your Project in Detail'); ?>:</label>
                <span id="p_description"></span></p>
              <p>
                <label> <?php echo __('postjob_skills','Skills'); ?> :</label>
                <span id="p_select2-search__field"></span></p>
              <p hidden>
                <label> <?php echo __('postjob_project_environment','Project Environment'); ?> :</label>
                <span id="p_environment"></span></p>
              <p hidden>
                <label> <?php echo __('postjob_project_visibility','Project Visibility'); ?> :</label>
                <span id="p_visibility"></span></p>
              <p hidden>
                <label> <?php echo __('postjob_project_type','Project Type'); ?> :</label>
                <span id="p_project_type"></span></p>
				<p>
                <label>Postal Code :</label>
                <span id="p_postal_code"></span></p>
				<p>
                <label>Project Start Date :</label>
                <span id="p_start_date"></span></p>
				<p>
                <label>Project Bidding Deadline :</label>
                <span id="p_bidding_deadline"></span></p>
            </div>
            <br />
            <br />
          </div>
          
          <!-- end of preview section -->
          <button type="button" class="btn btn-site" id="submit-check" onclick="JobFormPost()"><?php echo strtoupper(__('postjob_submit','SUBMIT')); ?></button>
          &nbsp;
          <button type="button" class="btn btn-site" id="edit-preview" onclick="EditJobFormPost()" style="display:none;"><?php echo __('postjob_edit','Edit'); ?></button>
          <button type="button" class="btn btn-site" id="preview-check" onclick="PreviewJobFormPost()"><?php echo strtoupper(__('postjob_preview','PREVIEW')); ?></button>
          &nbsp; <a class="btn btn-warning hide" href="<?php echo base_url('dashboard/dashboard_new'); ?>"><?php echo strtoupper(__('postjob_cancel','CANCEL')); ?></a>
          <div class="form-group hidden">
            <div class="checkbox checkbox-inline">
              <input class="magic-checkbox" type="checkbox" name="termsandcondition" id="confirm" value="Y">
              <label for="confirm"> <?php echo __('postjob_by_regristering_you_confirm_that_you_accept_the','By registering you confirm that you accept the'); ?> <a href="<?php echo base_url('information/info/terms_condition');?>"><?php echo __('postjob_terms_and_conditions','Terms &amp; Conditions'); ?></a> &amp; <a href="<?php echo base_url('information/info/privacy_policy');?>"><?php echo __('postjob_privecy_policy','Privacy Policy'); ?></a>.</label>
            </div>
            <span id="termsandconditionError" class="error-msg13 rerror"></span> </div>
        </div>
        </form>
        <div class="spacer-20"></div>
      </aside>
    </div>
  </div>
</section>
<script src="<?=JS?>mycustom.js"></script> 
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
</script> 
<script type="text/javascript">
	
	/* $('.inputtag').tokenize2({
		placeholder: "<?php echo __('postjob_select_a_skill','Select a Skill'); ?>",
		dataSource: function(search, object){
			$.ajax({
				url : '<?php echo base_url('contest/get_skills')?>',
				data: {search: search},
				dataType: 'json',
				success: function(data){
					var $items = [];
					$.each(data, function(k, v){
						$items.push(v);
					});
					object.trigger('tokenize:dropdown:fill', [$items]);
				}
			});
		}
	}); */
	
	$('.inputtag').chosen();
	
	
	function JobFormPost(){	
	$('span.error-msg').hide();
	$(window).scrollTop(0);
	FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>postjob/check",'postjob_frm');
	$('#job_det').show();
	$('#job_det_1').show();
	$('#job_det_2').show();
	$('#preview-check').show();
	$('#preview_div').hide();
    }
	
	function PreviewJobFormPost(){
		
		var p_form = true;
		
		var title = $('#title').val();
		var exp_level_txt = $('[name="exp_level"]:checked').data('text');
		var description = $('#description').val();
		var category = $("#category_id").val();
		var subcategory = $('#subcategory_id').val();
		var optionTexts = [];
        $(".chosen-choices li.search-choice").each(function() { optionTexts.push($(this).text()) });
        var skill = optionTexts.join('<br/>');
        //var skill = skill.substr(1);

		// var environment = $('input[name=environment').val();
		var environment = $('input[name=environment]:checked').val();
			if ( environment == 'ON' ){
				environment = '<?php echo __('postjob_online','Online'); ?>';
			} else if ( environment == 'OFF' ){
				environment = '<?php echo __('postjob_offline','Offline'); ?>';
			}
		var visibility = $('input[name=visibility]:checked').val();
			if(visibility=='Public'){
				visibility = '<?php echo __('postjob_public','Public'); ?>';
			}
			if(visibility=='Private'){
				visibility = '<?php echo __('postjob_private','Private'); ?>';
			}
			
		var project_type = $('input[name="project_type"]:checked').val();
		
		$('#appended').remove();
			if ( project_type == 'F' ){
				project_type = '<?php echo __('postjob_fixed','Fixed'); ?>';
				$('#appended').remove();
				if ( $('#budgetall').val() == 'other' ){
					$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_budget','Your Budget'); ?> :</label><span> '+$('#fixed_budeget').val()+'</span></p>');
				} else {
					var bgt =  $('#budgetall').val().split('#');
					var bgt_all = '';
					if(bgt[1] == ''){
						bgt_all = ' Over <?php echo CURRENCY; ?>' + bgt[0];
					}else{
						bgt_all = bgt.map(function(v){ return '<?php echo CURRENCY;?> '+v}).join(' to ');
					}
					
					$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_budget','Your Budget'); ?> :</label><span>'+bgt_all+'</span></p>');
				}
			} else if ( project_type == 'H' ){
				project_type = '<?php echo __('postjob_hourly','Hourly'); ?>';
				$('#appended').remove();
				$('#labelBlock').append('<p id="appended"><label> <?php echo __('postjob_your_average_hourly_rate','Your average hourly rate'); ?> :</label><span> <?php echo __('postjob_min','Min'); ?>: $'+$('input[name=budget_min').val()+' <?php echo __('postjob_max','Max'); ?>: $'+$('input[name=budget_max').val()+'</span></p><p id="appended"><label> <?php echo __('postjob_number_of_freelancer','No Of Freelancer'); ?> :</label><span>'+$('input[name=no_of_freelancer').val()+'</span></p>');
			}
		
		if(title == ''){
			$('#titleError').html('<?php echo __('postjob_please_enter_job_title','Please Enter Job Title'); ?>');
			p_form = false;
		}else{
			$('#titleError').html('');
		}
		
		if(description == ''){
			$('#descriptionError').html('<?php echo __('postjob_please_enter_description','Please Enter Description'); ?>');
			p_form = false;
		}else{
			$('#descriptionError').html('');
		}
		
		if(category == ''){
			$('#category_idError').html('<?php echo __('postjob_please_select_category','Please Select Category'); ?>');
			p_form = false;
		}else{
			$('#category_idError').html('');
		}
		
		if(subcategory == ''){
			$('#subcategory_idError').html('<?php echo __('postjob_please_select_sub_category','Please Select Sub Category'); ?>');
			p_form = false;
		}else{
			$('#subcategory_idError').html('');
		}
		
		var skill_len = $(".chosen-choices li.search-choice").length;
		
		if(skill_len == 0){
			
			$('#subskill_idError').html('<?php echo __('postjob_please_select_sub_skill','Please Select Sub Skill'); ?>');
			p_form = false;
		}else{
			$('#subskill_idError').html('');
		}
		
		if(p_form){
			$('#job_det').hide();
			$('#job_det_1').hide();
			$('#job_det_2').hide();
			$('#preview-check').hide();
			$('#edit-preview').show();
			$('#preview_div').show();
			
			category = $('#category_id :selected').text();
			subcategory = $('#subcategory_id :selected').text();
			var start_date = $('[name="project_start_on"] :selected').text();
			var bidding_deadline = $('[name="bidding_deadline"]').val();
			var postal_code = $('[name="postal_code"]').val();
			 
			$('#p_title').html(title);
			$('#p_exp_level').html(exp_level_txt);
			$('#p_description').html(description);
			$('#p_category_id').html(category);
			$('#p_subcategory_id').html(subcategory);
			$('#p_select2-search__field').html(skill);
			$('#p_environment').html(environment);
			$('#p_visibility').html(visibility);
			$('#p_project_type').html(project_type);
			$('#p_postal_code').html(postal_code);
			$('#p_start_date').html(start_date);
			$('#p_bidding_deadline').html(bidding_deadline);
			$(window).scrollTop(0);
		}else{
			var error_ele = $('.rerror').not(':empty').offset();
			if(error_ele){
				$(window).scrollTop(error_ele.top - 180);
			}else{
				$(window).scrollTop(300);
			}
			
		}
		
		
	}
	
	function EditJobFormPost(){
		$('#job_det').show();
		$('#job_det_1').show();
		$('#job_det_2').show();
		$('#preview_div').hide();
		$('#preview-check').show();
		$('#edit-preview').hide();
	}
	
$(document).ready(function(){
	$('input[name="project_type"]').change(function(){
		var val = $(this).val();
		if(val == 'F'){
			$('#hourly_budget').hide();
			$('#fixed_budget').show();
			
		}else{
			$('#fixed_budget').hide();
			$('#hourly_budget').show();
			
		}
		
		checkPrice($('input[name="featured"]'));
	});
	
	
	$('select[name="budgetall"]').change(function(){
		var val = $(this).val();
		if(val == 'other'){
			$('#budget_other').show();
		}else{
			$('#budget_other').hide();
			$(".fixed_budeget").val('0');
		}
	});
	
	$('.form-group').popover({
		selector: '[rel=infopop]',
		trigger: "click",
		}).on("show.bs.popover", function(e){
		$("[rel=infopop]").not(e.target).popover("destroy");
		$(".popover").remove();                    
	});
	
	$('body').click(function(e){
		var target = $(e.target);
		if(!target.is('i')){
			$("[rel=infopop]").popover("destroy");
			$(".popover").remove(); 
		}
		
	});

});

</script> 
<script>
  function getscat(v){
	 $('.abc').removeClass('selected');
	 $(".abc").fadeTo("slow",0.4);
	 $('#li_'+v).fadeTo("fast",1.0); 
	 $('#li_'+v).attr('class','abc selected');  
     var dataString = 'pid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubcat",
     success:function(return_data){
		$("#category_id").val(v);
        $("#subcat_dv").html(return_data);
        $("#subcat_select").show();
        select2load();
     }
    });
  }
  
  function getsubcat(v)
  {  	
  	  var dataString = 'pid='+v;    
	  $.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo VPATH;?>postjob/getsubcat",
		 success:function(return_data){
			//$("#category_id").val(v);
			$("#subcategory_id").html(return_data);
			 select2load();
			//$("#subcat_select").show();
		 }
     });
  }
  
  function putscat(v){
	 $('.def').removeClass('selected');
	 $(".def").fadeTo("slow",0.4);
	 $('#li_'+v).fadeTo("fast",1.0); 
	 $('#li_'+v).attr('class','def selected');  
     var dataString = 'catid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubcatname",
     success:function(return_data){
		$("#subcategory_id").val(return_data);
     }
    });
  }
  
  function putskill(v){
	 $("#ls_"+v).fadeTo("slow",0.4); 
	 $('#li_'+v).attr('class','sus selected');
	 $('#chk_'+v).attr('checked','checked');  
     
  }
  
 function getsubskill(v){  
	 
     var dataString = 'sid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubskill",
	 beforeSend: function() {  
       // $("#subskill").html('<option value="">Loading...</option>');
    },
     success:function(return_data){	 	
	 	
        //$("#subskill").html(return_data);
		/*$('.inputtag').tokenize2();*/
		$("#subskill").html('');
		$('.tokenize').find('.token').remove();
        //select2load();
		
     }
    });
  }
  
 function getskill(v){ 
 
 	$('.stu').removeClass('selected');
	 $(".stu").fadeTo("slow",0.4);
	 $('#lis_'+v).fadeTo("fast",1.0); 
	 $('#lis_'+v).attr('class','stu selected'); 
	 
     var dataString = 'sid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>postjob/getsubskill",
     success:function(return_data){
		$("#skill_id").val(v); 
        $("#subskill_id").html(return_data);
        $("#subskill_select").show();
		
     }
    });
  }
  
  
  function project_type_box(v){ 
  var multi_freelancer=$("input[name=multi_freelancer]:checked").val();
     if(v=="H"){ 
       $("#ptype_h").show();
       $("#ptype_f").hide();
	   $("#price_span").html("<?php echo html_entity_decode(CURRENCY)." ".HOURLY_RATE;?>");
	  // $(".multi_freelancer").show(); 
	   if(multi_freelancer!='Y'){
			  $(".multi_freelancer_number").hide();
		}else{
			 $(".multi_freelancer_number").show();
		}
     }
     else{ 
       $("#ptype_f").show();
       $("#ptype_h").hide();
	   $("#price_span").html("<?php echo html_entity_decode(CURRENCY)." ".FIXED_RATE;?>");    
	   //$(".multi_freelancer").hide();    
	   $(".multi_freelancer_number").hide(); 
     }
  }
  function getMulti(val){
  	if(val=='Y'){
		$(".multi_freelancer_number").show();
	}else{
	$(".multi_freelancer_number").hide();	
	}
  }
 function movefile(evt){ 
      
        var n=document.getElementById('userfile').files[0];
       
        $.ajaxFileUpload({
            url:'<?php echo VPATH;?>postjob/test/',
            secureuri:false,
            fileElementId:'userfile',
            dataType: 'json',
            data:{name:n.name, id:'id'},
            success: function (data){              
                var flist=$("#upload_file").val()+","+data.msg;
                
                $("#upload_file").val(flist);                
                //$("#flist_div").append("<div class='flisttext' id='sp_"+data.msg.replace(".","")+"'>"+data.msg+"<img id='"+data.msg+"' onclick='removespan(this.id)' style='float: right;' src='<?php// echo VPATH;?>assets/images/bin.png' /></div>");
                $("#flist_div").append("<div class='flisttext' id='sp_"+data.msg.replace(".","")+"'>"+data.msg+"<i class='zmdi zmdi-delete' id='"+data.msg+"' onclick='removespan(this.id)' style='float:right;color:#f00;font-size:19px;cursor:pointer'></i></div>");
               // $("flist_div").text(data.msg);
                $("#flist_div").show();
                
            }
    });
      
     
  }
  
  
  /*function check_featured(){     
    if($("#featured").is(':checked')){ 
        
      var b='<?php echo $balance;?>';  
      var fprice='<?php echo FIXED_RATE;?>';
      if(b<fprice){        
        $("#submit-check").attr('disabled', 'true');
        $("#featuredlError").show();
        $("#featuredlError").text("You don't have enough balance..!");
      }
      else{ 
        $("#submit-check").removeAttr('disabled');
         $("#featuredlError").hide();
      }
    }
    else{ 
      $("#submit-check").removeAttr('disabled');
       $("#featuredlError").hide();
    }    
  }*/
  

  function showsignup(){ 
    $("#signup_frm").show();
    $("#login_frm").hide();
	$("#user_inf").val('s');
	$("#su").attr('class','selected');
	$("#lg").removeAttr('class','selected');
	
  }
  function showlogin(){ 
    $("#signup_frm").hide();
    $("#login_frm").show();
	$("#user_inf").val('l');
	$("#lg").attr('class','selected');
	$("#su").removeAttr('class','selected');
	
  } 
  
  function citylist(country)
{
	
	var dataString = 'cid='+country;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>login/getcity/"+country,
     success:function(return_data)
     {
	 	//alert(return_data);
      	$('#city').html('');
		$('#city').html(return_data);
     }
    });
}
function GetContents() {
	// Get the editor instance that you want to interact with.
	var editor = CKEDITOR.instances.description;

	// Get editor contents
	// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-getData
	var con=editor.getData();
	$('#description').text(con);
	var t=$('#description').text();
	if(t=='')
	{
		return false;	
	}
	else
	{
		return true;	
	}
	
	
} 
function removespan(v)
{
	
	var dataString = 'img='+v;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>postjob/rmvimage/"+v,
     success:function(return_data)
     {
		var flist=$("#upload_file").val();
		flist=flist.replace(v, "");
		$("#upload_file").val(flist);
		$('#sp_'+v.replace(".","")).remove();
      	
     }
    });	
}   
function getfixed(val){
	if(val=='other'){
		$(".fixed_budeget").show();
	}else{
		$(".fixed_budeget").hide();
		$(".fixed_budeget").val('0');
	}
} 
</script> 
<script type="text/javascript">
function formatRepo (repo) {
    if (repo.loading) return repo.text;

    var markup = '<div class="clearfix">' +
    '<div class="col-sm-1">' +
    '</div>' +
    '<div clas="col-sm-10">' +
    '<div class="clearfix">' +
    '<div class="col-sm-6">' + repo.full_name + '</div>'+
    '</div>';

    if (repo.description) {
      markup += '<div>' + repo.description + '</div>';
    }

    markup += '</div></div>';

    return markup;
  }

  function formatRepoSelection (repo) {
    return repo.full_name || repo.text;
  }
  
</script> 
<script>
/* function search_freelancer(val){
	$.get('<?php echo base_url('postjob/search_freelancer')?>?term='+val, function(res){
		$('#freelancer_list').html(res);
	});
} */
</script> 
<script>
/*function setActive(e){
	var u_id = $(e).attr('data-user');
	if($(e).is('.selected')){
		$(e).removeClass('selected');
		$(e).find('input[name="freelancer[]"]').remove();
	}else{
		$(e).addClass('selected');
		$(e).append('<input type="hidden" name="freelancer[]" value="'+u_id+'"/>');
	}
}*/

function setActive(e){
	var choosen_f = $(e).clone();
	var u_id = $(e).attr('data-user');
	if($(e).is('.selected')){
		$(e).remove();
		$('#freelancer_row_'+u_id).show();
		if($('#selected_freelancer_list').find('.item').length == 0){
			$('#selected_freelancer_list').hide();
		}
	}else{
		choosen_f.addClass('selected');
		choosen_f.append('<input type="hidden" name="freelancer[]" value="'+u_id+'"/>');
		$('#freelancer_row_'+u_id).hide();
		$('#selected_freelancer_list').show();
		if($('#selected_freelancer_list').find('#freelancer_row_'+u_id).length == 0){
			$('#selected_freelancer_list').append(choosen_f);
		}
		
	}
}

function checkPrice(ele){
	var is_checked = $(ele).is(':checked');
	if(is_checked){
		var p_type = $('input[name="project_type"]:checked').val();
		if(p_type == 'F'){
			$('#featured_price_p_fixed').show();
			$('#featured_price_p_hourly').hide();
		}else{
			$('#featured_price_p_fixed').hide();
			$('#featured_price_p_hourly').show();
		}
	}else{
		$('#featured_price_p_fixed').hide();
		$('#featured_price_p_hourly').hide();
	}
}

var qs_count = 1;
function addQuestion(){
	var l = $('#f_q_wapper').find('.qBx').length +1;
	var html = '<div class="qBx" id="qs_item_'+qs_count+'"><div class="input-group"><input type="text" class="form-control" placeholder="Question '+l+'" name="questions[]"/><div class="input-group-append"><button type="button" class="btn btn-success save-btn" onclick="saveQs('+qs_count+')">Ok</button>&nbsp;<button type="button" class="btn btn-danger" onclick="removeQs('+qs_count+')">Remove</button></div></div></div>';
	$('#f_q_wapper').append(html);
	qs_count++;
	$('#add_qs_btn').hide();
	
}

function saveQs(i){
	var qs_val = $('#qs_item_'+i).find('input').val();
	if(qs_val.trim() == ''){
		$('#qs_item_'+i).find('input').addClass('invalid');
		return false;
	}else{
		$('#qs_item_'+i).find('input').removeClass('invalid');
	}
	
	$('#qs_item_'+i).find('input').attr('readonly', 'readonly');
	
	$('#f_q_wapper').find('.save-btn').hide();
	$('#add_qs_btn').show();
}


function removeQs(i){
	$('#qs_item_'+i).remove();
	$('#add_qs_btn').show();
	return false;
	
}

$('[name="visibility"]').change(function(){
	var val = $(this).val();
	if(val.toLowerCase() == 'private'){
		$('#promote_wrapper').hide();
		$('input[name="featured"]').prop('checked', false);
		checkPrice($('input[name="featured"]'));
	}else{
		$('#promote_wrapper').show();
	}
});

$('[name="place_quote"]').change(function(){
	var is_checked = $(this).is(':checked');
	if(is_checked){
		$('#fixed_budget').hide();
	}else{
		$('#fixed_budget').show();
	}
});



</script> 
