
<?php echo $breadcrumb;?>
<script type="text/javascript">
function editFormPost(){
FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/check",'editprofile');
}
</script>       
<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">

<div class="row">

<?php echo $leftpanel;?> 

<div class="col-md-9 col-sm-8 col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">
	<h4 class="title-sm">Select Skills</h4>
</div>
<div class="panel-body">
<?php
if($this->session->flashdata('skill_succ'))
{
?>
	<div class="success alert-success alert"><i class="icon-ok icon-2x"></i>&nbsp;<?php echo $this->session->flashdata('skill_succ');?></div>
<?php		
}
if($this->session->flashdata('skill_error'))
{
?>
	<div class="alert" style="width:100%"><i class="icon-warning-sign icon-1x"></i>&nbsp;<?php echo $this->session->flashdata('skill_error');?></div>
<?php
}
?>

<!--<h1>
<a class="selected" href="javascript:void(0)">Select Skills</a>
</h1> -->

<input type="hidden" id="totalskill" value="<?php echo $total_plan_skill;?>" readonly="readonly">

<form method="post" action="<?php VPATH;?>dashboard/updateskill"> 
<?php
   $parent_skillid=array();
  if(!empty($user_skill) AND count($user_skill) >0){ 
	foreach($user_skill as $k => $v){
		$user_skills[] = $v['sub_skill_id'];
		$parent_skillid[] = $v['skill_id'];
	}
  // $user_skills=explode(",",$user_skill[0]['skills_id']); 
  }
  else{ 
      $user_skills[]=0;
  }
  $parent_skillid=array_unique($parent_skillid);
?>

<div class="editprofile">

    <?php 
      foreach ($parent_skill as $row){
    ?>

    <div class="skillsbox">
    <h4 class="titlebg" ><i id="skilli<?php echo $row['id'];?>" class="<?php if(!in_array($row['id'],$parent_skillid)){?>fa fa-angle-down<?php }else{?> fa fa-angle-up<?php }?>"> </i> <a href="javascript:void()" onclick="showsubskill('<?php echo $row['id'];?>')"><?php echo $row['skill_name'];?></a></h4>

<div class="skilllink" style=" <?php if(!in_array($row['id'],$parent_skillid)){?>display:none; <?php }?>" id="skilllink<?php echo $row['id'];?>">
<ul> 
<?php 
  $sub_skill=$this->auto_model->getskill($row['id']);
  
  foreach($sub_skill as $s){ 
?>
<li>
<span style="float:left; margin-right:4px;">

    <input class="jbchk" name="user_skill[]" type="checkbox" id="chk_<?php echo $s['id'];?>" onclick="return gettotal(this.id);" value="<?php echo $row['id'].'|'.$s['id'];?>" 
   <?php 
     if(in_array($s['id'],$user_skills)){ 
	   echo "checked='checked'";
	 }
   ?>  
  >
</span>
<a href="javascript:void()"><?php echo $s['skill_name'];?></a></li>

<?php 
}
?>

</ul>

</div>


</div>
    <?php      
      }
    ?>
    
    
<div class="divide30"></div>

<input type="submit" id="submit_btn" name="submit" class="btn btn-site" value="Update">
</div>
</form>
<!--SkillsBox Start-->



</div>     
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
        <div class="addbox2">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
<div style="clear:both;"></div>

                     </div>

                     <!-- Left Section End -->

                  </div>

               </div>
</section>               

<script>   
   function gettotal(v){ 
       var chkl=$(".jbchk:checked").length;     
       if(chkl>$('#totalskill').val()){
           alert("Maximum "+$('#totalskill').val()+" Skills You Can Select According To Membership Plan");
           /*$("#submit_btn").attr("disabled", "disabled");*/		   		   return false;
       }
       else{
           $("#submit_btn").removeAttr("disabled");			return true;
       }
   }
   
   function showsubskill(v){
     //$(".skilllink").hide();  
     $("#skilllink"+v).toggle();
	 if($("#skilli"+v).hasClass('fa-angle-down'))
	 {
	 	$("#skilli"+v).removeClass('fa-angle-down');
		$("#skilli"+v).addClass('fa-angle-up');
	 }
	 else
	 {
	 	$("#skilli"+v).addClass('fa-angle-down');
		$("#skilli"+v).removeClass('fa-angle-up');
	 }
   }
</script>
         