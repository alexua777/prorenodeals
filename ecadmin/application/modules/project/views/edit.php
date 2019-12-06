<link rel="stylesheet" href="<?php echo SITE_URL;?>assets/plugins/taginput/tokenize2.min.css" type="text/css" />
<script src="<?php echo SITE_URL;?>assets/plugins/taginput/tokenize2.min.js" type="text/javascript"></script>
<section id="content">
<div class="wrapper">
  <?php 
            if($status=='O'){
                    $fnc = 'open';
            }elseif($status=='F'){
                    $fnc = 'frozen';
            }
            elseif($status=='P'){
                    $fnc = 'process';
            }
            elseif($status=='C'){
                    $fnc = 'complete';
            }
            elseif($status=='E'){
                    $fnc = 'expire';
            }
            ?>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url() ?>project/<?=$fnc?>">Project List</a></li>
      <li class="breadcrumb-item active"><a>Project Management</a></li>
    </ol>
  </nav>
  <div class="container-fluid">
    <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
      <?= $this->session->flashdata('succ_msg') ?>
    </div>
    <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
      <?= $this->session->flashdata('error_msg') ?>
    </div>
    <?php
}
?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h5><i class="la la-edit"></i> Edit/Modify Project </h5>
        <a href="#" class="minimize2"></a> </div>
      <!-- End .panel-heading -->
      
      <div class="panel-body">
        <form id="validate" action="<?php echo base_url(); ?>project/edit_project/<?php echo $status;?>/<?php echo $id;?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
          <?php 
		 
    if(isset($all_data)){ 
        $buget=$all_data['buget_min']."#".$all_data['buget_max'];
		$buget=trim($buget,"");
		$skill=explode(",",$all_data['skills']);
 		$parentc=$this->auto_model->getFeild('parent_id','categories','cat_name',$all_data['category']);
		$subcat=$this->auto_model->getcategory($parentc);
		$parents=$this->auto_model->getFeild('parent_id','skills','skill_name',$skill['0']);
		$subskill=$this->auto_model->getskill($parents);
		
    }
		?>
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          <div class="form-group">
            <label class="control-label" for="required">Project Title</label>
				
              <input type="text" id="required" value="<?php echo $all_data['title']; ?>" name="title" class="required form-control" <?php if($status!='O'){ ?> readonly="readonly" <? } ?> />
              <?php echo form_error('title', '<label class="error" for="required">', '</label>'); ?>
          </div>
          <!-- End .control-group  -->
          
          <div class="form-group">
            <label class="control-label" for="required"> Skill</label><br />
              <select class="form-control inputtag" name="skills[]" multiple>
                <?php 
				 $subskill = $this->db->where("id IN (select skill_id from serv_project_skill where project_id = '{$all_data['project_id']}')")->get('skills')->result_array();
				
				  foreach($subskill as $v){ 
				?>
                <option value="<?php echo $v['id']; ?>" selected><?php echo $v['skill_name']; ?></option>
                <?php 
					  }        
					?>
              </select>
              <?php echo form_error('skills', '<label class="error" for="required">', '</label>'); ?> 
          </div>
          <!-- End .control-group  -->
          
          <div class="form-group">
            <label class="control-label" for="required">Description</label>
              <textarea class="form-control elastic" id="textarea1" name="description" rows="3" <?php if($status!='O'){ ?> readonly="readonly" <? } ?> style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;"><?php echo $this->auto_model->truncate($all_data['description'], 5000, '', true, true); ?></textarea>
              <?php echo form_error('description', '<label class="error" for="required">', '</label>'); ?>
          </div>
          <!-- End .control-group  -->
          
          <div class="form-group" hidden>
            <label class="control-label" for="required">Project Type</label>            
              <select class="form-control" onchange="project_type_box(this.value)" class="acount-input" size="1" id="project_type" name="project_type" <?php if($status!='O'){ ?> readonly="readonly" <? } ?>>
                <option value="F" <?php if($all_data['project_type']=="F"){echo "selected";}?>>Fixed</option>
                <option value="H" <?php if($all_data['project_type']=="H"){echo "selected";}?>>Hourly</option>
              </select>
              <?php echo form_error('project_type', '<label class="error" for="required">', '</label>'); ?>
          </div>
          
          <!--<div class="row" id="ptype_h"    <?php if($all_data['project_type']=="H"){ echo "style=display:block;";}else{echo "style=display:none;";}?> >
                           
                <label class="col-lg-2 control-label" for="required">Hourly Rate</label>
                                
                  <div class="col-lg-10 col-md-9" style="display: block;">
                        <label style="width:auto;padding-top: 8px;"> Min $ </label>
                        <input class="browsinput" type="text" name="buget_min" value="<?php if(isset($all_data)&& $all_data['buget_min']!=""){echo $all_data['buget_min'];}else{echo "0";}?>" <?php if($status!='O'){ ?> readonly="readonly" <? } ?> >
                        <label style="width:auto;padding-top: 8px;">  Max $ </label>
                        <input class="browsinput" type="text" name="buget_max" value="<?php if(isset($all_data)&& $all_data['buget_max']!=""){echo $all_data['buget_max'];}else{echo "0";}?>" <?php if($status!='O'){ ?> readonly="readonly" <? } ?>>
                <?php echo form_error('buget', '<label class="error" for="required">', '</label>'); ?> 
                </div>

                </div>-->
          
          <div class="row" hidden>
          <div class="col-sm-4 col-xs-12">
            <label class="col-form-label">Project Visiblity</label><br />
            	<div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="visibility_mode" name="visibility_mode" value="Private" <?php if($all_data['visibility_mode']=='Private'){echo "checked";} ?>>
                  <label class="custom-control-label" for="visibility_mode">Private</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="visibility_mode_2" name="visibility_mode" value="Public" <?php if($all_data['visibility_mode']=='Public'){echo "checked";} ?>>
                  <label class="custom-control-label" for="visibility_mode_2">Public</label>
                </div>                            
          </div>
          <div class="col-sm-4 col-xs-12">
              <label class="col-form-label">Project Environment</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="environment" name="environment" value="ON" <?php if($all_data['environment']=='ON'){echo "checked";} ?>>
                  <label class="custom-control-label" for="environment">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="environment_2" name="environment" Value="OFF" <?php if($all_data['environment']=='OFF'){echo "checked";} ?>>
                  <label class="custom-control-label" for="environment_2">Offline</label>
                </div>
          </div>
          <div class="col-sm-4 col-xs-12">
              <label class="col-form-label">Featured</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="featured" name="featured" value="Y" <?php if($all_data['featured']=='Y'){echo "checked";} ?>>
                  <label class="custom-control-label" for="featured">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="featured_2" name="featured" Value="N" <?php if($all_data['featured']=='N'){echo "checked";} ?>>
                  <label class="custom-control-label" for="featured_2">No</label>
                </div>                            
          </div>
          </div>
                            
            <input type="submit" name="submit" class="btn btn-primary" value="Update" <?php if($status!='O'){ ?> style="display:none;" <? } ?>>&nbsp;
			<button type="button" onclick="redirect_to('<?php echo base_url() . 'project/'.$fnc; ?>');" class="btn btn-secondary" <?php if($status!='O'){ ?> style="display:none;" <? } ?>>Cancel</button>          
                    
        </form>
      </div>
      <!-- End .panel-body --> 
    </div>
    <!-- End .widget --> 
    
  </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
<script>
  function project_type_box(v){ 
     if(v=="H"){ 
       $("#ptype_h").show();
       $("#ptype_f").hide();
     }
     else{ 
       $("#ptype_f").show();
       $("#ptype_h").hide();     
     }
  }
  function getscat(v){ 
     var dataString = 'pid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>project/getsubcat",
     success:function(return_data){
        $("#subcategory_id").html(return_data);
     }
    });
  }
  
  
 function getskill(v){ 
     var dataString = 'sid='+v;
    
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>project/getsubskill",
     success:function(return_data){
        $("#subskill_id").html(return_data);
     }
    });
  }
  
  $('.inputtag').tokenize2({
		placeholder: "Select skill",
		dataSource: function(search, object){
			$.ajax({
				url : '<?php echo SITE_URL.'contest/get_skills'; ?>',
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
	});
	
</script>