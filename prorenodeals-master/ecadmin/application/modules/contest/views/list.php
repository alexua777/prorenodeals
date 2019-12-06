<style>
.table-danger .la-eye {
	color:#000
}
</style>
<section id="content">
<div class="wrapper">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item active"><a>Contest list</a></li>
    </ol>
  </nav>
  <div class="container-fluid">
    <form action="">
      <div class="input-group-btn">
        <div class="row">
          <div class="col-sm-4">
            <input type="text" class="form-control" name="title" style="margin-right: 6px;"  value="<?php echo !empty($srch['title']) ? $srch['title'] : ''; ?>" placeholder="Title" />
          </div>
          <div class="col-sm-3">
            <select name="status" class="form-control">
              <option value="">Status</option>
              <option value="Y" <?php echo (!empty($srch['status']) && $srch['status'] == 'Y') ? 'selected="selected"' : ''; ?>>Running</option>
              <option value="C" <?php echo (!empty($srch['status']) && $srch['status'] == 'C') ? 'selected="selected"' : ''; ?>>Completed</option>
              <option value="N" <?php echo (!empty($srch['status']) && $srch['status'] == 'N') ? 'selected="selected"' : ''; ?>>Ended</option>
            </select>
          </div>
          <div class="col-sm-3">
            <select name="is_guranteed" class="form-control">
              <option value="">Guaranteed</option>
              <option value="1" <?php echo (isset($srch['is_guranteed']) && $srch['is_guranteed'] == '1') ? 'selected="selected"' : ''; ?>>Yes</option>
              <option value="0" <?php echo (isset($srch['is_guranteed']) && $srch['is_guranteed'] == '0') ? 'selected="selected"' : ''; ?>>No</option>
            </select>
          </div>
          <div class="col-sm-2 text-right">
            <input type="submit" name='submit' id="submit" class="btn btn-primary btn-block" value="SEARCH">
          </div>
        </div>
      </div>
    </form>
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
    <table class="table adminmenu_list">
      <thead>
        <tr>
          <th>Contest Id</th>
          <th>Title</th>
          <th>Amount</th>
          <th>Start</th>
          <th>End</th>
          <th>Status </th>
          <th>Guaranteed </th>
          <th>Entries</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
                               $attr = array(
                                
                                'class' => 'la la-times _165x red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                               
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Active',
								'href'=> 'javascript:;'
                            );
							?>
        <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { 
								$admin_action_needed = false;
								if(($val['status'] == 'N') && ($val['is_guranteed'] == 1)){
								$admin_action_needed = true;
								}	
								?>
        <tr class="<?php echo $admin_action_needed ? 'table-danger' : ''; ?>">
          <td><?php echo !empty($val['contest_id']) ? $val['contest_id'] : '-'; ?></td>
          <td><?php echo !empty($val['title']) ? (strlen($val['title']) > 60 ? substr($val['title'], 0, 60).'...' : $val['title']) : ''; ?></td>
          <td>$<?php echo !empty($val['budget']) ? $val['budget'] : '0.00'; ?></td>
          <td><?php echo !empty($val['posted']) ? $val['posted'] : ''; ?></td>
          <td><?php echo !empty($val['ended']) ? $val['ended'] : ''; ?></td>
          <td align="center">
		  <?php
			$status = '';
			switch($val['status']){
				case 'Y' : 
					$status = '<font color="blue">Running</font>';
				break;
				case 'C' : 
					$status = '<font color="green">Completed</font>';
				break;
				case 'N' : 
					$status = '<font color="red">Ended</font>';
				break;
			}
			echo $status;
			?></td>
          <td align="center"><?php echo (!empty($val['is_guranteed']) &&  $val['is_guranteed'] == 1) ? 'Yes' : 'No'; ?></td>
          <td align="center"><?php echo !empty($val['total_entries']) ? $val['total_entries'] : '0'; ?></td>
          <td><a href="<?php echo base_url('contest/contest_entries/'.$val['contest_id']); ?>" title="View"><i class="la la-eye _165x"></i></a></td>
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
