
<!-- custom check For freelancer-->
<?php 
$user=$this->session->userdata('user');
if($user[0]->account_type == 'freelancer') : ?>
<div class="h_bar"> 
<div class="container">

<div class="oNavTabpanel oNavInline">
<nav class="oPageCentered" role="navigation">
<ul class="oSecondaryNavList">
<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH;?>findjob">Find Jobs</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" href="#">Saved Jobs</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" href="#">Proposals</a>
</li>


<li class="isCurrent">
<a class="oNavLink isCurrent" href="<?php echo VPATH;?>dashboard">Profile</a>
</li>
<li class="isCurrent">
<a class="oNavLink isCurrent" href="#">My Stats</a>
</li>

<li class="isCurrent">
<a class="oNavLink isCurrent" href="#">Tests</a>
</li>

</ul>
</nav>
</div>
</div>
</div>
<?php endif;?>
<!-- custom check for FreeLancer ends Here -->
<?php echo $breadcrumb; ?>      

<script src="<?= JS ?>mycustom.js"></script>

<!-- Main Content start-->
<div class="container">
    <div class="row">			
        <?php echo $leftpanel; ?> 

        <!-- Sidebar End -->

	<div class="col-md-9 col-sm-8 col-xs-12">

           
	<div class="profile_right">
                <?
                if ($this->session->flashdata('notApprove')) {
                ?>
                <div class="alert alert-danger" style="width:100%">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('notApprove') ?>
                </div>
                <?php
                }
                ?>


                    <?php
                    if ($this->session->flashdata('skill_succ')) {
                        ?>
                        <div class="success alert-success alert"><i class="icon-ok icon-2x"></i>&nbsp;<?php echo $this->session->flashdata('skill_succ'); ?></div>
                        <?php }
                    ?>



                    <div class="clearfix"></div>

                    </div><div class="latest_worbox lst clearafter"><div class="latest_text"><h1>Skills</h1></div>
                        <div class="balance2"><span><img src="<?php echo ASSETS; ?>images/balance2_icon.png"> Balance: </span><?php echo CURRENCY; ?> <?php echo $balance; ?></div>
                        <div class="clearfix"></div>
                        <div class="latest_work clearafter">

                            <div class="notifications">

                                <h3 id="all_skills">

                                    <?php
                                    if ($user_skill != "") {
                                        foreach ($user_skill as $key => $val) {
                                            ?>
                                            <a href="<?php echo VPATH; ?>findtalents/filtertalent/<?php echo $val['id']; ?>/All/" class="skilslinks"><?php echo $val['skill_name']; ?></a> &nbsp;<span class="delete_remove" style="display:none;"><a href="javascript:void(0)" title="Delete" onclick="userrmv_skill('<?php echo $val['id']; ?>')"><i class="fa fa-trash"></i></a></span>              
                                            <?php
                                        }
                                    } else {
                                        echo "No Skill Set Yet";
                                    }
                                    ?>        


                                </h3>
                                <div id="tags" style="display:none;">
                                    <input class="tagging" name="subskill" type="text" value="" data-role="tagsinput"/></div>
                                <div class="edit_bott">
                                    <a id="edt" href="javascript:void(0);" onclick="addspan();" style="display:inline;">Edit</a>
                                    <div id="sv_dv" style="display:none;"><a href="javascript:void(0);" onclick="saveskill();" style="margin-right:10px">Save</a><a href="javascript:void(0);" onclick="rmvspan();">cancel</a></div>
                                </div>
                            </div></div></div>
                          
