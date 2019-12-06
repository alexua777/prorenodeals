<section id="content">

    <div class="wrapper">

        <div class="crumb">

            <ul class="breadcrumb">

                <li class="active"><a href="<?= base_url() ?>"><i class="icon16 i-home-4"></i>Home</a></li>

                <li class="active">Site Account modify</li>

            </ul>

        </div>



        <div class="container-fluid">

            <div id="heading" class="page-header">

                <h1><i class="icon20 i-list-4"></i> Site Settings Account Management</h1>

            </div>

            <?php

            if ($this->session->flashdata('succ_msg')) {

                ?>

                <div class="alert alert-success">

                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    <strong><i class="la la-check-circle la-2x"></i> Well done!</strong> <?= $this->session->flashdata('succ_msg') ?>

                </div> 

                <?php

            }

            if ($this->session->flashdata('error_msg')) {

                ?>

                <div class="alert alert-error">

                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    <strong><i class="icon24 i-close-4"></i> Oh snap!</strong> <?= $this->session->flashdata('error_msg') ?>

                </div>

                <?php

            }

            ?>

            <div class="row">

                <div class="col-lg-12">

				

				

				 

				 

				 

				 <table border="0" align="center" cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table"> 

		

		<tr bgcolor="">

		

    	<td height="20" align="center" >

    	<a href="<?= base_url() ?>settings/edit/1" class="lnk_white_m">Site Setting</a>

        </td>

		

		

    	<td align="center" >

        <a href="<?= base_url() ?>settings/account_edit/1" class="lnk">Account Setting</a>

        </td>

		

		

    	<td align="center" bgcolor="#666666">

        <a href="<?= base_url() ?>settings/transfer_edit/1" class="lnk">Transfer Setting</a>

        </td>

		

		

		<td height="20" width="25%" align="center">

		<a href="<?= base_url() ?>settings/maintenance_setting/1" class="lnk">Site Under Maintenance</a>

		</td>

        

		</tr>

