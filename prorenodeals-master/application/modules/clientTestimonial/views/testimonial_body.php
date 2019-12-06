<div id="main">
    
            <!-- Title, Breadcrumb Start-->

            <?php echo $breadcrumb;?>
                  
			<script src="<?=JS?>mycustom.js"></script> 
 <!-- Main Content start-->
            <div class="content">
               <div class="container">
                  <div class="row">
                     <div class="posts-block col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <article>
                           <h3 class="title">Clients Feedback</h3>
                           <div class="post-content">
                              <p><h4>
                                 What Our members said about us!!</h4>
                              </p>
                           </div>
                        </article>
                     </div>
                     <!-- Left Section End -->
                     
                     
<!--New page-->
<div class="comments-sec">
                              <ol class="commentlist">
                                 <li>
                                          
                                    <div class="clearfix">
                                    </div>
                                 </li>
                                 <?php
                                 foreach($testimonial as $key=>$val)
								 {
									 $logo=$this->auto_model->getFeild('logo','user','user_id',$val['user_id']);
									 $fname=$this->auto_model->getFeild('fname','user','user_id',$val['user_id']);
									 $lname=$this->auto_model->getFeild('lname','user','user_id',$val['user_id']);
								 ?>
                                 <li>
                                    <div class="comment" id="2">
                                       <div class="avatar">
                                       <?php
                                       if($logo!='')
									   {
									   ?>
                                          <img alt="" src="<?php echo ASSETS;?>uploaded/<?php echo $logo;?>">
                                          <?php
									   }
									   else
									   {
										 ?>
                                         <img alt="" src="<?php echo ASSETS;?>images/face_icon.gif">
                                         <?php  
										 }
										  ?>
                                       </div>
                                       <div class="comment-des">
                                          <div class="arrow-comment">
                                          </div>
                                          <div class="comment-by">
                                             <strong><?php echo $fname." ".$lname;?></strong><span class="date"><?php echo date('M d, Y',strtotime($val['posted_date']));?></span><!--<span class="reply"><a href="#"><i class="icon-reply"></i> Reply</a></span>-->
                                          </div>
                                          <p>
                                            <?php
                                            echo html_entity_decode($val['description']);
											?>
                                          </p>
                                       </div>
                                       <div class="clearfix">
                                       </div>
                                    </div>
                                 </li>
                                 <?php
								 }
								 ?>
                                 <!--<li>
                                    <div class="comment" id="4">
                                       <div class="avatar">
                                          <img alt="" src="../../clientTestimonials/views/img/testimonial/team-member-3.jpg">
                                       </div>
                                       <div class="comment-des">
                                          <div class="arrow-comment">
                                          </div>
                                          <div class="comment-by">
                                             <strong>Indy Parker</strong><span class="date">July 30, 2013</span><span class="reply"><a href="#"><i class="icon-reply"></i> Reply</a></span>
                                          </div>
                                          <p>
                                             Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                                          </p>
                                       </div>
                                       <div class="clearfix">
                                       </div>
                                    </div>
                                 </li>-->
                              </ol>
                           </div>

<!--New page End-->
                  </div>
                  <div class="divider"></div>
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
 <!-- Main Content end-->
</div>