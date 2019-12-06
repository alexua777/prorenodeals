<?php // $this->load->library('session');  ?>

<section id="content">
    <div class="wrapper">
        <div class="crumb">
            <ol class="breadcrumb">
            <li class="active"><a href="<?= base_url()?>"><i class="icon16 i-home-4"></i>Home</a></li>            
            <li class="active"><a onclick="redirect_to('<?php echo base_url() . 'skills/add'; ?>');">Add Skills</a></li>
            <li class="active">Category list</a> </li>
            </ol>
        </div>
        <div class="container-fluid">
			<div class="text-right mb-2"><a href="<?=base_url().'skills/add'?>" class="btn btn-primary"><i class="la la-plus"></i> Add Skill</a></div>
					
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
                                <th >Skill Name</th>
                               <!--  <th >Sub Skills</th> -->
                             <!--    <th>Status</th> -->
                                <th >Active/Inactive</th>
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
						'onclick' => "javascript: return confirm('Do you want to active for show in home?');",
						'class' => 'la la-check-circle _165x red',
						'title' => 'Inactive'
					);
					$atr4 = array(
						'onclick' => "javascript: return confirm('Do you want to inactive from home?');",
						'class' => 'la la-check-circle _165x green',
						'title' => 'Active'
					);
				foreach ($list as $key => $menu) {
    ?>
                            <tr class="pointer_class">
                                    <td><?php echo $menu['id']; ?></td>
                                    <td><?php echo $menu['skill_name']; ?></td>
									 <td align="center"><?php
                                         if ($menu['show_status'] == 'Y') {
										echo anchor(base_url() . 'home_skills/change_skill_status/' . $menu['id'].'/inact/'.$menu['show_status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'home_skills/change_skill_status/' . $menu['id'].'/act/'.$menu['show_status'], '&nbsp;', $atr3);
										}
                                        ?> 
                                   
									
									</td>
                                    
                                    <?php /*<td align="center">
                                        <?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'skills/change_skill_status/' . $menu['id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'skills/change_skill_status/' . $menu['id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?> 
                                    </td> 
                                    <td align="center"><?php
                                    $atr1 = array('class' => 'i-plus-circle-2', 'title' => 'Add', 'style' => 'text-decoration:none',);
                                    $atr2 = array('class' => 'i-highlight', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                    echo anchor(base_url() . 'skills/add/' . $menu['id'], '&nbsp;', $atr1);
                                    echo anchor(base_url() . 'skills/edit/' . $menu['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'skills/delete/' . $menu['id'], '&nbsp;', $attr);
                                        ?>
                                    </td>*/ ?>
                                </tr>
                                <?php /*
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
                                echo '<i class="i-close-4 red"></i>';
                            } else {
                                echo '<i class="i-checkmark-4 green"></i>';
                            }
                                            ?></td> 
                                                <td align="center"><?php
                                    echo anchor(base_url() . 'skills/edit/' . $child->id, '&nbsp;', $atr2);

                                    echo anchor(base_url() . 'skills/delete/' . $child->id, '&nbsp;', $attr);
                                            ?>
                                                </td>
                                            </tr> 
                                            <?php
                                        } //4each
                                    }//if
                                }
                                ?>*/ ?>
                            <?php } ?>
                        </tbody>
                    </table>
               
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>
