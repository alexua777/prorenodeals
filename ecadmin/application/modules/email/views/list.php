<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Email List</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <?php /*?><table class="table table-hover table-bordered adminmenu_list">
				<tr>
				<td colspan="5" align="right">
				<a href="<?=base_url()?>email/add"><input class="btn btn-default" type="button" value="Add Email"></a>
				</td>
				</tr>
			    </table><?php */?>
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
            <th>Type</th>
            <th>subject</th>
            <!--  <th>Status</th>-->
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

if(count($list)!=0){
foreach ($list as $key => $email) {
   // print_r($list);
    ?>
          <tr>
            <td><?php echo $email['id']; ?></td>
            <td><?php echo $email['type']; ?></td>
            <td><?php echo $email['subject']; ?></td>
            <?php /*?>	<td align="center">
                                         <?php
										if ($email['status'] == 'Y') {
										echo anchor(base_url() . 'email/change_email_status/' . $email['id'].'/inact/'.$email['status'], '&nbsp;', $atr4);
									
										} else {
									
										echo anchor(base_url() . 'email/change_email_status/' . $email['id'].'/act/'.$email['status'], '&nbsp;', $atr3);
										}
								
								     ?> </td><?php */?>
            <td align="right"><?php
                                        $atr2 = array('class' => 'la la-edit _165x', 'title' => 'Edit', 'style' => 'text-decoration:none',);

                                        echo anchor(base_url() . 'email/edit/' . $email['id'], '&nbsp;', $atr2);
                                       ?></td>
          </tr>
          <?php }
	}else{
	
 ?>
          <tr>
            <td colspan="6" align="center" class="red">Records Not Found</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php if ($links) {?>
      <?php echo $links; ?>
      <?php }?>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
