<section id="content">
    <div class="wrapper">        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
            <li class="breadcrumb-item active"><a>User List</a></li>
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
                                <th>Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
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
							$atr9 = array(
                                'onclick' => "javascript: return confirm('Do you want to change pasword?');",
                                'class' => 'la la-key _165x green',
                                'title' => 'Change password'
                            );

                            //$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');

                            if (count($all_data) > 0) {
                                foreach ($all_data as $key => $val) {
									$type=$this->auto_model->getFeild('name','adminuser_type','id',$val['type']);
                                    ?>

                                    <tr> 	

                                        <td><?= $val['admin_id'] ?></td>
                                        <td><?= $val['username'] ?></td>
                                        <td><?= $val['email'] ?></td>
                                        <td><?= $type ?></td>
                                        <td align="center">
                                            <?php
                                            if ($val['status'] == 'Y') {
                                                echo anchor(base_url() . 'adminuser/change_status/' . $val['admin_id'] .'/inact', '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'adminuser/change_status/' . $val['admin_id'] . '/act', '&nbsp;', $atr3);
                                            }
                                            ?>




                                        </td>
                                        <td align="center">
                                            <?php
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit user');
                                            echo anchor(base_url() . 'adminuser/edit_user/' . $val['admin_id'].'/', '&nbsp;', $atr2);
                                            echo anchor(base_url() . 'adminuser/change_status/' . $val['admin_id'] . '/' . 'del/', '&nbsp;', $attr);
											echo anchor(base_url() . 'settings/pass_edit/' . $val['admin_id'] . '/', '&nbsp;', $atr9);
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
	window.location.href='<?php echo base_url();?>knowledge/search_knowledge/'+elmnt+'/';		
}
</script>