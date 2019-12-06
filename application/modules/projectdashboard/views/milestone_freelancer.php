<?php $this->load->view('section-top');?>
<section class="sec dashboard">
  <div class="container">
    <?php $this->load->view('tab');?>
     <div class="tab-content" style="margin:10px 0 0; padding:0; border:none">
      <div role="tabpanel" class="tab-pane active">
        <!-- working area -->
			<table class="table">
			<thead>
			<tr>
				<th>Milestone No</th><th>Amount(<?php echo CURRENCY;?>)</th><th>Project</th><th>Date</th><th>Title</th><th>Payment Request</th>
			</tr>
			</thead>
			<tbody>
			<?php
			
			foreach($set_milestone_list as $key=>$val)
			{
			$is_escrowed = 0;
			$escrow_row = $this->db->where('milestone_id', $val['id'])->get('escrow_new')->row_array();
			if(!empty($escrow_row)){
				$is_escrowed = 1;
			}
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
			<td><a href="<?=VPATH?>dashboard/FundRequest/<?php echo $val['id'];?>?next=projectdashboard/milestone_freelancer/<?php echo $val['project_id']; ?>" style="float:none">Send Invoice</a></td>
			<?php
			}
			elseif($val['fund_release']=='R' && $val['release_payment'] == 'R'){
			?>
			<td>Unpaid | <a href="<?php echo base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F')?>">Invoice</a>
			<?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
			Disputed | <a href="#">View</a>
			<?php } ?>
			</td>
			<?php
			}else if($val['fund_release']=='R' && $val['release_payment'] == 'D'){ ?>
			
			<td>
			<?php if(($is_escrowed == 1 ) && ($escrow_row['status'] == 'D')){ ?>
				Disputed | <a href="<?php echo base_url('projectdashboard/dispute_room/'.$val['id'].'/'.$val['project_id']); ?>">View</a>
			<?php } ?>
			</td>
			
			<?php
				
			}elseif($val['fund_release']=='A'){
			
			?>    
			<td><i class="zmdi zmdi-check-circle zmdi-hc-2x green-text" title="Fund Approve"></i> | <a href="<?php echo base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F')?>" target="_blank">Invoice</a></td>
			<?php
			}else if($val['release_payment']=='C'){
				echo '<td>Cancelled <a href="'.VPATH.'dashboard/FundRequest/'.$val['id'].'?next=projectdashboard/milestone_freelancer/'.$val['project_id'].'">Resend</a> | <a href="'.base_url('/dashboard/invoice/'.$val['invoice_id'].'/'.'F').'" target="_blank">Invoice</a></td>';
			}
			
			}
			?>
			</tr>
			<?php } ?>
			</tbody>
			</table>
			
		
        <!-- working area -->
      </div>
    </div>
  </div>
</section>


<style>
.tab-content {
	margin-top:10px;
	padding: 0;
	border:none;
}
.zmdi-hc-2x {
    font-size: 20px;
}
ul.list-group {
	box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
}
ul.list-group li:last-of-type {
    border-bottom: none;
}
.magic-radio + label:before, .magic-checkbox + label:before {
	width: 18px;
    height: 18px;
}
.magic-radio + label:after {
    width: 8px;
    height: 8px;
}
</style>
