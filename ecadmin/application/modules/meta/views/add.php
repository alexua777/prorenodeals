<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url() . 'meta'; ?>">Meta Section List</a></li>
        <li class="breadcrumb-item active"><a>Add Meta Section</a></li>
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-plus-square"></i> Add Meta Section</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body">
          <form id="validate" action="<?php echo base_url(); ?>meta/add" class="form-horizontal" role="form" name="meta" method="post">
            <div class="form-group">
              <label class="col-form-label" for="url">Enter Pagename</label>
                <select id="curl" name="pagename" class="required form-control">
                  <option value="">Please Select</option>
                  <option value="Home">Home</option>
                  <option value="Signup">Signup</option>
                  <option value="Forgot_pass">Forgot Password</option>
                  <option value="Postjob">Post Job</option>
                  <option value="Notification">Notification</option>
                  <option value="Myfinance">My Finance</option>
                  <option value="Message">Message</option>
                  <option value="Membership">Membership</option>
                  <option value="Login">Login</option>
                  <option value="Findwork">Find Work</option>
                  <option value="Findtalents">Find Talents</option>
                  <option value="Findjob">Find Job</option>
                  <option value="Findfreelancer">Find Freelancer</option>
                  <option value="Disputes">Disputes</option>
                  <option value="Dashboard">Dashboard</option>
                  <option value="Faqhelp">FAQ Help</option>
                  <option value="Howitwork">How It Works</option>
                  <option value="Contact">Contact Us</option>
                  <option value="Editprofile_professional">Editprofile Professional</option>
                  <option value="Editprofile_skill">Editprofile Skill</option>
                  <option value="Editportfolio">Editportfolio</option>
                  <option value="Myproject">Myproject</option>
                  <option value="Settings">Settings</option>
                  <option value="Addportfolio">Addportfolio</option>
                  <option value="Edit">Edit</option>
                  <option value="Testimonial">Testimonial</option>
                  <option value="Clienttestimonial">Client Testimonial</option>
                  <option value="Invitetalents">Invite Talents</option>
                  <option value="Knowledgebase">Knowledgebase</option>
                  <option value="References">References</option>
                  <option value="Sitemap">Sitemap</option>
                </select>
                <?php echo form_error('pagename', '<label class="error" for="required">', '</label>'); ?> 
            </div>
            <div class="form-group">
              <label class="col-form-label" for="url">Meta Title</label>
                <input id="curl" value="<?php echo set_value('meta_title'); ?>" type="text" name="meta_title" class="required form-control" />
                <?php echo form_error('meta_title', '<label class="error" for="required">', '</label>'); ?> 
            </div>
            <div class="form-group">
              <label class="col-form-label" for="url">Meta Keywords</label>
              <input id="curl" value="<?php echo set_value('meta_keys'); ?>" type="text" name="meta_keys" class="required form-control" />
              <?php echo form_error('meta_keys', '<label class="error" for="required">', '</label>'); ?>
            </div>
            <div class="form-group">
              <label class="col-form-label" for="digits">Meta Description</label>
              <textarea class="form-control elastic" id="textarea1" name="meta_desc" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 74px;"></textarea>
            </div>
            <div class="form-group">
              <label for="radio" class="col-form-label">Status</label><br />
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status" name="status" value="Y" checked="checked">
                  <label class="custom-control-label" for="status">Online</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="status_2" name="status" value="N" <?php echo set_checkbox('status', 'N'); ?>>
                  <label class="custom-control-label" for="status_2">Offline</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;
            <button type="button" onclick="redirect_to('<?php echo base_url().'meta'; ?>');" class="btn btn-secondary">Cancel</button>
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
