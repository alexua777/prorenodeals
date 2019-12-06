<section id="content">

  <div class="wrapper">

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>

        <li class="breadcrumb-item"><a href="<?= base_url() ?>user_support/list_all/">User Support</a></li>

        <li class="breadcrumb-item active"><a>Detail</a></li>

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

      <div class="panel panel-default">

        <div class="panel-heading">

          <h5><i class="la la-plus-square"></i> User Message</h5>

          <a href="#" class="minimize2"></a> </div>

        <!-- End .panel-heading -->

        

        <div class="panel-body">

          <form id="validate" action="" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

            <div class="form-group">
				<label class="col-form-label" for="required">User</label>
			  &nbsp;
			  <span><?php echo !empty($detail['full_name']) ? $detail['full_name'] : 'Unknown Name'; ?></span>

            </div>

			<div class="form-group">
				<label class="col-form-label" for="required">Date</label>
			  &nbsp;
			  <span><?php echo !empty($detail['date']) ? $detail['date'] : '--'; ?></span>

            </div>

			<div class="form-group">
				<label class="col-form-label" for="required">Category</label>
			  &nbsp;
			  <span class="badge"><?php echo !empty($detail['category']) ? $detail['category'] : 'n/a'; ?></span>

            </div>
			
            <!-- End .control-group  -->

            

            <div class="form-group">

              <label class="col-form-label" for="required">User Message</label>

               <div><?php echo nl2br($detail['support_message']); ?></div>


            </div>
			
			<div class="form-group">

              <label class="col-form-label" for="required">Reply</label>

              <textarea class="form-control" name="reply" <?php echo $detail['replied'] > 0 ? 'readonly' : '';?>><?php echo !empty($detail['reply']) ? $detail['reply'] : '';?></textarea>


            </div>

			
			<?php if($detail['replied'] === '0'){ ?>
            <input type="submit" class="btn btn-primary" value="Reply">&nbsp;
			<?php } ?>

            <button type="button" onclick="redirect_to('<?php echo base_url() . 'user_support/list_all/'; ?>');" class="btn btn-secondary">Cancel</button>                        

          </form>

        </div>

        <!-- End .panel-body --> 

      </div>

      <!-- End .widget --> 

      

    </div>

    <!-- End .container-fluid  --> 

  </div>

  <!-- End .wrapper  --> 

</section>

