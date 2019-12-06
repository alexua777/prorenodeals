 <!-- Content Start -->
   <div id="main">
    <?php echo $breadcrumb;?>
    <script type="text/javascript">
	function loginFormPost(){
		FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>affiliate/resetpass",'register');
    }
	</script>      
	<script src="<?=JS?>mycustom.js"></script>	
           <!-- Main Content start-->
            <div class="content">
               <div class="container" style="min-height: 437px;">
                      <div class="row">
                     <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="contact-form" style="width:100%;">
                       <h3 class="title">Reset Password</h3>
                        <div class="loginright"></div>
                      
                        <div class="success alert-success alert" style="display:none; position: absolute;">
						</div>
						<?php
						$attributes = array('id' => 'register','class' => 'reply','role'=>'form','name'=>'register','onsubmit'=>"disable");
						echo form_open('', $attributes);
						?>
						
                     <span id="agree_termsError" class="rerror error alert-error alert" style="display:none"></span>
						
                        <div class="divider"></div>
                           <fieldset>
                              
							 
                              <div class="row">
							  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                             
							 
                              <div style="clear:both;"></div>
                              	<input type="hidden" name="uid" value="<?php echo $user_id?>" readonly/>
                              	<input type="hidden" name="v_code" value="<?php echo $v_code?>" readonly/>
                                    <label>Enter New Password: <span>*</span></label>
                                    <input class="form-control" id="user_pass" name="user_pass" type="password" value="<?php echo set_value('user_pass');?>" required tooltipText="Enter New Password" /> 
									<span id="user_passError" class="rerror"></span>
                                    
                                    <label>Confirm New Password: <span>*</span></label>
                                    <input class="form-control" id="conf_pass" name="conf_pass" type="password" value="<?php echo set_value('conf_pass');?>" required tooltipText="Please Confirm Password" /> 
									<span id="conf_passError" class="rerror"></span>
                                </div>
                              </div>
							  
                           </fieldset><div style="clear:both">&nbsp;</div>
                           <input class="btn-normal btn-color submit  bottom-pad" type="button" id="submit-check" onclick="loginFormPost()" value="Submit" />  
                           
                           
                           <div class="clearfix">
						   
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div style="clear:both;"></div>
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
<div style="clear:both;"></div>
            </div>
         </div>
         <!-- Content End -->