<?php 
$user=$this->session->userdata('user');
$accountType=$user[0]->account_type;
    if(isset($skill))
    {
            $cat=$skill;
			$parentc="";
			$pcat=$this->auto_model->getFeild('parent_id','skills','id',$cat);
			$parentc=$pcat;	
		
    }
    else{
            $cat='All';
			$parentc="";
    }

    if(isset($country))
    {
            $coun=$country;
    }
    else{
            $coun='All';
    }
	if(isset($city))
    {
            $ct=$city;
    }
    else{
            $ct='All';
    }
	if(isset($plans))
    {
            $plans=$plans;
    }
    else{
            $plans='All';
    }
    
    
    
?>

<!-- Content Start -->
        
		 
<?php if($accountType == 'employee'){?>		
<div class="h_bar"> 
<div class="container">

<div class="oNavTabpanel oNavInline">
    <nav class="oPageCentered" role="navigation">
            <ul class="oSecondaryNavList">
	<li class="isCurrent">
	 <a class="oNavLink isCurrent" href="<?php echo VPATH;?>findtalents/myfreelancer/">My Freelancers</a>
	</li>
	<li class=""><a class="oNavLink" href="<?php echo VPATH;?>findtalents">Find Freelancers</a>
	</li>
                                                                        
                            </ul>
        </nav>
</div>
</div>
</div>
<?php } ?>
		 
		 
<!-- Title, Breadcrumb Start-->
<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>

<div class="container">
<div class="row">

<div class='sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12'>
<!--LeftCategory Start-->
<div class="leftcategory">

<?php
foreach($parent_skill as $key =>$val){ 
?>
<div class="catcontent">
<h1 id="h1_<?php echo $val['id'];?>" style="cursor: pointer;" onclick="shwcat('<?php echo $val['id'];?>')"><?php echo $val['skill_name'];?></h1>
<div id="sub_<?php echo $val['id'];?>" style="<?php if($val['id']!=$parentc){?>display:none;<?php }?>overflow-y: scroll; height: 290px;">
<?php
$sub_skill=$this->auto_model->getskill($val['id']);

foreach ($sub_skill as $key => $sval){
if($cat!='All')
{
if($sval['id']==$cat)
{
$lnk='All';	
} 
else
{
$lnk=$sval['id'];	
}  
}
else
{
$lnk=$sval['id'];	
}
?> 
<div class="catlink"><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $lnk;?>/<?php echo $coun."/".$ct."/".$plans."/";?>'>
<div class="unchecked <?php if($cat!='All'){if($sval['id']==$cat){echo  'select_chkbx';}}?>"></div> <h2><?php echo $sval['skill_name'];?></h2></a>
</div>
<?php
}
?>
</div>
</div>
<?php
}
?>
<div class="catcontent">
<h3>Membership Plan</h3>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo "/".$coun."/".$ct."/All/";?>" <?php if($plans=='All'){echo  'class="selected"';}?>>All</a></h2></div>
<?php
foreach($all_plans as $key=>$val)
{
?>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/".$ct."/".$val['id']."/";?>" <?php if($plans==$val['id']){echo  'class="selected"';}?>><?php echo $val['name'];?></a></h2></div>
<?php
}
?>
</div>


<div class="catcontent">
<h3>Country</h3>
<div class="live-pro-list clearfix" style='max-height:300px;overflow-x: hidden;overflow-y: scroll;'>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo "/All/".$ct."/".$plans."/";?>" <?php if($coun=='All'){echo  'class="selected"';}?>>All</a></h2></div>
<?php
foreach($countries as $key=>$val)
{
?>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $val['name']."/".$ct."/".$plans."/";?>" <?php if($coun==$val['name']){echo  'class="selected"';}?>><?php echo $val['name'];?></a></h2></div>
<?php
}
?>
</div>
</div>

<?php
if($coun!='All')
{
$countr=str_replace("%20"," ",$coun);
$country_code=$this->auto_model->getFeild('Code','country','Name',$countr);
$cti=$this->autoload_model->getCity($country_code);
?>

<div class="catcontent">
<h1>City</h1>
<div class="live-pro-list clearfix" style='max-height:300px;overflow-x: hidden;overflow-y: scroll;'>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/All/".$plans."/";?>" <?php if($ct=='All'){echo  'class="selected"';}?>>All</a></h2></div>
<?php
foreach($cti as $key=>$val)
{
?>
<div class="catlink"><h2><a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/".$val['name']."/".$plans."/";?>" <?php if($ct==$val['name']){echo  'class="selected"';}?>><?php echo $val['name'];?></a></h2></div>
<?php
}
?>
</div>
</div>

<?php
}
?>

</div>

<!--LeftCategory End-->   
<div class="clearfix"></div>


