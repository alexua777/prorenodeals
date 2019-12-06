<!--ActiveProject Start-->
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
?>    
    
    
<!--Tab1 Start-->
<div class="media">
<div class="media-left">
    <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['user_id']?>">
        <?php 
          if($row['logo']!=""){ 
        ?>
           <img src="<?php echo VPATH."assets/uploaded/".$row['logo'];?>" class="media-object">
        <?php             
          }
          else{ 
        ?>
           <img src="<?php echo VPATH;?>assets/images/viewimage.gif" class="media-object">
        <?php   
          }
        ?>
        
    </a>
</div>
<div class="media-body">
<div class="featuredimg2">
    <?php 
      $membership_logo=""; 
      if($row['membership_plan']==1){ 
          $membership_logo="free_thumb.png"; 
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
    
    <img title="Silver Member" src="<?php echo VPATH;?>assets/plan_icon/<?php echo $membership_logo;?>">
</div>
<h4 class="media-heading">
    <a style="text-decoration: none;" href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['user_id']?>"><?php echo $row['fname']." ".$row['lname']?></a>           
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
            <img src="<?php echo VPATH;?>assets/images/verified.png">
            <?php
		}
?>

    </h4>

<h5>Completed Projects <b><?php echo $row['com_project'];?></b> | Hourly rate: <?php echo CURRENCY;?>  <b><?php echo $row['hourly_rate'];?></b></h5>
<div style="padding-bottom:5px;"> Skills :
    
    <?php 
      $skill_list=$this->auto_model->getFeild("skills_id","user_skills","user_id",$row['user_id']);
      if($skill_list!=""){ 
        $skill_list=  explode(",",$skill_list);

        foreach($skill_list as $key => $s){ 
            $sname=$this->auto_model->getFeild("skill_name","skills","id",$s);             
      
    ?>
      <a href="#" class="skilslinks "><?php echo $sname;?></a>
    <?php
       }       
      }
      else{ 
    ?>
       <a href="#" class="skilslinks ">Skill Not Set Yet</a>
    <?php  
      }
   ?>
        <div style=" margin:0px 12px 0px 0px; float:right; "> 
            <input name="invite_freelancer[]" type="checkbox" value="<?php echo $row['user_id'];?>" />
        </div>     
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
 
 <div><p><!--<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>">--><?php echo $contry_info;?> &nbsp;&nbsp; | Last Login:<b><?php echo date("d M Y",  strtotime($row['ldate']))?></b> | Register Since:<b><?php echo date("M Y",  strtotime($row['reg_date']))?></b></p></div>
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


<!--ActiveProject End-->