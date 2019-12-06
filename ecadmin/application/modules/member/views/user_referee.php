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
                    <?php $this->load->view('top_nav');?>
						
                  <div class="panel-body">
				   
					 <table class="table table-hover table-bordered adminmenu_list" id="example1">
                        <thead>
                           <tr>
								<th>Name</th>
								<th>Company Name</th>
								<th>Email</th>
								<th>Phone No</th>
								<th>Date</th> 
								<th>Rating</th>
                                <th>Status</th>
								
							</tr>
						</thead>
						
						<?php 
						
                            $attr = array(
                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                'onclick' => "javascript: return confirm('Do you want to active this?');",
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                                'onclick' => "javascript: return confirm('Do you want to inactive this?');",
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active'
                            );

						
						if(count($user_trans)>0) {
							$count = 1;
							foreach($user_trans as $list){


						?>
						
						<tr>
							<td><?php echo $list['name']?></td>
							<td><?php echo $list['company']?></td>
							<td><?php echo $list['email']; ?></td>
							<td><?php echo $list['phone_no'];?></td>
							<td><?php echo date('M d, Y',strtotime($list['add_date']));?></td>
							<td><?php if($list['rating_status']=='Y'){ ?><a href="javascript:void(0)" onclick="hds('<?php echo $list['id'];?>');" data-reveal-id="exampleModal"> <?php echo "Feedback Given";?> </a><?php }else {?> <?php echo "No feedback given yet.";}?></td>
							
                            <td>
							<?php if($list['rating_status']=='Y' && $list['admin_review']=='Y'){
								echo anchor(base_url() . 'member/change_review_status/' . $list['id'] .'/inact/'.$user_details['user_id'], '&nbsp;', $atr4);
								}
								elseif($list['rating_status']=='Y' && $list['admin_review']=='N') 
								{
                                   echo anchor(base_url() . 'member/change_review_status/' . $list['id'] . '/act/'.$user_details['user_id'], '&nbsp;', $atr3);
                                 }
								 else
								 {
									echo "--------";	 
								}
								?></td>
						
						
						</tr>
						
						
						
						<?php } 
						
						
						}else{?>
						
						<tr>
						<td colspan="7" style="text-align:center;"> No References Yet </td>
						
						</tr>
						
						<?php }?>
                    </table>
					
		
				  </div>
				   
			
            <div id="exampleModal" class="reveal-modal" style="width:70%;margin-left: -35%;" >
            <h3> Rating of <?php echo $user_details['fname'];?></h3>
  					<div class="editprofile" style="padding-bottom: 14px;padding-top: 14px;">
                    	<div id="id2"></div>
                        </div>
  						<a class="close-reveal-modal">&#215;</a>
                    </div>
         </div>
         <!-- Content End -->
 </div>
<script src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/app.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script>
            
            
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
function hds(id)
{
	var dataString="user="+<?php echo $user_details['user_id'];?>+"refer="+id;
	$.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>member/viewfeedback/"+<?php echo $user_details['user_id'];?>+"/"+id,
     success:function(return_data)
     {
	 	
      	$('#id2').html('');
		$('#id2').html(return_data);
     }
    });
		
}
</script>