<?php // $this->load->library('session');     ?>

<section id="content">
  <div class="wrapper">
    <div class="crumb">
      <ul class="breadcrumb">
        <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>
        <li class="active">Advertise position list</li>
      </ul>
    </div>
    <div class="container-fluid"> <a href="<?= base_url() ?>addpos/add">
      <input class="btn btn-default" type="button" value="Add advertise position">
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
            <th>Page</th>
            <th>Position</th>
            <th>Resolution</th>
            <th>Price</th>
            <th>Validity (days)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
                            foreach ($list as $key => $banner) {
                                ?>
          <tr>
            <td><?php echo $banner['id']; ?></td>
            <td><?php echo $banner['type']; ?></td>
            <td><?php echo $banner['position']; ?></td>
            <td align="center"><?php echo $banner['resolution']; ?></td>
            <td align="right"><?php echo $banner['price']; ?></td>
            <td align="right"><?php echo $banner['validity']; ?></td>
            <td align="center"><?php
                                        $atr2 = array('class' => 'i-highlight', 'title' => 'Edit State');
                                        echo anchor(base_url() . 'addpos/edit/' . $banner['id'], '&nbsp;', $atr2);
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
