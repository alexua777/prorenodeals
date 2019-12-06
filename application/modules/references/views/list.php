
<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>

<!-- Main Content start-->
<?php 
$count=$total_row;
?>

<div class="container">
      <div class="row">
      <?php echo $leftpanel;?>
         <!-- Sidebar End -->
         <div class="col-md-9 col-sm-8 col-xs-12">
           
            
<!--ProfileRight Start-->
<div class="profile_right">

<!--UserPortfolio Start-->
<div class="editport_text">
<h1>All References (<?php echo $count;?>)</h1>
<?php 
if($count<5){ 
?>
<div class="upload_bott"><a href="<?php echo VPATH;?>references/addreferences">+&nbsp;Add New Reference</a></div>
<?php
}
?>
</div>
<div class="editprofile" id="editprofile">
<div class="notiftext"><h4>Referee Name</h4>	<h4>Company Name</h4> 	<h4>Email</h4> 	<h4>Phone No</h4> <h4>Action</h4></div>
<?php 
if($count>0){ 
foreach ($user_reference as $key=>$val){ 
?>

<div class="methodbox">
<div class="methodtext1"><h2><strong><?php echo $val['name'];?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo $val['company'];?></strong></h2></div>

<div class="methodtext1"><h2><strong><?php echo $val['email'];?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo $val['phone_no'];?></strong></h2></div>
<div class="methodtext1"><h2><strong>
<?php
if($val['rating_status']=="Y" && $val['admin_review']=='Y'){ 
?>
<a href="<?php echo VPATH;?>references/viewFeedback/<?php echo $val['id'];?>/">View Feedback</a>
<?php
}
elseif($val['rating_status']=="Y" && $val['admin_review']=='N')
{
echo "Feedback given. waiting for admin approval."; 
}
else
{
echo "Feedback Not Given Yet";	  
}

?>
</strong></h2></div>
<?php        
}

}
else{ 
?>
<p>(No References Added Yet.)</p>
<?php 
}
?>

</div>

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
</div>               
