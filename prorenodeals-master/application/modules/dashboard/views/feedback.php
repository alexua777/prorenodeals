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

<div class="profile_right">
<!--EditProfile Start-->
<?php
$username=$this->auto_model->getFeild('username','user','user_id',$user_id);
$given_name=$this->auto_model->getFeild('username','user','user_id',$given_id);
?>

<h4 class="title-sm">Feedback</h4>
<div class="notiftext"><span>Rating of <?php echo ucwords( $username);?> given by <?php echo ucwords( $given_name);?>.</span></div>
<div class="whiteSec"> 

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
for($i=0; $i < $feedback[0]['flexibility'];$i++)
{
?>
<img src="<?php echo ASSETS;?>images/1star.png" alt="review star"/>
<?php	
}
for($i=0; $i < (5-$feedback[0]['flexibility']);$i++)
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
<span><?php echo $feedback[0]['comments'];?></span>

</div>
</div>
<!--EditProfile End-->

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
<div class="clearfix"></div>

</div>

</div>
</div>               
</section>
