<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active">Category list</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="text-right mb-2"><a href="<?=base_url().'categories/add'?>" class="btn btn-primary"><i class="la la-plus"></i> Add Category</a></div>
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
      <table class="table table-hover table-bordered adminmenu_list">
        <thead>
          <tr>
            <th>Id</th>
            <th >Category Name</th>
            <th>Status</th>
            <th>Home Show Status</th>
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
          <tr onclick="displaySubadminmenu(<?php echo $menu['cat_id']; ?>);" class="pointer_class">
            <td><?php echo $menu['cat_id']; ?></td>
            <td><?php echo $menu['cat_name']; ?></td>
           
            <td align="center"><?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'categories/change_category_status/' . $menu['cat_id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'categories/change_category_status/' . $menu['cat_id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?></td>
            <td align="center"><?php
											 if ($menu['show_status'] == 'Y') {
											echo anchor(base_url() . 'categories/change_category_show_status/' . $menu['cat_id'].'/inact_stat/'.$menu['show_status'], '&nbsp;', $atr4);
										
											} else {
										
											echo anchor(base_url() . 'categories/change_category_show_status/' . $menu['cat_id'].'/act_stat/'.$menu['show_status'], '&nbsp;', $atr3);
											}
											?></td>
            <td align="right"><?php
                                    $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add', 'style' => 'text-decoration:none',);
                                    $atr5 = array('class' => 'la la-lightbulb-o _165x', 'title' => 'View Skills', 'style' => 'text-decoration:none',);
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);
									$atr7=array('class' => 'la la-plus _165x', 'title' => 'Add Skill', 'style' => 'text-decoration:none',);
									$atr8=array('class' => 'la la-graduation-cap _165x', 'title' => 'View Skill', 'style' => 'text-decoration:none',);

                                    echo anchor(base_url() . 'categories/addskill/' . $menu['cat_id'], '&nbsp;', $atr1);
                                    echo anchor(base_url() . 'categories/viewskill/' . $menu['cat_id'], '&nbsp;', $atr5);
                                    echo anchor(base_url() . 'categories/edit/' . $menu['cat_id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'categories/delete/' . $menu['cat_id'], '&nbsp;', $attr);
                                        ?></td>
          </tr>
          <?php
                                if (count($menu['childs']) > 0) {
                                    $childs = $menu['childs'];

                                    if (count($childs) != 0) {
                                        foreach ($childs as $k => $child) {
                                            ?>
          <tr class="submenulist  sub_trno_<?php echo $menu['cat_id']; ?>" style="display:none;">
           
            <td><?php echo $child->cat_name; ?></td>
            <td align="center"><?php
                            if ($child->status == 'N') {
                                echo '<i class="la la-times _165x red"></i>';
                            } else {
                                echo '<i class="la la-check-circle _165x green"></i>';
                            }
                                            ?></td>
            <td></td>
            <td align="center"><?php
                                    echo anchor(base_url() . 'categories/edit/' . $child->cat_id, '&nbsp;', $atr2);

                                    echo anchor(base_url() . 'categories/delete/' . $child->cat_id, '&nbsp;', $attr);
									echo anchor(base_url() . 'categories/addskill/' . $child->cat_id, '&nbsp;', $atr7);
									echo anchor(base_url() . 'categories/viewskill/' . $child->cat_id, '&nbsp;', $atr8);
									
                                            ?></td>
          </tr>
          <?php
                                        } //4each
                                    }//if
                                }
                                ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- End .wrapper  --> 
</section>
