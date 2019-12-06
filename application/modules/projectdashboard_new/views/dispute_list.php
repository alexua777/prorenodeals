<style>
.file_list .list-container {
	padding: 10px;
	border: 1px solid #ddd;
}
 .file_list .list-container:not(:first-child) {
 border-top: 0px;
}
.file_list .list-container a.rem {
	float: right;
}
</style>

<section id="mainpage">
<div class="container-fluid">

  <div class="row">
	<?php $this->load->view('dashboard/dashboard-left'); ?>
	<aside class="col-lg-10 col-md-9 col-12">
    <?php echo $breadcrumb; ?>
      <h3>Resolution Center</h3>
      <div class="spacer-20"></div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Project</th>
              <th>Milestone Info</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Reported to admin</th>
			   <th>Status</th>
              <th>Action</th>
			</tr>
          </thead>
          <tbody>
            <?php if(count($dispute_list) > 0){foreach($dispute_list as $k => $v){ ?>
            <tr>
              <td><?php echo $v['project_title'];?></td>
              <td><b>Title : </b><?php echo $v['title'];?></td>
              <td><?php echo $v['add_date']; ?></td>
              <td><?php echo CURRENCY.' '.$v['amount'];?></td>
              <td><?php echo $v['admin_involve'] == '1' ? 'Yes' : 'No';?></td>
              <td><?php echo $v['dispute_settled'] == '1' ? '<font color="green">Settled</font>' : '<font color="red">Not Settled</font>';?></td>
              <td><a href="<?php echo base_url('projectdashboard/dispute_room/'.$v['dispute_id']); ?>">View</a></td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
      <?php echo $links;?>
	</aside>
  </div>
</div>
</section>
