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
        <li class="breadcrumb-item active"><a>Abuse User Report</a> </li>
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
          <th style="text-align:left">#ID</th>
          <th>Logo</th>
          <th>Username</th>
          <th>Name</th>
		  <th>Abuse Count</th>
          <th>User Type</th>
          
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
								$logo = 'assets/images/face_icon.gif';
								if(!empty($val['logo'])){
									$logo = 'assets/uploaded/'.$val['logo'];
								}
								
								
								?>
        <tr>
          <td><?php echo !empty($val['user_id']) ? $val['user_id'] : '-'; ?></td>
          <td><img src="<?php echo SITE_URL.$logo;?>" height="48" width="48" /></td>
          <td><?php echo !empty($val['username']) ? $val['username'] : ''; ?></td>
          <td><?php echo $val['fname'].' '.$val['lname']; ?></td>
          <td><?php echo $val['abuse']; ?></td>
          <td>
			<?php 
				
				if($val['account_type'] == 'F'){
					echo 'Contractor';
				}else if($val['account_type'] == 'E'){
					echo 'Customer';
				}
			?>
		  
		  </td>
          
          <td align="right">
		 <?php
				$next = 'report_abuse/list_all_user';
				if ($val['verify'] == 'Y')

				{

					echo anchor(base_url() . 'member/change_status/' . $val['user_id'].'/inapp_veryify/'.$val['verify'].'?next='.$next, '&nbsp;', $atr4);

				}

				else

				{

					echo anchor(base_url() . 'member/change_status/' . $val['user_id'].'/app_veryify/'.$val['verify'].'?next='.$next, '&nbsp;', $atr3);

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
