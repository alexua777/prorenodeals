<section id="content">
  <div class="wrapper">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url()?>"><i class="la la-home"></i> Home</a></li>
        <li class="breadcrumb-item active"><a>Site Settings Account Management</a> </li>
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
      <ul class="nav nav-pills nav-fill mb-3">
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/edit/45">Site Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/account_edit/45">Account Setting</a> </li>
        <li class="nav-item"> <a class="nav-link active" href="<?= base_url() ?>settings/transfer_edit/45">Transfer Setting</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/maintenance_setting/45">Site Under Maintenance</a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?= base_url() ?>settings/email_setting/1">Email Setting</a> </li>
      </ul>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5><i class="la la-check-square"></i> TRANSFER SETTING</h5>
          <a href="#" class="minimize2"></a> </div>
        <!-- End .panel-heading -->
        
        <div class="panel-body"> <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>
          <form id="validate" action="<?php echo base_url(); ?>settings/transfer_edit/1" class="form-horizontal"  role="form" name="settings" method="post">
            <div class="form-group">
              <table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor="">
                <tbody>
                  <tr>
                    <td valign="top" width="25%"><b> Paypal Email Id :</b></td>
                    <td><input type="text" class="form-control" name="paypal_mail" id="paypal_mail" value="<?php echo $all_data['paypal_mail'];?>">
                      <p><b>Description: </b>The PayPal email address where users pay when depositting money (via paypal), and when the user clicks on the PayPal link, they will be taken to the referral signup referred by this email address (if you don\'t have a PayPal account, use the one shown in the example).</p>
                      <p><b>Example:</b> youremail@youremail.com</p>
                      <?php echo form_error('paypal_mail', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk">
                    <td valign="top" width="25%"><b> Paypal API user id :</b></td>
                    <td><input type="text" class="form-control" name="paypal_api_uid" id="paypal_api_uid" value="<?php echo $all_data['paypal_api_uid']?>">
                      <?php echo form_error('paypal_api_uid', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr>
                    <td valign="top" width="25%"><b> Paypal API password :</b></td>
                    <td><input type="text" class="form-control" name="paypal_api_pass" id="paypal_api_pass" value="<?php echo $all_data['paypal_api_pass']?>">
                      <?php echo form_error('paypal_api_pass', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr>
                    <td valign="top" width="25%"><b> Paypal API paypal_signature :</b></td>
                    <td><input type="text" class="form-control" name="paypal_api_sig" id="paypal_api_sig" value="<?php echo $all_data['paypal_api_sig']?>">
                      <?php echo form_error('paypal_api_sig', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr>
                    <td valign="top" width="25%"><b>Sandbox API user id :</b></td>
                    <td><input type="text" class="form-control" name="sandbox_api_uid" id="sandbox_api_uid" value="<?php echo $all_data['sandbox_api_uid']?>">
                      <?php echo form_error('sandbox_api_uid', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr>
                    <td valign="top" width="25%"><b>Sandbox API password :</b></td>
                    <td><input type="text" class="form-control" name="sandbox_api_pass" id="sandbox_api_pass" value="<?php echo $all_data['sandbox_api_pass'];?>">
                      <?php echo form_error('sandbox_api_pass', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr>
                    <td valign="top" width="25%"><b>Sandbox API paypal_signature :</b></td>
                    <td><input type="text" class="form-control" name="sandbox_api_sig" id="sandbox_api_sig" value="<?php echo $all_data['sandbox_api_sig'];?>">
                      <?php echo form_error('sandbox_api_sig', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk">
                    <td valign="top" width="25%"><b> Paypal Environment :</b></td>
                    <td><div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="customRadioInline1" name="paypal_mode" value="DEMO" <?php if($all_data['paypal_mode']=="DEMO") { echo "checked"; } ?>>
                        <label class="custom-control-label" for="customRadioInline1">SandBox</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="customRadioInline2" name="paypal_mode" value="LIVE" <?php if($all_data['paypal_mode']=="LIVE") { echo "checked"; } ?>>
                        <label class="custom-control-label" for="customRadioInline2">Live</label>
                      </div>
                      <p><?php echo form_error('paypal_mode', '<label class="error" for="required">', '</label>'); ?></p></td>
                  </tr>
                  <?php /*?><tr class="lnk">

        <td valign="top" width="25%"><b> Deposit By Creditcard Fees - Paypal (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_creaditcard_fees" id="deposite_by_creaditcard_fees" value="<?php echo $all_data['deposite_by_creaditcard_fees'];?>" size="10">&nbsp;%

        

        <span style="background-color:#CF0">Description: </span> Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.

        </td>

    </tr>
    

    <tr class="lnk">

        <td valign="top" width="25%"><b> Deposit By Paypal Commission Amount (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_paypal_commission" id="deposite_by_paypal_commission" value="<?php echo $all_data['deposite_by_paypal_commission'];?>" size="10">&nbsp;%

        

        <span style="background-color:#CF0">Description: </span> Provide commission % that will be charged for each deposit using paypal account.

        </td>

    </tr>

    

    <tr class="lnk">

        <td valign="top" width="25%"><b> Deposit By Paypal Fees - Paypal (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_paypal_fees" id="deposite_by_paypal_fees" value="<?php echo $all_data['deposite_by_paypal_fees'];?>" size="10">&nbsp;%

        

        <span style="background-color:#CF0">Description: </span> Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.

        </td>

    </tr><?php */?>
                  <tr hidden>
                    <td valign="top" width="25%"><b>Skrill Email :</b></td>
                    <td><input type="text" class="form-control" name="skrill_mail" id="skrill_mail" value="<?php echo $all_data['skrill_mail']?>">
                      <?php echo form_error('skrill_mail', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr hidden>
                    <td valign="top" width="25%"><b>Skrill Password :</b></td>
                    <td><input type="text" class="form-control" name="skrill_pass" id="skrill_pass" value="<?php echo $all_data['skrill_pass'];?>">
                      <?php echo form_error('skrill_pass', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr hidden>
                    <td valign="top" width="25%"><b>Skrill Fee (%) :</b></td>
                    <td><input type="text" class="form-control" name="deposite_by_skrill_fees" id="deposite_by_skrill_fees" value="<?php echo $all_data['deposite_by_skrill_fees'];?>">
                      <?php echo form_error('deposite_by_skrill_fees', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Payment Methods :</b></td>
                    <td><div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="check1" name="withdrawl_method_paypal" value="Y" <?php if($all_data['withdrawl_method_paypal']=='Y'){?>checked="checked" <?php }?>>
                        <label class="custom-control-label" for="check1">Paypal</label>
                      </div>
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="check2" name="method_skrill" value="Y" <?php if($all_data['method_skrill']=='Y'){?>checked="checked" <?php }?>>
                        <label class="custom-control-label" for="check2">Skrill</label>
                      </div>
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="check3" name="withdrawl_method_wire_transfer" value="Y" <?php if($all_data['withdrawl_method_wire_transfer']=='Y'){?>checked="checked" <?php }?>>
                        <label class="custom-control-label" for="check3">Wire Transfer </label>
                      </div>
                      <p><b>Description: </b> Please tick the checkboxes for withdrawal methods. Unchecked method will remain inactive in the frontend.</p></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Withdraw By Paypal Commission Amount (%) :</b></td>
                    <td><input type="text" class="form-control lnk" name="withdrawl_commission_paypal" value="<?php echo $all_data['withdrawl_commission_paypal'];?>" size="10">
                      <p><b>Description: </b>Provide fixed amount (in USD) that will be charged as commission for each withdrawal using paypal account.</p>
                      <?php echo form_error('withdrawl_commission_paypal', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
				   <tr class="lnk">

						<td valign="top" width="25%"><b> Paypal Fee percent (%) :</b></td>

						<td>

						<input type="text" class="form-control lnk" name="deposite_by_paypal_commission" id="deposite_by_paypal_commission" value="<?php echo $all_data['deposite_by_paypal_commission'];?>" size="10">
						
						<p><b>Description: </b> Provide paypal fee % that will be charged for each deposit using paypal account.</p>

						</td>

					</tr>
					
					 <tr class="lnk">

						<td valign="top" width="25%"><b> Paypal Fee Fixed :</b></td>

						<td>

						<input type="text" class="form-control lnk" name="constant[PAYPAL_FIXED_FEE]" id="PAYPAL_FIXED_FEE" value="<?php echo $all_data['PAYPAL_FIXED_FEE'];?>" size="10">
						
						<p><b>Description: </b>Provide stripe fixed fee that will be charged with percent (%)</p>

						</td>

					</tr>
					
					 <tr class="lnk">

						<td valign="top" width="25%"><b> Stripe Fee percent (%) :</b></td>

						<td>

						<input type="text" class="form-control lnk" name="constant[STRIP_FEE_PERCENT]" id="STRIP_FEE_PERCENT" value="<?php echo $all_data['STRIP_FEE_PERCENT'];?>" size="10">
						
						<p><b>Description: </b> Provide stripe fee % that will be charged for each deposit using stipe.</p>

						</td>

					</tr>
					
					<tr class="lnk">

						<td valign="top" width="25%"><b> Stripe Fee Fixed :</b></td>

						<td>

						<input type="text" class="form-control lnk" name="constant[STRIP_FEE_FIXED]" id="STRIP_FEE_FIXED" value="<?php echo $all_data['STRIP_FEE_FIXED'];?>" size="10">
						
						<p><b>Description: </b> Provide stripe fixed fee that will be charged with percent (%).</p>

						</td>

					</tr>
					
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Withdraw By Wire Transfer Commission Amount (%) :</b></td>
                    <td><input type="text" class="form-control lnk" name="withdrawl_commission_wire_transfer" value="<?php echo $all_data['withdrawl_commission_wire_transfer'];?>">
                      <p><b>Description: </b> Provide fixed amount (in USD) that will be charged as commission for each withdrawal using wire_transfer.</p>
                      <?php echo form_error('withdrawl_commission_wire_transfer', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Bank account no :</b></td>
                    <td><input type="text" class="form-control lnk" name="bank_ac" value="<?php echo $all_data['bank_ac'];?>">
                      <p><b>Description: </b> Provide your bank account no for fund deposite</p>
                      <?php echo form_error('bank_ac', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Bank account name :</b></td>
                    <td><input type="text" class="form-control lnk" name="bank_ac_name" value="<?php echo $all_data['bank_ac_name'];?>">
                      <p><b>Description: </b> Provide your bank account name for fund deposite</p>
                      <?php /*echo form_error('bank_ac', '<label class="error" for="required">', '</label>');*/ ?></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Bank name :</b></td>
                    <td><input type="text" class="form-control lnk" name="bank_name" value="<?php echo $all_data['bank_name'];?>">
                      <p><b>Description: </b> Provide your bank name for fund deposit</p>
                      <?php echo form_error('bank_name', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>
                  <tr class="lnk" hidden>
                    <td valign="top" width="25%"><b> Bank address :</b></td>
                    <td><input type="text" class="form-control lnk" name="bank_address" value="<?php echo $all_data['bank_address'];?>">
                      <p><b>Description: </b> Provide your bank address for fund deposit.</p>
                      <?php echo form_error('bank_address', '<label class="error" for="required">', '</label>'); ?></td>
                  </tr>				  				  <tr class="lnk">                    <td valign="top" width="25%"><b> Stripe Secret Key :</b></td>                    <td><input type="text" class="form-control lnk" name="constant[STRIPE_SECRET_KEY]" value="<?php echo $all_data['STRIPE_SECRET_KEY'];?>">                      <p><b>Description: </b> Provide your stripe secret Key of stripe payment gateway.</p>                      <?php echo form_error('constant[STRIPE_SECRET_KEY]', '<label class="error" for="required">', '</label>'); ?></td>                  </tr>				  				   <tr class="lnk">                    <td valign="top" width="25%"><b> Stripe Publishable Key :</b></td>                    <td><input type="text" class="form-control lnk" name="constant[STRIPE_PUBLISHABLE_KEY]" value="<?php echo $all_data['STRIPE_PUBLISHABLE_KEY'];?>">                      <p><b>Description: </b> Provide your stripe publishable Key of stripe payment gateway.</p>                      <?php echo form_error('constant[STRIPE_PUBLISHABLE_KEY]', '<label class="error" for="required">', '</label>'); ?></td>                  </tr>				  				  
                  <tr>
                    <td valign="top" width="25%">&nbsp;</td>
                    <td><button type="submit" class="btn btn-primary">Save</button>
                      &nbsp;
                      <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn btn-secondary">Cancel</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <!-- End .form-group  -->
            
          </form>
        </div>
        <!-- End .panel-body --> 
        
      </div>
    </div>
    <!-- End .container-fluid  --> 
    
  </div>
  <!-- End .wrapper  --> 
  
</section>
