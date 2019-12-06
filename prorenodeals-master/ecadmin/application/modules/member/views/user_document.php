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
	 <table class="table">
		<tr>
			<th>File</th>
			<th>View</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php if(count($documents)){foreach($documents as $k => $v){
		$file_url = SITE_URL.'assets/uploaded/'.$v['file_name'];
		$status = '';
		if($v['status'] == STATUS_PENDING){
			$status = 'Pending';
		}else if($v['status'] == STATUS_APPROVE){
			$status = 'Approved';
		}else if($v['status'] == STATUS_REJECT){
			$status = 'Rejected';
		}
		?>
		<tr>
			<td><?php echo $v['org_file_name'];?></td>
			<td><a href="<?php echo $file_url;?>" target="_blank">View</a></td>
			<td><?php echo $status;?></td>
			<td>
			<?php if($v['status'] == STATUS_PENDING){
				echo '<a href="'.base_url('member/doc_status/?status='.STATUS_APPROVE.'&document_id='.$v['id']).'">Approve</a>';
				echo ' | ';
				echo '<a href="'.base_url('member/doc_status/?status='.STATUS_REJECT.'&document_id='.$v['id']).'">Reject</a>';
			}else{
				echo '-';
			}
			
			?>
			</td>
		</tr>
		<?php } } ?>
	 </table>
	 </div>
	 
	 
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
