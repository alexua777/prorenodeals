<?php // $this->load->library('session');  ?>

<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'contact/'; ?>">Support Ticket List</a></li>
        <li class="breadcrumb-item active"><a>Reply Message</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
    <div class="panel">
    <div class="panel-heading">
    <h5><i class="la la-envelope"></i> Reply Message</h5>
    </div>
      <div class="panel-body">
	  <?php echo validation_errors('<div class="red alert ">', '</div>'); ?>
        <form id="validate"  class="form-horizontal" role="form" name="news" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-form-label" for="required">Mail To</label>
            <input type="text" id="required" value="<?php echo $user_email; ?>" name="mail_to" class="required form-control">
            <?php echo form_error('mail_to', '<label class="error" for="required">', '</label>'); ?> </div>
          <div class="form-group">
            <label class="col-form-label" for="required">Subject</label>
            <input type="text" id="required" value="" name="subject" class="required form-control">
            <?php echo form_error('subject', '<label class="error" for="required">', '</label>'); ?> </div>
          <div class="form-group">
            <label class="col-form-label" for="required">Reply Message</label>
            <textarea name="reply_message" id="text-editor" class="valid form-control" rows="15" cols="20"></textarea>
            <?php echo form_error('reply_message', '<label class="error" for="required">', '</label>'); ?> </div>
          <button type="submit" class="btn btn-primary" name="reply" value="reply">Send Message</button>
          &nbsp;
          <button type="button" onclick="redirect_to('<?php echo base_url() . 'contact/page'; ?>');" class="btn btn-secondary">Cancel</button>
        </form>
      </div>
    </div>
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
