<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
		<li class="breadcrumb-item active"><a>Newsletter Management</a></li>
      </ol>
    </nav>     
    <div class="container-fluid">
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
      <iframe src="<?php echo SITE_URL;?>/assets/newsletter/" height="600" width="1000"></iframe>
    </div>
    <!-- End .container-fluid  --> 
    
  </div>
  <!-- End .wrapper  --> 
  
</section>
