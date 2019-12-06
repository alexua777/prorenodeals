<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Admin User Type</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="text-right mb10"><a href="<?=base_url().'adminuser/add_type'?>" class="btn btn-primary"><i class="la la-plus"></i> Add User Type</a></div>
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
      <table class="table adminmenu_list">
        <thead>
          <tr>
            <th style="width:48px">Id</th>
            <th>Type Name</th>
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
	if(count($list)>0)
	{
	foreach ($list as $key => $menu) {
    ?>
          <tr class="pointer_class">
            <td><?php echo $menu['id']; ?></td>
            <td><?php echo $menu['name']; ?></td>
            <td align="center"><?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'adminuser/change_category_status/' . $menu['id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'adminuser/change_category_status/' . $menu['id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?></td>
            <td align="right"><?php
                                    $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add', 'style' => 'text-decoration:none',);
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                    
                                    echo anchor(base_url() . 'adminuser/edit_type/' . $menu['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'adminuser/delete_type/' . $menu['id'], '&nbsp;', $attr);
                                        ?></td>
          </tr>
          <?php } 
							}
							else
							{
								echo "<tr><td style='color:red'>No data found</td></tr>";	
							}
							?>
        </tbody>
      </table>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
