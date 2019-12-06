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
        <li class="breadcrumb-item active"><a>Invoice list</a> </li>
    </ol>
</nav>   
  <div class="container-fluid">
    <form action="">
      <div class="input-group-btn">
        <div class="row">
          <div class="col-sm-5">
            <input type="text" class="form-control" name="invoice_number" placeholder="Invoice number" value="<?php echo !empty($srch['invoice_number']) ? $srch['invoice_number'] : ''; ?>"/>
          </div>
          <div class="col-sm-5">
            <select name="invoice_type" class="form-control">
              <option value="">Choose invoice type</option>
              <?php if(count($invoice_type) > 0){foreach($invoice_type as $k => $v){ ?>
              <option value="<?php echo $v['invoice_type_id']; ?>" <?php echo (!empty($srch['invoice_type']) && $srch['invoice_type'] == $v['invoice_type_id']) ? 'selected="selected"' : ''; ?>><?php echo $v['type']; ?></option>
              <?php } }  ?>
            </select>            
          </div>
          <div class="col-sm-2"><input type="submit" name='submit' id="submit" class="btn btn-primary btn-block" value="SEARCH"></div>
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
    <table class="table table-hover table-bordered adminmenu_list">
      <thead>
        <tr>
          <th># Invoice Id</th>
          <th># Invoice number</th>
          <th>Invoice type</th>
          <th>Date</th>
          <th>From</th>
          <th>To</th>
          <th>Status</th>
          <th>Detail</th>
        </tr>
      </thead>
      <tbody>
        <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) { 
								$is_paid = $is_deleted = $is_pending = 0;
								
								if($val['is_paid'] != '0000-00-00 00:00:00'){
									$is_paid = 1;
								}else if($val['is_deleted'] != '0000-00-00 00:00:00'){
									$is_deleted = 1;
								}else{
									$is_pending = 1;
								}
								
								$from = '';
								$to = '';
								
								if($val['sender_id'] > 0){
									$from = getField('fname', 'user', 'user_id', $val['sender_id']);
									$from .= ' ';
									$from .= getField('lname', 'user', 'user_id', $val['sender_id']);
								}else{
									$from = SITE_TITLE;
								}
								
								if($val['receiver_id'] > 0){
									$to = getField('fname', 'user', 'user_id', $val['receiver_id']);
									$to .= ' ';
									$to .= getField('lname', 'user', 'user_id', $val['receiver_id']);
								}else{
									$to = SITE_TITLE;
								}
								
								$token = md5($val['invoice_id'].'-'.date('Y-m-d').'SE##%!@JK');
								
								?>
        <tr>
          <td><?php echo $val['invoice_id']; ?></td>
          <td><?php echo $val['invoice_number']; ?></td>
          <td><?php echo $val['type']; ?></td>
          <td><?php echo $val['invoice_date']; ?></td>
          <td><?php echo ucwords($from); ?></td>
          <td><?php echo ucwords($to); ?></td>
          <td><?php 
									   
									   if($is_pending == 1){
										   echo '<font color="blue">Pending</font>';
									   }elseif($is_deleted == 1){
										   echo '<font color="red">Deleted</font>';
									   }elseif($is_paid == 1){
										   echo '<font color="green">Paid</font>';
									   }
									   
									   ?></td>
          <td align="center"><a href="<?php echo SITE_URL.'invoice/detail/'.$val['invoice_id'].'?token='.$token; ?>" target="_blank" title="View"><i class="la la-eye _165x"></i></a></td>
        </tr>
        <?php
                                }
                            } else {
                                ?>
        <tr>
          <td colspan="8" align="center" style="color:#F00">No records found...</td>
        </tr>
        <?php
							}
							?>
      </tbody>
    </table>
    <?php echo $links;?> </div>
</div>
</section>
