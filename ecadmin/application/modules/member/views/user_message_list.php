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
                      
						<?php if(count($user_message)>0) {
							$count = 1;
							foreach($user_message as $list){


						?>
						
						<tr>
							<td>Project Name :<?php echo $list['project_title']?></td>
							<td>
							<table>
							<th>Sender Name</th>
							<th>Receiver Name</th>
							<th>Message</th>
							<th>Date</th>
							<?php
							$meassage = $list['message'];
							foreach($meassage as $text){

							?>
							
							<tr>
							<td><?php echo $text['send_to'];?></td>
							<td><?php echo $text['send_from'];?></td>
							<td><?php echo $text['message'];?></td>
							<td><?php echo $text['add_date'];?></td>
							
							</tr>
							
							<?php }?>
							
							</table>
							
							
							</td>
						
						</tr>
						
						
						
						
						
						<?php } 
						
						
						}else{?>
						
						<tr>
						<td colspan="6" style="text-align:center;"> No Message Yet </td>
						
						</tr>
						
						<?php }?>
                    </table>
					
		
				  </div>
				   

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
