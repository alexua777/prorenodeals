<?php echo $breadcrumb;?>
<script src="<?=JS?>mycustom.js"></script>
<section id="mainpage">
<div class="container-fluid">
  <div class="row">
 
  <div class="col-md-2 col-sm-3 col-xs-12">
<?php $this->load->view('dashboard/dashboard-left'); ?>
</div> 

<div class="col-md-10 col-sm-9 col-xs-12">  
<div class="spacer-20"></div>

     
          <?php

		if($this->session->flashdata('succ_msg'))
		
		{
		
		?>
		<div class="success alert-success alert"><?php echo $this->session->flashdata('succ_msg');?></div>
		<?php
		
		}
		
		if($this->session->flashdata('error_msg'))
		
		{
		
		?>
		  <span id="agree_termsError" class="error-msg2"><?php echo $this->session->flashdata('error_msg');?></span>
		  <?php
		
		}
		
		?>
        <!--<h4 class="title-sm">Give testimonial</h4>-->
        <div class="whiteSec">
        <form name="testimonial" id="testimonial" action="<?php echo VPATH;?>testimonial" method="post" class="form-horizontal">         
          <input type="hidden" name="uid" value="<?php echo $user_id;?>"/>
          <div class="form-group">
              <div class="col-xs-12">
                <label><?php echo __('testimonial_username','Username'); ?> : <span><?php echo $username;?></span></label>
              </div>
          </div>
          <div class="form-group">
          	<div class="col-xs-12">
            <label><?php echo __('testimonial_your_feedback','Your Feedback'); ?> : </label>
            <textarea class="form-control" size="30" rows="4" name="description" id="description" tooltipText="Write Your Proper Feedback" ></textarea>
            <?php echo form_error('description', '<span class="error-msg13" style="margin: 0px !important;width: auto;">', '</span>'); ?> 
            </div>
          </div>  

            <div class="masg3" >
              <input class="btn btn-site" type="submit" id="submit-check" value="<?php echo __('testimonial_submit','Submit'); ?>" />
            </div>
         
       
        </form>          
        </div>
       
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
    </div>    
  </div>
</div>
</section>