<div class="latest_worbox lst">
                    
                    <?php if($account_type == 'employee') {

?> 
                    
                    <!-- custom code for employee -->
 <div class="employee" id="employee">
                        <div class="latest_text" style="width:100%;margin-bottom: 5px;"><h1>My Project As Employer</h1>
                        </div>
                        <div class="clearfix"></div>

                        <div class="clearafter">

                            <div class=" ">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="<?=CSS?>datatable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="<?=CSS?>datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">
    jQuery(document).ready(function() {
        jQuery('#example').dataTable({
        columns: [
            {},
            { },
            { orderable:      false, },
            {  },
            { orderable:      false,},
            { }
        ],
        "order": [[ 5, "desc" ]]
        });
        jQuery('#example1').dataTable({
        columns: [
            {},
            { },
            { orderable:      false, },
            { orderable:      false, },
            { },
            { }
        ],
        "order": [[ 4, "desc" ]]
        });
    } );
</script>
<div class="profile_right dashorad_project" id="profile_right">
<h1><a class="selected" href="javascript:void(0)" onClick="projects('O');">Open Projects</a></h1>
<h1><a href="javascript:void(0)" onClick="projects('P');">Active</a></h1>  
<!--EditProfile Start-->
<div class="editprofile"> 

<table id="example" class="table table-hover">
<thead><tr><th>Project Name</th><th>Project Type</th><th>Status</th><th>Bid Placed</th><th>Action</th><th>Posted date</th></tr>
</thead>
<tbody>		
            

<?php
if(count($projects)>0)
{
foreach($projects as $key=>$val)
{
?>
<tr>
<?php 
 $visibility="";
 if($val['visibility_mode']=="Private"){ 
    $visibility="Private Job"; 
 }
 else{ 
     $visibility="Public Job";
 }
?>     

<td><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $val['title'];?></a></td>
<td><?php if($val['project_type']=="F") { echo "Fixed";} else {
echo "Hourly"; }?></td>
<td><?php if($val['project_status']=='Y'){echo "Active";}else{echo "Awaiting admin approval";}?></td>
<td><?php echo $val['bidder_details']?></td>
<td>
                        
     
     <span id="extend_span<?php echo $val['id'];?>" style="display: none;">
         
        <input type="hidden" name="eid" id="eid<?php echo $val['id'];?>" value="<?php echo $val['id'];?>">
        <input type="text" name="extend_day" id="extend_day<?php echo $val['id'];?>" value="" placeholder="No of Days (Max: 15 Days)" onkeypress="return isNumberKey(event)">
        <input type="button" name="submit" value="Set" onclick="setextend('<?php echo $val['id'];?>')"> &nbsp;
        <input type="button" name="cancel" value="Canel" onclick="hideextend('<?php echo $val['id'];?>')"> 

     </span>

        <select style="width: 100%; " id="action_select<?php echo $val['id'];?>" onchange="actionPerform(this.value,<?php echo $val['id'];?>)">
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
        </select> 
        <a href="javascript:void(0)" data-reveal-id="exampleModal" onclick="jQuery('#priject_id').val('<?php echo $val['id'];?>')" style="
float: left;" >Invite Guest Freelancer</a> 
        <div style="display: none;">
            <a id="spa_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/selectprovider/<?php echo $val['project_id'];?>"> Select a Freelancer</a>
            <a id="eidta_<?php echo $val['id'];?>" href="<?php echo VPATH;?>postjob/editjob/<?php echo $val['id'];?>"> Edit</a> | 
            <a id="closea_<?php echo $val['id'];?>" href="<?php echo VPATH;?>dashboard/projectclose/<?php echo $val['id'];?>">Close</a> |
            <?php
            $skill_id="";
            if(strstr($val['skills'],','))
            {
                $skills=explode(",",$val['skills']);	
                foreach($skills as $key=>$value)	
                {
                    $id=$this->auto_model->getFeild('id','skills','skill_name',$value,'','','');
                    $skill_id.=$id."-";
                }	
                $skill_id=rtrim($skill_id,"-");	
            }
            else
            {
                $skill_id=$this->auto_model->getFeild('id','skills','skill_name',$val['skills'],'','','');
            }
            ?>
            <a id="iba_<?php echo $val['id'];?>" href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $val['id'];?>/<?php echo $skill_id;?>/All/">Invite Freelancers</a> |                      
        </div>  
      
</td>
<td><?php echo $this->auto_model->date_format($val['posted_date']);?></td>
</tr>
<?php
}
}

?>

</tbody></table>
</div>
<!--EditProfile End-->

</div>   
</div>
</div>

</div>

<?php } ?>

