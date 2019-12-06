<?php echo $breadcrumb;?>
<div class="container">
<div class="row">

<div class="col-md-9 col-sm-8 col-xs-12">
<!--ProfileRight Start-->

<div class="profile_right">
<!--EditProfile Start-->

<?php 
   if ($this->session->flashdata('rating_succ'))
        {
?>
<div class="success alert-success alert"><?php  echo $this->session->flashdata('rating_succ');?></div>
<?php
        }
    ?>
<?php 
   if ($this->session->flashdata('rating_eror'))
        {
     ?>
 <div class="success alert-success alert"><?php  echo $this->session->flashdata('rating_eror');?></div>
 <?php
        }
 ?>

<h1><a class="selected" href="javascript:void(0);">Welcome to HireGround, <?php echo $referee_name;?></a></h1>
<div class="editprofile"> 
<form method="post" action="<?php echo VPATH;?>references/giveFeedback/<?php echo $refer_encode;?>">
<div class="notiftext"><div class="proposalcss">Please submit a rating for <?php if($requester_fname!='' && $requester_lname!=''){echo $requester_fname." ".$requester_lname;}else{ echo $requester;}?>.</div></div>
<div style="clear:both; height:20px;"></div>
<input type="hidden" name="refer_id" value="<?php echo $refer_id;?>">
<input type="hidden" name="user_id" value="<?php echo $user_id;?>">

<div class="acount_form"><p>Safety :</p>
<select style="width:225px;" class="acount-input" name="safety" id="safety">
    <option value="">Select Rating</option>
    <option value="1" <?php echo set_select('safety', '1'); ?>>Poor</option>
    <option value="2" <?php echo set_select('safety', '2'); ?>>Average</option>
    <option value="3" <?php echo set_select('safety', '3'); ?>>Normal</option>
    <option value="4" <?php echo set_select('safety', '4'); ?>>Good</option>
    <option value="5" <?php echo set_select('safety', '5'); ?>>Excellent</option>
</select>
    <?php echo form_error('safety', '<div class="errorvalidation">', '</div>'); ?>
</div>

<div class="acount_form"><p>Flexiblity :</p>
<select style="width:225px;" class="acount-input" name="flexiblity" id="flexiblity">
    <option value="">Select Rating</option>
    <option value="1" <?php echo set_select('flexiblity', '1'); ?>>Poor</option>
    <option value="2" <?php echo set_select('flexiblity', '2'); ?>>Average</option>
    <option value="3" <?php echo set_select('flexiblity', '3'); ?>>Normal</option>
    <option value="4" <?php echo set_select('flexiblity', '4'); ?>>Good</option>
    <option value="5" <?php echo set_select('flexiblity', '5'); ?>>Excellent</option>
</select>
    <?php echo form_error('flexiblity', '<div class="errorvalidation">', '</div>'); ?>
</div>

<div class="acount_form"><p>Performance :</p>
<select style="width:225px;" class="acount-input" name="performence" id="performence">
    <option value="">Select Rating</option>
    <option value="1" <?php echo set_select('performence', '1'); ?>>Poor</option>
    <option value="2"  <?php echo set_select('performence', '2'); ?>>Average</option>
    <option value="3"  <?php echo set_select('performence', '3'); ?>>Normal</option>
    <option value="4" <?php echo set_select('performence', '4'); ?>>Good</option>
    <option value="5" <?php echo set_select('performence', '5'); ?>>Excellent</option>
</select>
    <?php echo form_error('performence', '<div class="errorvalidation">', '</div>'); ?>
</div>

<div class="acount_form"><p>Initiative :</p>
<select style="width:225px;" class="acount-input" name="initiative" id="initiative">
    <option value="">Select Rating</option>
    <option value="1" <?php echo set_select('initiative', '1'); ?>>Poor</option>
    <option value="2" <?php echo set_select('initiative', '2'); ?>>Average</option>
    <option value="3" <?php echo set_select('initiative', '3'); ?>>Normal</option>
    <option value="4" <?php echo set_select('initiative', '4'); ?>>Good</option>
    <option value="5" <?php echo set_select('initiative', '5'); ?>>Excellent</option>
</select>
    <?php echo form_error('initiative', '<div class="errorvalidation">', '</div>'); ?>
</div>

<div class="acount_form"><p>Knowledge :</p>
<select style="width:225px;" class="acount-input" name="knowledge" id="knowledge">
    <option value="">Select Rating</option>
    <option value="1" <?php echo set_select('knowledge', '1'); ?>>Poor</option>
    <option value="2" <?php echo set_select('knowledge', '2'); ?>>Average</option>
    <option value="3" <?php echo set_select('knowledge', '3'); ?>>Normal</option>
    <option value="4" <?php echo set_select('knowledge', '4'); ?>>Good</option>
    <option value="5" <?php echo set_select('knowledge', '5'); ?>>Excellent</option>
</select>
    <?php echo form_error('knowledge', '<div class="errorvalidation">', '</div>'); ?>
</div>


<div class="acount_form"><p>Comment :</p>
    <textarea class="acount-input" cols="30" rows="6" name="comment" id="comment"></textarea>
     
</div>
<div class="acount_form">
    <p></p>
    <input class="btn-normal btn-color submit bottom-pad2 top-pad2" type="submit" name="submit"  value="Submit" />       
</div>

</form>
</div>
<!--EditProfile End-->

</div>                       

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
<div class="addbox">
 <?php 
   echo $code;
 ?>
</div>                      
<?php                      
      }
   elseif($type=='B'&& $image!="")
   {
  ?>
        <div class="addbox">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>

                     </div>

                     <!-- Left Section End -->

                  </div>
</div>


