<?php echo $breadcrumb;?>      
<script src="<?=JS?>mycustom.js"></script>

<div class="container">
  <div class="row">
	<?php echo $leftpanel;?>
	 <!-- Sidebar End -->
	 <div class="col-md-9 col-sm-8 col-xs-9">
	   
		
<!--ProfileRight Start-->
<div class="profile_right">
<?php
//print_r($message);
?>
<!--MessageDetais Start-->
<div class="editprofile">
<div class="notiftext"><div class="proposalcss">Conversation</div></div>
<?php
if(count($message)>0)
{
foreach($message as $key=>$val)
{
$sender_fname=$this->auto_model->getFeild('fname','user','user_id',$val['sender_id']);
$sender_lname=$this->auto_model->getFeild('lname','user','user_id',$val['sender_id']);        
?>
<div class="message-bubble">
<div class="posted_by_name"><a target="_blank" href="<?php echo VPATH."clientdetails/showdetails/".$val['sender_id'] ?>"><?php if($val['sender_id']==$user_id){echo "Me";}else{echo ucwords($sender_fname)." ".ucwords($sender_lname);}?></a></div>
<div class="messge_body"><?php echo $val['message'];?><br /> 
<?php
if($val['attachment']!='')
{
?>
<a href="<?php echo VPATH;?>assets/question_file/<?php echo $val['attachment']?>" target="_blank"><?php echo $val['attachment'];?></a>
<?php	
}
?>
<span><?php echo ucwords(date('d M,Y H:i:s',strtotime($val['add_date'])));?></span></div>
<div class="clearfix"></div>
</div>
<?php
}
}
else
{
echo "No conversation yet..";	
}
?>
<p id="pagi">
<?php  
if(isset($links))
{                     
echo $links;   
}
?> 
</p>
</div>
<?php
$project_name=$this->auto_model->getFeild('title','projects','project_id',$project_id);
?>


<div class="editprofile">
<div class="notiftext"><div class="proposalcss">Project Name: <?php echo ucwords($project_name);?></div></div>
<div style="clear:both; height:15px;"></div>
<form method="post" name="uploadmessage" action="<?php echo VPATH;?>message/details/<?php echo $sender_id;?>/<?php echo $project_id;?>" enctype="multipart/form-data">
<input type="text" name="recipient_id" value="<?php echo $sender_id;?>"/>
<input type="text" name="sender_id" value="<?php echo $user_id;?>"/>
<input type="text" name="project_id" value="<?php echo $project_id;?>"/>
<div class="acount_form"><p>Post Message :</p><textarea rows="3" id="message" name="message" class="acount-input"></textarea>

<div class="error-msg2"><?php echo form_error('message'); ?></div>

</div>
<div class="acount_form"><p>Attachment :</p><input type="file" name="userfile" size="30" class="acount-input"><br/><h3><span style="color:red;width:100%;" class="pull-left">File must be zip ,jpg ,jpeg ,gif ,png ,doc ,docx ,pdf ,xls ,xlsx ,txt.</span></h3></div>

<div class="masg3">
<input type="submit" name="submit" class="btn-normal btn-color submit bottom-pad2" value="Submit" >

<input type="button" name="button" class="btn-normal btn-color submit bottom-pad2" value="Cancel" onClick="javascript:window.history.back(-1);">
</div>
</form>
</div>   


</div>
<!--MessageDetais End-->

</div>                       
<!--ProfileRight Start-->                       
	   
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