<!--custom code  for freelancer-->
<?php if($account_type=='freelancer') {

?> 
<div class="freelancer" id="freelancer">
<div class="latest_text" style="width:100%;margin-bottom: 5px;">
<h1>My Project As Freelancer</h1></div>
<div class="clearfix"></div>
<table id="example1" class="table table-hover">
<thead>
<tr><th>Project Name</th><th>Project Type</th><th>Bid Amount</th><th>Duration</th><th>Posted date</th><th>Status</th></tr>
</thead>
<tbody>
<?php
if(count($proposals)>0)
{
foreach($proposals as $key=>$val)
{
$project_name=$this->auto_model->getFeild('title','projects','project_id',$val['project_id']);
$status=$this->auto_model->getFeild('status','projects','project_id',$val['project_id']);
$bidder_id=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$val['project_id']));
$chosen_id=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$val['project_id']));
$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$val['project_id']);
$type="";
if($project_type=="F")
{
$type="Fixed";
}
else
{
$type="Hourly";
}
?>
<tr><td><a href="<?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>"><?php echo $project_name;?></a></td>
<td><?php echo $type;?></td>
<td> <?php echo CURRENCY;?> <?php echo $val['bidder_amt'];?><?php if($project_type=='H'){ ?>/hr <?php } ?></td>
<td><?php if($project_type=='F'){?><?php echo $val['days_required'];?> days <?php }else{ echo "N/A";}?></td>
<td><?php echo $this->auto_model->date_format($val['add_date']);?></td>
<td>
<?php
if($bidder_id && in_array($user_id,$bidder_id) && $status!='O')
{
echo "Bid Won";
}
elseif($chosen_id && in_array($user_id,$chosen_id) &&  ($status=='F' || $status=='P'))
{
?>
<a href="javascript:void(0);" onclick="accept_offer('<?php echo $val['project_id'];?>')">Accept offer</a> | <a href="javascript:void(0);" onclick="decline_offer('<?php echo $val['project_id'];?>')">Decline offer</a>
<?php
}
elseif($bidder_id && !in_array($user_id,$bidder_id) && $status!='O' && $status!='F')
{
echo "Bid Lost";
}
else
{
echo "Offer Waiting";
}
?>
</td></tr>
<?php
}
}

?>	
</tbody></table>
                        
                        
</div>   
<?php } ?>                          
</div>
                    
<?php /*?>

                    <div class="latest_worbox lst">

                        <div class="latest_text"><h1>Notification</h1></div>
                        <div style="clear:both;"></div>

                        <div class="latest_work clearafter">

                            <div class="notifications ">
<?php /* ?><div class="notifbox">
<a class="rmv_notof" href="javascript:void(0)" onclick="javascript: if(confirm('Are you sure want to delete?')){window.location.href='<?php echo VPATH.'notification/delete/'.$val['id'];?>'}"><img src="<?php echo ASSETS;?>images/bid_icon.png" /></a>
<p>Sourav Dey has been placed a bid on Test Hourley Job</p>
<span>Apr 20,2015</span>
</div><?php *//* ?>


                                <?php
                                foreach ($notification as $row) {
                                    ?>
                                    <div class="notifbox">

                                        <p><?php echo html_entity_decode($row['notification']); ?></p>
                                        <span><?php echo date('d M, Y', strtotime($row['add_date'])); ?></span>
                                    </div>
<?php
}
?>

                            </div>
                        </div>
                    </div>

<?php */?>



                    <div class="testing_box tst_box"><div class="pb">

                            <div class="pba">Last Login :</div>

                            <div class="pbb"><?php echo date('d M Y, h:i:s', strtotime($ldate)) ?></div>

                            <div class="pbc">Balance Amount (<?php echo CURRENCY; ?>):</div>

                            <div class="pbd"><strong><?php echo $balance; ?></strong></div>

                            <div class="clr"></div>

                        </div>  

                        <div class="pb ac">Your Profile is <?php echo floor($completeness); ?>% Complete</div>
                    </div>







                    <!--<div class="latest_worbox pst">
                    
                    <div class="latest_text"><h1>Fusion Chart</h1></div>
                    
                    <div class="latest_work">
                    
                    <div class="notifications">
                    
                    <span style="color: #535353;font-family: Arial,Helvetica,sans-serif;"></span>
                    
                    <p style="padding-left: 20px;">No Chart</p>  <div style="height:20px;" class="clear"></div>
                    
                    </div></div></div> -->





                </div>                       

               
