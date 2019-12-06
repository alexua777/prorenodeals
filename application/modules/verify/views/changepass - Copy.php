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
 
 <div class="logpage1_area" style="margin-left:370px;"><!--start rht area-->
 <h2>Client Portal</h2>
 <?php
 if($this->session->flashdata('error_msg'))
 {
 ?>
 <h2><?php echo $this->session->flashdata('error_msg');?></h2>
 <?php
 }
 ?>
<form method="post" action="<?php echo base_url();?>user/changepassword">
<label>
<p class="login_text_fld_text">Enter Current password</p>
</label>
	<div class="lable_div">
	<label>
    <input type="password" placeholder="Enter current password" class="login_text_fld" name="currpass" value="<?=  set_value('currpass')?>">
    <div class="register_error"><?php echo form_error('currpass');?></div>
    </label>
    </div>
    <label>
<p class="login_text_fld_text">Enter New password</p>
</label>
	<div class="lable_div">
	<label>
    <input type="password" placeholder="Enter new password" class="login_text_fld" name="npass" value="<?=  set_value('npass')?>">
    <div class="register_error"><?php echo form_error('npass');?></div>
    </label>
    </div>
    
    <label>
<p class="login_text_fld_text">Confirm new password</p>
</label>
	<div class="lable_div">
	<label>
    <input type="password" placeholder="Confirm new password" class="login_text_fld" name="cpass" value="<?=  set_value('cpass')?>">
    <div class="register_error"><?php echo form_error('cpass');?></div>
    </label>
    </div>
    
   <div class="lable_div">
    <input type="submit" value="Submit" name="sub" class="logpage_btns"/>
   </div>
    
  </form>
 </div>   
    
    
    
    
 </section>
 

  

</div>
<div class="clear"></div>