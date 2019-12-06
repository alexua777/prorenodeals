<?php $verified = getField('verify', 'user', 'user_id', $user_id);?>
 
        <style>
a.d-block.text-big {    padding: 15px 30px;    display: inline-block !important;    border: 1px solid #ddd;    font-size: 20px;    font-weight: bold;    text-align: center;}
</style>
<section id="mainpage">
<div class="container-fluid">
<div class="row">
<?php $this->load->view('dashboard-left'); ?>
<aside class="col-lg-10 col-md-9 col-12">
<?php echo $breadcrumb; ?>
    <?php if($verified == 'N'){ ?>
    <div id="top_wrapper">
    <div class="alert alert-info"><strong>Info!</strong> Your account is not verified yet. You cannot bid until you verify your account. You must upload the required documents need for verification in order to verify your account.<div>
    <a href="javascript:void(0)" onclick="load_document_uploader()" class="btn btn-success">Click here to upload documents</a></div>
    </div>
    </div>
	<?php } ?>
	
	<?php $succ_msg = get_flash('succ_msg'); $error_msg = get_flash('error_msg'); ?>
      <?php if($succ_msg){ ?>
      <div class="alert alert-success alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> <?php echo $succ_msg; ?> </div>
      <?php } ?>
      <?php if($error_msg){ ?>
      <div class="alert alert-danger alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> <?php echo $error_msg; ?> </div>
      <?php } ?>
    <div class="row">
    <aside class="col-md-6 col-12">
    <div class="well fun-fact">
    	<img src="<?php echo IMAGE;?>icon_project.png" alt="" />
        <h4>Looking for projects?<br />We are here to help You!</h4>
        <a href="<?php echo base_url('findjob');?>" class="btn btn-site">Browse Projects</a>
    </div>
	</aside>
    <aside class="col-md-6 col-12">
	<div class="well fun-fact">
	  <?php $user_sess = $this->session->userdata('user'); $login_user_id = $user_sess[0]->user_id; $u_info = get_row(array('select' => 'account_type,featured,featured_till,featured_last_update,featured', 'from' => 'user', 'where' => array('user_id' => $login_user_id))); if($u_info['featured'] == '1'){			?>
          <div class="alert alert-info" style="display:none"> <strong>Info!</strong> Your profile is upgraded to <span class="label label-success">Featured</span> and is valid till <span class="label label-danger"><?php echo date('d M, Y', strtotime($u_info['featured_till']));?></span> </div>
          <?php } ?>
        
		<img src="<?php echo IMAGE;?>icon_contractors.png" alt="" />  
        <h4>Upgrade your profile to<br />featured to get searched on the top</h4>
        <a href="javascript:void(0)" class="btn btn-site" onclick="$('#toggleView').toggle()">Feature Profile</a>
		
			<div id="toggleView" style="display:none;">
				<h4>Profile Feature Plan</h4>
                  <a data-next="<?php echo base_url('dashboard/feature_profile?type=monthly'); ?>" data-confirm-text="Are you sure to upgrade profile to feature ?" class="d-block text-big" onclick="confirm_first(this)" href="javascript:void(0);">MONTLY
                  <div><small><?php echo CURRENCY.PROFILE_FEATURED_MONTHLY;?></small></div>
                  </a> 
				  <a data-next="<?php echo base_url('dashboard/feature_profile?type=yearly'); ?>" data-confirm-text="Are you sure to upgrade profile to feature ?" class="d-block text-big" onclick="confirm_first(this)" href="javascript:void(0);">YEARLY
                  <div><small><?php echo CURRENCY.PROFILE_FEATURED_YEARLY;?></small></div>
                  </a> 
    	</div>
	</div>
    </aside>
	</div>
		
		  <?php /*?><div class="row" hidden>
			<div class="col-sm-6 text-center">
            <div class="well mb-3">
				<?php
				$available_bids = get_available_bids($user_id);
				$free_bid = get_available_bids($user_id, TRUE);
				$purchase_bid = getField('available_bids', 'user', 'user_id', $user_id);
				?>
				<h4>Available bids : <?php echo $available_bids; ?></h4>
				<h5><i>Free Bid : <?php echo $free_bid; ?></i></h5>
				<h5><i>Purchase Bid : <?php echo $purchase_bid; ?></i></h5>
			</div>
            </div>
			
			<div class="col-sm-6 text-center">
            	<div class="well mb-3">
                    <h4>Add more bid to your account</h4>
                    <a href="<?php echo base_url('dashboard/bid_plan');?>" class="btn btn-site">Buy Bid</a>
                </div>
			</div>
		  </div><?php */?>
	
    <div class="row">
    	<div class="col-sm-4 col-12">
    	<article class="well fun-fact">
        	<img src="<?php echo IMAGE;?>wallet-70x70.png" alt="" />
    		<h4>Earned Amount</h4>
            <h2><?php echo CURRENCY. ' '. format_money($earned_amount, TRUE);?></h2>
    	</article>
        </div>
        <div class="col-sm-4 col-12">
    	<article class="well fun-fact">
        	<img src="<?php echo IMAGE;?>project-70x70.png" alt="" />
    		<h4>Completed Projects</h4>
            <h2><?php echo $total_completed_project; ?></h2>
    	</article>
        </div>
		<div class="col-sm-4 col-12">
    	<article class="well fun-fact">
        	<img src="<?php echo IMAGE;?>ongoing-70x70.png" alt="" />
    		<h4>Ongoing Projects</h4>
            <h2><?php echo $total_ongoing_project; ?></h2>
    	</article>
        </div>
    </div>
	<h3>In Progress Projects</h3>
	<div data-ajaxify="<?php echo base_url('dashboard/myproject_working'); ?>"></div>
    <h3 class="mt-30">Recent Bidded Project</h3>
    <div class="table-responsive mb-30">
        <table class="table table-hover">
        <thead> 
        	<th>Project title</th><th>Posted on</th><th hidden>Hourly/Fixed</th><th>Bid amount</th><th>Status</th>      	        	
        </thead>
        <tbody>
			<?php if(count($recent_bids) > 0){foreach($recent_bids as $k => $v){ 
			$p_status = '';
			$all_bidders = explode(',', $v['all_bidders']);
			/* $href =  base_url('jobdetails/details/'.$v['project_id'].'/'.seo_string($v['title'])); */
			$href =  base_url('job-'.seo_string($v['title']).'-'.$v['project_id']);
			if($v['project_status'] == 'O'){
				
				$p_status = '<span class="badge badge-warning">Pending</span>';
				
			}else{
				
				if($v['project_type'] == 'F'){
					
					
					if(in_array($user_id, $all_bidders)){
						if($v['project_status'] == 'C'){
							$p_status = '<span class="badge badge-success">Completed</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}else if($v['project_status'] == 'CNL'){
							$p_status = '<span class="badge badge-danger">Cancelled</span>';
						}else{
							$p_status = '<span class="badge badge-success">Active</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}
						
					}else if($v['project_status'] == '0'){
						$p_status = '<span class="badge badge-warning">Pending</span>';
					}else{
						$p_status = '<span class="badge badge-warning">Bid Lost</span>';
					}
					
					
				}elseif($v['project_type'] == 'H'){
					$schedulw_row = $this->db->where(array('project_id' => $v['project_id'], 'freelancer_id' => $user_id))->get('project_schedule')->row_array();
					
					if(!empty($schedulw_row)){
						if($schedulw_row['is_contract_end'] == 1){
							$p_status = '<span class="badge badge-danger">Ended</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}else{
							$p_status = '<span class="badge badge-success">Active</span>';
							$href = base_url('projectdashboard_new/freelancer/overview/'.$v['project_id']);
						}
						
					}else{
						$p_status = '<span class="badge badge-warning">Pending</span>';
					}
					
				}
			
			}
			
			
			?>
			
			<tr>
               <td><a href="<?php echo $href; ?>"><?php echo strlen($v['title']) > 90 ? substr($v['title'], 0, 90).'...' : $v['title'];  ?></a></td>
			   <td><?php echo date('d M , Y', strtotime($v['post_date']));?></td>
			   <td hidden><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly';?></td>
			   <td><?php echo CURRENCY.format_money($v['bidder_amt']+$v['admin_fee']); if($v['project_type'] == 'H'){ echo ' /hr'; } ?></td>
			   <td><?php echo $p_status; ?> </td>
            </tr> 
			
			<?php } }else{ ?>
			<tr>
				<td colspan="10" style="text-align:center;">No records found</td>
			</tr>
			<?php  } ?>
       
        </tbody>
        </table>
	</div>
	<h3>Financial Information</h3>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">In Progress</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Completed</a>
      </li>     
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="table-responsive mb-30">
		<table class="table table-middle table-hover">
		  <thead> 
			<tr>
				<th style="min-width:200px">Profile</th>
                <th>#Project ID</th>
				<th>Project</th>
				<th>Total Project Cost(<?php echo CURRENCY; ?>)</th>
				<th>Total Earned Amount(<?php echo CURRENCY; ?>)</th>
				<th>Total Pending Amount (<?php echo CURRENCY; ?>)</th>
			</tr>

			</thead>
			<tbody>

				<?php if(count($inprogress_project) > 0){foreach($inprogress_project as $k => $v){ ?>

				<tr>
					<td><a href="<?php echo $v['profile_url']; ?>"><img src="<?php echo get_user_logo($v['user_id']);?>" alt="" height="36" width="36" class="rounded-circle mr-2" /> <?php echo !empty($v['fname']) ? $v['fname'].' '.$v['lname'] : 'Unknown';?></a></td>
                    <td hidden><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>
                    <td><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></td>

					<td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>

					<td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>
					<td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>
					<td style="color:green;"><?php echo number_format(($v['total_credit']-$v['total_debit']), 2); ?></td>

				</tr>

				<?php } }else{  ?>

				<tr>

					<td colspan="10" style="text-align:center;">No records found</td>

				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="table-responsive mb-30">
		<table class="table table-middle">
		  <thead> 
			<tr>
				<th>Profile</th>
                <th>#Project ID</th>
				<th>Project</th>
				<th>Total Project Cost(<?php echo CURRENCY; ?>)</th>
				<th>Total Earned Amount(<?php echo CURRENCY; ?>)</th>
				<th>Total Pending Amount (<?php echo CURRENCY; ?>)</th>
			</tr>

			</thead>
			<tbody>

				<?php if(count($completed_project) > 0){foreach($completed_project as $k => $v){ ?>

				<tr>
					<td><a href="<?php echo $v['profile_url']; ?>"><img src="<?php echo get_user_logo($v['user_id']);?>" alt="" height="36" width="36" class="rounded-circle mr-2" /> <?php echo !empty($v['fname']) ? $v['fname'].' '.$v['lname'] : 'Unknown';?></a></td>
                    <td hidden><a href="<?php echo base_url('myfinance/project_all_transaction/'.$v['project_id'])?>"><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></a></td>
                    <td><?php echo !empty($v['project_id']) ? '#'.$v['project_id'] : ''; ?></td>

					<td><?php echo !empty($v['title']) ? (strlen($v['title']) > 60 ? substr($v['title'], 0, 60).'...' : $v['title']) : ''; ?></td>

					<td style="color:green;"><?php echo !empty($v['total_credit']) ? $v['total_credit'] : ''; ?></td>
					<td style="color:red;"><?php echo !empty($v['total_debit']) ? $v['total_debit'] : ''; ?></td>
					<td style="color:green;"><?php echo number_format(($v['total_credit']-$v['total_debit']), 2); ?></td>

				</tr>

				<?php } }else{  ?>

				<tr>

					<td colspan="10" style="text-align:center;">No records found</td>

				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
      </div>
    </div>
    
</aside>
</div>
</div>
</section>
<script>function load_document_uploader(){	
$.get('<?php echo base_url('dashboard/load_ajax?page=user_document'); ?>', function(res){		
$('#top_wrapper').html(res);	
});
}



</script>







