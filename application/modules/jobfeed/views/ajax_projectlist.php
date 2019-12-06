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
<?php if(count($projects) > 0){foreach($projects as $key=>$val){ 
	$skill=explode(",",$val['skills']);
	?>
	 <div class="media">    
		<div class="media-body">    
		<p class="designation"><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/"> <?php echo ucwords($val['title']);?></a> 
	<?php if(in_array($val['project_id'] , $favourite_project)){ ?><a href="javascript:void(0);" class="pull-right"><img src="<?php echo IMAGE;?>favourite-icon.png" alt="" /></a><?php } ?>
		</p>
		
		<p class="bio"><?php if($val['project_type']=='F'){echo "Fixed";} else{echo "Hourly";}?>- Price: Entry Level <?php echo '('. CURRENCY.') ';?> <?php echo $val['buget_min'];?>  Est. Budget : <?php echo '('.CURRENCY.') ';?><?php echo $val['buget_max'];?>- Posted <?php echo date('M d, Y',strtotime($val['post_date']));?></p>  

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

		
		<p><?php echo substr($val['description'],0,250);?><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?>/">more</a></p>
		</div>        	
		<ul class="skills">    
			<li>Skills: </li>
			<?php foreach($skill as $v){ ?>
			<li><a href="#"><?php echo $v;?></a></li>
			<?php } ?>
			
		</ul>
    </div>
	<?php } }else{  ?>
	<p>No Projects Found.</p>
	<?php } ?>
</div>