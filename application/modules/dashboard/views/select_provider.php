     
<script src="<?=JS?>mycustom.js"></script>

<section class="sec-60">

<div class="container">
<div class="row">
<?php echo $leftpanel;?>
<!-- Sidebar End -->
<div class="col-md-9 col-sm-8 col-xs-12">
<?php echo $breadcrumb;?> 
<div class="profile_right" id="profile_right">
<!--EditProfile Start-->
<div class="editprofile" id="editprofile"> 	 	 	
<div class="table-responsive">
<table class="table table-dashboard table-hover">
<thead>
	<tr><th>Select</th><th>Freelancer</th><th>Bid Amount</th><th>Delivery Within </th><th>Post Date </th><th>Pause Contract </th></tr>
</thead>
<tbody>

<?php
if(count($bidder)>0)
{   $approvedid=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id));
	$currentbidder_id=$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id);
	 $multi_freelancer=$this->auto_model->getFeild("multi_freelancer","projects",'project_id',$project_id);
	 
	 //echo '<pre>';
	// print_r($bidder);
		//echo '</pre>';
	 foreach($bidder as $key=>$val)
{
	
	$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$project_id);
	if($multi_freelancer=='Y'){
		
		$allchosenid=explode(",",$currentbidder_id);
		
		?>
<tr>
<td>
<input type="checkbox" name="provider[]" class="abc" value="<?php echo $val['bidder_id'];?>" <? if(($currentbidder_id && in_array($val['bidder_id'],$allchosenid)) || ($approvedid && in_array($val['bidder_id'],$approvedid))){?> checked="checked" <? }?> <? if($approvedid && in_array($val['bidder_id'],$approvedid)){?> onclick="return false" readonly <? }?>/><? if($approvedid && in_array($val['bidder_id'],$approvedid)){?><font color=green>Approved</font><? }?>
</td>

<td>
<a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['bidder_id'];?>" target="_blank"><?php echo $val['bidder_details'];?></a>
<?php if($project_type=='H'){?>
 <span id="bid_amtN_<?php echo $val['bidder_id'];?>"><?php echo $val['note'];?>hr/week</span>
<a href="javascript:void(0)" onclick="javascript:$('#hour_divN_<?=$val['bidder_id']?>').show();"><i class="icon-pencil icon-1x"></i></a>
<?php }?>

<?php if($project_type=='H'){?>
 <!----/---------------------Edit note -------------->
<div style="display:none" id="hour_divN_<?=$val['bidder_id']?>">
<input type="text" name="bidder_amt" id="bidder_amtN_<?=$val['bidder_id']?>" class="editinputN" value="<?php echo $val['note'];?>"  /> Enter hr per week
<input type="button" class="setbott" name="submit" value="Set" onclick="edit_bidamountN('<?=$val['bidder_id']?>');"  />

<input type="button" class="setbott" name="submit" value="Cancel" onclick="javascript:$('#hour_divN_<?=$val['bidder_id']?>').hide();" />
</div>
<!----/---------------------Edit note -------------->
<?php }?>


</td>
<td>

<?php echo CURRENCY;?>
<!-------------------------Edit Bid Price-------------->
<span id="bid_amt_<?php echo $val['bidder_id'];?>"><?php echo $val['bidder_amt'];?></span>
<!-------------------------Edit Bid Price-------------->
 <?php if($project_type=='H'){ echo "/hr"; }?>
 <!-------------------------Edit Bid Price-------------->
<a href="javascript:void(0)" onclick="javascript:$('#hour_div_<?=$val['bidder_id']?>').show();"><i class="icon-pencil icon-1x"></i></a>
<div style="display:none" id="hour_div_<?=$val['bidder_id']?>">
<input type="text" name="bidder_amt" id="bidder_amt_<?=$val['bidder_id']?>" class="editinput" value="<?php echo $val['bidder_amt'];?>"  /> 
<input type="button" class="setbott" name="submit" value="Set" onclick="edit_bidamount('<?=$val['bidder_id']?>');"  />
<input type="button" class="setbott" name="submit" value="Cancel" onclick="javascript:$('#hour_div_<?=$val['bidder_id']?>').hide();" />
</div>
<!-------------------------Edit Bid Price-------------->
</td>
 
<td><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days<?php }else{ echo "N/A";}?></td>
<td><?php echo date('d M, Y', strtotime($val['posted_date']));?></td>