<!--Old Sidebar Start-->    
<!--<div class='accordionMod panel-group'>
<?php
/*foreach($parent_skill as $key =>$val){ 
?>    
<div class='accordion-item' id="<?php echo $val['id'];?>">
<h4 class='accordion-toggle'><?php echo $val['skill_name'];?></h4>
<section class='accordion-inner panel-body'> 	
<ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>
<?php
$sub_skill=$this->auto_model->getskill($val['id']);

foreach ($sub_skill as $key => $sval){
?> 
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $sval['id'];?>/<?php echo $coun."/".$ct."/".$plans."/";?>' id="<?php echo $sval['id'];?>"><?php echo $sval['skill_name'];?></a></li>
<?php    
}
?>
</ul> 
</section>
</div>
<?php }*/?>

<div class='accordion-item' id="accod_country">
<h4 class='accordion-toggle'>Membership Plan</h4>
<section class='accordion-inner panel-body'>
<ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>							
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo "/".$coun."/".$ct."/All/";?>'><strong>All</strong></a></li>
<?php
foreach($all_plans as $key=>$val)
{
?>
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/".$ct."/".$val['id']."/";?>'><?php echo $val['name'];?></a></li>
<?php
}
?>
</ul>
</section>
</div>


<div class='accordion-item' id="accod_country">
<h4 class='accordion-toggle'>Country</h4>
<section class='accordion-inner panel-body'>
<ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;max-height: 300px;overflow-x: hidden;overflow-y: scroll;'>							
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo "/All/".$ct."/".$plans."/";?>'><strong>All</strong></a></li>
<?php
foreach($countries as $key=>$val)
{
?>
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $val['name']."/".$ct."/".$plans."/";?>'><?php echo $val['name'];?></a></li>
<?php
}
?>
</ul>
</section>
</div>

<?php
if($coun!='All')
{
$countr=str_replace("%20"," ",$coun);
$country_code=$this->auto_model->getFeild('Code','country','Name',$countr);
$cti=	$this->autoload_model->getCity($country_code);
?>
<div class='accordion-item' id="accod_">
<h4 class='accordion-toggle'>City</h4>
<section class='accordion-inner panel-body'>
<ul class='live-pro-list clearfix' id="country_ul" aria-hidden='false' style='display: block;max-height: 300px;overflow-x: hidden;overflow-y: scroll;'>							
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/All/".$plans."/";?>' <?php if($ct=='All'){echo  'class="selected"';}?>>All</a></li>
<?php
foreach($cti as $key=>$val)
{
?>
<li><a href='<?php echo VPATH;?>findtalents/filtertalent/<?php echo $cat;?>/<?php echo $coun."/".$val['name']."/".$plans."/";?>' <?php if($ct==$val['name']){echo  'class="selected"';}?>><?php echo $val['name'];?></a></li>
<?php
}
?>
</ul>
</section>
</div>
<?php
}
?>

</div>-->
<!--Old Sidebar End-->
</div>


<div class="col-md-9 col-sm-8 col-xs-12">


<!--ProfileRight Start-->
<div class="profile_right">
<?php
if($this->session->flashdata('invite_success'))
{
?>
<div class="success alert-success alert"><?php echo $this->session->flashdata('invite_success');?></div>
<?php
}
?>
<!-- /input-group -->

<div class="input-group">

<div class="input-group-btn">
<!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" disabled="disabled">Search</button>-->
<ul class="dropdown-menu pull-right">
<li><a href="#">Action</a></li>
<li><a href="#">Another action</a></li>
<li><a href="#">Something else here</a></li>
<li class="divider"></li>
<li><a href="#">Separated link</a></li>
</ul>
</div>
<!-- /btn-group -->                              
</div>
<!-- /input-group -->
<br>
<!--ActiveProject Start-->
<div id="talent">
<div class="editprofile" style=" border:#F00 0px solid;"> 	 	 	  	 	 	 	 	 	
<div class="subdcribe-bar">
<ul class="subdcribe-bar-left"><li><?php echo $total_rows;?> Freelancers Found</li></ul>
<div class="subdcribe-bar-right"></div>
<div class="clr"></div>
</div>

