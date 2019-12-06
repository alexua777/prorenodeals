<section id="content">
  <div class="wrapper">
    <div class="crumb">
      <ul class="breadcrumb">
        <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
        <li class="active"><a href="<?= base_url() ?>advertise/page">Advertise List</a></li>
        <li class="active"><a href="<?php echo base_url() ; ?>advertise/add">Add Advertise</a></li>
      </ul>
    </div>
    <div class="container-fluid"> <a href="<?= base_url() ?>advertise/add">
      <input class="btn btn-default" type="button" name="add_state" value="Add Advertise">
      </a>
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
            <th>Advertise Title</th>
            <th>Advertise Image</th>
            <th>Page Name</th>
            <th>Position</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
                                            $attr = array(
                                                'onclick' => "javascript: return confirm('Do you want to delete?');",
                                                'class' => 'i-cancel-circle-2 red',
                                                'title' => 'Delete'
                                            );
                                            $atr3 = array(
                                                'onclick' => "javascript: return confirm('Do you want to active this?');",
                                                'class' => 'i-checkmark-3 red',
                                                'title' => 'Inactive'
                                            );
                                            $atr4 = array(
                                                'onclick' => "javascript: return confirm('Do you want to inactive this?');",
                                                'class' => 'i-checkmark-3 green',
                                                'title' => 'Active'
                                            );

                                            //	$atr3 = array('class' => 'i-close-4 red', 'title' => 'Inactive');
                                            //$atr4 = array('class' => 'i-checkmark-4 green', 'title' => 'Active');

                                            foreach ($list as $key => $state) {
                                                ?>
          <tr>
            <td><?php echo $state['id']; ?></td>
            <td><?php echo ucwords($state['advertise_name']); ?></td>
            <td><image src="../../assets/advertise_image/<?php echo $state['advartise_image']; ?>"  width="220" height="120"/></td>
            <td><?php echo $state['page_name']; ?></td>
            <td><?php 
													
													
													switch($state['add_pos']){
													
														case 'T':
														echo 'Top';
														break;
														
														case 'R':
														echo 'Right';
														break;
														case 'B':
														echo 'Bottom';
														break;
														case 'T':
														echo 'Top';
														break;
													
													
													}



													?></td>
            <td align="center"><?php
														if ($state['status'] == 'Y') {
															echo anchor(base_url() . 'advertise/change_status/' . $state['id'] . '/inact/', '&nbsp;', $atr4);
															} else {
															echo anchor(base_url() . 'advertise/change_status/' . $state['id'] . '/act/', '&nbsp;', $atr3);
															}
														?></td>
            <td align="center"><?php
                                                        
                                                        $atr2 = array('class' => 'i-highlight', 'title' => 'Edit Event');

                                                       
                                                        echo anchor(base_url() . 'advertise/edit/' . $state['id'], '&nbsp;', $atr2);
                                                        echo anchor(base_url() . 'advertise/delete_event/' . $state['id'], '&nbsp;', $attr);
                                                        ?></td>
          </tr>
          <?php } ?>
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