</table>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 

                            <h4>TRANSFER SETTING</h4>

                            <a href="#" class="minimize2"></a>

                        </div><!-- End .panel-heading -->





                        <div class="panel-body">



                            <?php echo validation_errors('<div class=" red alert ">', '</div>'); ?>

                            <form id="validate" action="<?php echo base_url(); ?>settings/transfer_edit/1" class="form-horizontal"  role="form" name="settings" method="post">

								



                                <div class="form-group" style="padding:2%;">

								

								<table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor="">

    <tbody><tr class="lnk" bgcolor="#ffffff">

    	<td valign="top" width="25%"><b> Paypal Email Id :</b></td>

        <td>

     		<input type="text" name="paypal_mail" id="paypal_mail" size="45" value="<?php echo $all_data['paypal_mail'];?>">       <br><br />

    <span style="background-color:#CF0">Description: </span>The PayPal email address where users pay when depositting money (via paypal), and when the user clicks on the PayPal link, they will be taken to the referral signup referred by this email address (if you don\'t have a PayPal account, use the one shown in the example).<br>

    Example: youremail@youremail.com

    

     <?php echo form_error('paypal_mail', '<label class="error" for="required">', '</label>'); ?>

    	</td>

    </tr>

	<tr class="lnk" bgcolor="#ffffff">

    	<td valign="top" width="25%"><b> Paypal API user id :</b></td>

        <td>

     		<input type="text" name="paypal_api_uid" id="paypal_api_uid" size="45" value="<?php echo $all_data['paypal_api_uid']?>"> 

      <?php echo form_error('paypal_api_uid', '<label class="error" for="required">', '</label>'); ?>

    	</td>

    </tr>

	<tr class="lnk" bgcolor="#ffffff">

    	<td valign="top" width="25%"><b> Paypal API password :</b></td>

        <td>

     		<input type="text" name="paypal_api_pass" id="paypal_api_pass" size="45" value="<?php echo $all_data['paypal_api_pass']?>"> 

              <?php echo form_error('paypal_api_pass', '<label class="error" for="required">', '</label>'); ?>

    

    	</td>

    </tr>

	<tr class="lnk" bgcolor="#ffffff">

    	<td valign="top" width="25%"><b> Paypal API paypal_signature :</b></td>

        <td>

     		<input type="text" name="paypal_api_sig" id="paypal_api_sig" size="45" value="<?php echo $all_data['paypal_api_sig']?>">

              <?php echo form_error('paypal_api_sig', '<label class="error" for="required">', '</label>'); ?>

    	</td>

    </tr>

	

	    <tr class="lnk" bgcolor="#ffffff">

                        <td valign="top" width="25%"><b>Sandbox API user id :</b></td>

                        <td>

                            <input type="text" name="sandbox_api_uid" id="sandbox_api_uid" size="45" value="<?php echo $all_data['sandbox_api_uid']?>"> 

                              <?php echo form_error('sandbox_api_uid', '<label class="error" for="required">', '</label>'); ?>



                        </td>

                    </tr>

                    <tr class="lnk" bgcolor="#ffffff">

                        <td valign="top" width="25%"><b>Sandbox API password :</b></td>

                        <td>

                            <input type="text" name="sandbox_api_pass" id="sandbox_api_pass" size="45" value="<?php echo $all_data['sandbox_api_pass'];?>"> 

                              <?php echo form_error('sandbox_api_pass', '<label class="error" for="required">', '</label>'); ?>



                        </td>

                    </tr>

                    <tr class="lnk" bgcolor="#ffffff">

                        <td valign="top" width="25%"><b>Sandbox API paypal_signature :</b></td>

                        <td>

                            <input type="text" name="sandbox_api_sig" id="sandbox_api_sig" size="45" value="<?php echo $all_data['sandbox_api_sig'];?>">

                              <?php echo form_error('sandbox_api_sig', '<label class="error" for="required">', '</label>'); ?>

                        </td>

                    </tr>

                    <tr bgcolor="#ffffff" class="lnk">



                        <td valign="top" width="25%"><b> Paypal Environment :</b></td>



                        <td><div class="radio">

						<span class="checked">

						<input type="radio" name="paypal_mode" value="DEMO" class="lnk" <?php if($all_data['paypal_mode']=="DEMO") { echo "checked"; } ?>></span></div>

                            SandBox &nbsp;&nbsp;&nbsp;

                            <div class="radio"><span><input type="radio" name="paypal_mode" value="LIVE" class="lnk" <?php if($all_data['paypal_mode']=="LIVE") { echo "checked"; } ?>></span></div>Live 

						  <?php echo form_error('paypal_mode', '<label class="error" for="required">', '</label>'); ?>

                        </td>



                    </tr> 
<?php /*?>
	

   

    

    <tr bgcolor="#ffffff" class="lnk">

        <td valign="top" width="25%"><b> Deposit By Creditcard Fees - Paypal (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_creaditcard_fees" id="deposite_by_creaditcard_fees" value="<?php echo $all_data['deposite_by_creaditcard_fees'];?>" size="10">&nbsp;%

        <br><br />

        <span style="background-color:#CF0">Description: </span> Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.<br>

        </td>

    </tr>

	

   



   

    

    <tr bgcolor="#ffffff" class="lnk">

        <td valign="top" width="25%"><b> Deposit By Paypal Commission Amount (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_paypal_commission" id="deposite_by_paypal_commission" value="<?php echo $all_data['deposite_by_paypal_commission'];?>" size="10">&nbsp;%

        <br><br />

        <span style="background-color:#CF0">Description: </span> Provide commission % that will be charged for each deposit using paypal account.<br>

        </td>

    </tr>

    

    <tr bgcolor="#ffffff" class="lnk">

        <td valign="top" width="25%"><b> Deposit By Paypal Fees - Paypal (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="deposite_by_paypal_fees" id="deposite_by_paypal_fees" value="<?php echo $all_data['deposite_by_paypal_fees'];?>" size="10">&nbsp;%

        <br><br />

        <span style="background-color:#CF0">Description: </span> Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.<br>

        </td>

    </tr><?php */?>

    

    <tr bgcolor="#ffffff" class="lnk">

        <td valign="top" width="25%"><b> Payment Methods :</b></td>

        <td>

        <div class="checker">

		

		<input type="checkbox" name="withdrawl_method_paypal" value="Y" <?php if($all_data['withdrawl_method_paypal']=='Y'){?>checked="checked" <?php }?> >

	

		</div>&nbsp;Paypal

		

        <div class="checker">

		

		<input type="checkbox" name="withdrawl_method_wire_transfer" value="Y" <?php if($all_data['withdrawl_method_wire_transfer']=='Y'){?>checked="checked" <?php }?> >

		

		</div>

		&nbsp;Wire Transfer <br><br />

        <span style="background-color:#CF0">Description: </span> Please tick the checkboxes for withdrawal methods. Unchecked method will remain inactive in the frontend.<br>

        

        </td>

    </tr>



    <tr bgcolor="#ffffff" class="lnk">

        <td valign="top" width="25%"><b> Withdraw By Paypal Commission Amount (%) :</b></td>

        <td>

        <input type="text" class="lnk" name="withdrawl_commission_paypal" value="<?php echo $all_data['withdrawl_commission_paypal'];?>" size="10">

        <br><br />

        <span style="background-color:#CF0">Description: </span> Provide fixed amount (in USD) that will be charged as commission for each withdrawal using paypal account.<br>

          <?php echo form_error('withdrawl_commission_paypal', '<label class="error" for="required">', '</label>'); ?>

        </td>

    </tr>

    

    

    

    

     <tr bgcolor="#ffffff" class="lnk">



          <td valign="top" width="25%"><b> Withdraw By Wire Transfer Commission Amount (%) :</b></td>



          <td><input type="text" class="lnk" name="withdrawl_commission_wire_transfer" value="<?php echo $all_data['withdrawl_commission_wire_transfer'];?>" size="45">



                <br><br />



          <span style="background-color:#CF0">Description: </span> Provide fixed amount (in USD) that will be charged as commission for each withdrawal using wire_transfer.<br>



  <?php echo form_error('withdrawl_commission_wire_transfer', '<label class="error" for="required">', '</label>'); ?>

          </td>



        </tr>  

        

        <tr bgcolor="#ffffff" class="lnk">



          <td valign="top" width="25%"><b> Bank account no :</b></td>



          <td><input type="text" class="lnk" name="bank_ac" value="<?php echo $all_data['bank_ac'];?>" size="45">



                <br><br />



          <span style="background-color:#CF0">Description: </span> Provide your bank account no for fund deposite<br>



  <?php echo form_error('bank_ac', '<label class="error" for="required">', '</label>'); ?>

          </td>



        </tr>

        

        <tr bgcolor="#ffffff" class="lnk">



          <td valign="top" width="25%"><b> Bank account name :</b></td>



          <td><input type="text" class="lnk" name="bank_ac_name" value="<?php echo $all_data['bank_ac_name'];?>" size="45">



                <br><br />



          <span style="background-color:#CF0">Description: </span> Provide your bank account name for fund deposite<br>



  <?php /*echo form_error('bank_ac', '<label class="error" for="required">', '</label>');*/ ?>

          </td>



        </tr>

        

        <tr bgcolor="#ffffff" class="lnk">



          <td valign="top" width="25%"><b> Bank name :</b></td>



          <td><input type="text" class="lnk" name="bank_name" value="<?php echo $all_data['bank_name'];?>" size="45">



                <br><br />



          <span style="background-color:#CF0">Description: </span> Provide your bank name for fund deposit<br>



  <?php echo form_error('bank_name', '<label class="error" for="required">', '</label>'); ?>

          </td>



        </tr>

        

        <tr bgcolor="#ffffff" class="lnk">



          <td valign="top" width="25%"><b> Bank address :</b></td>



          <td><input type="text" class="lnk" name="bank_address" value="<?php echo $all_data['bank_address'];?>" size="45">



                <br><br />



          <span style="background-color:#CF0">Description: </span> Provide your bank address for fund deposit.<br>



  <?php echo form_error('bank_address', '<label class="error" for="required">', '</label>'); ?>

          </td>



        </tr>

    </tbody></table>

	</div>



                                

								 

                                <div class="form-group">

                                    <div class="col-lg-offset-2">

                                        <div class="pad-left15">

                                            <button type="submit" class="btn btn-primary">Save changes</button>

                                            <button type="button" onclick="redirect_to('<?php echo base_url() . 'settings/edit/1' ?>');" class="btn">Cancel</button>

                                        </div>

                                    </div>

                                </div><!-- End .form-group  -->



                            </form>

                        </div><!-- End .panel-body -->

                    </div><!-- End .widget -->

                </div><!-- End .col-lg-12  --> 

            </div><!-- End .row-fluid  -->



        </div> <!-- End .container-fluid  -->

    </div> <!-- End .wrapper  -->

</section>