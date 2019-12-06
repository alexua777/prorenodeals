<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>

<div class="container">
  <div class="row"> <?php echo $leftpanel;?> 
    <!-- Sidebar End -->
    <div class="col-md-9 col-sm-8 col-xs-12">
      
       
        <div class="profile_right">
          <h3> Contract for :: <a href="<?php echo VPATH;?>jobdetails/details/<?php echo $project_id;?>">
            <?=$project_name?>
            </a> </h3>
          <!--EditProfile Start-->
          <div class="editprofile11" id="editprofile">
            <link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
            <link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
            <script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script> 
            <script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script> 
            <script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script> 
            <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable({
				columns: [
					{},
					{ },
					{ orderable:      false, },
					{ orderable:      false, },

        		],
				"order": [[ 0, "asc" ]]
				});
			} );
		</script>
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Client Name</th>
                  <th>My Feedback</th>
                  <th>Client Feedback</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
if(count($contructor)>0)
{
foreach($contructor as $key=>$val)
{
	/*$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
	$status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);
	$bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val['project_id']));
	$chosen_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$val['project_id']));
	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$val['project_id']);
	$type="";
	if($project_type=="F")
	{
		$type="Fixed";
	}
	else
	{
		$type="Hourly";
	}*/
?>
                <tr>
                  <td><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['user_id'];?>" id="name_<?php echo $val['user_id'];?>"><?php echo $val['name'];?></a></td>
                  <td><? if($val['myfeedback']=='Y'){?>
                    <a href="javascript:void(0)" onclick="getFeedback('<?=$project_id?>','<?=$user_id?>')" data-reveal-id="exampleModal_view">My Feedback</a>
                    <? }?></td>
                  <td><? if($val['freelancer_feedback']=='Y'){?>
                    <a href="javascript:void(0)" onclick="getFeedback('<?=$project_id?>','<?php echo $val['user_id'];?>')" data-reveal-id="exampleModal_view">Client Feedback</a>
                    <? }?></td>
                  <td><? if($val['end_status']=='N'){?>
                    <a href="javascript:void(0)" onclick="closecontract('<?=$project_id?>','<?php echo $val['user_id'];?>')" data-reveal-id="exampleModal" class="btn btn-primary" >Give Feedback</a>
                    <?}else{ ?>
                    <? }?></td>
                </tr>
                <?php
}
}

