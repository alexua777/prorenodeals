<div id="main">
    <?php echo $breadcrumb;?>
    <script src="js/mycustom.js"></script>
<div class="container">
<div class="row">

<div class="dashboard_wrap clearafter">
<h2 class="dash_headline"><?php echo $project_name;?> <span class="port_time"><?php echo date('d F, Y',strtotime($screenshot_date));?></span></h2>
<div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 portfolio-wrap">
                        <div class="row">
                           <div class="portfolio isotope">
                           <?php 
							foreach($tracker_details as $key=>$val)
							{
								$image_name=$pid."_".$val['id'].".jpg";
							?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 jquery item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="<?php echo VPATH;?>time_tracker/mediafile/<?php echo $image_name;?>">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="<?php echo VPATH;?>time_tracker/mediafile/<?php echo $image_name;?>">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p><?php echo date('d F, Y h:i:s',strtotime($val['project_work_snap_time']));?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                            <?php	
							}
							?>
                              
                             
                              <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wp css item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-2.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-2.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Fashion / Style
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 php jquery wp item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-3.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-3.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Business / Ecommerce
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wp jquery css item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-4.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-4.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Design / Development
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>

                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 web jquery item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-1.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-1.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>Design / Development</p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wp css item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-2.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-2.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Fashion / Style
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 php jquery wp item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-3.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-3.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Business / Ecommerce
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wp jquery css item isotope-item">
                                 <div class="portfolio-item">
                                    <a data-rel="prettyPhoto" class="portfolio-item-link" href="http://192.168.0.123/pixma/img/portfolio/portfolio-4.jpg">
                                    <span class="portfolio-item-hover" style="opacity: 0;"></span>
                                    <span class="fullscreen" style="top: 65%; opacity: 0;"><i class="icon-search"></i></span><img alt=" " src="http://192.168.0.123/pixma/img/portfolio/portfolio-4.jpg">
                                    </a>
                                    <div class="portfolio-item-title">
                                       <p>
                                          Design / Development
                                       </p>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </div>-->
                           </div>
                        </div>
                     </div>


</div><!--dashboard_wrap-->




 
</div><!--row--> 
</div><!--container--> 
</div>