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
				   
					 <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                           <tr>
								<th style="text-align:left;">
								
								
								Index(#)
								
								
								</th>
								<th style="text-align:left;">
								Job Title
								
								</th>
								<th style="text-align:left;">
								
								Bid Details
								</th>
								<th style="text-align:left;">
								Bidder Amount
								</th>
								<th style="text-align:left;">
								Total Amount
								</th> 
								
								<th style="text-align:left;">
								
								
								Day Require
								
								</th>
								
							</tr>
						</thead>
						
						<?php if(count($user_applyed)>0) {
							$count = 1;
							foreach($user_applyed as $list){


						?>
						
						<tr>
							<td style="text-align:left;"><?php echo $count++;?></td>
							<td style="text-align:left;"><?php echo $list['job_details']['title']?></td>
							<td style="text-align:left;"><?php echo $list['details']; ?></td>
							<td style="text-align:left;"><?php echo $list['bidder_amt'];?></td>
							<td style="text-align:left;"><?php echo $list['total_amt'];?></td>
							<td style="text-align:left;"><?php echo $list['days_required'];?></td>
						
						
						
						</tr>
						
						
						
						<?php } 
						
						
						}else{?>
						
						<tr>
						<td colspan="6" style="text-align:center;"> No Application Yet </td>
						
						</tr>
						
						<?php }?>
                    </table>
					
		
				  </div>
				   
               

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
