
<?php echo $breadcrumb;?>

<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="posts-block col-lg-9 col-md-9 col-sm-8 col-xs-12">


<!--ProfileRight Start-->
<div class="profile_right">
<?php
if($this->session->flashdata('succ_msg'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
<?php
}
if($this->session->flashdata('error_msg'))
{
?>
<span id="agree_termsError" class="error-msg2"><?php echo $this->session->flashdata('error_msg');?></span>
<?php
}
?>
<!--EditProfile Start-->
<form name="references" id="reference" action="<?php echo VPATH;?>references/addreferences" method="post"> 
<h1>
<a class="selected" href="javascript:void(0)">Add reference</a>
</h1> 

<div class="editprofile">
<input type="hidden" name="uid" value="<?php echo $user_id;?>"/>

<div class="acount_form"><p>Referee Name : <span style="color:#F00">*</span></p><input type="text" class="acount-input" size="30" name="name" id="name" tooltipText="Enter referee's name" value="<?php echo set_value('name');?>" />

<div class="error-msg2"> <?php echo form_error('name'); ?></div></div>

<div class="acount_form"><p>Company/Organization Name : </p><input type="text" class="acount-input" size="30" name="company" id="company" tooltipText="Enter referee's company/ organization name" value="<?php echo set_value('company');?>" />

<div class="error-msg2"> <?php echo form_error('company'); ?></div></div>

<div class="acount_form"><p>Email : <span style="color:#F00">*</span></p><input type="text" class="acount-input" size="30" name="email" id="email" tooltipText="Enter referee's valid email id" value="<?php echo set_value('email');?>" />

<div class="error-msg2"> <?php echo form_error('email'); ?></div></div>

<div class="acount_form"><p>Phone No. : <span style="color:#F00">*</span></p><input type="text" class="acount-input" size="30" name="phone_no" id="phone_no" tooltipText="Enter referee's phone no" value="<?php echo set_value('phone_no');?>" />

<div class="error-msg2"> <?php echo form_error('phone_no'); ?></div></div>


<div class="acount_form"><div class="masg3" >
<input class="btn-normal btn-color submit  bottom-pad" type="submit" id="submit-check" value="Submit" /></div></div>

</div>
</form>
<!--EditProfile Start-->

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
