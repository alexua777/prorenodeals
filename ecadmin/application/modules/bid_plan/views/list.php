<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Bid Plan List</a></li>
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
      <div id="prod">
        <table class="table adminmenu_list" id="example1">
          <thead>
            <tr>
              <th>Plan Name</th>
              <th>Plan Price</th>
              <th>Bids</th>
              <th align="right" id="acc">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
                            $attr = array(
                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                'class' => 'la la-times _165x red',
                                'title' => 'Delete'
                            );
                            $atr3 = array(
                                'onclick' => "javascript: return confirm('Do you want to active this?');",
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Inactive'
                            );
                            $atr4 = array(
                                'onclick' => "javascript: return confirm('Do you want to inactive this?');",
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Active'
                            );
                            
                            $atr5 = array(
                                'onclick' => "javascript: return confirm('Do you want to active this plan as default?');",
                                'class' => 'la la-check-circle _165x red',
                                'title' => 'Default Plan Inactive'
                            );
                            $atr6 = array(
                                'onclick' => "javascript: return confirm('Do you want to inactive this default plan?');",
                                'class' => 'la la-check-circle _165x green',
                                'title' => 'Default Plan Active'
                            );                            
                            
							?>
          
          <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
                                    ?>
          <tr>
            <td><?= ucwords($val['plan_name']) ?></td>
            <td><?= $val['price'] ?></td>
            <td><?= $val['bids'] ?></td>
            <td align="right" id="ac">
			<?php
				$atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Membership');
				echo anchor(base_url() . 'bid_plan/edit/' . $val['id'].'/', '&nbsp;', $atr2);
				echo anchor(base_url() . 'bid_plan/delete_plan/' . $val['id'] , '&nbsp;', $attr);
			?></td>
          </tr>
          <?php
                                }
                            } else {
                                ?>
          <tr>
            <td colspan="7" align="center">No records found...</td>
          </tr>
          <?php
}
?>
          </tbody>
          
        </table>
      </div>
	<?php /* if ($page>30) {?>    
	  <?php echo $links; ?>
	<?php } */ ?>
  
  </div>
  </div>
</section>
<?php /*?><script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script><?php */?>
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

function srch(id)
{
	var elmnt=$('#'+id).val();
	//alert(elmnt);
	var dataString = 'cid='+elmnt;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"<?php echo base_url();?>product/getprod/"+elmnt,
     success:function(return_data)
     {
      	$('#prod').html('');
		$('#prod').html(return_data);
     }
    });
}
</script>