<?php 
if(count($talents)){ 


foreach ($talents as $row){
$previouscon=in_array($row['user_id'],$previousfreelancer);
?>    
<?php
if($this->session->userdata('user'))
{
$user=$this->session->userdata('user');
if($user[0]->user_id==$row['user_id'])
{
$lnk=VPATH."dashboard/profile_professional";
}
else
{
$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";
}	
}
else
{
$lnk=VPATH."clientdetails/showdetails/".$row['user_id']."/".$this->auto_model->getcleanurl($row['fname']." ".$row['lname'])."/";	
}
?>     

<!--Tab1 Start-->
<div class="resutblock">
<div class="resultimg">
<a href="<?php echo $lnk;?>">
<?php 
if($row['logo']!=""){ 
?>
<img src="<?php echo VPATH."assets/uploaded/".$row['logo'];?>">
<?php             
}
else{ 
?>
<img src="<?php echo VPATH;?>assets/images/people.png">
<?php   
}
?>

</a>
<div><!--<img src="images/starone.png" alt=""> <img src="images/cup.png" alt="">--></div>
</div>
<div class="resulttxt">
<div class="featuredimg2">
<?php 
$membership_logo="";
$membership_logo=$this->auto_model->getFeild('icon','membership_plan','id',$row['membership_plan']); 
$membership_title=$this->auto_model->getFeild('name','membership_plan','id',$row['membership_plan']); 
/*if($row['membership_plan']==1){ 
$membership_logo="free.png"; 
$membership_title="Free Member"; 
}
else if($row['membership_plan']==2){ 
$membership_logo="silver.png"; 
$membership_title="Silver Member"; 
}
else if($row['membership_plan']==3){ 
$membership_logo="gold.png"; 
$membership_title="Gold Member"; 
}
else if($row['membership_plan']==4){ 
$membership_logo="PLATINUM.png"; 
$membership_title="PLATINUM Member"; 
}*/      

?>


<img title="<?php echo $membership_title;?>" src="<?php echo VPATH;?>assets/plan_icon/<?php echo $membership_logo;?>">
</div>
<h2>
<a style="text-decoration: none;" href="<?php echo $lnk;?>">
<font color="#ff9f00"><?php echo $row['fname']." ".$row['lname']?></font>
</a>

<?php
if($row['rating'][0]['num']>0)
{
$avg_rating=$row['rating'][0]['avg']/$row['rating'][0]['num'];
for($i=0;$i < $avg_rating;$i++)
{
?>
<img src="<?php echo VPATH;?>assets/images/1star.png">

<?php		
}



for($i=0;$i < (5-$avg_rating);$i++)
{
?>
<img src="<?php echo VPATH;?>assets/images/star_3.png">
<?
}
}
else
{
?>

<img src="<?php echo VPATH;?>assets/images/star_3.png">

<img src="<?php echo VPATH;?>assets/images/star_3.png">

<img src="<?php echo VPATH;?>assets/images/star_3.png">

<img src="<?php echo VPATH;?>assets/images/star_3.png">

<img src="<?php echo VPATH;?>assets/images/star_3.png">
<?php
}
if($row['verify']=='Y')
{
?>
<img src="<?php echo VPATH;?>assets/images/verified.png"><img width="30" height="30"  alt="" src="<?php echo VPATH;?>assets/images/ques.jpg"  title="HireGround has checked and verified at least 3 positive references submitted by past clients of this user.">
<?php
}

if($previouscon){
?>
<button type="button" class="btn btn-primary btn-lg" onclick="givebonus('<?php echo $row['user_id'];?>')" data-toggle="modal" data-target="#givebonus">Give Bonus</button>
<? }
?>
</h2>
<h3></h3>
<h4>Completed Projects <b><?php echo $row['com_project'];?></b> | Hourly rate: <?php echo CURRENCY;?>  <b><?php echo $row['hourly_rate'];?></b></h4>

<?php
if($this->session->userdata('user'))
{
$user=$this->session->userdata('user');
$user_id=$user[0]->user_id;
if($user_id!=$row['user_id'])
{
?>  
<p> <button type="button" class="btn btn-primary btn-lg" onclick="setProject('<?php echo $row['user_id'];?>','<?php echo $user_id;?>')" data-toggle="modal" data-target="#myModal">Hire Me</button></p>
<?php
}
}
?>
<div style="padding-bottom:5px;"> Skills :

<?php 
$skill_list=$this->auto_model->getFeild("skills_id","user_skills","user_id",$row['user_id']);
if($skill_list!=""){ 
$skill_list=  explode(",",$skill_list);

foreach($skill_list as $key => $s){ 
$sname=$this->auto_model->getFeild("skill_name","skills","id",$s);             

?>
<a href="<?php echo VPATH;?>findtalents/filtertalent/<?php echo $s;?>/<?php echo $coun."/".$ct."/".$plans."/";?>" class="skilslinks ">
<?php echo $sname;?>
</a>
<?php
}       
}
else{ 
?>
<a href="#" class="skilslinks ">Skill Not Set Yet</a>
<?php  
}
?>

<div style="clear:both"></div>	   
</div>	   

<!-- <div  style="padding-bottom:5px;">
Skills            :
</div> -->
<?php 
/*$flag=$this->auto_model->getFeild("code","countries","name",$row['country']);
$flag=  strtolower($flag).".png";*/

$contry_info="";

if($row['city']!=""){ 
$contry_info.=$row['city'].", ";
} 
$contry_info.=$row['country'];

?>
<?php
$code=strtolower($this->auto_model->getFeild('code2','country','Name',$row['country']));
?>

<div><p><!--<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>">--> <?php echo $contry_info;?>&nbsp;&nbsp;<img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $code;?>.png"> &nbsp;&nbsp; | Last Login:<b><?php echo date("d M Y",  strtotime($row['ldate']))?></b> | Register Since:<b><?php echo date("M Y",  strtotime($row['reg_date']))?></b> | <b><a href="<?php echo VPATH;?>findjob/filterjob/All/All/0/0/All/All/All/All/All/<?php echo $row['user_id'];?>/">View Open Jobs</a></b></p></div>
</div>
</div>
<!--Tab1 End-->

<?php 
}
//echo $this->pagination->create_links();   
}
else{ 
echo "No Record Found";
}
?>
</div>


