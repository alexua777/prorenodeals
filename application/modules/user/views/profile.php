   
      <div class="profile_area">
      <?php
 if($this->session->flashdata('error_msg'))
 {
 ?>
 <h2 align="center"><?php echo $this->session->flashdata('error_msg');?></h2>
 <?php
 }
 elseif($this->session->flashdata('succ_msg'))
 {
 ?>
 <h2 align="center"><?php echo $this->session->flashdata('succ_msg');?></h2>
 <?php
 }
 ?>
      	<div class="prof_rht_inner margin-top10">
        	<h2>Profile Information</h2>
            <div class="prof_img" onmouseover="hdd();" onmouseout="hds();">
            <?php
            if($all_data[0]['image']!='')
			{
			?>
            <img src="<?php echo base_url();?>assets/user_image/<?php echo $all_data[0]['image'];?>" alt="" />
            <?php
            }
			else
			{
            ?>
            <img src="<?php echo base_url();?>assets/images/noimg.jpg" height="130" width="150" alt="" />
            <?php
            }
			?>
            </div>
            <a href="javascript:void(0);" onclick="upd()">
            <div id="editimg">
            	<b>Edit Image</b>
            </div></a>
            
            <div id="up_photo" class="prof_upld" style="display:none;">
            <form name="upldphoto" action="<?php echo base_url();?>user/uploadphoto/<?php echo $all_data[0]['user_id'];?>/" method="post" enctype="multipart/form-data">
            <input type="hidden" name="curimg" value="<?php echo $all_data[0]['image'];?>" />
            <input type="file" name="userfile" />
            <input type="submit" name="submt" class="btns" value="Upload" /> 
            </form>
            </div>
            <!--<div class="clr"></div>-->
            <div class="prof_detail_area">
            <span>
            <?php echo $all_data[0]['description'];?>
            </span>
            </div>
            
             <div class="pro_info">
             <div class="pro_info_lft">
            	<form>
                 <label>
                <p><strong>First Name :</strong> <?php echo $all_data[0]['fname'];?></p>
                </label>
                 <label>
                <p><strong>Last Name :</strong> <?php echo $all_data[0]['lname'];?></p>
                </label>
                <label>
                <p><strong>Email :</strong> <?php echo $all_data[0]['email'];?></p>
                </label>
                 <label>
                <p><strong>Country :</strong> <?php echo $all_data[0]['country'];?></p>
                </label>
                 <label>
                <p><strong>Address :</strong> <?php echo $all_data[0]['address1'].", ".$all_data[0]['address2'];?></p>
                </label>
                 <label>
                <p><strong>City :</strong> <?php echo $all_data[0]['city'];?></p>
                </label>
                <label>
                <a href="<?php echo base_url();?>user/editprofile/<?php echo $all_data[0]['user_id'];?>/<?php echo $all_data[0]['fname'];?>">
                <input type="button" value="Edit Info" name="" class="prof_btn"></a>
                </label>
                </form>
                </div>
                
              
                
            </div>
            
        </div>
        
      </div>
        
    </section>
    
   
  
  
 
  

</div>
<div class="clear"></div>
<script>
/*function hdd()
{
	$('#editimg').show();
}
function hds()
{
	$('#editimg').hide();
}*/
function upd()
{
	$('#up_photo').toggle();
}
</script>