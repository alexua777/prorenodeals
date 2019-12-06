<!--ActiveProject Start-->
<?php /*
<div class="editprofile" style=" border:#F00 0px solid;"> 	 	 	  	 	 	 	 	 	
<div class="subdcribe-bar">
<ul class="subdcribe-bar-left"><li><?php echo $total_rows;?> Freelancers Found</li></ul>
<div class="subdcribe-bar-right"></div>
<div class="clr"></div>
</div>
    <div id="talent">
<?php 
  if($total_rows>0){
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
      if($row['membership_plan']==1){ 
          $membership_logo="free.png"; 
      }
      else if($row['membership_plan']==2){ 
          $membership_logo="silver.png"; 
      }
      else if($row['membership_plan']==3){ 
          $membership_logo="gold.png"; 
      }
      else if($row['membership_plan']==4){ 
          $membership_logo="PLATINUM.png"; 
      }      
    
    ?>    
    <img title="Silver Member" src="<?php echo VPATH;?>assets/images/<?php echo $membership_logo;?>">
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
      <a href="javascript:void(0)" class="skilslinks "><?php echo $sname;?></a>
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
   <!--$flag=$this->auto_model->getFeild("code","countries","name",$row['country']);
   $flag=  strtolower($flag).".png";-->
   $contry_info="";
 
   if($row['city']!=""){ 
       $contry_info.=$row['city'].", ";
   } 
   $contry_info.=$row['country'];
 ?>
 
 <div><p><!--<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>">--><?php echo $contry_info;?> &nbsp;&nbsp; | Last Login:<b><?php echo date("d M Y",  strtotime($row['ldate']))?></b> | Register Since:<b><?php echo date("M Y",  strtotime($row['reg_date']))?></b> | <b><a href="<?php echo VPATH;?>findjob/filterjob/All/All/0/0/All/All/All/All/All/<?php echo $row['user_id'];?>/">View Open Jobs</a></b></p></div>
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

</div>

*/?>
<?php /* <p>( <?php echo $total_freelancers;?> )Freelancers Found</p>   */ ?>
<?php 

  if(count($freelancers)){ 
 

  foreach ($freelancers as $row){
  	$previouscon=in_array($row['user_id'],$previousfreelancer);
?>    
<?php
if($this->session->userdata('user'))
{
	$user=$this->session->userdata('user');
	$account_type=$user[0]->account_type;
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

    <div class="media">
    <div class="media-left">
    <a href="<?php echo $lnk;?>">
		<?php 
          if($row['logo']!=""){ 
		  
		  if(file_exists('assets/uploaded/cropped_'.$row['logo'])){
					$logo="cropped_".$row['logo'];
				}else{
					$logo=$row['logo'];
				}
		  
		  
        ?>
           <img src="<?php echo VPATH."assets/uploaded/".$logo;?>" class="media-object" />
        <?php             
          }
          else{ 
        ?>
           <img src="<?php echo VPATH;?>assets/images/people.png" class="media-object" />
        <?php   
          }
        ?>
    </a>
    </div>
    <div class="media-body">
	<?php 
      $membership_logo="";
	  $membership_logo=$this->auto_model->getFeild('icon','membership_plan','id',$row['membership_plan']); 
	  $membership_title=$this->auto_model->getFeild('name','membership_plan','id',$row['membership_plan']); 
    
    ?>
	<?php 

   $contry_info="";
 
   if($row['city']!=""){ 
       $contry_info.=$this->auto_model->getFeild('Name' , 'city' , 'id' , $row['city']).", ";
   } 
   $contry_info.=$this->auto_model->getFeild('Name','country','Code',$row['country']);
   
 ?>
 <?php
$code=strtolower($this->auto_model->getFeild('code2','country','Code',$row['country']));
$slogan = $this->auto_model->getFeild('slogan','user','user_id',$row['user_id']);
	$overview = $this->auto_model->getFeild('overview','user','user_id',$row['user_id']);
?>

    <h4 class="media-heading"><a href="<?php echo $lnk;?>"><?php echo $row['fname']." ".$row['lname']?></a></h4>
    <p class="bio"><i class="zmdi zmdi-map"></i> &nbsp;&nbsp;<img src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $code;?>.png"> &nbsp;&nbsp; <?php echo $contry_info;?>&nbsp;&nbsp;</p>
   <p class="designation"><a href="<?php echo $lnk;?>"><?php echo $slogan;?></a></p>
    <p><?php echo strlen(strip_tags($overview)) > 200 ? substr(strip_tags($overview) , 0 , 200).'... <a href="'.$lnk.'">more</a>' : strip_tags($overview); ?> </p>
    </div>
    <div class="media-right">
	<h4>
	<?php
if($row['rating'][0]['num']>0)
{
	$avg_rating=$row['rating'][0]['avg']/$row['rating'][0]['num'];
	for($i=0;$i < $avg_rating;$i++)
	{
?>
		<i class="zmdi zmdi-star"></i>
       
<?php		
	}
	
		
		
	for($i=0;$i < (5-$avg_rating);$i++)
	{
?>
		<i class="zmdi zmdi-star-outline"></i>
<?
	}
}
else
{
?>

<i class="zmdi zmdi-star-outline"></i>
<i class="zmdi zmdi-star-outline"></i>
<i class="zmdi zmdi-star-outline"></i>
<i class="zmdi zmdi-star-outline"></i>
<i class="zmdi zmdi-star-outline"></i>

<?php
}
?>
    </h4>
	
   <?php 
		$row['total_project'] = $row['total_project'] == 0 ? 1 : $row['total_project'];
		$success_prjct = (int) $row['com_project'] * 100 / (int) $row['total_project'];
	
	?>
    <div class="circle-bar position" data-percent="<?php echo round($success_prjct);?>" data-duration="1000" data-color="#dedede,green"></div>
    <p>Job Success<br>
    <?php echo CURRENCY;?>  <b><?php echo $row['hourly_rate'];?>/hr</b><br>
   <?php echo $row['com_project'];?> Completed Project</p>
    </div>    	
	
       <ul class="skills">    
    	<li>Skills: </li>
		<?php 
      $skill_list=$row['skills'];
      if(count($skill_list)){
		foreach($skill_list as $k => $v){
	?>
       <li><a href="<?php echo base_url('findtalents/browse').'/'.$this->auto_model->getcleanurl($v['parent_skill_name']).'/'.$v['parent_skill_id'].'/'.$this->auto_model->getcleanurl($v['skill']).'/'.$v['skill_id'];?>">
          <?php echo $v['skill'];?>
      </a> </li>
    <?php
             
      } } 
      else{ 
    ?>
        <li><a href="#">Skill Not Set Yet</a> </li>
    <?php  
      }
   ?>
    </ul>
    </div>
    
	
	<?php 
}

}
else{ 
    echo "<div class='alert alert-danger'>No result found</div>";
}
?>
<script>
$(".circle-bar").loading();
</script>