<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        
        <li class="breadcrumb-item active"><a>Faq List</a></li>
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
					<div class="row">
                        <div class="col-md-6">
                        <label class="col-form-label">Keyword:</label>
                        <div class="input-group mb-3">
                          <input type="text" class="form-control searchfield" placeholder="Enter FAQ question ..." name="search_element" id="srch">
                          <div class="input-group-append">
                            <button type="submit" name='submit' id="submit" class="btn btn-primary" onclick="hdd();">SEARCH</button>
                          </div>
                        </div>            		                    
                        </div>
                        <div class="col-md-6">
                        <label class="col-form-label">Serach By:</label>
                        <select class="form-control" id="slct" onchange="srch()">
                        <option value="">Please Choose Category</option>
                        <?php
                        foreach($category as $key=>$val)
                        {
                        ?>
                        <option value="<?php echo $val['id']?>" <?php if($cat && $cat==$val['id']){echo "selected";}?>><?php echo $val['name'];?></option>
                        <?php	
                        }
                        ?>
                        </select>
                        </div>
                    </div>
                    
                    
                    <table class="table table-hover table-bordered adminmenu_list">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th align="right">Action</th>
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

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');

                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
                                    ?>

                                    <tr> 	

                                        <td><?= $val['id'] ?></td>
                                        <td><?= ucwords($val['question']) ?></td>
                                        <td><?= html_entity_decode($val['answers']) ?></td>
                                        <td><?= $val['order'] ?></td>
                                        <td align="center">
                                            <?php
                                            if ($val['status'] == 'Y') {
                                                echo anchor(base_url() . 'faq/change_status/' . $val['id'] .'/inact', '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'faq/change_status/' . $val['id'] . '/act', '&nbsp;', $atr3);
                                            }
                                            ?>




                                        </td>
                                        <td align="right">
                                            <?php
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit FAQ');
                                            echo anchor(base_url() . 'faq/edit_faq/' . $val['id'].'/', '&nbsp;', $atr2);
                                            echo anchor(base_url() . 'faq/change_status/' . $val['id'] . '/' . 'del/', '&nbsp;', $attr);
                                            ?>

                                        </td>
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
                    <?php echo $links; ?>                

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
<script>
function hdd()
{
	var elmnt=$('#srch').val();
	window.location.href='<?php echo base_url();?>faq/search_faq/'+elmnt+'/';		
}
function srch()
{
	var cid=$('#slct').val();
	window.location.href='<?php echo base_url();?>faq/faq_cat/'+cid+'/';	
}
</script>