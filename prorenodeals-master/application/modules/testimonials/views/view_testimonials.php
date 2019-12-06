<!-- Main Content start-->
<div class="content">
   <div class="container">
      <div class="row">
         <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <article>
               <h3 class="title">See Our Clients Feedback</h3>
               <div class="post-content">
                  <p>
                     There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                  </p>
               </div>
            </article>
         </div>
         <!-- Left Section End -->
      </div>
      <div class="divider"></div>
      <!-- 2 Column Testimonials -->
        
      		<div class="row">
         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
         <?php foreach($get_testimonials as $key => $val){?>
            <div class="testimonial item">
               <p>
                  <?php echo html_entity_decode($val['description']);?>
               </p>
               <div class="testimonials-arrow">
               </div>
               <div class="author">
                  <div class="testimonial-image "><img alt="" src="<?php echo base_url().'/'?>assets/testimonial_image/<?=$val['image']?>"></div>
                  <div class="testimonial-author-info">
                     <a href="#"><span class="color"><?=$val['name']?></span></a>
                  </div>
               </div>
            </div>
         <?php }?>
         </div>
         
      </div>
      	 
      <div class="divider"></div>
      <!-- 2 Column Testimonials End-->
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
        <div class="addbox">
        <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
        </div>
        <?php  
 }
  }

?>
</div>
<!-- Main Content end-->