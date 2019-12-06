<div class="table-responsive">
<table class="table table-dashboard table-middle">
<thead><tr><th style="width:30%"><?php echo __('dashboard_myproject_client_project_name','Project Name'); ?></th><th align="center"><?php echo __('dashboard_myproject_client_project_type','Project Type'); ?></th><th align="center"><?php echo __('dashboard_myproject_client_status','Status'); ?></th><th align="center"><?php echo __('dashboard_myproject_client_bid_placed','Bid Placed'); ?></th><th align="center"><?php echo __('dashboard_myproject_client_action','Action'); ?></th><th><?php echo __('dashboard_myproject_posted_date','Posted date'); ?></th></tr>
</thead>
<tbody>		
    

<?php

if(count($projects)>0)
{
foreach($projects as $key=>$val)
{
$val = filter_data($val);
?>
<tr>
<?php 
$visibility="";
if($val['visibility_mode']=="Private"){ 
$visibility=__('dashboard_myproject_private_job','Private Job'); 
}
else{ 
$visibility=__('dashboard_myproject_public_job','Public Job');
}
?>     

<td><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $val['title']." (".$visibility.")"?></a></td>
<td align="center">
<?php if($val['project_type']=="F") { echo "<div class='hourly' title='".__('dashboard_myproject_fixed','Fixed')."''><i class='zmdi zmdi-lock' data-toggle='tooltip' data-placement='top' title='".__('dashboard_myproject_fixed','Fixed')."'></i></div>";} else {
echo "<div class='hourly' title='".__('dashboard_myproject_hourly','Hourly')."'><i class='zmdi zmdi-time' data-toggle='tooltip' data-placement='bottom' title='".__('dashboard_myproject_hourly','Hourly')."'></i></div>"; }?></td>

<td align="center"><?php if($val['project_status']=='Y'){echo "<div class='hourly' data-toggle='tooltip' data-placement='top' title='".__('dashboard_myproject_active','Active')."'><i class='fa fa-check-circle'></i></div>";}else{echo "<div class='hourly' title='".__('dashboard_myproject_waiting_for_admin_approval','Awaiting admin approval')."'><i class='fa fa-spinner'></i></div>";}?></td>
<td align="center"><?php echo $val['bidder_details']?></td>

<td align="center">
<div class="icon-set">
<?php 
if($val['expiry_date_extend']!="Y"){ 
?>
<a class="hidden" href="javascript:void(0);" onclick="actionPerform('EX',<?php echo $val['id'];?>)" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_extend','Extend'); ?>"><i class="fa fa-arrows"></i></a>
<?php
}
?>
<?php               
/*if($val['bidder_details'] >0){ 
?>
<a href="javascript:void(0);" data-toggle="tooltip" onclick="actionPerform('SF',<?php echo $val['id'];?>)" title="<?php echo __('dashboard_myproject_select_freelancer','Select Freelancer'); ?>"><i class="fa fa-gift"></i></a>
<?php
}*/
?> 
<a href="javascript:void(0);" onclick="actionPerform('E',<?php echo $val['id'];?>)" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_edit','Edit'); ?>"><i class="fa fa-edit"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('C',<?php echo $val['id'];?>)" data-toggle="tooltip" title="<?php echo __('dashboard_myproject_close','Close'); ?>"><i class="fa fa-ban"></i></a>
<!--<a href="javascript:void(0);" onclick="actionPerform('IB',<?php echo $val['id'];?>)" data-toggle="tooltip" title="Invite Freelancer"><i class="fa fa-user"></i></a>-->
<?php /*?><a href="javascript:void(0);" onclick="actionPerform('PC',<?php echo $val['id'];?>)" data-toggle="tooltip" title="Pause Contract"><i class="fa fa-pause"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('M',<?php echo $val['id'];?>)"  data-toggle="tooltip" title="Message"><i class="fa fa-envelope-alt"></i></a>		 
<a href="javascript:void(0);" onclick="actionPerform('VF',<?php echo $val['id'];?>)" data-toggle="tooltip" title="View Profile"><i class="fa fa-dashboard"></i></a>		
<a href="javascript:void(0);" onclick="actionPerform('GB',<?php echo $val['id'];?>)" data-toggle="tooltip" title="Give Bonus"><i class="fa fa-money"></i></a>
<a href="javascript:void(0);" onclick="actionPerform('EC',<?php echo $val['id'];?>)" data-toggle="tooltip" title="End Contractor"><i class=" fa fa-user"></i></a><?php */?>
</div>

<span id="extend_span<?php echo $val['id'];?>" style="display: none;">
 
<input type="hidden" name="eid" id="eid<?php echo $val['id'];?>" value="<?php echo $val['id'];?>">
<input type="text" class="form-control input-sm" style="display:inline-block;width:auto" name="extend_day" id="extend_day<?php echo $val['id'];?>" value="" placeholder="No of Days (Max: 15 Days)" onkeypress="return isNumberKey(event)">
<input type="button" class="btn btn-success btn-sm" name="submit" value="Set" onclick="setextend('<?php echo $val['id'];?>')"> 
<input type="button" class="btn btn-warning btn-sm" name="cancel" value="Canel" onclick="hideextend('<?php echo $val['id'];?>')"> 
</span>

<select class="form-control input-sm" style="width:auto;display:none;margin-top:px" id="action_select<?php echo $val['id'];?>" onchange="actionPerform(this.value,<?php echo $val['id'];?>)">
    <option value="">Select</option>                    
    <?php               
        if($val['bidder_details'] >0){ 
    ?>
      <option value="SP">Select a Freelancer</option>
    <?php
        }
?>                    
    
     <?php 
        if($val['expiry_date_extend']!="Y"){ 
     ?>
          <option value="EX">Extend</option>
     <?php
        }
     ?>
    
    <option value="E">Edit</option>
    <option value="C">Close</option>
    <option value="IB">Invite Freelancer</option>    
    <option value="PC">Pause contract</option>
    <option value="M">Message</option>	
    <option value="VF">View Profile</option>
    <option value="GB">Give Bonus</option>					
    <option value="GB">End Contractor</option>	
</select> 
<a href="javascript:void(0)" data-reveal-id="exampleModal" onclick="$('#priject_id').val(<?php echo $val['id'];?>)" style="
float: left;  display: none;" >Invite Guest Freelancer</a> 
<div style="display: none;font-size:13px">
    <a id="spa_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/selectprovider/<?php echo $val['project_id'];?>"> Select a Freelancer</a>
    <a id="eidta_<?php echo $val['id'];?>" href="<?php echo VPATH;?>postjob/editjob/<?php echo $val['id'];?>"> Edit</a> | 
    <a id="closea_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/projectclose/<?php echo $val['id'];?>">Close</a> |
	<a id="closea_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/projectclose/<?php echo $val['id'];?>">Close</a> |
	
    <a id="pc_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/selectprovider/<?php echo $val['id'];?>">Pause contract</a> | 
    
    <a id="m_<?php echo $val['id'];?>" href="<?php echo VPATH;?>message/">Message</a> |
    <a id="vp_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/profile_client/">View Profile</a> |

    
</div>  

</td>
<td><?php echo $this->auto_model->date_format($val['posted_date']);?></td>
</tr>
<?php
}
}
?>
</tbody>
</table>
</div>

<?php echo $links; ?>