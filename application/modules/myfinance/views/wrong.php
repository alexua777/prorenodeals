<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
<div class="row">
<?php echo $leftpanel;?> 
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">
<?php echo $breadcrumb;?>
<ul class="tab">
    <li><a class="selected" href="<?php echo VPATH;?>myfinance/">Add Fund</a></li>
    <li><a href="<?php echo VPATH;?>myfinance/milestone">Milestone</a></li> 
    <li><a href="<?php echo VPATH;?>myfinance/withdraw">Withdraw Fund</a></li> 
    <li><a href="<?php echo VPATH;?>myfinance/transaction">Transaction History</a></li> 
    <li><a href="<?php echo VPATH;?>membership/">Membership</a></li> 
</ul>
<div class="balance"><span><img src="<?php echo ASSETS;?>images/balance2_icon.png"> Balance: </span>$<?php echo $balance;?></div>
<!--EditProfile Start-->
<div class="whiteSec"> 	 	 	

<div class="methodbox"><h1>Wrong Entry</h1></div>

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
</section>