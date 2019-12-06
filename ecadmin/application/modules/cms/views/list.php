<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'cms/add'; ?>">Add Content</a></li>
        <li class="breadcrumb-item active"><a>Content List</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
    	<div class="text-right mb-2"><a href="<?= base_url() ?>cms/add" class="btn btn-primary"><i class="la la-plus"></i> Add Content</a></div>      
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
      <table class="table table-hover adminmenu_list">
        <thead>
          <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Pagename</th>
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
                                foreach ($list as $key => $cms) {
                                    ?>
          <tr>
            <td align="center"><?php echo $cms['id']; ?></td>
            <td><?php echo $cms['cont_title']; ?></td>
            <td align="left"><?php echo $cms['pagename']; ?></td>
            <td align="center"><?php
                                            if ($cms['status'] == 'Y') {
                                                echo anchor(base_url() . 'cms/change_cms_status/' . $cms['id'] . '/inact/' . $cms['status'], '&nbsp;', $atr4);
                                            } else {

                                                echo anchor(base_url() . 'cms/change_cms_status/' . $cms['id'] . '/act/' . $cms['status'], '&nbsp;', $atr3);
                                            }
                                            ?></td>
            <td align="right"><?php
                                            $atr1 = array('class' => 'la la-plus _165x', 'title' => 'Add Contents');
                                            $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit Contents');



                                            echo anchor(base_url() . 'cms/edit/' . $cms['id'], '&nbsp;', $atr2);
//echo anchor(base_url().'cms/delete/'.$cms['id'],'&nbsp;',$attr) ; 
                                            ?></td>
          </tr>
          <?php
                                }
                            } else {
                                ?>
          <tr>
            <td colspan="5" align="center" class="red"> No Records Found </td>
          </tr>
          <?php }
?>
        </tbody>
      </table>
      <?php if ($page > 30) { ?>
      <?php echo $links; ?>
      <?php } ?>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
