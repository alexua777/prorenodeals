
<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'email'; ?>">Email List</a></li>
        <li class="breadcrumb-item active"><a>Edit Email</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h5><i class="la la-edit"></i> Modify Email Template</h5>
              <a href="#" class="minimize2"></a> </div>
            <!-- End .panel-heading -->
            <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
              <form id="validate" action="<?php echo base_url(); ?>email/edit" class="form-horizontal" role="form" name="email" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <div class="row">
                  <label class="col-lg-2 col-md-3 col-form-label" for="required">Email Type</label>
                  <div class="col-lg-10 col-md-9">
                    <input type="text" id="required" value="<?php echo $type; ?>" name="type" class="required form-control" readonly="readonly">
                    <?php echo form_error('type', '<label class="error" for="required">', '</label>'); ?> </div>
                </div>
                <div class="row">
                  <label class="col-lg-2 col-md-3 col-form-label" for="required">Subject</label>
                  <div class="col-lg-10 col-md-9">
                    <input type="text" value="<?php echo $subject; ?>" name="subject" class="required form-control">
                    <?php echo form_error('subject', '<label class="error" for="required">', '</label>'); ?> </div>
                </div>
                <div class="row">
                  <label class="col-lg-2 col-md-3 col-form-label" for="digits">Template</label>
                  <div class="col-lg-10 col-md-9">
                    <textarea name="template" id="contents" class="col-lg-7 valid form-control" rows="18" cols="40">
                    <?php echo html_entity_decode($template); ?>
                    </textarea>
                    <?php echo display_ckeditor($ckeditor); ?> <br />
                    <span style="color:#F00">Legend:</span><span style="text-align:justify;">{username}->User's username; {copy_url}->Url for browser; {password}->User's password; {freelancer}->Freelancer name; {project}->Project name; {project_url}->Job details page url; {amount}->Bid amount; {duration}->Estimated duration on bid; {plan}->Membershipo plan name; {start}->Membership plan start date; {end}->Membership Plan end date; {name}->Freelancer name/ Invitee name; {project_name}->Project name; {NAME}->Contacted person name; {EMAIL}->Contacted person email; {TICKET}->Support ticket no; {SUBJECT}->Support request subject; {MESSAGE}->Support request message;</span><span style="color:#F00"> (Please do not edit or modify these keywords.)</span> </div>
                </div>
                
                <!-- End .control-group  -->
                <?php /*?>	<div class="row">
                                            <label for="radio" class="col-lg-2 col-md-3 col-form-label">Status</label>
                                            <label class="radio-inline">
                                                <div class="radio"><span><input type="radio" id="status" name="status" value="Y" checked="checked"  /></span></div> Online
                                            </label>
                                            <label class="radio-inline">
                                                <div class="radio"><span class="checked"><input <?php if ($status == 'N') { echo 'checked'; } ?> type="radio" id="status" name="status" Value="N"></span></div> Offline
                                            </label>                                           
                                        </div><?php */?>
                <!-- End .control-group  -->
                <div class="row">
                  <div class="col-lg-2 col-md-3">&nbsp;</div>
                  <div class="col-lg-10 col-md-9">
                    <button type="submit" class="btn btn-primary">Save</button>
                    &nbsp;
                    <button type="button" onclick="redirect_to('<?php echo base_url() . 'email'; ?>');" class="btn btn-secondary">Cancel</button>
                  </div>
                </div>
                <!-- End .row  -->
              </form>
            </div>
            <!-- End .panel-body --> 
          </div>
          <!-- End .widget --> 
        </div>
        <!-- End .col-lg-12  --> 
      </div>
      <!-- End .row-fluid  --> 
    </div>
    <!-- End .container-fluid  --> 
  </div>
  <!-- End .wrapper  --> 
</section>
