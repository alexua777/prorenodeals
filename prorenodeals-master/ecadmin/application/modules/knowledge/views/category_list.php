<?php // $this->load->library('session');  ?>

<section id="content">
    <div class="wrapper">        
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url() . 'knowledge/add_category'; ?>">Add Knowledge Category</a></li>
        <li class="breadcrumb-item active">Knowledge Category List</a></li>
      </ol>
    </nav>
        <div class="container-fluid">            
					<div class="text-right mb-2"><a href="<?=base_url().'knowledge/add_category'?>" class="btn btn-primary"><i class="la la-plus"></i> Add Category</a></div>
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
                                <th >Category Name</th>                                
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
                            <tr onClick="displaySubadminmenu(<?php echo $menu['id']; ?>);" class="pointer_class">
                                    <td><?php echo $menu['id']; ?></td>
                                    <td><?php echo $menu['name']; ?></td>
                                    
                                    
                                    <td align="center">
                                        <?php
                                         if ($menu['status'] == 'Y') {
										echo anchor(base_url() . 'knowledge/change_category_status/' . $menu['id'].'/inact/'.$menu['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'knowledge/change_category_status/' . $menu['id'].'/act/'.$menu['status'], '&nbsp;', $atr3);
										}
                                        ?>
                                    </td>
                                    <td align="right"><?php
                                    $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add', 'style' => 'text-decoration:none',);
                                    $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                    
                                    echo anchor(base_url() . 'knowledge/edit_category/' . $menu['id'], '&nbsp;', $atr2);
                                    echo anchor(base_url() . 'knowledge/delete_category/' . $menu['id'], '&nbsp;', $attr);
                                        ?>
                                    </td>
                                </tr>
            
                            <?php } ?>
                        </tbody>
                    </table>
                
        </div>
        <!-- End .container-fluid  -->
    </div>
    <!-- End .wrapper  -->
</section>
