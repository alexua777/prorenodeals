<style>
tr.hightlight {
	background-color: #ece8e8;
	border: 2px solid #e45757;
}
</style>
<section id="content">
<div class="wrapper">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>User Support</a> </li>
    </ol>
</nav>
  <div class="container-fluid">
    <?php
                    if ($this->session->flashdata('succ_msg')) {
                        ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong>
      <?= $this->session->flashdata('succ_msg') ?>
    </div>
    <?php
                    }  if ($this->session->flashdata('error_msg')) {  ?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
      <?= $this->session->flashdata('error_msg') ?>
    </div>
    <?php } ?>
    <table class="table table-hover adminmenu_list">
      <thead>
        <tr>
          <th style="text-align:left">Name</th>
          <th>Category</th>
          <th>Message</th>
          <th>Date</th>
          <th>Replied</th>
          <th align="right">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
                               $attr = array(
                                
                                'class' => 'i-cancel-circle-2 red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'i-checkmark-3 red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'i-checkmark-3 green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
        <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { 
								
								?>
        <tr>
          <td><?php echo !empty($val['full_name']) ? $val['full_name'] : 'Unknown User'; ?></td>
          <td><?php echo $val['category']; ?></td>
          <td><?php echo strlen($val['support_message']) > 80 ? substr($val['support_message'], 0, 80).'...' : $val['support_message'] ; ?></td>
          <td><?php echo $val['date']; ?></td>
          <td><?php echo $val['replied'] > 0 ? 'Yes' : 'No'; ?></td>
          <td align="right">
			<a href="<?php echo base_url('user_support/detail/'.$val['id']); ?>" title="Detail">Detail</a>|
			<a href="<?php echo base_url('user_support/delete/'.$val['id']); ?>" title="Delete"><i class="la la-times _165x red"></i></a>
		  </td>
        </tr>
        <?php
                                }
                            } else {
                                ?>
        <tr>
          <td colspan="7" align="center" style="color:#F00">No records found...</td>
        </tr>
        <?php
							}
							?>
      </tbody>
    </table>
    <?php echo $links;?> </div>
  <!-- End .container-fluid  --> 
</div>
<!-- End .wrapper  -->
</section>
