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
        <li class="breadcrumb-item active"><a>Abuse Project Report</a> </li>
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
          <th style="text-align:left">#PROJECT ID</th>
          <th>Title</th>
          <th>Date</th>
          <th>Posted By</th>
          <th>Abuse Count</th>
          <th align="right">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
                               $attr = array(
                                
                                'class' => 'la la-times _165x red',
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
          <td><?php echo !empty($val['project_id']) ? $val['project_id'] : '-'; ?></td>
          <td><?php echo !empty($val['title']) ? $val['title'] : '-'; ?></td>
          <td><?php echo !empty($val['post_date']) ? $val['post_date'] : '-'; ?></td>
          <td><?php echo !empty($val['username']) ? $val['username'] : '-'; ?></td>
		   <td><?php echo $val['abuse']; ?></td>
          
          <td align="right">
		  <?php
		  $next = 'report_abuse/list_all_project';
		  if($val['status']=='O' || $val['status']=='E'){

			  echo anchor(base_url() . 'project/change_status/'. $val['status'].'/' . $val['p_id'] . '/' . 'del'.'?next='.$next, '&nbsp;', $attr);

		  }
		  if ($val['projectstatus'] == 'Y') {

				echo anchor(base_url() . 'project/change_project_status/' . $val['p_id'].'/inact/'.$val['projectstatus'].'?next='.$next, '&nbsp;', $atr4);

			

				} else {

			

				echo anchor(base_url() . 'project/change_project_status/' . $val['p_id'].'/act/'.$val['projectstatus'].'?next='.$next, '&nbsp;', $atr3);

				}
		  ?>
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
