  <script src="<?=base_url()?>assets/js/plugins/charts/pie-chart/jquery.easy-pie-chart.js"></script>
 <script src="<?=base_url()?>assets/js/pages/dashboard.js"></script>
  <script src="<?=base_url()?>assets/js/highcharts.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.flot.min.js"></script>
<section id="content">
<div class="wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Dashboard</a> </li>
        </ol>
	</nav>                
    <div class="container-fluid">                                                            
     <div class="row">
      <!------------- MEMBER STATISTIC START  ------------------>
        <div class="col-md-6" >
            <div class="card pull-up">
                <div class="card-header">                                    	
                    <h5><i class="la la-line-chart _125x blue"></i> Member Statistic </h5>
                    <a href="#" class="minimize"></a>
                </div><!-- End .panel-heading -->                           
                <div class="card-body" style="min-height:213px">
                    <div class="campaign-stats center" style="border-top:none;">
                        <div class="items">
                            <div class="percentage" data-percent="100"><span>100</span></div>
                                <div class="txt">Total <?php echo $total_member;?></div>
                            </div>
                            <div class="items">
                                <div class="percentage-green" data-percent="<?php echo ($active_member/$total_member)*100;?>"><span><?php echo floor(($active_member/$total_member)*100);?></span>%</div>
                                <div class="txt">Active <?php echo $active_member;?></div>
                            </div>
                 
                            <div class="items">
                                <div class="percentage" data-percent="<?php echo ($suspended_member/$total_member)*100;?>"><span><?php echo floor(($suspended_member/$total_member)*100);?></span>%</div>
                                <div class="txt">Suspended <?php echo $suspended_member;?></div>
                            </div>
                            <div class="items">
                                <div class="percentage" data-percent="<?php echo ($inactive_member/$total_member)*100;?>"><span><?php echo floor(($inactive_member/$total_member)*100);?></span>%</div>
                                <div class="txt">Inactive <?php echo $inactive_member;?></div>
                            </div>
                            
                            
                        </div>
    
                        <div class="clearfix"></div>
    
                    </div><!-- End .panel-body -->
                </div><!-- End .widget -->
        </div>
        <!------- MEMBER STATISTIC END ---------------------------->
        
        <!-------------PAID / FREE MEMBERSHIP STATISTIC START  ------------------>
        
        <?php /*?><div class="col-md-6">
        <div class="card pull-up">
            <div class="card-header">                                    	
                <h5><i class="la la-pie-chart _125x blue"></i> Membership Statistic </h5>
                <a href="#" class="minimize"></a>
            </div><!-- End .panel-heading -->
        
            <div class="card-body">
                <div class="campaign-stats center" style="border-top:none;">
                    
                        <div class="items">
                            <div class="percentage-green" data-percent="<?php echo ($free_member/$total_member)*100;?>"><span><?php echo floor(($free_member/$total_member)*100);?></span>%</div>
                            <div class="txt">Free <?php echo $free_member;?></div>
                        </div>
             
                        <div class="items">
                            <div class="percentage" data-percent="<?php echo ($silver_member/$total_member)*100;?>"><span><?php echo floor(($silver_member/$total_member)*100);?></span>%</div>
                            <div class="txt">Silver <?php echo $silver_member;?></div>
                        </div>
                        <div class="items">
                            <div class="percentage" data-percent="<?php echo ($gold_member/$total_member)*100;?>"><span><?php echo floor(($gold_member/$total_member)*100);?></span>%</div>
                            <div class="txt">Gold <?php echo $gold_member;?></div>
                        </div>
                        <div class="items">
                            <div class="percentage" data-percent="<?php echo ($platinum_member/$total_member)*100;?>"><span><?php echo floor(($platinum_member/$total_member)*100);?></span>%</div>
                            <div class="txt">Platinum <?php echo $platinum_member;?></div>
                        </div>
                        
                        
                    </div>                
            </div><!-- End .panel-body -->
            </div><!-- End .widget -->
        </div><?php */?>
        <div class="col-md-6 col-xs-12">
			<div class="card pull-up">
                <div class="card-header">                   
                  <h5><i class="la la-registered _125x blue"></i> Registration Statistic</h5>
                  <a href="#" class="minimize"></a>
                </div><!-- End .panel-heading -->
    
                <div class="card-body" style="padding:0; padding-top:1rem">                                
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?=date('F Y',strtotime('-2 month'))?></a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?=date('F Y',strtotime('last month'))?></a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><?=date('F Y')?></a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="border:none; margin-top:12px">
                  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  
                  <div class="stats-buttons">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon orangeBG"><i class="la la-user"></i></span>
                                <span class="number"><?php echo $total_registration_2;?></span>
                                <span class="txt">Total User</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon redBG"><i class="la la-money"></i></span>
                                <span class="number"><?php echo $paid_registration_2;?></span>
                                <span class="txt">Paid User</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon greenBG"><i class="la la-frown-o"></i></span>
                                <span class="number"><?php echo $free_registration_2;?></span>
                                <span class="txt">Free User</span>
                            </a>
                        </li>
                    </ul>
                </div>
                  </div>
                  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
             
                  <div class="stats-buttons">
                        <ul class="list-unstyled">
                            <li>
                                <a href="#" class="clearfix">
                                    <span class="icon orangeBG"><i class="la la-user"></i></span>
                                    <span class="number"><?php echo $total_registration_1;?></span>
                                    <span class="txt">Total User</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#" class="clearfix">
                                    <span class="icon redBG"><i class="la la-money"></i></span>
                                    <span class="number"><?php echo $paid_registration_1;?></span>
                                    <span class="txt">Paid User</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="clearfix">
                                    <span class="icon greenBG"><i class="la la-frown-o"></i></span>
                                    <span class="number"><?php echo $free_registration_1;?></span>
                                    <span class="txt">Free User</span>
                                </a>
                            </li>
                        </ul>
                  </div>
                  </div>
                  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
          
                  <div class="stats-buttons">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon orangeBG"><i class="la la-user"></i></span>
                                <span class="number"><?php echo $total_registration_current;?></span>
                                <span class="txt">Total User</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon redBG"><i class="la la-money"></i></span>
                                <span class="number"><?php echo $paid_registration_current;?></span>
                                <span class="txt">Paid User</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="clearfix">
                                <span class="icon greenBG"><i class="la la-frown-o"></i></span>
                                <span class="number"><?php echo $free_registration_current;?></span>
                                <span class="txt">Free User</span>
                            </a>
                        </li>
                    </ul>
                </div>
                  </div>
                </div>

                
				</div><!-- End .panel-body -->
                </div><!-- End .widget -->  
		</div>
        <!-------------PAID / FREE MEMBERSHIP STATISTIC END  ------------------>
        </div>
                            
        <!-------- MEMBER GRAPH END --------->
        
                <div class="row">
				<div class="col-md-6 col-xs-12">
                <div class="card pull-up">        
                <div class="card-header">                                    
                <h5><i class="la la-pie-chart _125x blue"></i> Member Graph Chart</h5>
                <a class="minimize" href="#"></a>
                
                </div><!-- End .panel-heading -->
                <div class="card-body">                
                 <div class="campaign-stats center" style="border-top:none;">
                <style>
                #tooltip{background:#000; color:#fff;padding:5px 10px;font-family:inherit; font-size:9px;}
                .tooltip{position:absolute;z-index:1030;display:block;visibility:visible;font-size:11px;line-height:1.4;opacity:0;filter:alpha(opacity=0);}.tooltip.in{opacity:0.8;filter:alpha(opacity=80);}
                .tooltip.top{margin-top:-3px;padding:5px 0;}
                .tooltip.right{margin-left:3px;padding:0 5px;}
                .tooltip.bottom{margin-top:3px;padding:5px 0;}
                .tooltip.left{margin-left:-3px;padding:0 5px;}
                .tooltip-inner{max-width:200px;padding:8px;color:#ffffff;text-align:center;text-decoration:none;background-color:#000000;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;}
                .tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid;}
                .tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000000;}
                .tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000000;}
                .tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000000;}
                .tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000000;}
                </style>
                
                <table width="100%" align="center" border="0" cellpadding="4" cellspacing="0">
                <tr class="lnk" bgcolor="#ffffff">
                <td align="left" width="100%">
                <div id="chartplace" style="height:300px;"></div>
                <script type="text/javascript">
                jQuery(document).ready(function() {
                
                // simple chart
                var active = [
                        <?php 
                        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                                //$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'Y' AND `reg_date` LIKE '".$i."-%'");
                                //$res = mysql_fetch_assoc($qry);
                                $res=$this->user_model->getMember('Y',$i);
                                if($i== date('Y')){
                                    echo '['.$i.', '.$res.']';
                                }
                                else{
                                    echo '['.$i.', '.$res.'], ';
                                }
                        }
                        ?>
                    ];
                var inactive = [
                    <?php 
                        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                                //$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'N' AND `reg_date` LIKE '".$i."-%'");
                                //$res = mysql_fetch_assoc($qry);
                                $res=$this->user_model->getMember('N',$i);
                                
                                if($i== date('Y')){
                                    echo '['.$i.', '.$res.']';
                                }
                                else{
                                    echo '['.$i.', '.$res.'], ';
                                }
                        }
                        ?>
                        ];
                var suspended = [
                        <?php 
                        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                                //$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'S' AND `reg_date` LIKE '".$i."-%'");
                                //$res = mysql_fetch_assoc($qry);
                                $res=$this->user_model->getMember('S',$i);
                                if($i== date('Y')){
                                    echo '['.$i.', '.$res.']';
                                }
                                else{
                                    echo '['.$i.', '.$res.'], ';
                                }
                        }
                        ?>
                        ];
                
                
                
                function showTooltip(x, y, contents) {
                jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5
                }).appendTo("body").fadeIn(200);
                }		
                var plot = jQuery.plot(jQuery("#chartplace"),
                [ { data: active, label: "Active Member", color: "#6fad04"},
                 { data: inactive, label: "Inactive Member", color: "#f00"},
                 { data: suspended, label: "Suspended Member", color: "#06c"}],
                
                  {
                   series: {
                       lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
                       points: { show: true }
                   },
                   legend: { position: 'nw'},
                   grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },
                   xaxis: { min: <?=date('Y')-5?>, max: <?=date('Y')?>, 
                            tickFormatter: function suffixFormatter(val, axis) {
                                return (val.toFixed(0));
                            }
                         }
                 });
                
                var previousPoint = null;
                jQuery("#chartplace").bind("plothover", function (event, pos, item) {
                jQuery("#x").text(pos.x);
                jQuery("#y").text(pos.y);
                
                if(item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;
                        
                    jQuery("#tooltip").remove();
                    var x = item.datapoint[0];
                    var y = item.datapoint[1];
                        
                    showTooltip(item.pageX, item.pageY,
                                    item.series.label + " " + parseInt(y) + " on " + parseInt(x));
                }
                
                } else {
                jQuery("#tooltip").remove();
                previousPoint = null;            
                }
                
                });
                
                jQuery("#chartplace").bind("plotclick", function (event, pos, item) {
                if (item) {
                jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
                plot.highlight(item.series, item.datapoint);
                }
                });
                });
                </script>
                </td>
                
                
                </tr>
                </table>
                                    </div>
                
                
                
                                    <div class="clearfix"></div>
                
                
                
                                </div><!-- End .panel-body -->                                                                
                
                </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card pull-up">
                        <div class="card-header">                            
                            <h5><i class="la la-line-chart _125x blue"></i> Project Statistic</h5>
                            <a href="#" class="minimize"></a>
                        </div><!-- End .panel-heading -->
               
                        <div class="card-body">
                            <div class="campaign-stats center" style="border-top:none;">
                                <div class="items">
                                    <div class="percentage" data-percent="100"><span>100</span></div>
                                        <div class="txt">Total Project <?php echo $total_project;?></div>
                                    </div>
                                    <div class="items">
                                        <div class="percentage-green" data-percent="<?php echo ($open_project/$total_project)*100;?>"><span><?php echo floor(($open_project/$total_project)*100);?></span>%</div>
                                        <div class="txt">Open Project <?php echo $open_project;?></div>
                                    </div>
                         
                                    <div class="items" hidden>
                                        <div class="percentage" data-percent="<?php echo ($frozen_project/$total_project)*100;?>"><span><?php echo floor(($frozen_project/$total_project)*100);?></span>%</div>
                                        <div class="txt">Frozen Project <?php echo $frozen_project;?></div>
                                    </div>
                                    <div class="items">
                                        <div class="percentage" data-percent="<?php echo ($working_project/$total_project)*100;?>"><span><?php echo floor(($working_project/$total_project)*100);?></span>%</div>
                                        <div class="txt">Working Project <?php echo $working_project;?></div>
                                    </div>
                                    <div class="items">
                                        <div class="percentage" data-percent="<?php echo ($complete_project/$total_project)*100;?>"><span><?php echo floor(($complete_project/$total_project))*100;?></span>%</div>
                                        <div class="txt">Complete Project <?php echo $complete_project;?></div>
                                    </div>
                                    <div class="items">
                                        <div class="percentage-red" data-percent="<?php echo ($expire_project/$total_project)*100;?>"><span><?php echo floor(($expire_project/$total_project)*100);?></span>%</div>
                                        <div class="txt">Expire Project <?php echo $expire_project;?></div>
                                    </div>
                                </div>
    
                                <div class="clearfix"></div>
    
                            </div><!-- End .panel-body -->
                        </div><!-- End .widget -->
                    </div>
                    <!-- End .col-lg-6  --> 
                    </div>
                    
                <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="card pull-up">
                        <div class="card-header">                            
                            <h5><i class="la la-bar-chart _125x blue"></i> Project Graph Chart</h5>
                            <a href="#" class="minimize"></a>
                        </div><!-- End .panel-heading -->
               
                        <div class="card-body">
                            <div class="campaign-stats center" style="border-top:none;">
                                <style>
    #tooltip{background:#000; color:#fff;padding:5px 10px;font-family:inherit; font-size:9px;}
    .tooltip{position:absolute;z-index:1030;display:block;visibility:visible;font-size:11px;line-height:1.4;opacity:0;filter:alpha(opacity=0);}.tooltip.in{opacity:0.8;filter:alpha(opacity=80);}
    .tooltip.top{margin-top:-3px;padding:5px 0;}
    .tooltip.right{margin-left:3px;padding:0 5px;}
    .tooltip.bottom{margin-top:3px;padding:5px 0;}
    .tooltip.left{margin-left:-3px;padding:0 5px;}
    .tooltip-inner{max-width:200px;padding:8px;color:#ffffff;text-align:center;text-decoration:none;background-color:#000000;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;}
    .tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid;}
    .tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000000;}
    .tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000000;}
    .tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000000;}
    .tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000000;}
    </style>
    
    <table width="100%" align="center"  border="0" cellpadding="4" cellspacing="0">
    <tr class="lnk" bgcolor="#ffffff">
    
    <td align="left" width="100%">
    <div id="chartplace1" style="height:300px;"></div>
    <script type="text/javascript">
    jQuery(document).ready(function() {
    
    // simple chart
    var openp = [
            <?php 
            for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                    
                    $res=$this->user_model->getProject('O',$i);
                    //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'O' AND `post_date` LIKE '".$i."-%'");
                    //$res = mysql_fetch_assoc($qry);
                    if($i== date('Y')){
                        echo '['.$i.', '.intval($res).']';
                    }
                    else{
                        echo '['.$i.', '.intval($res).'], ';
                    }
            }
            ?>
        ];
    var progress = [
            <?php 
            for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                $res=$this->user_model->getProject('P',$i);
                    //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'P' AND `post_date` LIKE '".$i."-%'");
                    //$res = mysql_fetch_assoc($qry);
                    if($i== date('Y')){
                        echo '['.$i.', '.intval($res).']';
                    }
                    else{
                        echo '['.$i.', '.intval($res).'], ';
                    }
            }
            ?>
        ];
    var complete = [
            <?php 
            for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                
                $res=$this->user_model->getProject('C',$i);
                    //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'C' AND `post_date` LIKE '".$i."-%'");
                    //$res = mysql_fetch_assoc($qry);
                    if($i== date('Y')){
                        echo '['.$i.', '.intval($res).']';
                    }
                    else{
                        echo '['.$i.', '.intval($res).'], ';
                    }
            }
            ?>
        ];
    var expire = [
            <?php 
            for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                    $res=$this->user_model->getProject('E',$i);
                    //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'E' AND `post_date` LIKE '".$i."-%'");
                    //$res = mysql_fetch_assoc($qry);
                    if($i== date('Y')){
                        echo '['.$i.', '.intval($res).']';
                    }
                    else{
                        echo '['.$i.', '.intval($res).'], ';
                    }
            }
            ?>
        ];
    var frozen = [
            <?php 
            for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                $res=$this->user_model->getProject('F',$i);
                    //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'F' AND `post_date` LIKE '".$i."-%'");
                    //$res = mysql_fetch_assoc($qry);
                    if($i== date('Y')){
                        echo '['.$i.', '.intval($res).']';
                    }
                    else{
                        echo '['.$i.', '.intval($res).'], ';
                    }
            }
            ?>
        ];
        
                
        
    
    
    function showTooltip(x, y, contents) {
    jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
    position: 'absolute',
    display: 'none',
    top: y + 5,
    left: x + 5
    }).appendTo("body").fadeIn(200);
    }
    
    
    var plot = jQuery.plot(jQuery("#chartplace1"),
    [ { data: openp, label: "Open Project", color: "#6fad04"},
    { data: progress, label: "On Progress Project", color: "#06c"},
    { data: complete, label: "Completed Project", color: "#d6c"},
    { data: frozen, label: "Frozen Project", color: "#dfc"},
    { data: close, label: "Close Project", color: "#EB7D00"},
    { data: expire, label: "Expired Project", color: "#f00"} ], {
       series: {
           lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
           points: { show: true }
       },
       legend: { position: 'nw'},
       grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },
       xaxis: { min: <?=date('Y')-5?>, max: <?=date('Y')?>, 
                tickFormatter: function suffixFormatter(val, axis) {
                    return (val.toFixed(0));
                }
             }
     });
    
    var previousPoint = null;
    jQuery("#chartplace1").bind("plothover", function (event, pos, item) {
    jQuery("#x").text(pos.x);
    jQuery("#y").text(pos.y);
    
    if(item) {
    if (previousPoint != item.dataIndex) {
        previousPoint = item.dataIndex;
            
        jQuery("#tooltip").remove();
        var x = item.datapoint[0].toFixed(0),
        y = item.datapoint[1].toFixed(1);
            
        showTooltip(item.pageX, item.pageY,
                        item.series.label + " of " + x + " = " + y);
    }
    
    } else {
    jQuery("#tooltip").remove();
    previousPoint = null;            
    }
    
    });
    
    jQuery("#chartplace1").bind("plotclick", function (event, pos, item) {
    if (item) {
    jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
    plot.highlight(item.series, item.datapoint);
    }
    });
    });
    </script>
    </td>
    
    </tr>
    </table>
                                </div>
                                <div class="clearfix"></div>
    
                            </div><!-- End .panel-body -->
                        </div><!-- End .widget -->
                </div>
                    <!-------------FINANCIAL STATISTICS START ---------------->
                <div class="col-md-6 col-xs-12">
                <div class="card pull-up">
                    <div class="card-header">                        
                        <h5><i class="la la-dollar _125x blue"></i> Financial Graph Chart</h5>
                        <a href="#" class="minimize"></a>
                    </div><!-- End .panel-heading -->
           
                    <div class="card-body">
                        <div class="campaign-stats center" style="border-top:none;">
                            <style>
