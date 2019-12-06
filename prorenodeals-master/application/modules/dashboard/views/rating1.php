<?php echo $breadcrumb;?>
<script type="text/javascript">

function editFormPost(){

FormPost('#submit-check',"<?=VPATH?>","<?=VPATH?>dashboard/check",'editprofile');

}

</script>
<script src="<?=JS?>mycustom.js"></script>

<section class="sec-60">
<div class="container">
  <div class="row">
 	<?php echo $leftpanel;?>    
    
    <div class="col-md-9 col-sm-8 col-xs-12">
        
        <div class="profile_right"> 
          <!--EditProfile Start-->
          
          <?php 
    if ($this->session->flashdata('rating_succ'))
    {
    ?>
          <div class="success alert-success alert">
            <?php  echo $this->session->flashdata('rating_succ');?>
          </div>
          <?php
    }
    ?>
          <?php 
    if ($this->session->flashdata('rating_eror'))
    {
    ?>
          <div class="success alert-success alert">
            <?php  echo $this->session->flashdata('rating_eror');?>
          </div>
          <?php
    }
    ?>
          <?php
    $title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
    ?>          	
            <h4 class="title-sm"><?php echo __('dashboard_rating_give_feedback','Give Feedback'); ?></h4>
            <div class="notiftext">
            	<span class="text-uppercase"><?php echo __('dashboard_rating_put_your_rating_here','Put your rating here'); ?></span>
            </div>
            <div class="whiteSec">
            <form method="post" class="form-horizontal" action="<?php echo VPATH;?>dashboard/rating/<?php echo $project_id;?>/<?php echo $user_id;?>/<?php echo $title;?>">                           
              <input type="hidden" name="given_id" value="<?php echo $given_id;?>">
              <input type="hidden" name="project_id" value="<?php echo $project_id;?>">
              <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
              <div class="form-group">
                <div class="col-sm-6 col-xs-12">
                <label><?php echo __('dashboard_safety','Safety'); ?> :</label>
                <select class="form-control" name="safety" id="safety">
                  <option value=""><?php echo __('dashboard_select_rating','Select Rating'); ?></option>
                  <option value="1" <?php echo set_select('safety', '1'); ?>><?php echo __('dashboard_poor','Poor'); ?></option>
                  <option value="2" <?php echo set_select('safety', '2'); ?>><?php echo __('dashboard_average','Average'); ?></option>
                  <option value="3" <?php echo set_select('safety', '3'); ?>><?php echo __('dashboard_normal','Normal'); ?></option>
                  <option value="4" <?php echo set_select('safety', '4'); ?>><?php echo __('dashboard_good','Good'); ?></option>
                  <option value="5" <?php echo set_select('safety', '5'); ?>><?php echo __('dashboard_excellent','Excellent'); ?></option>
                </select>
                <?php echo form_error('safety', '<div class="errorvalidation">', '</div>'); ?> 
                </div>
                <div class="col-sm-6 col-xs-12">
                <label><?php echo __('dashboard_flexibility','Flexiblity'); ?> :</label>
                <select class="form-control" name="flexiblity" id="flexiblity">
                  <option value=""><?php echo __('dashboard_select_rating','Select Rating'); ?></option>
                  <option value="1" <?php echo set_select('flexiblity', '1'); ?>><?php echo __('dashboard_poor','Poor'); ?></option>
                  <option value="2" <?php echo set_select('flexiblity', '2'); ?>><?php echo __('dashboard_average','Average'); ?></option>
                  <option value="3" <?php echo set_select('flexiblity', '3'); ?>><?php echo __('dashboard_normal','Normal'); ?></option>
                  <option value="4" <?php echo set_select('flexiblity', '4'); ?>><?php echo __('dashboard_good','Good'); ?></option>
                  <option value="5" <?php echo set_select('flexiblity', '5'); ?>><?php echo __('dashboard_excellent','Excellent'); ?></option>
                </select>
                <?php echo form_error('flexiblity', '<div class="errorvalidation">', '</div>'); ?>
                </div>
              </div>
                
              
              <div class="form-group">
                <div class="col-sm-6 col-xs-12">
                <label><?php echo __('dashboard_performence','Performence'); ?> :</label>
                <select class="form-control" name="performence" id="performence">
                  <option value=""><?php echo __('dashboard_select_rating','Select Rating'); ?></option>
                  <option value="1" <?php echo set_select('performence', '1'); ?>><?php echo __('dashboard_poor','Poor'); ?></option>
                  <option value="2"  <?php echo set_select('performence', '2'); ?>><?php echo __('dashboard_average','Average'); ?></option>
                  <option value="3"  <?php echo set_select('performence', '3'); ?>><?php echo __('dashboard_normal','Normal'); ?></option>
                  <option value="4" <?php echo set_select('performence', '4'); ?>><?php echo __('dashboard_good','Good'); ?></option>
                  <option value="5" <?php echo set_select('performence', '5'); ?>><?php echo __('dashboard_excellent','Excellent'); ?></option>
                </select>
                <?php echo form_error('performence', '<div class="errorvalidation">', '</div>'); ?>
                </div>
              
                <div class="col-sm-6 col-xs-12">                	
                <label><?php echo __('dashboard_initiative','Initiative'); ?> :</label>
                <select class="form-control" name="initiative" id="initiative">
                  <option value=""><?php echo __('dashboard_select_rating','Select Rating'); ?></option>
                  <option value="1" <?php echo set_select('initiative', '1'); ?>><?php echo __('dashboard_poor','Poor'); ?></option>
                  <option value="2" <?php echo set_select('initiative', '2'); ?>><?php echo __('dashboard_average','Average'); ?></option>
                  <option value="3" <?php echo set_select('initiative', '3'); ?>><?php echo __('dashboard_normal','Normal'); ?></option>
                  <option value="4" <?php echo set_select('initiative', '4'); ?>><?php echo __('dashboard_good','Good'); ?></option>
                  <option value="5" <?php echo set_select('initiative', '5'); ?>><?php echo __('dashboard_excellent','Excellent'); ?></option>
                </select>
                <?php echo form_error('initiative', '<div class="errorvalidation">', '</div>'); ?>
                </div>
              </div>
              <div class="form-group">
              <div class="col-sm-6 col-xs-12">
                <label><?php echo __('dashboard_knowledge','Knowledge'); ?> :</label>
                <select class="form-control" name="knowledge" id="knowledge">
                  <option value=""><?php echo __('dashboard_select_rating','Select Rating'); ?></option>
                  <option value="1" <?php echo set_select('knowledge', '1'); ?>><?php echo __('dashboard_poor','Poor'); ?></option>
                  <option value="2" <?php echo set_select('knowledge', '2'); ?>><?php echo __('dashboard_average','Average'); ?></option>
                  <option value="3" <?php echo set_select('knowledge', '3'); ?>><?php echo __('dashboard_normal','Normal'); ?></option>
                  <option value="4" <?php echo set_select('knowledge', '4'); ?>><?php echo __('dashboard_good','Good'); ?></option>
                  <option value="5" <?php echo set_select('knowledge', '5'); ?>><?php echo __('dashboard_excellent','Excellent'); ?></option>
                </select>
                <?php echo form_error('knowledge', '<div class="errorvalidation">', '</div>'); ?>
                
                </div>   
              </div>
              <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                <label><?php echo __('dashboard_comment','Comment'); ?> :</label>
                <textarea class="form-control" cols="30" rows="6" name="comment" id="comment"></textarea>
                </div>             
              </div>                 
              <input class="btn btn-site" type="submit" name="submit"  value="<?php echo __('dashboard_submit','Submit'); ?>" />              
            </form>
          </div>
          <!--EditProfile End--> 
          
        </div>       
        
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
      <div class="addbox2"> <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a> </div>
      <?php  
    }
    }
    
    ?>
      <div class="clearfix"></div>
    </div>
        
  </div>
</div>
</section>
