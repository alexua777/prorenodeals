<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?= base_url() ?>membership_plan/membership_plan_list">Membership Plan List</a></li>
        <li class="breadcrumb-item active"><a>Add new Skills</a></li>
      </ol>
    </nav>         
    <div class="container-fluid">            

                <?php
                if ($this->session->flashdata('succ_msg')) {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>
                    </div> 
                    <?php
                }
                if ($this->session->flashdata('error_msg')) {
                    ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>
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
                 </form><?php */?>
                
                <?php /*?><table class="table table-hover table-bordered adminmenu_list">
                <tr>
                <td colspan="5" align="right">
                <a href="<?=base_url().'membership_plan/add_membership_plan'?> ">	<input class="btn btn-default" type="button" name="add_membership" value="Add Membership">
                </td>
                </tr>
                </table><?php */?>
                 <div id="prod">
                <table class="table table-hover table-bordered adminmenu_list" id="example1">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Plan Price</th>
                            <th>Plan Icon</th>
                            <th>No. of Project</th>
                            <th>No. of Skills</th>
                            <th>No. of Bids</th>
                            <th>No of Portfolio</th>
                             <th>Bidwin Charge (in %)</th>
                            <th>Days</th>
                            <th id="stt">Status</th>
                            <th id="acc">Action</th>
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
                        

                        //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                        //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');
                        ?>
                        <?php
                        if (count($all_data) > 0) {
                            foreach ($all_data as $key => $val) {
                                ?>

                                <tr>

                                    <td><?= ucwords($val['name']) ?></td>
                                    <td><?= ucwords($val['price']) ?></td>
                                    <td>
                                     <?php
                                        if($val['icon']!='')
                                        {
                                        ?>
                                            <img src="<?php echo SITE_URL;?>assets/plan_icon/<?php echo $val['icon'];?>" width="50" height="50"/><br />
                                        <?php	
                                        }
                                        ?>
                                    </td>
                                    <td><?= $val['project'] ?></td>
                                    <td><?= $val['skills'] ?></td>
                                    <td><?= $val['bids'] ?></td>
                                    <td><?= $val['portfolio'] ?></td>
                                    <td><?= $val['bidwin_charge'] ?></td>
                                    <td><?= $val['days'] ?></td>
                                    <td align="center" id="st">
                                        <?php
                                        if ($val['status'] == 'Y') {
                                            echo anchor(base_url() . 'membership_plan/change_status/' . $val['id'] .'/inact', '&nbsp;', $atr4);
                                        } else {

                                            echo anchor(base_url() . 'membership_plan/change_status/' . $val['id'] . '/act', '&nbsp;', $atr3);
                                        }
                                        ?>




                                    </td>
                                    <td align="center" id="ac">
                                        <?php
                                        if ($val['default_plan'] == 'Y') {
                                            echo anchor(base_url() . 'membership_plan/change_default/' . $val['id'] .'/inact', '&nbsp;', $atr5);
                                        } else {

                                            echo anchor(base_url() . 'membership_plan/change_default/' . $val['id'] . '/act', '&nbsp;', $atr6);
                                        }
                                        ?>                                            
                                        
                                        
                                        
                                        <?php
                                        $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Membership');
                                        echo anchor(base_url() . 'membership_plan/edit_membership/' . $val['id'].'/', '&nbsp;', $atr2);
                                        /*?>echo anchor(base_url() . 'membership_plan/change_status/' . $val['id'] . '/' . 'del/', '&nbsp;', $attr);<?php */
                                        ?>

                                    </td>
                                </tr>



                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="11" align="center">No records found...</td>
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

    </div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
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