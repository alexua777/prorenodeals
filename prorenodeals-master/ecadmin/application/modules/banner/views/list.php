<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>        
        <li class="breadcrumb-item active"><a>Banner Image List</a></li>
      </ol>
    </nav>    

    <div class="container-fluid">           
                <div class="text-right mb-2"><a href="<?= base_url() ?>banner/add" class="btn btn-primary">Add banner</a></div>		

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
                            <th>Banner Title</th>
                            <th>Banner Image</th>
                            <th>Display For</th>
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

                        if (count($all_data) != 0) {
                            foreach ($all_data as $key => $ban) {
                                // print_r($list);
                                ?>
                                <tr>
                                    <td><?php echo $ban['title']; ?></td>
                                    <td> 
                                        <?php
                                        if ($ban['image'] != '') {
                                            ?>
                                        <img src="<?php echo SITE_URL . "assets/banner_image/" . $ban['image']; ?>" style="max-height: 75px; max-width: 100px;" />

                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ban['display_for'] == 'D') {
                                            echo 'DESKTOP';
                                        } else {

                                            echo 'MOBILE';
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        if ($ban['status'] == 'Y') {
                                            echo anchor(base_url() . 'banner/change_banner_status/' . $ban['id'] . '/inact/' . $ban['status'], '&nbsp;', $atr4);
                                        } else {

                                            echo anchor(base_url() . 'banner/change_banner_status/' . $ban['id'] . '/act/' . $ban['status'], '&nbsp;', $atr3);
                                        }
                                        ?>
                                    </td>
                                    <td align="right">
                                        <?php
                                        //$atr1 = array('class' => 'i-plus-circle-2', 'title' => 'Add City');
                                        $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit business');
                                        echo anchor(base_url() . 'banner/edit/' . $ban['id'], '&nbsp;', $atr2);
                                        echo anchor(base_url() . 'banner/delete/' . $ban['id'], '&nbsp;', $attr);
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" align="center" class="red">Records Not Found</td>                                                          	
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
               <?php if ($page>30) {  ?>    

            <?php echo $links; ?>
                <?php }  ?>
            

    </div> <!-- End .container-fluid  -->
    </div> <!-- End .wrapper  -->
</section>