<td>
<?php if($val['status']=='N') {?>
<a href="javascript:void(0)" onclick="pausecontractFreelancer('<?php echo $project_id.'@@'.$val['bidder_id'];?>');" class="btn btn-site btn-sm">Pause Contract</a></h2> 
 <?php } else { ?>
<a onclick="recontractFreelancer('<?php echo $project_id.'@@'.$val['bidder_id'];?>');" href="javascript:void(0)" class="btn btn-site btn-sm">Start Contract </a></h2> 	 
	 
<?php  } ?>
</td>
</tr>
		
		<?
	}else{
?>
<tr>
<td><input type="radio" name="provider" class="abc" value="<?php echo $val['bidder_id'];?>" <? if($currentbidder_id==$val['bidder_id']){?> checked="checked" <? }?>/></td>

<td>
<a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $val['bidder_id'];?>" target="_blank"><?php echo $val['bidder_details'];?></a>
<?php if($project_type=='H'){?>
 <span id="bid_amtN_<?php echo $val['bidder_id'];?>"><?php echo $val['note'];?>hr/week</span>
<a href="javascript:void(0)" onclick="javascript:$('#hour_divN_<?=$val['bidder_id']?>').show();"><i class="icon-pencil icon-1x"></i></a>
<?php }?>

<?php if($project_type=='H'){?>
 <!----/---------------------Edit note -------------->
<div style="display:none" id="hour_divN_<?=$val['bidder_id']?>">
<input type="text" name="bidder_amt" id="bidder_amtN_<?=$val['bidder_id']?>" class="editinputN" value="<?php echo $val['note'];?>"  /> Enter hr per week
<input type="button" class="setbott" name="submit" value="Set" onclick="edit_bidamountN('<?=$val['bidder_id']?>');"  />

<input type="button" class="setbott" name="submit" value="Cancel" onclick="javascript:$('#hour_divN_<?=$val['bidder_id']?>').hide();" />
</div>
<!----/---------------------Edit note -------------->
<?php }?>
</td>

<td>

<?php echo CURRENCY;?>
<!-------------------------Edit Bid Price-------------->
<span id="bid_amt_<?php echo $val['bidder_id'];?>"><?php echo $val['bidder_amt'];?></span>
<!-------------------------Edit Bid Price-------------->
 <?php //echo $val['bidder_amt'];?>
 <?php if($project_type=='H'){ echo "/hr"; }?>
  <!-------------------------Edit Bid Price-------------->
<a href="javascript:void(0)" onclick="javascript:$('#hour_div_<?=$val['bidder_id']?>').show();"><i class="icon-pencil icon-1x"></i></a>

<div style="display:none" id="hour_div_<?=$val['bidder_id']?>">
<input type="text" name="bidder_amt" id="bidder_amt_<?=$val['bidder_id']?>" class="editinput" value="<?php echo $val['bidder_amt'];?>"  /> 
<input type="button" class="setbott" name="submit" value="Set" onclick="edit_bidamount('<?=$val['bidder_id']?>');"  />
<input type="button" class="setbott" name="submit" value="Cancel" onclick="javascript:$('#hour_div_<?=$val['bidder_id']?>').hide();" />
</div>
<!-------------------------Edit Bid Price-------------->
 </td>
 
 
<td><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days<?php }else{ echo "N/A";}?></td>
<td><?php echo date('d M, Y', strtotime($val['posted_date']));?></td>

