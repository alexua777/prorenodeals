<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb;?>      
<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">
<?php echo $leftpanel;?>
<!-- Sidebar End -->
<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        
                        
<!--ProfileRight Start-->
<div class="profile_right" id="profile_right">
<!--EditProfile Start-->
<div class="editprofile" id="editprofile"> 	 	 	
<div class="notiftext"><h4>Select</h4><h4>Freelancer</h4><h4>Bid Amount</h4><h4>Delivery Within </h4><h4>Post Date </h4></div>
<?php
if(count($bidder)>0)
{
	$currentbidder_id=$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id);
	 $multi_freelancer=$this->auto_model->getFeild("multi_freelancer","projects",'project_id',$project_id);
foreach($bidder as $key=>$val)
{
	
	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$project_id);
	if($multi_freelancer=='Y'){
		
		$allchosenid=explode(",",$currentbidder_id);
		
		?>
<div class="methodbox">
<div class="methodtext1"><h2><input type="checkbox" name="provider[]" class="abc" value="<?php echo $val['bidder_id'];?>" <? if($currentbidder_id && in_array($val['bidder_id'],$allchosenid)){?> checked="checked" <? }?>/></h2></div>
<div class="methodtext1"><h2><strong><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['bidder_id'];?>" target="_blank"><?php echo $val['bidder_details'];?></a></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo CURRENCY;?> <?php echo $val['bidder_amt'];?><?php if($project_type=='H'){ echo "/hr"; }?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days<?php }else{ echo "N/A";}?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo date('d M, Y', strtotime($val['posted_date']));?></strong></h2></div>
</div>
		
		<?
	}else{
	
?>
<div class="methodbox">
<div class="methodtext1"><h2><input type="radio" name="provider" class="abc" value="<?php echo $val['bidder_id'];?>" <? if($currentbidder_id==$val['bidder_id']){?> checked="checked" <? }?>/></h2></div>
<div class="methodtext1"><h2><strong><a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['bidder_id'];?>" target="_blank"><?php echo $val['bidder_details'];?></a></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo CURRENCY;?> <?php echo $val['bidder_amt'];?><?php if($project_type=='H'){ echo "/hr"; }?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days<?php }else{ echo "N/A";}?></strong></h2></div>
<div class="methodtext1"><h2><strong><?php echo date('d M, Y', strtotime($val['posted_date']));?></strong></h2></div>
</div>
<?php
	
	}
}
}
else
{
?>
<div class="myprotext"><p><strong>No freelancer to display</strong></p></div>
<?php
}
?>

</div>
<!--EditProfile End-->
<h1><a class="selected" href="<?php echo VPATH;?>dashboard/myproject_client">Back</a></h1>
<h1 style="float:right;" id="slct_prvd"><a class="selected" href="javascript:void(0)" onClick="prvd();">Select Freelancer</a></h1>
</div>                       
<!--ProfileRight Start-->                       

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
<div style="clear:both;"></div>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>
           
<script>
function prvd()
{
    var selected = $(".abc:checked");
    if(!selected.val()){
        alert('No Freelancer selected!')
    }
    else{
        var selectedValue = selected.val();
        var dataString = 'userid='+selectedValue+'&projectid='+<?php echo $project_id?>;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/getProvider",
			 success:function(return_data)
			 {
				$('#editprofile').html();
				$('#editprofile').html(return_data);
				$('#slct_prvd').hide();
			 }
		});
    }
}
/**
* *************
added column multi_freelancer (Y/N) default name
added column no_of_freelancer int
update chosen_id and bidder_id as verchar 100 default 0

*/
</script>