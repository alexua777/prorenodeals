<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
  <div class="row"> <?php echo $leftpanel;?>
    <div class="col-md-9 col-sm-8 col-xs-12"> 
      
      <!--ProfileRight Start-->
      <div class="profile_right">
        <div class="editport_text">
          <h4><i class="fa fa-user"></i> My Client Profile</h4>
          <a href="<?php echo VPATH;?>dashboard/editprofile_professional" class="btn btn-sm btn-warning pull-right"><i class="fa fa-edit"></i> Edit</a>
        </div>
        <div class="whiteSec">
        <div class="media client_profile">
          <div class="media-left myproimg">
			<?php
            if($logo!='')
            {
            ?>
                <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo?>" class="img-thumbnail img-responsive">
                <?php
            }
            else
            {
            ?>
                <img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif" class="img-thumbnail img-responsive">
                <?php
            }
            ?>
          </div>
          <div class="media-body">
            <p> Username: <span><?php echo $fname." ".$lname;?></span>
              <?php
if($rating[0]['num']>0)
{
	$avg_rating=$rating[0]['avg']/$rating[0]['num'];
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
              <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png">
              <?php
}
?>
              <?php
if($verify=='Y')
{
?>
              <img src="<?php echo VPATH;?>assets/images/verified.png">
              <?php
}
?>
            </p>
            <p><span>
              <?php 
$flag=$this->auto_model->getFeild("code2","country","Name",$country);
   $flag=  strtolower($flag).".png";
   if($city!=""){ 
       echo $city.", ";
   }
   echo $country;
 ?>
              &nbsp;<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>"> </span></p>
              
          
          
          
          </div>
          <div class="media-right">          
          	<ul class="social-icons media-icons icon-circle">
            <?php 
    if($twitter_link!=""){ 
  ?>
            <li><a href="<?php echo $twitter_link;?>" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
            <?php 
    }
  ?>
            <?php 
    if($facebook_link!=""){ 
  ?>
            <li><a href="<?php echo $facebook_link;?>" target="_blank"><i class="fa fa-facebook-official"></i></a></li>
            <?php 
    }
  ?>
            <?php 
    if($linkedin_link!=""){ 
  ?>
            <li><a href="<?php echo $linkedin_link;?>" target="_blank"><i class="fa fa-linkedin-square"></i></a></li>
            <?php 
    }
  ?>
            <?php 
    if($gplus_link!=""){ 
  ?>
            <li><a href="<?php echo $gplus_link;?>" target="_blank"><i class="fa fa-google-plus-official"></i></a></li>
            <?php 
    }
  ?>
          </ul>
          </div>
        </div>
        </div>
        <div class="divide20"></div>
      </div>
      
      <div class="profile_right">
        <div class="editport_text">
          <h4><i class="fa fa-info-circle"></i> About Us</h4>
          <a href="javascript:void(0)" onclick="showaboutdiv()" class="btn btn-sm btn-warning pull-right"><i class="fa fa-edit"></i> Edit</a>
          
        </div>
      </div>
      
      <div class="whiteSec" id="client_about"> <?php echo $about;?> 
      <div class="divide15"></div>	        
      <div id="about_div" style="display: none">
        <form method="post" action="<?php echo VPATH;?>dashboard/client_about_check" class="form-horizontal">
          <div class="form-group">
          <div class="col-xs-12">
            <textarea class="form-control" name="asclient_aboutus" id="asclient_aboutus" rows="10" cols="20"><?php echo $about;?></textarea>
            <div class="focusmsg" id="asclient_aboutusFocus" style="display:none">Write About Us</div>
          </div>
          </div>          
          <input class="btn btn-site" type="submit"  value="Submit" />
        </form>
      </div>
      </div>
      
      <div class="divide20"></div>
      <div class="myproblockleft">
        <div class="editport_text">
          <h4><i class="fa fa-star"></i> Rating and Review</h4>
        </div>
        <div class="clearfix"></div>
        <?php

if(count($review)>0){ 
    
  foreach($review as $key => $val){  
      
    $username=$this->auto_model->getFeild('username','user','user_id',$val['user_id']);      
    $given_name=$this->auto_model->getFeild('username','user','user_id',$val['given_user_id']);      
    
    $feedback=$this->dashboard_model->getAllreview($val['project_id'],$val['given_user_id'],$val['user_id']);
    
?>
     
          <!--Rating Review-->
          <div class="ratingreview">
          <div class="row">
            <aside class="col-sm-9 col-xs-12">
            <div class="ratingtext">
              <h4>
                <?php
  echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      
?>
              </h4>
              <p>
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
              </p>
              <p><?php echo $feedback[0]['comments'];?></p>
            </div>
            </aside>
            <aside class="col-sm-3 col-xs-12">
            <div class="ratingtext_right">
              <p><?php echo ucwords( $given_name);?><br />
                <span><?php echo date('M d, Y',strtotime($val['add_date']));?></span></p>
            </div>
            </aside>
          </div>
          <!--Rating Review End-->
          
          <?php        
  }    
}
else{
    ?>
          <div class="myproblock"> 
            <!--Rating Review-->
            <div class="ratingreview">
              <div class="ratingtext">
                <p>No Review Yet.</p>
              </div>
            </div>
          </div>
          <?php 
}
 
?>
        </div>
     
    </div>
  </div>
</div>
</div>
</section>
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
<div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
<?php  
 }
  }

?>
<div class="clearfix"></div>
<script> 
  function showaboutdiv(){ 
    //$("#about_div").toggle();
    document.getElementById('about_div').style.display = "block";
	document.getElementById('client_about').style.display = "none";
	
  }
  
  function Kazi(id){
		$('#'+id+'Focus').show();
	}
	function Nasim(id){
		$('#'+id+'Focus').hide();
	}
</script> 
