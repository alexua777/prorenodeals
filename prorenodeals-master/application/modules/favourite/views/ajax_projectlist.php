<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>
<?php 
$total=count($projects);
?>
<div class="editprofile" style=" border:#F00 0px solid;"> 	 	 	  	 	 	 	 	 	
<div class="subdcribe-bar">
<ul class="subdcribe-bar-left"><li>Total Jobs (<?php echo $total;?>)</li></ul>
<div class="subdcribe-bar-right"></div>
<div class="clr"></div>
</div>
<?php
if(count($projects)>0)
{
foreach($projects as $key=>$val)
{
	$skill=explode(",",$val['skills']);
?>
<div class="search-job-content clearfix">
<?php
if($val['featured']=='Y')
{
?>
<div class="featuredimg"><img src="<?php echo VPATH;?>assets/images/featured_vr.png" alt="" title="Featured"></div>
<?php }?>
<div class="asd">
<a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/"> <h1> <?php echo ucwords($val['title']);?> 	<br> </h1></a>
<?php
if($val['visibility_mode']=='Private')
{
?>
<input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt" style="float:right;margin-right: 50%;margin-top: -4%;">
<?php
}
?>
</div>
<div class="addthis_sharing_toolbox" data-url="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>" style="float: right;margin-top: -30px;margin-right: 12px;"></div>
<?php
if($val['visibility_mode']=='Private')
{
?>
<input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt" >
<?php
}
?>
<br />
<ul style="float:left" class="search-job-content-minili">
<li><?php if($val['project_type']=='F'){echo "Fixed";} else{echo "Hourly";}?> Price: <b>Between $<?php echo $val['buget_min'];?> and $<?php echo $val['buget_max'];?> </b> </li>
<li>  Posted: <b><?php echo date('M d, Y',strtotime($val['post_date']));?></b>  </li>
<li>  Ends: <b> &nbsp;<?php echo floor((strtotime($val['expiry_date'])-strtotime(date('Y-m-d')))/(60*60*24))?>&nbsp;days&nbsp;Left&nbsp;</b>   </li>
<?php
$totalbid=$this->jobdetails_model->gettotalbid($val['project_id']);
?>
<li class="bor-right"> <b><?php echo $totalbid;?></b> Proposals</li>
</ul>
<?php
//////////////////////For Email/////////////////////////////
$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$replacement = "[*****]";
$val['description']=preg_replace($pattern, $replacement, $val['description']);
/////////////////////Email End//////////////////////////////////

//////////////////////////For URL//////////////////////////////
$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
$replacement = "[*****]";
$val['description']=preg_replace($pattern, $replacement, $val['description']);
/////////////////////////URL End///////////////////////////////

/////////////////////////For Bad Words////////////////////////////
$healthy = explode(",",BAD_WORDS);
$yummy   = array("[*****]");
$val['description'] = str_replace($healthy, $yummy, $val['description']);
/////////////////////////Bad Words End////////////////////////////

/////////////////////////// For Mobile///////////////////////////////

$pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
$replacement = "[*****]";
$val['description'] = preg_replace($pattern, $replacement, $val['description']);

////////////////////////// Mobile End////////////////////////////////
?>	
<p><?php echo substr($val['description'],0,250);?> ...</p>
<p class="mar-top">Skills<span>: 
<?php
foreach($skill as $v)
{
?>
<a href="#"><?php echo $v;?></a>   
<?php }?>
</span></p>
<p>

<p class="mar-top">Category<span>: <a href="#"><?php echo $val['category'];?></a> </span></p>
<p>

Posted by: <a style=" color: #205691;text-decoration: none;
" href="<?php echo VPATH;?>employerdetails/showdetails/<?php echo $val['user_id'];?>"><?php echo $val['user']->fname;?></a>,<?php if($val['user_city']!=""){echo "&nbsp;&nbsp;".$val['user_city'].", ";}?>&nbsp;&nbsp;<?php echo $val['user_country'];?> &nbsp;&nbsp; 
<?php
$code=strtolower($this->auto_model->getFeild('code2','country','Name',$val['user_country']));
?>
<img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $code;?>.png"> &nbsp;&nbsp;
 <?php
 if($val['project_type']=='F')
 {
 ?>
 <img src="<?php echo VPATH;?>assets/images/fixed.png">
 <?php
 }
 else
 {
 ?>
 <img src="<?php echo VPATH;?>assets/images/hourly.png">
 <?php
 }
 ?>
<?php
 if($val['environment']=='ON')
 {
 ?>
 <img src="<?php echo VPATH;?>assets/images/onlineicon.png"> 
 <?php
 }
 else
 {
 ?>
 <img src="<?php echo VPATH;?>assets/images/offlineicon.png">
 <?php
 }
 ?>
 </p>
  <?php
  if($this->session->userdata('user'))
  {
  ?>       
  <a style="float: right;padding-right: 1%;" href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/" class="logbtn2">Select this job</a>       
    <?php
    }
	else
	{
	?>
    <a style="float: right;padding-right: 1%;" href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/" class="logbtn2">Select this job</a>
    <?php
	}
	?>  
</div>
<?php
}
                        
}
else{
	echo "No result found";
}
?>
</div>