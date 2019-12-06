<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>project/">Bids Management</a></li>
        <li class="breadcrumb-item active"><a>Bids List</a></li>
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
      <?php /*?><form action="<?= base_url() ?>footer/search_parent_footers/0" method="post">
                         <table class="table table-hover table-bordered adminmenu_list" style="height: 15px; padding: 0;">
                        <tr>
                            <td>
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td style="width: 45%;">
                                         <select id="usr_select" name="usr_select"  class="select2 select_country required  form-control">
                        <option value="">--- Search By ---</option>
                        <option value="all" <?php if (isset($usr_select)) {
                if ($usr_select == 'all') echo "selected";
            } ?> >All</option>
                        <option value="Product name" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_id') echo "selected";
            } ?> >Footer Id</option>
                        <option value="footer_cat_name" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_cat_name') echo "selected";
            } ?>>Footer Category Name</option>
                        <option value="footer_link" <?php if (isset($usr_select)) {
                if ($usr_select == 'footer_link') echo "selected";
            } ?>>Footer Link</option>
                    </select>   
                                        </td>
                                        <td>
                                <input type="text" placeholder="Enter search element ..." class="searchfield " name="search_element" size="30" value="<?php if (isset($search_element)) {
                echo $search_element;
            } ?>">
                            </td>
                            <td>
                                <input type="submit" name='submit' id="submit" class="btn btn-default" value="SEARCH">
                            </td>
                                    </tr>
                                </table>
                                
                            </td>
                            
                            <td align="right" style="width: 10%;">
                                <table>
                                    <tr>
                                        <td>
                                   <a href="<?= base_url() ?>footer/add_parent_footer">	<input class="btn btn-default" type="button" value="Add Parent Footer"></a>         
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>
                        </tr>
                    </table>
                     </form>
					
                    <table class="table table-hover table-bordered adminmenu_list">
                    <tr>
                    <td colspan="5" align="right">
                    <a href="<?=base_url().'membership_plan/add_membership_plan'?>">	<input class="btn btn-default" type="button" name="add_membership" value="Add Membership"></a>
                    </td>
                    </tr>
                    </table><?php */?>
      <div id="prod">
        <table class="table table-hover table-bordered adminmenu_list" id="example1">
          <thead>
            <tr>
              <th>Id</th>
              <th>Bidder</th>
              <th>Details</th>
              <th align="center">Bid Amount</th>
              <th align="center">Total Amount</th>
              <th align="center">Bid Days</th>
              <th align="center">Date</th>
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
                                'class' => 'la la-gavel _165x green',
                                'title' => 'Bid List'
                            );

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
							?>
            <?php
                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
                                    $username=$this->auto_model->getFeild('username','user','user_id',$val['bidder_id']);
									?>
            <tr>
              <td><?php echo $val['id'];?></td>
              <td ><?php echo $username;?></td>
              <td><?php echo $val['details'] ;?></td>
              <td align="center"><?php if($val['bidder_amt']!= 0 && $val['bidder_amt']!='')
									    echo '$'.$val['bidder_amt'] ;?></td>
              <td align="center"><?php 
										if($val['total_amt']!= 0 && $val['total_amt']!='') 
										echo '$'.$val['total_amt'] ;?></td>
              <td align="center"><?php if($val['days_required']!=0)
										echo $val['days_required']." Days" ;?></td>
              <td align="center"><?php echo date('d-M-Y',strtotime($val['add_date'])) ;?></td>
            </tr>
            <?php
                                }
                           } else {
                                ?>
            <tr>
              <td colspan="7" align="center" style="color:#F00;">No records found...</td>
            </tr>
            <?php
                    }
                    ?>
          </tbody>
        </table>
      </div>
      <?php /* if ($page>30) {?>    

                      <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
                      <?php } */ ?>
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
