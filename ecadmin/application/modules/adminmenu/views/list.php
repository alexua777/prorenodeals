<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Admin menu list</a> </li>
        <li class="breadcrumb-item active"><a onclick="redirect_to('<?php echo base_url() . 'addnewmenu'; ?>');">Add Administrator Menu</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="text-right mb-2"> <a href="<?=base_url().'addnewmenu'?>" class="btn btn-primary"><i class="la la-plus"></i> Add admin menu</a></div>
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
            <th >Menu Name</th>
            <th >Sub Menu Name</th>
            <th style="width:35%">Menu Description</th>
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
foreach ($list as $key => $menu) {
    ?>
          <tr onclick="displaySubadminmenu(<?php echo $menu['id']; ?>);" class="pointer_class">
            <td><?php echo $menu['id']; ?></td>
            <td><?php echo $menu['name']; ?></td>
            <td>&nbsp;</td>
            <td><?php echo $menu['title']; ?></td>
            <td align="center"><?php echo $menu['ord']; ?></td>
            <td align="center"><?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'adminmenu/change_admin_status/' . $menu['id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'adminmenu/change_admin_status/' . $menu['id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?></td>
            <td align="right"><?php
                                    $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add', 'style' => 'text-decoration:none',);
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                    echo anchor(base_url() . 'adminmenu/add/' . $menu['id'], '&nbsp;', $atr1);
                                    echo anchor(base_url() . 'adminmenu/edit/' . $menu['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'adminmenu/delete/' . $menu['id'], '&nbsp;', $attr);
                                        ?></td>
          </tr>
          <?php
                                if (count($menu['childs']) > 0) {
                                    $childs = $menu['childs'];

                                    if (count($childs) != 0) {
                                        foreach ($childs as $k => $child) {
                                            ?>
          <tr class="submenulist  sub_trno_<?php echo $menu['id']; ?>" style="display:none;">
            <td colspan="2"></td>
            <td><?php echo $child->name; ?></td>
            <td><?php echo $child->title; ?></td>
            <td align="center"><?php echo $child->ord; ?></td>
            <td align="center"><?php
                            if ($child->status == 'N') {
                                echo '<i class="i-close-4 red"></i>';
                            } else {
                                echo '<i class="i-checkmark-4 green"></i>';
                            }
                                            ?></td>
            <td align="center"><?php
                                    echo anchor(base_url() . 'adminmenu/edit/' . $child->id, '&nbsp;', $atr2);

                                    echo anchor(base_url() . 'adminmenu/delete/' . $child->id, '&nbsp;', $attr);
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
</section>