</tr>
<?php
}
}
}
else
{
?>

<tr><td class="text-center" colspan="6">No freelancer to display</td></tr>
<?php
}
?>

</tbody>
</table>
</div>
</div>
<!--EditProfile End-->
<a class="btn btn-warning" href="<?php echo VPATH;?>dashboard/myproject_client">Back</a>
<a class="btn btn-site pull-right" id="slct_prvd" href="javascript:void(0)" onClick="prvd();">Select Freelancer</a>
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
<div style="clear:both;"></div>
                     </div>
                     <!-- Left Section End -->
                  </div>
               </div>

</section>
<script>
function prvd()
{
	 var checkValues = $('input[class=abc]:checked').map(function()
            {
                return $(this).val();
            }).get();
    var selectedValue=checkValues.join(",");     
  //  var selected = $(".abc:checked");
    if(!selectedValue){
        alert('No Freelancer selected!')
    }
    else{
      
       /* console.log(selectedValue);
        return false;*/
        var dataString = 'userid='+selectedValue+'&projectid='+<?php echo $project_id?>;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 dataType: "json",
			 url:"<?php echo VPATH?>dashboard/getProvider",
			 success:function(return_data)
			 {
				$('#editprofile').hide();
				//alert(return_data.msg);
				$('#editprofile').before(return_data.msg);
				$('#slct_prvd').hide();
			 }
		});
    }
}
<!-------------------------Edit Bid Price-------------->
function edit_bidamount(bidder_id)
{
	var bid_amount = $("#bidder_amt_"+bidder_id).val();
	if(bid_amount==''){
		alert('Enter bid amount first.');
		$("#bidder_amt").focus();
	}
	else{        
        var dataString = 'bid_amount='+bid_amount+'&projectid='+<?php echo $project_id?>+'&bidder_id='+bidder_id;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/editBidamount",
			 success:function(return_data)
			 {
				$('#bid_amt_'+bidder_id).html(return_data);
				$('#hour_div_'+bidder_id).hide();
			 }
		});
    }
}
<!-------------------------Edit Bid Price-------------->
function edit_bidamountN(bidder_id)
{
	var note = $("#bidder_amtN_"+bidder_id).val();
	if(note==''){
		alert('Enter note.');
		 $("#bidder_amtN_"+bidder_id).focus();
	}
	else{        
        var dataString = 'note='+note+'&projectid='+<?php echo $project_id?>+'&bidder_id='+bidder_id;
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/editBidnote",
			 success:function(return_data)
			 {
				$('#bid_amtN_'+bidder_id).html(return_data);
				$('#hour_divN_'+bidder_id).hide();
			 }
		});
    }
}


/* 9-March */
function pausecontractFreelancer(data)
{
	//alert(data);
	var res = data.split("@@");
		var project_id =	res[0];
		var  userid		 =   res[1];
	
	 var dataString = 'projectid='+project_id+'&bidder_id='+userid;
	// alert(dataString);
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/pausecontractFreelancer",
			 success:function(return_data)
			 {
				alert("Contract Paused");
				window.location.reload();
				//$('#bid_amtN_'+bidder_id).html(return_data);
				//$('#hour_divN_'+bidder_id).hide();
			 }
		});
	
	return false;
}


function recontractFreelancer(data)
{
	//alert(data);
	var res = data.split("@@");
		var project_id =	res[0];
		var  userid		 =   res[1];
	
	 var dataString = 'projectid='+project_id+'&bidder_id='+userid;
	// alert(dataString);
		  $.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/recontractFreelancer",
			 success:function(return_data)
			 {
				// alert(return_data); return false ;
				alert("Contract Started");
				window.location.reload();
				//$('#bid_amtN_'+bidder_id).html(return_data);
				//$('#hour_divN_'+bidder_id).hide();
			 }
		});
	
	return false;
}
/* 9 march */
</script>