<?php
if (isset($ad_page)) {
$type = $this->auto_model->getFeild("type", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
if ($type == 'A') {
$code = $this->auto_model->getFeild("advertise_code", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
} else {
$image = $this->auto_model->getFeild("banner_image", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
$url = $this->auto_model->getFeild("banner_url", "advartise", "", "", array("page_name" => $ad_page, "add_pos" => "M"));
}

if ($type == 'A' && $code != "") {
?>
                    <div class="addbox2">
                    <?php
                    echo $code;
                    ?>
                    </div>                      
                    <?php
                } elseif ($type == 'B' && $image != "") {
                    ?>
                    <div class="addbox2">
                        <a href="<?php echo $url; ?>" target="_blank"><img src="<?= ASSETS ?>ad_image/<?php echo $image; ?>" alt="" title="" /></a>
                    </div>
                        <?php
                    }
                }
                ?>
            <div class="clearfix"></div>

        </div>

        <!-- Left Section End -->

    </div>
</div>

<div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;" >
<h3> Invite Friends To this Project</h3>
<div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
<form name="invitefriend" action="<?php echo VPATH;?>invitetalents/inviteGuestFreelancer" method="post">
<div class="mainacount" id="login_frm">
<input type="hidden" name="priject_id" id="priject_id" value="">

    <div class="acount_form">
        <p>Friend's Email :</p>
        <input type="text" id="femail" name="femail[]" value="" class="acount-input" >                                    
        <div class="error-msg3" id="femailError"><?php echo form_error('femail');?></div>
    </div>
    <div class="acount_form">
        <p>Friend's Name :</p>
        <input type="text" value="" name="fname[]" id="fname" class="acount-input" >                                   
        <div class="error-msg3" id="fnameError"><?php echo form_error('fname');?></div>
    </div>

    <div id="add_more_div">

    </div> 

<input type="button"  class="btn-normal btn-color submit bottom-pad2" value="Add More" style="float: right;margin-right: 95px;" onClick="addFRM()">                            
                  
    <div class="acount_form">
        <div class="masg3">
            <input type="submit" name="invite" class="btn-normal btn-color submit bottom-pad2" value="Invite"  onClick="return invitecheck();">
         
        </div>
    </div>   
</div>
</form>
</div>
<a class="close-reveal-modal">&#215;</a>
</div>

<!-- Content End -->
<link rel="stylesheet" href="<?php echo ASSETS ?>tags/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo ASSETS ?>tags/app.css">
<script src="<?php echo ASSETS;?>js/jquery.reveal.js"></script>
<script src="<?php echo ASSETS ?>tags/typeahead.bundle.min.js"></script>
<script src="<?php echo ASSETS ?>tags/bootstrap-tagsinput.js"></script>
<script>
function projects(type)
{
	//alert(type);
	var dataString= "status="+type;
	//alert(dataString);
  jQuery.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo VPATH;?>dashboard/project_dashboard",
     success:function(return_data)
     {
     	//alert(return_data);
		jQuery('.dashorad_project').html('');
		jQuery('.dashorad_project').fadeOut("slow");
		jQuery('.dashorad_project').fadeIn("slow");
		jQuery('.dashorad_project').html(return_data);
		     
		jQuery('#example').dataTable({
				columns: [
					{},
					{ },
					{  },
					
					{ orderable:      false,},
					{ }
        		],
				"order": [[ 4, "desc" ]]
				});	 
	}
    });
	
}
 function showextend(i){ 
       jQuery("#extend_span"+i).show();
       jQuery("#action_select"+i).hide();
    }
    function hideextend(i){ 
       jQuery("#extend_span"+i).hide();
       jQuery("#action_select"+i).show();
    }
    
 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

    
    function setextend(i){ 
       var id=jQuery("#eid"+i).val();
       var extday=jQuery("#extend_day"+i).val();	   
       if(extday<16){ 
         window.location.href="<?php echo VPATH;?>dashboard/projectextend/"+id+"/"+extday;
       }
       
    }
    
    function addFRM(){ 
       jQuery("#add_more_div").append("<div class='acount_form'><p>Friend's Email :</p><input type='text' id='femail' name='femail[]' value='' class='acount-input' ></div><div class='acount_form'><p>Friend's Name :</p><input type='text' value='' name='fname[]' id='fname' class='acount-input' ><div class='error-msg3' id='fnameError'><?php echo form_error('fname');?></div></div>");   
    }
    
    function actionPerform(v,i){ 
	//alert(v);alert(i);
        if(v=="E"){ 
            window.location.href=jQuery("#eidta_"+i).attr('href');
        }
        else if(v=="C"){ 
          if(confirm('Are you sure to close this job?'))
		  {
		  	window.location.href=jQuery("#closea_"+i).attr('href');
		  }
        } 
        else if(v=="IB"){ 
          window.location.href=jQuery("#iba_"+i).attr('href');
        }
        else if(v=="SP"){ 
          window.location.href=jQuery("#spa_"+i).attr('href');
        }        
        else if(v=="IBG"){ 
         jQuery('#priject_id').val(i);        
        }
        else if(v=="EX"){ 
           showextend(i);
        }        
        
    }
	/******************************/
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substrRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            jQuery.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push({value: str});
                }
            });
            cb(matches);
        };
    };
    var states = [<?php echo $ahead; ?>];
    jQuery('.tagging').tagsinput({
        typeaheadjs: {
            name: 'states',
            displayKey: 'value',
            valueKey: 'value',
            source: substringMatcher(states)
        }
    });


    function addspan()
    {
        jQuery('.delete_remove').show();
        jQuery('#tags').show();
        jQuery('#edt').hide();
        jQuery('#sv_dv').show();

    }
    function rmvspan()
    {
        jQuery('.delete_remove').hide();
        jQuery('#tags').hide();
        jQuery('#edt').show();
        jQuery('#sv_dv').hide();

    }
    function userrmv_skill(id)
    {
        var datastring = "id=" + id;
        jQuery.ajax({
            data: datastring,
            type: 'post',
            url: '<?php echo VPATH; ?>dashboard/delete_skill/' + id,
            success: function(return_data) {

                jQuery('#all_skills').html(return_data);

            }

        });
    }
    function saveskill()
    {
        var skill = jQuery('.tagging').val();
        var datastring = "skill=" + skill;
        jQuery.ajax({
            data: datastring,
            type: 'post',
            url: '<?php echo VPATH; ?>dashboard/add_skill/',
            success: function(return_data) {

                jQuery('#all_skills').html(return_data);
                jQuery('#tags').hide();
                jQuery('#edt').show();
                jQuery('#sv_dv').hide();
            }

        });
    }
</script>
<script>
function accept_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  jQuery.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/acceptoffer",
			 success:function(return_data)
			 {
				jQuery('#editprofile').html();
				jQuery('#editprofile').html(return_data);
			 }
		});
}
function decline_offer(project_id)
{
    
        var pid=project_id;
		//alert(pid); die();
		var dataString = 'userid='+<?php echo $user_id?>+'&projectid='+pid;
		  jQuery.ajax({
			 type:"POST",
			 data:dataString,
			 url:"<?php echo VPATH?>dashboard/declineoffer",
			 success:function(return_data)
			 {
				jQuery('#editprofile').html();
				jQuery('#editprofile').html(return_data);
			 }
		});
}
</script>