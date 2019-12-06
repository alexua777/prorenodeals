<script type="text/javascript">
function Kazi(id){
		$('#'+id+'Focus').show();
	}
	function Nasim(id){
		$('#'+id+'Focus').hide();
	}
</script>


<style>
.register_error p {
    color: #FF0000;
    float: left;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    padding: 4px 8px;
    width: 227px;
	margin-top:2px;
    }
</style>
<div class="warap">
  <div class="mid" style=" padding-bottom:80px; padding-top:50px;">
  <?php 
       if ($this->session->flashdata('succ_msg'))
	    {
	 ?>
    <div class="success"><?php  echo $this->session->flashdata('succ_msg');?></div>
    <?php
	    }
	?>
    <?php 
       if ($this->session->flashdata('error_msg'))
	    {
	 ?>
     <div class="error"><?php  echo $this->session->flashdata('error_msg');?></div>
     <?php
	    }
	 ?>

    <div class="blue_header" style="margin-left:20px; width:95%;">Forgot Password</div>
    <h3 style=" width:98%; text-align:center; font:16px/20px Arial, Helvetica, sans-serif; background:#99CCFF; padding:5px;">Enter Your registered email id below. New password will be emailed to you.</h3>
    <?php echo form_open('user/forgot_password') ?>
    <div class="mid_midle" style="border-bottom:1px dotted #999999; padding-bottom:20px;">
      <div class="filddiv">
        <input type="text" name="email" id="email" value="<?=  set_value('email')?>"  class="textfeald" placeholder="Enter your email"   />    <div class="focusmsg" id="emailFocus" style="display:none">Enter Your registered email id </div>
        <div class="register_error"><?php echo form_error('email');?></div>
      </div>
      <div class="filddiv">&nbsp;
      </div>
      <div class="filddiv">
        <input style=" text-align:center;" type="Submit" value="Submit" class="btn2" name="signup">
<!--        <input style="margin:10px 0 0 20px; float:left;" type="button" value="Clear" class="btn" name="">-->
      </div>
    </div>
    </form>
  </div>
</div>