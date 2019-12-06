<?php 
   
	if(isset($skill))
    {
			$cat=$skill;
			$parentc=array();
			$cats=array();
			if(strstr($skill,','))
			{				
				$allskills=explode(",",$skill);
				foreach($allskills as $key=>$value)	
				{
					$cats[]=$value;
					$pcat=$this->auto_model->getFeild('parent_id','skills','id',$value);
					$parentc[]=$pcat;
				}				
			}
			else
			{
				$cats[]=$skill;
				$pcat=$this->auto_model->getFeild('parent_id','skills','id',$cat);
				$parentc[]=$pcat;	
			}
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
    
?>

<!-- <?//php echo $breadcrumb;?> -->

<script src="<?=JS?>mycustom.js"></script>

<section class="breadcrumb-classic">
  <div class="container">
    <div class="row">
      <aside class="col-sm-6 col-xs-12">
        <h3>All Talent</h3>
      </aside>
      <aside class="col-sm-6 col-xs-12">
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url();?>">Home</a></li>
          <li class="active">All Talent</li>
        </ol>
      </aside>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="sec">
  <div class="container">
    <div class="row">
      <aside class='sidebar col-lg-3 col-md-3 col-sm-4 col-xs-12'>
        <div class="left_sidebar">
          <ul class="list-group">
            <?php
    foreach($parent_skill as $key =>$val){ 
    ?>
            <li id="h1_<?php echo $val['id'];?>" style="cursor: pointer;" onclick="shwcat('<?php echo $val['id'];?>')"><?php echo $val['skill_name'];?></li>
            <ul class="list-group sub_cat" id="sub_<?php echo $val['id'];?>" <?php if(!in_array($val['id'],$parentc)){?>style="display:none;"<?php }?>>
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
              <div class="unchecked <?php if($cat!='All'){if(in_array($sval['id'],$cats)){echo  'select_chkbx';}}?>"></div>
              <li><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $sval['id'];?>/<?php echo $coun."/";?>'><?php echo $sval['skill_name'];?></a></li>
              <?php
           }
    ?>
            </ul>
            <?php
    }
    ?>
          </ul>
          <h4 class="title-sm">Country</h4>
          <ul class="list-group scroll-bar">
            <li><a href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo str_replace(",","-",$cat);?>/<?php echo "/All/";?>" <?php if($coun=='All'){echo  'class="selected"';}?>>All</a></li>
            <?php
    foreach($countries as $key=>$val)
    {
    ?>
            <div class="catlink">
              <li><a href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo str_replace(",","-",$cat);?>/<?php echo $val['name']."/";?>" <?php if($coun==$val['name']){echo  'class="selected"';}?>><?php echo $val['name'];?></a></li>
            </div>
            <?php
    }
    ?>
          </ul>
        </div>
        <div class="clearfix"></div>
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
              <li><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $sval['id'];?>/<?php echo $coun."/";?>' id="<?php echo $sval['id'];?>"><?php echo $sval['skill_name'];?></a></li>
           <?php    
           }
           ?>
           </ul> 
        </section>
        </div>
        <?php }*/?>
        <?php /*?><div class='accordion-item' id="accod_country">
        <h4 class='accordion-toggle'>Country</h4>
        <section class='accordion-inner panel-body'>
        <ul class='live-pro-list clearfix' aria-hidden='false' style='display: block;'>							
        <li><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $cat;?>/<?php echo "/All/";?>'><strong>All</strong></a></li>
        <?php
		foreach($countries as $key=>$val)
		{
		?>
        <li><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $cat;?>/<?php echo $val['name']."/";?>'><?php echo $val['name'];?></a></li>
        <?php
		}
		?>
        </ul>
        </section>
        </div><?php */?>
        
        <!--<div class="catcontent">
