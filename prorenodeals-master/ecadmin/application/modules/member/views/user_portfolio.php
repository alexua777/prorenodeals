<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>  
        <li class="breadcrumb-item"><a href="<?= base_url()?>member/member_list">Member List</a></li>      
        <li class="breadcrumb-item active"><a>Member Details</a></li>
      </ol>
    </nav> 
        
        
 
        <div class="container-fluid">
                  
                    <?php $this->load->view('top_nav');?>
						
                  <div class="panel-body">
				 
					
					<?php if(count($user_portfolio)>0) {
					
					
					
						foreach($user_portfolio as $profile){
					?>
					
						<div  style="float:left; width:21%;margin-right:1%; border:1px solid #ccc;padding:1%;">
							<?php 
							
							$bUrl  = base_url();
							$fUrl =str_replace("/admin","",$bUrl);
                                                        
                                                        $ext=end(explode(".",$profile['thumb_img']));
                                                        $other_file=array("pdf","xls","doc","docx","xlsx","ppt","pptx","txt","one");
                                                          if(!in_array($ext, $other_file)){ 
							?>                                                         
							<image src="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" style=" width: 200px;height:150px;">
                                                        <?php 
                                                          }
                                                          else if($ext=="pdf"){
                                                        ?>
                                                        <a href="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" target="_blank"> <image src="<?php echo $fUrl;?>assets/portfolio/pdf.jpg" style=" width: 200px;height:150px;"></a>
                                                        <?php
                                                          }
                                                          else if($ext=="xls" || $ext=="xlsx"){ 
                                                        ?>
                                                        <a href="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" target="_blank"><image src="<?php echo $fUrl;?>assets/portfolio/excel-logo.jpg" style=" width: 200px;height:150px;"></a>
                                                        <?php      
                                                          }
                                                          else if($ext=="doc" || $ext=="docx"){
                                                        ?>
                                                        <a href="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" target="_blank"> <image src="<?php echo $fUrl;?>assets/portfolio/docx.jpg" style=" width: 200px;height:150px;"></a>
                                                        <?php      
                                                          } 
                                                          else if($ext=="ppt" || $ext=="pptx"){
                                                        ?>
                                                        <a href="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" target="_blank"> <image src="<?php echo $fUrl;?>assets/portfolio/ppt.png" style=" width: 200px;height:150px;"></a>
                                                        <?php      
                                                          }
                                                          else if($ext=="txt" || $ext=="one"){
                                                        ?>
                                                        <a href="<?php echo $fUrl;?>assets/portfolio/<?php echo $profile['thumb_img']?>" target="_blank"> <image src="<?php echo $fUrl;?>assets/portfolio/txt.gif" style=" width: 200px;height:150px;"></a>
                                                        <?php      
                                                          }                                                          
                                                        ?>                                                          
                                                            
							<p >
							
							<b style="margin-right:1%;">Title :</b><?php echo $profile['title'];?><br/>
							
							<b style="margin-right:1%;">URL :</b><a href="<?php echo $profile['url'];?>" target="_blank"><?php echo $profile['url'];?></a>
							
							</p>
						</div>
					<?php } 
					
					}else{?>
					
					<div  style="float:left; width:21%;margin-right:1%; border:1px solid #ccc;padding:1%;">
					
					<p> No Portfolio Added</p>
					
					</div>
					
					<?php } ?>
				
			
				  </div>

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
