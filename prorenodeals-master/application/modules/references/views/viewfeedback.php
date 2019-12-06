
            

<?php echo $breadcrumb;?>            


<div class="container">

  <div class="row">

    <?php echo $leftpanel;?> 

<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">

<!--ProfileRight Start-->
<div class="profile_right">
<!--EditProfile Start-->
<?php
$fname=$this->auto_model->getFeild('fname','user','user_id',$user_id);
$lname=$this->auto_model->getFeild('lname','user','user_id',$user_id);
$given_name=$this->auto_model->getFeild('name','references','id',$refer_id);
?>
<h1><a class="selected" href="javascript:void(0);">Feedback</a></h1>
<div class="editprofile"> 
<div class="notiftext"><div class="proposalcss">Rating of <?php echo ucwords( $fname." ".$lname);?> by <?php echo ucwords( $given_name);?>.</div></div>
<div style="clear:both; height:20px;"></div>

<div class="safetybox"><p>Safety :</p>
<?php
for($i=0; $i < $feedback[0]['safety'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['safety']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>

</div>

<div class="safetybox"><p>Flexiblity :</p>
<?php
for($i=0; $i < $feedback[0]['flexiblity'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['flexiblity']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>
</div>

<div class="safetybox"><p>Performence :</p>
<?php
for($i=0; $i < $feedback[0]['performence'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['performence']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>
</div>

<div class="safetybox"><p>Initiative :</p>
<?php
for($i=0; $i < $feedback[0]['initiative'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['initiative']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>
</div>

<div class="safetybox"><p>Knowledge :</p>
<?php
for($i=0; $i < $feedback[0]['knowledge'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['knowledge']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>
</div>

<div class="safetybox"><p>Average rating :</p>
<?php
for($i=0; $i < $feedback[0]['average'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['average']);$i++)
{
?>
<img src="<?php echo ASSETS;?>images/star_3.png" alt="review star"/>
<?php	
}
?>
</div>


<div class="safetybox"><p>Comment :</p>
<p style="text-align:left !important; width:55%;"><?php echo $feedback[0]['comments'];?></p>

</div>
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

            