<section id="content">
    <div class="wrapper">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'add/add'; ?>">Advertise List</a></li>
                <li class="breadcrumb-item active">Advertise List</li>
            </ol>
        </nav>
        
        <div class="container-fluid">                    		
			<div class="text-right mb-2"><a href="<?= base_url() ?>add/add_advertise" class="btn btn-primary"><i class="la la-plus"></i> Add advertise</a></div>
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
                                <th>Page (position)</th>
                                <th>Ad Type</th>
                                <th>Code</th>
                                <th>Image</th>
                                <th>URL</th>
                                <th>Add date</th>
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

                            if (count($all_data) != 0) {
                                foreach ($all_data as $key => $ban) {
                                    // print_r($list);
                                    ?>
                                    <tr>
                                        <td><?php echo $ban['id']; ?></td>
                                        <td><?php echo $ban['page_name']. " (" . $ban['position'] . ")"; ?></td>
                                        <td><?php echo $ban['type']; ?></td>
                                        <td><?php if($ban['code']!=''){echo "Adsense code available";}else{echo "...";} ?></td>
                                        <td align="center">
										<?php if($ban['banner_image']!='')
										{
										?>
                                        <img src="<?= SITE_URL?>assets/ad_image/<?=$ban['banner_image']?>" height="60" width="60"/>
										<?php
										}else{ ?>
											
											  No Images.
											<?php
											
											} ?>
										</td>
                                        <td><?php echo $ban['banner_url'];?></td>
                                        <td align="center"><?php echo date('d-M-Y',strtotime($ban['add_date'])); ?></td>
                                        <td align="center">
                                            <?php
                                            if ($ban['status'] == 'Y') {
                                                echo anchor(base_url() . 'add/change_banner_status/' . $ban['id'] . '/inact/' . $ban['status'], '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'add/change_banner_status/' . $ban['id'] . '/act/' . $ban['status'], '&nbsp;', $atr3);
                                            }
                                            ?>
                                        </td>
                                        <td align="right">
                                            <?php
                                            //$atr1 = array('class' => 'i-plus-circle-2', 'title' => 'Add City');
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit advertise');
                                            echo anchor(base_url() . 'add/edit/' . $ban['id'], '&nbsp;', $atr2);
                                            echo anchor(base_url() . 'add/delete/' . $ban['id'], '&nbsp;', $attr);
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" align="center" class="red">Records Not Found</td>                                                          	
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