<!--ActiveProject End-->
</div>
</div>                       
<!--ProfileRight Start-->                       
<span id="pagi_span"> 
<?php                       
echo $this->pagination->create_links();   
?> 



</span>    

</div>
<!-- Left Section End -->
</div>  
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
 

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Your project to invite freelancer</h4>
      </div>
      <div class="modal-body">
       <input type="hidden" name="freelancer_id" id="freelancer_id" value=""/>
       <div id="allprojects"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="hdd()" id="sbmt" class="btn btn-primary">Invite</button>
      </div>
    </div>
  </div>
</div>       

<div class="modal fade" id="givebonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top:5%">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Give Bonus</h4>
      </div>
      <div class="modal-body">
      <div id="bonusmessage" style="text-align: center" class="login_form"></div>
      <form action="" name="givebonusform" class="givebonusform" method="POST">
       <input type="hidden" name="bonus_freelancer_id" id="bonus_freelancer_id" value="0"/>
       
       <div class="login_form">
       <p>Amount : </p>
       <input type="text" class="loginput6" size="30" value="0" name="bonus_amount" id="bonus_amount"> 
       </div>
       <div class="login_form">
       <p>Reason : </p>
       <textarea type="text" class="loginput6"  name="bonus_reason" id="bonus_reason"> </textarea>
       </div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="sendbonus()" id="sbmt" class="btn btn-primary" style="background: #428bca">Send</button>
      </div>
    </div>
  </div>
</div>  
<script>
function shwcat(id)
{
	$('#sub_'+id).toggle();
	if($('#h1_'+id).hasClass('active'))
	{
		$('#h1_'+id).removeAttr('class','true');
	}
	else
	{
		$('#h1_'+id).attr('class','active');	
	}
		
}
function setProject(user_id,project_user)
{
	$("#freelancer_id").val(user_id);
	var datastring="user_id="+project_user;
	$.ajax({
		data:datastring,
		type:"POST",
		url:"<?php echo VPATH;?>findtalents/getProject",
		success:function(return_data){
			//alert(return_data);
				if(return_data!=0)
				{
					$("#allprojects").html('');	
					$("#allprojects").html(return_data);
					$("#sbmt").show();
				}
				else
				{
					$("#allprojects").html('<b>You dont have any open projects to invite</b>');	
					$("#sbmt").hide();	
				}
			}
		});
}
function hdd()
{
	var free_id=$("#freelancer_id").val();
	var project_id=$(".prjct").val();
	var page='findtalents';
	window.location.href='<?php echo VPATH;?>invitetalents/invitefreelancer/'+free_id+'/'+project_id+'/'+page+'/';	
}
function givebonus(user_id)
{
	$("#givebonus div.modal-footer button#sbmt").css('display','inline-block');
	$("#bonus_freelancer_id").val(user_id);
	$(".givebonusform").css('display','block');
	
}
function sendbonus(){
	$("#bonusmessage").html('Wait...');
	var requestbonis=$(".givebonusform").serialize();
	
	$.ajax({
		data:$(".givebonusform").serialize(),
		type:"POST",
		dataType: "json",
		url:"<?php echo VPATH;?>findtalents/givebonus",
		success:function(response){
			//alert(response);
				if(response['status']=='OK')
				{
					
					$("#bonusmessage").html('<div style="color:green;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');
					$(".givebonusform").css('display','none');
					$("#givebonus div.modal-footer button#sbmt").css('display','none');
					$(".givebonusform")[0].reset();	
					
				}
				else
				{
					
					$("#bonusmessage").html('<div style="color:red;margin-bottom: 23px;font-size: 20px;">'+response['msg']+'</div>');	
						
				}
			}
		});
}
$(function () {
$(".close").click(function(){
	$(".modal").modal('hide');
	
	})
$('[data-dismiss="modal"]').each(function () {
	$(this).click(function(){
		$(".modal").modal('hide');	
	})
	})
	
	})
</script>        