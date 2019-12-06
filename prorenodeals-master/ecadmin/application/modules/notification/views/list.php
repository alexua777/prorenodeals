<?php // $this->load->library('session');  ?>
<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
			<li class="breadcrumb-item active">Notification List</li>
			<?php /*?><li class="active"><a onclick="redirect_to('<?php echo base_url() . 'news/add'; ?>');">Add News/Article</a></li><?php */?>
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
                    
                    <table id="example2" class="table responsive table-bordered" cellspacing="0" width="100%">
						<thead><tr><th>Project Name</th><th>Employeer Name</th><th>Freelancer Name</th><th>Project Type</th><th>Amount</th><th colspan="2">Date</th></tr>
						</thead>
						<tbody>
						<?php
						if(count($invitation)>0) { foreach($invitation as $k=>$v){ 
						
						$this->db->select('fname,lname');
						$this->db->where('user_id',$v['employer_id']);
						$employer_uname = $this->db->get('user')->row_array();
						
						$this->db->select('fname,lname');
						$this->db->where('user_id',$v['freelancer_id']);
						$freelencer_uname = $this->db->get('user')->row_array();
						
						//$employer_uname = getField('username','user','user_id',$v['employer_id']);
						//$freelencer_uname = getField('username','user','user_id',$v['freelancer_id']);
						?>
						<tr>
							<td><a href="#<?php // echo base_url('jobdetails/details/'.$v['project_id']); ?>"><?php echo $v['title']; ?></a></td>
							<td><?php echo $employer_uname['fname'].' '.$employer_uname['lname']; ?></td>
							<td><?php echo $freelencer_uname['fname'].' '.$freelencer_uname['lname']; ?></td>
							<td><?php echo $v['project_type'] == 'F' ? 'Fixed' : 'Hourly'; ?></td>
							<td><?php echo $v['invitation_amount'] != '0' ? CURRENCY. $v['invitation_amount'] : '--'; ?></td>
							<td><?php echo $v['date']; ?></td>
							<td><a href="#"  data-toggle="modal" data-target="#msgModal"  data-message="<?php echo $v['message']; ?>" onclick="viewMsg(this);"><i class="la la-envelope _165x"></i> </a></td>
						</tr>
						<?php } } ?>	
						</tbody>
					</table>
					<?php echo $links; ?>
					
					
               
		<!--  ------------------------Message Modal Starts-------------------------->			
			<div id="msgModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
                    <h5 class="modal-title">Message</h5>
					<button type="button" class="close" data-dismiss="modal" onclick="$('#msgModal').modal('hide');">&times;</button>                    
				  </div>
				  <div class="modal-body">
				  
				  </div>				  
				</div>

			  </div>
			</div>                       
          

<script src="<?php echo SITE_URL;?>assets/js/app.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script>	
        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
function hdd()
{
	var matches = [];
	$(".mailcheck:checked").each(function() {
   	 	matches.push(this.value);
	});
	if(matches=='')
	{
		$('#id2').html("");
		$('#id2').html("You haven't select anyone to send mail!");	
	}
	else
	{
		var dataString="user="+matches;
		$.ajax({
		 type:"POST",
		 data:dataString,
		 url:"<?php echo base_url();?>invite/getMail/"+matches,
		 success:function(return_data)
		 {
			
			$('#to').html('');
			$('#to').html(return_data);
		 }
		});	
	}	
}
function viewMsg(e){
	var msg = $(e).data('message');
	$('#msgModal').find('.modal-body').html(msg);
}
</script>