#tooltip{background:#000; color:#fff;padding:5px 10px;font-family:inherit; font-size:9px;}
.tooltip{position:absolute;z-index:1030;display:block;visibility:visible;font-size:11px;line-height:1.4;opacity:0;filter:alpha(opacity=0);}.tooltip.in{opacity:0.8;filter:alpha(opacity=80);}
.tooltip.top{margin-top:-3px;padding:5px 0;}
.tooltip.right{margin-left:3px;padding:0 5px;}
.tooltip.bottom{margin-top:3px;padding:5px 0;}
.tooltip.left{margin-left:-3px;padding:0 5px;}
.tooltip-inner{max-width:200px;padding:8px;color:#ffffff;text-align:center;text-decoration:none;background-color:#000000;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;}
.tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid;}
.tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000000;}
.tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000000;}
.tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000000;}
.tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000000;}
</style>

<table width="100%" align="center"  border="0" cellpadding="4" cellspacing="0">
<tr class="lnk" bgcolor="#ffffff">

<td align="left" width="100%">
<div id="chartplace2" style="height:300px;"></div>
<script type="text/javascript">
jQuery(document).ready(function() {

// simple chart
var credit = [
        <?php 
        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
                
                $res=$this->user_model->getFinance('CR',$i);
                //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'O' AND `post_date` LIKE '".$i."-%'");
                //$res = mysql_fetch_assoc($qry);
                if($i== date('Y')){
                    echo '['.$i.', '.intval($res).']';
                }
                else{
                    echo '['.$i.', '.intval($res).'], ';
                }
        }
        ?>
    ];
var debit = [
        <?php 
        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
            $res=$this->user_model->getFinance('DR',$i);
                //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'P' AND `post_date` LIKE '".$i."-%'");
                //$res = mysql_fetch_assoc($qry);
                if($i== date('Y')){
                    echo '['.$i.', '.intval($res).']';
                }
                else{
                    echo '['.$i.', '.intval($res).'], ';
                }
        }
        ?>
    ];
