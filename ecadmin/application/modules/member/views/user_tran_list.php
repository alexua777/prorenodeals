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
								paypal_transaction_id
								
								</th>
								<th style="text-align:left;">
								
								Amount
								</th>
								<th style="text-align:left;">
								Transaction Type
								</th>
								<th style="text-align:left;">
								Transaction For
								</th> 
								
								<th style="text-align:left;">
								
								
								Date
								
								</th>
								
							</tr>
						</thead>
						
						<?php if(count($user_trans)>0) {
							$count = 1;
							foreach($user_trans as $list){


						?>
						
						<tr>
							<td style="text-align:left;"><?php echo $count++;?></td>
							<td style="text-align:left;"><?php echo $list['paypal_transaction_id']?></td>
							<td style="text-align:left;"><?php echo $list['amount']; ?></td>
							<td style="text-align:left;"><?php echo $list['transction_type'];?></td>
							<td style="text-align:left;"><?php echo $list['transaction_for'];?></td>
							<td style="text-align:left;"><?php echo $list['transction_date'];?></td>
						
						
						
						</tr>
						
						
						
						<?php } 
						
						
						}else{?>
						
						<tr>
						<td colspan="6" style="text-align:center;"> No Transaction Yet </td>
						
						</tr>
						
						<?php }?>
                    </table>
					
		
				  </div>
				   

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
