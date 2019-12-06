<?php // $this->load->library('session');  ?>
<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li> 
		<li class="breadcrumb-item"><a href="<?php echo base_url() . 'meta/add'; ?>">Add Meta Section</a></li>
        <li class="breadcrumb-item active"><a>Meta Section List</a></li>
      </ol>
    </nav> 
        

        <div class="container-fluid">
	        <div class="text-right mb-2"><a href="<?= base_url() ?>meta/add" class="btn btn-primary"><i class="la la-plus"></i> Add Meta Section</a></div>
	
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
                    <table class="table table-hover adminmenu_list">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Pagename</th>
                                <th>Title</th>
                                <th align="center">Status</th>
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


                            if (count($list) != 0) {
                                foreach ($list as $key => $meta) {
                                    ?>

                                    <tr>

                                        <td align="center"><?php echo $meta['id']; ?></td>
                                        <td align="left"><?php echo $meta['pagename']; ?></td>
                                        <td><?php echo $meta['meta_title']; ?></td>
                                        <td align="center"> 
                                            <?php
                                            if ($meta['status'] == 'Y') {
                                                echo anchor(base_url() . 'meta/change_meta_status/' . $meta['id'] . '/inact/' . $meta['status'], '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'meta/change_meta_status/' . $meta['id'] . '/act/' . $meta['status'], '&nbsp;', $atr3);
                                            }
                                            ?>
                                        </td>


                                        <td align="right">
                                            <?php
                                            $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add Meta Section');
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Meta Section');



                                            echo anchor(base_url() . 'meta/edit/' . $meta['id'], '&nbsp;', $atr2);
//echo anchor(base_url().'cms/delete/'.$cms['id'],'&nbsp;',$attr) ; 
                                            ?>
                                        </td>
                                    </tr>

                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" align="center" class="red">
                                        No Records Found
                                    </td>
                                </tr>
    <?php }
?>
                        </tbody>
                    </table>
    

                   <?php echo $links; ?>



        </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
