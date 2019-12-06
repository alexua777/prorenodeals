<style>
.header_tr {
	background-color:#61adff;
	color:#fff;
	font-size: 16px;
	font-weight: 500;
}
</style>
<section id="content">
<div class="wrapper">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
      <li class="breadcrumb-item active"><a>Site Account modify</a> </li>
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
    <?php  //$this->layout->view('inc/setting_menu', '', '',false); 

				 ?>
    <ul class="nav nav-pills nav-fill mb-3">
      <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/edit/45">Site Setting</a> </li>
      <li class="nav-item"> <a class="nav-link active" href="<?= base_url() ?>settings/account_edit/45">Account Setting</a> </li>
      <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/transfer_edit/45">Transfer Setting</a> </li>
      <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/maintenance_setting/45">Site Under Maintenance</a> </li>
      <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/email_setting/1">Email Setting</a> </li>
    </ul>
    <div class="panel panel-blank">
      <div class="panel-heading">
        <h5><i class="la la-edit"></i> Edit Account Settings</h5>
        <a href="#" class="minimize2"></a> </div>
      <!-- End .panel-heading --> 
      <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
      <form id="validate" action="<?php echo base_url(); ?>settings/account_edit/1" class="form-horizontal"  role="form" name="settings" method="post">
        <input type="hidden" name="id" value="<?php echo $all_data['id'];  ?>" />
        <div class="form-group">
          <table class="table" hidden>
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Fixed Project</td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <th valign="middle" width="25%">Featured  charge (Fixed)(<?php echo CURRENCY;?>):</th>
                <td><input type="text" class="form-control" name="fix_featured_charge" size="9" value="<?php echo $all_data['fix_featured_charge'];?>" style="max-width:200px">
                  <?php echo form_error('fix_featured_charge', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <th valign="middle" width="25%">Non featured  charge (Fixed)(<?php echo CURRENCY;?>):</th>
                <td><input type="text" class="form-control" name="fix_non_featured_charge" size="9"  value="<?php echo $all_data['fix_non_featured_charge'];?>" style="max-width:200px">
                  <?php echo form_error('fix_non_featured_charge', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table" hidden>
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Hourly Project</td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Featured  charge (hourly)(<?php echo CURRENCY;?>):</b></td>
                <td><input type="text" class="form-control" name="featured_charge_hourly" size="9" value="<?php echo $all_data['featured_charge_hourly'];?>" style="max-width:200px">
                  <?php echo form_error('featured_charge_hourly', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <td valign="top" width="25%"><b>Non featured  charge (hourly)(<?php echo CURRENCY;?>):</b></td>
                <td><input type="text" class="form-control" name="non_featured_charge_hourly" size="9" value="<?php echo $all_data['non_featured_charge_hourly'];?>" style="max-width:200px">
                  <?php echo form_error('non_featured_charge_hourly', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Currency:</b></td>
                <td><input type="text" class="form-control" name="currency_txt" size="9" value="<?php echo $all_data['currency_txt'];?>" style="max-width:200px">
                  <?php echo form_error('currency_txt', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <td valign="top" width="25%"><b>Bidwin charge (%):</b></td>
                <td><input type="text" class="form-control" name="bidwin_charge" size="9" value="<?php echo $all_data['bidwin_charge'];?>" style="max-width:200px">
                  <?php echo form_error('bidwin_charge', '<label class="error">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Hourly minimum deposit (%):</b></td>
                <td><input type="text" class="form-control" name="hourly_project_deposit" size="9" value="<?php echo $all_data['hourly_project_deposit'];?>" style="max-width:200px">
                  <?php echo form_error('hourly_project_deposit', '<label class="error">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table" hidden>
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Affiliate Amount</td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Amount(<?php echo CURRENCY;?>):</b></td>
                <td><input type="text" class="form-control" name="affiliate_amount" size="9" value="<?php echo $all_data['affiliate_amount'];?>" style="max-width:200px">
                  <?php echo form_error('affiliate_amount', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table" hidden>
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Bonus Amount</td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <th valign="top" width="25%">Amount(<?php echo CURRENCY;?>) in (%):</th>
                <td><input type="text" class="form-control" name="bonus_amount" size="9" value="<?php echo $all_data['bonus_amount'];?>" style="max-width:200px">
                  <?php echo form_error('bonus_amount', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Commission and Tax</td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <th width="25%">Website commission (%):</th>
                <td><input type="text" class="form-control" name="constant[SITE_COMMISSION]" size="9" value="<?php echo $all_data['SITE_COMMISSION'];?>" style="max-width:200px">
                  <?php echo form_error('constant[SITE_COMMISSION]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <th width="25%">HST Rate (%):</th>
                <td><input type="text" class="form-control" name="constant[HST_RATE]" size="9" value="<?php echo $all_data['HST_RATE'];?>" style="max-width:200px">
                  <?php echo form_error('constant[HST_RATE]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <th width="25%">Featured Contest Price (<?php echo CURRENCY;?>):</th>
                <td><input type="text" class="form-control" name="constant[CONTEST_FEATURED_PRICE]" size="9" value="<?php echo $all_data['CONTEST_FEATURED_PRICE'];?>" style="max-width:200px">
                  <?php echo form_error('constant[CONTEST_FEATURED_PRICE]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <td valign="top" width="25%"><b>Contest entry highlight price (<?php echo CURRENCY;?>) :</b></td>
                <td><input type="text" class="form-control" name="constant[CONTEST_ENTRY_HIGHLIGHT_PRICE]" size="9" value="<?php echo $all_data['CONTEST_ENTRY_HIGHLIGHT_PRICE'];?>" style="max-width:200px">
                  <?php echo form_error('constant[CONTEST_ENTRY_HIGHLIGHT_PRICE]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk" hidden>
                <td valign="top" width="25%"><b>Sealed contest price (<?php echo CURRENCY;?>) :</b></td>
                <td><input type="text" class="form-control"  name="constant[CONTEST_SEALED_PRICE]" size="9" value="<?php echo $all_data['CONTEST_SEALED_PRICE'];?>" style="max-width:200px">
                  <?php echo form_error('constant[CONTEST_SEALED_PRICE]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <tbody>
              <tr class="header_tr">
                <td height="25" colspan="2">&nbsp;Profile Featured </td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Price (monthly) :</b></td>
                <td><input type="text" class="form-control" name="constant[PROFILE_FEATURED_MONTHLY]" size="9" value="<?php echo $all_data['PROFILE_FEATURED_MONTHLY'];?>" style="max-width:200px">
                  <?php echo form_error('constant[PROFILE_FEATURED_MONTHLY]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
              <tr bgcolor="#ffffff" class="lnk">
                <td valign="top" width="25%"><b>Price (yearly) :</b></td>
                <td><input type="text" class="form-control" name="constant[PROFILE_FEATURED_YEARLY]" size="9" value="<?php echo $all_data['PROFILE_FEATURED_YEARLY'];?>" style="max-width:200px">
                  <?php echo form_error('constant[PROFILE_FEATURED_YEARLY]', '<label class="error" for="required">', '</label>'); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        &nbsp;
        <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn btn-secondary">Cancel</button>
        <!-- End .form-group  -->
        
      </form>
      
      <!-- End .panel-body --> 
      
    </div>
  </div>
  <!-- End .container-fluid  --> 
  
</div>
<!-- End .wrapper  -->

</section>
