<script type="text/javascript">
 function  ToggleEdit(id){ 
		if(document.getElementById(id).style.display =='none'){
		document.getElementById(id).style.display = 'block';
		
		}else{		
		document.getElementById(id).style.display = 'none';
		} 
	}
	
	function populateSkill(val){
		$.ajax({
			type: "POST",
			url: "../getskill_option",
			data: { pid: val}
		})		
		.done(function( msg ) {			
			$('#c_skill').html(msg);
		});			
	}
        
        function showDiv(v){ 
          $("#"+v).toggle();
        }
        
        function showEditBtn(v){ 
          if($("#"+v).val()=="Cancel"){ 
            $("#"+v).val("Edit Skill");
          }
          else{ 
            $("#"+v).val("Cancel");          
          }
        }
	
</script>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url()?>member/member_list">Member List</a></li>
        <li class="breadcrumb-item active"><a>Member Details</a></li>
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
      <?php $this->load->view('top_nav');?>
      <div class="panel-body">
        <form id="validate" action="<?php echo base_url(); ?>member/update_member_skill/<?php echo $user_id;?>" class="form-horizontal" role="form" name="state" method="post" enctype="multipart/form-data">
          <input type="hidden" name="referrer" value="<?php echo base_url();?>member/view_skill/<?php echo $user_id;?>"/>
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
          <div class="row">
            <label class="col-md-2 control-label" for="required">Skill</label>
            <div class="col-md-10">
              <?php $counter = 1;?>
              <?php foreach($user_skill as $skill){?>              
                <input type="button" name="" class="btn btn-primary" style="margin:0 4px 8px 0" value="<?php  echo  $counter++.'. ' .$skill;?>">
              <?php }?>
            </div>
          </div>
          <div id="edit_section" style="display:none;">
            <div class="row">
            <div class="col-md-2">&nbsp;</div>
              <?php 
                    foreach($all_p_skill as $p_skill) {
                    ?>
              <div class="col-md-10">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5><i class="icon20 i-cube"></i> <?php echo $p_skill['skill_name'];?></h5>
                    <a href="#" class="minimize"></a> </div>
                  <div class="panel-body center">
                    <ul style="list-style: none;">
                      <?php 
                             $sub_skill=$this->auto_model->getskill($p_skill['id']);
                            foreach($sub_skill as $s_skill) {?>
                      <li style="display:inline-block; margin-right: 10px;width: 30%;text-align: left;margin-bottom: 14px;">
                        <input type="checkbox" name="c_skill[]"  value="<?php echo $s_skill['id'];?>" <?php if(in_array($s_skill['skill_name'], $user_skill)){echo "checked='checked'";}?>  class="mailcheck checkIt" />
                        &nbsp;&nbsp;<?php echo $s_skill['skill_name'];?></li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <?php                                              
                    }
                    ?>
            </div>
            <div class="row">
              <label class="col-md-2 control-label" for="required"></label>
              <div class="col-md-10">
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-md-2 control-label" for="required"></label>
            <div class="col-md-10">
              <input type="button" id="jb_edit_btn" name="" class="btn btn-primary" value="Edit Skill" onclick="showEditBtn(this.id),ToggleEdit('edit_section');">
            </div>
          </div>
        </form>
      </div>
      
      <!--   <div class="col-lg-6">
                            <div class="page-header">
                                <h4>Select Skill</h4>
                            </div>
                            <?php 
                              foreach($all_p_skill as $p_skill) { 
                            ?>
                              <div class="panel panel-default">
                                <div class="panel-heading">
                                  <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                      <?php echo $p_skill['skill_name'];?>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse in" style="height: auto;">
                                  <div class="panel-body">
                                    <?php 
                                     $sub_skill=$this->auto_model->getskill($p_skill['id']);
                                    foreach($sub_skill as $s_skill) {?>
                                        <p><input type="checkbox" name="c_skill[]"  value="<?php echo $s_skill['id'];?>" <?php if(in_array($s_skill['skill_name'], $user_skill)){echo "checked='checked'";}?>  class="mailcheck checkIt" /><?php echo $s_skill['skill_name'];?></p><br/>                                                
                                    <?php
                                    } 
                                    ?>                                      
                                      
                                      
                                      
                                    
                                  </div>
                                </div>
                              </div>                            
                            <?php 
                              }
                            ?>

                        </div>--> 
      
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
