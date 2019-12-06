<?php // $this->load->library('session');  ?>

<section id="content">
    <div class="wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('categories'); ?>">Category list</a> </li>
            <li class="breadcrumb-item active">Category Skills</li>
            </ol>
        </nab>
        <div class="container-fluid">            
				<div class="text-right" style="margin-bottom:10px" hidden><a href="<?=base_url().'skills_new/add'?>" class="btn btn-primary"><i class="la la-plus"></i> Add Skill</a></div>
                
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
                        <div class="alert alert-danger">
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
                                <th >Skill Name</th>
                                <th >Category</th>
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
foreach ($list as $key => $menu) {
    ?>
								<tr>
                                    <td><?php echo $menu['id']; ?></td>
                                    <td><?php echo $menu['skill_name']; ?></td>
                                    <td><?php echo $menu['cat_name']; ?></td>
                                    
                                    <td align="center">
                                        <?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'skills_new/change_skill_status/' . $menu['id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'skills_new/change_skill_status/' . $menu['id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?>
                                    </td>
                                    <td align="right"><?php
                                    /* $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add', 'style' => 'text-decoration:none',); */
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                    /* echo anchor(base_url() . 'skills_new/add_new/' . $menu['id'], '&nbsp;', $atr1); */
                                    echo anchor(base_url() . 'skills_new/edit_new/' . $menu['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'skills_new/delete_new/' . $menu['id'], '&nbsp;', $attr);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                if (count($menu['childs']) > 0) {
                                    $childs = $menu['childs'];

                                    if (count($childs) != 0) {
                                        foreach ($childs as $k => $child) {
                                            ?>
                                            <tr class="submenulist  sub_trno_<?php echo $menu['id']; ?>" style="display:none;">
                                                <td colspan="2"></td>
                                                <td><?php echo $child->skill_name; ?></td>
                                            
                                                <td align="center"><?php
                            if ($child->status == 'N') {
                                echo '<i class="la la-times _165x red"></i>';
                            } else {
                                echo '<i class="la la-check-circle _165x green"></i>';
                            }
                                            ?></td>
                                                <td align="center"><?php
                                    echo anchor(base_url() . 'skills_new/edit_new/' . $child->id, '&nbsp;', $atr2);

                                    echo anchor(base_url() . 'skills_new/delete_new/' . $child->id, '&nbsp;', $attr);
                                            ?>
                                                </td>
                                            </tr>
                                            <?php
                                        } 
                                    }
                                }
                                ?>
                            <?php } ?>
                        </tbody>
                    </table>
                
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>
