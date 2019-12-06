<?php // $this->load->library('session');   ?>

<section id="content">
  <div class="wrapper">
    <div class="crumb">
      <ul class="breadcrumb">
        <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
        <li class="active">Country List</a></li>
        <li class="active"><a onclick="redirect_to('<?php echo base_url() . 'country/add'; ?>');">Add Country</a></li>
      </ul>
    </div>
    <div class="container-fluid">
      <div class="text-right mb-2"><a href="<?= base_url() . 'country/add/' ?>" class="btn btn-primary"><i class="la la-plus"></i> Add Country</a></div>
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
            <th>Country</th>
            <th>Order</th>
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
                                            $atr6 = array(
                                                'onclick' => "javascript: return confirm('Cancel default?');",
                                                'class' => 'i-plus-2  green',
                                                'title' => 'Cancel default'
                                            );
                                            $atr7 = array(
                                                'onclick' => "javascript: return confirm('Set as default?');",
                                                'class' => 'i-plus-2  red',
                                                'title' => 'Set as default country'
                                            );

                                            if (count($list) != 0) {
                                                foreach ($list as $key => $country) {
                                                    ?>
          <tr>
            <td align="center"><?php echo $country['id']; ?></td>
            <td><?php
                                                            if ($country['flag_logo'] != "") {
                                                                ?>
              <img src="<? echo SITE_URL . "assets/country_flag_logo/" . $country['flag_logo'] ?>" height="15" width="20">
              <?php
                                                            } else {
                                                                ?>
              <img src="<?= SITE_URL ?>assets/country_flag_logo/default.jpg" height="15" width="20">
              <?php
                                                            }
                                                            ?>
              <b style="color: #E48609;">
              <?= ucwords($country['c_name']) ?>
              </b> <font style="color: #f00;">(
              <?= $country['c_code'] ?>
              )</font><br/>
              <div style="margin-left: 20px; font-size: 12px; color: #006621">
                <div class="i-earth" style="color: #7197E8;"></div>
                <?= $country['domain'] ?>
              </div></td>
            <td align="center"><?php echo $country['order_id']; ?></td>
            <td align="center"><?php
                                                            if ($country['status'] == 'Y') {
                                                                echo anchor(base_url() . 'country/change_country_status/' . $country['id'] . '/inact/' . $country['status'], '&nbsp;', $atr4);
                                                            } else {

                                                                echo anchor(base_url() . 'country/change_country_status/' . $country['id'] . '/act/' . $country['status'], '&nbsp;', $atr3);
                                                            }
                                                            ?></td>
            <td align="center"><?php
                                                            if ($country['set_default'] == 'Y') {
                                                                echo anchor(base_url() . 'country/change_default_country/' . $country['id'] . '/nod', '&nbsp;', $atr6);
                                                            } else {

                                                                echo anchor(base_url() . 'country/change_default_country/' . $country['id'] . '/yd', '&nbsp;', $atr7);
                                                            }
                                                            $atr1 = array('class' => 'i-plus-circle-2', 'title' => 'Add State');
                                                            $atr2 = array('class' => 'i-highlight', 'title' => 'Edit Country');

                                                            echo anchor(base_url() . 'state/add/' . $country['id'], '&nbsp;', $atr1);
                                                            echo anchor(base_url() . 'country/edit/' . $country['id'], '&nbsp;', $atr2);
                                                            echo anchor(base_url() . 'country/delete/' . $country['id'], '&nbsp;', $attr);
                                                            ?></td>
          </tr>
          <?php } ?>
          <? } else { ?>
          <tr>
            <td colspan="6" align="center" class="red"> No Records Found </td>
          </tr>
          <? } ?>
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
