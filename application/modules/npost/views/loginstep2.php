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
    width:70%;
    }
</style>
<div class="wrapper">
 <section>
 
 <div class="logpage1_area"><!--start rht area-->
 <h2>Client Portal</h2>
<form action="<?php echo base_url();?>login/steptwo" method="post">
<div class="lable_div">
<label>
<p class="login_text_fld_text">Enter your password</p>
</label>
</div>

<div class="lable_div">
	<label>
    <input type="hidden" name="curpass" value="<?php echo $all_data[0]['password']?>" />
    <input type="password" placeholder="Enter your password" class="login_text_fld" name="password">
    <div class="register_error"><?php echo form_error('password');?></div>
    </label>
    </div>
    
    <div class="lable_div">
    <label><p class="login_text_fld_text"><a href="#">Forgot your password</a></p></label>
    </div>
   
   <div class="lable_div">
    <input type="submit" value="Submit" name="sub" class="logpage_btns"/>
    </div>
    
  </form>
 </div>   
    
    
    
    
 </section>
 

  

</div>
<div class="clear"></div>