<link rel="stylesheet" href="<?=JS?>jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?=JS?>jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=JS?>jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
		
		});
	});
	</script>
<section id="content">
<div class="wrapper">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item active"><a>Wallet List</a></li>
    </ol>
  </nav>
  <div class="container-fluid">
    <?php
				if($this->session->flashdata('succ_msg')){
				?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
    <?php
				}
				if($this->session->flashdata('error_msg')){
				
				?>
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
    <?php
				}
				?>
    <form action="">
		<div class="input-group mb-3">
          <input type="text" class="form-control" name="wallet_id" placeholder="Wallet ID"  value="<?php echo !empty($srch['wallet_id']) ? $srch['wallet_id'] : ''; ?>"/>
          <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo !empty($srch['title']) ? $srch['title'] : ''; ?>"/>
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit" name='submit' id="submit">Search</button>
          </div>
        </div>
    </form>
    <div id="prod">
      <table class="table table-hover adminmenu_list" id="example1">
        <thead>
          <tr>
            <th>Wallet ID #</th>
            <th>User</th>
            <th>Title</th>
            <th>Balance</th>
            <th align="right">Detail</th>
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
                                foreach ($all_data as $key => $val) { ?>
        <tr>
          <td><?php echo !empty($val['wallet_id']) ? $val['wallet_id'] : '-'; ?></td>
          <td><?php echo !empty($val['full_name']) ? $val['full_name'] : '-'; ?></td>
          <td><?php echo !empty($val['title']) ? $val['title'] : 'no title'; ?></td>
          <td>$ <?php echo !empty($val['balance']) ? $val['balance'] : '-'; ?></td>
          <td align="right"><a href="<?php echo base_url('fund/wallet_txn_detail/'.$val['wallet_id']); ?>" title="Detail"><i class="la la-eye _165x"></i></a></td>
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
      <?php echo $links;?>
   </div>
</div>
<!-- End .container-fluid  -->
</div>
<!-- End .wrapper  -->
</section>
<style>
  @media print {
  body * {
    visibility: hidden;
  }
  #st{ display: none;}
  #ac{ display: none;}
  #stt{ display: none;}
  #acc{ display: none;}
  #example1_length{ display: none;}
  #example1_filter{ display: none;}
  .pagination{ display: none;}
  .crumb{ display: none;}
  #sidebar{ display: none;}
  #prod * {
    visibility: visible;
  }
  #prod {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<script>
function prnt()
{
  window.print();
}


</script> 
<script>
function handle_txn(txn_id, cmd){
	if(txn_id && cmd){
		$.ajax({
			url : '<?php echo base_url('fund/status_txn_new');?>',
			data: {txn_id: txn_id, cmd: cmd},
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				if(res.status == 1){
					location.reload();
				}
			}
		});
	}
}
</script>