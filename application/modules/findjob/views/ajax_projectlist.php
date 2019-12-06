
<?php 
if(isset($category))
{
	$cat=$category=str_replace('%20',' ',$category);
	$cate=explode("-",$category);
	$parentc=array();
	foreach($cate as $rw)
	{
		$pcat=$this->auto_model->getFeild('parent_id','categories','cat_name',$rw);
		$parentc[]=$pcat;	
	}
}
else{
	$parentc=array();
	$cat='All';
}
?>
<?php 
$total=count($projects);
?>
<!--<h4 class="title-sm"><span>(<?php // echo $total;?>) Results found.</span></h4>-->
<?php

if(count($projects)>0)
{
foreach($projects as $key=>$val)
{
	$skill=explode(",",$val['skills']);
	
?>
<div class="media">    
    <div class="media-body">  
<?php
if($val['featured']=='Y')
{
?>
<div class="featuredimg"><img src="<?php echo VPATH;?>assets/images/featured_vr.png" alt="" title="Featured"></div>
<?php } ?>

 <p class="designation"><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/"><?php echo ucwords($val['title']);?> </a></p>
	<?php
if($val['visibility_mode']=='Private')
{
?>
<input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt" style="float:right;margin-right: 50%;margin-top: -4%;">
<?php
}
?>

<div class="addthis_sharing_toolbox hidden" data-url="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>" style="float: right;margin-top: -30px;margin-right: 12px;"></div>
<?php
if($val['visibility_mode']=='Private')
{
?>
<input type="button" value="Private: bidding by invitation only" class="logbtn2" name="tt" >
<?php
}
?>
 <p class="bio">
	<?php if($val['project_type']=='F'){echo "Fixed";} else{echo "Hourly";}?> Price: Between <?php echo CURRENCY;?> <?php echo $val['buget_min'];?> and <?php echo CURRENCY;?> <?php echo $val['buget_max'];?> - Posted  <b><?php echo date('M d, Y',strtotime($val['post_date']));?></b>
	</p> 
<?php
$totalbid=$this->jobdetails_model->gettotalbid($val['project_id']);
?>
<p> <b><?php echo $totalbid;?></b> Proposals</p>
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
<p><?php echo substr($val['description'],0,250);?> ... <a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/">more</a></p>
	<ul class="skills"> 
	<?php
	$q = array(
		'select' => 's.skill_name , s.id',
		'from' => 'project_skill ps',
		'join' => array(array('skills s' , 'ps.skill_id = s.id' , 'INNER')),
		'offset' => 200,
		'where' => array('ps.project_id' => $val['project_id'])
	);
	$skills = get_results($q);
	
	?>
    <ul class="skills">    
    	<li>Skills: </li>
		<?php
		foreach($skills as $k => $v)
		{
		?>
		<li><a href="#"><?php echo $v['skill_name'];?></a> </li>  
		<?php } ?>
    </ul>
	<?php
if($cat!='All')
{
	if(in_array($val['category'],$cate))
	{
		$lnki=$category;	
	} 
	else
	{
		$lnki=$category."-".$val['category'];	
	}  
}
else
{
	$lnki=$val['category'];	
}
if(is_numeric($val['sub_category'])){
	$val['sub_category_name'] = $this->auto_model->getFeild('cat_name' , 'categories' , 'cat_id' , $val['sub_category']);
}else{
	$val['sub_category_name'] = $val['sub_category'];
}
$par_cat = $this->auto_model->getFeild('cat_name' , 'categories' , 'cat_id' , $val['category']);
?>
<p class="mar-top">Category<span>: <a href="<?php echo base_url('findjob/browse').'/'.$this->auto_model->getcleanurl($par_cat).'/'.$val['category'].'/'.$this->auto_model->getcleanurl($val['sub_category_name']).'/'.$val['sub_category'];?>"><?php echo $val['sub_category_name'];?></a> </span></p>
<?php /* <p class="mar-top">Category<span>: <a href="#"><?php echo $val['category'];?></a> </span></p> */ ?>

<p>

Posted by: <a style=" color: #205691;text-decoration: none;
" href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['user_id'];?>"><?php echo $val['user']->fname;?> <?php echo $val['user']->lname;?></a>,<?php if($val['user']->city !="" AND is_numeric($val['user']->city)){echo "&nbsp;&nbsp;".getField('Name', 'city', 'id', $val['user']->city).", ";}?>&nbsp;&nbsp;<?php echo $val['user']->country ;?> &nbsp;&nbsp; 
<?php
$code=strtolower($this->auto_model->getFeild('code2','country','Code',$val['user']->country));
//$code=strtolower($this->auto_model->getFeild('code2','country','Code',$val['country']));
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
<?php /*
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
 */ ?>

  <?php
  if($this->session->userdata('user'))
  {
  ?>       
  <a class="btn btn-site btn-sm pull-right" href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/" class="logbtn2">Select this job</a>       
    <?php
    }
	else
	{
	?>
    <a class="btn btn-site btn-sm pull-right" href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/" class="logbtn2">Select this job</a>
    <?php
	}
	?> 
</p> 
</div>
</div>
<?php
}
                        
}
else{
	echo "<div class='alert alert-danger'>No result found</div>";
}
?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53a028a2284897c6"></script>