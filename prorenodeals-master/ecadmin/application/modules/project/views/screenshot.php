<link href="<?= CSS ?>lightbox.css" rel="stylesheet" />


<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li> 
        <li class="breadcrumb-item"><a href="<?= base_url() ?>project/">Project List</a></li>       
        <li class="breadcrumb-item active"><a><?php echo $project_name;?> <span class="port_time"><?php echo date('d F, Y',strtotime($screenshot_date));?></span></a></li>
      </ol>
    </nav>        

        <div class="container-fluid">

                    <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                        </div> 
                        <?php
                    }
                    if ($this->session->flashdata('error_msg')) {
                        ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
                        </div>
							<?php
                            }
                            ?>     
						                    
                    
                    
                    
                    
                           <?php 
							foreach($tracker_details as $key=>$val)
							{
								$image_name=$pid."_".$val['id'].".jpg";
							?>
                            
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-cube"></i></div> 
                                    <h4><?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?></h4>
                                    <a href="javascript:void(0)" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body center">
                                    <p>
                                    <a class="example-image-link" href="<?php echo SITE_URL;?>time_tracker/mediafile/<?php echo $image_name;?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="<?php echo SITE_URL;?>time_tracker/mediafile/<?php echo $image_name;?>" alt="" style="max-height:200px; max-width:189px"/></a>                                   
                                    </p>
                                </div><!-- End .panel-body -->
                            </div><!-- End .widget -->
                                               
                            <?php	
							}
                      ?>                
                
                <?php echo "<div class='pagin'>".$links."</div>"; ?>
           </div>
    </div> <!-- End .wrapper  -->
</section>

 