<style>
.register_error p {
   border: 1px dashed #2d9eca;
    color: #ff0000;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    margin-bottom: 10px;
    margin-top: 2px;
    padding: 4px 8px;
    width: 184px;
    }
</style>
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
        	<h2>Public Profile</h2>
            
             <div class="pro_info">
             <div class="pro_info_lft">
            	<form action="<?php echo base_url();?>user/editprofile/<?php echo $all_data[0]['user_id'];?>/<?php echo $all_data[0]['fname'];?>" method="post">
                 <div class="lable_div">
                <label>
                <p class="prof_edit_text"><span style="color:#F00;">*</span>First Name</p>
                </label>
                 <label>
                 <input type="text" placeholder="First Name" class="proedit_fld" name="fname" value="<?php echo $all_data[0]['fname'];?>">
                 <div class="register_error"><?php echo form_error('fname');?></div>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Last Name</p>
                </label>
                <label>
                 <input type="text" placeholder="Last Name" class="proedit_fld" name="lname" value="<?php echo $all_data[0]['lname'];?>">
                 <div class="register_error"><?php echo form_error('lname');?></div>
                </label>
                </div>
                <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">About you </p>
                </label>
                <label>
                 <textarea name="description" cols="" rows="" class="proedit_objective" placeholder="About you here"><?php echo $all_data[0]['description'];?></textarea>
                </label>
                </div>
                
                <div class="lable_div">
                 <label>
                <p class="prof_edit_text"><span style="color:#F00;">*</span>Gender</p>
                </label>
                <label>
               <div class="radio"><input name="sex" type="radio" value="M" <?php if($all_data[0]['sex']=='M') {echo "checked";}?>/>Male </div> <div class="radio"><input name="sex" type="radio" value="F" <?php if($all_data[0]['sex']=='F') {echo "checked";}?>/>Female</div>
               <div class="register_error"><?php echo form_error('gender');?></div>
                </label>
                </div>
                
               
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Email</p>
                </label>
                <label>
                 <input type="text" placeholder="Email" class="proedit_fld" name="email" value="<?php echo $all_data[0]['email'];?>">
                 <div class="register_error"><?php echo form_error('email');?></div>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Confirm Email</p>
                </label>
                <label>
                 <input type="text" placeholder="Confirm Email" class="proedit_fld" name="cemail">
                 <div class="register_error"><?php echo form_error('cemail');?></div>
                </label>
                </div>
                
                <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Date of Birth</p>
                </label>
                <label>
                 <input type="text" placeholder="In yyyy-mm-dd format" class="proedit_fld" name="dob" value="<?php echo $all_data[0]['dob'];?>">
                </label>
                </div>
                
              
                
               
               <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Address Line 1 </p>
                </label>
                <label>
                 <textarea name="address1" cols="" rows="" class="proedit_objective" placeholder="Address here"><?php echo $all_data[0]['address1'];?></textarea>
                 <div class="register_error"><?php echo form_error('address1');?></div>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Address Line 2 </p>
                </label>
                <label>
                 <textarea name="address2" cols="" rows="" class="proedit_objective" placeholder="Address here"><?php echo $all_data[0]['address2'];?></textarea>
                </label>
                </div>
                
               
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Country</p>
                </label>
                <label>
                <select class="proedit_fld_select" name="country">
                 	<option value="">Select . . .</option>
                <?php 
				foreach($country as $key=>$val)
				{
				?>
                    <option value="<?php echo $val['code'];?>" <?php if($all_data[0]['country']==$val['code']){echo "selected";}?>><?php echo $val['name'];?></option>
                 <?php
                 }
				 ?>
                 </select>
                 <div class="register_error"><?php echo form_error('country');?></div>
                </label>
                </div>
                
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>State</p>
                </label>
                <label>
                 <input type="text" placeholder="State" class="proedit_fld" name="state" value="<?php echo $all_data[0]['state'];?>">
                 <div class="register_error"><?php echo form_error('state');?></div>
                </label>
                </div>
                
                  <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>City</p>
                </label>
                <label>
                 <input type="text" placeholder="City" class="proedit_fld" name="city" value="<?php echo $all_data[0]['city'];?>">
                 <div class="register_error"><?php echo form_error('city');?></div>
                </label>
                </div>
                  <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Zip</p>
                </label>
                <label>
                 <input type="text" placeholder="Zip" class="proedit_fld" name="zip" value="<?php echo $all_data[0]['zip'];?>">
                 <div class="register_error"><?php echo form_error('zip');?></div>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text"><span style="color:#F00;">*</span>Mobile</p>
                </label>
                <label>
                 <input type="text" placeholder="Mobile" class="proedit_fld" name="phone" value="<?php echo $all_data[0]['phone'];?>">
                 <div class="register_error"><?php echo form_error('phone');?></div>
                </label>
                </div>
      
                <label>
                <div>
                <input type="submit" name="sub" value="SAVE CHANGE" class="btns">
                <a href="<?php echo base_url();?>user/profile">
                <input type="button" value="CANCEL" class="btns"></a>
                </div>
                </label>
                </form>
                </div>
                
              
                
            </div>
            
        </div>
        
      </div>
        
    </section>
    
   
  
  
 
  

</div>
<div class="clear"></div>