?>
              </tbody>
            </table>
          </div>
          <!--EditProfile End-->
          <a href="<?php echo VPATH;?>dashboard/myproject_client" class="btn btn-warning">Back</a>
        </div>
        
       <div class="clearfix"></div>
      <?php 
  
  if(isset($ad_page)){ 
    $type=$this->auto_model->getFeild("type","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
  if($type=='A') 
  {
   $code=$this->auto_model->getFeild("advertise_code","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
  else
  {
   $image=$this->auto_model->getFeild("banner_image","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M"));
    $url=$this->auto_model->getFeild("banner_url","advartise","","",array("page_name"=>$ad_page,"add_pos"=>"M")); 
  }
        
      if($type=='A'&& $code!=""){ 
?>
      <div class="addbox2">
        <?php 
   echo $code;
 ?>
      </div>
      <?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
      <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
      <?php  
 }
  }

?>
       <div class="clearfix"></div>
    </div>
    <!-- Left Section End --> 
  </div>
</div>
<div id="exampleModal_view" class="reveal-modal" >
  <h3> Feedback <span id="contrucname"></span> ::
    <?=$project_name?>
  </h3>
  <div class="editprofile11" id="getfeedbacksection" > </div>
  <a class="close-reveal-modal">×</a> </div>
<div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;" >
  <h3> Close Contract with <span id="contrucname"></span> ::
    <?=$project_name?>
  </h3>
  <div class="editprofile" >
    <div class="notiftext">
      <div class="proposalcss">Put your rating here.</div>
    </div>
    <div style="clear:both; height:20px;"></div>
    <div id="feedbackmessage" style="text-align: center" class="login_form"></div>
    <form action="" name="givefeedbackform" class="givefeedbackform" method="POST">
      <input type="hidden" name="given_id" value="<?php echo $user_id;?>">
      <input type="hidden" name="project_id" value="<?php echo $project_id;?>">
      <input type="hidden" name="user_id" id="user_id_o" value="">
      <div class="acount_form">
        <p>Safety :</p>
        <select style="width:225px;" class="acount-input" name="safety" id="safety">
          <option value="">Select Rating</option>
          <option value="1" <?php echo set_select('safety', '1'); ?>>Poor</option>
          <option value="2" <?php echo set_select('safety', '2'); ?>>Average</option>
          <option value="3" <?php echo set_select('safety', '3'); ?>>Normal</option>
          <option value="4" <?php echo set_select('safety', '4'); ?>>Good</option>
          <option value="5" <?php echo set_select('safety', '5'); ?>>Excellent</option>
        </select>
        <?php echo form_error('safety', '<div class="errorvalidation">', '</div>'); ?> </div>
      <div class="acount_form">
        <p>Flexiblity :</p>
        <select style="width:225px;" class="acount-input" name="flexiblity" id="flexiblity">
          <option value="">Select Rating</option>
          <option value="1" <?php echo set_select('flexiblity', '1'); ?>>Poor</option>
          <option value="2" <?php echo set_select('flexiblity', '2'); ?>>Average</option>
          <option value="3" <?php echo set_select('flexiblity', '3'); ?>>Normal</option>
          <option value="4" <?php echo set_select('flexiblity', '4'); ?>>Good</option>
          <option value="5" <?php echo set_select('flexiblity', '5'); ?>>Excellent</option>
        </select>
        <?php echo form_error('flexiblity', '<div class="errorvalidation">', '</div>'); ?> </div>
      <div class="acount_form">
        <p>Performence :</p>
        <select style="width:225px;" class="acount-input" name="performence" id="performence">
          <option value="">Select Rating</option>
          <option value="1" <?php echo set_select('performence', '1'); ?>>Poor</option>
          <option value="2"  <?php echo set_select('performence', '2'); ?>>Average</option>
          <option value="3"  <?php echo set_select('performence', '3'); ?>>Normal</option>
          <option value="4" <?php echo set_select('performence', '4'); ?>>Good</option>
          <option value="5" <?php echo set_select('performence', '5'); ?>>Excellent</option>
        </select>
        <?php echo form_error('performence', '<div class="errorvalidation">', '</div>'); ?> </div>
      <div class="acount_form">
        <p>Initiative :</p>
        <select style="width:225px;" class="acount-input" name="initiative" id="initiative">
          <option value="">Select Rating</option>
          <option value="1" <?php echo set_select('initiative', '1'); ?>>Poor</option>
          <option value="2" <?php echo set_select('initiative', '2'); ?>>Average</option>
          <option value="3" <?php echo set_select('initiative', '3'); ?>>Normal</option>
          <option value="4" <?php echo set_select('initiative', '4'); ?>>Good</option>
          <option value="5" <?php echo set_select('initiative', '5'); ?>>Excellent</option>
        </select>
        <?php echo form_error('initiative', '<div class="errorvalidation">', '</div>'); ?> </div>
      <div class="acount_form">
        <p>Knowledge :</p>
        <select style="width:225px;" class="acount-input" name="knowledge" id="knowledge">
          <option value="">Select Rating</option>
          <option value="1" <?php echo set_select('knowledge', '1'); ?>>Poor</option>
          <option value="2" <?php echo set_select('knowledge', '2'); ?>>Average</option>
          <option value="3" <?php echo set_select('knowledge', '3'); ?>>Normal</option>
          <option value="4" <?php echo set_select('knowledge', '4'); ?>>Good</option>
          <option value="5" <?php echo set_select('knowledge', '5'); ?>>Excellent</option>
        </select>
        <?php echo form_error('knowledge', '<div class="errorvalidation">', '</div>'); ?> </div>
      <div class="acount_form">
        <p>Comment :</p>
        <textarea class="acount-input" cols="30" rows="6" name="comment" id="comment"></textarea>
      </div>
      <div class="acount_form">
        <p></p>
        <button type="button" onclick="givefeedback()" id="sbmt" class="btn btn-primary" style="background: #428bca">Send</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>
    <div class="acount_form">&nbsp;</div>
  </div>
  <a class="close-reveal-modal">&#215;</a> </div>
<script src="<?php echo ASSETS;?>js/jquery.reveal.js"></script> 
<script>
function closecontract(project_id,user_id){
	$("#contrucname").html($("#name_"+user_id).html());
	$("#user_id_o").val(user_id);
}
function givefeedback(){
	$("#feedbackmessage").html('Wait...');
	var requestbonis=$(".givefeedbackform").serialize();
	
	$.ajax({
		data:$(".givefeedbackform").serialize(),
		type:"POST",
		dataType: "json",
		url:"<?php echo VPATH;?>projectcontractor/givefeedback",
		success:function(response){
			
				if(response['status']=='OK')
				{
					
					$("#feedbackmessage").html('<div style="color:green;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');
					$(".givefeedbackform").css('display','none');
					$("#givebonus div.modal-footer button#sbmt").css('display','none');
					$(".givefeedbackform")[0].reset();	
					
				}
				else
				{
					
					$("#feedbackmessage").html('<div style="color:red;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');	
						
				}
			}
		});
		
}
function getFeedback(project_id,given_user){
	
	$("#getfeedbacksection").html('Wait...');
	$.ajax({
		data:{project_id:project_id,given_user:given_user},
		type:"POST",
		dataType: "json",
		url:"<?php echo VPATH;?>projectcontractor/getfeedback",
		success:function(response){
			
				if(response['status']=='OK')
				{
					
					$("#getfeedbacksection").html(response['msg']);
					
					
				}
				else
				{
					
					$("#getfeedbacksection").html('<div style="color:red;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');	
						
				}
			}
		});
}


</script>