<h3>Country</h3>
<div class="live-pro-list clearfix" style='max-height:300px;overflow-x: hidden;overflow-y: scroll;'>
<div class="catlink"><h2><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $cat;?>/<?php echo "/All/";?>'><strong>All</strong></a></h2></div>
<?php
foreach($countries as $key=>$val)
{
?>
<div class="catlink"><h2><a href='<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $this->uri->segment("3");?>/<?php echo $cat;?>/<?php echo $val['name']."/";?>'><?php echo $val['name'];?></a></h2></div>
<?php
}
?>
</div>
</div>--> 
      </aside>
      <aside class="col-md-9 col-sm-8 col-xs-12"> 
        
        <!--ProfileRight Start-->
        <div class="success alert-success alert">Click on the check boxes to select freelancers, then click on the Invite button below.</div>
        <form method="post" action="<?php echo VPATH;?>invitetalents/inviteFriends/<?php echo $this->uri->segment(3)?>" name="invite_frm">
          <div class="searchbox">
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="Search..." aria-describedby="basic-addon1" required id="srch" onkeyup="catdtls(this.id);">
              <span class="input-group-addon" id="basic-addon1">
              <button type="submit" class="btn btn-site"><i class="zmdi zmdi-search"></i> Search</button>
              </span> </div>
            <p class="text-right" style="display:none;"><a href="#">Advanced Search</a></p>
          </div>
          <div class="listing findtalent"> 
            <!-- /input-group --> 
            <br>
            <!--ActiveProject Start-->
            <div id="talent">
              <div class="editprofile" style=" border:#F00 0px solid;">
                <div class="subdcribe-bar">
                  <ul class="subdcribe-bar-left">
                    <li><?php echo $total_rows;?> Freelancers Found</li>
                  </ul>
                  <div class="subdcribe-bar-right"></div>
                  <div class="clr"></div>
                </div>
                <?php 
  if(count($talents)){ 
 
 
  foreach ($talents as $row){
?>
                
                <!--Tab1 Start-->
                <div class="media">
                  <div class="media-left"> <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['user_id']?>">
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
                    </a> </div>
                  <div class="media-body">
                    <div class="featuredimg2">
                      <?php 
      $membership_logo="";
	  $membership_logo=$this->auto_model->getFeild('icon','membership_plan','id',$row['membership_plan']); 
	  $membership_title=$this->auto_model->getFeild('name','membership_plan','id',$row['membership_plan']); 
    ?>
                      <img title="<?php echo $membership_title;?>" src="<?php echo VPATH;?>assets/plan_icon/<?php echo $membership_logo;?>"> </div>
                    <h4 class="media-heading"> <a href="<?php echo VPATH;?>clientdetails/showdetails/<?php echo $row['user_id']?>"> <?php echo $row['fname']." ".$row['lname']?> </a>
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
                      <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png"> <img src="<?php echo VPATH;?>assets/images/star_3.png">
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
                    <h5>Completed Projects <b><?php echo $row['com_project'];?></b> | Hourly rate: <?php echo CURRENCY;?> <b><?php echo $row['hourly_rate'];?></b></h5>
                    <div style="padding-bottom:5px;"> Skills :
                      <?php 
      $skill_list=$this->auto_model->getFeild("skills_id","user_skills","user_id",$row['user_id']);
      if($skill_list!=""){ 
        $skill_list=  explode(",",$skill_list);

        foreach($skill_list as $key => $s){ 
            $sname=$this->auto_model->getFeild("skill_name","skills","id",$s);             
      
    ?>
                      <a href="<?php echo VPATH;?>invitetalents/filtertalent/<?php echo $s;?>/<?php echo $coun."/";?>" class="skilslinks "> <?php echo $sname;?> </a>
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
                    <?php 
   
   $contry_info="";
 
   if($row['city']!=""){ 
       $contry_info.=$row['city'].", ";
   } 
   $contry_info.=$row['country'];
   
 ?>
                    <div>
                      <p><!--<img width="16" height="11" title="" src="<?php echo VPATH;?>assets/images/cuntryflag/<?php echo $flag;?>">--> <?php echo $contry_info;?>&nbsp;&nbsp; | Last Login:<b><?php echo date("d M Y",  strtotime($row['ldate']))?></b> | Register Since:<b><?php echo date("M Y",  strtotime($row['reg_date']))?></b></p>
                    </div>
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
          <?php 
  if(count($talents)){ 
?>
          <input type="submit" name="invite" class="btn btn-site pull-right" value="Invite Freelancers">
          <?php 
  }
?>
        </form>
        <div class="clearfix"></div>
        <nav aria-label="Page navigation" id="pagi_span"> <?php echo $this->pagination->create_links();   ?> </nav>
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
        <div class="addbox"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
        <?php  
 }
  }

?>
      </aside>
      
      <!-- Left Section End --> 
    </div>
  </div>
</section>
<script>
function catdtls(id){
	var stext=$('#'+id).val();	
        
	if(stext=='')
	{
		stext='_';	
	}
        var skill='<?php echo str_replace(",","-",$cat);?>';        
        var coun='<?php echo $coun;?>';        
        
        
	var dataString = 'cid='+stext+'&skill='+skill+'&coun='+coun;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>invitetalents/getsrch/"+stext+"/"+skill+"/"+coun,
     success:function(return_data)
     {
	 	//alert(return_data);
      //	$('#talent').html('');
                $("#pagi_span").hide();
		$('#talent').html(return_data);
     }
    });
}
</script> 
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
</script> 