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
        	<h2>Add New Product </h2>
            
             <div class="pro_info">
             <div class="pro_info_lft">
            	<form action="<?php echo base_url();?>user/addproduct/" method="post">
                 <div class="lable_div">
                <label>
                <p class="prof_edit_text"><span style="color:#F00;">*</span>Product Name</p>
                </label>
                 <label>
                 <input type="text" placeholder="Type Product Name" class="proedit_fld" name="name"  value="<?php echo set_value('name'); ?>">
                <?php echo form_error('name', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Select Company</p>
                </label>
                <label>
                <select class="proedit_fld_select" name="company">
                 	<option value="">Select . . .</option>
                    <?php
                    foreach($company as $key=>$val)
					{
					?>
                    <option value="<?php echo $val['comp_id']?>"><?php echo $val['name']?></option>
                    <?php
					}
					?>
                 </select>
                 <?php echo form_error('company', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Model/Batch No</p>
                </label>
                <label>
                 <input type="text" placeholder="Type Model/Batch No" class="proedit_fld" name="batch" value="<?php echo set_value('batch'); ?>">
                 <?php echo form_error('batch', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Product No</p>
                </label>
                <label>
                 <input type="text" placeholder="Input product no" class="proedit_fld" name="product_no" id="product_no" readonly="readonly"><br />
                 
                 <input type="button" class="prof_btn margin-bottom10" name="openbx" value="Generate Product No" onclick="gnrt()">
                </label>
                </div>
                
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Manufacture Date</p>
                </label>
                <label>
                 <input type="text" placeholder="Type Manufacture Date in mm/dd/yyyy format" class="proedit_fld" value="<?php echo set_value('mdate'); ?>" name="mdate">
                 <?php echo form_error('mdate', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Expiry Date</p>
                </label>
                <label>
                 <input type="text" placeholder="Type Expiry Date in mm/dd/yyyy format" class="proedit_fld" value="<?php echo set_value('edate'); ?>" name="edate">
                 <?php echo form_error('edate', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">NAFDAC No</p>
                </label>
                <label>
                 <input type="text" placeholder="Type NAFDAC No" class="proedit_fld" value="<?php echo set_value('nafdac'); ?>" name="nafdac">
                 <?php echo form_error('nafdac', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Contact No</p>
                </label>
                <label>
                 <input type="text" placeholder="Type Contact No" class="proedit_fld" value="<?php echo set_value('phone'); ?>" name="phone">
                 <?php echo form_error('phone', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                 <label>
                 <p class="prof_edit_text">Email</p>
                </label>
                <label>
                 <input type="text" placeholder="Type Email" class="proedit_fld" value="<?php echo set_value('email'); ?>" name="email">
                 <?php echo form_error('email', '<label class="error" for="required">', '</label>'); ?>
                </label>
                </div>
                
                 <div class="lable_div">
                <label>
                <input type="submit" name="submit" value="ADD" class="btns">
                <a href="<?php echo base_url();?>user/profile">
                <input type="button" value="CANCEL" class="btns"/></a>
                </label>
                </div>
                

                </form>
                </div>
                
              
                
            </div>
            
        </div>
        
      </div>
        
    </section>
    
   
  
  
 
  

</div>
<div class="clear"></div>
<script>
function gnrt()
{
	var naf=Math.floor(Math.random()*(9999999999999-1000000000000+1)+1000000000000);
	$('#product_no').val(naf);
}
</script>