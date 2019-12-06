<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active">Testimonial List</a></li>
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
        

        <table class="table table-hover table-bordered adminmenu_list">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Description</th>
                    <th style="width:120px">Posted Date</th>
                    <th align="center">Status</th>
                    <th align="right" style="width:90px">Action</th>
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
                        $fname=$this->auto_model->getFeild('fname','user','user_id',$val['user_id']);
                        $lname=$this->auto_model->getFeild('lname','user','user_id',$val['user_id']);
                        ?>

                        <tr>

                            <td><?= $val['id'] ?></td>
                            <td><?= ucwords($fname." ".$lname) ?></td>
                            <td><?php echo ucwords($val['description']);?></td>
                             <td><?php echo date('d-M-Y',strtotime($val['posted_date']));?></td>
                            <td align="center">
                                <?php
                                if ($val['status'] == 'Y') {
                                    echo anchor(base_url() . 'testimonial/change_status/' . $val['id'] .'/inact', '&nbsp;', $atr4);
                                } else {

                                    echo anchor(base_url() . 'testimonial/change_status/' . $val['id'] . '/act', '&nbsp;', $atr3);
                                }
                                ?>




                            </td>
                            <td align="right">
                                <?php
                               $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit');
                                echo anchor(base_url() . 'testimonial/edit/' . $val['id'], '&nbsp;', $atr2);
                                echo anchor(base_url() . 'testimonial/change_status/' . $val['id'] . '/' . 'del/', '&nbsp;', $attr);
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
        <?php /* if ($page>30) {?>    

          <div class="pagin"><p>Page:</p><a class="active"><?php echo $links; ?></a></div>
          <?php } */ ?>
    

        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
