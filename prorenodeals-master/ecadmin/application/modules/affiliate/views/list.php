<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <div class="crumb">
      <ul class="breadcrumb">
        <li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
        <li class="active">Affiliate User List</li>
        <!--<li class="active"><a onclick="redirect_to('<?php echo base_url() . 'news/add'; ?>');">Add News/Article</a></li>-->
      </ul>
    </div>
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
                         }
						if ($this->session->flashdata('error_msg')) {
							?>
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong>
        <?= $this->session->flashdata('error_msg') ?>
      </div>
      <?php
						}
						?>
      <table class="table table-hover table-bordered adminmenu_list">
        <thead>
          <tr>
            <th style="text-align:left;">Id</th>
            <th>User Id</th>
            <th>User Name</th>
            <th>Affiliated By</th>
            <th>Affiliate Id</th>
            <th>Reg Date</th>
            <th>Stats</th>
            <th>IP</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
					);
					$atr3 = array(
						'onclick' => "javascript: return confirm('Do you want to active this?');",
						'class' => 'i-checkmark-3 red',
						'title' => 'Inactive'
					);
					$atr4 = array(
						'onclick' => "javascript: return confirm('Do you want to inactive this?');",
						'class' => 'i-checkmark-3 green',
						'title' => 'Active'
					);
					
		if(count($list)!=0){
		foreach ($list as $key => $con) {
				
				?>
          <tr>
            <td><?php echo $con['id']; ?></td>
            <td><?php echo $con['user_id']; ?></td>
            <td><?php echo $con['name']."<br>(".$con['email'].")"; ?></td>
            <td align="center"><?php echo $con['affliliate_by']; ?></td>
            <td align="center"><?php echo $con['affliliate_id']; ?><br /></td>
            <td align="center"><?php echo $con['add_date']; ?></td>
            <td align="center"><?php
                                            if ($con['status'] == 'Y') {
                                                echo anchor(base_url() . 'affiliate/change_status/' . $con['id'] .'/inact', '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'affiliate/change_status/' . $con['id'] . '/act', '&nbsp;', $atr3);
                                            }
                                            ?></td>
            <td align="center"><?php echo $con['ip'];?></td>
            <td align="center"><?php echo anchor(base_url() . 'affiliate/delete/' . $con['id'], '&nbsp;', $attr);?></td>
          </tr>
          <?php }
	}else{
	
 ?>
          <tr>
            <td colspan="6" align="center" class="red">Records Not Found</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php if ($links) {?>
      <?php echo $links; ?>
      <?php }?>
      <script src="<?php echo SITE_URL;?>assets/js/app.js"></script> 
      <script src="<?php echo SITE_URL;?>assets/js/jquery.reveal.js"></script> 
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
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
</script>