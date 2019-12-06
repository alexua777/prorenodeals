<?php echo $breadcrumb;?>      

<script src="<?=JS?>mycustom.js"></script>
<section class="sec-60">
<div class="container">
    <div class="row">
    <?php echo $leftpanel;?> 
    <!-- Sidebar End -->
    <div class="col-md-9 col-sm-8 col-xs-12">
	    <ul class="tab">
            <li><a href="<?php echo VPATH?>dashboard/myproject_professional">My Proposal</a></li>
            <li><a class="selected" href="<?php echo VPATH?>dashboard/myproject_working">Active Projects</a></li>
            <li><a href="<?php echo VPATH?>dashboard/myproject_completed">Completed Projects</a></li>        
    	</ul>
		<?php 
        if ($this->session->flashdata('mile_succ'))
        {
        ?>
        <div class="success alert-success alert"><?php  echo $this->session->flashdata('mile_succ');?></div>
        <?php
        }
        ?>
        <?php 
        if ($this->session->flashdata('succ_msg'))
        {
        ?>
        <div class="success alert-success alert"><?php  echo $this->session->flashdata('succ_msg');?></div>
        <?php
        }
        ?>
        <?php 
        if ($this->session->flashdata('error_msg'))
        {
        ?>
        <div class="error alert-error alert"><?php  echo $this->session->flashdata('error_msg');?></div>
        <?php
        }
        ?> 
    <!--EditProfile Start-->
    <div class="editprofile" id="editprofile">
    <div class="notiftext"><div class="proposalcss">Milestone Chart for Project: <?php echo ucwords($project_name);?></div></div>
    <div class="table-responsive">
    <table class="table">
    <thead>
    <tr>
    	<th>Milestone No</th><th>Amount(<?php echo CURRENCY;?>)</th><th>Project</th><th>Date</th><th>Title</th><th>Fund Request</th><th>Payment Request</th>
    </tr>
    </thead>
    <tbody>
    <?php
    
    foreach($set_milestone_list as $key=>$val)
    {
    $project_name=$this->auto_model->getFeild("title","projects","project_id",$val['project_id']);
    ?>
    
    <tr>
    <td><?=$val['milestone_no']?></td>
    <td><?=$val['amount']?></td>
    <td><?=$project_name?></td>
    <td><?=$this->auto_model->date_format($val['mpdate'])?></td>
    <td><?=$val['title']?></td>
    <?php
    if($val['client_approval']=='N'){
    echo "<td>Not Approve</td>";
    echo "<td>Not Approve</td>";
    }
    elseif($val['client_approval']=='Y')
    {
    if($val['fund_release']=='P'){
    ?>
    <td><a href="<?=VPATH?>dashboard/FundRequest/<?php echo $val['id'];?>" style="float:none">Send Request</a></td>
    <?php
    }
    elseif($val['fund_release']=='R'){
    ?>
    <td>Request Pending</td>
    <?php
    }
    elseif($val['fund_release']=='A'){
    
    ?>    
    <td><img alt="Fund Approve" title="Fund Approve" src="<?=IMAGE?>/apply.png" /></td>
    <?php
    }
    if($val['fund_release']!='A')
    {
    ?>
    <td>Fund Not Released</td>
    <?php
    }
    elseif($val['fund_release']=='A')
    {
    if($val['release_payment']=='N')
    {
    ?>
    <td><a href="<?=VPATH?>dashboard/paymentRequest/<?php echo $val['id'];?>" style="float:none">Send Request</a></td>
    <?php	
    }
    elseif($val['release_payment']=='Y')
    {
    ?>
    <td><img alt="Payment Approve" title="Payment Approve" src="<?=IMAGE?>/approved_img.jpg" /></td>
    <?php	
    }
    elseif($val['release_payment']=='C')
    {
    ?>
    <td><img alt="Payment Canceled" title="Payment Canceled" src="<?=IMAGE?>/rejected_img.jpg" /><br/><a href="<?=VPATH?>dashboard/paymentRequest/<?php echo $val['id'];?>" style="float:none">Send Request Again</a></td>
    <?php	
    }
    elseif($val['release_payment']=='D')
    {
    ?>
    <td><a href="<?=VPATH?>disputes/" style="float:none">Payment Disputed</a></td>
    <?php	
    }
    else
    {
    ?>
    <td>Payment Requested</td>
    <?php	
    }	
    }
    }
    ?>
    </tr>
    <?php } ?>
    </tbody>
    </table>
    </div> </div>                     
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
    <div class="addbox2">
    <a href="<?php echo $url;?>" target="_blank"><img src="<?=ASSETS?>ad_image/<?php echo $image;?>" alt="" title="" /></a>
    </div>
    <?php  
    }
    }
    
    ?>
    <div class="clearfix"></div>
    </div>
    <!-- Left Section End -->
    </div>
</div>
</section>
            