var profit = [
        <?php 
        for($i=intval(date('Y')-5); $i<= date('Y'); $i++){
            
            $res=$this->user_model->getProfit_new($i);
                //$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'C' AND `post_date` LIKE '".$i."-%'");
                //$res = mysql_fetch_assoc($qry);
                if($i== date('Y')){
                    echo '['.$i.', '.intval($res).']';
                }
                else{
                    echo '['.$i.', '.intval($res).'], ';
                }
        }
        ?>
    ];

    
            
    


function showTooltip(x, y, contents) {
jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
position: 'absolute',
display: 'none',
top: y + 5,
left: x + 5
}).appendTo("body").fadeIn(200);
}


var plot = jQuery.plot(jQuery("#chartplace2"),
[

{ data: profit, label: "Net Profit", color: "#d6c"} 

], {
   series: {
       lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
       points: { show: true }
   },
   legend: { position: 'nw'},
   grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },
   xaxis: { min: <?=date('Y')-5?>, max: <?=date('Y')?>, 
            tickFormatter: function suffixFormatter(val, axis) {
                return (val.toFixed(0));
            }
         }
 });

var previousPoint = null;
jQuery("#chartplace2").bind("plothover", function (event, pos, item) {
jQuery("#x").text(pos.x);
jQuery("#y").text(pos.y);

if(item) {
if (previousPoint != item.dataIndex) {
    previousPoint = item.dataIndex;
        
    jQuery("#tooltip").remove();
    var x = item.datapoint[0].toFixed(0),
    y = item.datapoint[1].toFixed(1);
        
    showTooltip(item.pageX, item.pageY,
                    item.series.label + " of " + x + " = " + y);
}

} else {
jQuery("#tooltip").remove();
previousPoint = null;            
}

});

jQuery("#chartplace2").bind("plotclick", function (event, pos, item) {
if (item) {
jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
plot.highlight(item.series, item.datapoint);
}
});
});
</script>
</td>

</tr>
</table>
                            </div>
                            <div class="clearfix"></div>

                        </div><!-- End .panel-body -->
                    </div><!-- End .widget -->
                </div>
                    <!-- End .col-lg-6  --> 
                </div>
       
                  <!-- End .row-fluid  -->
      
    </div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>

<!--<script>
  $(function () {
    $('#myTab li:last-child a').tab('show')
  })
</script>-->
   