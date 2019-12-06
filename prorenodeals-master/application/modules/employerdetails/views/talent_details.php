<?php echo $breadcrumb;?> 
<script src="<?=JS?>mycustom.js"></script>
<section class="sec">
<div class="container">
  <div class="row">
    <?php /*echo $leftpanel;*/?> 
     <!-- Sidebar End -->
    <div class="col-xs-12">

    <div class="profile_right">
    
    <div class="editport_text">
    	<h4><i class="fa fa-user"></i> My Client Profile</h4>
    </div>
    
    <div class="myproblockleft">
    
    
    <div class="whiteSec">
    <div class="media">
    
    <div class="media-left myproimg">
    <?php
    if($logo!='')
    {
    ?>
    <img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo?>">
    <?php
    }
    else
    {
    ?>
    <img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif">
    <?php
    }
    ?>
    </div>
    
    <div class="media-body">
    <p>
    <b>Username:</b>
    <span><?php echo $fname." ".$lname;?></span>
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
    
    <img src="<?php echo VPATH;?>assets/images/star_3.png">
    
    <img src="<?php echo VPATH;?>assets/images/star_3.png">
    
    <img src="<?php echo VPATH;?>assets/images/star_3.png">
    
    <img src="<?php echo VPATH;?>assets/images/star_3.png">
    
    <img src="<?php echo VPATH;?>assets/images/star_3.png">
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
    ?></p>
    
    <p><span>
    <?php
        $flag=$this->auto_model->getFeild("code2","country","Code",$country);
       $flag=  strtolower($flag).".png"; 
	  $c=$this->auto_model->getFeild("Name","country","Code",$country);
       if($city!=""){
			if(is_numeric($city)){
				echo getField('Name', 'city', 'ID', $city).' , ';
			}else{
				echo $city.", ";
			}
           
       }
       echo $c;
     ?>
    &nbsp;<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>">                        
    </span></p>   
	</div>
    </div>             
    </div>
    
    <div class="socialicons">
      <?php 
        if($twitter_link!=""){ 
      ?>
        <div class="soc_icon"><a href="<?php echo $twitter_link;?>" target="_blank"><img alt="" src="<?php echo VPATH;?>assets/images/t-icon.png"></a></div>    
      <?php 
        }
      ?>  
    
      <?php 
        if($facebook_link!=""){ 
      ?>
        <div class="soc_icon"><a href="<?php echo $facebook_link;?>" target="_blank"><img alt="" src="<?php echo VPATH;?>assets/images/f_icon.png"></a> </div>
      <?php 
        }
      ?>     
      <?php 
        if($linkedin_link!=""){ 
      ?>
        <div class="soc_icon"><a href="<?php echo $linkedin_link;?>" target="_blank"><img alt="" src="<?php echo VPATH;?>assets/images/linkedin.png"></a></div>
      <?php 
        }
      ?>     
      <?php 
        if($gplus_link!=""){ 
      ?>
            <div class="soc_icon"><a href="<?php echo $gplus_link;?>" target="_blank"><img alt="" src="<?php echo VPATH;?>assets//images/g-icon.png"></a></div>
      <?php 
        }
      ?>       
        
    
    
    
    
    </div>
    </div>
    </div>
<div class="divide20"></div>
    <div class="profile_right">
    <div class="editport_text">
    	<h4><i class="fa fa-info-circle"></i> About Us</h4>
    </div>
    </div>
      
    <div class="myproblockleft" id="client_about"> 
    <?php echo $about;?>
    </div>
    
    <?php /*?><div class="myproblockleft" id="about_div" style="display: none;">
        <form method="post" action="<?php echo VPATH;?>dashboard/client_about_check">  
         <div class="acount_form">  
        <textarea class="acount-input" name="asclient_aboutus" id="asclient_aboutus" rows="10" cols="20"   >    <?php echo $about;?></textarea>
    <div class="focusmsg" id="asclient_aboutusFocus" style="display:none">Write About Us</div>
    </div>
        
    <div class="acount_form">
        <input class="btn-normal btn-color submit  bottom-pad top-pad" type="submit"  value="Submit" />  
    </div>
    </form>   
    </div><?php */?>    
    
<div class="divide20"></div>
<div class="myproblockleft">
<div class="editport_text">
<h4><i class="fa fa-star"></i> Rating and Review</h4>
</div>


<div style="clear:both;"></div>

<?php

if(count($review)>0){ 

foreach($review as $key => $val){  

$username=$this->auto_model->getFeild('username','user','user_id',$val['user_id']);      
$given_name=$this->auto_model->getFeild('username','user','user_id',$val['given_user_id']);      

$feedback=$this->dashboard_model->getAllreview($val['project_id'],$val['given_user_id'],$val['user_id']);

?>

<div class="myproblock">
<!--Rating Review-->
<div class="ratingreview">

<div class="ratingtext">
<p><?php
echo $this->auto_model->getFeild('title','projects','project_id',$val['project_id']);      
?></p>
<div class="safetybox">
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
?></div>
<p><?php echo $feedback[0]['comments'];?></p>
</div>
<div class="ratingtext_right"><p><?php echo ucwords( $given_name);?><br />
<span><?php echo date('M d, Y',strtotime($val['add_date']));?></span></p></div>
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

<div class="ratingtext"><p>No Review Yet.</p></div></div></div>
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
<div class="addbox2">
<a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
</div>
<?php  
}
}

?>
  
               
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
         
